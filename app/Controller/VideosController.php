<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');

class VideosController extends AppController {

	public $name = 'Videos';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('Video','Style','Shortcode', 'PageTemplateRowsColumn','FooterColumn','Page');
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
			//$titlekeyArr = array('style');
			$conditionArr = array();
			foreach($data['Video'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['Video.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
							$conditionArr['Video.'.$k] = $v;
						}
					}
				}
			$conditionArr['Video.isdel'] = 0;
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Video.id' => 'DESC')
			);
			$this->set('searchData',$data);
		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('Video.isdel'=>'0'),
					'order'=>array('Video.id' => 'DESC')
					);
	}
		$data = $this->paginate('Video');
		
		$this->set('data', $data);
	}
	
	public function admin_manage($id=NULL){	
		$this->layout = 'adminInner';
		
		if($this->request->is('post')){	
			
			if($this->Video->validates()){
			
				$data = $this->request->data;
				if($id != ''){
					
					$this->Video->id = $id;
				} else{
			
					$this->Video->create();
				}
				
				$saveFlag = $this->Video->save($data);
				$saveId = $this->Video->id;
				
				if($saveFlag){
					if($id != ''){
						$this->Session->setFlash('Video updated successfully.', 'default', array('class' => 'alert alert-success'));
					} else{
						$this->Session->setFlash('Video added successfully', 'default', array('class' => 'alert alert-success'));
					}
				} else {
					$this->Session->setFlash('Failed to save the video', 'default', array('class' => 'alert alert-danger'));
				}
				
				if($data['Video']['status']=='Y')
				{
					$this->loadModel('Shortcode');
					$get_data = $this->Shortcode->findByNameAndWidgetId('Video',$id);
				
					if(empty($get_data))
					{
					    $styleData = $this->Style->findByGroupId(28);
						/* pr($styleData);
						exit; */
						$data['Shortcode']['controller'] 	= 'Videos';
						$data['Shortcode']['action']		= 'manage';
						$data['Shortcode']['widget_id'] 	= $saveId;
						$data['Shortcode']['widget_title'] 	= $data['Video']['title'];
						$data['Shortcode']['name'] 			= 'Video';
						$data['Shortcode']['group_id'] 		= 28;
					    $data['Shortcode']['style_id'] 		= $styleData['Style']['id'];
						$this->Shortcode->create();
						
						$this->Shortcode->save($data);
					} else {
						$styleData = $this->Style->findByGroupId(28);
						$scdata = $this->Shortcode->findByNameAndWidgetId('Video',$saveId);
						$this->Shortcode->id = $scdata['Shortcode']['id'];
						$savedata['Shortcode']['controller'] 	= 'Videos';
						$savedata['Shortcode']['action']		= 'manage';
						$savedata['Shortcode']['widget_id'] 	= $saveId;
						$savedata['Shortcode']['widget_title'] 	= $data['Video']['title'];
						$savedata['Shortcode']['name'] 			= 'Video';
						$savedata['Shortcode']['group_id'] 		= 28;
						$savedata['Shortcode']['style_id'] 		= $styleData['Style']['id'];
				
						$this->Shortcode->save($savedata);
					}	
				}
				
				if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'Videos','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'Videos','action'=>'admin_index'));
				}
				//$this->redirect(array('controller'=>'Videos','action'=>'admin_index'));
			} 
		}
		if(trim($id) !== ''){
				$data = $this->Video->findById($id);
				$this->set('data', $data);
			}
			
			$this->set('id', $id);
	}
	
	
		public function admin_ajaxcopyitem($footer){		$this->layout = 'ajax';	
		if($this->request->is('post')){		
		$data = $this->request->data;	
				$pageid=$data['pageid'];
			if(!empty($pageid)){
	
		$this->Page->id = $pageid;
		$updata['Page']['save']=1;
		$this->Page->save($updata);
		}
		if(!empty($data)){				$orgWidget = $this->Video->findById($data['widgetId']);				unset($orgWidget['Video']['id']);								$this->Video->create();				$fl = $this->Video->save($orgWidget);				$newId = $this->Video->id;								if(!empty($newId)){										$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(28, $data['widgetId']);					if(!empty($shortcode)){						$shortcode['Shortcode']['widget_id'] = $newId;						unset($shortcode['Shortcode']['id']);						$this->Shortcode->create();						$this->Shortcode->save($shortcode);					}										if(!empty($data['colId'])){						if(empty($footer))						{						$this->PageTemplateRowsColumn->id = $data['colId'];						$tpldata['PageTemplateRowsColumn']['shortcode'] = '[Video-'.$newId.']';						$tpldata['PageTemplateRowsColumn']['clone_flag'] = 'Y';												$this->PageTemplateRowsColumn->save($tpldata);						}else {						$this->FooterColumn->id = $data['colId'];						$tpldata['FooterColumn']['shortcode'] = '[Video-'.$newId.']';																		$this->FooterColumn->save($tpldata);												}					}					echo 1; exit();				} else {					echo 0; exit();				}			} else {				echo 0; exit();			}		}	}	
	
	public function admin_copyitem($id){
		if(!empty($id)){
			
			$orgWidget = $this->Video->findById($id);
			unset($orgWidget['Video']['id']);
			
			$this->Video->create();
			$fl = $this->Video->save($orgWidget);
			$newId = $this->Video->id;
			
			if(!empty($newId)){					
				$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(28, $id);
				if(!empty($shortcode)){
					$shortcode['Shortcode']['widget_id'] = $newId;
					unset($shortcode['Shortcode']['id']);
					$this->Shortcode->create();
					$this->Shortcode->save($shortcode);
				}
				
				return '[Video-'.$newId.']';
			} else {
				echo 0; exit();
			}
			
		} else {
			return "";
		}
	}
	
	
	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Video']['isdel'] = $isdel; 
		$this->Video->id = $id;
		$deleteFlag = $this->Video->save($data);	

		if($deleteFlag)
		{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Video',$id);
				//pr($get_data); exit;
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
		}
		
		$this->Session->setFlash('<p>Video details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->Video->findById($id);
			
			$data['Video']['isdel'] = $stat;
			$this->Video->id = $id;
			$deleteFlag = $this->Video->save($data);
			
			if($deleteFlag){
			
			$this->loadModel('Shortcode');
			$get_data = $this->Shortcode->findByNameAndWidgetId('Video',$id);
			//pr($get_data);
			$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
			
				$this->Session->setFlash('<p>Videos removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Video cannot be removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Video']['status'] = $stat;
		
		$this->Video->id = $id;
		$this->Video->save($data);
		$this->Session->setFlash('<p>Video updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	
	
	
}
	
?>