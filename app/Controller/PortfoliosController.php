<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class PortfoliosController extends AppController {

	public $name = 'Portfolios';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('Portfolio', 'PortfolioContent', 'Style', 'Shortcode', 'PageTemplateRowsColumn','FooterColumn','Page');
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
			foreach($data['Portfolio'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['Portfolio.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
						if(in_array($k,$titlekeyArr)){
							$conditionArr['Portfolio.'.$k.' LIKE'] = '%'.$v.'%';
						} else {
							$conditionArr['Portfolio.'.$k] = $v;
						}
					}
				}
			}
			$conditionArr['Portfolio.isdel'] = 0;
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Portfolio.id' => 'DESC')
			);
			$this->set('searchData',$data);
		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('Portfolio.isdel'=>'0'),
					'order'=>array('Portfolio.id' => 'DESC')
					);
			
		}
		$data= $this->paginate('Portfolio');

		$this->set('data', $data);
		
	}
	
	public function admin_manage($id=NULL){
		$this->layout = 'adminInner';
		if($this->request->is("post")){
			
			if($id != ''){
				$this->Portfolio->id = $id;
				$this->request->data['Portfolio']['date_modified'] = date("Y-m-d H:m:s");
			} else{
				$this->request->data['Portfolio']['date_created'] = date("Y-m-d H:m:s");
				$this->Portfolio->create();
			}
			$data = $this->request->data;
			//pr($data); exit();
			
			if(array_key_exists('category', $data['Portfolio'])){
				$data['Portfolio']['category'] = implode(",",$data['Portfolio']['category']);
			} else {
				$data['Portfolio']['category'] = '';
			}
			
			
			if($data['Portfolio']['style'] =='style6')
			{
				$data['Portfolio']['position'] = 2;
			}
			if($data['Portfolio']['style'] =='style5')
			{
				$data['Portfolio']['position'] = 1;
				$data['Portfolio']['category_type'] = 'N';
			}
			
			
			$return =  $this->Portfolio->save($data);
			$saveId = $this->Portfolio->id;

			if($return['Portfolio']['id'] != ''){
				$this->Session->setFlash('<p>Image Box updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else{
				$this->Session->setFlash('<p>Image Box added successfully!</p>', 'default', array('class' => 'alert alert-success'));
			}
			
			if($data['Portfolio']['status']=='Y')
			{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Portfolio',$return['Portfolio']['id']);
			
				if(empty($get_data))
				{
					$styleData = $this->Style->findByGroupIdAndWidgetstyleName(31,$data['Portfolio']['style']);
					//pr($styleData); exit;
					$data['Shortcode']['controller'] 	= 'Portfolios';
					$data['Shortcode']['action']		= 'manage';
					$data['Shortcode']['widget_id'] 	= $return['Portfolio']['id'];
					$data['Shortcode']['widget_title'] 	= $data['Portfolio']['name'];
					$data['Shortcode']['name'] 			= 'Portfolio';
					$data['Shortcode']['group_id'] 		= 31;
					$data['Shortcode']['style_id'] 	= $styleData['Style']['id'];
					$this->Shortcode->create();
					
					$this->Shortcode->save($data);
				} else {
					$styleData = $this->Style->findByGroupIdAndWidgetstyleName(31,$data['Portfolio']['style']);
					$scdata = $this->Shortcode->findByNameAndWidgetId('Portfolio',$saveId);
					$this->Shortcode->id=$scdata['Shortcode']['id'];
					$savedata['Shortcode']['controller'] 	= 'Portfolios';
					$savedata['Shortcode']['action']		= 'manage';
					$savedata['Shortcode']['widget_id'] 	= $saveId;
					$savedata['Shortcode']['widget_title'] 	= $data['Portfolio']['name'];
					$savedata['Shortcode']['name'] 			= 'Portfolio';
					$savedata['Shortcode']['group_id'] 		= 31;
					$savedata['Shortcode']['style_id'] 		= $styleData['Style']['id'];
				
					$this->Shortcode->save($savedata);
				}
			}

			if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'Portfolios','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'Portfolios','action'=>'admin_index'));
				}
			
			//$this->redirect('/admin/Portfolios/manage/'.$return['Portfolio']['id']);
			
		}
		$stylesArr = $this->Style->find('list', array(
				'conditions'=>array(
					'Style.group_id'=>31
				),
				'fields'=>array(
					'widgetstyle_name', 'name'
				)
			)
		);
		
		
		$this->set('id', $id);
		if($id != NULL || $id != ''){
			//$this->loadModel('Tabs');
			
			$this->Portfolio->bindModel(array(
									'hasMany' => array(
										'PortfolioContent' => array(
												'className'    => 'PortfolioContent',
												'foreignKey'   => 'portfolio_id',
												'conditions'=>array('PortfolioContent.isdel'=>'0')	
											),
										
									)
								));
			
			$data = $this->Portfolio->findById($id);
			if(!empty($data)){
				$accordionStyle = $this->Style->findByGroupIdAndWidgetstyleName(31,$data['Portfolio']['style']);
			} else {
				$accordionStyle = array();
			}
			
			$this->set(compact('data','accordionStyle'));
		}
		
		$this->set(compact('stylesArr'));
		
		$this->loadModel('style');
		$accordiondata=$this->style->find('all', array(
				'order'=>array('style.id ASC'),
				'fields'=>array('style.widgetstyle_name', 'style.style_img','style.name'),
				'conditions'=>array('style.group_id'=>31)
			)
		);
		
		$this->set('accordiondata',$accordiondata);
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
	$arr = array_keys($this->PortfolioContent->schema());				unset($arr[0]);				$this->Portfolio->bindModel(					array(						'hasMany'=>array(							'PortfolioContent'=>array(								'className'=>'PortfolioContent',								'foreignKey'=>'portfolio_id',								'fields'=>$arr							)						)					)				);												$orgWidget = $this->Portfolio->findById($data['widgetId']);												unset($orgWidget['Portfolio']['id']);								$this->Portfolio->create();				$fl = $this->Portfolio->save($orgWidget);				$newId = $this->Portfolio->id;								if(!empty($newId)){					if(!empty($orgWidget['PortfolioContent'])){						foreach($orgWidget['PortfolioContent'] as $widgetItem){							if(!empty($widgetItem['image'])){								$newfileName = rand()."_".time();								$fileName = $this->copyFile($widgetItem['image'], $newfileName);								$saveData['PortfolioContent']['image'] = $fileName;							} else {								$saveData['PortfolioContent']['image'] = '';							}														$saveData['PortfolioContent']['portfolio_id'] = $newId;														$this->PortfolioContent->create();							$this->PortfolioContent->save($saveData);						}					}										$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(31, $data['widgetId']);					if(!empty($shortcode)){						$shortcode['Shortcode']['widget_id'] = $newId;						unset($shortcode['Shortcode']['id']);						$this->Shortcode->create();						$this->Shortcode->save($shortcode);					}										if(!empty($data['colId'])){						if(empty($footer))						{						$this->PageTemplateRowsColumn->id = $data['colId'];						$tpldata['PageTemplateRowsColumn']['shortcode'] = '[Portfolio-'.$newId.']';						$tpldata['PageTemplateRowsColumn']['clone_flag'] = 'Y';						$this->PageTemplateRowsColumn->save($tpldata);						}else {						$this->FooterColumn->id = $data['colId'];						$tpldata['FooterColumn']['shortcode'] = '[Portfolio-'.$newId.']';																		$this->FooterColumn->save($tpldata);												}					}					echo 1; exit();				} else {					echo 0; exit();				}			} else {				echo 0; exit();			}		}	}
	
	public function admin_copyitem($id){
		if(!empty($id)){
			$arr = array_keys($this->PortfolioContent->schema());
			unset($arr[0]);
			$this->Portfolio->bindModel(
				array(
					'hasMany'=>array(
						'PortfolioContent'=>array(
							'className'=>'PortfolioContent',
							'foreignKey'=>'portfolio_id',
							'fields'=>$arr
						)
					)
				)
			);
			
			
			$orgWidget = $this->Portfolio->findById($id);
							
			unset($orgWidget['Portfolio']['id']);
			
			$this->Portfolio->create();
			$fl = $this->Portfolio->save($orgWidget);
			$newId = $this->Portfolio->id;
			
			if(!empty($newId)){
				if(!empty($orgWidget['PortfolioContent'])){
					foreach($orgWidget['PortfolioContent'] as $widgetItem){
						if(!empty($widgetItem['image'])){
							$newfileName = rand()."_".time();
							$fileName = $this->copyFile($widgetItem['image'], $newfileName);
							$saveData['PortfolioContent']['image'] = $fileName;
						} else {
							$saveData['PortfolioContent']['image'] = '';
						}
						
						$saveData['PortfolioContent']['portfolio_id'] = $newId;
						
						$this->PortfolioContent->create();
						$this->PortfolioContent->save($saveData);
					}
				}
				
				$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(31, $id);
				if(!empty($shortcode)){
					$shortcode['Shortcode']['widget_id'] = $newId;
					unset($shortcode['Shortcode']['id']);
					$this->Shortcode->create();
					$this->Shortcode->save($shortcode);
				}
				
				return '[Portfolio-'.$newId.']';
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
				$dir = new Folder(ROOT.DS.APP_DIR .'/webroot/img/uploads/portfolio_image/'.$folder, true, 0755);
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
		$this->set('style', $this->request->data['style']);
		$this->set('styler', $this->request->data['styler']);
		$this->set('portfolio_id', $this->request->data['portfolio_id']);
		$data = $this->Portfolio->findById($this->request->data['portfolio_id']);
		$this->set('data_category',$data);
		$this->loadModel('PortfolioContent');
		if($this->request->data['id'] != ''){			
			
			$data12 = $this->PortfolioContent->findById($this->request->data['id']);
			$this->set('data1',$data12);
		}
	}
	
	
	public function admin_boxmanageupdate($b_id,$id=NULL){
		$this->layout = 'adminInner';
		
		if($this->request->is("post")){
			$this->loadModel('PortfolioContent');
			
			if(array_key_exists('image',$this->request->data['Portfolio'])){
				if($this->request->data['Portfolio']['image']['name']!=""){
					list($file1,$error1,$update_field1) = AppController::upload($this->request->data['Portfolio']['image'],WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'portfolio_image'. DS . 'original' . DS ,'jpg,jpeg,JPG,JPEG,gif,GIF,png,PNG');
							
					if($error1 == ""){
						$image	=	new SimpleImage();
						
						$image->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'portfolio_image'. DS . 'original' . DS .$file1); 
						$image_size=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'portfolio_image'. DS . 'original' . DS .$file1,1140,760); 
						$image->resize($image_size['0'],$image_size['1']); 
						$image->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'portfolio_image'. DS . 'resize' . DS .$file1); 
						
						$thumb	=	new SimpleImage();
						
						$thumb->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'portfolio_image'. DS . 'original' . DS .$file1); 
						$image_size=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'portfolio_image'. DS . 'original' . DS .$file1,360,240); 
						$thumb->resize($image_size['0'],$image_size['1']); 
						$thumb->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'portfolio_image'. DS . 'thumb' . DS .$file1); 
						
						$this->request->data['Portfolio']['image'] = $file1;
					} else {
						$this->request->data['Portfolio']['image'] = "";
					}
				} else {
					if(array_key_exists('set_image', $this->request->data['Portfolio'])){
						if($this->request->data['Portfolio']['set_image']!=""){
							$this->request->data['Portfolio']['image'] = $this->request->data['Portfolio']['set_image'];
						} else {
							$this->request->data['Portfolio']['image'] = '';
						}
					} else {
						$this->request->data['Portfolio']['image'] = '';
					}
				}
			}	
			if($id != ''){
				$this->PortfolioContent->id = $id;
				$data1['PortfolioContent']['date_modified'] = date("Y-m-d");
			} else{
				$data1['PortfolioContent']['date_created'] = date("Y-m-d");
				$this->PortfolioContent->create();
			}
			
			$data = $this->request->data;
			
			/* pr($data);
			exit;  */
			if($data['Portfolio']['popup']=='')
			{
				unset($data['Portfolio']['popup']);
			}
			if($data['Portfolio']['status']=='')
			{
				unset($data['Portfolio']['status']);
			}
			
			$data1['PortfolioContent'] = $data['Portfolio'];
			
			
			
			$return =  $this->PortfolioContent->save($data1);
			
			
			if($return['PortfolioContent']['id'] !== ''){
				$this->Session->setFlash('<p>Image Box Content updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else{
				$this->Session->setFlash('<p>Image Box Content added successfully!</p>', 'default', array('class' => 'alert alert-success'));
			}
			
			
			
			$this->redirect('/admin/Portfolios/manage/'.$b_id);
			
		}
		
		
		$this->set('id', $id);
		if($id != NULL || $id != ''){
			$this->loadModel('Portfolio');
			
			$this->Portfolio->bindModel(array(
									'hasMany' => array(
										'PortfolioContent' => array(
												'className'    => 'PortfolioContent',
												'foreignKey'   => 'portfolio_id'
											)
									)
								));
			
			$data = $this->Portfolio->findById($id);
			$this->set('data',$data);
		}
	}
	
	
	
	
	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Portfolio']['isdel'] = $isdel; 
		$this->Portfolio->id = $id;
		$deleteFlag = $this->Portfolio->save($data);
		$this->loadModel('PortfolioContent');
		
		$this->Portfolio->updateAll(
			array( 'Portfolio.isdel' => $isdel ),   //fields to update
			array( 'Portfolio.id' => $id )  //condition
		);
		
		if($deleteFlag)
		{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Portfolio',$id);
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
		$this->loadModel('PortfolioContent');
		$data['PortfolioContent']['isdel'] = $isdel; 
		$this->PortfolioContent->id = $id;
		$this->PortfolioContent->save($data);
		$this->Session->setFlash('<p>Image Box details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->Portfolio->findById($id);
			
			$data['Portfolio']['isdel'] = $stat;
			$this->Portfolio->id = $id;
			$deleteFlag = $this->Portfolio->save($data);
			if($deleteFlag){
			
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Portfolio',$id);
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
		$data['Portfolio']['status'] = $stat;
		
		$this->Portfolio->id = $id;
		$this->Portfolio->save($data);
		$this->Session->setFlash('<p>Image Box updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	public function admin_imgdelete($id=null,$mid=null){

		$data=$this->request->params['named'];
		if($data['id']){
			$original_path=UPLOADS_FOLDER . DS .'portfolio_image'. DS.'original'. DS .$data['image_name'];
			$resize_path=UPLOADS_FOLDER . DS .'portfolio_image'. DS.'resize'. DS .$data['image_name'];
			$thumb_path=UPLOADS_FOLDER . DS .'portfolio_image'. DS.'thumb'. DS .$data['image_name'];
			
			if(file_exists($original_path)){
				unlink($original_path);
			}
			if(file_exists($resize_path)){
				unlink($resize_path);
			}
			if(file_exists($thumb_path)){
				unlink($thumb_path);
			}
			$this->loadModel('PortfolioContent');
			$mydata['PortfolioContent']['image']="";
			
			$this->PortfolioContent->id = $data['id'];
			$updateFlag = $this->PortfolioContent->save($mydata);
			
			if($updateFlag){
				$this->Session->setFlash('<p>Image deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('<p>Failed to delete image!</p>', 'default', array('class' => 'alert alert-danger'));
			}
			$this->redirect('/admin/Portfolios/manage/'.$data['mid'].'/'.$data['id']);
		}
	}

}
?>