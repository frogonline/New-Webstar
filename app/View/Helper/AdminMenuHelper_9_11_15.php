<?php
class AdminMenuHelper extends AppHelper {
	var $helpers = array('Cache','Html','Session','Form','Paginator');
	public function adminMenu($currentUrl){
		
		$arr = $this->menu_array();
		$readyMademenu = $this->create_admin_menu($arr, $currentUrl);
		return $readyMademenu;
	}
	
	private function create_admin_menu($menu_array, $currentUrl, $c=0){
		$user = AuthComponent::user();
		
		$str = '';
		
		if($c == 0){
			$str.='<ul class="page-sidebar-menu" data-auto-scroll="false" data-auto-speed="200">';
			$str.='<li class="sidebar-toggler-wrapper">';
			$str.='<div class="sidebar-toggler"></div>';
			$str.='</li>';
		} else {
			$str.='<ul class="sub-menu">';
		}
		
		$extraArr = array('admin_manage');
		
		foreach($menu_array as $item){
			if(array_key_exists('child', $item['Menu'])){
				$url = 'javascript:void(0);';
				
				if(array_key_exists('childControllers',$item['Menu'])){
					if($c == 0){
						//pr($item['Menu']['childControllers']);
						if(in_array($currentUrl['controller'],$item['Menu']['childControllers']) && in_array($currentUrl['action'],$item['Menu']['childActions'])){
							$label = '<i class="'.$item['Menu']['class'].'"></i><span class="title">'.$item['Menu']['label'].'</span><span class="selected"></span><span class="arrow open"></span>';
							$str.='<li class="active open">';
						} else {
							$label = '<i class="'.$item['Menu']['class'].'"></i><span class="title">'.$item['Menu']['label'].'</span><span class="arrow"></span>';
							$str.='<li>';
						}
					} else {
						if(in_array($currentUrl['controller'],$item['Menu']['childControllers']) && in_array($currentUrl['action'],$item['Menu']['childActions'])){
							$label = '<i class="'.$item['Menu']['class'].'"></i><span class="title">'.$item['Menu']['label'].'</span><span class="selected"></span><span class="arrow open"></span>';
							$str.='<li class="active open">';
						} else {
							$label = '<i class="'.$item['Menu']['class'].'"></i><span class="title">'.$item['Menu']['label'].'</span><span class="arrow"></span>';
							$str.='<li>';
						}
					}
				} else {
					if($c == 0){
						if(($currentUrl['controller']==strtolower($item['Menu']['controller'])) && ($currentUrl['action']==$item['Menu']['action'])){
							$label = '<i class="fa fa-home"></i><span class="title">'.$item['Menu']['label'].'</span><span class="selected"></span>';
							$str.='<li class="active">';
						} else {
							$label = '<i class="fa fa-home"></i><span class="title">'.$item['Menu']['label'].'</span>';
							$str.='<li>';
						}
					} else {
						if(($currentUrl['controller']==strtolower($item['Menu']['controller'])) && ($currentUrl['action']==$item['Menu']['action'])){
							$label = '<i class="'.$item['Menu']['class'].'"></i><span class="title">'.$item['Menu']['label'].'</span><span class="arrow open"></span>';
							$str.='<li class="active">';
						} else {
							$label = '<i class="'.$item['Menu']['class'].'"></i><span class="title">'.$item['Menu']['label'].'</span><span class="arrow"></span>';
							$str.='<li>';
						}
					}
				}	
			} else {
				$url = array('controller'=>$item['Menu']['controller'], 'action'=>$item['Menu']['action']);
				
				if($c == 0){
					array_push($extraArr, $item['Menu']['action']);
					if(($currentUrl['controller']==strtolower($item['Menu']['controller'])) && (in_array($currentUrl['action'],$extraArr) ) ){
						$label = '<i class="'.$item['Menu']['class'].'"></i><span class="title '.$currentUrl['controller'].'">'.$item['Menu']['label'].'</span><span class="selected"></span>';
						$str.='<li class="active">';
					} else {
						$label = '<i class="'.$item['Menu']['class'].'"></i><span class="title '.$item['Menu']['controller'].'">'.$item['Menu']['label'].'</span>';
						$str.='<li>';
					}
					array_pop($extraArr);
				} else {
					array_push($extraArr, $item['Menu']['action']);
					if(($currentUrl['controller']==strtolower($item['Menu']['controller'])) && (in_array($currentUrl['action'],$extraArr) )){
						$label = '<i class="'.$item['Menu']['class'].'"></i><span class="title '.$item['Menu']['controller'].'">'.$item['Menu']['label'].'</span>';
						$str.='<li class="active">';
					} else {
						$label = '<i class="'.$item['Menu']['class'].'"></i><span class="title '.$item['Menu']['controller'].'">'.$item['Menu']['label'].'</span>';
						$str.='<li>';
					}
					array_pop($extraArr);
				}
			}
			
			$permissionArr = $this->getPermissionModule($user['user_id'], $item['Menu']['id']);
			
			if(!empty($permissionArr)){
				if($permissionArr['UserPermission']['view']=='Y'){
					$str.=$this->Html->link($label,
						$url,
						array('full_base'=>true, 'escape'=>false)
					);
					
					if(array_key_exists('child', $item['Menu'])){
						$c++;
						$str.=$this->create_admin_menu($item['Menu']['child'], $currentUrl, $c);
						$c--;
					}
					
					$str.='</li>';
				}
			}
			
		}
		$str.='</ul>';
		
		return $str;
	}
	
	
	public function menu_array($pid = 0){
		
		App::import('Model', 'Menu');
        $item = new Menu();
        $data = $item->find('all',
			array(
				'conditions' => array(
					'Menu.is_active'=>'Y',
					'Menu.menu_id'=>$pid
					),
				'order' => array('Menu.order')
			)
		);
		
		$i = 0;
		foreach($data as $single){
			
			$n = $item->find('count',
					array(
						'conditions' => array(
							'Menu.is_active'=>'Y',
							'Menu.menu_id'=>$single['Menu']['id']
							),
						'order' => array('Menu.order')
					)
				);
			if($n > 0){
				$childElement = $this->getAllChildControllers($single['Menu']['id']);
				$data[$i]['Menu']['childControllers'] = $childElement['childControllers'];
				$data[$i]['Menu']['childActions'] = $childElement['childActions'];
				$data[$i]['Menu']['child'] = $this->menu_array($single['Menu']['id']);
				
			}
			$i++;
		}
		
		return $data;
	}
	
