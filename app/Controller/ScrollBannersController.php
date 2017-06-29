<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class ScrollBannersController extends AppController {

	public $name = 'ScrollBanners';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('ScrollBanner','Style', 'Shortcode', 'PageTemplateRowsColumn','FooterColumn','Page');
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
			foreach($data['ScrollBanner'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['ScrollBanner.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
							$conditionArr['ScrollBanner.'.$k] = $v;
						}
					}
				}
			$conditionArr['ScrollBanner.isdel'] = 0;
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('ScrollBanner.id' => 'DESC')
			);
			$this->set('searchData',$data);
		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('ScrollBanner.isdel'=>'0'),
					'order'=>array('ScrollBanner.id' => 'DESC')
					);
			}
		$data = $this->paginate('ScrollBanner');
		$this->set('data', $data);
	}
	
	public function admin_manage($id=NULL){
		$this->layout = 'adminInner';
		if($this->request->is("post")){
				$data = $this->request->data;
				if(array_key_exists('scroll_image', $data['ScrollBanner'])){
					if($this->request->data['ScrollBanner']['scroll_image']['name']!="")
					{
						list($file1,$error1,$update_field1) = AppController::upload($data['ScrollBanner']['scroll_image'],WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'scroll_image'. DS . 'original' . DS ,'jpg,jpeg,JPG,JPEG,gif,GIF,png,PNG');
						
						if($error1 == "")
						{
							$image	=	new SimpleImage();
							
							$image->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'scroll_image'. DS . 'original' . DS .$file1); 
							$image_size=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'scroll_image'. DS . 'original' . DS .$file1,1920,1280); 
							$image->resize($image_size['0'],$image_size['1']); 
							$image->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'scroll_image'. DS . 'resize' . DS .$file1); 
							
							$thumb	=	new SimpleImage();
							
							$thumb->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'scroll_image'. DS . 'original' . DS .$file1); 
							$image_size=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'scroll_image'. DS . 'original' . DS .$file1,360,240); 
							$thumb->resize($image_size['0'],$image_size['1']); 
							$thumb->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'scroll_image'. DS . 'thumb' . DS .$file1); 
							
							$data['ScrollBanner']['scroll_image'] = $file1;
						} else {
							$data['ScrollBanner']['scroll_image'] = "";
						}
					} 
					else if ($this->request->data['ScrollBanner']['set_image']!=="")
					{
						$data['ScrollBanner']['scroll_image'] = $this->request->data['ScrollBanner']['set_image'];
					} 
					else 
					{
						$data['ScrollBanner']['scroll_image'] = '';
					}
				}
				if($id != ''){
					$this->ScrollBanner->id = $id;
					
				} else{
					
					$this->ScrollBanner->create();
				}
				//pr($data); exit();
			
				$return =  $this->ScrollBanner->save($data);
				$saveId = $this->ScrollBanner->id;

			if($id==''){
				$this->Session->setFlash('<p>Scroll Banner Content added successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else{
				$this->Session->setFlash('<p>Scroll Banner Content updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
			}
			
			if($data['ScrollBanner']['status']=='Y')
			{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Scrollbg',$data['ScrollBanner']['id']);
			
				if(empty($get_data))
				{
				    $styleData = $this->Style->findByGroupId(19);
					$saveData['Shortcode']['controller'] 	= 'ScrollBanners';
					$saveData['Shortcode']['action']		= 'manage';
					$saveData['Shortcode']['widget_id'] 	= $saveId;
					$saveData['Shortcode']['widget_title'] 	= $data['ScrollBanner']['name'];
					$saveData['Shortcode']['name'] 			= 'Scrollbg';
					$saveData['Shortcode']['group_id'] 		= 19;
					$saveData['Shortcode']['style_id'] 		= $styleData['Style']['id'];
					$this->Shortcode->create();
					
					$this->Shortcode->save($saveData);
				} else {
						$styleData = $this->Style->findByGroupId(19);
						$scdata = $this->Shortcode->findByNameAndWidgetId('Scrollbg',$saveId);
						$this->Shortcode->id = $scdata['Shortcode']['id'];
						$savedata['Shortcode']['controller'] 	= 'ScrollBanners';
						$savedata['Shortcode']['action']		= 'manage';
						$savedata['Shortcode']['widget_id'] 	= $saveId;
						$savedata['Shortcode']['widget_title'] 	= $data['ScrollBanner']['name'];
						$savedata['Shortcode']['name'] 			= 'Scrollbg';
						$savedata['Shortcode']['group_id'] 		= 19;
						$savedata['Shortcode']['style_id'] 		= $styleData['Style']['id'];
				
						$this->Shortcode->save($savedata);
					}	
			}
			
			if(array_key_exists('continue', $data)){
				$this->redirect(array('controller'=>'ScrollBanners','action'=>'admin_manage/'.$saveId));
			} else {
				$this->redirect(array('controller'=>'ScrollBanners','action'=>'admin_index'));
			}
		}
		
		
		$this->set('id', $id);
		if($id != NULL || $id != ''){
			
			$data = $this->ScrollBanner->findById($id);
			
			
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
	
	$orgWidget = $this->ScrollBanner->findById($data['widgetId']);							unset($orgWidget['ScrollBanner']['id']);								if(!empty($orgWidget['ScrollBanner']['scroll_image'])){					$newfileName = rand()."_".time();					$fileName = $this->copyFile($orgWidget['ScrollBanner']['scroll_image'], $newfileName);					$orgWidget['ScrollBanner']['scroll_image'] = $fileName;				} else {					$saveData['ScrollBanner']['scroll_image'] = '';				}								$this->ScrollBanner->create();				$fl = $this->ScrollBanner->save($orgWidget);				$newId = $this->ScrollBanner->id;								if(!empty($newId)){					$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(19, $data['widgetId']);					if(!empty($shortcode)){						$shortcode['Shortcode']['widget_id'] = $newId;						unset($shortcode['Shortcode']['id']);						$this->Shortcode->create();						$this->Shortcode->save($shortcode);					}										if(!empty($data['colId'])){						if(empty($footer))						{						$this->PageTemplateRowsColumn->id = $data['colId'];						$tpldata['PageTemplateRowsColumn']['shortcode'] = '[Scrollbg-'.$newId.']';						$tpldata['PageTemplateRowsColumn']['clone_flag'] = 'Y';						$this->PageTemplateRowsColumn->save($tpldata);						}else {						$this->FooterColumn->id = $data['colId'];						$tpldata['FooterColumn']['shortcode'] = '[Scrollbg-'.$newId.']';																		$this->FooterColumn->save($tpldata);												}					}					echo 1; exit();				} else {					echo 0; exit();				}			} else {				echo 0; exit();			}		}	}
	
	public function admin_copyitem($id){
		if(!empty($id)){
			$orgWidget = $this->ScrollBanner->findById($id);			
			unset($orgWidget['ScrollBanner']['id']);
			
			if(!empty($orgWidget['ScrollBanner']['scroll_image'])){
				$newfileName = rand()."_".time();
				$fileName = $this->copyFile($orgWidget['ScrollBanner']['scroll_image'], $newfileName);
				$orgWidget['ScrollBanner']['scroll_image'] = $fileName;
			} else {
				$saveData['ScrollBanner']['scroll_image'] = '';
			}
			
			$this->ScrollBanner->create();
			$fl = $this->ScrollBanner->save($orgWidget);
			$newId = $this->ScrollBanner->id;
			
			if(!empty($newId)){
				$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(19, $id);
				if(!empty($shortcode)){
					$shortcode['Shortcode']['widget_id'] = $newId;
					unset($shortcode['Shortcode']['id']);
					$this->Shortcode->create();
					$this->Shortcode->save($shortcode);
				}
				
				return '[Scrollbg-'.$newId.']';
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
				$dir = new Folder(ROOT.DS.APP_DIR .'/webroot/img/uploads/scroll_image/'.$folder, true, 0755);
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
	
	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['ScrollBanner']['isdel'] = $isdel; 
		$this->ScrollBanner->id = $id;
		$deleteFlag = $this->ScrollBanner->save($data);
		
		/* 
		$this->ScrollBanner->updateAll(
			array( 'ScrollBanner.isdel' => $isdel ),   //fields to update
			array( 'ScrollBanner.id' => $id )  //condition
		); */
		
		if($deleteFlag)
		{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Scrollbg',$id);
				//pr($get_data); exit;
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
		}
		
		$this->Session->setFlash('<p>Scroll Banner details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->ScrollBanner->findById($id);
			
			$data['ScrollBanner']['isdel'] = $stat;
			$this->ScrollBanner->id = $id;
			$deleteFlag = $this->ScrollBanner->save($data);
			if($deleteFlag){
			
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Scrollbg',$id);
				//pr($get_data); exit;
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
				
				$this->Session->setFlash('<p>Scroll Banner removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Scroll Banner removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	public function admin_imgdelete($id=null){

		$data=$this->request->params['named'];
		//pr($data); exit;
		if($data['id']){
			$original_path=UPLOADS_FOLDER . DS .'scroll_image'. DS.'original'. DS .$data['image_name'];
			$resize_path=UPLOADS_FOLDER . DS .'scroll_image'. DS.'resize'. DS .$data['image_name'];
			$thumb_path=UPLOADS_FOLDER . DS .'scroll_image'. DS.'thumb'. DS .$data['image_name'];
			
			if(file_exists($original_path)){
				unlink($original_path);
			}
			if(file_exists($resize_path)){
				unlink($resize_path);
			}
			if(file_exists($thumb_path)){
				unlink($thumb_path);
			}
			$this->loadModel('ScrollBanner');
			$mydata['ScrollBanner']['scroll_image']="";
			
			$this->ScrollBanner->id = $data['id'];
			$updateFlag = $this->ScrollBanner->save($mydata);
			
			if($updateFlag){
				$this->Session->setFlash('<p>Image deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('<p>Failed to delete image!</p>', 'default', array('class' => 'alert alert-danger'));
			}
			$this->redirect('/admin/ScrollBanners/manage/'.$data['id'].'/'.$data['id']);
		}
	}
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['ScrollBanner']['status'] = $stat;
		
		$this->ScrollBanner->id = $id;
		$this->ScrollBanner->save($data);
		$this->Session->setFlash('<p>Scroll Banner updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
}
?>