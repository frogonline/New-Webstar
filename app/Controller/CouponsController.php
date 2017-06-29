<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class CouponsController extends AppController 
{
	public $name = 'Coupons';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('Coupons');
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
	
	public function admin_index()
	{
		$this->layout = 'adminInner';
		
		
		if($this->request->is("post"))
		{
			$data = $this->request->data;
			$likekeyArr = array('code');
			$conditionArr = array('Coupons.isdel'=>'0');
			foreach($data['Coupons'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr)){
						$conditionArr['Coupons.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
							$conditionArr['Coupons.'.$k] = $v; 
						}
					}
				}
		
			
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Coupons.id' => 'DESC')
			);
			$this->set('searchData',$data);

		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('Coupons.isdel'=>'0'),
					'order'=>array('Coupons.id' => 'DESC')
					);
			
		}
		$data=$this->paginate('Coupons');
		$this->set('data', $data);
		
	}

	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Coupons']['isdel'] = $isdel; 
		$this-> Coupons->id = $id;
		$this-> Coupons->save($data);
		$this->Session->setFlash('<p> Coupon details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}



public function admin_manage($id=NULL){	
		$this->layout = 'adminInner';
		
		if($this->request->is('post')){	
			
			if($this->Coupons->validates()){
				$data = $this->request->data;
				if($id != ''){
					
					$this->Coupons->id = $id;
				} else{
			
					$this->Coupons->create();
				}
				
				if($this->request->data['Coupons']['available_from']!=='')
				{
				$date=$this->request->data['Coupons']['available_from'];
			
				$this->request->data['Coupons']['available_from'] =date('Y-m-d', strtotime(str_replace('.', '/', $date)));
				
				}
				if($this->request->data['Coupons']['available_to']!=='')
				{
				
			  $date=$this->request->data['Coupons']['available_to'];
			
				$this->request->data['Coupons']['available_to'] =date('Y-m-d', strtotime(str_replace('.', '/', $date)));
			
				}
				
			
				$saveFlag = $this->Coupons->save($this->request->data);
				$saveId = $this->Coupons->id;

				if($saveFlag){
					if($id != ''){
						$this->Session->setFlash('Coupon updated successfully.', 'default', array('class' => 'alert alert-success'));
					} else{
						$this->Session->setFlash('Coupon added successfully', 'default', array('class' => 'alert alert-success'));
					}
				} else {
					$this->Session->setFlash('Failed to save the Coupon', 'default', array('class' => 'alert alert-danger'));
				}
				//$this->redirect(array('controller'=>'Coupons','action'=>'admin_index'));
			
			if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'Coupons','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'Coupons','action'=>'admin_index'));
				}
			} 
		}
		$this->set('id', $id);
		if(trim($id) !== ''){
			$data = $this->Coupons->findById($id);
			$this->set('data', $data);
		}
	}
	
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		//pr($id); exit();
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->Coupons->findById($id);
			
			$data['Coupons']['isdel'] = $stat;
			$this->Coupons->id = $id;
			$deleteFlag = $this->Coupons->save($data);
			//$deleteFlag = $this->News->delete($id);
			if($deleteFlag){
				$this->Session->setFlash('<p>Coupon removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Coupon removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Coupons']['status'] = $stat;
		
		$this->Coupons->id = $id;
		$this->Coupons->save($data);
		$this->Session->setFlash('<p>Coupon updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
}
?>