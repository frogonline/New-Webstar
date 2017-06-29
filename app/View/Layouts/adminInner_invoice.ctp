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
				'admin/css/custom'
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
<body >
	
	<!-- BEGIN CONTAINER -->
	<div class="page-container">
		
		<div class="">
			<div class="page-content">
				
				<?php echo $this->fetch('content'); ?>
				
			</div>
		</div>
		
	</div>
	
	<?php 
		//echo $this->element('admin_footer',array('siteSettings'=>$siteSettings)); 
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
						'admin/jquery.autocomplete'
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
