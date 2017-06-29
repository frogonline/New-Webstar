<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');

class MembersController extends AppController {

	public $name = 'Members';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('Member', 'Country', 'State', 'City', 'Wishlist');
	public $paginate = array();

	public function beforeFilter() 
	{
		parent::beforeFilter();
		
		$this->Auth->allow('login', 'ajaxlogin', 'register', 'ajaxregister', 'ajaxstate', 'ajaxcity', 'ajaxcheckemail', 'success', 'myaccount', 'myorders', 'wishlist', 'ajaxpersonalinfo', 'ajaxpinfosubmit', 'ajaxaddressinfo', 'ajaxmystate', 'ajaxmycity', 'ajaxainfosubmit', 'activate', 'forgotpassword','recovery','reset_password','logout','admin_getListMembers');
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
			$likekeyArr = array('name');
			$likekeyArr = array('username');
			$likekeyArr = array('email_id');
			$conditionArr = array('Member.isdel'=>'0');
			foreach($data['Member'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr)){
						$conditionArr['Member.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
							$conditionArr['Member.'.$k] = $v; 
						}
					}
				}
			
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Member.id' => 'DESC')
			);
			$this->set('searchData',$data);

		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('Member.isdel'=>'0'),
					'order'=>array('Member.id' => 'DESC')
					);
			
		}
		$data=$this->paginate('Member');
		$this->set('data', $data);
	}
	
	public function admin_manage($id=NULL)
	{	
		$this->layout = 'adminInner';
		
		if ($this->request->is('post')) 
		{		
			$this->Member->set($this->request->data);
			if($this->Member->validates()) 
			{
				$data = $this->request->data;
				if(!empty($id)){
					$this->Member->id = $id;
				} else{
					$this->Member->create();
				}		
				$newArr = $data['New'];
				//pr($newArr['password']); exit;
				if($newArr['password']!=='')
				{
					$data['Member']['password'] = AuthComponent::password($newArr['password']);
				}
				//pr($data); exit();
				$this->Member->save($data);
				$saveId = $this->Member->id;
				if(!empty($id)){
					$this->Session->setFlash('<p>Member details updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
				} else {
					$this->Session->setFlash('<p>Member details added successfully!</p>', 'default', array('class' => 'alert alert-success'));
				}
				
				if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'Members','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'Members','action'=>'admin_index'));
				}
				//$this->redirect('/admin/Members/index');
			} 
		}
		
		$this->set('id', $id);
		if($id !== NULL || $id !== ''){
			$data = $this->Member->findById($id);
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
		$f_subs = $this->Member->findById($id);
		$data['Member']['isdel'] = $isdel; 
		$this->Member->id = $id;
		$this->Member->subscriber_email = $f_subs['Member']['email_id'];
		$this->Member->save($data);
		$this->Session->setFlash('<p> Member details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Member']['status'] = $stat;
		
		$this->Member->id = $id;
		$updateFlag = $this->Member->save($data);
		
		if($updateFlag){
			$this->Session->setFlash('Member status changed successfully!', 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('Failed to change status!', 'default', array('class' => 'alert alert-danger'));
		}
		$this->redirect($this->referer());
	}
	
	public function admin_deleteAll($idAll=NULL, $isdel='0')
	{	
		//pr($id); exit();
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			
			$data['Member']['isdel'] = $isdel; 
			$this->Member->id = $id;
			$deleteFlag = $this->Member->save($data);
			
			if($deleteFlag){
				$this->Session->setFlash('The Member has been successfully removed!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete the Member!', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	function ajax_check_email() {
		$this->layout = 'ajax';

		if (!empty($this->data)) {
			if ($this->request->data['Member']['email_id'] == '') {
				$this->set('value', 0);
			} else {
				$u = $this->Member->findByEmailId($this->request->data['Member']['email_id']);
				if (empty($u)) {
					$this->set('value', 1);
				} else {
					$this->set('value', 0);
				}
			}
		} else {
			$this->set('value', 0);
		}
	}
	
	public function login()
	{
		$this->theme = THEME_NAME;
		$this->layout = 'ecommerce_inner';
		
	}
	
	public function ajaxlogin()
	{
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$data = $this->request->data;
			//pr($data); exit();
			$username=$data['Member']['email_id'];
			$password=AuthComponent::password($data['Member']['password']);
			
			$user=$this->Member->find('all', array(
				'conditions'=>array(
					'email_id'=>$username
					)
				)
			);
						
			$no=count($user); 
			if($no>0){
				if($user[0]['Member']['status']=='Y'){
					
					if($user[0]['Member']['password']==$password){
						$this->Session->write('email_id', $user[0]['Member']['email_id']);
						$this->Session->write('id', $user[0]['Member']['id']);
						$this->Session->write('loggedin_status', true);
						$this->Session->write('last_login', time());
						echo 1; exit();
					} else {
						echo 2; exit();
					}
				} else {
					echo 3; exit();
				}
			}
			else{
				echo 4; exit();
			}
			
		} else {
			echo 5;
		}
		exit();
	}
	
	
	/********* Register Process Start *********/
	public function register()
	{
		$this->theme = THEME_NAME;
		$this->layout = 'ecommerce_inner';
		
		$countries = $this->Country->find('list', array(
				'conditions'=>array(
					'Country.status'=>'Y',
					'Country.isdel'=>0
				),
				'fields'=>array('Country.id','Country.Country')
			)
		);
		//pr($countries); exit();
		$this->set(compact('countries'));
	}
	
	public function ajaxregister()
	{
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			if($this->Member->validates()){
				$data = $this->request->data;
				//pr($data); exit();
				$newArr = $this->request->data['New'];
				if(($newArr['password'] !== '') && ($newArr['con_password'] !== '') && ($newArr['password'] == $newArr['con_password'])){
					$data['Member']['password'] = AuthComponent::password($newArr['password']);
				}
				$data['Member']['activate_code'] = time().uniqid();
				$data['Member']['status'] = 'N';
				$data['Member']['date_created'] = date('Y-m-d');
				$this->Member->create();
				$flag = $this->Member->save($data);
				
				if($flag){
					$this->loadModel('EmailTemplate');
					$Email = new CakeEmail();
					$body = $this->EmailTemplate->findByTemplateName('Registration');
					
					$url = '<a href="'.SITE_URL.'activate/'.$data['Member']['activate_code'].'">'.SITE_URL.'activate/'.$data['Member']['activate_code'].'</a>';
					$var = array('[firstname]'=>$data['Member']['firstname'],'[lastname]'=>$data['Member']['lastname'],'[urlpath]'=>$url);
					
					$Email->viewVars(array(
						'base_url' => SITE_URL,
						'subject' => 'Registration Successful',
						'contact_person' => 'Sir',
						'body_text' => $body['EmailTemplate']['email_body'],
						'body_varArr'=>$var
					));
					
					$fl = $Email->template('template', 'base_layout')
						->emailFormat('html')
						->from(array('sseal@sdsoftware.in' => 'cakecms_new'))
						->to($data['Member']['email_id'])
						->subject('Account Register')
						->send();
					if($fl){
						$this->Session->setFlash('<p>Registration successful and a confirmation email has been sent to your email id!</p>', 'default', array('class' => 'note note-success'),'register');
						echo 1;
					} else {
						$this->Session->setFlash('<p>Failed to sent registration mail!</p>', 'default', array('class' => 'note note-danger'),'register');
						echo 0;
					}
					exit();
				} else {
					$this->Session->setFlash('<p>Failed to register your account!</p>', 'default', array('class' => 'note note-danger'),'register');
					echo 2; exit();
				}
			}
		}
	}
	
	public function ajaxstate(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			if(!empty($reqdata)){
				$states = $this->State->find('list', array(
						'conditions'=>array('State.CountryID'=>$reqdata['id'], 'State.isdel'=>0),
						'fields'=>array('State.id','State.State'),
						'order'=>array('State.State ASC')
					)
				);
				//pr($states); exit();
			}
			$this->set(compact('states'));
		}
	}
	
	public function ajaxcity(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			if(!empty($reqdata)){
				$cities = $this->City->find('list', array(
						'conditions'=>array('City.StateID'=>$reqdata['id'], 'City.isdel'=>0),
						'fields'=>array('City.id','City.City'),
						'order'=>array('City.City ASC')
					)
				);
			}
			$this->set(compact('cities'));
		}
	}
	
	public function ajaxcheckemail(){
		$this->theme = THEME_NAME;
		$this->layout = "ajax";
		
		if($this->request->is('post')){
			$email = $this->request->data['email_id'];
			echo $count = $this->Member->find('count', array(
					'conditions'=>array(
						'Member.email_id'=>$email
					)
				)
			);
			exit();
		}
	}
	
	public function activate($activate_code=NULL){
		$this->theme = THEME_NAME;
		$this->layout = "ecommerce_inner";
		$test = '';
		if($activate_code!=''){
			$data = $this->Member->findByActivateCode($activate_code);
			if( count($data) == 1){
				if($data['Member']['status']=='Y'){
					$this->Session->setFlash('<p>You account already been activated</p>', 'default', array('class' => 'note note-danger'),'activate');
					$this->set(compact('test'));
				} else {
					$this->Member->id = $data['Member']['id'];
					$saveData['Member']['status'] = 'Y';
					$f = $this->Member->save($saveData);
					if($f){
						$this->Session->setFlash('<p>You account have been activated</p>', 'default', array('class' => 'note note-success'),'activate');
						$this->set(compact('test'));
					} else {
						$this->Session->setFlash('<p>Failed to activate your account!</p>', 'default', array('class' => 'note note-danger'),'activate');
						$this->set(compact('test'));
					}
				}
			} else {
				$this->Session->setFlash('<p>You have enter wrong url</p>', 'default', array('class' => 'note note-danger'),'activate');
				$this->set(compact('test'));
			}
		} else {
			$this->Session->setFlash('<p>You have enter wrong url</p>', 'default', array('class' => 'note note-danger'),'activate');
			$this->set(compact('test'));
		}
	}
	/********* Register Process End *********/
	
	/* public function ajaxSubscribe($id=Null,$email=NULL)
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		
		if($this->request->is("post"))
		{
			$data=$this->request->data;
			
			$find = $this->Member->findByEmailId($data['Member']['email_id']);
			
			if(!$find)
			{
				
				$email_id=$this->request->data['Member']['email_id'];
				$firstname=$this->request->data['Member']['firstname'];
				$lastname=$this->request->data['Member']['lastname'];
				// if given, set new password
				$newArr = $this->request->data['New'];
				if(($newArr['password'] !== '') && ($newArr['con_password'] !== '') && ($newArr['password'] == $newArr['con_password'])){
					$this->request->data['Member']['password'] = AuthComponent::password($newArr['password']);
				}
				$this->request->data['Member']['status'] = 'N';
				$username=$this->request->data['Member']['email_id'];
				
				
				$this->Member->create();
				$this->Member->save($this->request->data);
				
		
				$this->loadModel('EmailTemplate');
				$Email = new CakeEmail();
				$body = $this->EmailTemplate->findByTemplateName('Registration');
				$var = array('[Name]'=>'Sir');
				
				$Email->viewVars(array(
					'base_url' => SITE_URL,
					'subject' => 'Newsletter Subscribe',
					'contact_person' => 'Sir',
					'body_text' => $body['EmailTemplate']['email_body'],
					'body_varArr'=>$var
				));
				
				$Email->template('template', 'base_layout')
					->emailFormat('html')
					->from(array('asamanta@sdsoftware.in' => 'cakecms'))
					->to($data['Member']['email_id'])
					->subject('Newsletter Subscribe')
					->send();
				
				//$this->redirect($this->referer());
				
				echo 4;
			exit();
			
		} else {
			echo 3;
			exit();
		}
		
		} else {
			echo 1;
			exit();
		}
	} */
	
	public function success()
	{
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
		
	
	}
	public function forgotpassword()
	{
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
		if($this->request->is("post"))
		{
			$reqdata = $this->request->data; //pr($reqdata); exit();
			$email_id=$reqdata['Member']['email_id'];
			$email_count = $this->Member->findByEmailId($email_id);
			if(!empty($email_count))
			{
				$newPassword = AppController::generate_random_value(8);
				$saveArr['Member']['password'] = AuthComponent::password($newPassword);
				$saveArr['Member']['status'] = 'Y';
				
				$this->Member->id = $email_count['Member']['id'];
				$saveFlag = $this->Member->save($saveArr);
				
				if($saveFlag){
					$generalSetting = $this->Session->read('siteSettings');
					
					$this->loadModel('EmailTemplate');
					$Email = new CakeEmail();
					$body = $this->EmailTemplate->findByTemplateName('Reset Password');
					$var = array(
						'[Name]'=>$email_count['Member']['firstname'].' '.$email_count['Member']['lastname'],
						'[NewPassword]'=>$newPassword
						);
					
					$Email->viewVars(array(
						'base_url' => SITE_URL,
						'subject' => 'Reset Password',
						'contact_person' => $email_count['Member']['firstname'].' '.$email_count['Member']['lastname'],
						'body_text' => $body['EmailTemplate']['email_body'],
						'body_varArr'=>$var
					));
					
					$flag = $Email->template('template', 'base_layout')
						->emailFormat('html')
						->from(array($generalSetting['SiteSetting']['admin_email'] => $generalSetting['SiteSetting']['meta_title']))
						->to($email_count['Member']['email_id'])
						->subject('Reset Password')
						->send();
						
					if($flag){
						$this->Session->setFlash('<i class="fa fa-info pull-left"></i> An email has been sent to your email account.', 'default', array('class' => 'alert alert-icon alert-success'));
					} else {
						$this->Session->setFlash('<i class="fa fa-exclamation-circle pull-left"></i> Failed to send email. Please check your email.', 'default', array('class' => 'alert alert-icon alert-danger'));
					}
				}
					
			} else {
				$this->Session->setFlash('<i class="fa fa-exclamation-circle pull-left"></i> Please enter your email id.', 'default', array('class' => 'alert alert-icon alert-danger'));
					
			}
			$this->redirect($this->referer());
		}
		
	}
	
	
	public function recovery($id=NULL)
	{
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
		$this->set('data', $id);
	}
	public function reset_password()
	{
		$this->theme = THEME_NAME;
		$this->layout = '';
		$this->autoRender = false;
		$code = $this->request->data['Member']['recode'];
		$password = $this->request->data['Member']['reset_password'];
		
		if($code!='')
		{
			$code_count = $this->Member->findByUserRecoverycode($code);
			if(!empty($code_count))
			{
				$hashpass = AuthComponent::password($password);
				$this->Member->id = $code_count['Member']['id'];
				$save['Member']['password']=$hashpass ;
				$this->Member->save($save);
			
			
			}
			$this->Session->setFlash('<p>You password has been changed successfully </p>', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('controller'=>'Members', 'action'=>'login_page'));
		}
		else
		{
			$this->Session->setFlash('<p>You password not changed </p>', 'default', array('class' => 'alert alert-danger'));
			
		}
		
	}
	
	public function logout(){
		$this->autoRender=false;
		$this->Session->delete('loggedin_status');
		$this->Session->delete('last_login');
		$this->Session->delete('log');
		$this->Session->setFlash('<p>You have successfully logged out</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect(array('controller'=>'Members', 'action'=>'login'));
	
	}
	
	/*********** My Account ***********/
	public function myaccount(){
		$this->theme = THEME_NAME;
		$this->layout = 'ecommerce_inner';
		
		if($this->Session->read('loggedin_status')){
			$userid = $this->Session->read('id');
			$this->Member->bindModel(array(
					'belongsTo'=>array(
						'Country'=>array(
							'className'=>'Country',
							'foreignKey'=>'country'
						),
						'State'=>array(
							'className'=>'State',
							'foreignKey'=>'state'
						),
						'City'=>array(
							'className'=>'City',
							'foreignKey'=>'city'
						)
					)
				)
			);
			$data = $this->Member->findById($userid);
			//pr($data); exit();
			$this->set(compact('data'));
		} else {
			$this->redirect(array('controller'=>'Members', 'action'=>'login'));
		}
		
	}
	
	public function ajaxpersonalinfo(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		if($this->Session->read('loggedin_status')){
			$userid = $this->Session->read('id');
			$data = $this->Member->findById($userid);
			$mode = $this->request->data['mode'];
			$this->set(compact('data','mode'));
		}
	}
	
	public function ajaxaddressinfo(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		if($this->Session->read('loggedin_status')){
			$userid = $this->Session->read('id');
			
			$this->Member->bindModel(array(
					'belongsTo'=>array(
						'Country'=>array(
							'className'=>'Country',
							'foreignKey'=>'country'
						),
						'State'=>array(
							'className'=>'State',
							'foreignKey'=>'state'
						),
						'City'=>array(
							'className'=>'City',
							'foreignKey'=>'city'
						)
					)
				)
			);
			$data = $this->Member->findById($userid);
			
			$countries = $this->Country->find('list', array(
					'conditions'=>array(
						'Country.status'=>'Y',
						'Country.isdel'=>'0'
					),
					'fields'=>array(
						'id','Country'
					)
				)
			);
			
			if(!empty($data)){
				$states = $this->State->find('list', array(
						'conditions'=>array(
							'State.CountryID'=>$data['Member']['country'],
							'State.status'=>'Y',
							'State.isdel'=>'0'
						),
						'fields'=>array(
							'id','State'
						)
					)
				);
			} else {
				$states = array();
			}
			
			
			if(!empty($data)){
				$cities = $this->City->find('list', array(
						'conditions'=>array(
							'City.StateID'=>$data['Member']['state'],
							'City.status'=>'Y',
							'City.isdel'=>'0'
						),
						'fields'=>array(
							'id','City'
						)
					)
				);
			} else {
				$cities = array();
			}
			
			$mode = $this->request->data['mode'];
			$this->set(compact('data','mode','countries','states','cities'));
		}
	}
	
	public function ajaxpinfosubmit(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		if($this->Session->read('loggedin_status')){
			$userid = $this->Session->read('id');
			if($this->request->is('post')){
				$data = $this->request->data;
				$this->Member->id=$userid;
				$newArr = $this->request->data['New'];
				if($newArr['password'] !== ''){
					$data['Member']['password'] = AuthComponent::password($newArr['password']);
				}
				$flag = $this->Member->save($data);
				
				echo ($flag)?1:0;
				exit();
			}
		}
	}
	
	public function ajaxainfosubmit(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		if($this->Session->read('loggedin_status')){
			$userid = $this->Session->read('id');
			if($this->request->is('post')){
				$data = $this->request->data;
				$this->Member->id=$userid;
				$flag = $this->Member->save($data);
				
				echo ($flag)?1:0;
				exit();
			}
		}
	}
	
	public function ajaxmystate(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			if(!empty($reqdata)){
				$states = $this->State->find('list', array(
						'conditions'=>array('State.CountryID'=>$reqdata['id'], 'State.isdel'=>0),
						'fields'=>array('State.id','State.State'),
						'order'=>array('State.State ASC')
					)
				);
				//pr($states); exit();
			}
			$this->set(compact('states'));
		}
	}
	
	public function ajaxmycity(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			if(!empty($reqdata)){
				$cities = $this->City->find('list', array(
						'conditions'=>array('City.StateID'=>$reqdata['id'], 'City.isdel'=>0),
						'fields'=>array('City.id','City.City'),
						'order'=>array('City.City ASC')
					)
				);
			}
			$this->set(compact('cities'));
		}
	}
	
	public function myorders(){
		$this->theme = THEME_NAME;
		$this->layout = 'ecommerce_inner';
		
		if($this->Session->read('loggedin_status')){
			
		} else {
			$this->redirect(array('controller'=>'Members', 'action'=>'login'));
		}
		
	}
	
	public function wishlist(){
		$this->theme = THEME_NAME;
		$this->layout = 'ecommerce_inner';
		
		if($this->Session->read('loggedin_status')){
			$member_id = $this->Session->read('id');
			
			$productArr = $this->Wishlist->find('list', array(
					'conditions'=>array('Wishlist.member_id'=>$member_id),
					'fields'=>array('Wishlist.product_id')
				)
			);
			//pr($data); exit();
			$this->set(compact('productArr','member_id'));
		} else {
			$this->redirect(array('controller'=>'Members', 'action'=>'login'));
		}
		
	}
	public function admin_getListMembers(){
		$this->layout = 'ajax';
		
		$qdata = $this->params->query['query']; 
		$this->loadModel('Member');
		$data = $this->Member->find('all',
			array(
				'conditions'=>array(
					'Member.name LIKE'=>"%".$qdata."%",
					'Member.isdel' => 0
				),
				'fields'=>'Member.id,Member.name'
			)
		);
		$myArr = array();
		foreach($data as $dt){
			$obj = new stdClass();
			$obj->data = $dt['Member']['id'];
			$obj->value = $dt['Member']['name'];
			array_push($myArr, $obj);
		}
		
		$arr = array('suggestions'=>$myArr);
		echo json_encode($arr);
		exit();
	}
}
?>