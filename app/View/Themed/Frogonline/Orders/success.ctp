<?php
$ThemeSetting=$this->Session->read('ThemeSetting');
$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
echo $this->Layout->pagecrumb('order', 'Success');
?>
<div class="container">
	
	<div class="row margin-bottom-40">
		<!-- BEGIN CONTENT -->
		<?php if($ThemeSettingheadertype=='V'){ ?>
		<div class="col-md-3 col-sm-12">
		<?php
			App::import('Model','MenuMaster');
			$menumaster_model = new MenuMaster();
			$menuData = $menumaster_model->findById(12);
			if(!empty($menuData)){
			
			$default = array(
							'menu_slug' => $menuData['MenuMaster']['menu_slug'],
							'container_div' => true,
							'container_class' => 'vtl-navigation',
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
		</div>
		<?php }?>
		
		<?php if($ThemeSettingheadertype=='V'){ ?>
		<div class="col-md-9 col-sm-12">
		<?php }else{ ?>
		<div class="col-md-12 col-sm-12">
		<?php } ?>
			<?php echo $this->Session->flash('register'); ?>
			<?php echo $this->Session->flash('order'); ?>
		</div>
		<!-- END CONTENT -->
	</div>
</div>


