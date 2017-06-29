<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
class PricingTablesController extends AppController {

	public $name = 'PricingTables';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('PricePlan','PlanFeature');
	public $paginate = array();
	
	public function beforeFilter() 
	{
		parent::beforeFilter();
		$this->Auth->allow();
		
		if(isset($this->request->params['users'])){
			$this->Security->requireSecure();			
		}
		$this->Security->blackHoleCallback = 'blackhole';
	}
    
	public function blackhole($type) {
		// handle errors.
	}
	
	public function admin_index($id=NULL)
	{
		$this->layout = 'adminInner';
		$this->loadModel('PricePlan');
		$this->loadModel('PlanFeature');
		$data = $this->request->data;
		if(empty($data['PricePlan']['searchvalue']))
		{
		if($this->request->is("post"))
		{
			if($id != ''){
				$this->PricePlan->id = $id;
			} else{
				$this->PricePlan->create();
				$data = $this->request->data;
				$data['PricePlan']['status']='Y';
			}
			
			$saveFlag = $this->PricePlan->save($data);
			if($saveFlag){
					if($id != ''){
						$this->Session->setFlash('<p>Price Plan updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
					} else{
						$this->Session->setFlash('<p>Price Plan added successfully!</p>', 'default', array('class' => 'alert alert-success'));
					}
				} else {
					$this->Session->setFlash('Failed to save the Price Plan', 'default', array('class' => 'alert alert-danger'));
				}
			
			
			$this->redirect($this->referer());
		}
		}
		else if(!empty($data['PricePlan']['searchvalue'])){
			if($this->request->is("post"))
			{
			$data = $this->request->data;
			$likekeyArr = array('plan_name');
			$likekeyArr1 = array('plan_price');
			$likekeyArr2 = array('status');
			$conditionArr = array();
			foreach($data['PricePlan'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['PricePlan.'.$k.' LIKE'] = '%'.$v.'%';
					} else if( in_array($k,$likekeyArr1) ) {
							$conditionArr['PricePlan.'.$k.' LIKE'] = '%'.$v.'%';
					} else if( in_array($k,$likekeyArr2) ) {
							$conditionArr['PricePlan.'.$k.' LIKE'] = '%'.$v.'%';
					}
				}
			}
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('PricePlan.id' => 'DESC')
			);
			$this->set('searchData',$data);
			}
		}else
		{
			$this->paginate=array(
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('PricePlan.id' => 'DESC')
				);
		}
		$total = $this->PricePlan->find('count');
		
		$data=$this->paginate('PricePlan');
		$this->set('data', $data);
		$this->set('total', $total);
		
	}
	
	public function admin_manage($id=NULL)
	{
		$this->layout = 'adminInner';
		
		if($this->request->is('post')){
			$savedata = $this->request->data;
			if(!empty($id))
			{
				$this->PlanFeature->id=$id;
			
			}
			else{
			$this->PlanFeature->create();
			}
			$saveFlag = $this->PlanFeature->save($savedata);
			if($saveFlag){
					if($id != ''){
						$this->Session->setFlash('Plan feature updated successfully.', 'default', array('class' => 'alert alert-success'));
						$this->redirect(array('controller'=>'PricingTables', 'action'=>'admin_manage/'.$savedata['PlanFeature']['plan_id']));
					} else{
						$this->Session->setFlash('Plan feature added successfully', 'default', array('class' => 'alert alert-success'));
						$this->redirect(array('controller'=>'PricingTables', 'action'=>'admin_manage/'.$id));
					}
				} else {
					$this->Session->setFlash('Failed to save the Plan feature', 'default', array('class' => 'alert alert-danger'));
				}
			
		}
		
		if(!empty($id)){
			$data = $this->PlanFeature->find('all', array(
					'conditions'=>array('PlanFeature.plan_id'=>$id),
					'order'=>array('PlanFeature.sort_order ASC')
				)
			);
			$this->set(compact('data'));
		}
		
		$this->set(compact('id'));
	}
	
	public function admin_status($id=NULL, $status =NULL)
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['PricePlan']['status'] = $status;
		
		$this->PricePlan->id = $id;
		$updateFlag = $this->PricePlan->save($data);
		
		if($updateFlag){
			$this->Session->setFlash('Price Plan status changed successfully!', 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('Failed to changed status!', 'default', array('class' => 'alert alert-danger'));
		}
		$this->redirect($this->referer());
	}
	public function admin_delete($id=NULL)
	{	
		$this->layout = '';
		$this->loadModel('PricePlan');
		$this->loadModel('PlanFeature');
		$this->autoRender = false;
		$this->PricePlan->delete($id);
		$this->PlanFeature->deleteAll(array('PlanFeature.plan_id' => $id), false);
		$this->Session->setFlash('<p>Price Plan details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_deleteAll($idAll=NULL)
	{	
		//pr($id); exit();
		$this->loadModel('PricePlan');
		$this->loadModel('PlanFeature');
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$deleteFlag = $this->PricePlan->delete($id);
			$this->PlanFeature->deleteAll(array('PlanFeature.plan_id' => $id), false);
			if($deleteFlag){
				$this->Session->setFlash('All Price Plan Details removed successfully !', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete Price Plan Details', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	public function admin_edit(){
		$this->layout = 'ajax';
		$this->set('id', $this->request->data['id']);
		$this->loadModel('PricePlan');
		if($this->request->data['id'] != ''){			
			$data = $this->PricePlan->findById($this->request->data['id']);
			$this->set('data',$data);
		}
	}
	public function admin_editfeature(){
		$this->layout = 'ajax';
		$this->set('id', $this->request->data['id']);
		$this->set('plan_id', $this->request->data['plan_id']);
		$this->loadModel('PlanFeature');
		if($this->request->data['id'] != ''){			
			$data = $this->PlanFeature->findById($this->request->data['id']);
			$this->set('data',$data);
		}
	}
	public function admin_managefeature(){
		$this->layout = 'ajax';
		$this->set('plan_id', $this->request->data['id']);
		$this->loadModel('PricePlan');
		$this->loadModel('PlanFeature');
		if($this->request->data['id'] != ''){			
			$data = $this->PlanFeature->find('all',array('conditions'=>array('PlanFeature.plan_id'=>$this->request->data['id'])));
			$this->set('data',$data);
			
		}
	}
	
	public function admin_sortitem(){
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$data = $this->request->data;
			$sitems=json_decode($data['sstring']);
			//pr($mitems);
			
			$flag=$this->item_update($sitems);
			if($flag){
				echo 1;
			}
			else{
				echo "Try Later";
			}
			
			exit();
		}
		
	}
	
	private function item_update($sitems){
		$c=1;
		foreach($sitems as $sitem){
			$val['PlanFeature']['sort_order']=$c;
			$this->PlanFeature->id=$sitem->id;
			$flag = $this->PlanFeature->save($val);
			$c++;
		}
		
		return $flag;
	}
	
	public function admin_itemdelete($itemid=NULL, $id=NULL){
		$this->layout = '';
		$this->autoRender = false;
		
		if( (!empty($itemid)) && (!empty($id))){
			$dltFlag=$this->PlanFeature->delete($itemid);
			if($dltFlag){
				$this->Session->setFlash('Plan feature deleted successfully', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete plan feature', 'default', array('class' => 'alert alert-danger'));
			}
			$this->redirect(array('controller'=>'PricingTables', 'action'=>'admin_manage/'.$id));
		} else {
			$this->Session->setFlash('Failed to delete plan feature', 'default', array('class' => 'alert alert-danger'));
			$this->redirect(array('controller'=>'PricingTables', 'action'=>'admin_index'));
		}	
		
	}
}