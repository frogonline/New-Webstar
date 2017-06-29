<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class ShippingsController extends AppController {

	public $name = 'Shippings';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('Shipping');
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
			
			$likekeyArr = array('shipping_type');
			$codekeyArr = array('shipping_rate');
			$conditionArr = array();
			foreach($data['Shipping'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['Shipping.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
						if(in_array($k,$codekeyArr)){
							$conditionArr['Shipping.'.$k.' LIKE'] = '%'.$v.'%';
						} else {
							$conditionArr['Shipping.'.$k] = $v; 
						}
					}
				}
			}
			$conditionArr['Shipping.isdel'] = 0; 
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Shipping.id' => 'DESC')
			);
			$this->set('searchData',$data);
		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('Shipping.isdel'=>'0'),
					'order'=>array('Shipping.id' => 'DESC')
					);
			
		}
		$data=$this->paginate('Shipping');
		$this->set('data', $data);
		
		
	}
	
	public function admin_manage($id=NULL){
		$this->layout = 'adminInner';
		if($this->request->is('post')){	
			
			if($this->Shipping->validates()){
				$data = $this->request->data;
				if($id != ''){
					
					$this->Shipping->id = $id;
				} else{
					
					$this->Shipping->create();
				}
				
				$saveFlag = $this->Shipping->save($data);
				$saveId = $this->Shipping->id;
				if($saveFlag){
					if($id != ''){
						$this->Session->setFlash('Shipping updated successfully.', 'default', array('class' => 'alert alert-success'));
					} else{
						$this->Session->setFlash('Shipping added successfully', 'default', array('class' => 'alert alert-success'));
					}
				} else {
					$this->Session->setFlash('Failed to save the Shipping', 'default', array('class' => 'alert alert-danger'));
				}
				if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'Shippings','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'Shippings','action'=>'admin_index'));
				}
				//$this->redirect(array('controller'=>'Countries','action'=>'admin_index'));
			} 
		}
	
		
	$this->set('id', $id);
		if($id !== NULL || $id !== ''){
			$data = $this->Shipping->findById($id);
			$this->set('data',$data);
		}
		if(!$id)
		{
			$data	=	$this->request->data;
			$this->set('data',$data);
		}
	}
	
	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Shipping']['isdel'] = $isdel; 
		$this-> Shipping->id = $id;
		$this-> Shipping->save($data);
		$this->Session->setFlash('<p>Shipping details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
			
	}
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Shipping']['status'] = $stat;
		$this->Shipping->id = $id;
		$this->Shipping->save($data);
		$this->Session->setFlash('<p>Shipping updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());
		exit();
		
	}
	
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->Shipping->findById($id);
			
			
			$data['Shipping']['isdel'] = $stat;
			$this->Shipping->id = $id;
			$deleteFlag = $this->Shipping->save($data);
			if($deleteFlag){
				$this->Session->setFlash('<p>Shipping removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Shipping removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
		
	}
	

}
?>