<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class CalloutBoxesController extends AppController {

	public $name = 'CalloutBoxes';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	
	public $uses = array('CalloutBox','Style','Shortcode', 'PageTemplateRowsColumn','FooterColumn','Page','EditPageTemplateRowsColumn');
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
	
	public function admin_index($id=Null)
	{
		$this->layout = 'adminInner';
		$this->paginate=array(
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('CalloutBox.id' => 'DESC')
				);
		$data=$this->paginate('CalloutBox');
		$this->set('data', $data);
	}
	
	public function admin_manage($id=NULL)
	{
		$this->layout = 'adminInner';
		
		if($this->request->is("post")){
			
			if($id != ''){
				$this->CalloutBox->id = $id;
			} else{
				$this->CalloutBox->create();
			}
			$data = $this->request->data;
			//pr($data); exit;
			$return =  $this->CalloutBox->save($data);
			$saveId = $this->CalloutBox->id;

			if($return['CalloutBox']['id'] != ''){
				$this->Session->setFlash('<p>Callout Box updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else{
				$this->Session->setFlash('<p>Callout Box added successfully!</p>', 'default', array('class' => 'alert alert-success'));
			}
			
				$this->loadModel('Shortcode');
				$this->loadModel('Style');
				$get_data = $this->Shortcode->findByNameAndWidgetId('CalloutBox',$return['CalloutBox']['id']);
			
				if(empty($get_data))
				{ 
					$styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['CalloutBox']['style'], 38);
					$data['Shortcode']['controller'] 	= 'CalloutBoxes';
					$data['Shortcode']['action']		= 'manage';
					$data['Shortcode']['widget_id'] 	= $return['CalloutBox']['id'];
					$data['Shortcode']['widget_title'] 	= $data['CalloutBox']['heading'];
					$data['Shortcode']['name'] 			= 'CalloutBox';
					$data['Shortcode']['group_id'] 		= 38;
					$data['Shortcode']['style_id'] 		= $styleData['Style']['id'];
					$this->Shortcode->create();
					
					$this->Shortcode->save($data);
				} else {
					$styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['CalloutBox']['style'], 38);
					$scdata = $this->Shortcode->findByNameAndWidgetId('CalloutBox',$saveId);
					$this->Shortcode->id = $scdata['Shortcode']['id'];
					$savedata['Shortcode']['controller'] 	= 'CalloutBoxes';
					$savedata['Shortcode']['action']		= 'manage';
					$savedata['Shortcode']['widget_id'] 	= $saveId;
					$savedata['Shortcode']['widget_title'] 	= $data['CalloutBox']['heading'];
					$savedata['Shortcode']['name'] 			= 'CalloutBox';
					$savedata['Shortcode']['group_id'] 		= 38;
					$savedata['Shortcode']['style_id'] 		= $styleData['Style']['id'];
			
					$this->Shortcode->save($savedata);
				}	
			
			
			if(array_key_exists('continue', $data)){
				$this->redirect(array('controller'=>'CalloutBoxes','action'=>'admin_manage/'.$saveId));
			} else {
				$this->redirect(array('controller'=>'CalloutBoxes','action'=>'admin_index'));
			}			
		}
		$this->set('id', $id);
		
		$this->loadModel('style');
		if(trim($id) !== ''){
			$data = $this->CalloutBox->findById($id);
			
			if(!empty($data)){
				$widgetStyle = $this->style->findByGroupIdAndWidgetstyleName(38,$data['CalloutBox']['style']);
			} else {
				$widgetStyle = array();
			}
			
			
			$this->set(compact('data', 'widgetStyle'));
		}
		
		
		
		$caloutstyledata=$this->style->find('all', array(
				'order'=>array('style.id ASC'),
				'fields'=>array('style.widgetstyle_name', 'style.style_img','style.name'),
				'conditions'=>array('style.group_id'=>38)
			)
		);
		//pr($contactstyledata); exit;
		$this->set('caloutstyledata',$caloutstyledata);
		
	}
	public function admin_delete($id=NULL)
	{	
		$this->layout = '';
		$this->autoRender = false;
		$deleteFlag = $this->CalloutBox->delete($id);
		if($deleteFlag)
		{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('CalloutBox',$id);
				//pr($get_data); exit;
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
		}
		
		$this->Session->setFlash('<p>Callout Box details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_deleteAll($idAll=NULL)
	{	
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		foreach($idArr as $id){
			$deleteFlag = $this->CalloutBox->delete($id);
			if($deleteFlag){
			
			$this->loadModel('Shortcode');
			$get_data = $this->Shortcode->findByNameAndWidgetId('CalloutBox',$id);
			$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
			$this->Session->setFlash('<p>Callout Box removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Callout Box removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		} 
		$this->redirect($this->referer());	
	}
	
	public function admin_status($id=NULL, $status =NULL)
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['CalloutBox']['status'] = $status;
		
		$this->CalloutBox->id = $id;
		$updateFlag = $this->CalloutBox->save($data);
		
		if($updateFlag){
			$this->Session->setFlash('Callout Box status changed successfully!', 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('Failed to changed status!', 'default', array('class' => 'alert alert-danger'));
		}
		$this->redirect($this->referer());
	}
	
	public function admin_ajaxcopyitem($footer)
	{
	$this->layout = 'ajax';
	if ($this->request->is('post'))
		{
		$data = $this->request->data;
		if (!empty($data))
			{
			$pageid = $data['pageid'];
			if (!empty($pageid))
				{
				$this->Page->id = $pageid;
				$updata['Page']['save'] = 1;
				$this->Page->save($updata);
				}

			$orgWidget = $this->CalloutBox->findById($data['widgetId']);
			unset($orgWidget['CalloutBox']['id']);
			$this->CalloutBox->create();
			$fl = $this->CalloutBox->save($orgWidget);
			$newId = $this->CalloutBox->id;
			if (!empty($newId))
				{
				$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(38, $data['widgetId']);
				if (!empty($shortcode))
					{
					$shortcode['Shortcode']['widget_id'] = $newId;
					unset($shortcode['Shortcode']['id']);
					$this->Shortcode->create();
					$this->Shortcode->save($shortcode);
					}

				if (!empty($data['colId']))
					{
					if (empty($footer))
						{
						$this->PageTemplateRowsColumn->id = $data['colId'];
						$tpldata['PageTemplateRowsColumn']['shortcode'] = '[CalloutBox-' . $newId . ']';
						$tpldata['PageTemplateRowsColumn']['clone_flag'] = 'Y';
						$this->PageTemplateRowsColumn->save($tpldata);
						
						if($data['def']=='def')
							{
								$editdatarow['EditPageTemplateRowsColumn']['shortcode']='[CalloutBox-' . $newId . ']';
								$shortcode1='[CalloutBox-' . $newId . ']';
							
								
								$datarow=$this->EditPageTemplateRowsColumn->findByColumnIdAndPageId($data['colId'],$data['pageid']);
								
								$this->EditPageTemplateRowsColumn->id=$datarow['EditPageTemplateRowsColumn']['id'];
								$fl =$this->EditPageTemplateRowsColumn->save($editdatarow);
							}
						
						}
					  else
						{
						$this->FooterColumn->id = $data['colId'];
						$tpldata['FooterColumn']['shortcode'] = '[CalloutBox-' . $newId . ']';
						$this->FooterColumn->save($tpldata);
						}
					}
					if($data['def']=='def')
							{
					echo $shortcode1;
					exit();
				}else {
				echo 1;
					exit();
				
				}
				}
			  else
				{
				echo 0;
				exit();
				}
			}
		  else
			{
			echo 0;
			exit();
			}
		}
	}
	
	
	public function admin_copyitem($id){
		if(!empty($id)){
		
			$orgWidget = $this->CalloutBox->findById($id);
			unset($orgWidget['CalloutBox']['id']);
			
			$this->CalloutBox->create();
			$fl = $this->CalloutBox->save($orgWidget);
			$newId = $this->CalloutBox->id;
			
			if(!empty($newId)){					
				$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(38, $id);
				if(!empty($shortcode)){
					$shortcode['Shortcode']['widget_id'] = $newId;
					unset($shortcode['Shortcode']['id']);
					$this->Shortcode->create();
					$this->Shortcode->save($shortcode);
				}
				
				return '[CalloutBox-'.$newId.']';
			} else {
				return "";
			}
		} else {
			return "";
		}
	}
	
	
	

	

}
?>