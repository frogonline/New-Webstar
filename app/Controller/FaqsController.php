<?php
App::uses('AppController', 'Controller');

class FaqsController extends AppController {

	public $name = 'Faqs';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('Faq');
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
			$model = ClassRegistry::init('FaqCategory');
			$data = $this->request->data;
			
			$likekeyArr = array('faq_questions');
			$likekeyArr = array('faq_answers');
			$conditionArr = array();
			foreach($data['Faq'] as $k => $v){
				if( ($v != NULL) ){
					if(($k == 'status') || ($k == 'category_id')){
						$conditionArr['Faq.'.$k] = $v; 
					
					}else if( in_array($k,$likekeyArr) ){
						$conditionArr['Faq.'.$k.' LIKE'] = '%'.$v.'%';				
					
					} else {
							$conditionArr['Faq.'.$k] = $v; 
						}
					}
				}
			
			$conditionArr['Faq.isdel'] = 0; 
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Faq.id' => 'DESC')
			);
			$this->set('searchData',$data);

		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('Faq.isdel'=>'0'),
					'order'=>array('Faq.id' => 'DESC')
					);
			
		}
		
		$model = ClassRegistry::init('FaqCategory');
			$faqcat = $model->find('list',
				array(
					'conditions' => array('FaqCategory.isdel'=>'0'),
					'fields'=>'FaqCategory.id, FaqCategory.category'
				)
			);
			
		$data=$this->paginate('Faq');
		$this->set(compact('data', 'faqcat'));
		
		}
		
	public function admin_manage($id=NULL)
	{
		$this->layout = 'adminInner';
		
		if($this->request->is('post')){	
			
		//$this->Faq->set($this->request->data);
		

			if($this->Faq->validates()){
				$data = $this->request->data;
				if($id !== ''){
					$data['Faq']['modified_date'] = date("Y-m-d");
					$this->Faq->id = $id;
				} else{
					
					$this->request->data['Faq']['created_date'] = date("Y-m-d");
					$this->Faq->create();
				}
				$this->Faq->save($this->request->data);
				$saveId = $this->Faq->id;

				if($this->Faq->id == $id)
				{
					$this->Session->setFlash('<p>FAQ has been updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
				} 
				else
				{
					$this->Session->setFlash('<p>FAQ has been added successfully!</p>', 'default', array('class' => 'alert alert-success'));
				}
				if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'Faqs','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'Faqs','action'=>'admin_index'));
				}	
				//$this->redirect(array('controller'=>'Faqs','action'=>'admin_index'));
				
			} 
		}
		$this->set('id',$id);
		//Set Data For Edit
		
		$model = ClassRegistry::init('FaqCategory');
			$faqcat = $model->find('list',
				array(
					'conditions' => array('FaqCategory.isdel'=>'0'),
					'fields'=>'FaqCategory.id, FaqCategory.category'
				)
			);
		
		if($id !== NULL || $id !== '')
		{
			$data = $this->Faq->findById($id);
			$this->set(compact('data', 'faqcat'));
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
		

		$data['Faq']['isdel'] = $isdel; 
		$this->Faq->id = $id;
		$this->Faq->save($data);
		$this->Session->setFlash('<p>Faq details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
		
	}
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Faq']['status'] = $stat;
		
		$this->Faq->id = $id;
		$updateFlag = $this->Faq->save($data);
		
		if($updateFlag){
			$this->Session->setFlash('FAQ status changed successfully!', 'default', array('class' => 'alert alert-success'));
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
			
			$data['Faq']['isdel'] = $isdel; 
			$this->Faq->id = $id;
			$deleteFlag = $this->Faq->save($data);
			
			if($deleteFlag){
				$this->Session->setFlash('The FAQ has been successfully removed!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete the FAQ!', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());
	}
}
?>