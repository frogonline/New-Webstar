<?php
/* just for a test */
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	
	public $components = array('Session','Cookie','Security','RequestHandler',
							'Auth'=>array(
									  'authenticate' => array('Form' => array(
																			'fields'=>array(
																			'username' => 'username',
																			'password' => 'password' ),
																			'scope' => array(
																							'User.status' => 'CONFIRM',
																							'User.user_type' => array('admin','super')
																						),
																		),
															),
										'loginRedirect' => array('controller' => 'Generals', 'action' => 'admin_dashboard'),
										'logoutRedirect' => array('controller' => 'Generals', 'action' => 'admin_login')
		  
									)
						);
	
	var $helpers = array('Cache','Html','Session','Form','Paginator'); //,'Combinator.Combinator'
	
	public function beforeRender() {
		$this->response->disableCache();
		//$this->_configureErrorLayout();
		
	}
	
	public function beforeFilter() 
	{
		parent::beforeFilter();
		$blogcount = ClassRegistry::init("Page")->find('count', array(
        'conditions' => array('Page.type' => 'Post','Page.is_active'=>'Y','Page.is_del'=>'0')));
		$this->set(compact('blogcount'));
		
		if ($this->params['admin']) {
			$metaKeywords = "Cake CMS";
			$metaDescription = "This is testing site";
			
		}
		//write site settings to session
		$siteSettingArr = ClassRegistry::init("SiteSetting")->find('first');
		$this->Session->write('siteSettings', $siteSettingArr);
		
		$ThemeSettingArr = ClassRegistry::init("ThemeSetting")->find('first');
		$this->Session->write('ThemeSetting', $ThemeSettingArr);
		
		$session_id = $this->Session->read('session_id');
		if($session_id==NULL){
			$this->Session->write('session_id',uniqid());
		}
		
		
		$permissionArr=$this->Session->read('permissionArr');
		//pr($permissionArr); 
		if(!empty($permissionArr)){
			$currentmodelName = $this->name; 
			$currentactionName = $this->action; 
			if($currentmodelName != 'CakeError'){
				 $frompagewidgetper = ClassRegistry::init("Menu")->find('list',
						array(
							'conditions'=>array(
								'Menu.menu_id'=>'99'
							),
							'fields'=>array('Menu.controller')
						)
					);
				
					$fl = array_key_exists($currentmodelName, $permissionArr);
					if($fl){
						if(array_key_exists($currentactionName, $permissionArr[$currentmodelName])){
							$currentModelPer = $permissionArr[$currentmodelName][$currentactionName]; 
							
							//pr($currentModelPer); exit();
							if(($currentModelPer['view']=='N') && (in_array($currentmodelName,$frompagewidgetper) && ($this->action!='admin_manage'))){
								if($this->action!='admin_logout' && $this->action!='admin_login'){
									$this->redirect(array('controller'=>'Generals', 'action'=>'admin_dashboard'));
								}
							} else if(($currentModelPer['view']=='N') && (!in_array($currentmodelName,$frompagewidgetper))){
									if($this->action!='admin_logout' && $this->action!='admin_login'){
										$this->redirect(array('controller'=>'Generals', 'action'=>'admin_dashboard'));
									}
							} else {
								$this->Session->write('currentModelPer', $currentModelPer);
								//$this->set(compact('currentModelPer'));
							}
						}
						
					} else {
						if($this->params['prefix'] == 'admin'){
							$this->redirect(array('controller'=>'Generals', 'action'=>'admin_dashboard'));
						}
					}
			}
		}
	}
	
	protected function get_slug($title, $arr){
		$preslug = strtolower($title);
		$preslug = str_replace('&','',$preslug);
		$preslug = str_replace(',','',$preslug);
		$preslug = str_replace("'",'',$preslug);
		$preslug = str_replace('  ',' ',$preslug);
		$preslug = str_replace(' ','-',$preslug);
		
		$slug = $this->make_slug($preslug, $arr);
		return $slug;
	}
	
	/* protected function make_slug($slug, $arr){
		$dupslug = "";
		$orgslug = $slug; $i=0; $count=1;
		$this->loadModel($arr['Model']);
		while($count!=0){
			$conditionArr = array();
			if(array_key_exists('conditions', $arr)){
				foreach($arr['conditions'] as $k =>$v){
					$conditionArr[$arr['Model'].".".$k] = $v;
				}
				$conditionArr[$arr['Model'].".".$arr['field']] = $slug;
 			} else {
				$conditionArr[$arr['Model'].".".$arr['field']] = $slug;
			}
			
			
			$count = $this->$arr['Model']->find('count', array(
					'conditions'=>$conditionArr
				)
			);
			if($count==0){
				$dupslug = $slug;
				break;
			} else {
				$e = $i + 1;
				$slug = $orgslug.$e;
			}
			$i++;
		}
		return $dupslug;
		
	} */
	
	protected function make_slug($slug, $arr){
		$dupslug = "";
		$orgslug = $slug; $i=0; $count=1;
		$this->loadModel('Slug');
		while($count!=0){
						
			$count = $this->Slug->find('count', array(
					'conditions'=>array(
						'Slug.slug_name'=>$slug
					)
				)
			);
			if($count==0){
				$dupslug = $slug;
				break;
			} else {
				$e = $i + 1;
				$slug = $orgslug.$e;
			}
			$i++;
		}
		
		$arr['slug_name'] = $dupslug;
		$flag = $this->saveSlug($arr);
		if($flag){
			return $dupslug;
		} else {
			return 'No Slug';
		}
		
	}
	
	public function saveSlug($dataArr){
		$this->loadModel('Slug');
		$saveArr = array();
		if(!empty($dataArr)){
			foreach($dataArr as $k=>$v){
				$saveArr['Slug'][$k] = $v;
			}
			
			if(array_key_exists('mode', $dataArr)){
				if($dataArr['mode']=="edit"){
					$dataID = $this->Slug->findBySlugName($dataArr['pre_slug_name']);
					$this->Slug->id=$dataID['Slug']['id'];
				} else {
					$this->Slug->create();
				}
			} else {
				$this->Slug->create();
			}
			$flag = $this->Slug->save($saveArr);
			return $flag;
		} else {
			return false;
		}
		
	}
	
	public function upload($file_id, $folder="", $types="",$size="",$filename="") 
	{
		//if(!$_FILES[$file_id]['name']) return array('','No file specified');
		if(!$file_id['name']) return array('','No file specified');
		$file_title = $file_id['name'];
		//Get file extension
		$ext_arr = explode(".",basename($file_title));
		$ext = strtolower($ext_arr[count($ext_arr)-1]); //Get the last extension
		//Not really uniqe - but for all practical reasons, it is
		//   $uniqer = substr(md5(uniqid(rand(),1)),0,5);
		//  $file_name = $uniqer . '_' . $file_title;//Get Unique Name
		$all_types = explode(",",strtolower($types));
		if($types)
		{
			if(in_array($ext,$all_types))
			{}
			else 
			{
				$result = "'".$file_id['name']."' is not a valid file."; //Show error if any.
				return array('',$result);
			}
		}
		if($size)
		{
			if($file_id['size'] > $size)
			{
				$result = "The file is not uploaded. Because file size is greater than ".($size/1024)."KB";
				return array('',$result);
			}
		}

		if($filename=="")
		{
			$file_name=rand()."_".time().".".$ext;
		}
		else
		{
			$file_name=$filename.'.'.$ext;
		}
		//Where the file must be uploaded to
		if($folder) $folder .= '/';//Add a '/' at the end of the folder
		$uploadfile = $folder . $file_name;
		$result = '';
		$update_field='';
		//Move the file from the stored location to the new location
		if (!move_uploaded_file($file_id['tmp_name'], $uploadfile)) 
		{
			$result = "Cannot upload the file '".$file_id['tmp_name']."'"; //Show error if any.
			if(!file_exists($folder)) {
				$result .= " : Folder don't exist.";
			} 
			elseif(!is_writable($folder)) {
				$result .= " : Folder not writable.";
			} 
			elseif(!is_writable($uploadfile)) {
				$result .= " : File not writable.";
			}
			$file_name = '';
		} 
		else 
		{
			if(!$file_id['size']) 
			{ //Check if the file is made
				@unlink($uploadfile);//Delete the Empty file
				$file_name = '';
				$result = "Empty file found - please use a valid file."; //Show the error message
			} 
			else 
			{
				/* $update_field=",".$file_id."='".$file_name."'"; */
				$update_field=",Image='".$file_name."'"; 
				chmod($uploadfile,0777);//Make it universally writable.
			}
		}
		return array($file_name,$result,$update_field);
	}

	public function resize_to_save($image_file,$target,$target2="",$shape="") {
		$maxSize = $target; // set this varible to max width or height
		$maxSize2 = $target2; // set this varible to max width or height
		if(@fopen($image_file,'r'))
		{
			$image_size = getimagesize($image_file);
			$width = $image_size[0];
			$height = $image_size[1];
			if($width > $maxSize || $height > $maxSize2) 
			{
				if($width > $maxSize) 
				{
					$z = $width;
					$i = 0;
					while($z > $maxSize) 
					{
						--$z; ++$i;
					}
					$imgSizeArray[0] =round($z);
					$imgSizeArray[1] = round($height - ($height * ($i / $width)));
				}
				else 
				{
					$z = $height;
					$i = 0;
					while($z > $maxSize) 
					{
						--$z; ++$i;
					}
					$imgSizeArray[0] = round($width - ($width * ($i / $height)));
					$imgSizeArray[1] = round($z);
				}

				$width = $imgSizeArray[0];
				$height = $imgSizeArray[1];
				if($target2!="")
				{
					$z = $height;
					$i = 0;
					while($z > $target2) 
					{
						--$z; ++$i;

					}
					$imgSizeArray[0] = round($width - ($width * ($i / $height)));
					$imgSizeArray[1] = round($z);
				}
			}
			else
			{
				$imgSizeArray[0] = round($width);
				$imgSizeArray[1] = round($height);
			}
			return $imgSizeArray;
		}
		else
		{
			return $image_size;
		}
	}
	
	public function generate_random_value($length = 10) 
	{
		$alphabets = range('A','Z');
		$numbers = range('0','9');
		$additional_characters = array('_','.');
		$final_array = array_merge($alphabets,$numbers,$additional_characters);
		
		$value = '';

		while($length--) 
		{
			$key = array_rand($final_array);
			$value .= $final_array[$key];
		}
		
		return $value;
	}
	
}