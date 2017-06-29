<?php 
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class ProductCategoriesController extends AppController 
{
	public $name = 'ProductCategories';
	public $components = array();
	public $helpers = array();
	public $uses = array();
	public $paginate = array();

	public function beforeFilter() 
	{
		parent::beforeFilter();
		$this->Auth->allow('ajaxProduct');
		
		if(isset($this->request->params['users'])){
			$this->Security->requireSecure();			
		}
		$this->Security->blackHoleCallback = 'blackhole';
	}
    
	public function blackhole($type) {
	
		// handle errors.
	}
	public function ajaxProduct(){
		$this->layout = 'ajax';
		$this->loadModel('MenuitemMaster');
		
		//echo count($products);
		//$itemData = $this->MenuitemMaster->findById($id);
		
		//$this->set('itemData',$itemData);
	}
	
	
	public function admin_index()
	{
		$this->layout = 'adminInner';
		
		if($this->request->is("post"))
		{
			$data = $this->request->data;
			
			$likekeyArr = array('name');
			
			$conditionArr = array();
			foreach($data['ProductCategory'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['ProductCategory.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
						$conditionArr['ProductCategory.'.$k] = $v; 
					}
				}
			}
			$conditionArr['ProductCategory.is_del'] = 0;
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('ProductCategory.id' => 'DESC')
			);
			$this->set('searchData',$data);
		} else {
			$this->paginate=array(
					'conditions' => array('ProductCategory.is_del'=>'0'),
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'order'=>array('ProductCategory.id' => 'DESC')
					);
			
		}
		$data=$this->paginate('ProductCategory');
		 
		$this->set('data', $data);
	}
	
	public function admin_delete($id=NULL,$stat = '1')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['ProductCategory']['is_del'] = $stat;
		$this->ProductCategory->id = $id;
		$this->ProductCategory->save($data);
		$this->Session->setFlash('<p>Product Category Removed successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	public function admin_manage($id=NULL)
	{
		$this->layout = 'adminInner';
		
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			
			if($this->ProductCategory->validates()) 
			{
				if(array_key_exists('category_image',$reqdata['ProductCategory'])){
					if($reqdata['ProductCategory']['category_image']['name']!="")
					{
						list($file1,$error1,$update_field1) = AppController::upload($reqdata['ProductCategory']['category_image'],WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'category_image'. DS . 'original' . DS ,'jpg,jpeg,JPG,JPEG,gif,GIF,png,PNG');
						
						if($file1 != ""){
							$image	=	new SimpleImage();
							
							$image->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'category_image'. DS . 'original' . DS .$file1); 
							$image_size=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'category_image'. DS . 'original' . DS .$file1,1348,626); 
							$image->resize($image_size['0'],$image_size['1']); 
							$image->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'category_image'. DS . 'resize' . DS .$file1); 
							
							$thumb	=	new SimpleImage();
							
							$thumb->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'category_image'. DS . 'original' . DS .$file1); 
							$image_size=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'category_image'. DS . 'original' . DS .$file1,160,145); 
							$thumb->resize($image_size['0'],$image_size['1']); 
							$thumb->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'category_image'. DS . 'thumb' . DS .$file1); 
							
							$reqdata['ProductCategory']['category_image'] = $file1;
						} else {
							$reqdata['ProductCategory']['category_image'] = "";
						}
					} else {
						$reqdata['ProductCategory']['category_image'] = "";
					}
				} else if($this->request->data['ProductCategory']['set_category_image']!=""){
					$reqdata['ProductCategory']['category_image'] = $reqdata['ProductCategory']['set_category_image'];
				}
				
				if(empty($reqdata['ProductCategory']['categories_slug'])){
					$slugArr = array('controller_name'=>'Products','action_name'=>'products');
					$reqdata['ProductCategory']['categories_slug'] = AppController::get_slug($reqdata['ProductCategory']['name'],$slugArr);
					
					$this->ProductCategory->id = $id;
				} else{
					$this->ProductCategory->create();
				}
				
				$reqdata['ProductCategory']['parent_id'] = (!empty($reqdata['ProductCategory']['parent_id']))?$reqdata['ProductCategory']['parent_id']:0;
				
				
				//pr($this->request->data);exit();
				$saveFlag = $this->ProductCategory->save($reqdata);
				$saveId = $this->ProductCategory->id;
				
				if($saveFlag){
					if(!empty($id)){
					$this->Session->setFlash('<p>Product Category Updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
					
					} else{
						$this->Session->setFlash('<p>Product Category added successfully!</p>', 'default', array('class' => 'alert alert-success'));
					}
				} else {
					$this->Session->setFlash('<p>Failed to add category!</p>', 'default', array('class' => 'alert alert-danger'));
				}
				if(array_key_exists('continue', $reqdata)){
					$this->redirect(array('controller'=>'ProductCategories','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'ProductCategories','action'=>'admin_index'));
				}
				
				//$this->redirect('/admin/ProductCategories/index');
			} else {
				$this->set('errors', $this->Product->invalidFields());
				$this->set($reqdata);
			}
		}
		
		
		if($id !== NULL || $id !== ''){
			$data = $this->ProductCategory->findById($id);
			$this->set('data',$data);
		}
		$categories = $this->ProductCategory->generateTreeList(null, null, null, '&nbsp;&nbsp;&nbsp;&nbsp;');
		$this->set(compact('id','categories')); 
	}
	
	public function admin_imgdelete( ){
		$data=$this->request->params['named'];
		//pr($data);exit();
		if($data['id']){
			$original_path=UPLOADS_FOLDER . DS .'category_image'. DS.'original'. DS .$data['image_name'];
			$resize_path=UPLOADS_FOLDER . DS .'category_image'. DS.'resize'. DS .$data['image_name'];
			$thumb_path=UPLOADS_FOLDER . DS .'category_image'. DS.'thumb'. DS .$data['image_name'];
			
			if(file_exists($original_path)){
				unlink($original_path);
			}
			if(file_exists($resize_path)){
				unlink($resize_path);
			}
			if(file_exists($thumb_path)){
				unlink($thumb_path);
			}
			
			$mydata['ProductCategory']['category_image']="";
			
			$this->ProductCategory->id = $data['id'];
			$this->ProductCategory->save($mydata);
			
			$this->Session->setFlash('<p>Image delete successfully!</p>', 'default', array('class' => 'alert alert-success'));
			
			$this->redirect('/admin/ProductCategories/manage/'.$data['id']);
		}
	}
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['ProductCategory']['category_status'] = $stat;
		
		$this->ProductCategory->id = $id;
		$this->ProductCategory->save($data);
		$this->Session->setFlash('<p>Product Category updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		//pr($id); exit();
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->ProductCategory->findById($id);
			
			/* if($data['ProductCategory']['category_image']!=""){
				$original_path=UPLOADS_FOLDER . DS .'category_image'. DS.'original'. DS .$data['ProductCategory']['category_image'];
				$resize_path=UPLOADS_FOLDER . DS .'category_image'. DS.'resize'. DS .$data['ProductCategory']['category_image'];
				$thumb_path=UPLOADS_FOLDER . DS .'category_image'. DS.'thumb'. DS .$data['ProductCategory']['category_image'];
				
				$file_original = new File($original_path, false, 0777);
				$file_original->delete();
				$file_resize = new File($resize_path, false, 0777);
				$file_resize->delete();
				$file_thumb = new File($thumb_path, false, 0777);
				$file_thumb->delete();
			} */
			$data['ProductCategory']['is_del'] = $stat;
			$this->ProductCategory->id = $id;
			$deleteFlag = $this->ProductCategory->save($data);
			//$deleteFlag = $this->ProductCategory->delete($id);
			if($deleteFlag){
				$this->Session->setFlash('<p>Product Category removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Product Category removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	public function admin_sequenceupdate(){
		$this->layout = 'ajax';
		$this->loadModel('ProductCategory');
		$reqdata=array();
		$data=array();
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			$data['ProductCategory']['sequence'] = $reqdata['sequence'];
			$data['ProductCategory']['id']= $reqdata['id'];
			//pr($data);
		 	$this->ProductCategory->save($data);
			echo "1";
			exit();
				
		}
	}
}	
?>