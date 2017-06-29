<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
App::uses('AppController', 'Controller');

class PostTagsController extends AppController 
{
	public $name = 'PostTags';
	public $components = array();
	public $helpers = array('html','form', 'Js'=>'Jquery');
	public $uses =array('PostTags');
	public $paginate=array();
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		
		$this->Auth->allow();
		
		if(isset($this->request->params['users']))
		{
			$this->Security->requireSecure();
		}
		$this->Security->blackHoleCallback = 'blackhole';
	}
	public function blackhole($type)
	{
	
		// handle errors.
	}
	
	public function admin_index()
	{
		$this->layout = 'adminInner';
		if($this->request->is("post"))
		{ 
			$data = $this->request->data;
			$likekeyArr = array('tag_name');
			$conditionArr = array();
			foreach($data['PostTags'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['PostTags.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
							$conditionArr['PostTags.'.$k] = $v; 
					}
				}
			}
			$conditionArr['PostTags.isdel']=0;
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('PostTags.id' => 'DESC')
			);
			$this->set('searchData',$data);

		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('PostTags.isdel'=>'0'),
					'order'=>array('PostTags.id' => 'DESC')
					);
			}
		$data=$this->paginate('PostTags'); //pr($data); exit();
		$this->set('data', $data);
	}
	
	public function admin_manage($id=NULL)
	{
		$this->layout = 'adminInner';
		
		if($this->request->is('post')){	
		
		
		//$this->PostTags->set($this->request->data);

			if($this->PostTags->validates()){
				$data = $this->request->data;
				
				if(!empty($id)){
					$slugArr = array('controller_name'=>'Pages','action_name'=>'post_tags','mode'=>'edit','pre_slug_name'=>$data['PostTags']['tag_name']);
					$data['PostTags']['slug']=($data['PostTags']['slug'] != "")?$data['PostTags']['slug']:AppController::get_slug($data['PostTags']['tag_name'],$slugArr);
					
					$this->PostTags->id = $id;
				} else {
					$slugArr = array('controller_name'=>'Pages','action_name'=>'post_tags');
					$data['PostTags']['slug']=AppController::get_slug($data['PostTags']['tag_name'],$slugArr);
					
					$this->PostTags->create();
				}
				$this->PostTags->save($data);
				$saveId = $this->PostTags->id;
				
				/* if($id == ''){
					$slugArr = array('Model'=>'PostTags','field'=>'slug');
					$data['PostTags']['slug'] = AppController::get_slug($data['PostTags']['tag_name'],$slugArr);
										
					$this->request->data['PostTags']['created_date'] = date("Y-m-d");
					$this->PostTags->create();
					
				} else {
				$slugArr = array('Model'=>'PostTags','field'=>'slug');
					$data['PostTags']['slug']=($data['PostTags']['slug'] == $data['PostTags']['set_slug'])?$data['PostTags']['slug']:AppController::get_slug($data['PostTags']['slug'],$slugArr);
					
					$data['PostTags']['modified_date'] = date("Y-m-d");
					$this->PostTags->id = $id;
					
				} */
				
				
				/* if(!empty($id)){
					if($data['PostTags']['slug'] != $data['PostTags']['set_slug']){
						$dataSlug['mode'] = "edit";
						$dataSlug['slug_name'] = $data['PostTags']['slug'];
						$dataSlug['pre_slug_name'] = $data['PostTags']['set_slug'];
						AppController::saveSlug($dataSlug);
					}
				} else {
					//$this->PostTags->id = $id;
					$dataSlug['slug_name'] = $data['PostTags']['slug'];
					$dataSlug['controller_name'] = 'Pages';
					$dataSlug['action_name'] = 'post_tags';
					$dataSlug['table'] = 'post_tags';
					$dataSlug['table_id'] = $this->PostTags->id;
					AppController::saveSlug($dataSlug);
					
				} */
				
				if($this->PostTags->id == $id)
				{
					$this->Session->setFlash('<p>Post Tag has been updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
				} 
				else
				{
					$this->Session->setFlash('<p>Post Tag has been added successfully!</p>', 'default', array('class' => 'alert alert-success'));
				}
				if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'PostTags','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'PostTags','action'=>'admin_index'));
				}
				//$this->redirect(array('controller'=>'PostTags','action'=>'admin_index'));
				
			} 
		}
		$this->set('id',$id);
		//Set Data For Edit
		
		$model = ClassRegistry::init('PostTags');
			$faqcat = $model->find('list',
				array(
					'conditions' => array('PostTags.isdel'=>'0'),
					'fields'=>'PostTags.id'
				)
			);
		
		if($id !== NULL || $id !== '')
		{
			$data = $this->PostTags->findById($id);
			$this->set(compact('data'));
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
		

		$data['PostTags']['isdel'] = $isdel; 
		$this->PostTags->id = $id;
		$this->PostTags->save($data);
		$this->Session->setFlash('<p>Post Tag details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
		
	}
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['PostTags']['status'] = $stat;
		
		$this->PostTags->id = $id;
		$updateFlag = $this->PostTags->save($data);
		
		if($updateFlag){
			$this->Session->setFlash('PostTag status changed successfully!', 'default', array('class' => 'alert alert-success'));
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
		
		foreach($idArr as $id)
		{
			$data = $this->PostTags->findById($id);
			$data['PostTags']['isdel'] = $isdel; 
			$this->PostTags->id = $id;
			$deleteFlag = $this->PostTags->save($data);
			
			if($deleteFlag)
			{
				$this->Session->setFlash('The Post Tag has been successfully removed!', 'default', array('class' => 'alert alert-success'));
			} 
			else
			{
				$this->Session->setFlash('Failed to delete the Tag!', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());
	}
	
	
	
}
?>