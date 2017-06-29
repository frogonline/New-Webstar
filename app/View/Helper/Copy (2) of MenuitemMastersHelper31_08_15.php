<?php
class MenuitemMastersHelper extends AppHelper {
	var $helpers = array('Cache','Html','Session','Form','Paginator');
	
	public function menu_name($slug){
		App::import('Model', 'MenuMaster');
		$menu = new MenuMaster();
		
		$m = $menu->findByMenuSlug($slug);
		if(!empty($m)){
			return $m['MenuMaster']['menu_name'];
		} else {
			return "";
		}
	}
	
	
	public function cp_menu($arr) {
        App::import('Model', 'MenuMaster');
		$menu = new MenuMaster();
		$m = $menu->findByMenuSlug($arr['menu_slug']);
		
		$menuKeyArr = array('menu_slug','mobile_menu','custom_header_layout','container_div','container_class','container_id','menu_class','menu_id','submenu_class','item_wrap','item_wrap_class','hasChildli_class','item_class','anchor_class','before_item','before_item_class','after_item','after_item_class');
		
		$iconicHeaderArr = array('custom-2','custom-3','custom-4');
		
		$requestKeyArr = array_keys($arr);
		$leftKey = array_diff($menuKeyArr, $requestKeyArr);
		
		if(!empty($leftKey)){
			foreach($leftKey as $k){
				$arr[$k]="";
			}
		}
		
		if(!empty($m)){
			$data = $this->menu_array($m['MenuMaster']['id']);
			if(!empty($arr['custom_header_layout'])){
				if(in_array($arr['custom_header_layout'],$iconicHeaderArr)){
					$str = $this->create_iconic_menu($data, $arr, 0);
				} else {
					$str = $this->create_menu($data, $arr, 0);
				}
			} else {
				$str = $this->create_menu($data, $arr, 0);
			}
			if($arr['container_div']){
				$str = '<div class="'.$arr['container_class'].'" id="'.$arr['container_id'].'">'.$str.'</div>';
			}
		} else {
			$str = "";
		}
		return $str;
    }
	
	public function cp_admin_menu($arr) {
        App::import('Model', 'MenuMaster');
		$menu = new MenuMaster();
		$m = $menu->findByMenuSlug($arr['menu_slug']);
		
        $data = $this->menu_array($m['MenuMaster']['id']);
		
		$str = $this->create_admin_menu($data, $arr);
		return $str;
    }
	
