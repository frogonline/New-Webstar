<?php 
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class OptionValuesController extends AppController 
{
	public $name = 'OptionValues';
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