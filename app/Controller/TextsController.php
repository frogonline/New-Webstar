<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class TextsController extends AppController {

	public $name = 'Texts';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('Text','Style','Shortcode', 'PageTemplateRowsColumn','FooterColumn','Page');
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
			$conditionArr = array();
			foreach($data['Text'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['Text.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
							$conditionArr['Text.'.$k] = $v; 
					}
				}
			}
			$conditionArr['Text.isdel'] = 0;
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Text.id' => 'DESC')
			);
			$this->set('searchData',$data);
		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('Text.isdel'=>'0'),
					'order'=>array('Text.id' => 'DESC')
					);
			
		}
		$data= $this->paginate('Text');

		$this->set('data', $data);
		
	}
	
	public function admin_manage($id=NULL)
	{
		$this->layout = 'adminInner';
		
		if($this->request->is("post")){
			
			if($id != ''){
				$this->Text->id = $id;
			} else{
				$this->Text->create();
			}
			$data = $this->request->data;
			//pr($data); exit;
			$return =  $this->Text->save($data);
			$saveId = $this->Text->id;

			if($return['Text']['id'] != ''){
				$this->Session->setFlash('<p>Text updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else{
				$this->Session->setFlash('<p>Text added successfully!</p>', 'default', array('class' => 'alert alert-success'));
			}
			
			if($data['Text']['status']=='Y')
			{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Text',$return['Text']['id']);
			
				if(empty($get_data))
				{ 
				    $styleData = $this->Style->findByGroupId(26);
					$data['Shortcode']['controller'] 	= 'Texts';
					$data['Shortcode']['action']		= 'manage';
					$data['Shortcode']['widget_id'] 	= $return['Text']['id'];
					$data['Shortcode']['widget_title'] 	= $data['Text']['name'];
					$data['Shortcode']['name'] 			= 'Text';
					$data['Shortcode']['group_id'] 		= 26;
					$data['Shortcode']['style_id'] 		= $styleData['Style']['id'];
					$this->Shortcode->create();
					
					$this->Shortcode->save($data);
				} else {
					$styleData = $this->Style->findByGroupId(26);
					$scdata = $this->Shortcode->findByNameAndWidgetId('Text',$saveId);
					$this->Shortcode->id = $scdata['Shortcode']['id'];
					$savedata['Shortcode']['controller'] 	= 'Texts';
					$savedata['Shortcode']['action']		= 'manage';
					$savedata['Shortcode']['widget_id'] 	= $saveId;
					$savedata['Shortcode']['widget_title'] 	= $data['Text']['name'];
					$savedata['Shortcode']['name'] 			= 'Text';
					$savedata['Shortcode']['group_id'] 		= 26;
					$savedata['Shortcode']['style_id'] 		= $styleData['Style']['id'];
			
					$this->Shortcode->save($savedata);
				}	
			}
			
			if(array_key_exists('continue', $data)){
				$this->redirect(array('controller'=>'Texts','action'=>'admin_manage/'.$saveId));
			} else {
				$this->redirect(array('controller'=>'Texts','action'=>'admin_index'));
			}			
		}
		
		
		$this->set('id', $id);
		if($id != NULL || $id != ''){

			$data = $this->Text->findById($id);
	
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
		$orgWidget = $this->Text->findById($data['widgetId']);				unset($orgWidget['Text']['id']);								$this->Text->create();				$fl = $this->Text->save($orgWidget);				$newId = $this->Text->id;								if(!empty($newId)){										$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(26, $data['widgetId']);					if(!empty($shortcode)){						$shortcode['Shortcode']['widget_id'] = $newId;						unset($shortcode['Shortcode']['id']);						$this->Shortcode->create();						$this->Shortcode->save($shortcode);					}										if(!empty($data['colId'])){						if(empty($footer))						{						$this->PageTemplateRowsColumn->id = $data['colId'];						$tpldata['PageTemplateRowsColumn']['shortcode'] = '[Text-'.$newId.']';						$tpldata['PageTemplateRowsColumn']['clone_flag'] = 'Y';												$this->PageTemplateRowsColumn->save($tpldata);						}else {						$this->FooterColumn->id = $data['colId'];						$tpldata['FooterColumn']['shortcode'] = '[Text-'.$newId.']';																		$this->FooterColumn->save($tpldata);												}					}					echo 1; exit();				} else {					echo 0; exit();				}			} else {				echo 0; exit();			}		}	}
	
	public function admin_copyitem($id){
		if(!empty($id)){
			$orgWidget = $this->Text->findById($id);
			unset($orgWidget['Text']['id']);
			
			$this->Text->create();
			$fl = $this->Text->save($orgWidget);
			$newId = $this->Text->id;
			
			if(!empty($newId)){					
				$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(26, $id);
				if(!empty($shortcode)){
					$shortcode['Shortcode']['widget_id'] = $newId;
					unset($shortcode['Shortcode']['id']);
					$this->Shortcode->create();
					$this->Shortcode->save($shortcode);
				}
				
				return '[Text-'.$newId.']';
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
		$data['Text']['isdel'] = $isdel; 
		$this->Text->id = $id;
		$deleteFlag = $this->Text->save($data);
		
		if($deleteFlag)
		{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Text',$id);
				//pr($get_data); exit;
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
		}
		
		$this->Session->setFlash('<p>Text details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->Text->findById($id);
			
			$data['Text']['isdel'] = $stat;
			$this->Text->id = $id;
			$deleteFlag = $this->Text->save($data);
			
			if($deleteFlag){
			
			$this->loadModel('Shortcode');
			$get_data = $this->Shortcode->findByNameAndWidgetId('Text',$id);
			//pr($get_data);
			$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
			
			
			
				$this->Session->setFlash('<p>Texts removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Texts removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		} 
		$this->redirect($this->referer());	
	}
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Text']['status'] = $stat;
		
		$this->Text->id = $id;
		$this->Text->save($data);
		$this->Session->setFlash('<p>Text updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	public function admin_test($t){
		return $t;
	}
	
}

?>