<?php
App::uses('AppController', 'Controller');

class FaqCategoriesController extends AppController {

	public $name = 'FaqCategories';
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
			$likekeyArr = array('category');
			$datekeyArr = array('created_date');
			$conditionArr = array();
			foreach($data['FaqCategory'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['FaqCategory.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
						if(in_array($k,$datekeyArr)){
							$conditionArr['FaqCategory.'.$k] = date('Y-m-d',strtotime($v)); 
							} else {
							$conditionArr['FaqCategory.'.$k] = $v; 
						}
					}
				}
			}
			$conditionArr['FaqCategory.isdel'] = 0; 
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('FaqCategory.id' => 'DESC')
			);
			$this->set('searchData',$data);

		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('FaqCategory.isdel'=>'0'),
					'order'=>array('FaqCategory.id' => 'DESC')
					);
			
		}
		$data = $this->paginate('FaqCategory');
		$this->set('data', $data);
		
	}
	/* public function admin_index()
	{
		$this->layout = 'adminInner';
	
		$this->paginate = array(	
									'conditions'=>array('FaqCategory.isdel'=>'0'),
									'order' => array('FaqCategory.id' => 'DESC'),
									'limit' => PAGINATION_PER_PAGE_LIMIT
								);
									
		$data = $this->paginate('FaqCategory'); 
		
		$this->set('data', $data);
	}  */
		
	public function admin_manage($id=NULL)
	{
		$this->layout = 'adminInner';
		
		if($this->request->is('post')){	
		
		//$this->FaqCategory->set($this->request->data);
		
			if($this->FaqCategory->validates()){
				$data = $this->request->data;
				if($id !== ''){
					$data['FaqCategory']['modified_date'] = date("Y-m-d");
					$this->FaqCategory->id = $id;
				} else{
					
					$this->request->data['FaqCategory']['created_date'] = date("Y-m-d");
					$this->FaqCategory->create();
				}
				$saveFlag = $this->FaqCategory->save($this->request->data);
				$saveId = $this->FaqCategory->id;
		
		if($saveFlag){
				if($id != '')
				{
					$this->Session->setFlash('<p>FAQ Category has been updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
				} 
				else
				{
					$this->Session->setFlash('<p>FAQ Category has been added successfully!</p>', 'default', array('class' => 'alert alert-success'));
				}
			} else {
				$this->Session->setFlash('Failed to save the FAQ Category', 'default', array('class' => 'alert alert-danger'));
			}			
				if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'FaqCategories','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'FaqCategories','action'=>'admin_index'));
				}	//$this->redirect(array('controller'=>'FaqCategories','action'=>'admin_index'));
				
			} 
		}
		$this->set('id',$id);
		//Set Data For Edit
		
		if($id !== NULL || $id !== '')
		{
			$data = $this->FaqCategory->findById($id);
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
		
		$count=0;
		$this->loadModel('Faq');
		$count = $count + $this->Faq->find('count',
													array('conditions' => 
														array('Faq.category_id' => $id, 
																'Faq.isdel' => '0')
													)
												);
		if($count > 0)
		{
			$this->Session->setFlash('<p>Failed to delete this category since it is used in other places of this system!</p>', 'default', array('class' => 'alert alert-success'));
		} 
		else 
		{		
		$data['FaqCategory']['isdel'] = $isdel; 
		$this->FaqCategory->id = $id;
		$this->FaqCategory->save($data);
		$this->Session->setFlash('<p>FAQ Category has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		}
		
		$this->redirect($this->referer());	
		
	}
	
	public function admin_status($id=NULL, $stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['FaqCategory']['status'] = $stat;
		
		$this->FaqCategory->id = $id;
		$updateFlag = $this->FaqCategory->save($data);
		
		if($updateFlag){
			$this->Session->setFlash('FAQ Category status changed successfully!', 'default', array('class' => 'alert alert-success'));
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
			
			$data['FaqCategory']['isdel'] = $isdel; 
			$this->FaqCategory->id = $id;
			$deleteFlag = $this->FaqCategory->save($data);
			
			if($deleteFlag){
				$this->Session->setFlash('The FAQ Category has been successfully removed!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete the FAQ Category!', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());
	}
	
}
?>