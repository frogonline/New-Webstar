<?php
App::uses('AppController', 'Controller');

class GalleryImagesController extends AppController {

	public $name = 'GalleryImages';
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
}
?>