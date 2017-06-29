<?php
$siteSettings = $this->Session->read('siteSettings');
$theme = $this->Layout->themeSettings();
if(!empty($theme)){
	if($theme['ThemeSetting']['background_type']=='image'){
		$bgStyle = 'background-image: url('.IMGPATH.'bgfilename/'.$theme['ThemeSetting']['background_img'].'); background-repeat: no-repeat; background-attachment: fixed; background-size: 100% 100%;';
	} else if($theme['ThemeSetting']['background_type']=='pattern') {
		$bgStyle = 'background-image: url('.IMGPATH.'bgfilename/'.$theme['ThemeSetting']['background_img'].'); background-repeat: repeat; background-attachment: fixed;';
	} else {
		$bgStyle = "";
	}
} else {
	$bgStyle = "";
}
//pr($theme);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $siteSettings['SiteSetting']['meta_title']; ?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php 
			echo $this->Html->meta('keywords', $this->fetch( 'meta_keywords' ) ); 
			echo $this->Html->meta('description', $this->fetch( 'meta_description' ) ); 
		?>
		<meta property="og:site_name" content="<?php echo $siteSettings['SiteSetting']['meta_title']; ?>">
		<meta property="og:title" content="<?php echo $siteSettings['SiteSetting']['meta_title'].' | '.$this->fetch( 'meta_title' ); ?>">
		<meta property="og:description" content="<?php echo stripslashes(substr($this->fetch( 'meta_description' ),0,100)); ?>">
		<meta property="og:type" content="website">
		<meta property="og:image" content="<?php echo ($this->fetch('image_path')!='')?$this->fetch('image_path'):IMGPATH.'site_settings_logo/original/'.$siteSettings['SiteSetting']['logo']; ?>"><!-- link to image for socio -->
		<meta property="og:url" content="<?php echo Router::url(null, true); ?>">
		<?php
			$cssArr = array(
				'font-awesome.min',
				'fontello',
				'animation',
				'bootstrap.min',
				'mediaelementplayer.min',
				'settings',
				'smoothDivScroll',
				'magnific-popup',
				'aspect',
				'main-aspect',
				'style',
				'responsive',
				'toastr.min',
				'color_settings',
				'font_family'
			);       
			echo $this->Html->css($cssArr); 
			
			$jsArr = array('modernizr.custom.27667','jquery-1.11.1.min');
			echo $this->Html->script($jsArr);
			
		?>
	   
		<!--[if lt IE 9]>
		<script type="text/javascript" src="../../includes/html5shiv/html5shiv.js"></script>
		<script type="text/javascript" src="../../includes/respond/respond.min.js"></script>
		<![endif]-->
		<link rel="icon" type="image/png" href="../../favicon.png">
		
		
		<?php 
			$jsArr = array('jquery-1.11.0.min','validate/jquery.validate.min');
			echo $this->Html->script($jsArr); 
		?>
		<script type="text/javascript">
		<?php 
			echo $siteSettings['SiteSetting']['anlytics_code']; 
		?>
		</script>

	</head>

	<body data-spy="scroll" class="control_body control_body_background-color" data-target="#section-nav" style="<?php echo $bgStyle; ?>">
		<div id="main" class="<?php echo (!empty($theme))?($theme['ThemeSetting']['box_layout']=='yes')?'boxed':'':'' ?>">
			<?php
				echo $this->element((!empty($theme))?$theme['ThemeSetting']['header_layout']:'', array('theme'=>$theme,'siteSettings'=>$siteSettings));
				
				echo $this->element('minicart');
				echo $this->element('search');
			?>

			<!--- header section end -->
			<?php echo $this->fetch('content'); ?>
			<!-- Go to www.addthis.com/dashboard to customize your tools -->
			<?php if($siteSettings['SiteSetting']['social_plugin'] == 'Y'){?>
			<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-547f83da2f436356" async="async"></script>
			<?php }?>
			<!-- footer section start -->
			<?php echo $this->element('footer',array('siteSettings'=>$siteSettings));	?>
			<div id="totop" class="collapsed">
				<i class="fa fa-chevron-up"></i>
			</div>
			<?php
			$scriptArr = array(
				'jquery-ui-1.10.4.min',
				'bootstrap.min',
				'jquery.isotope.min',
				'jquery.isotope.sloppy-masonry.min',
				'jquery.cycle.all.min',
				'jquery.cycle2.center.min',
				'jquery.mixitup',
				'jquery.smoothdivscroll-1.3-min',
				'jquery.stellar.min',
				'mediaelement-and-player.min',
				'jquery.magnific-popup.min',
				'jquery.carouFredSel-6.2.1-packed',
				'jquery.themepunch.plugins.min',
				'jquery.themepunch.revolution.min',
				'frogonline',
				'retina-1.1.0.min',
							
				
				
				
				
				'toastr.min'
				);
			echo $this->Html->script($scriptArr);
			?>
		</div>
	<script type="text/javascript">
	$(function(){
		Ecommerce.init();
	});
	</script>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-75679067-1', 'auto');
  ga('send', 'pageview');

</script>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<script type="text/javascript">
/* $(document).ready(function(){
$('.parentclass').click(function(){
var current_url=$(this).attr('href');
var sitecur = window.location.href;
if(current_url!=sitecur){
var parentpaget=$('#breadcrumbtitle').text().toLowerCase();
var parentpage='more';
var site_url='<?php echo SITE_URL; ?>';

var redirecturl=site_url+parentpage+'/'+parentpaget+'/';
current_url = current_url.replace(site_url,redirecturl);
$(this).attr("href", current_url);
}
});

}); */
</script>
	</body>
</html>