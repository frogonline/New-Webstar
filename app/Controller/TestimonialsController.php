<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');

class TestimonialsController extends AppController {
	
	public $name = 'Testimonials';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('Testimonials', 'TestimonialContent', 'Style', 'Shortcode', 'PageTemplateRowsColumn','FooterColumn','Page');
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
			$likekeyArr = array('name');
			$datekeyArr = array('test_date');
			$conditionArr = array();
			foreach($data['Testimonials'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['Testimonials.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
						if(in_array($k,$datekeyArr)){
							$conditionArr['Testimonials.'.$k] = date('Y-m-d',strtotime($v)); 
						} else {
							$conditionArr['Testimonials.'.$k] = $v; 
						}
					}
				}
			}
			$conditionArr['Testimonials.isdel'] = 0;
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Testimonials.id' => 'DESC')
			);
			$this->set('searchData',$data);

		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('Testimonials.isdel'=>'0'),
					'order'=>array('Testimonials.id' => 'DESC')
					);
			
		}
		$stylesArr = $this->Style->find('list', array(
				'conditions'=>array(
					'Style.group_id'=>25
				),
				'fields'=>array(
					'widgetstyle_name', 'name'
				)
			)
		);
		$data=$this->paginate('Testimonials');
		$this->set(compact('data','stylesArr'));
	}
	
	
	public function admin_manage($id=NULL){
		$this->layout = 'adminInner';
		if($this->request->is("post")){
			
			if($id != ''){
				$this->Testimonials->id = $id;
				$this->request->data['Testimonials']['date_modified'] = date("Y-m-d H:m:s");
			} else{
				$this->request->data['Testimonials']['date_created'] = date("Y-m-d H:m:s");
				$this->Testimonials->create();
			}
			
			
			
			$data = $this->request->data;
			//pr($data);
			//exit;
			//$data['Tabs']['name'] = implode(",",$data['Tabs']['name']);
		
			
			$return =  $this->Testimonials->save($data);
			$saveId = $this->Testimonials->id;
			
			
			if($return['Testimonials']['id'] != ''){
				$this->Session->setFlash('<p>Testimonial updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else{
				$this->Session->setFlash('<p>Testimonial added successfully!</p>', 'default', array('class' => 'alert alert-success'));
			}
			
			if($data['Testimonials']['status']=='Y')
			{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Testimonial',$return['Testimonials']['id']);
			
				if(empty($get_data))
				{   
				
				    $styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['Testimonials']['style'], 25);
					$data['Shortcode']['controller'] 	= 'Testimonials';
					$data['Shortcode']['action']		= 'manage';
					$data['Shortcode']['widget_id'] 	= $return['Testimonials']['id'];
					$data['Shortcode']['widget_title'] 	= $data['Testimonials']['name'];
					$data['Shortcode']['name'] 			= 'Testimonial';
					$data['Shortcode']['group_id'] 		= 25;
					$data['Shortcode']['style_id'] 		= $styleData['Style']['id'];
					$this->Shortcode->create();
					
					$this->Shortcode->save($data);
				} else {
					$styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['Testimonials']['style'], 25);
					$scdata = $this->Shortcode->findByNameAndWidgetId('Testimonial',$saveId);
					$this->Shortcode->id=$scdata['Shortcode']['id'];
					$savedata['Shortcode']['controller'] 	= 'Testimonials';
					$savedata['Shortcode']['action']		= 'manage';
					$savedata['Shortcode']['widget_id'] 	= $saveId;
					$savedata['Shortcode']['widget_title'] 	= $data['Testimonials']['name'];
					$savedata['Shortcode']['name'] 			= 'Testimonial';
					$savedata['Shortcode']['group_id'] 		= 25;
					$savedata['Shortcode']['style_id'] 		= $styleData['Style']['id'];
				
					$this->Shortcode->save($savedata);
				}
			}
			
			if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'Testimonials','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'Testimonials','action'=>'admin_index'));
				}
			//$this->redirect('/admin/Testimonials/manage/'.$return['Testimonials']['id']);
			
		}
		
		$stylesArr = $this->Style->find('list', array(
				'conditions'=>array(
					'Style.group_id'=>25
				),
				'fields'=>array(
					'widgetstyle_name', 'name'
				)
			)
		);
		$this->set('id', $id);
		if($id != NULL || $id != ''){
			$this->loadModel('TestimonialContent');
			
			$this->Testimonials->bindModel(array(
									'hasMany' => array(
										'TestimonialContent' => array(
												'className'    => 'TestimonialContent',
												'foreignKey'   => 'testimonial_id',
												'conditions'=>array('TestimonialContent.isdel'=>'0')	
											),
										
									)
								));
			
			$data = $this->Testimonials->findById($id);
			if(!empty($data)){
				$widgetStyle = $this->Style->findByGroupIdAndWidgetstyleName(25,$data['Testimonials']['style']);
			} else {
				$widgetStyle = array();
			}
			$this->set(compact('data', 'widgetStyle'));
			
		}
		$this->set(compact('stylesArr'));
		
			$this->loadModel('style');
		    $testimonial_styledata=$this->style->find('all', array(
					'order'=>array('style.id ASC'),
					'fields'=>array('style.widgetstyle_name', 'style.style_img','style.name'),
					'conditions'=>array('style.group_id'=>25)
				)
			);
			//pr($testimonial_styledata); exit;
		    $this->set('testimonial_styledata',$testimonial_styledata);
	}
	
	
	public function admin_boxmanage(){
		$this->layout = 'ajax';
		
		$this->set('id', $this->request->data['id']);
		$this->set('style', $this->request->data['style']);
		$this->set('tab_id', $this->request->data['tab_id']);
		
		$this->loadModel('TestimonialContent');
		if($this->request->data['id'] != ''){			
			
			$data12 = $this->TestimonialContent->findById($this->request->data['id']);
			$this->set('data1',$data12);
		}
	}
	
	
	public function admin_boxmanageupdate($b_id,$style,$id=NULL){	
		$this->layout = 'adminInner';
		$this->loadModel('TestimonialContent');
		if($this->request->is('post'))
		{	
			$data = $this->request->data;
			//pr($data); exit;
			//$this->TestimonialContent->set($this->request->data);
			

				if($this->request->data['Testimonial']['style'] !='style3')
				{
					if(array_key_exists('testimonial_image', $this->request->data['Testimonial'])){
						if($this->request->data['Testimonial']['testimonial_image']['name']!="")
						{
						list($file1,$error1,$update_field1) = AppController::upload($this->request->data['Testimonial']['testimonial_image'], UPLOADS_FOLDER . DS . 'testimonial_image'. DS . 'original' . DS ,'jpg,jpeg,JPG,JPEG,gif,GIF,png,PNG');
						
							if($error1 == "")
							{
								$image	=	new SimpleImage();
								
								$image->load(UPLOADS_FOLDER . DS . 'testimonial_image'. DS . 'original' . DS .$file1); 
								$image_size=AppController::resize_to_save(UPLOADS_FOLDER . DS . 'testimonial_image'. DS . 'original' . DS .$file1,75,75); 
								$image->resize($image_size['0'],$image_size['1']); 
								$image->save(UPLOADS_FOLDER . DS . 'testimonial_image'. DS . 'resize' . DS .$file1); 
								
								$thumb	=	new SimpleImage();
								
								$thumb->load(UPLOADS_FOLDER . DS . 'testimonial_image'. DS . 'original' . DS .$file1); 
								$image_size=AppController::resize_to_save(UPLOADS_FOLDER . DS . 'testimonial_image'. DS . 'original' . DS .$file1,40,40); 
								$thumb->resize($image_size['0'],$image_size['1']); 
								$thumb->save(UPLOADS_FOLDER . DS . 'testimonial_image'. DS . 'thumb' . DS .$file1); 
								
								$this->request->data['Testimonial']['testimonial_image'] = $file1;
							}
							else
							{
								$this->request->data['Testimonial']['testimonial_image'] = "";
							}
						}
						else if($this->request->data['Testimonial']['set_testimonial_image']!="")
						{
							$this->request->data['Testimonial']['testimonial_image'] = $this->request->data['Testimonial']['set_testimonial_image'];
						}
						else
						{
							$this->request->data['Testimonial']['testimonial_image'] = '';
						}
					}
				}
					
				
				/* if($this->request->data['Testimonial']['test_date']!='')
				{
					$this->request->data['Testimonial']['test_date'] = str_replace('/','-',$this->request->data['Testimonial']['test_date']);
					$this->request->data['Testimonial']['test_date'] = date("Y-m-d",strtotime($this->request->data['Testimonial']['test_date']));	
				} */
				
				if($this->request->data['Testimonial']['id'] != '')
				{
	
					$data['TestimonialContent']['modified_date'] = date("Y-m-d");
					$this->TestimonialContent->id = $id;
				} 
				else
				{
					
					$this->request->data['TestimonialContent']['created_date'] = date("Y-m-d");
					$this->TestimonialContent->create();
				}
				
				
				$this->request->data['TestimonialContent']=$this->request->data['Testimonial'];
				
				
				$this->TestimonialContent->save($this->request->data);
				
				if($this->TestimonialContent->id == $id)
				{
					$this->Session->setFlash('<p>Testimonials Content details has been updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
				} 
				else
				{
					$this->Session->setFlash('<p>Testimonials Content details has been added successfully!</p>', 'default', array('class' => 'alert alert-success'));
				}
					//$this->redirect(array('controller'=>'Testimonials','action'=>'admin_index'));
				
			//} 
			$this->redirect('/admin/Testimonials/manage/'.$b_id);
		}
		$this->set('id', $id);
		if($id != NULL || $id != ''){
			$this->loadModel('TestimonialContent');
			
			$this->Testimonials->bindModel(array(
									'hasMany' => array(
										'TestimonialContent' => array(
												'className'    => 'TestimonialContent',
												'foreignKey'   => 'testimonial_id'
											)
									)
								));
			
			$data = $this->Testimonials->findById($id);
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
	
	$arr = array_keys($this->TestimonialContent->schema());				unset($arr[0]);				$this->Testimonials->bindModel(					array(						'hasMany'=>array(							'TestimonialContent'=>array(								'className'=>'TestimonialContent',								'foreignKey'=>'testimonial_id',								'fields'=>$arr							)						)					)				);												$orgWidget = $this->Testimonials->findById($data['widgetId']);								unset($orgWidget['Testimonials']['id']);								$this->Testimonials->create();				$fl = $this->Testimonials->save($orgWidget);				$newId = $this->Testimonials->id;								if(!empty($newId)){					if(!empty($orgWidget['TestimonialContent'])){						foreach($orgWidget['TestimonialContent'] as $widgetItem){							$saveData['TestimonialContent'] = $widgetItem;							if(!empty($widgetItem['testimonial_image'])){								$newfileName = rand()."_".time();								$fileName = $this->copyFile($widgetItem['testimonial_image'], $newfileName);								$saveData['TestimonialContent']['testimonial_image'] = $fileName;							} else {								$saveData['TestimonialContent']['testimonial_image'] = '';							}														$saveData['TestimonialContent']['testimonial_id'] = $newId;														$this->TestimonialContent->create();							$this->TestimonialContent->save($saveData);						}					}										$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(25, $data['widgetId']);					if(!empty($shortcode)){						$shortcode['Shortcode']['widget_id'] = $newId;						unset($shortcode['Shortcode']['id']);						$this->Shortcode->create();						$this->Shortcode->save($shortcode);					}										if(!empty($data['colId'])){						if(empty($footer))						{						$this->PageTemplateRowsColumn->id = $data['colId'];						$tpldata['PageTemplateRowsColumn']['shortcode'] = '[Testimonial-'.$newId.']';						$tpldata['PageTemplateRowsColumn']['clone_flag'] = 'Y';						$this->PageTemplateRowsColumn->save($tpldata);						}else {						$this->FooterColumn->id = $data['colId'];						$tpldata['FooterColumn']['shortcode'] = '[Testimonial-'.$newId.']';																		$this->FooterColumn->save($tpldata);												}					}					echo 1; exit();				} else {					echo 0; exit();				}			} else {				echo 0; exit();			}		}	}	
	
	public function admin_copyitem($id){
		if(!empty($id)){
			$arr = array_keys($this->TestimonialContent->schema());
			unset($arr[0]);
			$this->Testimonials->bindModel(
				array(
					'hasMany'=>array(
						'TestimonialContent'=>array(
							'className'=>'TestimonialContent',
							'foreignKey'=>'testimonial_id',
							'fields'=>$arr
						)
					)
				)
			);
			
			
			$orgWidget = $this->Testimonials->findById($id);				
			unset($orgWidget['Testimonials']['id']);
			
			$this->Testimonials->create();
			$fl = $this->Testimonials->save($orgWidget);
			$newId = $this->Testimonials->id;
			
			if(!empty($newId)){
				if(!empty($orgWidget['TestimonialContent'])){
					foreach($orgWidget['TestimonialContent'] as $widgetItem){
						$saveData['TestimonialContent'] = $widgetItem;
						if(!empty($widgetItem['testimonial_image'])){
							$newfileName = rand()."_".time();
							$fileName = $this->copyFile($widgetItem['testimonial_image'], $newfileName);
							$saveData['TestimonialContent']['testimonial_image'] = $fileName;
						} else {
							$saveData['TestimonialContent']['testimonial_image'] = '';
						}
						
						$saveData['TestimonialContent']['testimonial_id'] = $newId;
						
						$this->TestimonialContent->create();
						$this->TestimonialContent->save($saveData);
					}
				}
				
				$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(25, $id);
				if(!empty($shortcode)){
					$shortcode['Shortcode']['widget_id'] = $newId;
					unset($shortcode['Shortcode']['id']);
					$this->Shortcode->create();
					$this->Shortcode->save($shortcode);
				}
				
				return '[Testimonial-'.$newId.']';
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
				$dir = new Folder(ROOT.DS.APP_DIR .'/webroot/img/uploads/testimonial_image/'.$folder, true, 0755);
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
		$data['Testimonials']['isdel'] = $isdel; 
		$this->Testimonials->id = $id;
		$deleteFlag = $this->Testimonials->save($data);
		
		$this->loadModel('TestimonialContent');
		
		$this->TestimonialContent->updateAll(
			array( 'TestimonialContent.isdel' => $isdel ),   //fields to update
			array( 'TestimonialContent.testimonial_id' => $id )  //condition
		);
		
		if($deleteFlag)
		{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Testimonial',$id);
				//pr($get_data); exit;
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
		}
		
		
		$this->Session->setFlash('<p> Testimonials details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	
	public function admin_boxdelete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$this->loadModel('TestimonialContent');
		$data['TestimonialContent']['isdel'] = $isdel; 
		$this->TestimonialContent->id = $id;
		$this->TestimonialContent->save($data);
		$this->Session->setFlash('<p>Testimonial Content details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Testimonials']['status'] = $stat;
		
		$this->Testimonials->id = $id;
		$updateFlag = $this->Testimonials->save($data);
		
		if($updateFlag){
			$this->Session->setFlash('Testimonials status changed successfully!', 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('Failed to change status!', 'default', array('class' => 'alert alert-danger'));
		}
		$this->redirect($this->referer());
	}
	
	public function admin_deleteAll($idAll=NULL, $isdel='0')
	{	
		//pr($id); exit();
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			
			$data['Testimonials']['isdel'] = $isdel; 
			$this->Testimonials->id = $id;
			$deleteFlag = $this->Testimonials->save($data);
			
			if($deleteFlag){
			
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Testimonial',$id);
				//pr($get_data); exit;
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
				
				$this->Session->setFlash('The Testimonials has been successfully removed!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete the Testimonials!', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	public function admin_imgdelete( ){
		$data=$this->request->params['named'];
		//pr($data);exit();
		if($data['id']){
			$original_path=UPLOADS_FOLDER . DS .'testimonial_image'. DS.'original'. DS .$data['image_name'];
			$resize_path=UPLOADS_FOLDER . DS .'testimonial_image'. DS.'resize'. DS .$data['image_name'];
			$thumb_path=UPLOADS_FOLDER . DS .'testimonial_image'. DS.'thumb'. DS .$data['image_name'];
			
			if(file_exists($original_path)){
				unlink($original_path);
			}
			if(file_exists($resize_path)){
				unlink($resize_path);
			}
			if(file_exists($thumb_path)){
				unlink($thumb_path);
			}
			
			$this->loadModel('TestimonialContent');
			$mydata['TestimonialContent']['testimonial_image']="";
			
			$this->TestimonialContent->id = $data['id'];
			$this->TestimonialContent->save($mydata);
			
			$this->Session->setFlash('<p>Image deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
			
			$this->redirect('/admin/Testimonials/manage/'.$data['t_id'].'/'.$data['id']);
		}
	}
	
}
	?>