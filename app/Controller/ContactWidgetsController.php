<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');

class ContactWidgetsController extends AppController {
	
	public $name = 'ContactWidgets';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('ContactWidget','Style', 'Shortcode', 'PageTemplateRowsColumn','Page');
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
			//$titlekeyArr = array('style');
			$conditionArr = array();
			foreach($data['ContactWidget'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['ContactWidget.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
						$conditionArr['ContactWidget.'.$k] = $v;
						}
					}
				}
				$conditionArr['ContactWidget.is_active'] = 0;
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('ContactWidget.id' => 'DESC')
			);
			$this->set('searchData',$data);
		} else {
			$this->paginate=array(
						'limit' => PAGINATION_PER_PAGE_LIMIT,
						'conditions'=>array('ContactWidget.is_active'=>'0'),
						'order'=>array('ContactWidget.id' => 'DESC')
						);
		}
		$stylesArr = $this->Style->find('list', array(
				'conditions'=>array(
					'Style.group_id'=>6
				),
				'fields'=>array(
					'widgetstyle_name', 'name'
				)
			)
		);
			$data = $this->paginate('ContactWidget');
			
			$this->set(compact('data', 'stylesArr'));
		
	}
	
	
	public function admin_manage($id=NULL){	
		$this->layout = 'adminInner';
		
		if($this->request->is('post')){	
			
			if($this->ContactWidget->validates()){
				$data = $this->request->data;
				//pr($data); exit;
				if($id != ''){
					$this->ContactWidget->id = $id;
				} else{
					$this->ContactWidget->create();
				}
				$saveFlag = $this->ContactWidget->save($data);
				$saveId = $this->ContactWidget->id;
				if($saveFlag){
					if($id !== ''){
						$this->Session->setFlash('Contact Widget updated successfully.', 'default', array('class' => 'alert alert-success'));
					} else{
						$this->Session->setFlash('Contact Widget added successfully', 'default', array('class' => 'alert alert-success'));
					}
				} else {
					$this->Session->setFlash('Failed to save the Contact Widget', 'default', array('class' => 'alert alert-danger'));
				}
				if($data['ContactWidget']['status']=='Y')
				{
					$this->loadModel('Shortcode');
					$get_data = $this->Shortcode->findByNameAndWidgetId('Contact',$saveId);
					if(empty($get_data))
					{
						$styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['ContactWidget']['style'], 6);
						$data['Shortcode']['controller'] 	= 'ContactWidgets';
						$data['Shortcode']['action']		= 'manage';
						$data['Shortcode']['widget_id'] 	= $saveId;
						$data['Shortcode']['widget_title'] 	= $data['ContactWidget']['name'];
						$data['Shortcode']['name'] 			= 'Contact';
						$data['Shortcode']['group_id'] 		= 6;
						$data['Shortcode']['style_id'] 	= $styleData['Style']['id'];
						$this->Shortcode->create();
						$this->Shortcode->save($data);
					} else {
						$styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['ContactWidget']['style'], 6);
						$scdata = $this->Shortcode->findByNameAndWidgetId('Contact',$saveId);
						$this->Shortcode->id = $scdata['Shortcode']['id'];
						$savedata['Shortcode']['controller'] 	= 'ContactWidgets';
						$savedata['Shortcode']['action']		= 'manage';
						$savedata['Shortcode']['widget_id'] 	= $saveId;
						$savedata['Shortcode']['widget_title'] 	= $data['ContactWidget']['name'];
						$savedata['Shortcode']['name'] 			= 'Contact';
						$savedata['Shortcode']['group_id'] 		= 6;
						$savedata['Shortcode']['style_id'] 		= $styleData['Style']['id'];
				
						$this->Shortcode->save($savedata);
					}	
					
				}
				if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'ContactWidgets','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'ContactWidgets','action'=>'admin_index'));
				}	
			} 
		}
		$stylesArr = $this->Style->find('list', array(
				'conditions'=>array(
					'Style.group_id'=>6
				),
				'fields'=>array(
					'widgetstyle_name', 'name'
				)
			)
		);
		//pr($stylesArr); exit();
		$this->set('stylesArr', $stylesArr);
		
		
		if(trim($id) !== ''){
			$data = $this->ContactWidget->findById($id);
			
			if(!empty($data)){
				$widgetStyle = $this->Style->findByGroupIdAndWidgetstyleName(6,$data['ContactWidget']['style']);
			} else {
				$widgetStyle = array();
			}
			
			$this->set(compact('data', 'widgetStyle'));
		}
			
		$this->set('id', $id);
		
		
		$this->loadModel('style');
		$contactstyledata=$this->style->find('all', array(
				'order'=>array('style.id ASC'),
				'fields'=>array('style.widgetstyle_name', 'style.style_img','style.name'),
				'conditions'=>array('style.group_id'=>6)
			)
		);
		//pr($contactstyledata); exit;
		$this->set('contactstyledata',$contactstyledata);
			
	}
	
	public function admin_ajaxcopyitem(){
		$this->layout = 'ajax';
		if($this->request->is('post')){
			$data = $this->request->data;
			if(!empty($data)){							$pageid=$data['pageid'];			if(!empty($pageid)){			$this->Page->id = $pageid;		$updata['Page']['save']=1;		$this->Page->save($updata);		}
				$orgWidget = $this->ContactWidget->findById($data['widgetId']);
				unset($orgWidget['ContactWidget']['id']);
				
				$this->ContactWidget->create();
				$fl = $this->ContactWidget->save($orgWidget);
				$newId = $this->ContactWidget->id;
				
				if(!empty($newId)){					
					$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(6, $data['widgetId']);
					if(!empty($shortcode)){
						$shortcode['Shortcode']['widget_id'] = $newId;
						unset($shortcode['Shortcode']['id']);
						$this->Shortcode->create();
						$this->Shortcode->save($shortcode);
					}
					
					if(!empty($data['colId'])){
						$this->PageTemplateRowsColumn->id = $data['colId'];
						$tpldata['PageTemplateRowsColumn']['shortcode'] = '[Contact-'.$newId.']';
						$tpldata['PageTemplateRowsColumn']['clone_flag'] = 'Y';
						
						$this->PageTemplateRowsColumn->save($tpldata);
					}
					echo 1; exit();
				} else {
					echo 0; exit();
				}
			} else {
				echo 0; exit();
			}
		}
	}
	
	public function admin_copyitem($id){
		if(!empty($id)){
			$orgWidget = $this->ContactWidget->findById($id);
			unset($orgWidget['ContactWidget']['id']);
			$this->ContactWidget->create();
			$fl = $this->ContactWidget->save($orgWidget);
			$newId = $this->ContactWidget->id;
			if(!empty($newId)){					
				$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(6, $id);
				if(!empty($shortcode)){
					$shortcode['Shortcode']['widget_id'] = $newId;
					unset($shortcode['Shortcode']['id']);
					$this->Shortcode->create();
					$this->Shortcode->save($shortcode);
				}
				return '[Contact-'.$newId.']';
			}
			else {
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
		$data['ContactWidget']['is_active'] = $isdel; 
		$this->ContactWidget->id = $id;
		$deleteFlag = $this->ContactWidget->save($data);
		if($deleteFlag)
		{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Contact',$id);
				//pr($get_data); exit;
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
		}
		$this->Session->setFlash('<p> Contact Widget details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->ContactWidget->findById($id);
			
			$data['ContactWidget']['is_active'] = $stat;
			$this->ContactWidget->id = $id;
			$deleteFlag = $this->ContactWidget->save($data);
			
			if($deleteFlag){
			
			$this->loadModel('Shortcode');
			$get_data = $this->Shortcode->findByNameAndWidgetId('Contact',$id);
			//pr($get_data);
			$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
			
			
				$this->Session->setFlash('<p>Contact Widget removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Contact Widget cannot be removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	public function admin_status($id=NULL,$stat = 'Y')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['ContactWidget']['status'] = $stat;
		
		$this->ContactWidget->id = $id;
		$this->ContactWidget->save($data);
		$this->Session->setFlash('<p>Contact Widget updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	
}
?>