<?php 
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class CmsBannersController extends AppController 
{
	public $name = 'CmsBanners';
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

	public function admin_index(){
		$this->layout = 'adminInner';
		
		$this->paginate = array(
								'conditions' => array('CmsBanner.is_del'=>'0'),
								'order' => array('CmsBanner.banner_name ASC'),
								'limit' => PAGINATION_PER_PAGE_LIMIT
							);
			
		$data = $this->paginate('CmsBanner'); 
		$this->set('data', $data); 
	}
	
	public function admin_delete($id=NULL,$stat = '1')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['CmsBanner']['is_del'] = $stat;
		$this->CmsBanner->id = $id;
		$this->CmsBanner->save($data);
		$this->Session->setFlash('<p>The Banner has been successfully removed!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	public function admin_manage($id=NULL)
	{
		
		$this->layout = 'adminInner';
		
		if ($this->request->is('post')) 
		{	
			
			$this->CmsBanner->set($this->request->data);
			
			
			if($this->CmsBanner->validates()) 
			{
				if($this->request->data['CmsBanner']['banner_image']['name']!="")
				{
					list($file1,$error1,$update_field1) = AppController::upload($this->request->data['CmsBanner']['banner_image'],WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'cms_banner_image'. DS . 'original' . DS ,'jpg,jpeg,JPG,JPEG,gif,GIF,png,PNG');
					
					if($error1 == ""){
					$image	=	new SimpleImage();
					
					$image->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'cms_banner_image'. DS . 'original' . DS .$file1); 
					$image_size=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'cms_banner_image'. DS . 'original' . DS .$file1,1348,626); 
					$image->resize($image_size['0'],$image_size['1']); 
					$image->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'cms_banner_image'. DS . 'resize' . DS .$file1); 
					
					$thumb	=	new SimpleImage();
					
					$thumb->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'cms_banner_image'. DS . 'original' . DS .$file1); 
					$image_size=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'cms_banner_image'. DS . 'original' . DS .$file1,160,145); 
					$thumb->resize($image_size['0'],$image_size['1']); 
					$thumb->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'cms_banner_image'. DS . 'thumb' . DS .$file1); 
					
					$this->request->data['CmsBanner']['banner_image'] = $file1;
					}
					else{
						$this->request->data['CmsBanner']['banner_image'] = "";
					}
				}
				
				else if($this->request->data['CmsBanner']['set_banner_image']!="")
				{
					$this->request->data['CmsBanner']['banner_image'] = $this->request->data['CmsBanner']['set_banner_image'];
				}
				
				
				
				if($this->request->data['CmsBanner']['id'] !== ''){
					$this->CmsBanner->id = $id;
					$this->request->data['CmsBanner']['date_modified']	=	Date('Y-m-d');
				} else{
					//$this->Banner->create();
					
					$this->request->data['CmsBanner']['date_created']	=	Date('Y-m-d');
					
					$this->CmsBanner->create();
				}
		//	pr($this->request->data);exit();
				$this->CmsBanner->save($this->request->data);
				
				if($this->request->data['CmsBanner']['id'] !== ''){
					$this->Session->setFlash('<p>Banner Updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
					
				} else{
					$this->Session->setFlash('<p>Banner added successfully!</p>', 'default', array('class' => 'alert alert-success'));
					
				}
				$this->redirect('/admin/CmsBanners/index');
			} 
		}
		
		$this->set('id', $id);
		if($id !== NULL || $id !== ''){
			$data = $this->CmsBanner->findById($id);
			$this->set('data',$data);
		}
		if(!$id)
		{
			$data	=	$this->request->data;
			$this->set('data',$data);
		}
	}
	public function admin_imgdelete( ){
		$data=$this->request->params['named'];
		//pr($data);exit();
		if($data['id']){
			$original_path=UPLOADS_FOLDER . DS .'cms_banner_image'. DS.'original'. DS .$data['image_name'];
			$resize_path=UPLOADS_FOLDER . DS .'cms_banner_image'. DS.'resize'. DS .$data['image_name'];
			$thumb_path=UPLOADS_FOLDER . DS .'cms_banner_image'. DS.'thumb'. DS .$data['image_name'];
			
			if(file_exists($original_path)){
				unlink($original_path);
			}
			if(file_exists($resize_path)){
				unlink($resize_path);
			}
			if(file_exists($thumb_path)){
				unlink($thumb_path);
			}
			
			$mydata['CmsBanner']['banner_image']="";
			
			$this->CmsBanner->id = $data['id'];
			$this->CmsBanner->save($mydata);
			
			$this->Session->setFlash('<p>Image delete successfully!</p>', 'default', array('class' => 'alert alert-success'));
			
			$this->redirect('/admin/CmsBanners/manage/'.$data['id']);
		}
	}
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['CmsBanner']['banner_status'] = $stat;
		
		$this->CmsBanner->id = $id;
		$this->CmsBanner->save($data);
		$this->Session->setFlash('<p>Banner updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

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
			$data = $this->CmsBanner->findById($id);
			$data['CmsBanner']['is_del'] = $stat;
			$this->CmsBanner->id = $id;
			$deleteFlag = $this->CmsBanner->save($data);
			//$deleteFlag = $this->Banner->delete($id);
			if($deleteFlag){
				$this->Session->setFlash('<p>Banner removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Banner removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
}	
?>