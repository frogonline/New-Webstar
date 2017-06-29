<?php 
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class SubscribersController extends AppController 
{
	public $name = 'Subscribers';
	public $components = array();
	public $helpers = array();
	public $uses = array('Subscriber');
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

	public function admin_index(){
		$this->layout = 'adminInner';
		
		if($this->request->is("post"))
		{ 
			$data = $this->request->data;
			$likekeyArr = array('subscriber_name');
			$likeemailArr= array('subscriber_email');
			$conditionArr = array();
			foreach($data['Subscriber'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['Subscriber.'.$k.' LIKE'] = '%'.$v.'%';
					} else if( in_array($k,$likeemailArr)){
						$conditionArr['Subscriber.'.$k.' LIKE'] ='%'.$v.'%';
					}
					else {
						$conditionArr['Subscriber.'.$k] = $v; 
						}
					}
				}
			$conditionArr['Subscriber.is_del'] = 0;
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Subscriber.id' => 'DESC')
			);
			$this->set('searchData',$data);

		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('Subscriber.is_del'=>'0'),
					'order'=>array('Subscriber.id' => 'DESC')
					);
			
		}
		$data = $this->paginate('Subscriber');
		$this->set('data', $data);
		
	}
		
		
	
	public function admin_delete($id=NULL,$stat = '1')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$f_subs = $this->Subscriber->findById($id);
		$data['Subscriber']['is_del'] = $stat;
		$this->Subscriber->id = $id;
		$this->Subscriber->subscriber_email = $f_subs['Subscriber']['subscriber_email'];
		$this->Subscriber->save($data);
		$this->Session->setFlash('The Subscriber has been successfully removed!</p>', 'default', array('class' => 'alert alert-success'));
		//pr($email);exit;
		
		$this->loadModel('EmailTemplate');
		
		$Email = new CakeEmail();
		$body = $this->EmailTemplate->findByTemplateName('Desubscribe');
		$var = array('[Name]'=>$f_subs['Subscriber']['subscriber_name']);
		
		$Email->viewVars(array(
			'base_url' => SITE_URL,
			'subject' => 'Newsletter Desubscribe',
			'contact_person' => $f_subs['Subscriber']['subscriber_name'],
			'body_text' => $body['EmailTemplate']['email_body'],
			'body_varArr'=>$var
		));
		
		$Email->template('template', 'base_layout')
			->emailFormat('html')
			->from(array('asamanta@sdsoftware.in' => 'cakecms'))
			->to($f_subs['Subscriber']['subscriber_email'])
			->subject('Newsletter Desubscribe')
			->send();
		
		$this->redirect($this->referer());
		
		exit();
	}
	
	public function admin_manage($id=NULL)
	{
		
		$this->layout = 'adminInner';
		
		if ($this->request->is('post')) 
		{	
			
			//$this->Subscriber->set($this->request->data);
			$data = $this->request->data;
			
			if($this->Subscriber->validates()) 
			{
				if($this->request->data['Subscriber']['id'] != ''){
					$this->Subscriber->id = $id;
				} else{
					$this->Subscriber->create();
				}
		
				$this->Subscriber->save($this->request->data);
				$saveId = $this->Subscriber->id;
				if($this->request->data['Subscriber']['id'] !== ''){
					$this->Session->setFlash('<p>Subscriber Updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
				} else{
					$this->Session->setFlash('<p>Subscriber added successfully!</p>', 'default', array('class' => 'alert alert-success'));
				}
				if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'Subscribers','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'Subscribers','action'=>'admin_index'));
				}
			} 
		}
		
		$this->set('id', $id);
		if($id !== NULL || $id !== ''){
			$data = $this->Subscriber->findById($id);
			$this->set('data',$data);
		}
		if(!$id)
		{
			$data	=	$this->request->data;
			$this->set('data',$data);
		}
		$this->loadModel('NewsletterGroups');
		$group = $this->NewsletterGroups->find('all', array(
				'conditions' => array('NewsletterGroups.status' => 'Y','NewsletterGroups.isdel' => '0')
			));
		
		$this->set('group', $group);
	}
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Subscriber']['subscriber_status'] = $stat;
		
		$this->Subscriber->id = $id;
		$this->Subscriber->save($data);
		$this->Session->setFlash('<p>Subscriber updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	public function admin_deleteAll($idAll=NULL, $stat = '1')
	{	
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->Subscriber->findById($id);
			//echo $data; exit;
			$data['Subscriber']['is_del'] = $stat;
			$this->Subscriber->id = $id;
			$deleteFlag = $this->Subscriber->save($data);
			
			if($deleteFlag){
				$this->Session->setFlash('<p>Subscriber removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Subscriber cannot be removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	public function ajaxSubscribe()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		
		if($this->request->is("post"))
		{
			$data=$this->request->data;
			
			$find = $this->Subscriber->findBySubscriberEmailAndIsDel($data['Newsletter']['fname'],0);
			
			if(!$find)
			{
			$this->Subscriber->create();
			$this->Subscriber->saveField('subscriber_email',$data['Newsletter']['fname']);
			
		
			//pr($subscriber);exit;
			
				//$this->redirect($this->referer());
				//$this->Session->setFlash('Failed to save the Post', 'default', array('class' => 'alert alert-danger'));
		
				$this->loadModel('EmailTemplate');
				$Email = new CakeEmail();
				$body = $this->EmailTemplate->findByTemplateName('Subscribe');
				$var = array('[Name]'=>$data['Newsletter']['fname']);
				
				$Email->viewVars(array(
					'base_url' => SITE_URL,
					'subject' => 'Newsletter Subscribe',
					'contact_person' => $data['Newsletter']['fname'],
					'body_text' => $body['EmailTemplate']['email_body'],
					'body_varArr'=>$var
				));
				
				$Email->template('template', 'base_layout')
					->emailFormat('html')
					->from(array('asamanta@sdsoftware.in' => 'cakecms'))
					->to($data['Newsletter']['fname'])
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
		
		/* $this->loadModel('SiteSetting');
		$siteSetting = $this->SiteSetting->find('first');	
		if($this->request->is("post")){
			$data = $this->request->data;
			//$captcha = $this->Session->read('captcha_code');
			
			
				$this->loadModel('EmailTemplate');
		
				$Email = new CakeEmail();
				$body = $this->EmailTemplate->findByTemplateName('Contact ');
				$var = array('[Name]'=>$data['Page']['name'],'[Email]'=>$data['Page']['email'],'[Message]'=>$data['Page']['comment']);
				
				$Email->viewVars(array(
					'base_url' => SITE_URL,
					'subject' => $body['EmailTemplate']['email_subject'],
					'contact_person' => $data['Page']['name'],
					'body_text' => $body['EmailTemplate']['email_body'],
					'body_varArr'=>$var
				));
				
				$flag = $Email->template('template', 'base_layout')
					->emailFormat('html')
					->from(array('asamanta@sdsoftware.in' => 'cakecms'))
					->to($siteSetting['SiteSetting']['admin_email'])
					->subject($body['EmailTemplate']['email_subject'])
					->send();
				
					echo 4; exit();
				
			
				exit();
			
		} else {
			echo 1;
			exit();
		} */
	}
	
	public function ajaxsubcriberaction()
	{
		$this->layout = 'ajax';
		if($this->request->is('post')){
			$data = $this->request->data; 
			if(!empty($data)){
				$count=$this->Subscriber->find('count', array(
						'conditions'=>array(
							'Subscriber.subscriber_email'=>$data['Subscriber']['subscriber_email']
						)
					));
				if($count>0)
				{
					echo -1; exit();
				}
				else
				{
					$this->Subscriber->create();
					$data['Subscriber']['ip_address']=$this->RequestHandler->getClientIp();
					$data['Subscriber']['subscriber_group']=1;
					$result=$this->Subscriber->save($data);
					if($result)
					{
						echo 1; 
						exit();
					}
					else
					{
						echo 0; 
						exit();
					}
				}
			}
		}
		
	}
}	
?>