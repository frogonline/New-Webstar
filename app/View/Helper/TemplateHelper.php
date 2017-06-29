<?php
class TemplateHelper extends AppHelper {
	var $helpers = array('Cache','Html','Session','Form','Paginator');
	
	public function getTotalCol($arr){
		$total = 0;
		if(!empty($arr)){
			foreach($arr as $item){
				$total += (int)$item['column'];
			}
		}
		return $total;
	}
		
	public function shortcodelink($shortcode, $class='') {
        App::import('Model', 'Shortcode');
		$Shortcode = new Shortcode();
		
		$shortcode = trim($shortcode, '[');
		$shortcode = trim($shortcode, ']');
		
		$shortcode_arr = explode("-",$shortcode);
		$str = '';
		
		if(count($shortcode_arr)==2){
			$data_shortcode = $Shortcode->findByWidgetIdAndName($shortcode_arr[1],$shortcode_arr[0]);
			if(!empty($data_shortcode)){
				$str .= $this->Html->link('<i class="fa fa-pencil-square"></i>', array('controller'=>$data_shortcode['Shortcode']['controller'], 'action'=>$data_shortcode['Shortcode']['action'].'/'.$data_shortcode['Shortcode']['widget_id'], 'full_base'=>true), array('escape'=>false, 'class'=>$class, 'target'=>'_blank'));
			}
		}
		return $str;
    }
	
	public function generateChildColArr($parent_id = NULL){
		App::import('Model', 'PageTemplateRowsColumn');
		$ptlchildcolobj = new PageTemplateRowsColumn();
		
		if($parent_id!=NULL){
			$childcolArr = $ptlchildcolobj->find('all', array(
					'conditions'=>array(
						'PageTemplateRowsColumn.parent_colid'=>$parent_id
					),
					'order'=>'PageTemplateRowsColumn.sort_order ASC'
				)
			);
		} else {
			$childcolArr = array();
		}
		
		return $childcolArr;
	}
	
