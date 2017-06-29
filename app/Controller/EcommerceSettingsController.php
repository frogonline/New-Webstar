<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class EcommerceSettingsController extends AppController 
{
	public $name = 'EcommerceSettings';
	public $components = array();
	public $helpers = array();
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
	
	public function admin_index($id=NULL)
	{	
		$this->layout = 'adminInner';
		$this->loadModel('SiteSetting');
		if ($this->request->is('post')) 
		{	
				$reqdata = $this->request->data;
				if($id!== ''){
					$this->SiteSetting->id = $id;
				} else{
					$this->SiteSetting->create();
				}
				$this->SiteSetting->save($reqdata);
				if($id!== ''){
					$this->Session->setFlash(
					'Ecommerce Settings updated', 'default', array('class' => 'alert alert-success'));
				} else{
					$this->Session->setFlash(
					'Ecommerce Settings added', 'default', array('class' => 'alert alert-success'));
				}
				$this->redirect('/admin/EcommerceSettings/index');
		}
		$this->set('id', $id);
		$data = $this->SiteSetting->find('first');		
		$this->set('data', $data);	
	}
}
?>