<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');

class FlickrsController extends AppController {

	public $name = 'Flickrs';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('Flickr');
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
	
	$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('Flickr.isdel'=>'0')
					);
	
		$data = $this->paginate('Flickr');
		
		$this->set('data', $data);
	
	}
	
	public function admin_manage($id=NULL){	
		$this->layout = 'adminInner';
		
		if($this->request->is('post')){	
			
			if($this->Flickr->validates()){
			
				$data = $this->request->data;
				if($id != ''){
					
					$this->Flickr->id = $id;
				} else{
			
					$this->Flickr->create();
				}
				
				$saveFlag = $this->Flickr->save($data);
				$saveId = $this->Flickr->id;
				
				if($saveFlag){
					if($id != ''){
						$this->Session->setFlash('Flickr updated successfully.', 'default', array('class' => 'alert alert-success'));
					} else{
						$this->Session->setFlash('Flickr added successfully', 'default', array('class' => 'alert alert-success'));
					}
				} else {
					$this->Session->setFlash('Failed to save the Flickr', 'default', array('class' => 'alert alert-danger'));
				}
				
				if($data['Flickr']['status']=='Y')
				{
					$this->loadModel('Shortcode');
					$get_data = $this->Shortcode->findByNameAndWidgetId('flickrphoto',$id);
				
					if(empty($get_data))
					{
						$data['Shortcode']['controller'] 	= 'Flickrs';
						$data['Shortcode']['action']		= 'manage';
						$data['Shortcode']['widget_id'] 	= $saveId;
						$data['Shortcode']['name'] 			= 'flickrphoto';
						$this->Shortcode->create();
						
						$this->Shortcode->save($data);
					}	
				}
				
				
				if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'Flickrs','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'Flickrs','action'=>'admin_index'));
				}
				//$this->redirect(array('controller'=>'Videos','action'=>'admin_index'));
			} 
		}
		if(trim($id) !== ''){
				$data = $this->Flickr->findById($id);
				$this->set('data', $data);
			}
			
			$this->set('id', $id);
	}
	
	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Flickr']['isdel'] = $isdel; 
		$this->Flickr->id = $id;
		$deleteFlag = $this->Flickr->save($data);
		
		if($deleteFlag)
		{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('flickrphoto',$id);
				//pr($get_data); exit;
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
		}
		$this->Session->setFlash('<p><strong>Success:&nbsp;</strong> Flickr Widget details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Flickr']['status'] = $stat;
		
		$this->Flickr->id = $id;
		$this->Flickr->save($data);
		$this->Session->setFlash('<p><strong>Success:&nbsp;</strong>Flickr Widget updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
}

	
?>