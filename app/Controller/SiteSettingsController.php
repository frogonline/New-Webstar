<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class SiteSettingsController extends AppController 
{
	public $name = 'SiteSettings';
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
	
	public function admin_index($id=NULL)
	{	
		$this->layout = 'adminInner';
		
		if ($this->request->is('post')) 
		{	
			if($this->SiteSetting->validates()) 
			{
				$reqdata = $this->request->data;
				
				if(isset($reqdata['SiteSetting']['logo']))
				{
					$returnfile = $this->doupload($reqdata['SiteSetting']['logo'],WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'site_settings_logo'. DS . 'original' . DS );
					
					if($returnfile['error'] == ""){
						$reqdata['SiteSetting']['logo'] = $returnfile['filename'];
					}
					else{
						$reqdata['SiteSetting']['logo'] = "";
					}
				} else if(isset($reqdata['SiteSetting']['set_logo'])) {
					$reqdata['SiteSetting']['logo'] = $reqdata['SiteSetting']['set_logo'];
				} else {
					$reqdata['SiteSetting']['logo'] = "";
				}
				
				/* if(isset($reqdata['SiteSetting']['footer_logo']))
				{
					$returnfile = $this->doupload($reqdata['SiteSetting']['footer_logo'],WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'footer_logo'. DS . 'original' . DS );
					if($returnfile['error'] == ""){
						$reqdata['SiteSetting']['footer_logo'] = $returnfile['filename'];
					}
					else{
						$reqdata['SiteSetting']['footer_logo'] = "";
					}
				}
				else if($this->request->data['SiteSetting']['set_footer_logo']!="")
				{
					$reqdata['SiteSetting']['footer_logo'] = $reqdata['SiteSetting']['set_footer_logo'];
				}  */
				/* pr($reqdata); 
				pr($reqdata['SiteSetting']['admin_logo']);
				echo WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'admin_logo'. DS . 'original' . DS ;
				exit(); */
				/* if( isset($reqdata['SiteSetting']['admin_logo']) )
				{
					
					$returnfile = $this->doupload($reqdata['SiteSetting']['admin_logo'],WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'admin_logo'. DS . 'original' . DS );
					
					
					if($returnfile['error'] == ""){
						$reqdata['SiteSetting']['admin_logo'] = $returnfile['filename'];
					}
					else{
						$reqdata['SiteSetting']['admin_logo'] = "";
					}
				}
				else if($reqdata['SiteSetting']['set_admin_logo']!="")
				{
					$reqdata['SiteSetting']['admin_logo'] = $reqdata['SiteSetting']['set_admin_logo'];
				} */
				
				
				if($reqdata['SiteSetting']['id'] !== ''){
					$this->SiteSetting->id = $id;
					$reqdata['SiteSetting']['date_modified']	=	Date('Y-m-d');
				} else{
					$reqdata['SiteSetting']['date_created']	=	Date('Y-m-d');
					$this->SiteSetting->create();
				}
				//pr($this->request->data);exit();
				$this->SiteSetting->save($reqdata);
				
				if($reqdata['SiteSetting']['id'] !== ''){
					$this->Session->setFlash(
					'Settings updated', 'default', array('class' => 'alert alert-success'));
				} else{
					$this->Session->setFlash(
					'Settings added', 'default', array('class' => 'alert alert-success'));
					
				}
				$this->redirect('/admin/SiteSettings/index');
			} 
		}
		$this->set('id', $id);
		$data = $this->SiteSetting->find('first');		
		$this->set('data', $data);
		
	}
	
	private function doupload($fileArr, $path){
		$returnArr = array();
		if(!empty($fileArr['name'])){
			$exp = explode('.',$fileArr['name']);
			$ext = end($exp);
			$filename = $this->make_filename($path, $ext);
			if(move_uploaded_file($fileArr['tmp_name'], $path.$filename)){
				$returnArr['filename'] = $filename;
				$returnArr['error'] = '';
			} else {
				$returnArr['filename'] = '';
				$returnArr['error'] = 'Failed to upload image';
			}
		} else {
			$returnArr['filename'] = '';
			$returnArr['error'] = 'No file selected';
		}
		return $returnArr;
	}
	
	private function make_filename($path, $ext){
		$filename = time().'_'.rand(100000,999990).'.'.$ext;
		if(file_exists($path.$filename)){
			$filename = $this->make_filename($path, $ext);
			return $filename;
		} else {
			return $filename;
		}
	}
	
	public function admin_footer_logo_delete( ){
		$data=$this->request->params['named'];
		if($data['id']){
			$original_path=UPLOADS_FOLDER . DS .'footer_logo'. DS.'original'. DS .$data['image_name'];
			$resize_path=UPLOADS_FOLDER . DS .'footer_logo'. DS.'resize'. DS .$data['image_name'];
			
			if(file_exists($original_path)){
				unlink($original_path);
			}
			if(file_exists($resize_path)){
				unlink($resize_path);
			}
			
			$mydata['SiteSetting']['footer_logo']="";
			
			$this->SiteSetting->id = $data['id'];
			$this->SiteSetting->save($mydata);
			
			$this->Session->setFlash(
			'Logo removed', 'default', array('class' => 'alert alert-success'));
			
			$this->redirect('/admin/SiteSettings/index/'.$data['id']);
		}
	}
	
	public function admin_imgdelete( ){
		$data=$this->request->params['named'];
		if($data['id']){
			$original_path=UPLOADS_FOLDER . DS .'site_settings_logo'. DS.'original'. DS .$data['image_name'];
			$resize_path=UPLOADS_FOLDER . DS .'site_settings_logo'. DS.'resize'. DS .$data['image_name'];
			
			if(file_exists($original_path)){
				unlink($original_path);
			}
			if(file_exists($resize_path)){
				unlink($resize_path);
			}
			
			$mydata['SiteSetting']['logo']="";
			
			$this->SiteSetting->id = $data['id'];
			$this->SiteSetting->save($mydata);
			
			$this->Session->setFlash(
			'Image deleted successfully!', 'default', array('class' => 'alert alert-success'));
			
			$this->redirect('/admin/SiteSettings/index/'.$data['id']);
		}
	}
	
	public function admin_imgdelete1(){
		$data=$this->request->params['named'];
		if($data['id']){
			$original_path=UPLOADS_FOLDER . DS .'admin_logo'. DS.'original'. DS .$data['image_name'];
			$resize_path=UPLOADS_FOLDER . DS .'admin_logo'. DS.'resize'. DS .$data['image_name'];
			
			if(file_exists($original_path)){
				unlink($original_path);
			}
			if(file_exists($resize_path)){
				unlink($resize_path);
			}
			
			$mydata['SiteSetting']['admin_logo']="";
			
			$this->SiteSetting->id = $data['id'];
			$this->SiteSetting->save($mydata);
			
			$this->Session->setFlash(
			'Admin Logo deleted successfully!', 'default', array('class' => 'alert alert-success'));
			
			$this->redirect('/admin/SiteSettings/index/'.$data['id']);
		}
	}
	
	
	
}
?>