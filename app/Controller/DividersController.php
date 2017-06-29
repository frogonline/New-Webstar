<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');

class DividersController extends AppController {

	public $name = 'Dividers';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array();
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
			if($data['Divider']['id']!='')
			{
				
				$this->Divider->id = $data['Divider']['id'];
			}
			else
			{
				$this->Divider->create();
			}
			$this->Divider->save($data);
			
			$this->redirect('/admin/Dividers/index');
		}
		$data = $this->Divider->find('first');
		
		$this->set('data', $data);
	}
	
	
	
}
	
?>