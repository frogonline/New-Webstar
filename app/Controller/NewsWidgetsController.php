<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');

class NewsWidgetsController extends AppController {
	
	public $name = 'NewsWidgets';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('NewsWidget','Style','Shortcode', 'PageTemplateRowsColumn','FooterColumn','Page');
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
			
			$likekeyArr = array('style');
			$conditionArr = array();
			foreach($data['NewsWidget'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['NewsWidget.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
							$conditionArr['NewsWidget.'.$k] = $v;
						}
					}
				}
			$conditionArr['NewsWidget.isdel'] = 0;
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('NewsWidget.id' => 'DESC')
			);
			$this->set('searchData',$data);
		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('NewsWidget.isdel'=>'0'),
					'order'=>array('NewsWidget.id' => 'DESC')
					);
			}
			$stylesArr = $this->Style->find('list', array(
				'conditions'=>array(
					'Style.group_id'=>18
				),
				'fields'=>array(
					'widgetstyle_name', 'name'
				)
			)
		);
	
		$data = $this->paginate('NewsWidget');
		
		$this->set(compact('data', 'stylesArr'));
	
	}
	
	
	public function admin_manage($id=NULL){	
		$this->layout = 'adminInner';
		
		if($this->request->is('post')){	
			
			if($this->NewsWidget->validates()){
			
				$data = $this->request->data;
				
				//pr($data); exit;
				
				if($id != ''){
					
					$this->NewsWidget->id = $id;
				} else{
			
					$this->NewsWidget->create();
				}
				
				$saveFlag = $this->NewsWidget->save($data);
				$saveId = $this->NewsWidget->id;
				if($saveFlag){
					if($id !== ''){
						$this->Session->setFlash('News Widget updated successfully.', 'default', array('class' => 'alert alert-success'));
					} else{
						$this->Session->setFlash('News Widget added successfully', 'default', array('class' => 'alert alert-success'));
					}
				} else {
					$this->Session->setFlash('Failed to save the News Widget', 'default', array('class' => 'alert alert-danger'));
				}
				
				if($data['NewsWidget']['is_active']=='0')
				{
					$this->loadModel('Shortcode');
					$get_data = $this->Shortcode->findByNameAndWidgetId('News',$saveId);
				
					if(empty($get_data))
					{
					    $styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['NewsWidget']['style'], 18);
						$data['Shortcode']['controller'] 	= 'NewsWidgets';
						$data['Shortcode']['action']		= 'manage';
						$data['Shortcode']['widget_id'] 	= $saveId;
						$savedata['Shortcode']['widget_title'] 	= $data['NewsWidget']['name'];
						$data['Shortcode']['name'] 			= 'News';
						$data['Shortcode']['group_id'] 		= 18;
					    $data['Shortcode']['style_id'] 		= $styleData['Style']['id'];
						$this->Shortcode->create();
						
						$this->Shortcode->save($data);
					} else {
						$styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['NewsWidget']['style'], 18);
						$scdata = $this->Shortcode->findByNameAndWidgetId('News',$saveId);
						$this->Shortcode->id = $scdata['Shortcode']['id'];
						$savedata['Shortcode']['controller'] 	= 'NewsWidgets';
						$savedata['Shortcode']['action']		= 'manage';
						$savedata['Shortcode']['widget_id'] 	= $saveId;
						$savedata['Shortcode']['widget_title'] 	= $data['NewsWidget']['name'];
						$savedata['Shortcode']['name'] 			= 'News';
						$savedata['Shortcode']['group_id'] 		= 18;
						$savedata['Shortcode']['style_id'] 		= $styleData['Style']['id'];
				
						$this->Shortcode->save($savedata);
					}	
				}
				
				if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'NewsWidgets','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'NewsWidgets','action'=>'admin_index'));
				}
				//$this->redirect(array('controller'=>'NewsWidgets','action'=>'admin_index'));
			} 
		}
		$stylesArr = $this->Style->find('list', array(
				'conditions'=>array(
					'Style.group_id'=>18
				),
				'fields'=>array(
					'widgetstyle_name', 'name'
				)
			)
		);
		
		if(trim($id) !== ''){
				$data = $this->NewsWidget->findById($id);
				if(!empty($data)){
				$widgetStyle = $this->Style->findByGroupIdAndWidgetstyleName(18,$data['NewsWidget']['style']);
				} else {
					$widgetStyle = array();
				}
				$this->set(compact('data', 'widgetStyle'));
			}
			
			$this->set('id', $id);
			$this->set(compact('stylesArr'));
			
			$this->loadModel('style');
		    $newsstyledata=$this->style->find('all', array(
					'order'=>array('style.id ASC'),
					'fields'=>array('style.widgetstyle_name', 'style.style_img','style.name'),
					'conditions'=>array('style.group_id'=>18)
				)
			);
			//pr($newsstyledata); exit;
		    $this->set('newsstyledata',$newsstyledata);
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
		$orgWidget = $this->NewsWidget->findById($data['widgetId']);				unset($orgWidget['NewsWidget']['id']);								$this->NewsWidget->create();				$fl = $this->NewsWidget->save($orgWidget);				$newId = $this->NewsWidget->id;								if(!empty($newId)){										$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(18, $data['widgetId']);					if(!empty($shortcode)){						$shortcode['Shortcode']['widget_id'] = $newId;						unset($shortcode['Shortcode']['id']);						$this->Shortcode->create();						$this->Shortcode->save($shortcode);					}										if(!empty($data['colId'])){						if(empty($footer))						{						$this->PageTemplateRowsColumn->id = $data['colId'];						$tpldata['PageTemplateRowsColumn']['shortcode'] = '[News-'.$newId.']';						$tpldata['PageTemplateRowsColumn']['clone_flag'] = 'Y';												$this->PageTemplateRowsColumn->save($tpldata);						}else {						$this->FooterColumn->id = $data['colId'];						$tpldata['FooterColumn']['shortcode'] = '[News-'.$newId.']';																		$this->FooterColumn->save($tpldata);												}					}					echo 1; exit();				} else {					echo 0; exit();				}			} else {				echo 0; exit();			}		}	}
	
	public function admin_copyitem($id){
		if(!empty($id)){
			$orgWidget = $this->NewsWidget->findById($id);
			unset($orgWidget['NewsWidget']['id']);
			
			$this->NewsWidget->create();
			$fl = $this->NewsWidget->save($orgWidget);
			$newId = $this->NewsWidget->id;
			
			if(!empty($newId)){					
				$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(18, $id);
				if(!empty($shortcode)){
					$shortcode['Shortcode']['widget_id'] = $newId;
					unset($shortcode['Shortcode']['id']);
					$this->Shortcode->create();
					$this->Shortcode->save($shortcode);
				}
				
				return '[News-'.$newId.']';
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
		$data['NewsWidget']['isdel'] = $isdel; 
		$this->NewsWidget->id = $id;
		$deleteFlag = $this->NewsWidget->save($data);
		
		if($deleteFlag)
		{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('News',$id);
				//pr($get_data); exit;
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
		}
		
		$this->Session->setFlash('<p>News Widget details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_deleteAll($idAll=NULL, $stat = '1')
	{	
		
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->NewsWidget->findById($id);
			
			$data['NewsWidget']['isdel'] = $stat;
			$this->NewsWidget->id = $id;
			$deleteFlag = $this->NewsWidget->save($data);
			
			if($deleteFlag){
			
			$this->loadModel('Shortcode');
			$get_data = $this->Shortcode->findByNameAndWidgetId('News',$id);
			//pr($get_data);
			$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
			
			
				$this->Session->setFlash('<p>News Widget removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>News Widget cannot be removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	public function admin_status($id=NULL,$stat = '0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['NewsWidget']['is_active'] = $stat;
		
		$this->NewsWidget->id = $id;
		$this->NewsWidget->save($data);
		$this->Session->setFlash('<p>News Widget updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	
}
?>