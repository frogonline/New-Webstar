<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');

class ListStylesController extends AppController 
{

	public $name = 'ListStyles';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('ListStyle', 'ListContent', 'Style', 'Shortcode', 'PageTemplateRowsColumn','FooterColumn','Page');
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
	
	public function blackhole($type)
	{
	
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
			
			foreach($data['ListStyle'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['ListStyle.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
						if(in_array($k,$titlekeyArr)){
							$conditionArr['ListStyle.'.$k.' LIKE'] = '%'.$v.'%';
						} else {
							$conditionArr['ListStyle.'.$k] = $v; 
						}
					}
				}
			}
			$conditionArr['ListStyle.isdel'] = 0;
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('ListStyle.id' => 'DESC')
			);
			$this->set('searchData',$data);
		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('ListStyle.isdel'=>'0'),
					'order'=>array('ListStyle.id' => 'DESC')
					);
			
		}
		$stylesArr = $this->Style->find('list', array(
				'conditions'=>array(
					'Style.group_id'=>16
				),
				'fields'=>array(
					'widgetstyle_name', 'name'
				)
			)
		);
		$data= $this->paginate('ListStyle');

		$this->set(compact('data','stylesArr'));
	}
	
	public function admin_manage($id=NULL){
		$this->layout = 'adminInner';
		if($this->request->is("post")){
			
			if($id != ''){
				$this->ListStyle->id = $id;
				
				$this->request->data['ListStyle']['date_modified'] = date("Y-m-d");
			} else{
				$this->request->data['ListStyle']['date_created'] = date("Y-m-d");
				
				$this->ListStyle->create();
			}
			
			
			
			$data = $this->request->data;
			
			// pr($data);
			//exit; 
			
			//$data['ListStyle']['category'] = implode(",",$data['ListStyle']['category']);
		
			
			$return =  $this->ListStyle->save($data);
			$saveId = $this->ListStyle->id;
			
			if($return['ListStyle']['id'] !== ''){
				$this->Session->setFlash('<p>List Style updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else{
				$this->Session->setFlash('<p>List Style added successfully!</p>', 'default', array('class' => 'alert alert-success'));
			}
			
			if($data['ListStyle']['status']=='Y')
			{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('ListStyle',$return['ListStyle']['id']);
			
				if(empty($get_data))
				{
				    $styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['ListStyle']['style'], 16);
					$data['Shortcode']['controller'] 	= 'ListStyles';
					$data['Shortcode']['action']		= 'manage';
					$data['Shortcode']['widget_id'] 	= $return['ListStyle']['id'];
					$data['Shortcode']['widget_title'] 	= $data['ListStyle']['name'];
					$data['Shortcode']['name'] 			= 'ListStyle';
					$data['Shortcode']['group_id'] 		= 16;
				    $data['Shortcode']['style_id'] 		= $styleData['Style']['id'];
					$this->Shortcode->create();
					
					$this->Shortcode->save($data);
				} else {
					$styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['ListStyle']['style'], 16);
					$scdata = $this->Shortcode->findByNameAndWidgetId('ListStyle',$saveId);
					$this->Shortcode->id=$scdata['Shortcode']['id'];
					$savedata['Shortcode']['controller'] 	= 'ListStyles';
					$savedata['Shortcode']['action']		= 'manage';
					$savedata['Shortcode']['widget_id'] 	= $saveId;
					$savedata['Shortcode']['widget_title'] 	= $data['ListStyle']['name'];
					$savedata['Shortcode']['name'] 			= 'ListStyle';
					$savedata['Shortcode']['group_id'] 		= 16;
					$savedata['Shortcode']['style_id'] 		= $styleData['Style']['id'];
				
					$this->Shortcode->save($savedata);
				}
			}
			
			if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'ListStyles','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'ListStyles','action'=>'admin_index'));
				}
			
			//$this->redirect('/admin/ListStyles/manage/'.$return['ListStyle']['id']);
			
		}
		
		$stylesArr = $this->Style->find('list', array(
				'conditions'=>array(
					'Style.group_id'=>16
				),
				'fields'=>array(
					'widgetstyle_name', 'name'
				)
			)
		);
		
		$this->set('id', $id);
		if($id != NULL || $id != ''){
			$this->loadModel('ListStyle');
			
			$this->ListStyle->bindModel(array(
									'hasMany' => array(
										'ListContent' => array(
												'className'    => 'ListContent',
												'foreignKey'   => 'list_id',
												'conditions'=>array('ListContent.isdel'=>'0')	
											),
										
									)
								));
			
			$data = $this->ListStyle->findById($id);
			if(!empty($data)){
				$widgetStyle = $this->Style->findByGroupIdAndWidgetstyleName(16,$data['ListStyle']['style']);
			} else {
				$widgetStyle = array();
			}
			$this->set(compact('data', 'widgetStyle'));
			
			
		}
		$this->set('stylesArr',$stylesArr);
		
			$this->loadModel('style');
		    $liststyledata=$this->style->find('all', array(
					'order'=>array('style.id ASC'),
					'fields'=>array('style.widgetstyle_name', 'style.style_img','style.name'),
					'conditions'=>array('style.group_id'=>16)
				)
			);
			//pr($liststyledata); exit;
		    $this->set('liststyledata',$liststyledata);
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
		$arr = array_keys($this->ListContent->schema());				unset($arr[0]);				$this->ListStyle->bindModel(					array(						'hasMany'=>array(							'ListContent'=>array(								'className'=>'ListContent',								'foreignKey'=>'list_id',								'fields'=>$arr							)						)					)				);												$orgWidget = $this->ListStyle->findById($data['widgetId']);				unset($orgWidget['ListStyle']['id']);								$this->ListStyle->create();				$fl = $this->ListStyle->save($orgWidget);				$newId = $this->ListStyle->id;								if(!empty($newId)){					if(!empty($orgWidget['ListContent'])){						foreach($orgWidget['ListContent'] as $widgetItem){							$saveData['ListContent'] = $widgetItem;							$saveData['ListContent']['list_id'] = $newId;														$this->ListContent->create();							$this->ListContent->save($saveData);						}					}										$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(16, $data['widgetId']);					if(!empty($shortcode)){						$shortcode['Shortcode']['widget_id'] = $newId;						unset($shortcode['Shortcode']['id']);						$this->Shortcode->create();						$this->Shortcode->save($shortcode);					}										if(!empty($data['colId'])){						if(empty($footer))						{						$this->PageTemplateRowsColumn->id = $data['colId'];						$tpldata['PageTemplateRowsColumn']['shortcode'] = '[ListStyle-'.$newId.']';						$tpldata['PageTemplateRowsColumn']['clone_flag'] = 'Y';												$this->PageTemplateRowsColumn->save($tpldata);						}else {						$this->FooterColumn->id = $data['colId'];						$tpldata['FooterColumn']['shortcode'] = '[ListStyle-'.$newId.']';																		$this->FooterColumn->save($tpldata);												}					}					echo 1; exit();				} else {					echo 0; exit();				}			} else {				echo 0; exit();			}		}	}
	
	public function admin_copyitem($id){
			if(!empty($id)){
				$arr = array_keys($this->ListContent->schema());
				unset($arr[0]);
				$this->ListStyle->bindModel(
					array(
						'hasMany'=>array(
							'ListContent'=>array(
								'className'=>'ListContent',
								'foreignKey'=>'list_id',
								'fields'=>$arr
							)
						)
					)
				);
				
				
				$orgWidget = $this->ListStyle->findById($id);
				unset($orgWidget['ListStyle']['id']);
				
				$this->ListStyle->create();
				$fl = $this->ListStyle->save($orgWidget);
				$newId = $this->ListStyle->id;
				
				if(!empty($newId)){
					if(!empty($orgWidget['ListContent'])){
						foreach($orgWidget['ListContent'] as $widgetItem){
							$saveData['ListContent'] = $widgetItem;
							$saveData['ListContent']['list_id'] = $newId;
							
							$this->ListContent->create();
							$this->ListContent->save($saveData);
						}
					}
					
					$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(16, $id);
					if(!empty($shortcode)){
						$shortcode['Shortcode']['widget_id'] = $newId;
						unset($shortcode['Shortcode']['id']);
						$this->Shortcode->create();
						$this->Shortcode->save($shortcode);
					}
					return '[ListStyle-'.$newId.']';
				} else {
					return "";
				}
			} else {
				return "";
			}
	}
	
	public function admin_boxmanage(){
		$this->layout = 'ajax';
		$this->loadModel('ListContent');
		
		$this->set('id', $this->request->data['id']);
		$this->set('style', $this->request->data['style']);
		$this->set('list_id', $this->request->data['box_id']);
		
		if($this->request->data['id'] != ''){			
			$data12 = $this->ListContent->findById($this->request->data['id']);
			$this->set('data1',$data12);
		}
	}
	
	
	public function admin_boxmanageupdate($b_id,$style,$id=NULL)
	{
		$this->layout = 'adminInner';
		$this->loadModel('ListContent');
		if($this->request->is("post")){
			
			if($id != ''){
				$this->ListContent->id = $id;
				$data1['ListContent']['date_modified'] = date("Y-m-d");
			} else{
				$data1['ListContent']['date_created'] = date("Y-m-d");
				$this->ListContent->create();
			}
			
			$data = $this->request->data;
			
			
			$data1['ListContent'] = $data['ListStyle'];
			
			
			
			
			
			$return =  $this->ListContent->save($data1);
			
			
			if($return['ListContent']['id'] != ''){
				$this->Session->setFlash('<p>List style Content updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else{
				$this->Session->setFlash('<p>List style  Content added successfully!</p>', 'default', array('class' => 'alert alert-success'));
			}
			
			
			

			$this->redirect('/admin/ListStyles/manage/'.$b_id);
			
		
		}
		
		
		$this->set('id', $id);
		if($id != NULL || $id != ''){
			$this->loadModel('ListContent');
			
			
			
			$data = $this->ListContent->findById($id);
			
			
			$this->set('data1',$data);
		}
	}
	
/*
	
	public function delete($id) {
        $this->Post->delete($id);
        $this->Session->setFlash("Data successfully deleted!");
        $this->redirect(array('action' => 'admin_index'));
    }
	
	
	*/
	
	
	
	
	
	
	//delete Segments  Start s 
	
	
	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		/* $data['ListStyle']['isdel'] = $isdel; 
		$this->ListStyle->id = $id;
		$this->ListStyle->save($data); */
		
		//$this->loadModel('ListStyle');
		
		$deleteFlag = $this->ListStyle->updateAll(
			array( 'ListStyle.isdel' => $isdel ),   //fields to update
			array( 'ListStyle.id' => $id )  //condition
		);
		
		if($deleteFlag)
		{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('ListStyle',$id);
				//pr($get_data); exit;
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
		}
		
		$this->Session->setFlash('<p>List details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());
	}
	

	
	public function admin_boxdelete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$this->loadModel('ListContent');
		$data['ListContent']['isdel'] = $isdel; 
		$this->ListContent->id = $id;
		$this->ListContent->save($data);
		$this->Session->setFlash('<p> List details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_deleteAll($idAll=NULL, $status = '1')
	{	
		
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->ListStyle->findById($id);
			
			$data['ListStyle']['isdel'] = $status;
			$this->ListStyle->id = $id;
			$deleteFlag = $this->ListStyle->save($data);
			if($deleteFlag){
			
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('ListStyle',$id);
				//pr($get_data); exit;
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
		
				$this->Session->setFlash('<p>Lists removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Lists can not be removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
			//$this->redirect(array('action'=>'admin_index'));
	}
	
	
	//delete  segment ends ..
	
	
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['ListStyle']['status'] = $stat;
		
		$this->ListStyle->id = $id;
		$this->ListStyle->save($data);
		$this->Session->setFlash('<p>List updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	
	public function admin_icon()
	{
		$this->layout = 'ajax';
	}
	
/*	
	
	public function admin_admin_manage() {

	}

}
	
	
	*/
	
}

?>