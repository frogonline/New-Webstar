<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {

	public $uses = array();
	public $components = array();
	public $helpers = array();
	
	public function beforeFilter() 
	{
		parent::beforeFilter();
		
		if(isset($this->request->params['users'])){
			$this->Security->requireSecure();			
		}
		$this->Security->blackHoleCallback = 'blackhole';
	}
    
	public function blackhole($type) {
		// handle errors.
	}
	
	public function admin_login() {
		$this->layout = 'adminLogin';
		
		if($this->request->is('post')){	
			$this->User->set($this->request->data);
			if($this->User->validates()) 
			{	
				if($this->Auth->login()) {
					$this->loginUser = AuthComponent::user();
					return $this->redirect($this->Auth->redirect());
				} 
				else{
					$this->Session->setFlash('<p>Username or Password is incorrect</p>', 'default', array('class' => 'nNote nFailure hideit'));
				}
				
			}
	  	}
		
		if($this->Auth->login()){
			return $this->redirect($this->Auth->redirect());
		}
		
	}
	
	public function admin_logout() {	
		$this->Session->setFlash('<p><strong>Success:&nbsp;</strong>You have successfully logged out</p>', 'default', array('class' => 'nNote nSuccess hideit'));
		$this->redirect($this->Auth->logout());
	} 
	
	public function admin_dashboard() {
		$this->layout = 'adminInner';
		
	}
	
	
}
