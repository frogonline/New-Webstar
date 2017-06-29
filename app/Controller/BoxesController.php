<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class BoxesController extends AppController {

	public $name = 'Boxes';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('Box','BoxContent', 'Style', 'Shortcode', 'PageTemplateRowsColumn','FooterColumn','Page');
	public $paginate = array();

	public function beforeFilter() 
	{
		parent::beforeFilter();
		
		$this->Auth->allow('admin_boxmanage');
		
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
			
			$likekeyArr = array('boxname');
			$titlekeyArr = array('boxstyle');
			$conditionArr = array();
			foreach($data['Box'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['Box.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
						if(in_array($k,$titlekeyArr)){
							$conditionArr['Box.'.$k.' LIKE'] = '%'.$v.'%';
						} else {
							$conditionArr['Box.'.$k] = $v; 
						}
					}
				}
			}
			$conditionArr['Box.isdel'] = 0; 
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Box.id' => 'DESC')
			);
			$this->set('searchData',$data);
		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('Box.isdel'=>'0'),
					'order'=>array('Box.id' => 'DESC')
					);
			
		}
		$stylesArr = $this->Style->find('list', array(
				'conditions'=>array(
					'Style.group_id'=>3
				),
				'fields'=>array(
					'widgetstyle_name', 'name'
				)
			)
		);
		$data = $this->paginate('Box');
		$this->set(compact('data', 'stylesArr'));
		
	}
	
	public function admin_manage($id=NULL){
		$this->layout = 'adminInner';
		if($this->request->is("post")){
			
			if($id != ''){
				$this->Box->id = $id;
				$this->request->data['Box']['date_modified'] = date("Y-m-d");
			} else{
				$this->request->data['Box']['date_created'] = date("Y-m-d");
				$this->Box->create();
			}
			
			$data = $this->request->data;
			
			
			
			$return =  $this->Box->save($data);
			$saveId = $this->Box->id;

			
			if($return['Box']['id'] != ''){
				$this->Session->setFlash('<p>Box updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else{
				$this->Session->setFlash('<p>Box added successfully!</p>', 'default', array('class' => 'alert alert-success'));
			}
			
			if($data['Box']['status']=='Y')
			{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Box',$return['Box']['id']);
			
				if(empty($get_data))
				{
					$styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['Box']['boxstyle'], 3);
					//pr($styleData); exit();
					$data['Shortcode']['controller'] 	= 'Boxes';
					$data['Shortcode']['action']		= 'manage';
					$data['Shortcode']['widget_id'] 	= $return['Box']['id'];
					$data['Shortcode']['widget_title'] 	= $data['Box']['boxname'];
					$data['Shortcode']['name'] 			= 'Box';
					$data['Shortcode']['group_id'] 		= 3;
					$data['Shortcode']['style_id'] 		= $styleData['Style']['id'];
					$this->Shortcode->create();
					
					$this->Shortcode->save($data);
				} else {
					$styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['Box']['boxstyle'], 3);
					$scdata = $this->Shortcode->findByNameAndWidgetId('Box',$saveId);
					$this->Shortcode->id = $scdata['Shortcode']['id'];
					$savedata['Shortcode']['controller'] 	= 'Boxes';
					$savedata['Shortcode']['action']		= 'manage';
					$savedata['Shortcode']['widget_id'] 	= $saveId;
					$savedata['Shortcode']['widget_title'] 	= $data['Box']['boxname'];
					$savedata['Shortcode']['name'] 			= 'Box';
					$savedata['Shortcode']['group_id'] 		= 3;
					$savedata['Shortcode']['style_id'] 		= $styleData['Style']['id'];
				
					$this->Shortcode->save($savedata);
				}	
			}
			
			if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'Boxes','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'Boxes','action'=>'admin_index'));
				}
			
			//$this->redirect('/admin/Boxes/manage/'.$return['Box']['id']);
			
		}
		
		$stylesArr = $this->Style->find('list', array(
				'conditions'=>array(
					'Style.group_id'=>3
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
			$this->loadModel('Box');
			
			$this->Box->bindModel(array(
									'hasMany' => array(
										'BoxContent' => array(
											'className'    => 'BoxContent',
											'foreignKey'   => 'box_id',
											'conditions'=>array('BoxContent.isdel'=>'0')	
										),
										
									)
								)
							);
			
			$data = $this->Box->findById($id);
			if(!empty($data)){
				$boxStyle = $this->Style->findByGroupIdAndWidgetstyleName(3,$data['Box']['boxstyle']);
			} else {
				$boxStyle = array();
			}
			
			$this->set(compact('data','boxStyle'));
		}
		
		$this->loadModel('style');
		$boxstyledata=$this->style->find('all', array(
				'order'=>array('style.id ASC'),
				'fields'=>array('style.widgetstyle_name', 'style.style_img','style.name'),
				'conditions'=>array('style.group_id'=>3)
			)
		);
		//pr($boxstyledata); exit;
		$this->set('boxstyledata',$boxstyledata);
		
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
	$arr = array_keys($this->BoxContent->schema());				unset($arr[0]);				$this->Box->bindModel(					array(						'hasMany'=>array(							'BoxContent'=>array(								'className'=>'BoxContent',								'foreignKey'=>'box_id',								'fields'=>$arr							)						)					)				);												$orgWidget = $this->Box->findById($data['widgetId']);				unset($orgWidget['Box']['id']);								$this->Box->create();				$fl = $this->Box->save($orgWidget);				$newId = $this->Box->id;								if(!empty($newId)){					if(!empty($orgWidget['BoxContent'])){						foreach($orgWidget['BoxContent'] as $widgetItem){							$saveData['BoxContent'] = $widgetItem;							$saveData['BoxContent']['box_id'] = $newId;														$this->BoxContent->create();							$this->BoxContent->save($saveData);						}					}										$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(3, $data['widgetId']);					if(!empty($shortcode)){						$shortcode['Shortcode']['widget_id'] = $newId;						unset($shortcode['Shortcode']['id']);						$this->Shortcode->create();						$this->Shortcode->save($shortcode);					}										if(!empty($data['colId'])){						if(empty($footer))						{						$this->PageTemplateRowsColumn->id = $data['colId'];						$tpldata['PageTemplateRowsColumn']['shortcode'] = '[Box-'.$newId.']';						$tpldata['PageTemplateRowsColumn']['clone_flag'] = 'Y';												$this->PageTemplateRowsColumn->save($tpldata);						}else {						$this->FooterColumn->id = $data['colId'];						$tpldata['FooterColumn']['shortcode'] = '[Box-'.$newId.']';																		$this->FooterColumn->save($tpldata);												}					}					echo 1; exit();				} else {					echo 0; exit();				}			} else {				echo 0; exit();			}		}	}
	
	public function admin_copyitem($id){
		if(!empty($id)){
			$arr = array_keys($this->BoxContent->schema());
			unset($arr[0]);
			$this->Box->bindModel(
				array(
					'hasMany'=>array(
						'BoxContent'=>array(
							'className'=>'BoxContent',
							'foreignKey'=>'box_id',
							'fields'=>$arr
						)
					)
				)
			);
			
			
			$orgWidget = $this->Box->findById($id);
			unset($orgWidget['Box']['id']);
			
			$this->Box->create();
			$fl = $this->Box->save($orgWidget);
			$newId = $this->Box->id;
			
			if(!empty($newId)){
				if(!empty($orgWidget['BoxContent'])){
					foreach($orgWidget['BoxContent'] as $widgetItem){
						$saveData['BoxContent'] = $widgetItem;
						$saveData['BoxContent']['box_id'] = $newId;
						
						$this->BoxContent->create();
						$this->BoxContent->save($saveData);
					}
				}
				
				$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(3, $id);
				if(!empty($shortcode)){
					$shortcode['Shortcode']['widget_id'] = $newId;
					unset($shortcode['Shortcode']['id']);
					$this->Shortcode->create();
					$this->Shortcode->save($shortcode);
				}
				
				return '[Box-'.$newId.']';
			} else {
				return "";
			}
			
		} else {
			return "";
		}
	}
	
	public function admin_boxmanage(){
		$this->layout = 'ajax';
		$this->loadModel('BoxContent');
		
		
		$this->set('id', $this->request->data['id']);
		$this->set('style', $this->request->data['style']);
		$this->set('box_id', $this->request->data['box_id']);
		if($this->request->data['id'] != ''){			
			
			$data12 = $this->BoxContent->findById($this->request->data['id']);
			$this->set('data1',$data12);
		}
		
	}
	
	
	public function admin_boxmanageupdate($b_id,$style,$id=NULL){
		$this->layout = 'adminInner';
		$this->loadModel('BoxContent');
		if($this->request->is("post")){
			
			if($id != ''){
				$this->BoxContent->id = $id;
				$data1['BoxContent']['date_modified'] = date("Y-m-d");
			} else {
				$data1['BoxContent']['date_created'] = date("Y-m-d");
				$this->BoxContent->create();
			}
			
			$data = $this->request->data;
			
			$data1['BoxContent'] = $data['Box'];
			if($style == 'style3'){
				if(array_key_exists('backgroundstyle', $data['Box'])){
					if($data['Box']['backgroundstyle']['name']!=""){
						list($file1,$error1,$update_field1) = AppController::upload($data['Box']['backgroundstyle'],WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'backgroundstyle'. DS . 'original' . DS ,'jpg,jpeg,JPG,JPEG,gif,GIF,png,PNG');
						
						if($error1 == ""){
							$image	=	new SimpleImage();
							
							$image->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'backgroundstyle'. DS . 'original' . DS .$file1); 
							$image_size=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'backgroundstyle'. DS . 'original' . DS .$file1,768,365); 
							$image->resize($image_size['0'],$image_size['1']); 
							$image->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'backgroundstyle'. DS . 'resize' . DS .$file1); 
												
							$data1['BoxContent']['backgroundstyle'] = $file1;
						}
						else
						{
							$data1['BoxContent']['backgroundstyle'] = "";
						}
					} else {
						$data1['BoxContent']['backgroundstyle'] = "";
					}
				}
			}
			
			$return =  $this->BoxContent->save($data1);
			
			if($return['BoxContent']['id'] != ''){
				$this->Session->setFlash('<p>Box updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else{
				$this->Session->setFlash('<p>Box added successfully!</p>', 'default', array('class' => 'alert alert-success'));
			}
			
			$this->redirect('/admin/Boxes/manage/'.$b_id);
		}
		
		
		$this->set('id', $id);
		if($id != NULL || $id != ''){
			$this->loadModel('Box');
			
			$this->Box->bindModel(array(
									'hasMany' => array(
										'BoxContent' => array(
												'className'    => 'BoxContent',
												'foreignKey'   => 'box_id'
											)
									)
								));
			
			$data = $this->Box->findById($id);
			$this->set('data',$data);
		}
	}
	
	public function admin_boxbgimgdlt($id = NULL, $boxocntent_id = NULL){
		$this->layout = '';
		$this->autoRender = false;
		
		if(!empty($id) && !empty($boxocntent_id)){
			$contentData = $this->BoxContent->findById($boxocntent_id);
			if(!empty($contentData['BoxContent']['backgroundstyle'])){
				$original_path=UPLOADS_FOLDER . DS .'backgroundstyle'. DS.'original'. DS .$contentData['BoxContent']['backgroundstyle'];
				$resize_path=UPLOADS_FOLDER . DS .'backgroundstyle'. DS.'resize'. DS .$contentData['BoxContent']['backgroundstyle'];
				
				$file_original = new File($original_path, false, 0777);
				$file_original->delete();
				$file_resize = new File($resize_path, false, 0777);
				$file_resize->delete();
			}
			$saveData['BoxContent']['backgroundstyle'] = "";
			$this->BoxContent->id = $boxocntent_id;
			$saveFlag = $this->BoxContent->save($saveData);
			
			if($saveFlag){
				$this->Session->setFlash('Image deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete image!</p>', 'default', array('class' => 'alert alert-success'));
			}
			$this->redirect(array('controller'=>'Boxes', 'action'=>'admin_manage/'.$id));
		} else {
			$this->redirect(array('controller'=>'Boxes', 'action'=>'admin_index'));
		}
	}
	
	
	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Box']['isdel'] = $isdel; 
		$this->Box->id = $id;
		$deleteFlag = $this->Box->save($data);
		$this->loadModel('BoxContent');
		
		$this->BoxContent->updateAll(
			array( 'BoxContent.isdel' => $isdel ),   //fields to update
			array( 'BoxContent.box_id' => $id )  //condition
		);
		
		if($deleteFlag)
		{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Box',$id);
				//pr($get_data); exit;
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
		}
		
		$this->Session->setFlash('<p>Box details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	
	public function admin_boxdelete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$this->loadModel('BoxContent');
		$data['BoxContent']['isdel'] = $isdel; 
		$this->BoxContent->id = $id;
		$this->BoxContent->save($data);
		$this->Session->setFlash('<p>Box details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->Box->findById($id);
			
			$data['Box']['isdel'] = $stat;
			$this->Box->id = $id;
			$deleteFlag = $this->Box->save($data);
			
			if($deleteFlag){
			
			$this->loadModel('Shortcode');
			$get_data = $this->Shortcode->findByNameAndWidgetId('Box',$id);
			//pr($get_data);
			$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
			
				$this->Session->setFlash('<p>Boxes removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Boxes removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Box']['status'] = $stat;
		
		$this->Box->id = $id;
		$this->Box->save($data);
		$this->Session->setFlash('<p>Box updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	public function admin_icon()
	{
		$this->layout = 'ajax';
	}
	
	

}
?>