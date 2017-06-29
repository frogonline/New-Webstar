<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class PostCategoriesController extends AppController 
{
	public $name = 'PostCategories';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('PostCategory','Slug');
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
			$likekeyArr = array('category_name');
			$conditionArr = array();
			foreach($data['PostCategory'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['PostCategory.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
							$conditionArr['PostCategory.'.$k] = $v; 
					}
				}
			}
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('PostCategory.id' => 'DESC')
			);
			$this->set('searchData',$data);

		} else {
			$this->paginate = array(
									'order' => array('PostCategory.id' => 'DESC'),
									'limit' => PAGINATION_PER_PAGE_LIMIT
								);
			}
		$data=$this->paginate('PostCategory'); //pr($data); exit();
		$this->set('data', $data);
	}
	
	public function admin_manage($id=NULL)
	{	
		$this->layout = 'adminInner';
		
		if ($this->request->is('post')){
			if($this->PostCategory->validates()){
				$data = $this->request->data;
				
				if(!empty($id)){
					$slugArr = array('controller_name'=>'Pages','action_name'=>'post_category','mode'=>'edit','pre_slug_name'=>$data['PostCategory']['category_name']);
					$data['PostCategory']['slug']=($data['PostCategory']['slug'] != "")?$data['PostCategory']['slug']:AppController::get_slug($data['PostCategory']['category_name'],$slugArr);
					
					$this->PostCategory->id = $id;
				} else {
					$slugArr = array('controller_name'=>'Pages','action_name'=>'post_category');
					$data['PostCategory']['slug']=AppController::get_slug($data['PostCategory']['category_name'],$slugArr);
					
					$this->PostCategory->create();
				}
				
				$saveFlag = $this->PostCategory->save($data);
				$saveId = $this->PostCategory->id;
				if($saveFlag){
					if(!empty($id)){
						$this->Session->setFlash('Post Category updated successfully!', 'default', array('class' => 'alert alert-success'));
					} else {
						$this->Session->setFlash('Post Category added successfully!', 'default', array('class' => 'alert alert-success'));
					}
				} else {
					$this->Session->setFlash('Failed to add post category!', 'default', array('class' => 'alert alert-success'));
				}
				
				if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'PostCategories','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'PostCategories','action'=>'admin_index'));
				}
			}
		}
		
		$this->set('id', $id);
		if(trim($id) != ''){
			$data = $this->PostCategory->findById($id);
			$this->set('data', $data);
		}
		
	}
	
	public function admin_deleteAll($idAll=NULL)
	{	
		//pr($id); exit();
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->PostCategory->findById($id);
			$deleteFlag = $this->PostCategory->delete($id);
			
			if($deleteFlag){
				$dltSlugFlag = $this->Slug->deleteAll(array('Slug.slug_name'=>$data['PostCategory']['slug']));
				if($dltSlugFlag) {
					$this->Session->setFlash('The post category has been successfully removed!', 'default', array('class' => 'alert alert-success'));
				} else {
					$this->Session->setFlash('The post category has been successfully removed! But failed to delete the slug.', 'default', array('class' => 'alert alert-danger'));
				}
			} else {
				$this->Session->setFlash('Failed to delete the post category!', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	public function admin_delete($id=NULL) {	
		$this->layout = '';
		$this->autoRender = false;
		
		$data = $this->PostCategory->findById($id);
		
		$deleteFlag = $this->PostCategory->delete($id);
		
		if($deleteFlag){
			$dltSlugFlag = $this->Slug->deleteAll(array('Slug.slug_name'=>$data['PostCategory']['slug']));
			if($dltSlugFlag) {
				$this->Session->setFlash('The post category has been successfully removed!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('The post category has been successfully removed! But failed to delete the slug.', 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$this->Session->setFlash('Failed to delete the post category!', 'default', array('class' => 'alert alert-danger'));
			break;
		}
		$this->redirect($this->referer());
	}
	
	public function admin_status($id=NULL,$stat = 'N'){	
		$this->layout = '';
		$this->autoRender = false;
		$data['PostCategory']['status'] = $stat;
		
		$this->PostCategory->id = $id;
		$updateFlag = $this->PostCategory->save($data);
		
		if($updateFlag){
			$this->Session->setFlash('Post status changed successfully!', 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('Failed to change status!', 'default', array('class' => 'alert alert-danger'));
		}
		$this->redirect($this->referer());
	}
	
}
?>