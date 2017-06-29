<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');

class TwittersController extends AppController {
	
	public $name = 'Twitters';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('Twitter');
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
			$data = $this->request->data;
			//pr($data); exit;
			if($data['Twitter']['id']!='')
			{
				
				$this->Twitter->id = $data['Twitter']['id'];
			}
			else
			{
				$this->Twitter->create();
			}
			$fl = $this->Twitter->save($data);
			if($fl){
				$this->Session->setFlash('<p>Details has been updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('<p>Failed to update the details!</p>', 'default', array('class' => 'alert alert-danger'));
			}
			$this->redirect('/admin/Twitters/index');
		}
		$data = $this->Twitter->find('first',
				array(
					'conditions'=>array('Twitter.Is_active'=>'0')
					)
				);
		
		$this->set('data', $data);
	}
	
	
}
?>