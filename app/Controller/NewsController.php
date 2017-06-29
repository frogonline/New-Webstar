<?php 
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class NewsController extends AppController 
{
	public $name = 'News';
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
		
		if($this->request->is("post"))
		{ 
			$data = $this->request->data;
			$likekeyArr = array('news_title');
			$datekeyArr = array('date_created', 'date_modified');
			$conditionArr = array();
			foreach($data['News'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['News.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
						if(in_array($k,$datekeyArr)){
							$conditionArr['News.'.$k] = date('Y-m-d',strtotime($v)); 
						} else {
							$conditionArr['News.'.$k] = $v; 
						}
					}
				}
			}
			$conditionArr['News.is_del'] = 0; 
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('News.id' => 'DESC')
			);
			$this->set('searchData',$data);

		} else {
		
		$this->paginate = array(
								'conditions' => array('News.is_del'=>'0'),
								'order' => array('News.id'=>'DESC'),
								'limit' => PAGINATION_PER_PAGE_LIMIT
							);
		}	
		$data = $this->paginate('News'); 
		$this->set('data', $data); 
	}
	
	public function admin_delete($id=NULL,$stat = '1')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['News']['is_del'] = $stat;
		$this->News->id = $id;
		$this->News->save($data);
		$this->Session->setFlash('<p>The News has been successfully removed!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	public function admin_manage($id=NULL)
	{
		
		$this->layout = 'adminInner';
		
		if ($this->request->is('post')) 
		{	
			
			//$this->News->set($this->request->data);
			
			
			if($this->News->validates()) 
			{
				$data = $this->request->data;
				if(array_key_exists('news_image', $this->request->data['News'])){
					if($this->request->data['News']['news_image']['name']!="")
					{
						list($file1,$error1,$update_field1) = AppController::upload($this->request->data['News']['news_image'],WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'news_image'. DS . 'original' . DS ,'jpg,jpeg,JPG,JPEG,gif,GIF,png,PNG');
						
						if($error1 == ""){
						$image	=	new SimpleImage();
						
						$image->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'news_image'. DS . 'original' . DS .$file1); 
						$image_size=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'news_image'. DS . 'original' . DS .$file1,1348,626); 
						$image->resize($image_size['0'],$image_size['1']); 
						$image->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'news_image'. DS . 'resize' . DS .$file1); 
						
						$thumb	=	new SimpleImage();
						
						$thumb->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'news_image'. DS . 'original' . DS .$file1); 
						$image_size=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'news_image'. DS . 'original' . DS .$file1,160,145); 
						$thumb->resize($image_size['0'],$image_size['1']); 
						$thumb->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'news_image'. DS . 'thumb' . DS .$file1); 
						
						$this->request->data['News']['news_image'] = $file1;
						}
						else{
							$this->request->data['News']['news_image'] = "";
						}
					}
					else if($this->request->data['News']['set_news_image']!="")
					{
						$this->request->data['News']['news_image'] = $this->request->data['News']['set_news_image'];
					}
				}
				
				
				if($this->request->data['News']['id'] !== ''){
					$this->News->id = $id;
					$this->request->data['News']['date_modified']	=	Date('Y-m-d');
				} else{
					//$this->News->create();
					
					$this->request->data['News']['date_created']	=	Date('Y-m-d');
					
					$this->News->create();
				}
		//	pr($this->request->data);exit();
				$this->News->save($this->request->data);
				$saveId = $this->News->id;
				
				if($this->request->data['News']['id'] !== ''){
					$this->Session->setFlash('<p>News Updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
					
				} else{
					$this->Session->setFlash('<p><strong>Success:&nbsp;</strong>News added successfully!</p>', 'default', array('class' => 'alert alert-success'));
					
				}
				if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'News','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'News','action'=>'admin_index'));
				}
				//$this->redirect('/admin/News/index');
			} 
		}
		
		$this->set('id', $id);
		if($id !== NULL || $id !== ''){
			$data = $this->News->findById($id);
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
			$original_path=UPLOADS_FOLDER . DS .'news_image'. DS.'original'. DS .$data['image_name'];
			$resize_path=UPLOADS_FOLDER . DS .'news_image'. DS.'resize'. DS .$data['image_name'];
			$thumb_path=UPLOADS_FOLDER . DS .'news_image'. DS.'thumb'. DS .$data['image_name'];
			
			if(file_exists($original_path)){
				unlink($original_path);
			}
			if(file_exists($resize_path)){
				unlink($resize_path);
			}
			if(file_exists($thumb_path)){
				unlink($thumb_path);
			}
			
			$mydata['News']['news_image']="";
			
			$this->News->id = $data['id'];
			$this->News->save($mydata);
			
			$this->Session->setFlash('<p>Image delete successfully!</p>', 'default', array('class' => 'alert alert-success'));
			
			$this->redirect('/admin/News/manage/'.$data['id']);
		}
	}
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['News']['news_status'] = $stat;
		
		$this->News->id = $id;
		$this->News->save($data);
		$this->Session->setFlash('<p>News updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

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
			$data = $this->News->findById($id);
			
			/* if($data['News']['news_image']!=""){
				$original_path=UPLOADS_FOLDER . DS .'news_image'. DS.'original'. DS .$data['News']['news_image'];
				$resize_path=UPLOADS_FOLDER . DS .'news_image'. DS.'resize'. DS .$data['News']['news_image'];
				$thumb_path=UPLOADS_FOLDER . DS .'news_image'. DS.'thumb'. DS .$data['News']['news_image'];
				
				$file_original = new File($original_path, false, 0777);
				$file_original->delete();
				$file_resize = new File($resize_path, false, 0777);
				$file_resize->delete();
				$file_thumb = new File($thumb_path, false, 0777);
				$file_thumb->delete();
			} */
			$data['News']['is_del'] = $stat;
			$this->News->id = $id;
			$deleteFlag = $this->News->save($data);
			//$deleteFlag = $this->News->delete($id);
			if($deleteFlag){
				$this->Session->setFlash('<p>News removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>News removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
}	
?>