	public function cloneLink($shortcode,$tplId, $colId,$parent_colid=null){
	//echo $shortcode;
		App::import('Model', 'Shortcode');
		$shortcodeObj = new Shortcode();

		App::import('Model', 'PageTemplate');
		$pagetempobj = new PageTemplate();
		
		$linkStr = '';
		
		if(!empty($shortcode) && !empty($tplId) && !empty($colId)){
			$code = trim($shortcode, '[');
			$code = trim($code, ']');
			
			$widget = explode('-', $code);
			if(count($widget)==2){

				$tempinfo = $pagetempobj->findById($tplId);

				$codeArr = $shortcodeObj->findByNameAndWidgetId($widget[0],$widget[1]);
				if($codeArr['Shortcode']['widget_id']!=0){
					$linkStr = $this->Html->link('<i class="fa fa-copy"></i>', 'javascript:void(0);',
						array(
							'escape'=>false,
							'class'=>'cloneWidget',
							'data-colid'=>$colId,
							'data-templateid'=>$tplId,
							'data-templateid'=>$tplId,
							'parent_colid'=>$parent_colid,
							
							'data-widgetId'=>$codeArr['Shortcode']['widget_id'],
							'data-url'=>$this->Html->url(array('controller'=>$codeArr['Shortcode']['controller'], 'action'=>'admin_ajaxcopyitem', 'full_base'=>true)),
							'data-ajaxtplpreview'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true)),
							'data-ajaxtpldrpdwnurl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_pgtpldrpdown', 'full_base'=>true)),
							'data-tmpsubmiturl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_saveastplsubmit', 'full_base'=>true)),
							'data-tmpsidebar'=>$tempinfo['PageTemplate']['with_sidebar'] 

						)
					);
				}
			}
			
		}
		return $linkStr;
	}
	
	public function shortcode($shortcode, $cloneFlag, $tplId, $colId,$parent_colid=null){

		$code = trim($shortcode, '[');
		$code = trim($code, ']');
		$widget = explode('-', $code);
		$str = '';
		$userArr = AuthComponent::user();
		$excludeWidgetArr = array('Divider','Form');
		
		if($widget[0] != "Sidebar"){
			$str .= '<center>';
			$str .= '<div class="col-md-8 shotc'.$colId.'">';
			$str .= $shortcode;
			$str .= '</div>';
			$str .= '<div class="col-md-2">';
			
			$str .= $this->shortcodelink($shortcode);
			
			$str .= '</div>';
			$str .= '<div class="col-md-2">';
			
			if(!in_array($widget[0], $excludeWidgetArr)){
				$str .= $this->cloneLink($shortcode, $tplId, $colId,$parent_colid);
			}
			
			$str .= '</div>';
			$str .= '</center>';
		} else {
			$str = $this->sidebarOption($widget[1]);
			
			if($userArr['user_type']=='super'){
				$str .= '<div class="pull-right">'.$this->shortcodelink($shortcode).'</div>';
			}
		}
		return $str;
	}
	
	public function sidebarOption($id){
		App::import('Model', 'SidebarOption');
		$sidebaroptionObj = new SidebarOption();
		
		$optionsArr = $sidebaroptionObj->find('all', array(
				'conditions'=>array(
					'SidebarOption.sidebar_id'=>$id
				),
				'order'=>array(
					'SidebarOption.sort_order ASC'
				)
			)
		);
		
		
		$str = '';
		$str .= '<div class="dd" id="nestable">';
		
		if(!empty($optionsArr)){
			$str .= '<ol class="dd-list">';
			foreach($optionsArr as $option){
				$str .= '<li class="dd-item" data-id="'.$option['SidebarOption']['id'].'">
					<div class="dd-handle">'.$option['SidebarOption']['widget_shortcode'].'</div>';
				$str .= $this->shortcodelink($option['SidebarOption']['widget_shortcode'],'sidebar_item_edit');
				$str .= '</li>';
			}
			$str .= '</ol>'; 
		}
		
		$str .= '</div>';
		$str .= $this->Form->input('sidebar_id',array("type"=>"hidden", "value"=>$id));
		$str .= $this->Form->input('change_count',array("type"=>"hidden", 'id'=>'change_count', "label"=>false,"value"=> 0));
		$str .= $this->Form->input('Save Menu',array("type"=>"button", 'id'=>'sidebar_item_save', 'class'=>'btn btn-xs blue', 'div'=>false, 'label'=>false));
		
		
		return $str;
	}		public function cloneLinkfoot($shortcode, $tplId, $colId){		App::import('Model', 'Shortcode');		$shortcodeObj = new Shortcode();				$linkStr = '';				if(!empty($shortcode) && !empty($tplId) && !empty($colId)){			$code = trim($shortcode, '[');			$code = trim($code, ']');						$widget = explode('-', $code);			if(count($widget)==2){				$codeArr = $shortcodeObj->findByNameAndWidgetId($widget[0],$widget[1]);				if($codeArr['Shortcode']['widget_id']!=0){					$linkStr = $this->Html->link('<i class="fa fa-copy"></i>', 'javascript:void(0);',						array(							'escape'=>false,							'class'=>'cloneWidget',							'data-colid'=>$colId,							'data-templateid'=>$tplId,							'data-widgetId'=>$codeArr['Shortcode']['widget_id'],							'data-url'=>$this->Html->url(array('controller'=>$codeArr['Shortcode']['controller'], 'action'=>'admin_ajaxcopyitem/1', 'full_base'=>true)),							'data-ajaxtplpreview'=>$this->Html->url(array('controller'=>'FooterRows', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true))						)					);				}			}					}		return $linkStr;	}		public function shortcodefot($shortcode, $cloneFlag, $tplId, $colId){		$code = trim($shortcode, '[');		$code = trim($code, ']');		$widget = explode('-', $code);		$str = '';		$userArr = AuthComponent::user();		$excludeWidgetArr = array('Divider');				if($widget[0] != "Sidebar"){			$str .= '<center>';			$str .= '<div class="col-md-7">';			$str .= $shortcode;			$str .= '</div>';			$str .= '<div class="col-md-2">';						$str .= $this->shortcodelink($shortcode);						$str .= '</div>';			$str .= '<div class="col-md-2">';						if(!in_array($widget[0], $excludeWidgetArr)){				$str .= $this->cloneLinkfoot($shortcode, $tplId, $colId);			}						$str .= '</div>';			$str .= '</center>';		} else {			$str = $this->sidebarOption($widget[1]);						if($userArr['user_type']=='super'){				$str .= '<div class="pull-right">'.$this->shortcodelink($shortcode).'</div>';			}		}		return $str;	}
}
?>