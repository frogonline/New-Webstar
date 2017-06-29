<?php 
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class CmsGalleriesController extends AppController 
{
	public $name = 'CmsGalleries';
	public $components = array();
	public $helpers = array();
	public $uses = array('CmsGallery', 'CmsBanner', 'Style', 'Shortcode', 'PageTemplateRowsColumn','FooterColumn','Page');
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
		$reqdata = $this->request->data;
		 if(empty($reqdata['CmsGallery']['searchvalue']))
		 {
			if($this->request->is('post')){
			if($this->CmsGallery->validates()){
				$reqdata = $this->request->data;
				
				$this->CmsGallery->create();
				$slugArr = array('controller_name'=>'CmsGalleries','action_name'=>'gallery');
				$reqdata['CmsGallery']['gallery_slug'] = AppController::get_slug($reqdata['CmsGallery']['gallery_name'],$slugArr);
				
				$galSaveFlag = $this->CmsGallery->save($reqdata);
				$saveId = $this->CmsGallery->id;
				
				if($galSaveFlag){
					$this->loadModel('Shortcode');
					$get_data = $this->Shortcode->findByNameAndWidgetId('Banner',$saveId);
				
					if(empty($get_data))
					{
						$styleData = $this->Style->findByWidgetstyleNameAndGroupId($reqdata['CmsGallery']['style'], 2);
					    //pr($styleData); exit();
						$scdata['Shortcode']['controller'] 	= 'CmsGalleries';
						$scdata['Shortcode']['action']		= 'manage';
						$scdata['Shortcode']['widget_id'] 	= $saveId;
						$scdata['Shortcode']['name'] 		= 'Banner';
						$scdata['Shortcode']['group_id'] 	= 2;
					    $scdata['Shortcode']['style_id'] 	= $styleData['Style']['id'];
						$this->Shortcode->create();
						
						$this->Shortcode->save($scdata);
					}
					
					$this->Session->setFlash('Gallery added successfully', 'default', array('class' => 'alert alert-success'));
				} else {
					$this->Session->setFlash('Failed to add gallery', 'default', array('class' => 'alert alert-danger'));
				}
				$this->redirect($this->referer());
			}
		}
	 }

		if($this->request->is("post"))
			{ 
			$data = $this->request->data;
			$likekeyArr = array('gallery_name');
			$styleArr = array('style');
			$conditionArr = array();
			foreach($data['CmsGallery'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['CmsGallery.'.$k.' LIKE'] = '%'.$v.'%';
					}
				}
			}
			$conditionArr['CmsGallery.is_del']=0;
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT
			);
			$this->set('searchData',$data);

			}else {
			$this->paginate = array('conditions' => array('CmsGallery.is_del' => 0),
								'limit' => PAGINATION_PER_PAGE_LIMIT
							);
			}
		$data= $this->paginate('CmsGallery');
		$this->set('data', $data);
		/*  pr($data);
		exit; */ 
		$stylesArr = $this->Style->find('list', array(
				'conditions'=>array(
					'Style.group_id'=>2
				),
				'fields'=>array(
					'widgetstyle_name', 'name'
				)
			)
		);
		$this->set('stylesArr', $stylesArr);
			$this->loadModel('style');
		    $banner_slider_styledata=$this->style->find('all', array(
					'order'=>array('style.id ASC'),
					'fields'=>array('style.widgetstyle_name', 'style.style_img','style.name'),
					'conditions'=>array('style.group_id'=>2)
				)
			);
		    $this->set('banner_slider_styledata',$banner_slider_styledata);
	}
	
	public function admin_delete($id=NULL,$gallery_slug=null,$stat = 1)
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['CmsGallery']['is_del'] = $stat;
		$this->CmsGallery->id = $id;
		$this->CmsGallery->save($data);
		
		$this->loadModel('Slug');
		$find = $this->Slug->findBySlugName($gallery_slug);
		$this->Slug->delete($find['Slug']['id']);
		
		$this->CmsBanner->deleteAll(array('CmsBanner.gallery_id'=>$id));
		
		
		$this->Session->setFlash('<p>The Gallery has been successfully removed!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		
	}
	
	public function admin_manage($id=NULL){
		$this->layout = 'adminInner';
		
		$sliderTypeArr = $this->Style->find('list', array(
				'conditions'=>array(
					'group_id'=>2
				),
				'fields'=>array('widgetstyle_name', 'name')
			)
		);
		//pr($style); exit();
		
		$this->set(compact('id', 'sliderTypeArr'));
		if($id != NULL || $id != ''){
			$this->CmsGallery->bindModel(array(
					'hasMany' => array(
						'CmsBanner' => array(
							'className'    => 'CmsBanner',
							'foreignKey'   => 'gallery_id'
						)
					)
				)
				
			);
			
			$data = $this->CmsGallery->findById($id); //pr($data); exit();
			$this->set('data',$data);
		}
	}
	
	public function admin_editslideform(){
		$this->layout = 'ajax';
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			$data = $this->CmsBanner->findById($reqdata['slideId']);
			$this->set(compact('reqdata', 'data'));
		}
	}
	
	public function admin_addslideform(){
		$this->layout = 'ajax';
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			$this->set(compact('reqdata'));
		}
	}
	
	public function admin_manageslide(){
		$this->autoRender = false;
		
		if($this->request->is('post')){
			$data = $this->request->data; //pr($data); exit();
			$saveData = array();
			
			$keyArr = array_keys($data['CmsBanner']);
			$fieldsArr = array('banner_image', 'banner_back_image', 'rev_slider_type', 'banner_text', 'banner_link', 'detailheading', 'rev_video_link', 'button_link', 'button_text','target');
			$exceptionkeyArr = array('banner_image', 'banner_back_image');
			
			foreach($fieldsArr as $key){
				if(in_array($key, $keyArr)){
					if(in_array($key, $exceptionkeyArr)){
						if(!empty($data['CmsBanner'][$key]['name'])){
							list($file2,$error1,$update_field1) = AppController::upload($data['CmsBanner'][$key],WWW_ROOT . DS . 'img'. DS .'uploads'. DS . $key. DS . 'original' . DS ,'jpg,jpeg,JPG,JPEG,gif,GIF,png,PNG');
											
							if($file2 != ""){
								$image_back	=	new SimpleImage();
								
								$image_back->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . $key. DS . 'original' . DS .$file2); 
								$image_size_back=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . $key. DS . 'original' . DS .$file2,960,562); 
								$image_back->resize($image_size_back['0'],$image_size_back['1']); 
								$image_back->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . $key. DS . 'resize' . DS .$file2); 
								
								$thumb_back	=	new SimpleImage();
								
								$thumb_back->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . $key. DS . 'original' . DS .$file2); 
								$image_size_back=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . $key. DS . 'original' . DS .$file2,200,150); 
								$thumb_back->resize($image_size_back['0'],$image_size_back['1']); 
								$thumb_back->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . $key. DS . 'thumb' . DS .$file2);
								$saveData['CmsBanner'][$key] = $file2;
							} else {
								$saveData['CmsBanner'][$key] = "";
							}
						} else {
							$saveData['CmsBanner'][$key] = "";
						}
					} else {
						$saveData['CmsBanner'][$key] = $data['CmsBanner'][$key];
					}
				}
			}
			
			if(!empty($data['CmsBanner']['id'])){
				$this->CmsBanner->id = $data['CmsBanner']['id'];
			} else {
				$this->CmsBanner->create();
			}
			$saveData['CmsBanner']['gallery_id'] = $data['CmsBanner']['gallery_id'];
			$fl = $this->CmsBanner->save($saveData);
			
			if($fl){
				if(!empty($data['CmsBanner']['id'])){
					$this->Session->setFlash('Slide updated successfully', 'default', array('class' => 'alert alert-success'));
				} else {
					$this->Session->setFlash('Slide added successfully', 'default', array('class' => 'alert alert-success'));
				}
			} else {
				$this->Session->setFlash('Failed to add slide', 'default', array('class' => 'alert alert-danger'));
			}
			$this->redirect(array('controller'=>'CmsGalleries', 'action'=>'admin_manage/'.$data['CmsBanner']['gallery_id']));
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
	$arr = array_keys($this->CmsBanner->schema());				unset($arr[0]);				$this->CmsGallery->bindModel(					array(						'hasMany'=>array(							'CmsBanner'=>array(								'className'=>'CmsBanner',								'foreignKey'=>'gallery_id',								'fields'=>$arr							)						)					)				);												$orgWidget = $this->CmsGallery->findById($data['widgetId']);					unset($orgWidget['CmsGallery']['id']);								$slugArr = array('controller_name'=>'CmsGalleries','action_name'=>'gallery');				$orgWidget['CmsGallery']['gallery_slug'] = AppController::get_slug($orgWidget['CmsGallery']['gallery_name'],$slugArr);								$this->CmsGallery->create();				$fl = $this->CmsGallery->save($orgWidget);				$newId = $this->CmsGallery->id;								if(!empty($newId)){					if(!empty($orgWidget['CmsBanner'])){						foreach($orgWidget['CmsBanner'] as $widgetItem){							$saveData['CmsBanner'] = $widgetItem;							if(!empty($widgetItem['banner_image'])){								$newfileName = rand()."_".time();								$fileName = $this->copyFile($widgetItem['banner_image'], $newfileName, ROOT.DS.APP_DIR .'/webroot/img/uploads/banner_image/');								$saveData['CmsBanner']['banner_image'] = $fileName;							} else {								$saveData['CmsBanner']['banner_image'] = '';							}														if(!empty($widgetItem['banner_back_image'])){								$newfileName = rand()."_".time();								$fileName = $this->copyFile($widgetItem['banner_back_image'], $newfileName, ROOT.DS.APP_DIR .'/webroot/img/uploads/banner_back_image/');								$saveData['CmsBanner']['banner_back_image'] = $fileName;							} else {								$saveData['CmsBanner']['banner_back_image'] = '';							}														$saveData['CmsBanner']['gallery_id'] = $newId;														$this->CmsBanner->create();							$this->CmsBanner->save($saveData);						}					}										$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(2, $data['widgetId']);					if(!empty($shortcode)){						$shortcode['Shortcode']['widget_id'] = $newId;						unset($shortcode['Shortcode']['id']);						$this->Shortcode->create();						$this->Shortcode->save($shortcode);					}										if(!empty($data['colId'])){						if(empty($footer))						{						$this->PageTemplateRowsColumn->id = $data['colId'];						$tpldata['PageTemplateRowsColumn']['shortcode'] = '[Banner-'.$newId.']';						$tpldata['PageTemplateRowsColumn']['clone_flag'] = 'Y';						$this->PageTemplateRowsColumn->save($tpldata);						}else {						$this->FooterColumn->id = $data['colId'];						$tpldata['FooterColumn']['shortcode'] = '[Banner-'.$newId.']';																		$this->FooterColumn->save($tpldata);												}					}					echo 1; exit();				} else {					echo 0; exit();				}			} else {				echo 0; exit();			}		}	}
	
	public function admin_copyitem($id){
		if(!empty($id)){
			$arr = array_keys($this->CmsBanner->schema());
			unset($arr[0]);
			$this->CmsGallery->bindModel(
				array(
					'hasMany'=>array(
						'CmsBanner'=>array(
							'className'=>'CmsBanner',
							'foreignKey'=>'gallery_id',
							'fields'=>$arr
						)
					)
				)
			);
			
			
			$orgWidget = $this->CmsGallery->findById($id);	
			unset($orgWidget['CmsGallery']['id']);
			
			$slugArr = array('controller_name'=>'CmsGalleries','action_name'=>'gallery');
			$orgWidget['CmsGallery']['gallery_slug'] = AppController::get_slug($orgWidget['CmsGallery']['gallery_name'],$slugArr);
			
			$this->CmsGallery->create();
			$fl = $this->CmsGallery->save($orgWidget);
			$newId = $this->CmsGallery->id;
			
			if(!empty($newId)){
				if(!empty($orgWidget['CmsBanner'])){
					foreach($orgWidget['CmsBanner'] as $widgetItem){
						$saveData['CmsBanner'] = $widgetItem;
						if(!empty($widgetItem['banner_image'])){
							$newfileName = rand()."_".time();
							$fileName = $this->copyFile($widgetItem['banner_image'], $newfileName, ROOT.DS.APP_DIR .'/webroot/img/uploads/banner_image/');
							$saveData['CmsBanner']['banner_image'] = $fileName;
						} else {
							$saveData['CmsBanner']['banner_image'] = '';
						}
						
						if(!empty($widgetItem['banner_back_image'])){
							$newfileName = rand()."_".time();
							$fileName = $this->copyFile($widgetItem['banner_back_image'], $newfileName, ROOT.DS.APP_DIR .'/webroot/img/uploads/banner_back_image/');
							$saveData['CmsBanner']['banner_back_image'] = $fileName;
						} else {
							$saveData['CmsBanner']['banner_back_image'] = '';
						}
						
						$saveData['CmsBanner']['gallery_id'] = $newId;
						
						$this->CmsBanner->create();
						$this->CmsBanner->save($saveData);
					}
				}
				
				$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(2, $id);
				if(!empty($shortcode)){
					$shortcode['Shortcode']['widget_id'] = $newId;
					unset($shortcode['Shortcode']['id']);
					$this->Shortcode->create();
					$this->Shortcode->save($shortcode);
				}
				
				return '[Banner-'.$newId.']';
			} else {
				return "";
			}
		} else {
			return "";
		}
	}
	
	private function copyFile($fileName, $newfileName, $folderPath){
		if(!empty($fileName)){
			$folderArr = array('original', 'resize', 'thumb');
			
			foreach($folderArr as $folder){
				$dir = new Folder($folderPath.$folder, true, 0755);
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
		
	public function admin_bannerimgdelete( $id = NULL, $gallery_id = NULL ){
		$this->loadModel('CmsBanner');
		$data = $this->CmsBanner->findById($id);
		//pr($data);exit();
		if(!empty($data['CmsBanner']['banner_image'])){
			$original_path=UPLOADS_FOLDER . DS .'banner_image'. DS.'original'. DS .$data['CmsBanner']['banner_image'];
			$resize_path=UPLOADS_FOLDER . DS .'banner_image'. DS.'resize'. DS .$data['CmsBanner']['banner_image'];
			$thumb_path=UPLOADS_FOLDER . DS .'banner_image'. DS.'thumb'. DS .$data['CmsBanner']['banner_image'];
			
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
			
			$this->CmsBanner->id = $data['CmsBanner']['id'];
			$deleteFlag = $this->CmsBanner->save($mydata);
			
			if($deleteFlag){
				$this->Session->setFlash('Image delete successfully!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete image', 'default', array('class' => 'alert alert-danger'));
			}
			
			$this->redirect(array('controller'=>'CmsGalleries', 'action'=>'admin_manage/'.$gallery_id));
		}
	}
	
	public function admin_bannerimgdeleteback( $id = NULL, $gallery_id = NULL ){
		$this->loadModel('CmsBanner');
		$data = $this->CmsBanner->findById($id);
		//pr($data);exit();
		if(!empty($data['CmsBanner']['banner_back_image'])){
			$original_path=UPLOADS_FOLDER . DS .'banner_back_image'. DS.'original'. DS .$data['CmsBanner']['banner_back_image'];
			$resize_path=UPLOADS_FOLDER . DS .'banner_back_image'. DS.'resize'. DS .$data['CmsBanner']['banner_back_image'];
			$thumb_path=UPLOADS_FOLDER . DS .'banner_back_image'. DS.'thumb'. DS .$data['CmsBanner']['banner_back_image'];
			
			if(file_exists($original_path)){
				unlink($original_path);
			}
			if(file_exists($resize_path)){
				unlink($resize_path);
			}
			if(file_exists($thumb_path)){
				unlink($thumb_path);
			}
			
			$mydata['CmsBanner']['banner_back_image']="";
			
			$this->CmsBanner->id = $data['CmsBanner']['id'];
			$deleteFlag = $this->CmsBanner->save($mydata);
			
			if($deleteFlag){
				$this->Session->setFlash('Image delete successfully!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete image', 'default', array('class' => 'alert alert-danger'));
			}
			
			$this->redirect(array('controller'=>'CmsGalleries', 'action'=>'admin_manage/'.$gallery_id));
		}
	}
	
	public function admin_removerow( $id = NULL, $gallery_id = NULL ){
		$this->loadModel('CmsBanner');
		$data = $this->CmsBanner->findById($id);
		//pr($data);exit();
		if(!empty($data['CmsBanner']['id'])){
			$original_path=UPLOADS_FOLDER . DS .'banner_image'. DS.'original'. DS .$data['CmsBanner']['banner_image'];
			$resize_path=UPLOADS_FOLDER . DS .'banner_image'. DS.'resize'. DS .$data['CmsBanner']['banner_image'];
			$thumb_path=UPLOADS_FOLDER . DS .'banner_image'. DS.'thumb'. DS .$data['CmsBanner']['banner_image'];
			
			if(!empty($data['CmsBanner']['banner_image'])){
				if(file_exists($original_path)){
					unlink($original_path);
				}
				if(file_exists($resize_path)){
					unlink($resize_path);
				}
				if(file_exists($thumb_path)){
					unlink($thumb_path);
				}
			}
			
			$deleteFlag = $this->CmsBanner->delete($data['CmsBanner']['id']);
			
			if($deleteFlag){
				$this->Session->setFlash('Row delete successfully!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete row', 'default', array('class' => 'alert alert-danger'));
			}
			
			$this->redirect(array('controller'=>'CmsGalleries', 'action'=>'admin_manage/'.$gallery_id));
		}
	}
	
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		//pr($id); exit();
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->CmsGallery->findById($id);
			$data['CmsGallery']['is_del'] = $stat;
			$this->CmsGallery->id = $id;
			$deleteFlag = $this->CmsGallery->save($data);
				if($deleteFlag)
				{
					$this->loadModel('Slug');
					$find_slug = $this->Slug->findBySlugName($data['CmsGallery']['gallery_slug']);
					$this->Slug->delete($find_slug['Slug']['id']);
					
					foreach($data as $dt)
						{
							/* $this->loadModel('CmsBanner');
							$ban = $this->CmsBanner->findByGalleryId($dt['id']); */
						
							$this->CmsBanner->deleteAll(array('CmsBanner.gallery_id'=>$dt['id']));
						}
				}

			if($deleteFlag){
				$this->Session->setFlash('<p>Gallery removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Gallery can not be removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
}	
?>