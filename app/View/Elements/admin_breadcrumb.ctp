<?php 
	$current_controller = $this->name;
	$current_action = $this->action;
	
	$pageTitle = end($titleArr);
	//pr($titleArr);
	// which controller's admin_index are not needed with add new button
	$index_addNew_exceptions = array('SiteSettings','EcommerceSettings','BlogSettings', 'Homepages', 'MenuMasters', 'Reviews', 'ClaimedVenues', 'PostComments', 'Themes','HomepageWidgets', 'Resources', 'Twitters', 'Dividers', 'FooterRows', 'CmsGalleries', 'Replies', 'PageTemplates', 'Orders', 'ProductReviews', 'Sidebars', 'SocialWidgets','Catalogs','PricingTables','EmailTemplates','Responses');
	foreach($index_addNew_exceptions as $per){ Inflector::camelize($per); }  // in case underscored name given
	
	// which actions are not needed with back button
	$back_excluded_array = array('admin_index','admin_dashboard','admin_deleted','admin_view','admin_review_index');
	
	$manage_ctpArr = array('admin_manage'=>'Manage', 'admin_setting'=>'Setting');
	$manage_ctpKeyArr = array_keys($manage_ctpArr);
?>

<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<h3 class="page-title">
		<?php echo $pageTitle; ?> 
		<div class="col-md-3" style="float:right;">
		</div>
		</h3>
		<ul class="page-breadcrumb breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<?php echo $this->Html->link('Home', array('controller'=>'Users','action'=>'admin_dashboard'), array('full_base'=>true)); ?>
				<i class="fa fa-angle-right"></i>
			</li>
			<?php
			if(!empty($titleArr)){
				foreach($titleArr as $title){
					$end = end($titleArr);
					if($title != $end){
						?>
						<li>
							<a href="javascript:void(0);"><?php echo $title; ?></a>
							<i class="fa fa-angle-right"></i>
						</li>
						<?
					} else {
						?>
						<li>
							<?php if(in_array($current_action, $manage_ctpKeyArr)){ ?>
							<a href="<?php echo $this->Html->url(array('controller'=>$current_controller, 'action'=>'admin_index', 'full_base'=>true)); ?>"><?php echo $title; ?></a>
							<i class="fa fa-angle-right"></i>
							<?php } else { ?>
							<a href="javascript:void(0);"><?php echo $title; ?></a>
							<?php } ?>
						</li>
						<?php
						if(in_array($current_action, $manage_ctpKeyArr)){
							echo '<li>'.$manage_ctpArr[$current_action].'</li>';
						}
					}
				}
			} else {
				echo '404';
			}
			?>
			<li class="btn-group">
				<div class="col-md-2" style="float:right; padding: 0 0 0 0;">
					<?php
					if( ($current_action == 'admin_index') && (!in_array($current_controller,$index_addNew_exceptions))){
						
						$currentModelPer=$this->Session->read('currentModelPer');
						//pr($currentModelPer);
						if(array_key_exists('add',$currentModelPer))
						{
							if($currentModelPer['add']=='Y')
							{
								echo $this->Html->link('<span class="fa fa-pencil"></span> &nbsp; &nbsp; Add New', array('controller'=>$current_controller,'action'=>'admin_manage'), array('class'=>'btn blue', 'escape'=>false, 'full_base'=>true, 'style'=>'float:right;'));
							}
						}
					} else if(($current_action == 'admin_manage') || (!in_array($current_action,$back_excluded_array))){
						echo $this->Html->link('<span class="fa fa-caret-left"></span> &nbsp; &nbsp; Back To Listing', array('controller'=>$current_controller,'action'=>'admin_index'), array('class'=>'btn blue', 'escape'=>false, 'full_base'=>true, 'style'=>'float:right;'));
					}
					?>
				</div>
			</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>