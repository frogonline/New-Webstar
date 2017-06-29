<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class AccordionsController extends AppController {

	public $name = 'Accordions';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('Accordion','AccordionContent', 'Style', 'Shortcode', 'PageTemplateRowsColumn','FooterColumn','Page');
	public $paginate = array();

	public function beforeFilter() 
	{
		parent::beforeFilter();
		
		$this->Auth->allow('admin_boxmanageupdate','admin_selectstyle','admin_saveastemplate');
		
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
			$titlekeyArr = array('style');
			$conditionArr = array();
			foreach($data['Accordion'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['Accordion.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
						if(in_array($k,$titlekeyArr)){
							$conditionArr['Accordion.'.$k.' LIKE'] = '%'.$v.'%';
						} else {
							$conditionArr['Accordion.'.$k] = $v; 
						}
					}
				}
			}
			$conditionArr['Accordion.isdel'] = 0; 
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Accordion.id' => 'DESC')
			);
			$this->set('searchData',$data);
		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('Accordion.isdel'=>'0'),
					'order'=>array('Accordion.id' => 'DESC')
					);
			
		}
		$stylesArr = $this->Style->find('list', array(
				'conditions'=>array(
					'Style.group_id'=>1
				),
				'fields'=>array(
					'widgetstyle_name', 'name'
				)
			)
		);
		$data= $this->paginate('Accordion');
		//pr($data); exit;
		
		//pr($data);exit;
		$this->set(compact('data', 'stylesArr'));
		
	}
	
	public function admin_manage($id=NULL){
		$this->layout = 'adminInner';
		if($this->request->is("post")){
			$data = $this->request->data;
			//pr($data);exit;
			if($id != ''){
				$this->Accordion->id = $id;
				$data['Accordion']['date_modified'] = date("Y-m-d");
			} else{
				$data['Accordion']['date_created'] = date("Y-m-d");
				$this->Accordion->create();
			}
						
			$data['Accordion']['category'] = implode(",",$data['Accordion']['category']);
		
			
			$flag = $this->Accordion->save($data);
			$saveId = $this->Accordion->id;
			if($flag){
				if(!empty($id)){
					$this->Session->setFlash('<p>Accordion updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
				} else{
					$this->Session->setFlash('<p>Accordion added successfully!</p>', 'default', array('class' => 'alert alert-success'));
				}
			} else {
				$this->Session->setFlash('Failed to add accordion', 'default', array('class' => 'alert alert-danger'));
			}
			
			if($flag)
			{
				$this->loadModel('Shortcode');
				$checkdata = $this->Shortcode->find('count',array(
						'conditions'=>array(
							'Shortcode.name'=>'Accordion',
							'Shortcode.widget_id'=>$saveId
						)
					)
				);
				//pr($data);exit;
				if($checkdata==0)
				{
					$styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['Accordion']['style'], 1);
					//pr($styleData); exit();
					$savedata['Shortcode']['controller'] 	= 'Accordions';
					$savedata['Shortcode']['action']		= 'manage';
					$savedata['Shortcode']['widget_id'] 	= $saveId;
					$savedata['Shortcode']['widget_title'] 	= $data['Accordion']['name'];
					$savedata['Shortcode']['name'] 			= 'Accordion';
					$savedata['Shortcode']['group_id'] 		= 1;
					$savedata['Shortcode']['style_id'] 		= $styleData['Style']['id'];
					$this->Shortcode->create();
					
					$this->Shortcode->save($savedata);
				} else {
					$styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['Accordion']['style'], 1);
					$scdata = $this->Shortcode->findByNameAndWidgetId('Accordion',$saveId);
					$this->Shortcode->id=$scdata['Shortcode']['id'];
					$savedata['Shortcode']['controller'] 	= 'Accordions';
					$savedata['Shortcode']['action']		= 'manage';
					$savedata['Shortcode']['widget_id'] 	= $saveId;
					$savedata['Shortcode']['widget_title'] 	= $data['Accordion']['name'];
					$savedata['Shortcode']['name'] 			= 'Accordion';
					$savedata['Shortcode']['group_id'] 		= 1;
					$savedata['Shortcode']['style_id'] 		= $styleData['Style']['id'];
				
					$this->Shortcode->save($savedata);
				}	
			}
			
			if(array_key_exists('continue', $data)){
				$this->redirect(array('controller'=>'Accordions','action'=>'admin_manage/'.$saveId));
			} else {
				$this->redirect(array('controller'=>'Accordions','action'=>'admin_index'));
			}
			
		}
		
		$stylesArr = $this->Style->find('list', array(
				'conditions'=>array(
					'Style.group_id'=>1
				),
				'fields'=>array(
					'widgetstyle_name', 'name'
				)
			)
		);
		//pr($stylesArr); exit();
		
		$this->set('id', $id);
		if($id != NULL || $id != ''){
			$this->loadModel('Accordion');
			
			$this->Accordion->bindModel(array(
									'hasMany' => array(
										'AccordionContent' => array(
												'className'    => 'AccordionContent',
												'foreignKey'   => 'accordion_id',
												'conditions'=>array('AccordionContent.isdel'=>'0')	
											),
										
									)
								));
			
			$data = $this->Accordion->findById($id);
			if(!empty($data)){
				$accordionStyle = $this->Style->findByGroupIdAndWidgetstyleName(1,$data['Accordion']['style']);
			} else {
				$accordionStyle = array();
			}
			
			$this->set(compact('data','accordionStyle'));
			
		}
		
		$this->set(compact('stylesArr'));
		//$style_list = $this->Style->find('list', array('conditions'=>array('Style.group_id'=>1)));
		//pr($style_list);
		//$this->set('style_list', $style_list);
		
		    $this->loadModel('style');
		    $accordiondata=$this->style->find('all', array(
					'order'=>array('style.id ASC'),
					'fields'=>array('style.widgetstyle_name', 'style.style_img','style.name'),
					'conditions'=>array('style.group_id'=>1)
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
	$arr = array_keys($this->AccordionContent->schema());				unset($arr[0]);				$this->Accordion->bindModel(					array(						'hasMany'=>array(							'AccordionContent'=>array(								'className'=>'AccordionContent',								'foreignKey'=>'accordion_id',								'fields'=>$arr							)						)					)				);												$orgWidget = $this->Accordion->findById($data['widgetId']);				unset($orgWidget['Accordion']['id']);								$this->Accordion->create();				$fl = $this->Accordion->save($orgWidget);				$newId = $this->Accordion->id;								if(!empty($newId)){					if(!empty($orgWidget['AccordionContent'])){						foreach($orgWidget['AccordionContent'] as $widgetItem){							$saveData['AccordionContent'] = $widgetItem;							$saveData['AccordionContent']['accordion_id'] = $newId;														$this->AccordionContent->create();							$this->AccordionContent->save($saveData);						}					}										$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(1, $data['widgetId']);					if(!empty($shortcode)){						$shortcode['Shortcode']['widget_id'] = $newId;						unset($shortcode['Shortcode']['id']);						$this->Shortcode->create();						$this->Shortcode->save($shortcode);					}										if(!empty($data['colId'])){						if(empty($footer))						{						$this->PageTemplateRowsColumn->id = $data['colId'];						$tpldata['PageTemplateRowsColumn']['shortcode'] = '[Accordion-'.$newId.']';						$tpldata['PageTemplateRowsColumn']['clone_flag'] = 'Y';												$this->PageTemplateRowsColumn->save($tpldata);						}else {						$this->FooterColumn->id = $data['colId'];						$tpldata['FooterColumn']['shortcode'] = '[Accordion-'.$newId.']';																		$this->FooterColumn->save($tpldata);												}					}					echo 1; exit();				} else {					echo 0; exit();				}			} else {				echo 0; exit();			}		}	}
	
	public function admin_copyitem($id){
		if(!empty($id)){
			$arr = array_keys($this->AccordionContent->schema());
			unset($arr[0]);
			$this->Accordion->bindModel(
				array(
					'hasMany'=>array(
						'AccordionContent'=>array(
							'className'=>'AccordionContent',
							'foreignKey'=>'accordion_id',
							'fields'=>$arr
						)
					)
				)
			);
			
			
			$orgWidget = $this->Accordion->findById($id);
			unset($orgWidget['Accordion']['id']);
			
			$this->Accordion->create();
			$fl = $this->Accordion->save($orgWidget);
			$newId = $this->Accordion->id;
			
			if(!empty($newId)){
				if(!empty($orgWidget['AccordionContent'])){
					foreach($orgWidget['AccordionContent'] as $widgetItem){
						$saveData['AccordionContent'] = $widgetItem;
						$saveData['AccordionContent']['accordion_id'] = $newId;
						
						$this->AccordionContent->create();
						$this->AccordionContent->save($saveData);
					}
				}
				
				$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(1, $id);
				if(!empty($shortcode)){
					$shortcode['Shortcode']['widget_id'] = $newId;
					unset($shortcode['Shortcode']['id']);
					$this->Shortcode->create();
					$this->Shortcode->save($shortcode);
				}
				
				return '[Accordion-'.$newId.']';
				
				
			} else {
				return "";
			}
			
		} else {
			return "";
		}
	}
	
	
	public function admin_boxmanage(){
		$this->layout = 'ajax';
		$this->set('id', $this->request->data['id']);
		$this->set('style', $this->request->data['style']);
		$this->set('box_id', $this->request->data['box_id']);
		$data = $this->Accordion->findById($this->request->data['box_id']);
		$this->set('data_category',$data);
		$this->loadModel('AccordionContent');
		if($this->request->data['id'] != ''){			
			
			$data12 = $this->AccordionContent->findById($this->request->data['id']);
			$this->set('data1',$data12);
		}
	}
	
	
	public function admin_boxmanageupdate($b_id,$style,$id=NULL){
		$this->layout = 'adminInner';
		$this->loadModel('AccordionContent');
		if($this->request->is("post")){
			
			if($id != ''){
				$this->AccordionContent->id = $id;
				$data1['AccordionContent']['date_modified'] = date("Y-m-d");
			} else{
				$data1['AccordionContent']['date_created'] = date("Y-m-d");
				$this->AccordionContent->create();
			}
			
			$data = $this->request->data;
			
			/* pr($data);
			exit; */
			
			$data1['AccordionContent'] = $data['Accordion'];
			
			
			
			$return =  $this->AccordionContent->save($data1);
			
			
			if($return['AccordionContent']['id'] != ''){
				$this->Session->setFlash('<p>Accordion Content updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else{
				$this->Session->setFlash('<p>Accordion Content added successfully!</p>', 'default', array('class' => 'alert alert-success'));
			}
			
			
			
			$this->redirect('/admin/Accordions/manage/'.$b_id);
			
		}
		
		
		$this->set('id', $id);
		if($id != NULL || $id != ''){
			$this->loadModel('Accordion');
			
			$this->Accordion->bindModel(array(
									'hasMany' => array(
										'AccordionContent' => array(
												'className'    => 'AccordionContent',
												'foreignKey'   => 'box_id'
											)
									)
								));
			
			$data = $this->Accordion->findById($id);
			$this->set('data',$data);
		}
	}
	
	
	
	
	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Accordion']['isdel'] = $isdel; 
		$this->Accordion->id = $id;
		$deleteFlag = $this->Accordion->save($data);
		$this->loadModel('AccordionContent');
		
		$this->AccordionContent->updateAll(
			array( 'AccordionContent.isdel' => $isdel ),   //fields to update
			array( 'AccordionContent.accordion_id' => $id )  //condition
		);
		
		if($deleteFlag)
		{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Accordion',$id);
				//pr($get_data); exit;
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
		}
		
		$this->Session->setFlash('<p>Accordion details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	
	public function admin_boxdelete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$this->loadModel('AccordionContent');
		$data['AccordionContent']['isdel'] = $isdel; 
		$this->AccordionContent->id = $id;
		$this->AccordionContent->save($data);
		$this->Session->setFlash('<p>Accordion details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->Accordion->findById($id);
			
			$data['Accordion']['isdel'] = $stat;
			$this->Accordion->id = $id;
			$deleteFlag = $this->Accordion->save($data);
			if($deleteFlag){
			
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Accordion',$id);
				//pr($get_data); exit;
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
				
				$this->Session->setFlash('<p>Accordions removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Accordions removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Accordion']['status'] = $stat;
		
		$this->Accordion->id = $id;
		$this->Accordion->save($data);
		$this->Session->setFlash('<p>Accordion updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	public function admin_selectstyle()
	{
	echo "ok";
	
		/* $this->layout = "ajax";
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			
			$this->loadModel('Widgetgroup');
			$widgetgroup_dropdown = $this->Widgetgroup->find('list', array(
					'order'=>array('Widgetgroup.name ASC', 'Widgetgroup.id ASC'),
					'fields'=>array('Widgetgroup.id', 'Widgetgroup.name'),
					'conditions'=>array('Widgetgroup.is_active'=>'Y')
				)
			);
			//pr($shortcodeArr); exit;
			$this->set(compact('reqdata', 'widgetgroup_dropdown'));
		} */
		
	}
	
	public function admin_saveastemplate(){
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$data = $this->request->data;
			if(!empty($data['tplId'])){
				$tpldata = $this->PageTemplate->findById($data['tplId']);
			} else {
				$tpldata = array();
			}
			$this->set(compact('data','tpldata'));
		}
	}
	

}
?>