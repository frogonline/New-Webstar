<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class StatesController extends AppController 
{
	public $name = 'States';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('States','Countries');
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
			$this->States->bindModel(
				array(
					'belongsTo' => array(
						'Countries' => array(
								'className'    => 'Countries',
								'foreignKey'   => 'CountryID',
								'fields'=>'Country'
							)
					)
				)
			);	
		$model = ClassRegistry::init('Countries');
		$emp = $model->find('list',
			array(
				'fields'=>'Countries.id, Countries.Country'
			));		
			
			if($this->request->is("post"))
			{
			$data = $this->request->data;
			
			$likekeyArr = array('State');
			$conditionArr = array();
			foreach($data['States'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['States.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
							$conditionArr['States.'.$k] = $v; 
					}
				}
			}
			$conditionArr['States.isdel'] = 0;
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('States.id' => 'DESC')
			);
			$this->set('searchData',$data);
		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('States.isdel'=>'0'),
					'order'=>array('States.id' => 'DESC')
					);
			
			}
			
			$data = $this->paginate('States'); 
			$this->set(compact('data', 'emp')); 
	}
	
	public function admin_manage($id=NULL){	
		$this->layout = 'adminInner';
		
		if($this->request->is('post')){	
			
			if($this->States->validates()){
				$data = $this->request->data;
				if($id != ''){
					
					$this->States->id = $id;
				} else{
			
					$this->States->create();
				}
				
				
				
				$saveFlag = $this->States->save($data);
				$saveId = $this->States->id;
				if($saveFlag){
					if($id != ''){
						$this->Session->setFlash('State updated successfully.', 'default', array('class' => 'alert alert-success'));
					} else{
						$this->Session->setFlash('State added successfully', 'default', array('class' => 'alert alert-success'));
					}
				} else {
					$this->Session->setFlash('Failed to save the State', 'default', array('class' => 'alert alert-danger'));
				}
				if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'States','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'States','action'=>'admin_index'));
				}
				//$this->redirect(array('controller'=>'States','action'=>'admin_index'));
			} 
		}
		
		//Set Data For Editadmin_delete
		
		
		$Countries=$this->Countries->find('list', array(
			'fields'=>array('Countries.id', 'Countries.Country'),
			'conditions'=>array('Countries.isdel'=>'0') ) );
		
		if(trim($id) !== ''){
			$data = $this->States->findById($id);
			$this->set('data', $data);
		}
		
		$this->set(compact('Countries','id'));
		
	}
	
	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['States']['isdel'] = $isdel; 
		$this-> States->id = $id;
		$this-> States->save($data);
		$this->Session->setFlash('<p>State details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
		
	
	}
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['States']['status'] = $stat;
		
		$this->States->id = $id;
		$this->States->save($data);
		$this->Session->setFlash('<p>State updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->States->findById($id);
			
			$data['States']['isdel'] = $stat;
			$this->States->id = $id;
			$deleteFlag = $this->States->save($data);
			if($deleteFlag){
				$this->Session->setFlash('<p>State removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>State removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	
	

	
}
?>