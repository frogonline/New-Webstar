<?php
App::uses('AppController', 'Controller');

class MembersController extends AppController {

	public $name = 'Members';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('OtherUser');
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
			/* $data = $this->request->data;
			$conditionArr = array();
			foreach($data['Post'] as $k => $v){
				if( ($v != NULL) ){
					if( ($k == 'vip') ){
						$conditionArr['Post.'.$k] = $v; 
					} else {
						
						$conditionArr['Post.'.$k.' LIKE'] = '%'.$v.'%';
					}
				}
			}
			$conditionArr['Post.user_type'] = 'B';*/

		} else {
			$this->paginate=array(
					'limit' => 10,
					'conditions'=>array('OtherUser.status'=>'Y','isdel'=>0),
					'order'=>array('OtherUser.id' => 'DESC')
					);
			
		}
		$data=$this->paginate('OtherUser');
		$this->set('data', $data);
	}
	
	public function admin_manage($id=NULL){	
		$this->layout = 'adminInner';
		
		if($this->request->is('post')){	
			
			if($this->OtherUser->validates()){
				$data = $this->request->data;
				if($id !== ''){
					$data['OtherUser']['date_modified'] = date("Y-m-d");
					$this->OtherUser->id = $id;
				} else{
					
					$this->request->data['OtherUser']['date_created'] = date("Y-m-d");
					$this->OtherUser->create();
				}
				
				$newArr = $this->request->data['New'];
						if(($newArr['password'] !== ''))
						{
							
							$this->request->data['OtherUser']['password'] = AuthComponent::password($newArr['password']);
						}
				$this->OtherUser->save($this->request->data);
				
				if($this->OtherUser->id == $id)
				{
					$this->Session->setFlash('<p><strong>Success:&nbsp;</strong>User details has been updated successfully!</p>', 'default', array('class' => 'nNote nSuccess hideit'));
				} 
				else
				{
					$this->Session->setFlash('<p><strong>Success:&nbsp;</strong>User details has been added successfully!</p>', 'default', array('class' => 'nNote nSuccess hideit'));
				}
				$this->redirect(array('controller'=>'OtherUsers','action'=>'admin_index'));
				
			} 
		}
		$this->set('id',$id);
		//Set Data For Edit
		if($id !== NULL || $id !== '')
		{
			$data = $this->OtherUser->findById($id);
			$this->set('data', $data);
		}
		
	}
	
	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['OtherUser']['isdel'] = $isdel; 
		$this->OtherUser->id = $id;
		$this->OtherUser->save($data);
		$this->Session->setFlash('<p><strong>Success:&nbsp;</strong> User details has been deleted successfully!</p>', 'default', array('class' => 'nNote nSuccess hideit'));
		$this->redirect($this->referer());	
	}
	}
	?>