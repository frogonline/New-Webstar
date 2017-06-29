<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
class UsersController extends AppController {

	public $uses = array('User');
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	
	public function beforeFilter() 
	{
		parent::beforeFilter();
		
		$this->Auth->allow('admin_forget','admin_recovery','admin_reset');
		if(isset($this->request->params['users'])){
			$this->Security->requireSecure();			
		}
		$this->Security->blackHoleCallback = 'blackhole';
	}
    
	public function blackhole($type) {
		// handle errors.
	}
	
	
	public function admin_index() {
		$this->layout = 'adminInner';
		//echo 'hello';die();
		if($this->request->is("post"))
		{
			$data = $this->request->data;
			$likekeyArr = array('name');
			$likekeyArr = array('username');
			$likekeyArr = array('email_id');
			
			//$datekeyArr = array('test_date');
			$conditionArr = array('User.isdel'=>'0');
			foreach($data['User'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr)){
						$conditionArr['User.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
							$conditionArr['User.'.$k] = $v; 
						}
					}
				}
		
			
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('User.id' => 'DESC')
			);
			$this->set('searchData',$data);

		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('User.isdel'=>'0'),
					'order'=>array('User.user_id' => 'DESC')
					);
			
		}
		$data=$this->paginate('User');
		//print_r($data);die();
		$this->set('data', $data);
	} 
	
	public function admin_manage($user_id=NULL) {
		$this->layout = 'adminInner';
		
		//Set Data For Edit
		$this->set('user_id', $user_id);

		if($user_id != NULL || $user_id != '')
		{
			$this->loadModel('UserPermission');
			
			$data = $this->User->findByuser_id($user_id);
			$this->set('data', $data);
		}
		
		if(!$user_id)
		{
			$data	=	$this->request->data;
			$this->set('data',$data);
		}
		$this->loadModel('Menu');
		
	}
	
	public function admin_ajaxusermanage($id = NULL){
		$this->layout = 'ajax';
		if($this->request->is('post'))
		{
			$data = $this->request->data;
			
			if($this->User->validates()){
				
				if(!empty($id))
				{
					$data['User']['update_date'] = date("Y-m-d");
					$this->User->id = $id;
				} else{
					
					$data['User']['insert_date'] = date("Y-m-d");
					$this->User->create();
				}
				
				$newArr = $this->request->data['New'];
				if(!empty($newArr['password']))
				{
					$data['User']['password'] = AuthComponent::password($newArr['password']);
				}
				
				$this->User->save($data);
				$userid=$this->User->id;
				
				if(!empty($userid))
				{
					$datasave=array();
					$this->loadModel('UserPermission');
										
					foreach($data['UserPermission'] as $k=>$v)
					{
						if(empty($v['id']))
						{
							$this->UserPermission->create();
						} else {
							$this->UserPermission->id=$v['id'];
						}
						
						$datasave['UserPermission']['user_id']=$userid;
						$datasave['UserPermission']['module_id']=$v['module_id'];
						$datasave['UserPermission']['view']=$v['view'];
						$datasave['UserPermission']['add']=array_key_exists('add', $v)?$v['add']:'N';
						$datasave['UserPermission']['edit']=array_key_exists('edit', $v)?$v['edit']:'N';
						$datasave['UserPermission']['delete']=array_key_exists('delete', $v)?$v['delete']:'N';
						$this->UserPermission->save($datasave);
					}
					
					
					$this->Session->setFlash('User saved successfully', 'default', array('class' => 'alert alert-success'));
					
					echo $userid; exit();
				
				} else {
					echo 0; exit();
				}
			} else {
				echo 0; exit();
			}
		} else {
			echo 0; exit();
		}
	}
	
	public function admin_usernamechk(){
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$data = $this->request->data;
			if(!empty($data)){
				$count = $this->User->find('count', array(
						'conditions'=>array(
							'User.username'=>$data['username']
						)
					)
				);
				echo $count; exit();
			}
		}
	}
	
	public function admin_emailchk(){
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$data = $this->request->data;
			if(!empty($data)){
				$count = $this->User->find('count', array(
						'conditions'=>array(
							'User.email_id'=>$data['email']
						)
					)
				);
				echo $count; exit();
			}
		}
	}
	
	public function admin_status($user_id=NULL, $stat = 'REJECT')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['User']['status'] = $stat;
		
		$this->User->id = $user_id;
		$updateFlag = $this->User->save($data);
		
		if($updateFlag){
			$this->Session->setFlash('User status changed successfully!', 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('Failed to changed status!', 'default', array('class' => 'alert alert-danger'));
		}
		$this->redirect($this->referer());
	}
	
	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$f_subs = $this->User->findByuser_id($id);
		$data['User']['isdel'] = $isdel; 
		$this->User->id = $id;
		$this->User->email_id = $f_subs['User']['email_id'];
		$this->User->save($data);
		$this->loadModel('UserPermission');
		$this->UserPermission->deleteAll(array('UserPermission.user_id'=>$id));
		$this->Session->setFlash('<p>Admin User details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_deleteAll($idAll=NULL, $isdel='0')
	{	
		//pr($id); exit();
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			
			$data['User']['isdel'] = $isdel; 
			$this->User->id = $id;
			$deleteFlag = $this->User->save($data);
			$this->loadModel('UserPermission');
			$this->UserPermission->deleteAll(array('UserPermission.user_id'=>$id));
			if($deleteFlag){
				$this->Session->setFlash('The Admin User has been successfully removed!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete the Admin User!', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
}