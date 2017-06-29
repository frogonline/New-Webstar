<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class TabsController extends AppController {

	public $name = 'Tabs';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('Tabs', 'TabContent', 'Style', 'Shortcode', 'PageTemplateRowsColumn','FooterColumn','Page');
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
			$titlekeyArr = array('style');
			$conditionArr = array();
			foreach($data['Tabs'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['Tabs.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
						if(in_array($k,$titlekeyArr)){
							$conditionArr['Tabs.'.$k.' LIKE'] = '%'.$v.'%';
						} else {
							$conditionArr['Tabs.'.$k] = $v;
						}
					}
				}
			}
			$conditionArr['Tabs.isdel'] = 0;
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Tabs.id' => 'DESC')
			);
			$this->set('searchData',$data);
		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('Tabs.isdel'=>'0'),
					'order'=>array('Tabs.id' => 'DESC')
					);
			
		}
		$stylesArr = $this->Style->find('list', array(
				'conditions'=>array(
					'Style.group_id'=>23
				),
				'fields'=>array(
					'widgetstyle_name', 'name'
				)
			)
		);
		$data= $this->paginate('Tabs');
		
		
		$this->set(compact('data', 'stylesArr'));
		
	}
	
	public function admin_manage($id=NULL){
		$this->layout = 'adminInner';
		if($this->request->is("post")){
			
			if($id != ''){
				$this->Tabs->id = $id;
				
			} else{
				$this->Tabs->create();
			}
			
			$data = $this->request->data;
			//pr($data);
			//exit;
			//$data['Tabs']['name'] = implode(",",$data['Tabs']['name']);
		
			
			$return =  $this->Tabs->save($data);
			$saveId = $this->Tabs->id;
			
			if($return['Tabs']['id'] != ''){
				$this->Session->setFlash('<p>Tab updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else{
				$this->Session->setFlash('<p>Tab added successfully!</p>', 'default', array('class' => 'alert alert-success'));
			}
			
			if($data['Tabs']['status']=='Y')
			{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Tab',$return['Tabs']['id']);
			
				if(empty($get_data))
				{
				    $styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['Tabs']['style'], 23);
					$data['Shortcode']['controller'] 	= 'Tabs';
					$data['Shortcode']['action']		= 'manage';
					$data['Shortcode']['widget_id'] 	= $return['Tabs']['id'];
					$data['Shortcode']['widget_title'] 	= $data['Tabs']['name'];
					$data['Shortcode']['name'] 			= 'Tab';
					$data['Shortcode']['group_id'] 		= 23;
					$data['Shortcode']['style_id'] 		= $styleData['Style']['id'];
					$this->Shortcode->create();
					
					$this->Shortcode->save($data);
				} else {
					 $styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['Tabs']['style'], 23);
					$scdata = $this->Shortcode->findByNameAndWidgetId('Tab',$saveId);
					$this->Shortcode->id=$scdata['Shortcode']['id'];
					$savedata['Shortcode']['controller'] 	= 'Tabs';
					$savedata['Shortcode']['action']		= 'manage';
					$savedata['Shortcode']['widget_id'] 	= $saveId;
					$savedata['Shortcode']['widget_title'] 	= $data['Tabs']['name'];
					$savedata['Shortcode']['name'] 			= 'Tab';
					$savedata['Shortcode']['group_id'] 		= 23;
					$savedata['Shortcode']['style_id'] 		= $styleData['Style']['id'];
				
					$this->Shortcode->save($savedata);
				}		
			}
			
			if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'Tabs','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'Tabs','action'=>'admin_index'));
				}
			
			
			//$this->redirect('/admin/Tabs/manage/'.$return['Tabs']['id']);
			
		}
		
		$stylesArr = $this->Style->find('list', array(
				'conditions'=>array(
					'Style.group_id'=>23
				),
				'fields'=>array(
					'widgetstyle_name', 'name'
				)
			)
		);
		
		$this->set('id', $id);
		if($id != NULL || $id != ''){
			$this->loadModel('Tabs');
			
			$this->Tabs->bindModel(array(
									'hasMany' => array(
										'TabContent' => array(
												'className'    => 'TabContent',
												'foreignKey'   => 'tab_id',
												'conditions'=>array('TabContent.isdel'=>'0')	
											),
										
									)
								));
			
			$data = $this->Tabs->findById($id);
			if(!empty($data)){
				$widgetStyle = $this->Style->findByGroupIdAndWidgetstyleName(23,$data['Tabs']['style']);
			} else {
				$widgetStyle = array();
			}
			$this->set(compact('data', 'widgetStyle'));
		}
		$this->set(compact('stylesArr'));
		
		    $this->loadModel('style');
		    $tabsstyledata=$this->style->find('all', array(
					'order'=>array('style.id ASC'),
					'fields'=>array('style.widgetstyle_name', 'style.style_img','style.name'),
					'conditions'=>array('style.group_id'=>23)
				)
			);
			//pr($tabsstyledata); exit;
		    $this->set('tabsstyledata',$tabsstyledata);
	}
	
	
	public function admin_boxmanage(){
		$this->layout = 'ajax';
		//pr($this->request->data); exit;
		$this->set('id', $this->request->data['id']);
		$this->set('style', $this->request->data['style']);
		$this->set('tab_id', $this->request->data['tab_id']);
		//$data = $this->TabContent->findById($this->request->data['tab_id']);
		//$this->set('data_id',$data);
		$this->loadModel('TabContent');
		if($this->request->data['id'] != ''){			
			
			$data12 = $this->TabContent->findById($this->request->data['id']);
			$this->set('data1',$data12);
		}
	}
	
	
	public function admin_boxmanageupdate($b_id,$style,$id=NULL){
		$this->layout = 'adminInner';
		$this->loadModel('TabContent');
		if($this->request->is("post")){
			
			if($id != ''){
				$this->TabContent->id = $id;
				$data1['TabContent']['date_modified'] = date("Y-m-d");
			} else{
				$data1['TabContent']['date_created'] = date("Y-m-d");
				$this->TabContent->create();
			}
			
			$data = $this->request->data;
			
			//pr($data);
			//exit; 
			
			$data1['TabContent'] = $data['Tabs'];
			
			$return =  $this->TabContent->save($data1);
			
			
			if($return['TabContent']['id'] !== ''){
				$this->Session->setFlash('<p>Tab Content updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else{
				$this->Session->setFlash('<p>Tab Content added successfully!</p>', 'default', array('class' => 'alert alert-success'));
			}
			
			
			
			$this->redirect('/admin/Tabs/manage/'.$b_id);
			
		}
		
		
		$this->set('id', $id);
		if($id != NULL || $id != ''){
			$this->loadModel('Tabs');
			
			$this->Tabs->bindModel(array(
									'hasMany' => array(
										'TabContent' => array(
												'className'    => 'TabContent',
												'foreignKey'   => 'tab_id'
											)
									)
								));
			
			$data = $this->Tabs->findById($id);
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
	$arr = array_keys($this->TabContent->schema());				unset($arr[0]);				$this->Tabs->bindModel(					array(						'hasMany'=>array(							'TabContent'=>array(								'className'=>'TabContent',								'foreignKey'=>'tab_id',								'fields'=>$arr							)						)					)				);												$orgWidget = $this->Tabs->findById($data['widgetId']);				unset($orgWidget['Tabs']['id']);								$this->Tabs->create();				$fl = $this->Tabs->save($orgWidget);				$newId = $this->Tabs->id;								if(!empty($newId)){					if(!empty($orgWidget['TabContent'])){						foreach($orgWidget['TabContent'] as $widgetItem){							$saveData['TabContent'] = $widgetItem;							$saveData['TabContent']['tab_id'] = $newId;														$this->TabContent->create();							$this->TabContent->save($saveData);						}					}										$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(23, $data['widgetId']);					if(!empty($shortcode)){						$shortcode['Shortcode']['widget_id'] = $newId;						unset($shortcode['Shortcode']['id']);						$this->Shortcode->create();						$this->Shortcode->save($shortcode);					}										if(!empty($data['colId'])){						if(empty($footer))						{						$this->PageTemplateRowsColumn->id = $data['colId'];						$tpldata['PageTemplateRowsColumn']['shortcode'] = '[Tab-'.$newId.']';						$tpldata['PageTemplateRowsColumn']['clone_flag'] = 'Y';												$this->PageTemplateRowsColumn->save($tpldata);						}else {						$this->FooterColumn->id = $data['colId'];						$tpldata['FooterColumn']['shortcode'] = '[Tab-'.$newId.']';																		$this->FooterColumn->save($tpldata);												}					}					echo 1; exit();				} else {					echo 0; exit();				}			} else {				echo 0; exit();			}		}	}
	
	public function admin_copyitem($id){
		if(!empty($id)){
			$arr = array_keys($this->TabContent->schema());
			unset($arr[0]);
			$this->Tabs->bindModel(
				array(
					'hasMany'=>array(
						'TabContent'=>array(
							'className'=>'TabContent',
							'foreignKey'=>'tab_id',
							'fields'=>$arr
						)
					)
				)
			);
			
			
			$orgWidget = $this->Tabs->findById($id);
			unset($orgWidget['Tabs']['id']);
			
			$this->Tabs->create();
			$fl = $this->Tabs->save($orgWidget);
			$newId = $this->Tabs->id;
			
			if(!empty($newId)){
				if(!empty($orgWidget['TabContent'])){
					foreach($orgWidget['TabContent'] as $widgetItem){
						$saveData['TabContent'] = $widgetItem;
						$saveData['TabContent']['tab_id'] = $newId;
						
						$this->TabContent->create();
						$this->TabContent->save($saveData);
					}
				}
				
				$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(23, $id);
				if(!empty($shortcode)){
					$shortcode['Shortcode']['widget_id'] = $newId;
					unset($shortcode['Shortcode']['id']);
					$this->Shortcode->create();
					$this->Shortcode->save($shortcode);
				}
				
				return '[Tab-'.$newId.']';
			} else {
				return "";
			}
			
		} else {
			return "";
		}
	}
	
	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Tabs']['isdel'] = $isdel; 
		$this->Tabs->id = $id;
		$deleteFlag = $this->Tabs->save($data);
		$this->loadModel('TabContent');
		
		$this->TabContent->updateAll(
			array( 'TabContent.isdel' => $isdel ),   //fields to update
			array( 'TabContent.id' => $id )  //condition
		);
		
		if($deleteFlag)
		{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Tab',$id);
				//pr($get_data); exit;
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
		}
		
		$this->Session->setFlash('<p> Tab details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	
	public function admin_boxdelete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$this->loadModel('TabContent');
		$data['TabContent']['isdel'] = $isdel; 
		$this->TabContent->id = $id;
		$this->TabContent->save($data);
		$this->Session->setFlash('<p> Tab details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->Tabs->findById($id);
			
			$data['Tabs']['isdel'] = $stat;
			$this->Tabs->id = $id;
			$deleteFlag = $this->Tabs->save($data);
			if($deleteFlag){
			
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Tab',$id);
				//pr($get_data); exit;
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
				
				$this->Session->setFlash('<p>Tabs removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Failed to remove Tab!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Tabs']['status'] = $stat;
		
		$this->Tabs->id = $id;
		$this->Tabs->save($data);
		$this->Session->setFlash('<p>Tab updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	

}
?>