	private function getAllChildControllers($id){
		$controllersArr = array();
		$controllersArr['childControllers'] = array();
		$controllersArr['childActions'] = array('admin_manage');
		
		App::import('Model', 'Menu');
        $item = new Menu();
		
		$cntrlrs = $item->find('all',
					array(
						'conditions' => array(
							'Menu.menu_id'=>$id,
							'Menu.is_active'=>'Y'
							),
						'fields'=>'Menu.controller, Menu.action',
						'order' => array('Menu.order')
					)
				);
		
		foreach($cntrlrs as $cntrlr){
			array_unshift($controllersArr['childControllers'], strtolower($cntrlr['Menu']['controller']));
			array_unshift($controllersArr['childActions'], strtolower($cntrlr['Menu']['action']));
		}
		
		$chaildidArr =  $item->find('list', array(
								'conditions' => array(
									'Menu.menu_id'=>$id
								),
								'fields'=>array('Menu.id', 'Menu.id')
							)
						);
		if(!empty($chaildidArr)){
			if(count($chaildidArr)==1){
				foreach($chaildidArr as $k=>$v){
					$cntrlrs = $item->find('all',
							array(
								'conditions' => array(
									'Menu.menu_id'=>$v,
									'Menu.is_active'=>'Y'
									),
								'fields'=>'Menu.controller, Menu.action',
								'order' => array('Menu.order')
							)
						);
				}
			} else {
				$cntrlrs = $item->find('all',
						array(
							'conditions' => array(
								'Menu.menu_id IN'=>$chaildidArr,
								'Menu.is_active'=>'Y'
								),
							'fields'=>'Menu.controller, Menu.action',
							'order' => array('Menu.order')
						)
					);
			}
			foreach($cntrlrs as $cntrlr){
				array_unshift($controllersArr['childControllers'], strtolower($cntrlr['Menu']['controller']));
				array_unshift($controllersArr['childActions'], strtolower($cntrlr['Menu']['action']));
			}
		}
		
		return $controllersArr;
	}
	
