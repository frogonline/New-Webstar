<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class GalleryManagementsController extends AppController {

	public $name = 'GalleryManagements';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('GalleryManagement','GalleryImage','Style', 'Shortcode', 'PageTemplateRowsColumn','FooterColumn','Page');
	public $paginate = array();

	public function beforeFilter() 
	{
		parent::beforeFilter();
		
		$this->Auth->allow('gallery','gallery_details');
		$this->Auth->deny('index');
		
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
		/* $permissionArr=$this->Session->read('permissionArr');
		pr($permissionArr);
		exit; */
		$this->layout = 'adminInner';
		if($this->request->is("post"))
		{
			$data = $this->request->data;
			
			$likekeyArr = array('name');
			$titlekeyArr = array('title');
			$conditionArr = array();
			foreach($data['GalleryManagement'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['GalleryManagement.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
						if(in_array($k,$titlekeyArr)){
							$conditionArr['GalleryManagement.'.$k.' LIKE'] = '%'.$v.'%';
						} else {
							$conditionArr['GalleryManagement.'.$k] = $v; 
						}
					}
				}
			}
			$conditionArr['GalleryManagement.isdel'] = 0; 
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('GalleryManagement.id' => 'DESC')
			);
			$this->set('searchData',$data);
		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('GalleryManagement.isdel'=>'0'),
					'order'=>array('GalleryManagement.id' => 'DESC')
					);
			
		}
		$data=$this->paginate('GalleryManagement');
		$this->set('data', $data);
		
	}
	
	public function admin_manage($id=NULL){
		$this->layout = 'adminInner';
		if($this->request->is("post")){
			
			if($id != ''){
				$this->GalleryManagement->id = $id;
				$this->request->data['GalleryManagement']['date_modified'] = date("Y-m-d");
			} else{
				$this->request->data['GalleryManagement']['date_created'] = date("Y-m-d");
				$this->GalleryManagement->create();
			}
			
			$data = $this->request->data;
			//pr($data); exit();
			
			if(array_key_exists('slug',$data['GalleryManagement'])){
				if($data['GalleryManagement']['slug']==''){
					$slugArr = array('Model'=>'GalleryManagement','field'=>'slug');
					$data['GalleryManagement']['slug']=AppController::get_slug($data['GalleryManagement']['name'],$slugArr);
				}
			} else {
				$slugArr = array('Model'=>'GalleryManagement','field'=>'slug');
				$data['GalleryManagement']['slug']=AppController::get_slug($data['GalleryManagement']['name'],$slugArr);
			}
			
			
		
			
			$this->GalleryManagement->save($data);
			$gallery_management_id=$this->GalleryManagement->id;
			$data1['GalleryManagement']['short_code'] = '[gallery-'.$gallery_management_id.']';
			$this->GalleryManagement->save($data1);
			$saveId = $this->GalleryManagement->id;
			
			
			if($data['GalleryManagement']['style'] == 'style6')
			{
				foreach($data['GalleryImage']['gallery_cat_image_name'] as $galleryManagement)
				{
					foreach($galleryManagement as $arrgallery)
					{
						pr($imgArr);
					}
				}
				exit;
			}
			else
			{
				if( !empty($data['GalleryImage']['gallery_image_name'][0]['name']) ){
					
					$imgArr=$data['GalleryImage'];
				}
				else{
					$imgArr=array();
				}
				if(!empty($imgArr)){
				
					$imgdata['GalleryImage']['gallery_management_id']=$gallery_management_id;
					$model=ClassRegistry::init('GalleryImage');
					foreach($imgArr['gallery_image_name'] as $vimage){
					
						list($file2,$error1,$update_field1) = AppController::upload($vimage,WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'gallery_image'. DS . 'original' . DS ,'jpg,jpeg,JPG,JPEG,gif,GIF,png,PNG');
						
						if($error1 == ""){
						$image	=	new SimpleImage();
						
						$image->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'gallery_image'. DS . 'original' . DS .$file2); 
						$image_size=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'gallery_image'. DS . 'original' . DS .$file2,1348,626); 
						$image->resize($image_size['0'],$image_size['1']); 
						$image->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'gallery_image'. DS . 'resize' . DS .$file2); 
						
						$thumb	=	new SimpleImage();
						
						$thumb->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'gallery_image'. DS . 'original' . DS .$file2); 
						$image_size=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'gallery_image'. DS . 'original' . DS .$file2,160,145); 
						$thumb->resize($image_size['0'],$image_size['1']); 
						$thumb->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'gallery_image'. DS . 'thumb' . DS .$file2); 
						
						$this->request->data['GalleryImage']['gallery_image_name'] = $file2;
						$imgdata['GalleryImage']['gallery_image_name']=$file2;
						$model->create();
						$model->save($imgdata);
						}
						else {
						}
						
					}
				
				}
			}
			if($id != ''){
				$this->Session->setFlash('<p><strong>Success:&nbsp;</strong>Carousel Record updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else{
				$this->Session->setFlash('<p><strong>Success:&nbsp;</strong>Carousel Record added successfully!</p>', 'default', array('class' => 'alert alert-success'));
			}
			//pr($data);exit;
			if($data['GalleryManagement']['status']=='Y')
				{
					$this->loadModel('Shortcode');
					$get_data = $this->Shortcode->findByNameAndWidgetId('gallery',$saveId);
				
					if(empty($get_data))
					{
						$styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['GalleryManagement']['style'], 13);
					    //pr($styleData); exit();
						$data['Shortcode']['controller'] 	= 'GalleryManagements';
						$data['Shortcode']['action']		= 'manage';
						$data['Shortcode']['widget_id'] 	= $saveId;
						$data['Shortcode']['widget_title'] 	= $data['GalleryManagement']['name'];
						$data['Shortcode']['name'] 			= 'gallery';
						$data['Shortcode']['group_id'] 	= 13;
					    $data['Shortcode']['style_id'] 	= $styleData['Style']['id'];
						$this->Shortcode->create();
						
						$this->Shortcode->save($data);
					} else {
						$styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['GalleryManagement']['style'], 13);
						$scdata = $this->Shortcode->findByNameAndWidgetId('gallery',$saveId);
						$this->Shortcode->id = $scdata['Shortcode']['id'];
						$data['Shortcode']['controller'] 	= 'GalleryManagements';
						$data['Shortcode']['action']		= 'manage';
						$data['Shortcode']['widget_id'] 	= $saveId;
						$data['Shortcode']['widget_title'] 	= $data['GalleryManagement']['name'];
						$data['Shortcode']['name'] 			= 'gallery';
						$data['Shortcode']['group_id'] 	= 13;
					    $data['Shortcode']['style_id'] 	= $styleData['Style']['id'];
				
						$this->Shortcode->save($data);
					}	
				}
			
			if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'GalleryManagements','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'GalleryManagements','action'=>'admin_index'));
				}
		//$this->redirect('/admin/GalleryManagements/index');
			
		}
		
		$stylesArr = $this->Style->find('list', array(
				'conditions'=>array(
					'Style.group_id'=>13
				),
				'fields'=>array(
					'widgetstyle_name', 'name'
				)
			)
		);
		//pr($stylesArr); exit();
		$this->set('stylesArr', $stylesArr);
		
		
		$this->set('id', $id);
		if($id != NULL || $id != ''){
			$this->loadModel('GalleryManagement');
			
			$this->GalleryManagement->bindModel(array(
									'hasMany' => array(
										'GalleryImage' => array(
												'className'    => 'GalleryImage',
												'foreignKey'   => 'gallery_management_id'
											)
									)
								));
			
			$data = $this->GalleryManagement->findById($id);
			
			
			
			if(!empty($data)){
				$widgetStyle = $this->Style->findByGroupIdAndWidgetstyleName(13,$data['GalleryManagement']['style']);
			} else {
				$widgetStyle = array();
			}
			
			$this->set(compact('data', 'widgetStyle'));
		
		}
		
			$this->loadModel('style');
		    $Gallery_styledata=$this->style->find('all', array(
					'order'=>array('style.id ASC'),
					'fields'=>array('style.widgetstyle_name', 'style.style_img','style.name'),
					'conditions'=>array('style.group_id'=>13)
				)
			);
			//pr($Gallery_styledata); exit;
		    $this->set('Gallery_styledata',$Gallery_styledata);
		
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
	$arr = array_keys($this->GalleryImage->schema());				unset($arr[0]);				$this->GalleryManagement->bindModel(					array(						'hasMany'=>array(							'GalleryImage'=>array(								'className'=>'GalleryImage',								'foreignKey'=>'gallery_management_id',								'fields'=>$arr							)						)					)				);												$orgWidget = $this->GalleryManagement->findById($data['widgetId']);												unset($orgWidget['GalleryManagement']['id']);								$this->GalleryManagement->create();				$fl = $this->GalleryManagement->save($orgWidget);				$newId = $this->GalleryManagement->id;								if(!empty($newId)){					if(!empty($orgWidget['GalleryImage'])){						foreach($orgWidget['GalleryImage'] as $widgetItem){							if(!empty($widgetItem['gallery_image_name'])){								$newfileName = rand()."_".time();								$fileName = $this->copyFile($widgetItem['gallery_image_name'], $newfileName);								$saveData['GalleryImage']['gallery_image_name'] = $fileName;							} else {								$saveData['GalleryImage']['gallery_image_name'] = '';							}														$saveData['GalleryImage']['gallery_management_id'] = $newId;														$this->GalleryImage->create();							$this->GalleryImage->save($saveData);						}					}										$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(13, $data['widgetId']);					if(!empty($shortcode)){						$shortcode['Shortcode']['widget_id'] = $newId;						unset($shortcode['Shortcode']['id']);						$this->Shortcode->create();						$this->Shortcode->save($shortcode);					}										if(!empty($data['colId'])){						if(empty($footer))						{						$this->PageTemplateRowsColumn->id = $data['colId'];						$tpldata['PageTemplateRowsColumn']['shortcode'] = '[gallery-'.$newId.']';						$tpldata['PageTemplateRowsColumn']['clone_flag'] = 'Y';						$this->PageTemplateRowsColumn->save($tpldata);						}else {						$this->FooterColumn->id = $data['colId'];						$tpldata['FooterColumn']['shortcode'] = '[gallery-'.$newId.']';																		$this->FooterColumn->save($tpldata);												}					}					echo 1; exit();				} else {					echo 0; exit();				}			} else {				echo 0; exit();			}		}	}
	
	public function admin_copyitem($id){
		if(!empty($id)){
			$arr = array_keys($this->GalleryImage->schema());
			unset($arr[0]);
			$this->GalleryManagement->bindModel(
				array(
					'hasMany'=>array(
						'GalleryImage'=>array(
							'className'=>'GalleryImage',
							'foreignKey'=>'gallery_management_id',
							'fields'=>$arr
						)
					)
				)
			);
			
			
			$orgWidget = $this->GalleryManagement->findById($id);
							
			unset($orgWidget['GalleryManagement']['id']);
			
			$this->GalleryManagement->create();
			$fl = $this->GalleryManagement->save($orgWidget);
			$newId = $this->GalleryManagement->id;
			
			if(!empty($newId)){
				if(!empty($orgWidget['GalleryImage'])){
					foreach($orgWidget['GalleryImage'] as $widgetItem){
						if(!empty($widgetItem['gallery_image_name'])){
							$newfileName = rand()."_".time();
							$fileName = $this->copyFile($widgetItem['gallery_image_name'], $newfileName);
							$saveData['GalleryImage']['gallery_image_name'] = $fileName;
						} else {
							$saveData['GalleryImage']['gallery_image_name'] = '';
						}
						
						$saveData['GalleryImage']['gallery_management_id'] = $newId;
						
						$this->GalleryImage->create();
						$this->GalleryImage->save($saveData);
					}
				}
				
				$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(13, $id);
				if(!empty($shortcode)){
					$shortcode['Shortcode']['widget_id'] = $newId;
					unset($shortcode['Shortcode']['id']);
					$this->Shortcode->create();
					$this->Shortcode->save($shortcode);
				}
				
				return '[gallery-'.$newId.']';
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
				$dir = new Folder(ROOT.DS.APP_DIR .'/webroot/img/uploads/gallery_image/'.$folder, true, 0755);
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
	
	public function admin_imgdelete( ){
		$data=$this->request->params['named'];
		$model=ClassRegistry::init('GalleryImage');
		if($data['img_id']){
			$original_path=WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'gallery_image'. DS.'original'. DS .$data['gallery_image_name'];
			
			$resize_path=WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'gallery_image'. DS.'resize'. DS .$data['gallery_image_name'];
			$thumb_path=WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'gallery_image'. DS.'thumb'. DS .$data['gallery_image_name'];
			
			if(file_exists($original_path)){
				unlink($original_path);
			}
			if(file_exists($resize_path)){
				unlink($resize_path);
			}
			if(file_exists($thumb_path)){
				unlink($thumb_path);
			}
			
			$model->delete($data['img_id']);		
			
			$this->Session->setFlash('<p><strong>Success:&nbsp;</strong>Image delete successfully!</p>', 'default', array('class' => 'alert alert-success'));
			
			$this->redirect('/admin/GalleryManagements/manage/'.$data['id']);
		}
	}
	
	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['GalleryManagement']['isdel'] = $isdel; 
		$this-> GalleryManagement->id = $id;
		$deleteFlag = $this->GalleryManagement->save($data);
		
		if($deleteFlag)
		{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('gallery',$id);
				//pr($get_data); exit;
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
		}
		
		$this->Session->setFlash('<p>Gallery Management details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_deleteAll($idAll=NULL, $stat = 0)
	{	
		
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			//$data = $this->GalleryManagement->findById($id);
			
			$data['GalleryManagement']['isdel'] = $stat;
			$this->GalleryManagement->id = $id;
			$deleteFlag = $this->GalleryManagement->save($data);
			if($deleteFlag){
			
			$this->loadModel('Shortcode');
			$get_data = $this->Shortcode->findByNameAndWidgetId('gallery',$id);
			//pr($get_data);
			$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
			
				$this->Session->setFlash('<p>Gallery removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Gallery cannot be removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['GalleryManagement']['status'] = $stat;
		
		$this->GalleryManagement->id = $id;
		$this->GalleryManagement->save($data);
		$this->Session->setFlash('<p>Gallery Management updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	public function gallery()
	{
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
		
		$this->loadModel('GalleryImage');
		$this->GalleryManagement->bindModel(array(
									'hasMany' => array(
										'GalleryImage' => array(
												'className'    => 'GalleryImage',
												'foreignKey'   => 'gallery_management_id'
											)
										)
									));
									
		$this->paginate = array(
							'limit' => PAGINATION_PER_PAGE_LIMIT,
							'conditions' => array('GalleryManagement.isdel'=>0),
							'order' => array('GalleryManagement.id'=>'DESC')
						);
		
		$gallery = 	$this->paginate('GalleryManagement');
		
		$this->set('gallery',$gallery);
		
		
	}
	
	
	public function gallery_details($id = NULL)
	{
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
		
		$this->loadModel('GalleryImage');
		$this->GalleryManagement->bindModel(array(
									'hasMany' => array(
										'GalleryImage' => array(
												'className'    => 'GalleryImage',
												'foreignKey'   => 'gallery_management_id'
											)
										)
									));
									
		if($id!=="")
		{
			$this->GalleryManagement->id=$id;	
		}
			$galleryImages = $this->GalleryManagement->findAllById($id);
			
			//pr($galleryImages);
			$this->set('galleryImages',$galleryImages);
		
		
		
	}

}
?>