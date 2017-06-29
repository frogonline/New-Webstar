<?php 
	$siteSettings = $this->Session->read('siteSettings');
	//pr($siteSettings);
?>
   <div class="container only">
                <div class="row">
                    <div id="random-id" class="col-sm-8">
                        <div class="form-3 main-el">
						<div class="ajaxLayout"  style="display: none;">
						  <img src="<?php echo $this->webroot ?>img/load.GIF" />
					    </div>
	                     <div id="contact_msg"></div>
                          <?php echo $this->Form->create('Page', array('url'=>array('controller'=>'Pages', 'action'=>'contactus'), 'id'=>"contactus_form", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
	                            <div class="row">
		                            <div class="col-sm-6">
			                          <?php echo $this->Form->input('name',array('id'=>"name",'class'=>"form-control",'div'=>false,'placeholder'=>'Name', 'label'=>false, 'type'=>'text')); ?>
		                            </div>

		                            <div class="col-sm-6">
			                           <?php echo $this->Form->input('email',array('id'=>"contacts-email",'class'=>"form-control",'div'=>false,'placeholder'=>'Email', 'label'=>false, 'type'=>'text')); ?>
		                            </div>

		                            

		                            <div class="col-xs-6">
			                           <?php echo $this->Form->textarea('comment',array('id'=>"contacts-message",  'class'=>"form-control",'div'=>false, 'label'=>false)); ?>

			                            <div class="btns">
				                            <div class="button solid blue sm">
					                            <div class="over">
						                            <i class="fa fa-plane"></i>
						                            <?php echo $this->Form->button('Send', array('type' => 'submit','value'=>'Send','class'=>'btn btn-primary'));?>
					                            </div>
					                            <!--<a class="button solid sm blue"><div class="over"><i class="fa fa-plane"></i>submit</div></a>-->
				                            </div>

				                           
			                            </div>
		                            </div>
	                            
									<div class="col-sm-6">
			                        <div id="RecaptchaField1"></div>
							         <span class="captcha-required"></span>
		                            </div>
								
								</div>
                           
					<?php  echo $this->Form->end(); ?>
                        
					
						
						</div>
                    </div>

                    <div class="col-sm-4">
                        <div class="contact-location main-el">
                            <div class="sep-heading-container shc4 clearfix">
                                <h4>London</h4>
                                <div class="sep-container">
                                    <div class="the-sep"></div>
                                </div>
                            </div>
                            <p>2736 North Avenue Luke Lane South Bend, IN 46601
 near subway century)</p>

                            <div class="phone">
                                <span class="bold field">Call: </span><a class="main-text-color">+00-000-0000</a>
                            </div>

                            <div class="mail">
                                <span class="bold field">Email: </span><a class="main-text-color">contact@yourdomain.com</a>
                            </div>
                        </div>

                        <div class="contact-location main-el">
                            <div class="sep-heading-container shc4 clearfix">
                                <h4>United States</h4>
                                <div class="sep-container">
                                    <div class="the-sep"></div>
                                </div>
                            </div>
                            <p>2736 North Avenue Luke Lane South Bend, IN 46601
 near subway century)</p>

                            <div class="phone">
                                <span class="bold field">Call: </span><a class="main-text-color">+00-000-0000</a>
                            </div>

                            <div class="mail">
                                <span class="bold field">Email: </span><a class="main-text-color">contact@yourdomain.com</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<div class="content">
	<div class="container">
		<div class="row">
			<div class="col-md-12 main-el">
				<div class="google-maps">
				<?php echo $siteSettings['SiteSetting']['google_map']; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	var form3 = $('#contactus_form');
	var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
	
	var validator = form3.validate({
		rules: {
			'data[Page][name]': {
				required: true
			},
			'data[Page][email]': {
				required: true,
				email: true
			},
			'data[Page][comment]': {
				required: true
			}
		},
		errorPlacement: function (error, element) { // render error placement for each input type
			if (element.attr("data-error-container")) { 
				error.appendTo(element.attr("data-error-container"));
			} else {
				error.insertAfter(element); // for other inputs, just perform default behavior
			}
		},
	});
	
	
	$('#contactus_form').submit(function(e){
		e.preventDefault();
		var g_recaptcha	=	$('#contactus_form [name="g-recaptcha-response"]').val();
		if(g_recaptcha=="")
		{
			$('.captcha-required').html('<label for="PageComment" class="error" style="margin-top:0px!important;margin-left:0px;">This field is required.</label>');
		}
		else
		{
			$('.captcha-required').html('');
			if(validator.form()){
				var data = $(this).serialize();
				$.ajax({
					type:'POST',
					url:'<?php echo $this->Html->url(array('controller'=>'Pages','action'=>'ajaxContact'), array('full_base'=>true)); ?>',
					data:data,
					beforeSend : function(res){
						$(".ajaxLayout").show(); 
					},
					complete: function() {
						$(".ajaxLayout").hide(); 
					},
					success:function(result){
						if(result == 4){
							$('#contact_msg').html('<p class="success_msg">Contact details has been sent.</p>');
							$('#contactus_form')[0].reset();
							<!--grecaptcha.reset(); -->
						} else if(result == 3) {
							$('#contact_msg').html('<p class="error_msg">Failed to send mail.</p>');
								<!--grecaptcha.reset(); -->
						} else if(result == 2) {
							$('.captcha-required').html('<p class="error_msg">You have given wrong captcha.</p>');
								<!--grecaptcha.reset(); -->
						} else if(result == 1) {
							$('#contact_msg').html('<p class="error_msg">Please fill all fields.</p>');
						}
					}
				});
			}
		}
		
	});
	
	//Message Hide
	$('#contact_msg').click(function(e){
		e.preventDefault();
		$(this).find('p').remove();
	});
	
});
</script>


