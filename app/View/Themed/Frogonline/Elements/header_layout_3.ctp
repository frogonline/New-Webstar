<header class="head-1">
	
	<div class="top-bar hidden-sm hidden-xs headertop_backgound">
		<div class="container hidden-xs">
			<div class="row headertop_control">
				<div class="col-sm-4 info txt-min">
					<span class="element header-text"><i class="fa fa-envelope main-text-color headertop_control"></i> <?php echo $siteSettings['SiteSetting']['admin_email']; ?></span>
					<span class="element header-text"><i class="fa fa-phone main-text-color headertop_control"></i> <?php echo $siteSettings['SiteSetting']['phone']; ?></span>
				</div>

				<div class="col-sm-8">
					<div class="buttons pull-right text-right txt-min clearfix header-text">
						<ul id="" class="">
						<?php
						if($siteSettings['SiteSetting']['ecommerce_flag']=='Y')
						{
						?>
							<li class="element headertop_control"><?php echo $this->Html->link('Checkout', SITE_URL.'checkout'); ?></li>
						<?php
						}
						if($siteSettings['SiteSetting']['ecommerce_flag']=='Y')
						{
						if($this->Session->read('loggedin_status'))
						{
						?>
							<li class="element headertop_control"><?php echo $this->Html->link('My Account', SITE_URL.'myaccount'); ?></li>
							<li class="element headertop_control"><?php echo $this->Html->link('Logout', SITE_URL.'logout'); ?></li>
						<?php
						}
						else
						{
						?>
							<li class="element headertop_control"><?php echo $this->Html->link('Register', SITE_URL.'register'); ?></li>
							<li class="element headertop_control"><?php echo $this->Html->link('Log in', SITE_URL.'login'); ?></li>
						<?php
						}
						}
						?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="container menu-bar headerbutton_backgound" role="navigation">
		
		<div class="large-header">
			<div class="navbar-header">
				<!--<a class="logo-box" href="../homepages/home-corp1.php">
					<img class="img-responsive" alt="Corex" src="../../images/logo.png">
				</a>-->
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