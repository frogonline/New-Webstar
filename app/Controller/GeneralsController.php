<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
class GeneralsController extends AppController {
	public $uses = array('User');
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	
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
	
	public function admin_gadashboard()
	{
		$this->layout = 'adminInner';
	}
	
	public function admin_dashboard() {
		$this->layout = 'adminInner';
		$this->loadModel('Member');
		$this->loadModel('Subscriber');
		$this->loadModel('PostComment');
		$this->loadModel('Order');
		$memcount = $this->Member->find('count', array(
												'conditions' => array('Member.isdel' => '0')
											));
		$members = $this->Member->find('all', array(
									'conditions' => array('Member.isdel'=>'0'),
									'limit' => PAGINATION_PER_PAGE_LIMIT,
									'order'=>array('Member.id' => 'DESC')
									));
		
		$subscribercount = $this->Subscriber->find('count', array(
										'conditions' => array('Subscriber.is_del' => '0')
									));
		$subscribers = $this->Subscriber->find('all', array(
									'conditions' => array('Subscriber.is_del'=>'0'),
									'limit' => PAGINATION_PER_PAGE_LIMIT,
									'order'=>array('Subscriber.id' => 'DESC')
									));
		/* pr($subscribers);
		exit;	 */	
		$postCommentcount = $this->PostComment->find('count');
		$postComments = $this->PostComment->find('all', array(
									'limit' => PAGINATION_PER_PAGE_LIMIT,
									'order'=>array('PostComment.id' => 'DESC')
									));
									
		$ordercount = $this->Order->find('count',array(
											'conditions' => array('Order.isdel'=>'0')
										));
		
		$order = $this->Order->find('all', array(
									'conditions' => array('Order.isdel'=>'0'),
									'limit' => 10,
									'order'=>array('Order.id' => 'DESC')
									));
	
		$this->set(compact('members','memcount','subscribercount','subscribers','postCommentcount','postComments','order','ordercount'));
	}
	
		
	public function admin_login() {

		$this->layout = 'adminLogin';
	    
		  /* echo  $newpass = AuthComponent::password('admin');
		 exit;  */
		if($this->request->is('post')){	
		
			$this->User->set($this->request->data);
			
			if($this->User->validates()) 
			{	
				if($this->Auth->login()) {
				
					$user_name=$this->request->data['User']['username'];
					$user_nameArr = $this->User->findByusername($user_name);
					$this->loadModel('UserPermission');
					$this->loadModel('Menu');
					$this->Menu->bindModel(array(
									'hasOne' => array(
										'UserPermission' => array(
												'className'    => 'UserPermission',
												'foreignKey'   => 'module_id',
                                                'conditions'   => array('UserPermission.user_id'=>$user_nameArr['User']['user_id'])											
											),
										
										
									)
								));
			
			        $permissionArr = $this->Menu->find('all',
						array(
							'conditions'=>array(
								'Menu.controller !='=>''
							),
							'fields'=>array('Menu.id','Menu.controller','Menu.action','UserPermission.*')
						)
					);
					//pr($permissionArr);
					
					$generateArr = $this->permissioArray($permissionArr); //pr($permissionArr); exit();
					$this->Session->write('admintype', $user_nameArr['User']['user_type']);		$this->Session->write('special_type', $user_nameArr['User']['special_type']);
					$this->Session->write('permissionArr', $generateArr);
					//pr($this->Session->read('admintype'));
					//pr($this->Session->read('permissionArr'));
					//exit;
					$this->loginUser = AuthComponent::user();
					return $this->redirect($this->Auth->redirect());
				} 
				else{
					$this->Session->setFlash('<p>Username or Password is incorrect</p>', 'default', array('class' => 'alert alert-danger'));
				}
				
			}
	  	}
		
		if($this->Auth->login()){
			return $this->redirect($this->Auth->redirect());
		}
		
	}
	
	private function permissioArray($rawArr)
	{
		$generateArr = array();
		if(!empty($rawArr)){
			foreach($rawArr as $module){
				
				$generateArr[$module['Menu']['controller']][$module['Menu']['action']] = $module['UserPermission'];
				
			}
		}
		return $generateArr;
	}
	
	public function admin_forget()
	{	
		$this->layout = '';
		$this->autoRender = false;
		$this->loadModel('SiteSetting');
		$siteSetting=$this->SiteSetting->find('first');
		
		
		$email_id = $this->request->data['email_id'];
		$email_count = $this->User->findByEmailId($email_id);
	
		if(!empty($email_count))
		{
			
			$username=$email_count['User']['firstname'];
			$this->User->id = $email_count['User']['user_id'];
			$user_recover = AppController::generate_random_value(16);
			$save['User']['user_recoverycode']=$user_recover ;
			$this->User->save($save);
			
			$body="<body>
			Hi <strong>".$username."</strong><br/></br><br/></br>
			Click the link below to reset you account password:<br/></br>
			".SITE_URL."admin/generals/recovery/".$user_recover."<br/>
			If you have any questions,please contact us at <strong>".$siteSetting['SiteSetting']['cc_email']."</strong><br/></br><br/></br>
			Thank you <br/>
			".$siteSetting['SiteSetting']['meta_title']."
			</body>";
			
			$Email = new CakeEmail();
				
			$flag = $Email->emailFormat('html')
					->from(array($siteSetting['SiteSetting']['admin_email'] =>$siteSetting['SiteSetting']['meta_title']))
					->to($email_id)
					->subject('Password Recovery Link')
					->send($body);
			echo ($flag)?1:0; exit();
		}
		else
		{
			echo '0';
			exit();
		}
	}
	
	public function admin_recovery($id=NULL)
	{
		$this->layout = 'adminLogin';
		$this->set('data', $id);
	}
	
	public function admin_reset()
	{
		$this->layout = '';
		$this->autoRender = false;
		$code = $this->request->data['code'];
		$password = $this->request->data['password'];
		
		if($code!='')
		{
			$code_count = $this->User->findByUserRecoverycode($code);
			if(!empty($code_count))
			{
				$hashpass = AuthComponent::password($password);
				$this->User->id = $code_count['User']['user_id'];
				$save['User']['password']=$hashpass ;
				$this->User->save($save);
			}
			echo '1';
		}
		else
		{
			echo '0';
		}
		
	}
	
	public function admin_logout() {
		$this->Session->delete('permissionArr');
		$this->Session->delete('currentModelPer');
		$this->Session->setFlash('<p>You have successfully logged out</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->Auth->logout());
	}
	/* public function lists()
	{
		$this->autoRender = false;
		$data = $this->request->data;
		if($data['search']['search-type-value']=='Products')
		{
			$this->redirect(SITE_URL.'Products/lists/'.$data['search']['searching-value']);
			
		}
		if($data['search']['search-type-value']=='Pages')
		{
			$this->redirect(SITE_URL.'Pages/lists/'.$data['search']['searching-value']);
			
		}
		if($data['search']['search-type-value']=='Posts')
		{
			$this->redirect(SITE_URL.'Posts/lists/'.$data['search']['searching-value']);
			
		}
	} */
	
}
?>