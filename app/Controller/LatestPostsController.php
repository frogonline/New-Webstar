<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');

class LatestPostsController extends AppController {

	public $name = 'LatestPosts';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('Style','LatestPost', 'Shortcode', 'PageTemplateRowsColumn','FooterColumn','Page');
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
			foreach($data['LatestPost'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['LatestPost.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
							$conditionArr['LatestPost.'.$k] = $v;
						}
					}
				}
			$conditionArr['LatestPost.isdel'] = 0;
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('LatestPost.id' => 'DESC')
			);
			$this->set('searchData',$data);
		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('LatestPost.isdel'=>'0'),
					'order'=>array('LatestPost.id' => 'DESC')
					);
			}
				$stylesArr = $this->Style->find('list', array(
					'conditions'=>array(
						'Style.group_id'=>15
					),
					'fields'=>array(
						'widgetstyle_name', 'name'
					)
				)
			);
			$data = $this->paginate('LatestPost');
			
			$this->set(compact('data', 'stylesArr'));
	}
	
	
	public function admin_manage($id=NULL){	
		$this->layout = 'adminInner';
		
		if($this->request->is('post')){	
			
			if($this->LatestPost->validates()){
			
				$data = $this->request->data;
				//pr($data); exit();
				if($id != ''){
					
					$this->LatestPost->id = $id;
				} else{
			
					$this->LatestPost->create();
				}
				
				$saveFlag = $this->LatestPost->save($data);
				$saveId = $this->LatestPost->id;
				
				if($saveFlag){
					if($id !== ''){
						$this->Session->setFlash('Latest Post updated successfully.', 'default', array('class' => 'alert alert-success'));
					} else {
						$this->Session->setFlash('Latest Post added successfully', 'default', array('class' => 'alert alert-success'));
					}
				} else {
					$this->Session->setFlash('Failed to save the Latest Post', 'default', array('class' => 'alert alert-danger'));
				}
				if($data['LatestPost']['is_active']==0)
				{
					$this->loadModel('Shortcode');
					$get_data = $this->Shortcode->findByNameAndWidgetId('LatestPost',$saveId);
				
					if(empty($get_data))
					{
						$styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['LatestPost']['style'], 15);
					    //pr($styleData); exit();
						$data['Shortcode']['controller'] 	= 'LatestPosts';
						$data['Shortcode']['action']		= 'manage';
						$data['Shortcode']['widget_id'] 	= $saveId;
						$data['Shortcode']['widget_title'] 	= $data['LatestPost']['name'];
						$data['Shortcode']['name'] 			= 'LatestPost';
						$data['Shortcode']['group_id'] 		= 15;
					    $data['Shortcode']['style_id'] 		= $styleData['Style']['id'];
						$this->Shortcode->create();
						
						$this->Shortcode->save($data);
					} else {
					
						$styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['LatestPost']['style'], 15);
						$scdata = $this->Shortcode->findByNameAndWidgetId('LatestPost',$saveId);
						$this->Shortcode->id = $scdata['Shortcode']['id'];
						$savedata['Shortcode']['controller'] 	= 'LatestPosts';
						$savedata['Shortcode']['action']		= 'manage';
						$savedata['Shortcode']['widget_id'] 	= $saveId;
						$savedata['Shortcode']['widget_title'] 	= $data['LatestPost']['name'];
						$savedata['Shortcode']['name'] 			= 'LatestPost';
						$savedata['Shortcode']['group_id'] 		= 15;
						$savedata['Shortcode']['style_id'] 		= $styleData['Style']['id'];
				
						$this->Shortcode->save($savedata);
					}	
				}
				
				if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'LatestPosts','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'LatestPosts','action'=>'admin_index'));
				}
			} 
		}
		
		$stylesArr = $this->Style->find('list', array(
				'conditions'=>array(
					'Style.group_id'=>15
				),
				'fields'=>array(
					'widgetstyle_name', 'name'
				)
			)
		);
		//pr($stylesArr); exit();
		
		$this->set('stylesArr', $stylesArr);
		
		if(trim($id) !== ''){
			$data = $this->LatestPost->findById($id);
			if(!empty($data)){
				$widgetStyle = $this->Style->findByGroupIdAndWidgetstyleName(15,$data['LatestPost']['style']);
			} else {
				$widgetStyle = array();
			}
			$this->set(compact('data', 'widgetStyle'));
		}
			
			$this->set('id', $id);
		    $this->loadModel('style');
		    $lattestpost_styledata=$this->style->find('all', array(
					'order'=>array('style.id ASC'),
					'fields'=>array('style.widgetstyle_name', 'style.style_img','style.name'),
					'conditions'=>array('style.group_id'=>15)
				)
			);
			//pr($lattestpost_styledata); exit;
		    $this->set('lattestpost_styledata',$lattestpost_styledata);	
			
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
	$orgWidget = $this->LatestPost->findById($data['widgetId']);				unset($orgWidget['LatestPost']['id']);								$this->LatestPost->create();				$fl = $this->LatestPost->save($orgWidget);				$newId = $this->LatestPost->id;								if(!empty($newId)){										$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(15, $data['widgetId']);					if(!empty($shortcode)){						$shortcode['Shortcode']['widget_id'] = $newId;						unset($shortcode['Shortcode']['id']);						$this->Shortcode->create();						$this->Shortcode->save($shortcode);					}										if(!empty($data['colId'])){						if(empty($footer))						{						$this->PageTemplateRowsColumn->id = $data['colId'];						$tpldata['PageTemplateRowsColumn']['shortcode'] = '[LatestPost-'.$newId.']';						$tpldata['PageTemplateRowsColumn']['clone_flag'] = 'Y';												$this->PageTemplateRowsColumn->save($tpldata);						}else {						$this->FooterColumn->id = $data['colId'];						$tpldata['FooterColumn']['shortcode'] = '[LatestPost-'.$newId.']';																		$this->FooterColumn->save($tpldata);												}					}					echo 1; exit();				} else {					echo 0; exit();				}			} else {				echo 0; exit();			}		}	}		
	public function admin_copyitem($id){		if(!empty($id)){			$orgWidget = $this->LatestPost->findById($id);			unset($orgWidget['LatestPost']['id']);						$this->LatestPost->create();			$fl = $this->LatestPost->save($orgWidget);			$newId = $this->LatestPost->id;						if(!empty($newId)){									$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(15, $id);				if(!empty($shortcode)){					$shortcode['Shortcode']['widget_id'] = $newId;					unset($shortcode['Shortcode']['id']);					$this->Shortcode->create();					$this->Shortcode->save($shortcode);				}				return '[LatestPost-'.$newId.']';			} else {				return "";			}		} else {			return "";		}	}
	

	
	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['LatestPost']['isdel'] = $isdel; 
		$this->LatestPost->id = $id;
		$deleteFlag = $this->LatestPost->save($data);

		if($deleteFlag){
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('LatestPost',$id);
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
		}	
		
		$this->Session->setFlash('<p> Latest Post details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->LatestPost->findById($id);
			
			$data['LatestPost']['isdel'] = $stat;
			$this->LatestPost->id = $id;
			$deleteFlag = $this->LatestPost->save($data);
			if($deleteFlag){
			
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('LatestPost',$id);
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
				
				$this->Session->setFlash('<p>Latest Post removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Latest Post cannot be removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	public function admin_status($id=NULL,$stat = '0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['LatestPost']['is_active'] = $stat;
		
		$this->LatestPost->id = $id;
		$this->LatestPost->save($data);
		$this->Session->setFlash('<p>Latest Post updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
}
?>