	private function menu_array($id, $pid = 0){
		
		App::import('Model', 'MenuitemMaster');
        $item = new MenuitemMaster();
        $data = $item->find('all',
			array(
				'conditions' => array(
					'MenuitemMaster.menu_id'=>$id,
					'MenuitemMaster.parent_id'=>$pid
					),
				'order' => array('MenuitemMaster.sort_order')
			)
		);
		
		$i = 0;
		foreach($data as $single){
			
			$n = $item->find('count',
					array(
						'conditions' => array(
							'MenuitemMaster.menu_id'=>$id,
							'MenuitemMaster.parent_id'=>$single['MenuitemMaster']['id']
							),
						'order' => array('MenuitemMaster.sort_order')
					)
				);
			
			$currentUrl = strtolower(trim('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], '/'));
			$chk = $item->find('count',
					array(
						'conditions' => array(
							'MenuitemMaster.menu_id'=>$id,
							'MenuitemMaster.parent_id'=>$single['MenuitemMaster']['id'],
							'MenuitemMaster.page_url'=>$currentUrl
							)
					)
				);
			if($chk > 0){
				$data[$i]['MenuitemMaster']['parent_active'] = true;
			}
			
			if($n > 0){
				$data[$i]['MenuitemMaster']['child'] = $this->menu_array($id,$single['MenuitemMaster']['id']);
			}
			$i++;
		}
		
		return $data;
	}
    
	private function create_admin_menu($data, $arr){
		
		$str = '';
				
		if(count($data) > 0){
			$str.='<ol class="'.$arr['menu_class'].'">';
			foreach($data as $item){
				$str.='<li class="dd-item" data-id="'.$item['MenuitemMaster']['id'].'">
				<div class="dd-handle">'.$item['MenuitemMaster']['page_title'].'</div>'.
				$this->Html->link('<i class="fa fa-edit"></i>', 
					'#responsive',
					array(
						'class' =>'purple item_edit',
						'escape' =>false,
						'data-id'=>$item['MenuitemMaster']['id'],
						'data-toggle'=>'modal'
					)
				).
				$this->Html->link('&times;', 
					array(
						'controller'=>'MenuMasters','action'=>'admin_item_delete/'.$item['MenuitemMaster']['id']
					),
					array(
						'class' =>'red item_delete',
						'escape' =>false,
						'confirm' => 'Are you sure you wish to delete this?'
					)
				);
				
				if(array_key_exists('child', $item['MenuitemMaster'])){
					$n=count($item);
					$str.=$this->create_admin_menu($item['MenuitemMaster']['child'], $arr);
				}
				else{
					$str.='</li>';
				}
				
			}
			$str.='</ol>'; 
			
		}

		return $str;
		
	}
	
	private function create_menu($data, $arr, $ent=0){
		
		$str = '';
				
		if(count($data) > 0){
			$str.=($ent==0)?'<ul class="'.$arr['menu_class'].'" id="'.$arr['menu_id'].'">':'<ul class="'.$arr['submenu_class'].'">';
			if(($arr['mobile_menu']=='yes') && $ent==0){
				$str.='<li class="main alt-bg-color">
					<button type="button" class="collapsed fa fa-times" data-toggle="collapse" data-target="#'.$arr['menu_id'].'"></button>
				</li>';
			}
			foreach($data as $item){
				$currentUrl = strtolower(trim('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], '/'));
				$itemurl = strtolower(trim($item['MenuitemMaster']['page_url'], '/'));
				
				if(array_key_exists('parent_active', $item['MenuitemMaster'])){
					$str.=(array_key_exists('child', $item['MenuitemMaster']))?'<li class="'.$arr['hasChildli_class'].' active">':'<li class="'.$arr['item_class'].' active">';
				} else {
					if($currentUrl == $itemurl) {
					$str.=(array_key_exists('child', $item['MenuitemMaster']))?'<li class="'.$arr['hasChildli_class'].' active">':'<li class="'.$arr['item_class'].' active">';
					} else {
						$str.=(array_key_exists('child', $item['MenuitemMaster']))?'<li class="'.$arr['hasChildli_class'].'">':'<li class="'.$arr['item_class'].'">';
					}
				}
				
				
				$str.='<a href="'.$item['MenuitemMaster']['page_url'].'">'.$this->Html->tag($arr['before_item'], '', array('class' => $arr['before_item_class'])).$this->Html->tag($arr['item_wrap'],$item['MenuitemMaster']['page_title'], array('class'=>$arr['item_wrap_class'])).$this->Html->tag($arr['after_item'], '', array('class' => $arr['after_item_class'])).'</a>';
				
				if(array_key_exists('child', $item['MenuitemMaster'])){
					$n=count($item);
					$ent++;
					$str.=$this->create_menu($item['MenuitemMaster']['child'], $arr, $ent);
					$ent--;
				}
				else{
					$str.='</li>';
				}
				
			}
			$str.='</ul>'; 
			
		}

		return $str;
		
	}
	
	private function create_iconic_menu($data, $arr, $ent=0){
		
		$str = '';
				
		if(count($data) > 0){
			$str.=($ent==0)?'<ul class="'.$arr['menu_class'].'" id="'.$arr['menu_id'].'">':'<ul class="'.$arr['submenu_class'].'">';
			foreach($data as $item){
				$currentUrl = strtolower(trim('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], '/'));
				$itemurl = strtolower(trim($item['MenuitemMaster']['page_url'], '/'));
				
				$str.=(array_key_exists('child', $item['MenuitemMaster']))?'<li class="'.$arr['hasChildli_class'].'">':'<li class="'.$arr['item_class'].'">';
				
				if($ent==0){
					$str.='<a href="'.$item['MenuitemMaster']['page_url'].'" class="v-al-container over"><div class="v-al">'.$this->Html->tag((!empty($item['MenuitemMaster']['class']))?'i':$arr['before_item'], '', array('class' => (!empty($item['MenuitemMaster']['class']))?'fa fa-'.$item['MenuitemMaster']['class']:$arr['before_item_class'])).$this->Html->tag($arr['item_wrap'],$item['MenuitemMaster']['page_title'], array('class'=>$arr['item_wrap_class'])).$this->Html->tag($arr['after_item'], '', array('class' => $arr['after_item_class'])).'</div></a>';
				} else {
					$str.='<a href="'.$item['MenuitemMaster']['page_url'].'">'.$this->Html->tag($arr['before_item'], '', array('class' => $arr['before_item_class'])).$this->Html->tag($arr['item_wrap'],$item['MenuitemMaster']['page_title'], array('class'=>$arr['item_wrap_class'])).$this->Html->tag($arr['after_item'], '', array('class' => $arr['after_item_class'])).'</a>';
				}
				
				if(array_key_exists('child', $item['MenuitemMaster'])){
					$n=count($item);
					$ent++;
					$str.=$this->create_menu($item['MenuitemMaster']['child'], $arr, $ent);
					$ent--;
				}
				else{
					$str.='</li>';
				}
				
			}
			$str.='</ul>'; 
			
		}

		return $str;
		
	}
	
}
?>