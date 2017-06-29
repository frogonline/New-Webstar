<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class SidebarsController extends AppController {

	public $name = 'Sidebars';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('Sidebar','Shortcode','Style','SidebarOption','PageTemplateRowsColumn','FooterColumn','Page');
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
		$data = $this->request->data;
		if(empty($data['Sidebar']['searchvalue'])){
			
			if($this->request->is("post")){
				$this->Sidebar->create();
				
				$data = $this->request->data;
				
				$saveFlag =  $this->Sidebar->save($data);
				$saveId = $this->Sidebar->id;
				
				if($saveFlag){
					$this->loadModel('Shortcode');
					$get_data = $this->Shortcode->findByNameAndWidgetId('Sidebar',$saveId);
					
					if(empty($get_data))
					{
						$styleData = $this->Style->findByGroupId(21);
						$saveData['Shortcode']['controller'] 	= 'Sidebars';
						$saveData['Shortcode']['action']		= 'manage';
						$saveData['Shortcode']['widget_id'] 	= $saveId;
						$saveData['Shortcode']['widget_title'] 	= $data['Sidebar']['name'];
						$saveData['Shortcode']['name'] 			= 'Sidebar';
						$saveData['Shortcode']['group_id'] 		= 21;
						$saveData['Shortcode']['style_id'] 		= $styleData['Style']['id'];
						$this->Shortcode->create();
						$this->Shortcode->save($saveData);
					} else {
						$styleData = $this->Style->findByGroupId(21);
						$scdata = $this->Shortcode->findByNameAndWidgetId('Sidebar',$saveId);
						$this->Shortcode->id = $scdata['Shortcode']['id'];
						$savedata['Shortcode']['controller'] 	= 'Sidebars';
						$savedata['Shortcode']['action']		= 'manage';
						$savedata['Shortcode']['widget_id'] 	= $saveId;
						$savedata['Shortcode']['widget_title'] 	= $data['Sidebar']['name'];
						$savedata['Shortcode']['name'] 			= 'Sidebar';
						$savedata['Shortcode']['group_id'] 		= 21;
						$savedata['Shortcode']['style_id'] 		= $styleData['Style']['id'];
				
						$this->Shortcode->save($savedata);
					}
					
					$this->Session->setFlash('<p>Sidebar added successfully!</p>', 'default', array('class' => 'alert alert-success'));
				} else {
					$this->Session->setFlash('<p>Failed to add sidebar!</p>', 'default', array('class' => 'alert alert-danger'));
				}
				$this->redirect(array('controller'=>'Sidebars','action'=>'admin_index'));
			}
		}
	
		if($this->request->is("post"))
		{ 
			$data = $this->request->data;
			$likekeyArr = array('name');
			$conditionArr = array();
			foreach($data['Sidebar'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['Sidebar.'.$k.' LIKE'] = '%'.$v.'%';
					}
				}
			}
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Sidebar.id' => 'DESC')
			);
			$this->set('searchData',$data);

		}else {
			$this->paginate=array(
			'limit' => PAGINATION_PER_PAGE_LIMIT,
			'order' => array('Sidebar.id' => 'DESC')
			);
		}
		$data= $this->paginate('Sidebar');
		$this->set('data', $data);
	}
	
	public function admin_manage($id=NULL){
		$this->layout = 'adminInner';
		if(!empty($id)){
			$optionsArr = $this->SidebarOption->find('all', array(
					'conditions'=>array(
						'SidebarOption.sidebar_id'=>$id
					),
					'order'=>array(
						'SidebarOption.sort_order ASC'
					)
				)
			);
		} else {
			$optionsArr = array();
			$this->redirect(array('controller'=>'Sidebars','action'=>'admin_index'));
		}
		$this->set(compact('id','optionsArr'));
	}
	
	public function admin_addoption($id = NULL){
		$this->layout = '';
		$this->autoRender = false;
		
		if(!empty($id)){
			if($this->request->is('post')){
				$data = $this->request->data;
				$this->SidebarOption->create();
				
				$saveFlag = $this->SidebarOption->save($data);
				
				if($saveFlag){
					$this->Session->setFlash('<p>Shortcode added successfully!</p>', 'default', array('class' => 'alert alert-success'));
				} else {
					$this->Session->setFlash('<p>Failed to add shortcode!</p>', 'default', array('class' => 'alert alert-danger'));
				}
				$this->redirect(array('controller'=>'Sidebars','action'=>'admin_manage/'.$id));
			}
		}
	}
	
	public function admin_sortitem(){
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$data = $this->request->data;
			$sitems=json_decode($data['sstring']);
			//pr($mitems);
			
			$flag=$this->item_update($sitems);
			if($flag){
				echo 1;
			}
			else{
				echo "Try Later";
			}
			
			exit();
		}
		
	}
	
	private function item_update($sitems){
		$c=1;
		foreach($sitems as $sitem){
			$val['SidebarOption']['sort_order']=$c;
			$this->SidebarOption->id=$sitem->id;
			$flag = $this->SidebarOption->save($val);
			$c++;
		}
		
		return $flag;
	}
	
	public function admin_itemdelete($item_id = NULL, $sidebar_id = NULL)
	{
		$this->layout = '';
		$this->autoRender = false;
		
		$deleteFlag = $this->SidebarOption->delete($item_id);
		
		if($deleteFlag){
			$this->Session->setFlash('<p>Sidebar item has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('<p>Failed to delete sidebar item!</p>', 'default', array('class' => 'alert alert-danger'));
		}
		$this->redirect(array('controller'=>'Sidebars','action'=>'admin_manage/'.$sidebar_id));
	}
	
	public function admin_ajaxcopyitem($footer){	
	$this->layout = 'ajax';	
	if($this->request->is('post')){	
	$data = $this->request->data;	
		$pageid=$data['pageid'];
			if(!empty($pageid)){
	
		$this->Page->id = $pageid;
		$updata['Page']['save']=1;
		$this->Page->save($updata);
		}
	if(!empty($data)){				$arr = array_keys($this->SidebarOption->schema());				unset($arr[0]);				$this->Sidebar->bindModel(					array(						'hasMany'=>array(							'SidebarOption'=>array(								'className'=>'SidebarOption',								'foreignKey'=>'sidebar_id',								'fields'=>$arr							)						)					)				);												$orgWidget = $this->Sidebar->findById($data['widgetId']);				unset($orgWidget['Sidebar']['id']);								$this->Sidebar->create();				$fl = $this->Sidebar->save($orgWidget);				$newId = $this->Sidebar->id;								if(!empty($newId)){					if(!empty($orgWidget['SidebarOption'])){						foreach($orgWidget['SidebarOption'] as $widgetItem){							$saveData['SidebarOption'] = $widgetItem;							$saveData['SidebarOption']['accordion_id'] = $newId;														$this->SidebarOption->create();							$this->SidebarOption->save($saveData);						}					}										$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(21, $data['widgetId']);					if(!empty($shortcode)){						$shortcode['Shortcode']['widget_id'] = $newId;						unset($shortcode['Shortcode']['id']);						$this->Shortcode->create();						$this->Shortcode->save($shortcode);					}										if(!empty($data['colId'])){						if(empty($footer))						{						$this->PageTemplateRowsColumn->id = $data['colId'];						$tpldata['PageTemplateRowsColumn']['shortcode'] = '[Sidebar-'.$newId.']';						$tpldata['PageTemplateRowsColumn']['clone_flag'] = 'Y';												$this->PageTemplateRowsColumn->save($tpldata);						}else {						$this->FooterColumn->id = $data['colId'];						$tpldata['FooterColumn']['shortcode'] = '[Sidebar-'.$newId.']';																		$this->FooterColumn->save($tpldata);												}					}					echo 1; exit();				} else {					echo 0; exit();				}			} else {				echo 0; exit();			}		}	}
	
	public function admin_copyitem($id){
		if(!empty($id)){
			$arr = array_keys($this->SidebarOption->schema());
			unset($arr[0]);
			$this->Sidebar->bindModel(
				array(
					'hasMany'=>array(
						'SidebarOption'=>array(
							'className'=>'SidebarOption',
							'foreignKey'=>'sidebar_id',
							'fields'=>$arr
						)
					)
				)
			);
			
			
			$orgWidget = $this->Sidebar->findById($id);
			unset($orgWidget['Sidebar']['id']);
			
			$this->Sidebar->create();
			$fl = $this->Sidebar->save($orgWidget);
			$newId = $this->Sidebar->id;
			
			if(!empty($newId)){
				if(!empty($orgWidget['SidebarOption'])){
					foreach($orgWidget['SidebarOption'] as $widgetItem){
						$saveData['SidebarOption'] = $widgetItem;
						$saveData['SidebarOption']['sidebar_id'] = $newId;
						
						$this->SidebarOption->create();
						$this->SidebarOption->save($saveData);
					}
				}
				
				$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(21, $id);
				if(!empty($shortcode)){
					$shortcode['Shortcode']['widget_id'] = $newId;
					unset($shortcode['Shortcode']['id']);
					$this->Shortcode->create();
					$this->Shortcode->save($shortcode);
				}
				
				return '[Sidebar-'.$newId.']';
				
				
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
		
		$deleteFlag = $this->Sidebar->delete($id);
		
		if($deleteFlag)
		{
			$this->SidebarOption->deleteAll(array('SidebarOption.sidebar_id'=>$id));
			
			$this->loadModel('Shortcode');
			$get_data = $this->Shortcode->findByNameAndWidgetId('Sidebar',$id);
			//pr($get_data); exit;
			$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
		}
		
		$this->Session->setFlash('<p>Sidebar has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
		
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$deleteFlag = $this->Sidebar->delete($id);
			if($deleteFlag){
				$this->SidebarOption->deleteAll(array('SidebarOption.sidebar_id'=>$id));
				
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Sidebar',$id);
				//pr($get_data); exit;
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
				
				$this->Session->setFlash('<p>Sidebar removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Sidebar removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
}
?>