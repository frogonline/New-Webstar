<?php 
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class EmailTemplatesController extends AppController 
{
	public $name = 'EmailTemplates';
	public $components = array();
	public $helpers = array();
	public $uses = array();
	public $paginate = array();

	public function beforeFilter() 
	{
		parent::beforeFilter();
		
		$this->Auth->allow('admin_fetch');
		
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
			
			$likekeyArr = array('template_name');
			
			$conditionArr = array();
			foreach($data['EmailTemplate'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['EmailTemplate.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
						$conditionArr['EmailTemplate.'.$k] = $v; 
					}
				}
			}
			$conditionArr['EmailTemplate.isdel'] = 0; 
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('EmailTemplate.id' => 'DESC')
			);
			$this->set('searchData',$data);
		} else {
			$this->paginate=array(
					'conditions' => array('EmailTemplate.isdel'=>0),
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'order'=>array('EmailTemplate.id' => 'DESC')
					);
			
		}
		$data=$this->paginate('EmailTemplate');
		$this->set('data', $data);
	}
	
	public function admin_manage($id=NULL)
	{
		$this->layout = 'adminInner';
		if($this->request->is('post'))
		{
			$data = $this->request->data;
			$this->EmailTemplate->save($this->request->data);
			$saveId = $this->EmailTemplate->id;

			if($this->request->data['EmailTemplate']['id'] !== ''){
				$this->Session->setFlash('<p>Email Template Updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
				
			} else{
				$this->Session->setFlash('<p>Email Template added successfully!</p>', 'default', array('class' => 'alert alert-success'));
				
			}
			
			if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'EmailTemplates','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'EmailTemplates','action'=>'admin_index'));
				}
			//$this->redirect('/admin/EmailTemplates/index');
			
		}
		$data = $this->EmailTemplate->findById($id);
		$this->set('data',$data);	
		
	}
	
	public function admin_preview($id=NULL)
	{
		$this->layout = 'Emails/html/base_layout';
		$this->set('base_url', SITE_URL);
		$data = $this->EmailTemplate->findById($id);
		$this->set('subject',$data['EmailTemplate']['email_subject']);
		$this->set('body_text',$data['EmailTemplate']['email_body']);	
		$this->set('body_varArr',array());	
		
		$this->render('/Emails/html/template');
	}

	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['EmailTemplate']['status'] = $stat;
		
		$this->EmailTemplate->id = $id;
		$this->EmailTemplate->save($data);
		$this->Session->setFlash('<p>Email Template updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	public function admin_restore($id=NULL)
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['EmailTemplate']['email_body'] = 'This is a test template';
		$this->EmailTemplate->id = $id;
		$this->EmailTemplate->save($data);
		$this->Session->setFlash('<p>Email Template restored successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());
		exit();
	}
	
	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['EmailTemplate']['isdel'] = $isdel; 
		$this-> EmailTemplate->id = $id;
		$this-> EmailTemplate->save($data);
		$this->Session->setFlash('<p> Email Template details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		//pr($id); exit();
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->EmailTemplate->delete($id);
		}
		$this->Session->setFlash(
				'<p>Email Template removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
		$this->redirect($this->referer());	
	}
	
}	
?>