<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class CountriesController extends AppController 
{
	public $name = 'Countries';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('Countries');
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
			
			$likekeyArr = array('Country');
			$codekeyArr = array('code');
			$conditionArr = array();
			foreach($data['Countries'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['Countries.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
						if(in_array($k,$codekeyArr)){
							$conditionArr['Countries.'.$k.' LIKE'] = '%'.$v.'%';
						} else {
							$conditionArr['Countries.'.$k] = $v; 
						}
					}
				}
			}
			
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Countries.id' => 'DESC')
			);
			$this->set('searchData',$data);
		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('Countries.isdel'=>'0'),
					'order'=>array('Countries.id' => 'DESC')
					);
			
		}
		$data=$this->paginate('Countries');
		$this->set('data', $data);
	}
	
	public function admin_manage($id=NULL){	
		$this->layout = 'adminInner';
		
		if($this->request->is('post')){	
			
			if($this->Countries->validates()){
				$data = $this->request->data;
				if($id != ''){
					
					$this->Countries->id = $id;
				} else{
					
					$this->Countries->create();
				}
				
				$saveFlag = $this->Countries->save($data);
				$saveId = $this->Countries->id;
				if($saveFlag){
					if($id != ''){
						$this->Session->setFlash('Country updated successfully.', 'default', array('class' => 'alert alert-success'));
					} else{
						$this->Session->setFlash('Country added successfully', 'default', array('class' => 'alert alert-success'));
					}
				} else {
					$this->Session->setFlash('Failed to save the Country', 'default', array('class' => 'alert alert-danger'));
				}
				if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'Countries','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'Countries','action'=>'admin_index'));
				}
				//$this->redirect(array('controller'=>'Countries','action'=>'admin_index'));
			} 
		}
	
		
	$this->set('id', $id);
		if($id !== NULL || $id !== ''){
			$data = $this->Countries->findById($id);
			$this->set('data',$data);
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
		$data['Countries']['isdel'] = $isdel; 
		$this-> Countries->id = $id;
		$this-> Countries->save($data);
		$this->Session->setFlash('<p>Country details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->Countries->findById($id);
			
			
			$data['Countries']['isdel'] = $stat;
			$this->Countries->id = $id;
			$deleteFlag = $this->Countries->save($data);
			if($deleteFlag){
				$this->Session->setFlash('<p>Country removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Country removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Countries']['status'] = $stat;
		
		$this->Countries->id = $id;
		$this->Countries->save($data);
		$this->Session->setFlash('<p>Country updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	
	public function admin_checkDhead(){
		$this->layout = 'ajax';
		$qdata = $this->request->data['dhead']; 
	
		 $this->loadModel('Countries');
		echo $data = $this->Countries->find('count',
			array(
				'conditions'=>array(
					'Countries.Country'=>$qdata
				)
			)
		);
		exit(); 
	}
	
	
	public function admin_getListEmp(){
		$this->layout = 'ajax';
		$qdata = $this->params->query['query']; 
		$this->loadModel('Countries');
		$data = $this->Countries->find('all',
			array(
				'conditions'=>array(
					'Countries.Country LIKE'=>"%".$qdata."%",
					'Countries.isdel' => 0
				),
				'fields'=>'Countries.id,Countries.Country'
			)
		);
		pr($this->request->data);
		exit;
		$myArr = array();
		foreach($data as $dt){
			$obj = new stdClass();
			$obj->data = $dt['Countries']['id'];
			$obj->value = $dt['Countries']['Country'];
			array_push($myArr, $obj);
		}
		
		$arr = array('suggestions'=>$myArr);
		echo json_encode($arr);
		exit();
	}
}
?>