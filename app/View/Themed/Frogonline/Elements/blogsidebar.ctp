<?php 
$ThemeSetting=$this->Session->read('ThemeSetting');
$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
?>

<div class="blog sidebar col-md-3 main-el">
<?php if($ThemeSettingheadertype=='V'):	?>

<?php
					App::import('Model','MenuMaster');
					$menumaster_model = new MenuMaster();
					$menuData = $menumaster_model->findById(12);
				if(!empty($menuData)){
					
					$default = array(
									'menu_slug' => $menuData['MenuMaster']['menu_slug'],
									'container_div' => true,
									'container_class' => 'vtl-navigation hidden-xs hidden-sm',
									'container_id' => '',
									'menu_class' => 'list-group',
									'item_class' => 'list-group-item',
									'submenu_class' => '',
									'item_wrap' => '',
									'after_item' => '',
									'after_item_class' => '',
									'hasChildli_class' => 'list-group-item has-sub',
									'menu_id' => ''
								);
					$menu = $this->MenuitemMasters->cp_menu($default);
					echo $menu;
				}
				?>



<?php endif; ?>
	<?php
	$options = $this->SideBars->sidebarOptions(2);

	if(!empty($options)){
	
	
	
		foreach($options as $option){
			echo $this->ShortCode->make_content($option['SidebarOption']['widget_shortcode']);
		}
	}

	?>
</div>