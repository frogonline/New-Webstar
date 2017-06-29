<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class CitiesController extends AppController 
{
	public $name = 'Cities';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('Cities','Countries','States');
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
			
			$likekeyArr = array('City');
			$conditionArr = array();
			foreach($data['Cities'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['Cities.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
							$conditionArr['Cities.'.$k] = $v; 
					}
				}
			}
			$conditionArr['Cities.isdel'] = 0;
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Cities.id' => 'DESC')
			);
			$this->set('searchData',$data);
		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('Cities.isdel'=>'0'),
					'order'=>array('Cities.id' => 'DESC')
					);
			
			}
		    $paginate1=$this->Countries->find('list', array(
			'fields'=>array('Countries.id', 'Countries.Country'),
			'conditions'=>array('Countries.isdel'=>'0') ) );
			
			$paginate2=$this->States->find('list', array(
			'fields'=>array('States.id', 'States.State'),
			'conditions'=>array('States.isdel'=>'0') ) );
			
			 $data=$this->paginate('Cities');
			 $this->set(compact('data', 'paginate1','paginate2')); 
	}
	
	public function admin_manage($id=NULL){	
		$this->layout = 'adminInner';
		$paginate2 = array();
		
		if($this->request->is('post')){	
			
			if($this->Cities->validates()){
				$data = $this->request->data;
				if($id != ''){
					$this->Cities->id = $id;
				} else{
					
					$this->Cities->create();
				}
				$data['Cities']['StateID'] = $this->request->data['Cities']['StateID'];
			
				$saveFlag = $this->Cities->save($data);
				$saveId = $this->Cities->id;
				if($saveFlag){
					if($id != ''){
						$this->Session->setFlash('City updated successfully.', 'default', array('class' => 'alert alert-success'));
					} else{
						$this->Session->setFlash('City added successfully', 'default', array('class' => 'alert alert-success'));
					}
				} else {
					$this->Session->setFlash('Failed to save the City', 'default', array('class' => 'alert alert-danger'));
				}
				if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'Cities','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'Cities','action'=>'admin_index'));
				}
				//$this->redirect(array('controller'=>'Cities','action'=>'admin_index'));
			} 
		}
		
		    $Countries=$this->Countries->find('list', array(
			'fields'=>array('Countries.id', 'Countries.Country'),
			'conditions'=>array('Countries.isdel'=>'0') ) );
			
			$this->set('id', $id);
			$this->set('paginate2', $paginate2);
			$this->set(compact('data','Countries','paginate2'));
			
			
		
		if(trim($id) !== ''){
		  $data = $this->Cities->findById($id);
		
		    $paginate2=$this->States->find('list', array(
			'fields'=>array('States.id', 'States.State'),
			'conditions'=>array('States.isdel'=>'0','States.id'=>$data['Cities']['StateID']) ) );
			$this->set('data', $data);
			$this->set(compact('data','Countries','paginate2'));
			
				
		}
				 
		
		
		
		
	}
	
	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Cities']['isdel'] = $isdel; 
		$this-> Cities->id = $id;
		$this-> Cities->save($data);
		$this->Session->setFlash('<p>City details has been deleted successfully!</p>', 'default', array('class' =>  'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_ajaxstate(){
		$this->layout = 'ajax';
		$data = $this->request->data;
		if(!empty($data)){
			$this->loadModel('State');
			$fetchData =  $this->State->find('list', 
				array(
					'conditions' =>array('State.isdel' => '0','State.CountryID' => $data['CountryID']),
					'fields' => array('id', 'State'),
					'order' => array('State' => 'ASC'),
				)
			);
		} else {
			$fetchData = array();
		}
		$this->set('states',$fetchData);
	}
	
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->Cities->findById($id);
			
			$data['Cities']['isdel'] = $stat;
			$this->Cities->id = $id;
			$deleteFlag = $this->Cities->save($data);
			if($deleteFlag){
				$this->Session->setFlash('<p>City removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>City removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Cities']['status'] = $stat;
		
		$this->Cities->id = $id;
		$this->Cities->save($data);
		$this->Session->setFlash('<p>City updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	

	
}
?>