<header class="head-2">
	
	<div class="logo hidden-sm hidden-xs">
		<div class="container">
			<?php 
			echo $this->Html->link(
				$this->Html->image(IMGPATH.'site_settings_logo/original/'.$siteSettings['SiteSetting']['logo'], array('alt'=>$siteSettings['SiteSetting']['meta_title'],'class'=>'img-responsive')),
				SITE_URL,
				array(
					'class'=>'logo-box center-block',
					'escape'=>false
				)
			);	
			?>
		</div>
	</div>
	

	<div class="container menu-bar headerbutton_backgound" role="navigation">
		
		<div class="large-header">
			<div class="navbar-header">
				<?php 
				echo $this->Html->link(
					$this->Html->image(IMGPATH.'site_settings_logo/original/'.$siteSettings['SiteSetting']['logo'], array('alt'=>$siteSettings['SiteSetting']['meta_title'],'class'=>'img-responsive')),
					SITE_URL,
					array(
						'class'=>'logo-box',
						'escape'=>false
					)
				);	
				?>
			</div>
			<?php 
			if(!empty($theme)){ 
				if($theme['ThemeSetting']['header_type']=='H'){
			?>
			<?php
				$menu_class = (!empty($theme))?'nav navbar-nav '.$theme['ThemeSetting']['header_menu_style']:'nav navbar-nav';
				$default = array(
								'menu_slug' => 'header-menu',
								'container_div' => false,
								'container_class' => '',
								'container_id' => '',
								'menu_class' => $menu_class,
								'item_class' => '',
								'submenu_class' => 'dropdown-menu',
								'item_wrap' => '',
								'after_item' => 'span',
								'after_item_class' => 'main-text-color light',
								'hasChildli_class' => 'dropdown closed',
								'menu_id' => ''
							);
				$menu = $this->MenuitemMasters->cp_menu($default); 
				echo $menu;
				
			?>
			<?php
			}
		}
		?>
				<?php if($theme['ThemeSetting']['header_type']=='H'){ ?>
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar main-bg-color"></span>
				<span class="icon-bar main-bg-color"></span>
				<span class="icon-bar main-bg-color"></span>
			</button>
			<?php } ?>
			<?php if($theme['ThemeSetting']['header_type']=='V'){ ?>
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".vtl-navigation">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar main-bg-color"></span>
				<span class="icon-bar main-bg-color"></span>
				<span class="icon-bar main-bg-color"></span>
			</button>
			<?php } ?>
           
			<div class="utilities-buttons pull-right">
			<?php 
			if($siteSettings['SiteSetting']['ecommerce_flag']=='Y')
			{
			?>
				<a data-toggle="collapse" href="#nav-shop" class="collapsed"> <i class="fa  fa-shopping-cart"></i> </a>
			<?php
			}
			if($siteSettings['SiteSetting']['ecommerce_flag']=='Y')
			{
			if($this->Session->read('loggedin_status'))
			{
				echo $this->Html->link('<i class="fa fa-user"></i>', array('controller'=>'Members', 'action'=>'myaccount'), array('class'=>'collapsed', 'title'=>'Login','escape'=>false)); 
				echo $this->Html->link('<i class="fa  fa-sign-out"></i>', array('controller'=>'Members', 'action'=>'logout'), array('class'=>'collapsed', 'title'=>'Logout','escape'=>false)); 
			}
			else
			{
				echo $this->Html->link('<i class="fa  fa-lock"></i>', array('controller'=>'Members', 'action'=>'login'), array('class'=>'collapsed', 'title'=>'Login','escape'=>false)); 
			}
			}
			?>
				<a data-toggle="collapse" href="#search" class="collapsed submenu_rightsearch_backgound"> <i class="fa  fa-search magnify_glass"></i> </a>
			</div>
			
		</div>
		
		
		<div class="mobile-header">
			<?php
				$default = array(
								'menu_slug' => 'header-menu',
								'container_div' => false,
								'container_class' => '',
								'container_id' => '',
								'menu_class' => 'main-menu',
								'item_class' => '',
								'submenu_class' => 'submenu',
								'menu_id' => 'navbar-collapse-1',
								'mobile_menu' => 'yes'
							);
				$menu = $this->MenuitemMasters->cp_menu($default); 
				echo $menu;
				
			?>

			<div class="navbar-header">
				<?php 
				echo $this->Html->link(
					$this->Html->image(IMGPATH.'site_settings_logo/original/'.$siteSettings['SiteSetting']['logo'], array('alt'=>$siteSettings['SiteSetting']['meta_title'],'class'=>'img-responsive')),
					SITE_URL,
					array(
						'class'=>'logo-box',
						'escape'=>false
					)
				);	
				?>
			</div>

			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar main-bg-color"></span>
				<span class="icon-bar main-bg-color"></span>
				<span class="icon-bar main-bg-color"></span>
			</button>

			<div class="utilities-buttons pull-right">
			<?php
			 if($siteSettings['SiteSetting']['ecommerce_flag']=='Y')
			 {
			 ?>
				<a data-toggle="collapse" href="#nav-shop" class="collapsed"> <i class="fa  fa-shopping-cart"></i> </a>
			<?php
			}
			?>
				<a data-toggle="collapse" href="#search" class="collapsed submenu_rightsearch_backgound"> <i class="fa  fa-search magnify_glass"></i> </a>
			</div>

		</div>
		
	</div>
	<?php 
	if(!empty($theme)){ 
		if($theme['ThemeSetting']['header_type']=='H'){
	?>
	<div class="shadow <?php echo (!empty($theme['ThemeSetting']['shadow_style']))?$theme['ThemeSetting']['shadow_style']:'' ?>"></div>
	<?php
		}
	}
	?>
</header>