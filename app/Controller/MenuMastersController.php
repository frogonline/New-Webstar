<?php
class MenuMastersController extends AppController 
{
	public $name = 'MenuMasters';
	public $components = array();
	public $helpers = array();
	public $uses = array('MenuMaster', 'MenuitemMaster', 'Shortcode', 'Style', 'Shortcode', 'PageTemplateRowsColumn','FooterColumn','Page');
	public $paginate = array();

	public function beforeFilter() 
	{
		parent::beforeFilter();
		
		//$this->Auth->allow('*');
		
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
		
		if($this->request->is("post")){
			$data = $this->request->data;
			$slugArr = array('Model'=>'MenuMaster','field'=>'menu_slug');
			$data['MenuMaster']['menu_slug'] = AppController::get_slug($data['MenuMaster']['menu_name'],$slugArr);
			$data['MenuMaster']['menu_type'] = 'D';
			$this->MenuMaster->create();
			$saveFlag = $this->MenuMaster->save($data);
			$saveId = $this->MenuMaster->id;
			
			if($saveFlag){
				$checkData = $this->Shortcode->find('count',array(
						'conditions'=>array(
							'Shortcode.name'=>'Menu',
							'Shortcode.id'=>$saveId
						)
					)
				);
				
				if($checkData == 0){
					$styleData = $this->Style->findByGroupId(29);
					//pr($styleData); exit();
					$savedata['Shortcode']['controller'] 	= 'MenuMasters';
					$savedata['Shortcode']['action']		= 'manage';
					$savedata['Shortcode']['widget_id'] 	= $saveId;
					$savedata['Shortcode']['name'] 			= 'Menu';
					$savedata['Shortcode']['group_id'] 		= 29;
					$savedata['Shortcode']['widget_title'] 	= $data['MenuMaster']['menu_name'];
					$savedata['Shortcode']['style_id'] 		= $styleData['Style']['id'];
					$this->Shortcode->create();
					
					$this->Shortcode->save($savedata);
				}
				
				$this->Session->setFlash('Menu added successfully!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to add menu', 'default', array('class' => 'alert alert-danger'));
			}
			
			$this->redirect(array('controller'=>'MenuMasters', 'action'=>'admin_index'));
		}
		$this->paginate=array(
					
					'limit' => PAGINATION_PER_PAGE_LIMIT,
				);
		
		$data = $this->paginate('MenuMaster');
		$this->set('data',$data);
		/* pr($data);
		exit; */
	}
	
	public function admin_manage($id=NULL)
	{
		$this->layout = 'adminInner';
		$ThemeSetting=$this->Session->read('ThemeSetting');
		$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
		if($id != NULL){
			$menu = $this->MenuMaster->findById($id);
			
			$this->loadModel('Page');
			if($ThemeSettingheadertype=='H')
			{
				$page = $this->Page->find('all', array(
				'conditions' => array('Page.is_del'=>'0','Page.template_use'=>'HN'),
				'fields' => array('Page.id','Page.title')
				)
				);
			}
			if($ThemeSettingheadertype=='V')
			{
				$page = $this->Page->find('all', array(
				'conditions' => array('Page.is_del'=>'0','Page.template_use'=>'VN'),
				'fields' => array('Page.id','Page.title')
				)
				);
			}
			
			
			$this->loadModel('ProductCategory');
			$productcategory = $this->ProductCategory->find('all', array(
				'conditions' => array('ProductCategory.is_del'=>'0'),
				'fields' => array('ProductCategory.id','ProductCategory.name')
				)
			);
			
			$this->loadModel('PostCategory');
			$postcategory = $this->PostCategory->find('all', array(
				'conditions' => array('PostCategory.status'=>'Y'),
				'fields' => array('PostCategory.id','PostCategory.category_name')
				)
			);
			
			$this->set(compact('menu','page','productcategory','postcategory','id'));
		} else {
			$this->redirect(array('controller'=>'MenuMasters', 'action'=>'admin_index'));
		}
	}
	
