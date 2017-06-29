<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');

class BackgroundsController extends AppController {

	public $name = "Backgrounds";
	public $components = array();
	public $helpers = array();
	public $uses = array('ThemeBackground');
	public $paginate = array();
	
	public function beforeFilter() 
	{
		parent::beforeFilter();
		
		$this->Auth->allow('');
		
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
			
			$likekeyArr = array('bgtype');
			$conditionArr = array();
			foreach($data['ThemeBackground'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['ThemeBackground.'.$k.' LIKE'] = '%'.$v.'%';
					}
				}
			}
			$conditionArr['ThemeBackground.is_active'] ='Y';
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => 10,
				'order'=>array('ThemeBackground.id' => 'DESC')
			);
			$this->set('searchData',$data);
		} else {
			$this->paginate=array(
				'limit' => 10,
				'conditions'=>array('ThemeBackground.is_active'=>'Y'),
				'order'=>array('ThemeBackground.id' => 'Desc')
				);
			
		}
		$data= $this->paginate('ThemeBackground');
		$this->set('data', $data);
	}
	
	public function admin_manage($id=NULL)
	{
		$this->layout = 'adminInner';
		$this->loadModel('ThemeBackground');
		
		$backgroundSetting = $this->ThemeBackground->find('all', array(
							'conditions'=>array(
								'ThemeBackground.id'=>$id
							)
						)
					);
		//pr($backgroundSetting); exit();
		if($id!=NULL)
		{	
			$background_id = $backgroundSetting[0]['ThemeBackground']['id'];
			$background_type = $backgroundSetting[0]['ThemeBackground']['bgtype'];
			$background_image = $backgroundSetting[0]['ThemeBackground']['bgfilename'];
			$this->set('background_image', $background_image);
			$this->set('background_type', $background_type);
			$this->set('background_id', $background_id);
		}
		if($this->request->is('post')){
			$data = $this->request->data;
			//pr($data); exit;
			$themeSetting = $this->ThemeBackground->find('all', array(
							'conditions'=>array(
								'ThemeBackground.id'=>$id
							)
						)
					);
			
			if(count($themeSetting) > 0){
				$this->ThemeSetting->id = $themeSetting[0]['ThemeSetting']['id'];
			} else {
				$this->ThemeSetting->create();
			}
			
			$flag = $this->ThemeSetting->save($data);
			
			/* $str = '.main-bg-color {background-color: '.$data['ThemeSetting']['background_color'].';}
					.alt-bg-color {background-color: '.$data['ThemeSetting']['background_color'].';}
					header .menu-1 li.active.dropdown > a, header .menu-1 li.active > a{background:'.$data['ThemeSetting']['background_color'].' none repeat scroll 0 0; color:'.$data['ThemeSetting']['foreground_color'].';'; */
			$dir = new Folder(ROOT.DS.APP_DIR .'/View/Themed/'.THEME_NAME.'/webroot/css', true, 0755);
			$file = new File($dir->pwd().DS.'aspect.css');
			$str = $file->read();
			
			if($data['ThemeSetting']['background_color']!=$data['ThemeSetting']['previous_background_color']){
				$find = '#main {background-color: '.$data['ThemeSetting']['previous_background_color'];
				$replace = '#main {background-color: '.$data['ThemeSetting']['background_color'];
				$str = str_replace($find, $replace, $str);
				//$file->write($newstr);
			}
			
			
			
			if($flag){
				$this->Session->setFlash('<p>Theme updated successfully.</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('<p>Failed to update theme.</p>', 'default', array('class' => 'alert alert-danger'));
			}
			
			if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'Themes','action'=>'admin_manage/'.$id));
				} else {
					$this->redirect(array('controller'=>'Themes','action'=>'admin_index'));
				}
			//$this->redirect(array('controller'=>'Themes', 'action'=>'admin_manage/'.$id));
			
		}
				
		$this->set('id', $id);
		
		
		$this->loadModel('ThemeBackground');
		$themepatten = $this->ThemeBackground->find('list', array(
							'conditions'=>array(
								'ThemeBackground.bgtype'=>'P'
							),
							'fields'=>array('bgfilename')
						)
					);
					
		$themebg = $this->ThemeBackground->find('list', array(
							'conditions'=>array(
								'ThemeBackground.bgtype'=>'I'
							),
							'fields'=>array('bgfilename')
						)
					);
		//pr($themepatten); exit();
		$this->set(compact('themepatten','themebg'));
	}
	
	
	
	public function admin_delete($id=NULL){	
		$this->layout = '';
		$this->autoRender = false;
		$this->ThemeBackground->id = $id;
		if($this->ThemeBackground->delete($id)){
			$this->Session->setFlash('Theme Backgrounds deleted successfully.', 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('Failed to deleted the Theme Backgrounds', 'default', array('class' => 'alert alert-danger'));
		}
		$this->redirect($this->referer());	
	}
	
	
	public function admin_imgdelete( $id = NULL){
		$this->loadModel('ThemeBackground');
		$data = $this->ThemeBackground->findById($id);
		//pr($data);exit();
		if(!empty($data['ThemeBackground']['bgfilename'])){
			$original_path=IMGPATH.'bgfilename/'.$data['ThemeBackground']['bgfilename'];
			//echo $original_path; exit;
			//$resize_path=UPLOADS_FOLDER . DS .'banner_image'. DS.'resize'. DS .$data['CmsBanner']['banner_image'];
			//$thumb_path=UPLOADS_FOLDER . DS .'banner_image'. DS.'thumb'. DS .$data['CmsBanner']['banner_image'];
			
			if(file_exists($original_path)){
				unlink($original_path);
			}
			/*if(file_exists($resize_path)){
				unlink($resize_path);
			}
			if(file_exists($thumb_path)){
				unlink($thumb_path);
			}*/
			
			$mydata['ThemeBackground']['bgfilename']="";
			
			$this->ThemeBackground->id = $data['ThemeBackground']['id'];
			$deleteFlag = $this->ThemeBackground->save($mydata);
			
			if($deleteFlag){
				$this->Session->setFlash('Image delete successfully!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete image', 'default', array('class' => 'alert alert-danger'));
			}
			
			$this->redirect(array('controller'=>'Backgrounds', 'action'=>'admin_manage/'.$id));
		}
	}
	
	
	
	
	public function admin_back_ground($id=null)
	{
		
		$this->autoRender = false;
		$model=ClassRegistry::init('ThemeBackground');
		if($this->request->is('post'))
		{
			$data = $this->request->data; 
			//pr($data); exit();
			if(!empty($data['ThemeBackground']['bgfilename']['name']))
			{
				list($file,$error1,$update_field1) = AppController::upload($data['ThemeBackground']['bgfilename'],WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'bgfilename'. DS ,'jpg,jpeg,JPG,JPEG,gif,GIF,png,PNG');
				
				if($file!=""){
					$data['ThemeBackground']['bgfilename'] = $file;
				} else {
					$data['ThemeBackground']['bgfilename'] = "";
				}
			}
			//$model->create();
			$this->ThemeBackground->id = $id;
			
			$fl = $model->save($data);
			if($fl){
				$this->Session->setFlash('<p>Theme Background added successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('<p>Failed to upload background!</p>', 'default', array('class' => 'alert alert-danger'));
			}
			$this->redirect(array('controller'=>'Backgrounds','action'=>'admin_index'));
						
		}
			
	}
	
}
