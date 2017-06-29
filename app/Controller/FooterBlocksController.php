<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class FooterBlocksController extends AppController 
{
	
	public $name = 'FooterBlocks';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('FooterBlock');
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
	
	public function admin_index() {
		$this->layout = 'adminInner';
		
		if($this->request->is('post')){
			
			$reqdata = $this->request->data;
			//pr($reqdata); exit();
			if(!empty($id)){
				$this->FooterBlock->id = $reqdata['FooterBlock']['id'];
			} else {
				$this->FooterBlock->create();
			}
			$flag = $this->FooterBlock->save($reqdata);
			if($flag){
				$this->Session->setFlash('<p>Footer block Updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('<p>Failed to update footer block</p>', 'default', array('class' => 'alert alert-danger'));
			}
			$this->redirect(array('controller'=>'FooterBlocks', 'action'=>'admin_index'));	
			
		}
		
		
		$data = $this->FooterBlock->find('first');
		$id = (!empty($data))?$data['FooterBlock']['id']:'';
		$this->set(compact('data','id'));			
		
	}	
}
?>
