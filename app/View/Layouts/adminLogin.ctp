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
$siteSettings = $this->Session->read('siteSettings');

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $siteSettings['SiteSetting']['meta_title'];  ?> : Admin Loging
	
	</title>
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
	<?php
		$cssFiles = array(
	            'admin/css/font-awesome.min',
	            'admin/css/simple-line-icons.min',
	            'admin/css/bootstrap.min',
	            'admin/css/uniform.default',
	            'admin/css/select2',
	            'admin/css/login',
	            'admin/css/components',
	            'admin/css/plugins',
	            'admin/css/layout',
	            'admin/css/default',
	            'admin/css/custom'
			   );
		$jsFiles = array(
						'admin/jquery-1.11.0.min'
						);		
		echo $this->Html->script($jsFiles);
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');

		//echo $this->fetch('meta');
		echo $this->Html->css($cssFiles);
		//echo $this->fetch('script');
	?>
</head>
<body class="login">
	<!-- BEGIN LOGO -->
		<div class="row">
			<div class="col-md-12">
				<div class="logo">
					<a href="<?=SITE_URL?>admin/Users/index">
					<img  src="<?php echo IMGPATH."admin_logo/original/".$siteSettings['SiteSetting']['admin_logo']; ?>"  alt=""/>
					</a>
				</div>
			</div>
		</div>
	<!-- END LOGO -->
	
	<!-- BEGIN CONTAINER -->
	<div class="content">
		<!--<div class="row">
			<div class="col-md-12">
				<div class="logo">
					
				</div>
			</div>
		</div>-->
		<!-- BEGIN LOGIN FORM -->
		<?php echo $this->fetch('content'); ?>
		<!-- END LOGIN FORM -->
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<div class="copyright"><?php echo date('Y'); ?> <?php echo $siteSettings['SiteSetting']['admin_copyright']; ?></div>
	<!-- END FOOTER -->
	<?php 
		/* echo $this->element('sql_dump');  */
		$jsFiles = array(
						'admin/jquery-migrate-1.2.1.min',
						'admin/jquery-ui-1.10.3.custom.min',
						'admin/bootstrap.min',
						'admin/bootstrap-hover-dropdown.min',
						'admin/jquery.slimscroll.min',
						'admin/jquery.blockui.min',
						'admin/jquery.cokie.min',
						'admin/jquery.uniform.min',
						'admin/validate/jquery.validate.min',
						'admin/select2.min',
						'admin/metronic',
						'admin/layout',
						'admin/login'
					);
		echo $this->Html->script($jsFiles);
	?>
	<script type="text/javascript">
	jQuery(document).ready(function() {    
		Metronic.init(); // init metronic core components
		Layout.init(); // init current layout
		Login.init();
		
	});
	</script>
</body>
</html>
