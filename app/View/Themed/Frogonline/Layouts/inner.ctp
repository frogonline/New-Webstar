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
        <title><?php echo ($this->fetch('title')!='')?$siteSettings['SiteSetting']['meta_title'].' | '.$this->fetch('title'):$siteSettings['SiteSetting']['meta_title']; ?></title>
        <meta charset="utf-8">
<meta name="google-site-verification" content="p6w2d7VOUtDmR2jSBDut8HCDJb1J0WcWlH-UJ5VAQGI" />
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
				'style',
				'aspect',
				'main-aspect',
				'responsive',
				'toastr.min',
				'color_settings',
				'font_family',
				'custom',
				'themify-icons',
				'ionicons.css',
				'https://cdn.jsdelivr.net/animatecss/3.5.2/animate.min.css'
			);       
			echo $this->Html->css($cssArr); 
			
			$jsArr = array('modernizr.custom.27667','jquery-1.11.1.min','subscriber');
			echo $this->Html->script($jsArr);
			
		?>
       
		<!--[if lt IE 9]>
		<script type="text/javascript" src="../../includes/html5shiv/html5shiv.js"></script>
		<script type="text/javascript" src="../../includes/respond/respond.min.js"></script>
		<![endif]-->
        <link rel="icon" type="image/png" href="../favicon.ico">
	


		
		<!--<script src='https://www.google.com/recaptcha/api.js'></script>
		<script src="//www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit" async defer></script>
		<script type="text/javascript">
			var CaptchaCallback = function(){
				grecaptcha.render('RecaptchaField1', {'sitekey' : '<?php echo SITE_KEY; ?>'});
				grecaptcha.render('RecaptchaField2', {'sitekey' : '<?php echo SITE_KEY; ?>'});
			};
		</script>-->
		<?php 
		$jsArr = array('jquery-1.11.0.min','validate/jquery.validate.min');
		echo $this->Html->script($jsArr); 
		?>
		<script type="text/javascript">
		<?php 
			echo $siteSettings['SiteSetting']['anlytics_code']; 
		?>
		</script>
		<script type="text/javascript">
		
			(function() {
			
			window._pa = window._pa || {};
			
			// _pa.orderId = "myOrderId"; // OPTIONAL: attach unique conversion identifier to conversions
			
			// _pa.revenue = "19.99"; // OPTIONAL: attach dynamic purchase values to conversions
			
			// _pa.productId = "myProductId"; // OPTIONAL: Include product ID for use with dynamic ads
			
			var pa = document.createElement('script'); pa.type = 'text/javascript'; pa.async = true;
			
			pa.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + "//tag.marinsm.com/serve/58356b00b467157ef4000093.js";
			
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(pa, s);
			
			})();
		
		</script>
		<style>	
		#iframemap iframe{
			width: 100%;
			display: block;
			pointer-events: none;
			position: relative; /* IE needs a position other than static */
		}
		#iframemap iframe.clicked{
			pointer-events: auto;
		}
		</style>
    </head>

    <body id="inner" class="control_body control_body_background-color" data-spy="scroll" data-target="#section-nav" style="<?php echo $bgStyle; ?>">
		<!-- Go to www.addthis.com/dashboard to customize your tools -->
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-54db21f15b614045" async></script>
        <div id="main" class="<?php echo (!empty($theme))?($theme['ThemeSetting']['box_layout']=='yes')?'boxed':'':'' ?>">
			
            <?php
				echo $this->element((!empty($theme))?$theme['ThemeSetting']['header_layout']:'', array('theme'=>$theme,'siteSettings'=>$siteSettings));
				echo $this->element('minicart');
			   echo $this->element('search');
			?>
			<div class="clearfix"></div>
			<!--- header section end -->
			<?php echo $this->fetch('content'); ?>
			<!-- Go to www.addthis.com/dashboard to customize your tools -->
			<?php if($siteSettings['SiteSetting']['social_plugin'] == 'Y'){?>
			<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-547f83da2f436356" async></script>
			<?php }?>
			<!-- footer section start -->
            <?php	echo $this->element('footer', array('siteSettings'=>$siteSettings));	?>
			<div id="totop" class="collapsed">
	            <i class="fa fa-chevron-up"></i>
            </div>
			<?php
				$scriptArr = array(
					'jquery-ui-1.10.4.min',
					'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false',
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
					'toastr.min',
					'jquery.validate.min',
					'validation',
					'wow'
					);
				echo $this->Html->script($scriptArr);
			?>
        </div>
		 <script src='https://www.google.com/recaptcha/api.js'></script>
        <script>
        $(document).ready(function(){
	$(".qbutton").on('click',function() {
	   
	        createRecaptcha1();
	  
	});
		$(".qbutton1").on('click',function() {
	   
	        createRecaptcha1();
	  
	});
	/*else if(response.length == 0){
		$('#contact_msg_popup').html('<p style="color:red" class="alert alert-danger">reCaptcha not verified</p>');
		return false;
		}*/
	$('.contact_usform_popup').submit(function(e){
	
		e.preventDefault();
		var name = $('#pop-name').val();
		var email = $('#pop-contacts-email').val();
		var phone = $('#pop-phone').val();
		var message = $('#pop-contacts-message').val();
		var path = $('#pop-hidden').val();
		var response = grecaptcha.getResponse();
		//alert(response);
		if(name == '' && email == '' && message == '' && phone == ''){
		$('#pop-name').css('border', 'solid 2px #F00');
		$('#pop-contacts-email').css('border', 'solid 2px #F00');
		$('#pop-phone').css('border', 'solid 2px #F00');
		$('#pop-contacts-message').css('border', 'solid 2px #F00');
		return false;
		}else if(name == ''){
		$('#pop-name').css('border', 'solid 2px #F00');
		return false;
		}else if(email == ''){
		$('#pop-contacts-email').css('border', 'solid 2px #F00');
		return false;
		}else if(phone == ''){
		$('#pop-phone').css('border', 'solid 2px #F00');
		return false;
		}else if(message == ''){
		$('#pop-contacts-message').css('border', 'solid 2px #F00');
		return false;
		}else{
				$.ajax({
					type:'POST',
					url:path,
					data:{ name : name, email : email, message : message , phone : phone },
					beforeSend : function(res){
						$(".ajaxLayout_popup").show(); 
					},
					complete: function() {
						$(".ajaxLayout_popup").hide(); 
					},
					success:function(result){
						if(result == 4){
							window.location.href="<?php echo SITE_URL?>thank-you";
							return false;
						} else if(result == 3) {
							$('#contact_msg_popup').html('<p class="alert alert-danger">Failed to send mail.</p>');
						} else if(result == 1) {
							$('#contact_msg_popup').html('<p class="alert alert-danger">Please fill all fields.</p>');
						}
					}
				});

		}

	});
	
	$('#contact_msg').click(function(e){
		e.preventDefault();
		$(this).find('p').remove();
	});
	
	$('#pop-name').blur(function () {
   var fname = $("#pop-name").val();
   if (fname != "") {
        $("#pop-name").css('border', 'none');
    } 


});
$('#pop-contacts-email').blur(function () {
   var contacts_email = $("#pop-contacts-email").val();
   if (contacts_email != "") {
        $("#pop-contacts-email").css('border', 'none');
    } 


});
$('#pop-phone').blur(function () {
   var phone = $("#pop-phone").val();
   if (phone != "") {
        $("#pop-phone").css('border', 'none');
    } 


});
$('#pop-contacts-message').blur(function () {
   var contacts_message = $("#pop-contacts-message").val();
   if (contacts_message != "") {
        $("#pop-contacts-message").css('border', 'none');
    } 


});
	
	});


	function createRecaptcha1() {
		grecaptcha.render("captcha1", {sitekey: "6Le-CCMUAAAAAHXAPsDbjzgItb2L3ith_s9LAepF"});
	}
	
	
        
        </script>
	<script type="text/javascript">
	$(function(){
		Ecommerce.init();
	});
	</script>
	
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

