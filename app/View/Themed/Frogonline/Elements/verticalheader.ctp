<?php 
    $ThemeSetting=$this->Session->read('ThemeSetting');
	$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
	$siteSettings = $this->Session->read('siteSettings');
?>
<header class="custom-5">
	
	<div class="top-bar hidden-sm hidden-xs">
		<div class="container hidden-xs">
			<div class="row">
				<div class="col-sm-6">
					<div class="socials">
						<?php
						$socialIcons = $this->Footer->socialWidget();
						//pr($socialIcons);
						if(!empty($socialIcons)){
							foreach($socialIcons as $icon){
								echo $this->Html->link('<i class="fa fa-'.$icon['SocialWidget']['class'].'"></i>', $icon['SocialWidget']['link'], array('class'=>$icon['SocialWidget']['link_class'], 'data-toggle'=>'tooltip', 'title'=>$icon['SocialWidget']['title'], 'target'=>'_blank', 'escape'=>false));
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
							<a data-toggle="collapse" title="Cart" href="#nav-shop" class="collapsed"> <i class="fa  fa-shopping-cart"></i> </a>
						</div>
						<?php 
						}
						if($siteSettings['SiteSetting']['ecommerce_flag']=='Y')
						{
						if($this->Session->read('loggedin_status'))
						{
						?>
						<div class="element">
							<?php echo $this->Html->link('<i class="fa fa-user"></i>', array('controller'=>'Members', 'action'=>'myaccount'), array('class'=>'collapsed', 'title'=>'Login','escape'=>false)); ?>
						</div>
						<div class="element">
							<?php echo $this->Html->link('<i class="fa  fa-sign-out"></i>', array('controller'=>'Members', 'action'=>'logout'), array('class'=>'collapsed', 'title'=>'Logout','escape'=>false)); ?>
						</div>
						<?php
						}
						else
						{
						?>
						<div class="element">
							<?php echo $this->Html->link('<i class="fa  fa-lock"></i>', array('controller'=>'Members', 'action'=>'login'), array('class'=>'collapsed', 'title'=>'Login','escape'=>false)); ?>
						</div>
						<?php
						}
						}
						?>
						<div class="element">
							<a data-toggle="collapse" title="Search" href="#search" class="collapsed"> <i class="fa  fa-search"></i> </a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="container menu-bar" role="navigation">
		
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

			
			
		</div>
		

	</div>
	
	
</header>