	public function getModuleTitle($controller, $action){
		App::import('Model', 'Menu');
        $menu = new Menu();
		
		$manage_ctpArr = array('admin_manage'=>'Manage', 'admin_setting'=>'Setting');
		$manage_ctpKeyArr = array_keys($manage_ctpArr);
		$action = (in_array($action,$manage_ctpKeyArr))?'admin_index':$action;
		$data = $menu->findByControllerAndAction($controller,$action);
		//return $action;
		$titleArr = array();
		if(!empty($data)){
			array_unshift($titleArr,$data['Menu']['title']);
			
			if($data['Menu']['menu_id'] != 0){
				while($data['Menu']['menu_id'] != 0){
					$data = $menu->findById($data['Menu']['menu_id']);
					array_unshift($titleArr,$data['Menu']['title']);
				}
			}
		}
		
		return $titleArr;
	}
	
	
	/***** Access Control Permission CheckBoxes *****/
	public function accessFields($userid = NULL){
		
		$arr = $this->menu_array();
		$readyMademenu = $this->create_access_fields($arr, $userid);
		return $readyMademenu;
	}
	
	public function getPermissionModule($user_id, $module_id){
		App::import('Model', 'UserPermission');
        $UserPermission = new UserPermission();
		
		if(!empty($user_id)){
			$dataRaw = $UserPermission->findByUserIdAndModuleId($user_id,$module_id);
			return $dataRaw;
		} else {
			return NULL;
		}
	}
	
