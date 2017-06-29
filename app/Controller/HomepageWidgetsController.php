<?php 
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
/* class HomepageWidgetsController extends AppController 
{
	public $name = 'HomepageWidgets';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('HomepageWidget');
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
			foreach($data['HomepageWidget'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['HomepageWidget.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
						if(in_array($k,$datekeyArr)){
							$conditionArr['HomepageWidget.'.$k] = date('Y-m-d',strtotime($v)); 
						} else {
							$conditionArr['HomepageWidget.'.$k] = $v; 
						}
					}
				}
			}
			$conditionArr['HomepageWidget.is_del'] = 0; 
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('HomepageWidget.id' => 'DESC')
			);
			$this->set('searchData',$data);
		}  else {
			$this->paginate=array(
					'conditions' => array('HomepageWidget.is_del'=>'0'),
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'order'=>array('HomepageWidget.id' => 'DESC')
					);
			
		}
		$data=$this->paginate('HomepageWidget');
		$this->set('data', $data);
	}
	
	
	public function admin_delete($id=NULL,$stat = '1')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['HomepageWidget']['is_del'] = $stat;
		$this->HomepageWidget->id = $id;
		$this->HomepageWidget->save($data);
		$this->Session->setFlash('<p><strong>Success:&nbsp;</strong>The HomepageWidget has been successfully removed!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	public function admin_manage($id=NULL)
	{
		
		$this->layout = 'adminInner';
		
		if ($this->request->is('post')) 
		{	
			
			$this->HomepageWidget->set($this->request->data);
			
			
			if($this->HomepageWidget->validates()) 
			{
				if($this->request->data['HomepageWidget']['id'] !== ''){
					$this->HomepageWidget->id = $id;
					$this->request->data['HomepageWidget']['updated_date']	=	Date('Y-m-d');
				} else{
					//$this->HomepageWidget->create();
					
					$this->request->data['HomepageWidget']['created_date']	=	Date('Y-m-d');
					
					$this->HomepageWidget->create();
				}
		//	pr($this->request->data);exit();
				$this->HomepageWidget->save($this->request->data);
				
				if($this->request->data['HomepageWidget']['id'] !== ''){
					$this->Session->setFlash('<p><strong>Success:&nbsp;</strong>HomepageWidget Updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
					
				} else{
					$this->Session->setFlash('<p><strong>Success:&nbsp;</strong>HomepageWidget added successfully!</p>', 'default', array('class' => 'alert alert-success'));
					
				}
				$this->redirect('/admin/HomepageWidgets/index');
			} 
		}
		
		$this->set('id', $id);
		if($id !== NULL || $id !== ''){
			$data = $this->HomepageWidget->findById($id);
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
			
			$mydata['HomepageWidget']['banner_image']="";
			
			$this->HomepageWidget->id = $data['id'];
			$this->HomepageWidget->save($mydata);
			
			$this->Session->setFlash('<p><strong>Success:&nbsp;</strong>Image delete successfully!</p>', 'default', array('class' => 'alert alert-success'));
			
			$this->redirect('/admin/banners/manage/'.$data['id']);
		}
	}
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['HomepageWidget']['status'] = $stat;
		
		$this->HomepageWidget->id = $id;
		$this->HomepageWidget->save($data);
		$this->Session->setFlash('<p><strong>Success:&nbsp;</strong>HomepageWidget updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

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
			$data = $this->HomepageWidget->findById($id);
			$data['HomepageWidget']['is_del'] = $stat;
			$this->HomepageWidget->id = $id;
			$deleteFlag = $this->HomepageWidget->save($data);
			//$deleteFlag = $this->HomepageWidget->delete($id);
			if($deleteFlag){
				$this->Session->setFlash('<p><strong>Success:&nbsp;</strong>HomepageWidget removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p><strong>Success:&nbsp;</strong>HomepageWidget removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	} */
	
	/*public function home(){
		$this->theme = 'Nulife';
		$this->layout = 'home';
		$this->loadModel('HomepageWidget');
		$this->loadModel('Page');
		$bannerArray = $this->HomepageWidget->find('*',array('conditions'=>array('status'=>'Y','is_del'=>'0')));
		$cmsId = '22';
		$homeContent = $this->Page->find('*',array('conditions'=>array('id=>'.$cmsId.',is_active'=>'Y','is_del'=>'0')));
		$this->set(compact('bannerArray','homeContent'));
	}*/
//}	
?>