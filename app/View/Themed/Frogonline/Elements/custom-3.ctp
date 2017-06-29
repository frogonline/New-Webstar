<header class="custom-3">
	
	<div class="top-bar hidden-sm hidden-xs headertop_backgound">
		<div class="container hidden-xs">
			<div class="row headertop_control">
				<div class="col-sm-6">
					<div class="socials">
						<?php
						$socialIcons = $this->Footer->socialWidget();
						//pr($socialIcons);
						if(!empty($socialIcons)){
							foreach($socialIcons as $icon){
								echo $this->Html->link('<i class="fa fa-'.$icon['SocialWidget']['class'].' headertop_control"></i>', $icon['SocialWidget']['link'], array('class'=>$icon['SocialWidget']['link_class'], 'data-toggle'=>'tooltip', 'title'=>$icon['SocialWidget']['title'], 'target'=>'_blank', 'escape'=>false));
								echo '&nbsp;';
							}
						} 
						?>
					</div>
				</div>

				<div class="col-sm-6">
					<div class="utilities-buttons pull-right">
						 <?php 
						 if($siteSettings['SiteSetting']['ecommerce_flag']=='Y')
						 {
						 ?>
						<div class="element">
							<a data-toggle="collapse" title="Cart" href="#nav-shop" class="collapsed"> <i class="fa  fa-shopping-cart headertop_control"></i> </a>
						</div>
						<?php 
						}
						if($siteSettings['SiteSetting']['ecommerce_flag']=='Y')
						{
						if($this->Session->read('loggedin_status'))
						{
						?>
						<div class="element">
							<?php echo $this->Html->link('<i class="fa fa-user headertop_control"></i>', array('controller'=>'Members', 'action'=>'myaccount'), array('class'=>'collapsed', 'title'=>'Login','escape'=>false)); ?>
						</div>
						<div class="element">
							<?php echo $this->Html->link('<i class="fa fa-sign-out headertop_control"></i>', array('controller'=>'Members', 'action'=>'logout'), array('class'=>'collapsed', 'title'=>'Logout','escape'=>false)); ?>
						</div>
						<?php
						}
						else
						{
						?>
						<div class="element">
							<?php echo $this->Html->link('<i class="fa  fa-lock headertop_control"></i>', array('controller'=>'Members', 'action'=>'login'), array('class'=>'collapsed', 'title'=>'Login','escape'=>false)); ?>
						</div>
						<?php
						}
						}
						?>
						<div class="element">
							<a data-toggle="collapse" title="Search" href="#search" class="collapsed submenu_rightsearch_backgound"> <i class="fa  fa-search headertop_control magnify_glass"></i> </a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container menu-bar headerbutton_backgound" role="navigation">
	
		<div class="large-header">
			<div class="logo-wrapper">
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
				$menu_class = (!empty($theme))?'nav navbar-nav navbar-right '.$theme['ThemeSetting']['header_menu_style']:'nav navbar-nav';
				$default = array(
								'menu_slug' => 'header-menu',
								'custom_header_layout' => $theme['ThemeSetting']['header_layout'],
								'container_div' => false,
								'container_class' => '',
								'container_id' => '',
								'menu_class' => $menu_class,
								'item_class' => '',
								'submenu_class' => 'dropdown-menu',
								'item_wrap' => 'div',
								'item_wrap_class' => 'text',
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
		</div>
	

		<div class="mobile-header">
			<div class="navbar-header">
			<div class="logo-wrapper">
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
			</div>

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
			<div class="utilities-buttons">
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