	private function create_access_fields($menu_array, $user_id, $c=0){
		$str = '';
	
		foreach($menu_array as $item){
		
				
			$dataPermission = $this->getPermissionModule($user_id, $item['Menu']['id']);
			//pr($dataPermission);
			if(array_key_exists('child', $item['Menu'])){
				
				$str .= $this->Form->input('UserPermission.id',array("type"=>"hidden","label"=>false,"value"=>(!empty($dataPermission))?$dataPermission['UserPermission']['id']:'', 'name'=>'data[UserPermission]['.$item['Menu']['id'].'][id]',)); 
							
				$str .= $this->Form->input('UserPermission.module_id',array("type"=>"hidden", "class"=>"permimodel","label"=>false,"value"=>$item['Menu']['id'], 'name'=>'data[UserPermission]['.$item['Menu']['id'].'][module_id]',));
				
				$str.=	'<div class="form-group">
							<div class="col-md-4">
								<label class="control-label"><strong>'.$item['Menu']['label'].'</strong></label>
							</div>
							<div class="col-md-2">
								<div class="input-group">'.
								$this->Form->input('UserPermission.view', array(
										'type'=>'checkbox',
										'class'=>'checkBoxClass viewbox maindiv',								  
										'label'=>'View',
										'id'=>'view'.$item['Menu']['id'],
										'data-parentid'=>'#view'.$item['Menu']['menu_id'],
										'nes'=>$item['Menu']['id'],
										'name'=>'data[UserPermission]['.$item['Menu']['id'].'][view]',
										'value' => 'Y',
										'hiddenField' => 'N',
										'checked'=>(!empty($dataPermission))?($dataPermission['UserPermission']['view']=='Y')?'checked':'':''
									)
								).
								'</div>
							</div>
						</div>';
						$displayvar=($dataPermission['UserPermission']['id']!='')?'block':'none';
						$str.='<div class="form-group">
						
							<div class="col-md-1 chealldiv'.$item['Menu']['id'].'" style="display:'.$displayvar.'">
								<div class="input-group">
									<div>
										<a class="btn default btn-xs purple forcheckclass" "df"='.$item['Menu']['id'].' id="allcheck'.$item['Menu']['id'].'" onclick="checkuncheck1('.$item['Menu']['id'].')">Check All</a>
									</div>
								</div>
							</div>
							<div class="col-md-1 unchealldiv'.$item['Menu']['id'].'" style="display:'.$displayvar.'">
								<div class="input-group">
									<div>
										<a class="btn default btn-xs purple foruncheckclass" id="allcheck1'.$item['Menu']['id'].'" onclick="checkuncheck11('.$item['Menu']['id'].')">Uncheck All</a>
									</div>
								</div>
							</div>
						</div>';	
				$str.=	$this->create_access_fields($item['Menu']['child'], $user_id, $c);
					
			} else {
				$str .= $this->Form->input('UserPermission.id',array("type"=>"hidden","label"=>false,"value"=>(!empty($dataPermission))?$dataPermission['UserPermission']['id']:'', 'name'=>'data[UserPermission]['.$item['Menu']['id'].'][id]')); 
							
				$str .= $this->Form->input('UserPermission.module_id',array("type"=>"hidden","label"=>false,"value"=>$item['Menu']['id'], 'name'=>'data[UserPermission]['.$item['Menu']['id'].'][module_id]'));
				
			
				
				
				if($item['Menu']['action']=='admin_dashboard'){
					
				$str.= $this->Form->input('UserPermission.view',array("type"=>"hidden","label"=>false,"value"=>'Y', 'name'=>'data[UserPermission]['.$item['Menu']['id'].'][view]'));
				$str.= $this->Form->input('UserPermission.add',array("type"=>"hidden","label"=>false,"value"=>'Y', 'name'=>'data[UserPermission]['.$item['Menu']['id'].'][add]'));
				$str.= $this->Form->input('UserPermission.edit',array("type"=>"hidden","label"=>false,"value"=>'Y', 'name'=>'data[UserPermission]['.$item['Menu']['id'].'][edit]'));
				$str.= $this->Form->input('UserPermission.delete',array("type"=>"hidden","label"=>false,"value"=>'Y', 'name'=>'data[UserPermission]['.$item['Menu']['id'].'][delete]'));
				}
				else if($item['Menu']['menu_id']==0 && $item['Menu']['controller']!='' && $item['Menu']['action']!='admin_dashboard'){
				
				$str.=	'<div class="form-group divshow'.$item['Menu']['menu_id'].'" >
							<div class="col-md-4">
								<label class="control-label"><strong>'.$item['Menu']['label'].'</strong></label>
							</div>
							<div class="col-md-2">
								<div class="input-group">'.
								$this->Form->input('UserPermission.view', array(
										'type'=>'checkbox',
										'class'=>'checkBoxClass viewbox permode'.$item['Menu']['menu_id'].'',								  
										'label'=>'View',
										'id'=>'view'.$item['Menu']['id'],
										'data-parentid'=>'#view'.$item['Menu']['menu_id'],
										'name'=>'data[UserPermission]['.$item['Menu']['id'].'][view]',
										'value' => 'Y',
										'hiddenField' => 'N',
										'checked'=>(!empty($dataPermission))?($dataPermission['UserPermission']['view']=='Y')?'checked':'':''
									)
								).
								'</div>
							</div>';
						
					$str.=	'<div class="col-md-2">
								<div class="input-group">'.
								$this->Form->input('UserPermission.add', array(
										'type'=>'checkbox',
										'class'=>'checkBoxClass addbox permode'.$item['Menu']['menu_id'].'',								  
										'name'=>'data[UserPermission]['.$item['Menu']['id'].'][add]',
										'label'=>'Add',
										'data-id'=>'#view'.$item['Menu']['id'],
										'edit-id'=>'#edit'.$item['Menu']['id'],
										'delete-id'=>'#delete'.$item['Menu']['id'],
										'id'=>'add'.$item['Menu']['id'],
										'data-parentid'=>'#view'.$item['Menu']['menu_id'],
										'value' => 'Y',
										'hiddenField' => 'N',
										'checked'=>(!empty($dataPermission))?($dataPermission['UserPermission']['add']=='Y')?'checked':'':''
									)
								).
								'</div>
							</div>';
							
					$str.=	'<div class="col-md-2">
								<div class="input-group">'.
								$this->Form->input('UserPermission.edit', array(
										'type'=>'checkbox',
										'class'=>'checkBoxClass editbox permode'.$item['Menu']['menu_id'].'',								  
										'name'=>'data[UserPermission]['.$item['Menu']['id'].'][edit]',
										'label'=>'Edit',
										'data-id'=>'#view'.$item['Menu']['id'],
										'add-id'=>'#add'.$item['Menu']['id'],
										'delete-id'=>'#delete'.$item['Menu']['id'],
										'id'=>'edit'.$item['Menu']['id'],
										'data-parentid'=>'#view'.$item['Menu']['menu_id'],
										'value' => 'Y',
										'hiddenField' => 'N',
										'checked'=>(!empty($dataPermission))?($dataPermission['UserPermission']['edit']=='Y')?'checked':'':''
									) 
								).
								'</div>
							</div>';
							
					$str.=	'<div class="col-md-2">
								<div class="input-group">'.
								$this->Form->input('UserPermission.delete', array(
										'type'=>'checkbox',
										'class'=>'checkBoxClass deletebox permode'.$item['Menu']['menu_id'].'',								  
										'name'=>'data[UserPermission]['.$item['Menu']['id'].'][delete]',
										'label'=>'Delete',
										'data-id'=>'#view'.$item['Menu']['id'],
										'add-id'=>'#add'.$item['Menu']['id'],
										'edit-id'=>'#edit'.$item['Menu']['id'],
										'id'=>'delete'.$item['Menu']['id'],
										'data-parentid'=>'#view'.$item['Menu']['menu_id'],
										'value' => 'Y',
										'hiddenField' => 'N',
										'checked'=>(!empty($dataPermission))?($dataPermission['UserPermission']['delete']=='Y')?'checked':'':''
									) 
								).
								'</div>
							</div>
						</div><br/>';
				
				}
				else {
				
				//$displayvar=($dataPermission['UserPermission']['id']!='')?'block':'none';
				$displayvar=(!empty($dataPermission))?($dataPermission['UserPermission']['id']!='')?'block':'none':'none';
				$str.=	'<div class="form-group divshow'.$item['Menu']['menu_id'].'" style="display:'.$displayvar.';">
							<div class="col-md-4">
								<label class="control-label">'.$item['Menu']['label'].'</label>
							</div>
							<div class="col-md-2">
								<div class="input-group">'.
								$this->Form->input('UserPermission.view', array(
										'type'=>'checkbox',
										'class'=>'checkBoxClass viewbox permode'.$item['Menu']['menu_id'].'',								  
										'label'=>'View',
										'id'=>'view'.$item['Menu']['id'],
										'data-parentid'=>'#view'.$item['Menu']['menu_id'],
										'name'=>'data[UserPermission]['.$item['Menu']['id'].'][view]',
										'value' => 'Y',
										'hiddenField' => 'N',
										'checked'=>(!empty($dataPermission))?($dataPermission['UserPermission']['view']=='Y')?'checked':'':''
									)
								).
								'</div>
							</div>';
						
					$str.=	'<div class="col-md-2">
								<div class="input-group">'.
								$this->Form->input('UserPermission.add', array(
										'type'=>'checkbox',
										'class'=>'checkBoxClass addbox permode'.$item['Menu']['menu_id'].'',								  
										'name'=>'data[UserPermission]['.$item['Menu']['id'].'][add]',
										'label'=>'Add',
										'data-id'=>'#view'.$item['Menu']['id'],
										'edit-id'=>'#edit'.$item['Menu']['id'],
										'delete-id'=>'#delete'.$item['Menu']['id'],
										'id'=>'add'.$item['Menu']['id'],
										'data-parentid'=>'#view'.$item['Menu']['menu_id'],
										'value' => 'Y',
										'hiddenField' => 'N',
										'checked'=>(!empty($dataPermission))?($dataPermission['UserPermission']['add']=='Y')?'checked':'':''
									)
								).
								'</div>
							</div>';
							
					$str.=	'<div class="col-md-2">
								<div class="input-group">'.
								$this->Form->input('UserPermission.edit', array(
										'type'=>'checkbox',
										'class'=>'checkBoxClass editbox permode'.$item['Menu']['menu_id'].'',								  
										'name'=>'data[UserPermission]['.$item['Menu']['id'].'][edit]',
										'label'=>'Edit',
										'data-id'=>'#view'.$item['Menu']['id'],
										'add-id'=>'#add'.$item['Menu']['id'],
										'delete-id'=>'#delete'.$item['Menu']['id'],
										'id'=>'edit'.$item['Menu']['id'],
										'data-parentid'=>'#view'.$item['Menu']['menu_id'],
										'value' => 'Y',
										'hiddenField' => 'N',
										'checked'=>(!empty($dataPermission))?($dataPermission['UserPermission']['edit']=='Y')?'checked':'':''
									) 
								).
								'</div>
							</div>';
							
					$str.=	'<div class="col-md-2">
								<div class="input-group">'.
								$this->Form->input('UserPermission.delete', array(
										'type'=>'checkbox',
										'class'=>'checkBoxClass deletebox permode'.$item['Menu']['menu_id'].'',								  
										'name'=>'data[UserPermission]['.$item['Menu']['id'].'][delete]',
										'label'=>'Delete',
										'data-id'=>'#view'.$item['Menu']['id'],
										'add-id'=>'#add'.$item['Menu']['id'],
										'edit-id'=>'#edit'.$item['Menu']['id'],
										'id'=>'delete'.$item['Menu']['id'],
										'data-parentid'=>'#view'.$item['Menu']['menu_id'],
										'value' => 'Y',
										'hiddenField' => 'N',
										'checked'=>(!empty($dataPermission))?($dataPermission['UserPermission']['delete']=='Y')?'checked':'':''
									) 
								).
								'</div>
							</div>
						</div>';
				}
			}
			
		}
		return $str;
	}
	
}
