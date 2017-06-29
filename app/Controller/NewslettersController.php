<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');


class NewslettersController extends AppController {

	public $name = 'Newsletters';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('Newsletter', 'Subscriber');
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
	
	public function admin_index($id = NULL)
	{
		$this->layout = 'adminInner';
		
		$model = ClassRegistry::init('Subscriber');
		$this->loadModel('NewsletterGroups');
		$group = $this->NewsletterGroups->find('all', array(
				'conditions' => array('NewsletterGroups.status' => 'Y','NewsletterGroups.isdel' => '0')
			));
		
		$this->set('subs', $group);
		
		if($this->request->is("post"))
		{ 
			$data = $this->request->data;
			$likekeyArr = array('subject');
			
			$conditionArr = array();
			foreach($data['Newsletter'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['Newsletter.'.$k.' LIKE'] = '%'.$v.'%';
					}  else {
							$conditionArr['Newsletter.'.$k] = $v; 
						}
					}
				}
			$conditionArr['Newsletter.isdel'] = 0; 
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Newsletter.id' => 'DESC')
			);
			$this->set('searchData',$data);

		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('Newsletter.isdel'=>'0'),
					'order'=>array('Newsletter.id' => 'DESC')
					);
			
		}
		$this->set(compact('id','sub'));
		$data=$this->paginate('Newsletter');
		$this->set('data', $data);
	}
	
	public function admin_manage($id=NULL){	
		$this->layout = 'adminInner';
		
		if($this->request->is('post')){	
			//$this->Newsletter->set($this->request->data);
			$data = $this->request->data;
			if($this->Newsletter->validates()){
				
				if($id !== ''){
					$data['Newsletter']['modified_date'] = date("Y-m-d");
					$this->Newsletter->id = $id;
				} else{
					
					$this->request->data['Newsletter']['created_date'] = date("Y-m-d");
					$this->Newsletter->create();
				}
				
				$this->Newsletter->save($this->request->data);
				$saveId = $this->Newsletter->id;

				if($this->Newsletter->id == $id)
				{
					$this->Session->setFlash('<p>Template details has been updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
				} 
				else
				{
					$this->Session->setFlash('<p>Template details has been added successfully!</p>', 'default', array('class' => 'alert alert-success'));
				}
				
				if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'Newsletters','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'Newsletters','action'=>'admin_index'));
				}
				//$this->redirect(array('controller'=>'Newsletters','action'=>'admin_index'));
				
			} 
		}
		$this->set('id',$id);
		$model = ClassRegistry::init('Subscriber');
		$sub = $model->find('list',array
								('conditions'=>array('Subscriber.is_del'=>'0'),
									'fields'=>'Subscriber.id, Subscriber.subscriber_name, 
									Subscriber.subscriber_email'
									));
		//Set Data For Edit
		if($id !== NULL || $id !== '')
		{
			$data = $this->Newsletter->findById($id);
			$this->set(compact('data', 'sub'));
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
		$data['Newsletter']['isdel'] = $isdel; 
		$this->Newsletter->id = $id;
		$this->Newsletter->save($data);
		$this->Session->setFlash('<p>Template details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Newsletter']['status'] = $stat;
		
		$this->Newsletter->id = $id;
		$updateFlag = $this->Newsletter->save($data);
		
		if($updateFlag){
			$this->Session->setFlash('Template status changed successfully!', 'default', array('class' => 'alert alert-success'));
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
			
			$data['Newsletter']['isdel'] = $isdel; 
			$this->Newsletter->id = $id;
			$deleteFlag = $this->Newsletter->save($data);
			
			if($deleteFlag){
				$this->Session->setFlash('Templates are successfully removed!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete Templates!', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	public function admin_newslettermail($id=NULL, $select=NULL){	
		$this->layout = '';
		$data= $this->request->data;
		
		
		if($data['Newsletter']['select'] == '0')
		{
			$this->loadModel('Subscriber');
			$subscribers = $this->Subscriber->find('all',array
								('conditions'=>array('Subscriber.is_del'=>'0','Subscriber.subscriber_status'=>'Y','Subscriber.subscriber_group'=>$data['Newsletter']['grouplist'])));
		}
		if($data['Newsletter']['select'] == '1')
		{
			$this->loadModel('Subscriber');
			$subscribers = $this->Subscriber->find('all',array
								('conditions'=>array('Subscriber.is_del'=>'0','Subscriber.subscriber_status'=>'Y')));
		}
		

		
		$id=$this->request->data['Newsletter']['id'];
		
		$newsletter = $this->Newsletter->find('all',array
								('conditions'=>array('Newsletter.isdel'=>'0','Newsletter.status'=>'Y','Newsletter.id'=>$id)));
		
		
		if(!empty($subscribers))
		{
			foreach($subscribers as $subscribers)
			{
				$this->loadModel('EmailTemplate');
				$Email = new CakeEmail();
				$body = $this->EmailTemplate->findByTemplateName('Subscribe');
				$var = array('[Name]'=>$subscribers['Subscriber']['subscriber_name']);
				
				$Email->viewVars(array(
					'base_url' => SITE_URL,
					'subject' => $newsletter[0]['Newsletter']['subject'],
					'contact_person' => $subscribers['Subscriber']['subscriber_name'],
					'body_text' => $newsletter[0]['Newsletter']['newsletter'],
					'body_varArr'=>$var
				));
				
				$Email->template('template', 'base_layout')
					->emailFormat('html')
					->from(array('asamanta@sdsoftware.in' => 'cakecms'))
					->to($subscribers['Subscriber']['subscriber_email'])
					->subject($newsletter[0]['Newsletter']['subject'])
					->send();
			}
		}
		$this->redirect($this->referer());
		
							
			
	}

	
	public function admin_boxmanage()
	{
		$this->set('id', $this->request->data['box_id']);
		$this->loadModel('NewsletterGroups');
		$group = $this->NewsletterGroups->find('all', array(
				'conditions' => array('NewsletterGroups.status' => 'Y','NewsletterGroups.isdel' => '0')
			));
		
		$this->set('subs', $group);
	}
	
}

?>