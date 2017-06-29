<header class="head-1 custom-shadow static">
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
				<!--<a class="logo-box" href="../homepages/home-corp1.php">
					<img class="img-responsive" alt="Corex" src="../../images/logo.png">
				</a>-->
			</div>
            
			<div class="utilities-buttons">
			<?php 
			if($siteSettings['SiteSetting']['ecommerce_flag']=='Y')
			{
			if($this->Session->read('loggedin_status'))
			{
				echo $this->Html->link('<i class="fa fa-user"></i>', array('controller'=>'Members', 'action'=>'myaccount'), array('class'=>'collapsed', 'title'=>'Login','escape'=>false));
				echo $this->Html->link('<i class="fa  fa-sign-out"></i>', array('controller'=>'Members', 'action'=>'logout'), array('class'=>'collapsed', 'title'=>'Logout','escape'=>false));
			} else {
				echo $this->Html->link('<i class="fa fa-lock"></i>', array('controller'=>'Members', 'action'=>'login'), array('class'=>'collapsed', 'title'=>'Login','escape'=>false));
			}
			}
			if($siteSettings['SiteSetting']['ecommerce_flag']=='Y')
			{
				echo $this->Html->link(' <i class="fa fa-shopping-cart"></i> ', '#nav-shop', array('escape'=>false, 'class'=>'collapsed', 'data-toggle'=>'collapse'));
			}
			
			echo $this->Html->link(' <i class="fa  fa-search magnify_glass"></i> ', '#search', array('escape'=>false, 'class'=>'collapsed submenu_rightsearch_backgound', 'data-toggle'=>'collapse'));
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