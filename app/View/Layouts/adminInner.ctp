<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version());

$current_controller = $this->name;
$current_action = $this->action;
//($this->action=='admin_index')?$this->action:'admin_index';

$arrTitle = $this->AdminMenu->getModuleTitle($current_controller, $current_action); 

$siteSettings = $this->Session->read('siteSettings');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo 'Admin : '. implode(' : ',$arrTitle); ?>
	</title>
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
	<?php //echo $this->Html->css(''); ?>
	<?php
		$cssFiles = array(
	            'admin/css/font-awesome.min',
	            'admin/css/simple-line-icons.min',
	            'admin/css/bootstrap.min',
	            'admin/css/uniform.default',
				'admin/css/datepicker',
				'admin/css/select2',
	            'admin/css/components',
	            'admin/css/DT_bootstrap',
	            'admin/css/plugins',
	            'admin/css/layout',
	            'admin/css/custom',
				'admin/css/nestable',
				'admin/css/jquery.fancybox',
				'admin/css/portfolio',
				'admin/css/jquery-ui',
				'admin/css/multi-select',
				'admin/css/colorpicker',
				'admin/css/invoice',
				'admin/css/default',
				'admin/css/toastr.min',
				'admin/css/jquery-ui-1.10.3.custom.min',
				'admin/css/custom',
				'admin/css/google_analytics',
				'admin/css/daterangepicker-bs3'
				);
	
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
		

		//echo $this->fetch('meta');
		echo $this->Html->css($cssFiles);
		//echo $this->fetch('script');
		echo $this->Html->css('admin/css/default',array('id'=>'style_color'));
		$js = array(
					'admin/jquery-1.11.0.min',
					'admin/jquery.nestable',
					'admin/jquery-ui.js'
				);
		echo $this->Html->script($js);
	?>
</head>
<body class="page-header-fixed">
	<!-- BEGIN HEADER -->
	<?php echo $this->element('admin_header',array('siteSettings'=>$siteSettings)); ?>
	<!-- END HEADER -->
	<div class="clearfix"></div>
	
	<!-- BEGIN CONTAINER -->
	<div class="page-container">
		<!-- BEGIN SIDEBAR -->
		<div class="page-sidebar-wrapper">
			<?php echo $this->element('admin_sidebar'); ?>
		</div>
		<!-- END SIDEBAR -->
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<!-- BEGIN STYLE CUSTOMIZER -->
				<!--<div class="theme-panel hidden-xs hidden-sm">
					<div class="toggler"></div>
					<div class="toggler-close">
					</div>
					<div class="theme-options">
						<div class="theme-option theme-colors clearfix">
							<span> THEME COLOR </span>
							<ul>
								<li class="color-default current tooltips" data-style="default" data-original-title="Default">
								</li>
								<li class="color-darkblue tooltips" data-style="darkblue" data-original-title="Dark Blue">
								</li>
								<li class="color-blue tooltips" data-style="blue" data-original-title="Blue">
								</li>
								<li class="color-grey tooltips" data-style="grey" data-original-title="Grey">
								</li>
								<li class="color-light tooltips" data-style="light" data-original-title="Light">
								</li>
								<li class="color-light2 tooltips" data-style="light2" data-html="true" data-original-title="Light 2">
								</li>
							</ul>
						</div>
						<div class="theme-option">
							<span>
							Layout </span>
							<select class="layout-option form-control input-small">
								<option value="fluid" selected="selected">Fluid</option>
								<option value="boxed">Boxed</option>
							</select>
						</div>
						<div class="theme-option">
							<span>
							Header </span>
							<select class="page-header-option form-control input-small">
								<option value="fixed" selected="selected">Fixed</option>
								<option value="default">Default</option>
							</select>
						</div>
						<div class="theme-option">
							<span>
							Sidebar </span>
							<select class="sidebar-option form-control input-small">
								<option value="fixed">Fixed</option>
								<option value="default" selected="selected">Default</option>
							</select>
						</div>
						<div class="theme-option">
							<span>
							Sidebar Position </span>
							<select class="sidebar-pos-option form-control input-small">
								<option value="left" selected="selected">Left</option>
								<option value="right">Right</option>
							</select>
						</div>
						<div class="theme-option">
							<span>
							Footer </span>
							<select class="page-footer-option form-control input-small">
								<option value="fixed">Fixed</option>
								<option value="default" selected="selected">Default</option>
							</select>
						</div>
					</div>
				</div>-->
				<!-- END STYLE CUSTOMIZER -->
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<?php echo $this->element('admin_breadcrumb',array('titleArr'=>$arrTitle)); ?>
				<?php echo $this->Session->flash(); ?>
				<!-- END PAGE TITLE & BREADCRUMB-->
				<!-- BEGIN PAGE CONTENT-->
				<?php echo $this->fetch('content'); ?>
				<!-- END PAGE CONTENT-->
			</div>
		</div>
		<!-- END CONTENT -->
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<?php 
		echo $this->element('admin_footer',array('siteSettings'=>$siteSettings)); 
	?>
	<!-- END FOOTER -->
	<?php 
		echo $this->element('sql_dump'); 
		$jsFiles = array(
						'admin/jquery-migrate-1.2.1.min',
						'admin/jquery-ui-1.10.3.custom.min',
						'admin/bootstrap.min',
						'admin/bootstrap-hover-dropdown.min',
						'admin/jquery.slimscroll.min',
						'admin/jquery.blockui.min',
						'admin/jquery.cokie.min',
						'admin/jquery.uniform.min',
						'admin/jquery.dataTables.min',
						'admin/DT_bootstrap',
						'admin/bootstrap-datepicker',
						'admin/validate/jquery.validate.min',
						'admin/ckeditor/ckeditor',
						'admin/bootstrap-select.min',
						'admin/select2.min',
						'admin/metronic',
						'admin/layout',
						'admin/form-validation',
						'admin/table-managed',
						'admin/custom',
						'admin/components-pickers',
						'admin/jquery.mixitup.min',
						'admin/jquery.fancybox.pack',
						'admin/portfolio',
						'admin/jquery.multi-select',
						'admin/components-dropdowns',
						'admin/bootstrap-colorpicker',
						'admin/toastr.min',
						'admin/template',
						'admin/jquery.autocomplete',
						'http://code.highcharts.com/stock/highstock.js',
						'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js',
						'admin/daterangepicker'
					);
		echo $this->Html->script($jsFiles);
	?>
	<script type="text/javascript">
	jQuery(document).ready(function() {    
		Metronic.init(); // init metronic core components
		Layout.init(); // init current layout
		FormValidation.init();
		TableManaged.init();
		ComponentsPickers.init();
		Portfolio.init();
		ComponentsDropdowns.init();
	});
	</script>
</body>
</html>