<script type="text/javascript">
/* $(document).ready0(function(){
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



<script type="text/javascript">
var form = document.getElementById('form_3'); // form has to have ID: <form id="formID">
form.noValidate = true;
form.addEventListener('submit', function(event) { // listen for form submitting
        if (!event.target.checkValidity()) {
            event.preventDefault(); // dismiss the default functionality
            //alert('Please, fill the form'); // error message
            document.getElementById("errorMessageDiv").style.display = "block";
            document.getElementById('errorMessageDiv').innerHTML = 'Please, fill the form';
        }
    }, false);
</script>

<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    	<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" align="center">
					<strong>GET IN TOUCH WITH US!</strong>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					</button>
					<!--<div class="separator small center" style="width: 340px;margin: 6px auto 35px;">&nbsp;</div>-->
				</div>
                
                <!-- Begin # DIV Form -->
                <div id="div-forms">
                
                    <!-- Begin # Login Form -->
                    <form id="contact_usform" class="contact_usform_popup" method="post" accept-charset="utf-8" novalidate>
		                <div class="modal-body">
				    		
				<input name="data[Page][name]" id="pop-name" class="form-control" placeholder="Name *" type="text">
				
				
				<input name="data[Page][email]" id="pop-contacts-email" class="form-control" placeholder="Email *" type="text">
				
				
				
				
				<input name="data[Page][website]" id="pop-phone" placeholder="Phone number *" class="form-control" type="text">
				
									
	                           <textarea name="data[Page][message]" id="pop-contacts-message" class="form-control" rows="10" placeholder="Message *"></textarea>
	                           <input name="data[Page][hidden]" id="pop-hidden" value="<?php echo SITE_URL?>Pages/ajaxContactinfo1" type="hidden">
                            
        		    	</div>
				<div class="modal-footer">
	                            <div class="btns">
	                            
	                            <div id="captcha1"></div>
	                            <div id="contact_msg_popup"></div>
                                       <div class="over contactbutton_backgound" style="float: left; margin-top: 30px; margin-left: 21px!important;">   
	                               <input id="button" value="Submit" class="contact_button" type="submit">
	                               </div>
	                            </div>
	                            <div class="ajaxLayout_popup" align="center" style="display: none;">
					<img src="<?php echo SITE_URL?>app/webroot/img/fb_ajax_loader.gif" />
					</div>
				    </div>
                    </form>
                    
                    <!-- End # Login Form -->
                    
                   
                    
                    
                    
                </div>
                <!-- End # DIV Form -->
                
			</div>
		</div>
	</div>
    </body>
</html>