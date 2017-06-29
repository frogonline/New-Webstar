<?php 
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class BannersController extends AppController 
{
	public $name = 'Banners';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('Banner');
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
			$likekeyArr = array('banner_name');
			$datekeyArr = array('date_created', 'date_modified');
			$conditionArr = array();
			foreach($data['Banner'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['Banner.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
						if(in_array($k,$datekeyArr)){
							$conditionArr['Banner.'.$k] = date('Y-m-d',strtotime($v)); 
						} else {
							$conditionArr['Banner.'.$k] = $v; 
						}
					}
				}
			}
			$conditionArr['Banner.is_del'] = 0; 
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Banner.id' => 'DESC')
			);
			$this->set('searchData',$data);
		} else {
			$this->paginate=array(
					'conditions' => array('Banner.is_del'=>'0'),
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'order'=>array('Banner.id' => 'DESC')
					);
			
		}
		$data=$this->paginate('Banner');
		$this->set('data', $data);
	}
	
	
	public function admin_delete($id=NULL,$stat = '1')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Banner']['is_del'] = $stat;
		$this->Banner->id = $id;
		$this->Banner->save($data);
		$this->Session->setFlash('<p>The Banner has been successfully removed!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	public function admin_manage($id=NULL)
	{
		
		$this->layout = 'adminInner';
		
		if ($this->request->is('post')) 
		{	
			
			$this->Banner->set($this->request->data);
			
			
			if($this->Banner->validates()) 
			{
				//print_r($_FILES);die();
				if(isset($this->request->data['Banner']['banner_image']))
				{
					list($file1,$error1,$update_field1) = AppController::upload($this->request->data['Banner']['banner_image'],WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'banner_image'. DS . 'original' . DS ,'jpg,jpeg,JPG,JPEG,gif,GIF,png,PNG');
					
					if($error1 == ""){
					$image	=	new SimpleImage();
					
					$image->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'banner_image'. DS . 'original' . DS .$file1); 
					$image_size=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'banner_image'. DS . 'original' . DS .$file1,1348,626); 
					$image->resize($image_size['0'],$image_size['1']); 
					$image->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'banner_image'. DS . 'resize' . DS .$file1); 
					
					$thumb	=	new SimpleImage();
					
					$thumb->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'banner_image'. DS . 'original' . DS .$file1); 
					$image_size=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'banner_image'. DS . 'original' . DS .$file1,160,145); 
					$thumb->resize($image_size['0'],$image_size['1']); 
					$thumb->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'banner_image'. DS . 'thumb' . DS .$file1); 
					
					$this->request->data['Banner']['banner_image'] = $file1;
					}
					else{
						$this->request->data['Banner']['banner_image'] = "";
					}
				}
				
				else if($this->request->data['Banner']['set_banner_image']!="")
				{
					$this->request->data['Banner']['banner_image'] = $this->request->data['Banner']['set_banner_image'];
				}
				
				
				
				if($this->request->data['Banner']['id'] !== ''){
					$this->Banner->id = $id;
					$this->request->data['Banner']['date_modified']	=	Date('Y-m-d');
				} else{
					//$this->Banner->create();
					
					$this->request->data['Banner']['date_created']	=	Date('Y-m-d');
					
					$this->Banner->create();
				}
			///pr($this->request->data);exit();
				$this->Banner->save($this->request->data);
				$saveId = $this->Banner->id;
				
				if($this->request->data['Banner']['id'] !== ''){
					$this->Session->setFlash('<p>Banner Updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
					
				} else{
					$this->Session->setFlash('<p>Banner added successfully!</p>', 'default', array('class' => 'alert alert-success'));
					
				}
				
				if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'Banners','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'Banners','action'=>'admin_index'));
				}
				//$this->redirect('/admin/Banners/index');
			} 
		}
		
		$this->set('id', $id);
		if($id !== NULL || $id !== ''){
			$data = $this->Banner->findById($id);
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
			$original_path=UPLOADS_FOLDER . DS .'banner_image'. DS.'original'. DS .$data['image_name'];
			$resize_path=UPLOADS_FOLDER . DS .'banner_image'. DS.'resize'. DS .$data['image_name'];
			$thumb_path=UPLOADS_FOLDER . DS .'banner_image'. DS.'thumb'. DS .$data['image_name'];
			
			if(file_exists($original_path)){
				unlink($original_path);
			}
			if(file_exists($resize_path)){
				unlink($resize_path);
			}
			if(file_exists($thumb_path)){
				unlink($thumb_path);
			}
			
			$mydata['Banner']['banner_image']="";
			
			$this->Banner->id = $data['id'];
			$this->Banner->save($mydata);
			
			$this->Session->setFlash('<p>Image delete successfully!</p>', 'default', array('class' => 'alert alert-success'));
			
			$this->redirect('/admin/banners/manage/'.$data['id']);
		}
	}
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Banner']['banner_status'] = $stat;
		
		$this->Banner->id = $id;
		$this->Banner->save($data);
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
			$data = $this->Banner->findById($id);
			$data['Banner']['is_del'] = $stat;
			$this->Banner->id = $id;
			$deleteFlag = $this->Banner->save($data);
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