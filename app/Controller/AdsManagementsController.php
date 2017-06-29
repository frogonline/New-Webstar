<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class AdsManagementsController extends AppController 
{
	public $name = 'AdsManagements';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('AdsManagement');
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
			
			$likekeyArr = array('title');
			$conditionArr = array();
			foreach($data['AdsManagement'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['AdsManagement.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
						 
							$conditionArr['AdsManagement.'.$k] = $v; 
						
					}
				}
			}
			
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('AdsManagement.id' => 'DESC')
			);
			$this->set('searchData',$data);
		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('AdsManagement.isdel'=>'0'),
					'order'=>array('AdsManagement.id' => 'DESC')
					);
			
		}
		$data=$this->paginate('AdsManagement');
		$this->set('data', $data);
		
	}

	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['AdsManagement']['isdel'] = $isdel; 
		$this-> AdsManagement->id = $id;
		$this-> AdsManagement->save($data);
		$this->Session->setFlash('<p>Ads Management details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}



public function admin_manage($id=NULL)	
		{
		
		$this->layout = 'adminInner';
		
		if ($this->request->is('post')) 
		{	
			
			//$this->AdsManagements->set($this->request->data);
			
			$data = $this->request->data;
			if($this->AdsManagement->validates()) 
			{
				if(array_key_exists('image_ads', $this->request->data['AdsManagement'])){
					if($this->request->data['AdsManagement']['image_ads']['name']!="")
					{
						list($file1,$error1,$update_field1) = AppController::upload($this->request->data['AdsManagement']['image_ads'],WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'image_ads'. DS . 'original' . DS ,'jpg,jpeg,JPG,JPEG,gif,GIF,png,PNG');
						
						if($error1 == ""){
						$image	=	new SimpleImage();
						
						$image->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'image_ads'. DS . 'original' . DS .$file1); 
						$image_size=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'image_ads'. DS . 'original' . DS .$file1,1348,626); 
						$image->resize($image_size['0'],$image_size['1']); 
						$image->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'image_ads'. DS . 'resize' . DS .$file1); 
						
						$thumb	=	new SimpleImage();
						
						$thumb->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'image_ads'. DS . 'original' . DS .$file1); 
						$image_size=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'image_ads'. DS . 'original' . DS .$file1,160,145); 
						$thumb->resize($image_size['0'],$image_size['1']); 
						$thumb->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'image_ads'. DS . 'thumb' . DS .$file1); 
						
						$this->request->data['AdsManagement']['image_ads'] = $file1;
						}
						else{
							$this->request->data['AdsManagement']['image_ads'] = "";
						}
					}
					else if($this->request->data['AdsManagement']['set_image_ads']!="")
					{
						$this->request->data['AdsManagement']['image_ads'] = $this->request->data['AdsManagement']['set_image_ads'];
					} 
					else{
						$this->request->data['AdsManagement']['image_ads'] = "";
						
					}
				}
				
				
				if($this->request->data['AdsManagement']['id'] !== ''){
					$this->AdsManagement->id = $id;
					$this->request->data['AdsManagement']['modified_date']	=	Date('Y-m-d');
				} else{
				
					
					$this->request->data['AdsManagement']['created_date']	=	Date('Y-m-d');
					
					$this->AdsManagement->create();
				}
				//	pr($this->request->data);exit();
		
				$this->AdsManagement->save($this->request->data);
				$saveId = $this->AdsManagement->id;
				if($this->request->data['AdsManagement']['id'] !== ''){
					$this->Session->setFlash('<p>Record updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
				} else{
					$this->Session->setFlash('<p>Record added successfully!</p>', 'default', array('class' => 'alert alert-success'));
				}
				if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'AdsManagements','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'AdsManagements','action'=>'admin_index'));
				}
				//$this->redirect('/admin/AdsManagements/index');
			} 
		}
		
		$this->set('id', $id);
		if($id !== NULL || $id !== ''){
			$data = $this->AdsManagement->findById($id);
			$this->set('data',$data);
		}
		if(!$id)
		{
			$data	=	$this->request->data;
			$this->set('data',$data);
		}
	}
	
	
	public function admin_imgdelete($img_name=NULL, $id=NULL){
		$this->layout = '';
		$this->autoRender = false;
		if(!empty($img_name)){
			$original_path=UPLOADS_FOLDER . DS .'image_ads'. DS.'original'. DS .$img_name;
			$resize_path=UPLOADS_FOLDER . DS .'image_ads'. DS.'resize'. DS .$img_name;
			$thumb_path=UPLOADS_FOLDER . DS .'image_ads'. DS.'thumb'. DS .$img_name;
			
			if(file_exists($original_path)){
				unlink($original_path);
			}
			if(file_exists($resize_path)){
				unlink($resize_path);
			}
			if(file_exists($thumb_path)){
				unlink($thumb_path);
			}
			
			$mydata['AdsManagement']['image_ads']="";
			
			$this->AdsManagement->id = $id;
			$this->AdsManagement->save($mydata);
			
			$this->Session->setFlash('<p>Image delete successfully!</p>', 'default', array('class' => 'alert alert-success'));
			
			$this->redirect('/admin/AdsManagements/manage/'.$id);
		}
	}
	
	
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		//pr($id); exit();
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->AdsManagement->findById($id);
			
			$data['AdsManagement']['isdel'] = $stat;
			$this->AdsManagement->id = $id;
			$deleteFlag = $this->AdsManagement->save($data);
			//$deleteFlag = $this->News->delete($id);
			if($deleteFlag){
				$this->Session->setFlash('<p>Advertisement removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Advertisement removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['AdsManagement']['status'] = $stat;
		
		$this->AdsManagement->id = $id;
		$this->AdsManagement->save($data);
		$this->Session->setFlash('<p>Advertisement updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
}
?>