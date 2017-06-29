<?php
App::uses('AppController', 'Controller');

class CmsSectionsController extends AppController {

	public $name = 'CmsSections';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('CmsSection');
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
			$this->paginate = array(
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('CmsSection.id' => 'DESC')
			);
			$this->set('searchData',$data);

		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('CmsSection.isdel'=>'0'),
					'order'=>array('CmsSection.id' => 'DESC')
					);
			
		}
		$data=$this->paginate('CmsSection');
		$this->set('data', $data);
	}
	
	public function admin_manage($id=NULL){	
		$this->layout = 'adminInner';
		
		if($this->request->is('post')){	
			
			if($this->CmsSection->validates()){
				$data = $this->request->data;
				if($id !== ''){
					$data['CmsSection']['modified_date'] = date("Y-m-d");
					$this->CmsSection->id = $id;
				} else{
					
					$this->request->data['CmsSection']['created_date'] = date("Y-m-d");
					$this->CmsSection->create();
				}
				
				
				$this->CmsSection->save($this->request->data);
				
				if($this->CmsSection->id == $id)
				{
					$this->Session->setFlash('<p>Cms Section details has been updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
				} 
				else
				{
					$this->Session->setFlash('<p>Cms Section details has been added successfully!</p>', 'default', array('class' => 'alert alert-success'));
				}
				$this->redirect(array('controller'=>'CmsSections','action'=>'admin_index'));
				
			} 
		}
		$this->set('id',$id);
		//Set Data For Edit
		if($id !== NULL || $id !== '')
		{
			$data = $this->CmsSection->findById($id);
			$this->set('data', $data);
		}
		
	}
	
	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['CmsSection']['isdel'] = $isdel; 
		$this->CmsSection->id = $id;
		$this->CmsSection->save($data);
		$this->Session->setFlash('<p> Cms Section details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['CmsSection']['status'] = $stat;
		
		$this->CmsSection->id = $id;
		$updateFlag = $this->CmsSection->save($data);
		
		if($updateFlag){
			$this->Session->setFlash('Cms Section status changed successfully!', 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('Failed to change status!', 'default', array('class' => 'alert alert-danger'));
		}
		$this->redirect($this->referer());
	}
	
	public function admin_deleteAll($idAll=NULL, $isdel='0')
	{	
		//pr($id); exit();
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			
			$data['CmsSection']['isdel'] = $isdel; 
			$this->CmsSection->id = $id;
			$deleteFlag = $this->CmsSection->save($data);
			
			if($deleteFlag){
				$this->Session->setFlash('The Cms Section has been successfully removed!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete the Cms Section!', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
}
	?>