	 public function admin_delete1($id=NULL)
	{	
		$this->layout = '';
		$this->autoRender = false;
		$this->MenuMaster->id = $id;
		$this->MenuMaster->delete($id);
		$this->loadModel('Shortcode');
		$this->Shortcode->deleteAll(array('Shortcode.widget_id'=>$id,'Shortcode.controller'=>'MenuMasters',
										  'Shortcode.action'=>'manage','Shortcode.name'=>'Menu','Shortcode.group_id'=>29));
		$this->Session->setFlash('<p>Menu has been successfully removed!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());
	} 
	
	public function admin_menu_option($id=NULL)
	{
		if($this->request->is('post')){
			$post = $this->request->data;
			
			$flag = array();
			foreach($post['MenuitemMaster']['page_id'] as $pid){
				$pg = ClassRegistry::init('Page')->findById($pid);
				$svData['MenuitemMaster']['menu_id'] = $post['MenuMaster']['id'];
				$svData['MenuitemMaster']['page_title'] = $pg['Page']['title'];
				$svData['MenuitemMaster']['page_url'] = SITE_URL.$pg['Page']['slug'];
				$svData['MenuitemMaster']['parent_id'] = 0;
				$svData['MenuitemMaster']['sort_order'] = 0;
				
				$this->loadModel('MenuitemMaster');
				$this->MenuitemMaster->create();
				$saveArr = $this->MenuitemMaster->save($svData);
				
				if($saveArr){
					array_push($flag, 'T');
				} else {
					array_push($flag, 'F');
					break;
				}
			}
			
			if(!empty($flag)){
				if(in_array('F', $flag)){
					$this->Session->setFlash('Failed to add all items', 'default', array('class' => 'alert alert-danger'));
				} else {
					$this->Session->setFlash('Items added successfully!', 'default', array('class' => 'alert alert-success'));
				}
			} else {
				$this->Session->setFlash('Failed to add the items', 'default', array('class' => 'alert alert-danger'));
			}
			$this->redirect(array('controller'=>'MenuMasters', 'action'=>'admin_manage/'.$id));
		}
	}
	
	public function admin_menu_productcategory($id=NULL)
	{
		if($this->request->is('post')){
			$pcat = $this->request->data;
			//pr($post); exit();
			$flag = array();
			foreach($pcat['MenuitemMaster']['productcategory_id'] as $pid){
				$pg = ClassRegistry::init('ProductCategory')->findById($pid);
				$svData['MenuitemMaster']['menu_id'] = $pcat['MenuMaster']['id'];
				$svData['MenuitemMaster']['page_title'] = $pg['ProductCategory']['name'];
				$svData['MenuitemMaster']['page_url'] = SITE_URL.$pg['ProductCategory']['categories_slug'];
				$svData['MenuitemMaster']['parent_id'] = 0;
				$svData['MenuitemMaster']['sort_order'] = 0;
				
				$this->loadModel('MenuitemMaster');
				$this->MenuitemMaster->create();
				$saveArr = $this->MenuitemMaster->save($svData);
				
				if($saveArr){
					array_push($flag, 'T');
				} else {
					array_push($flag, 'F');
					break;
				}
			}
			
			if(!empty($flag)){
				if(in_array('F', $flag)){
					$this->Session->setFlash('Failed to add all items', 'default', array('class' => 'alert alert-danger'));
				} else {
					$this->Session->setFlash('Items added successfully!', 'default', array('class' => 'alert alert-success'));
				}
			} else {
				$this->Session->setFlash('Failed to add the items', 'default', array('class' => 'alert alert-danger'));
			}
			$this->redirect(array('controller'=>'MenuMasters', 'action'=>'admin_manage/'.$id));
		}
	}
	
	public function admin_menu_postcategory($id=NULL)
	{
		if($this->request->is('post')){
			$pcat = $this->request->data;
			//pr($post); exit();
			$flag = array();
			foreach($pcat['MenuitemMaster']['postcategory_id'] as $pid){
				$pg = ClassRegistry::init('PostCategory')->findById($pid);
				$svData['MenuitemMaster']['menu_id'] = $pcat['MenuMaster']['id'];
				$svData['MenuitemMaster']['page_title'] = $pg['PostCategory']['category_name'];
				$svData['MenuitemMaster']['page_url'] = SITE_URL.$pg['PostCategory']['slug'];
				$svData['MenuitemMaster']['parent_id'] = 0;
				$svData['MenuitemMaster']['sort_order'] = 0;
				
				$this->loadModel('MenuitemMaster');
				$this->MenuitemMaster->create();
				$saveArr = $this->MenuitemMaster->save($svData);
				
				if($saveArr){
					array_push($flag, 'T');
				} else {
					array_push($flag, 'F');
					break;
				}
			}
			
			if(!empty($flag)){
				if(in_array('F', $flag)){
					$this->Session->setFlash('Failed to add all items', 'default', array('class' => 'alert alert-danger'));
				} else {
					$this->Session->setFlash('Items added successfully!', 'default', array('class' => 'alert alert-success'));
				}
			} else {
				$this->Session->setFlash('Failed to add the items', 'default', array('class' => 'alert alert-danger'));
			}
			$this->redirect(array('controller'=>'MenuMasters', 'action'=>'admin_manage/'.$id));
		}
	}
	
	public function admin_custom_option($id=NULL)
	{
		if($this->request->is('post')){
			$post = $this->request->data;
			$this->loadModel('MenuitemMaster');
			$this->MenuitemMaster->create();
			$saveArr = $this->MenuitemMaster->save($post);
			
			if($saveArr){
				$this->Session->setFlash('Items added successfully!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to add item', 'default', array('class' => 'alert alert-danger'));
			}
			$this->redirect(array('controller'=>'MenuMasters', 'action'=>'admin_manage/'.$id));
		}
	}
	
	public function admin_update_menu()
	{
		$this->layout = 'ajax';
		$this->autoRender = false;
		
		$data = $this->request->data;
		$mitems=json_decode($data['mstring']);
		//pr($mitems);
		
		$flag=$this->item_update(0,$data['menu_id'],$mitems);
		if($flag){
			echo 1;
		}
		else{
			echo "Try Later";
		}
		
		exit();
	}
	
	private function item_update($pid=0,$menu_id,$mitems){
		$c=1;
		foreach($mitems as $mitem){
			$this->loadModel('MenuitemMaster');
			
			$ch = array_key_exists('children', $mitem)?true:false;
			
			if($ch){
				$val['MenuitemMaster']['parent_id']=$pid;
				$val['MenuitemMaster']['sort_order']=$c;
				$this->MenuitemMaster->id=$mitem->id;
				$this->MenuitemMaster->save($val);
				
				$flag = $this->item_update($mitem->id,$menu_id,$mitem->children);
				$c++;
			}
			else{
				$val['MenuitemMaster']['parent_id']=$pid;
				$val['MenuitemMaster']['sort_order']=$c;
				$this->MenuitemMaster->id=$mitem->id;
				$this->MenuitemMaster->save($val);
				$c++;
				$flag = true;
			}
		
		}
		
		return $flag;
	}
	
	public function admin_item_delete($id=NULL){
		$this->loadModel('MenuitemMaster');
		$data = $this->MenuitemMaster->find('all',
					array(
						'conditions' => array('MenuitemMaster.parent_id'=>$id),
						'fields' => array('MenuitemMaster.id')
					)
				);
				
		foreach($data as $child){
			$this->MenuitemMaster->id=$child['MenuitemMaster']['id'];
			$svData['MenuitemMaster']['parent_id'] = 0;
			$this->MenuitemMaster->save($svData);
		}
		
		$deleteArr = $this->MenuitemMaster->delete($id);
		
		if($deleteArr){
			$this->Session->setFlash('Record deleted successfully', 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('Failed to delete record', 'default', array('class' => 'alert alert-danger'));
		}
		
		$this->redirect($this->referer());
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
			
				$arr = array_keys($this->MenuitemMaster->schema());
				unset($arr[0]);
				$this->MenuMaster->bindModel(
					array(
						'hasMany'=>array(
							'MenuitemMaster'=>array(
								'className'=>'MenuitemMaster',
								'foreignKey'=>'menu_id',
								'fields'=>$arr
							)
						)
					)
				);
				
				
				$orgWidget = $this->MenuMaster->findById($data['widgetId']);
				unset($orgWidget['MenuMaster']['id']);
				$slugArr = array('Model'=>'MenuMaster','field'=>'menu_slug');
				$orgWidget['MenuMaster']['menu_slug'] = AppController::get_slug($orgWidget['MenuMaster']['menu_name'],$slugArr);
				$orgWidget['MenuMaster']['menu_type'] = 'D';
				
				$this->MenuMaster->create();
				$fl = $this->MenuMaster->save($orgWidget);
				$newId = $this->MenuMaster->id;
				
				if(!empty($newId)){
					if(!empty($orgWidget['MenuitemMaster'])){
						foreach($orgWidget['MenuitemMaster'] as $widgetItem){
							$saveData['MenuitemMaster'] = $widgetItem;
							$saveData['MenuitemMaster']['menu_id'] = $newId;
							
							$this->MenuitemMaster->create();
							$this->MenuitemMaster->save($saveData);
						}
					}
					
					$shortcode = $this->Shortcode->findByGroupIdAndWidgetId(29, $data['widgetId']);
					if(!empty($shortcode)){
						$shortcode['Shortcode']['widget_id'] = $newId;
						unset($shortcode['Shortcode']['id']);
						$this->Shortcode->create();
						$this->Shortcode->save($shortcode);
					}
					
					if(!empty($data['colId'])){
						if(empty($footer))
						{
						$this->PageTemplateRowsColumn->id = $data['colId'];
						$tpldata['PageTemplateRowsColumn']['shortcode'] = '[Menu-'.$newId.']';
						$tpldata['PageTemplateRowsColumn']['clone_flag'] = 'Y';
						
						$this->PageTemplateRowsColumn->save($tpldata);
						}else {
						$this->FooterColumn->id = $data['colId'];
						$tpldata['FooterColumn']['shortcode'] = '[Menu-'.$newId.']';
						
						
						$this->FooterColumn->save($tpldata);
						
						}
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
	
	public function admin_delete($id=NULL){
		if($id!=NULL){
			$this->loadModel('MenuitemMaster');
			$deleteFlag = false;
			$itemdelete = $this->MenuitemMaster->deleteAll(array('MenuitemMaster.menu_id'=>$id),false);
			
			if($itemdelete){
				$deleteFlag = $this->MenuMaster->delete($id);
			}
			
			if($deleteFlag){
				$this->Session->setFlash('Record deleted successfully', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete record', 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$this->Session->setFlash('There is no id!', 'default', array('class' => 'alert alert-danger'));
		}
		$this->redirect($this->referer());
	}
	
	public function admin_menuedit(){
		$this->layout = 'ajax';
		
		$id = $this->request->data['menu_id'];
		$menuData = $this->MenuMaster->findById($id);
		
		$this->set('menuData',$menuData);
	}
	
	public function admin_updatemenu($id=NULL){
		
		if($this->request->is('post')){
			$data = $this->request->data;
			$this->MenuMaster->id = $id;
			
			$saveFlag = $this->MenuMaster->save($data);
			$saveId = $this->MenuMaster->id;
			if($saveFlag){
				$checkData = $this->Shortcode->find('count',array(
						'conditions'=>array(
							'Shortcode.name'=>'Menu',
							'Shortcode.id'=>$saveId
						)
					)
				);
				
				if($checkData == 0){
					$styleData = $this->Style->findByGroupId(29);
					//pr($styleData); exit();
					$savedata['Shortcode']['controller'] 	= 'MenuMasters';
					$savedata['Shortcode']['action']		= 'manage';
					$savedata['Shortcode']['widget_id'] 	= $saveId;
					$savedata['Shortcode']['name'] 			= 'Menu';
					$savedata['Shortcode']['widget_title'] 	= $data['MenuMaster']['menu_name'];
					$savedata['Shortcode']['group_id'] 		= 29;
					$savedata['Shortcode']['style_id'] 		= $styleData['Style']['id'];
					$this->Shortcode->create();
					
					$this->Shortcode->save($savedata);
				}
				
				
				$this->Session->setFlash('Menu updated successfully!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to update menu', 'default', array('class' => 'alert alert-danger'));
			}
			
			$this->redirect(array('controller'=>'MenuMasters', 'action'=>'admin_index'));
		}
	}
	
	public function admin_itemedit(){
		$this->layout = 'ajax';
		$this->loadModel('MenuitemMaster');
		
		$id = $this->request->data['item_id'];
		$itemData = $this->MenuitemMaster->findById($id);
		
		$this->set('itemData',$itemData);
	}
	
	public function admin_updateitem($id=NULL,$menu_id = NULL){
		$this->loadModel('MenuitemMaster');
		if($this->request->is('post')){
			$data = $this->request->data;
			$this->MenuitemMaster->id = $id;
			$saveFlag = $this->MenuitemMaster->save($data);
			if($saveFlag){
				$this->Session->setFlash('Item updated successfully!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to update item', 'default', array('class' => 'alert alert-danger'));
			}
			
			$this->redirect(array('controller'=>'MenuMasters', 'action'=>'admin_manage/'.$menu_id));
		}
	}
	
	public function admin_deleteAll($idAll=NULL)
	{	
		//pr($id); exit();
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$this->loadModel('MenuitemMaster');
			$deleteFlag = false;
			$itemdelete = $this->MenuitemMaster->deleteAll(array('MenuitemMaster.menu_id'=>$id),false);
			
			if($itemdelete){
				$deleteFlag = $this->MenuMaster->delete($id);
			}
			
			if($deleteFlag){
				$this->Session->setFlash('The menu has been successfully removed!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete the menu!', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	public function admin_icon()
	{
		$this->layout = 'ajax';
	}
}
?>