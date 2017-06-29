<div class="page-header navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<div class="row">
				<a href="#" class="col-md-8">
				<img src="<?php echo IMGPATH."admin_logo/original/".$siteSettings['SiteSetting']['admin_logo']; ?>" alt="logo" class="" style="margin:5px 0;"/>
				</a>
			</div>
			<div class="menu-toggler sidebar-toggler hide">
				<!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
			</div>
		</div>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<div class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</div>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN TOP NAVIGATION MENU -->
		<div class="top-menu">
			<ul class="nav navbar-nav pull-right">
				
				<!-- BEGIN USER LOGIN DROPDOWN -->
				<!-- BEGIN USER LOGIN DROPDOWN -->
				<li> <a href="<?php echo $this->webroot ;?>" title="view site" target="_blank" > View Site </a>
				<li>
					<?php echo $this->Html->link('<i class="fa fa-key"></i> Log Out', array('controller'=>'Generals','action'=>'admin_logout'), array('escape'=>false)); ?>
					
				</li>
				<!-- END USER LOGIN DROPDOWN -->
				<!-- END USER LOGIN DROPDOWN -->
			</ul>
		</div>
		<!-- END TOP NAVIGATION MENU -->
	</div>
	<!-- END HEADER INNER -->
</div>