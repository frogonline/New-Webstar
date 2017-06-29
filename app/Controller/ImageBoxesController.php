<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class ImageBoxesController extends AppController {

	public $name = 'ImageBoxes';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('ImageBox', 'ImageBoxContent', 'Style', 'Shortcode', 'PageTemplateRowsColumn','FooterColumn','Page');
	public $paginate = array();

	public function beforeFilter() 
	{
		parent::beforeFilter();
		
		$this->Auth->allow('admin_boxmanageupdate');
		
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
			
			$likekeyArr = array('name');
			$titlekeyArr = array('title');
			$conditionArr = array();
			foreach($data['ImageBox'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['ImageBox.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
						if(in_array($k,$titlekeyArr)){
							$conditionArr['ImageBox.'.$k.' LIKE'] = '%'.$v.'%';
						} else {
							$conditionArr['ImageBox.'.$k] = $v;
						}
					}
				}
			}
			$conditionArr['ImageBox.isdel'] = 0;
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('ImageBox.id' => 'DESC')
			);
			$this->set('searchData',$data);
		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('ImageBox.isdel'=>'0'),
					'order'=>array('ImageBox.id' => 'DESC')
					);
			
		}
		$data= $this->paginate('ImageBox');

		$this->set('data', $data);
		
	}
	
	public function admin_manage($id=NULL){
		$this->layout = 'adminInner';
		if($this->request->is("post")){
			
			if($id != ''){
				$this->ImageBox->id = $id;
				$this->request->data['ImageBox']['date_modified'] = date("Y-m-d H:m:s");
			} else{
				$this->request->data['ImageBox']['date_created'] = date("Y-m-d H:m:s");
				$this->ImageBox->create();
			}
			$data = $this->request->data;
			
			$return =  $this->ImageBox->save($data);
			$saveId = $this->ImageBox->id;

			if($return['ImageBox']['id'] != ''){
				$this->Session->setFlash('<p>Image Box updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else{
				$this->Session->setFlash('<p>Image Box added successfully!</p>', 'default', array('class' => 'alert alert-success'));
			}
			
			if($data['ImageBox']['status']=='Y')
			{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Imagebox',$return['ImageBox']['id']);
			
				if(empty($get_data))
				{
					$styleData = $this->Style->findByGroupId(14);
					//pr($styleData); exit;
					$data['Shortcode']['controller'] 	= 'ImageBoxes';
					$data['Shortcode']['action']		= 'manage';
					$data['Shortcode']['widget_id'] 	= $return['ImageBox']['id'];
					$data['Shortcode']['widget_title'] 	= $data['ImageBox']['name'];
					$data['Shortcode']['name'] 			= 'Imagebox';
					$data['Shortcode']['group_id'] 		= 14;
					$data['Shortcode']['style_id'] 	= $styleData['Style']['id'];
					$this->Shortcode->create();
					
					$this->Shortcode->save($data);
				} else {
					$styleData = $this->Style->findByGroupId(14);
					$scdata = $this->Shortcode->findByNameAndWidgetId('ImageBox',$saveId);
					$this->Shortcode->id=$scdata['Shortcode']['id'];
					$savedata['Shortcode']['controller'] 	= 'ImageBoxes';
					$savedata['Shortcode']['action']		= 'manage';
					$savedata['Shortcode']['widget_id'] 	= $saveId;
					$savedata['Shortcode']['widget_title'] 	= $data['ImageBox']['name'];
					$savedata['Shortcode']['name'] 			= 'Imagebox';
					$savedata['Shortcode']['group_id'] 		= 14;
					$savedata['Shortcode']['style_id'] 		= $styleData['Style']['id'];
				
					$this->Shortcode->save($savedata);
				}
			}

			if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'ImageBoxes','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'ImageBoxes','action'=>'admin_index'));
				}
			
			//$this->redirect('/admin/ImageBoxes/manage/'.$return['ImageBox']['id']);
			
		}
		
		
		
		$this->set('id', $id);
		if($id != NULL || $id != ''){
			//$this->loadModel('Tabs');
			
			$this->ImageBox->bindModel(array(
									'hasMany' => array(
										'ImageBoxContent' => array(
												'className'    => 'ImageBoxContent',
												'foreignKey'   => 'image_box_id',
												'conditions'=>array('ImageBoxContent.isdel'=>'0')	
											),
										
									)
								));
			
			$data = $this->ImageBox->findById($id);
			
			
			$this->set('data',$data);
		}
	}
	
	public function admin_ajaxcopyitem($footer){
	$this->layout = 'ajax';		
	if($this->request->is('post')){		
	$data = $this->request->data;		
	if(!empty($data)){	

	$pageid=$data['pageid'];
			if(!empty($pageid)){
	
		$this->Page->id = $pageid;
		$updata['Page']['save']=1;
		$this->Page->save($updata);
		}	
	$arr = array_keys($this->ImageBoxContent->schema());				unset($arr[0]);				$this->ImageBox->bindModel(					array(						'hasMany'=>array(							'ImageBoxContent'=>array(								'className'=>'ImageBoxContent',								'foreignKey'=>'image_box_id',								'fields'=>$arr							)						)					)				);												$orgWidget = $this->ImageBox->findById($data['widgetId']);												unset($orgWidget['ImageBox']['id']);								$this->ImageBox->create();				$fl = $this->ImageBox->save($orgWidget);				$newId = $this->ImageBox->id;								if(!empty($newId)){					if(!empty($orgWidget['ImageBoxContent'])){						foreach($orgWidget['ImageBoxContent'] as $widgetItem){							if(!empty($widgetItem['image'])){								$newfileName = rand()."_".time();								$fileName = $this->copyFile($widgetItem['image'], $newfileName);								$saveData['ImageBoxContent']['image'] = $fileName;							} else {								$saveData['ImageBoxContent']['image'] = '';							}														$saveData['ImageBoxContent']['image_box_id'] = $newId;														$this->ImageBoxContent->create();							$this->ImageBoxContent->save($saveData);						}					}										$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(14, $data['widgetId']);					if(!empty($shortcode)){						$shortcode['Shortcode']['widget_id'] = $newId;						unset($shortcode['Shortcode']['id']);						$this->Shortcode->create();						$this->Shortcode->save($shortcode);					}										if(!empty($data['colId'])){						if(empty($footer))						{						$this->PageTemplateRowsColumn->id = $data['colId'];						$tpldata['PageTemplateRowsColumn']['shortcode'] = '[Imagebox-'.$newId.']';						$tpldata['PageTemplateRowsColumn']['clone_flag'] = 'Y';						$this->PageTemplateRowsColumn->save($tpldata);						}else {						$this->FooterColumn->id = $data['colId'];						$tpldata['FooterColumn']['shortcode'] = '[Imagebox-'.$newId.']';																		$this->FooterColumn->save($tpldata);												}					}					echo 1; exit();				} else {					echo 0; exit();				}			} else {				echo 0; exit();			}		}	}
	
	public function admin_copyitem($id){
		if(!empty($id)){
			$arr = array_keys($this->ImageBoxContent->schema());
			unset($arr[0]);
			$this->ImageBox->bindModel(
				array(
					'hasMany'=>array(
						'ImageBoxContent'=>array(
							'className'=>'ImageBoxContent',
							'foreignKey'=>'image_box_id',
							'fields'=>$arr
						)
					)
				)
			);
			
			
			$orgWidget = $this->ImageBox->findById($id);
							
			unset($orgWidget['ImageBox']['id']);
			
			$this->ImageBox->create();
			$fl = $this->ImageBox->save($orgWidget);
			$newId = $this->ImageBox->id;
			
			if(!empty($newId)){
				if(!empty($orgWidget['ImageBoxContent'])){
					foreach($orgWidget['ImageBoxContent'] as $widgetItem){
						if(!empty($widgetItem['image'])){
							$newfileName = rand()."_".time();
							$fileName = $this->copyFile($widgetItem['image'], $newfileName);
							$saveData['ImageBoxContent']['image'] = $fileName;
						} else {
							$saveData['ImageBoxContent']['image'] = '';
						}
						
						$saveData['ImageBoxContent']['image_box_id'] = $newId;
						
						$this->ImageBoxContent->create();
						$this->ImageBoxContent->save($saveData);
					}
				}
				
				$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(14, $id);
				if(!empty($shortcode)){
					$shortcode['Shortcode']['widget_id'] = $newId;
					unset($shortcode['Shortcode']['id']);
					$this->Shortcode->create();
					$this->Shortcode->save($shortcode);
				}
				
				return '[Imagebox-'.$newId.']';
			} else {
				return "";
			}
			
		} else {
			return "";
		}
	}
	
	private function copyFile($fileName, $newfileName){
		if(!empty($fileName)){
			$folderArr = array('original', 'resize', 'thumb');
			
			foreach($folderArr as $folder){
				$dir = new Folder(ROOT.DS.APP_DIR .'/webroot/img/uploads/box_image/'.$folder, true, 0755);
				$file = new File($dir->pwd().DS.$fileName);
				if($file->exists()){
					list($f, $e) = explode('.', $fileName);
					$saveFile = $newfileName.'.'.$e;
					$newfile = new File($dir->pwd().DS.$saveFile);
					
					$file->copy($dir->pwd() . DS . $newfile->name);
				} else {
					$saveFile = ''; 
				}
			}
			return $saveFile;
		} else {
			return ''; 
		}
	}
	
	public function admin_boxmanage(){
		$this->layout = 'ajax';
		//pr($this->request->data); exit;
		$this->set('id', $this->request->data['id']);
		$this->set('image_box_id', $this->request->data['image_box_id']);
		
		$this->loadModel('ImageBoxContent');
		if($this->request->data['id'] != ''){			
			
			$data12 = $this->ImageBoxContent->findById($this->request->data['id']);
			$this->set('data1',$data12);
		}
	}
	
	
	public function admin_boxmanageupdate($b_id,$id=NULL){
		$this->layout = 'adminInner';
		
		if($this->request->is("post")){
			$this->loadModel('ImageBoxContent');
			
			if(array_key_exists('image',$this->request->data['ImageBox'])){
				if($this->request->data['ImageBox']['image']['name']!=""){
					list($file1,$error1,$update_field1) = AppController::upload($this->request->data['ImageBox']['image'],WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'box_image'. DS . 'original' . DS ,'jpg,jpeg,JPG,JPEG,gif,GIF,png,PNG');
							
					if($error1 == ""){
						$image	=	new SimpleImage();
						
						$image->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'box_image'. DS . 'original' . DS .$file1); 
						$image_size=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'box_image'. DS . 'original' . DS .$file1,1140,760); 
						$image->resize($image_size['0'],$image_size['1']); 
						$image->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'box_image'. DS . 'resize' . DS .$file1); 
						
						$thumb	=	new SimpleImage();
						
						$thumb->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'box_image'. DS . 'original' . DS .$file1); 
						$image_size=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'box_image'. DS . 'original' . DS .$file1,360,240); 
						$thumb->resize($image_size['0'],$image_size['1']); 
						$thumb->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'box_image'. DS . 'thumb' . DS .$file1); 
						
						$this->request->data['ImageBox']['image'] = $file1;
					} else {
						$this->request->data['ImageBox']['image'] = "";
					}
				} else if ($this->request->data['ImageBox']['set_image']!==""){
					$this->request->data['ImageBox']['image'] = $this->request->data['ImageBox']['set_image'];
				} else {
					$this->request->data['ImageBox']['image'] = '';
				}
			}	
			if($id != ''){
				$this->ImageBoxContent->id = $id;
				$data1['ImageBoxContent']['date_modified'] = date("Y-m-d");
			} else{
				$data1['ImageBoxContent']['date_created'] = date("Y-m-d");
				$this->ImageBoxContent->create();
			}
			
			$data = $this->request->data;
			
			/* pr($data);
			exit;  */
			
			$data1['ImageBoxContent'] = $data['ImageBox'];
			
			
			
			$return =  $this->ImageBoxContent->save($data1);
			
			
			if($return['ImageBoxContent']['id'] !== ''){
				$this->Session->setFlash('<p>Image Box Content updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else{
				$this->Session->setFlash('<p>Image Box Content added successfully!</p>', 'default', array('class' => 'alert alert-success'));
			}
			
			
			
			$this->redirect('/admin/ImageBoxes/manage/'.$b_id);
			
		}
		
		
		$this->set('id', $id);
		if($id != NULL || $id != ''){
			$this->loadModel('ImageBox');
			
			$this->ImageBox->bindModel(array(
									'hasMany' => array(
										'ImageBoxContent' => array(
												'className'    => 'ImageBoxContent',
												'foreignKey'   => 'image_box_id'
											)
									)
								));
			
			$data = $this->ImageBox->findById($id);
			$this->set('data',$data);
		}
	}
	
	
	
	
	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['ImageBox']['isdel'] = $isdel; 
		$this->ImageBox->id = $id;
		$deleteFlag = $this->ImageBox->save($data);
		$this->loadModel('ImageBoxContent');
		
		$this->ImageBox->updateAll(
			array( 'ImageBox.isdel' => $isdel ),   //fields to update
			array( 'ImageBox.id' => $id )  //condition
		);
		
		if($deleteFlag)
		{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Imagebox',$id);
				//pr($get_data); exit;
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
		}
		
		$this->Session->setFlash('<p>Image Box details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	
	public function admin_boxdelete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$this->loadModel('ImageBoxContent');
		$data['ImageBoxContent']['isdel'] = $isdel; 
		$this->ImageBoxContent->id = $id;
		$this->ImageBoxContent->save($data);
		$this->Session->setFlash('<p>Image Box details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->ImageBox->findById($id);
			
			$data['ImageBox']['isdel'] = $stat;
			$this->ImageBox->id = $id;
			$deleteFlag = $this->ImageBox->save($data);
			if($deleteFlag){
			
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Imagebox',$id);
				//pr($get_data); exit;
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
				
				$this->Session->setFlash('<p>Image Box removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Image Box removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['ImageBox']['status'] = $stat;
		
		$this->ImageBox->id = $id;
		$this->ImageBox->save($data);
		$this->Session->setFlash('<p>Image Box updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	public function admin_imgdelete($id=null,$mid=null){

		$data=$this->request->params['named'];
		if($data['id']){
			$original_path=UPLOADS_FOLDER . DS .'box_image'. DS.'original'. DS .$data['image_name'];
			$resize_path=UPLOADS_FOLDER . DS .'box_image'. DS.'resize'. DS .$data['image_name'];
			$thumb_path=UPLOADS_FOLDER . DS .'box_image'. DS.'thumb'. DS .$data['image_name'];
			
			if(file_exists($original_path)){
				unlink($original_path);
			}
			if(file_exists($resize_path)){
				unlink($resize_path);
			}
			if(file_exists($thumb_path)){
				unlink($thumb_path);
			}
			$this->loadModel('ImageBoxContent');
			$mydata['ImageBoxContent']['image']="";
			
			$this->ImageBoxContent->id = $data['id'];
			$updateFlag = $this->ImageBoxContent->save($mydata);
			
			if($updateFlag){
				$this->Session->setFlash('<p>Image deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('<p>Failed to delete image!</p>', 'default', array('class' => 'alert alert-danger'));
			}
			$this->redirect('/admin/ImageBoxes/manage/'.$data['mid'].'/'.$data['id']);
		}
	}

}
?>