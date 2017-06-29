<?php
echo $this->Layout->pagecrumb('page', 'Reset Your Passowrd');
?>
<div class="container" id="blockui_sample_3_1_element">
	<div class="row margin-bottom-40">
	  <!-- BEGIN CONTENT -->
   
	  <div class="sidebar col-md-3 col-sm-3">
		<ul class="list-group margin-bottom-25 sidebar-menu">
		  <li class="list-group-item clearfix"><a href="#"><i class="fa fa-angle-right"></i> Login/Register</a></li>
		  <li class="list-group-item clearfix"><a href="#"><i class="fa fa-angle-right"></i> Restore Password</a></li>
		  <li class="list-group-item clearfix"><a href="#"><i class="fa fa-angle-right"></i> My account</a></li>
		  <li class="list-group-item clearfix"><a href="#"><i class="fa fa-angle-right"></i> Address book</a></li>
		  <li class="list-group-item clearfix"><a href="#"><i class="fa fa-angle-right"></i> Wish list</a></li>
		  <li class="list-group-item clearfix"><a href="#"><i class="fa fa-angle-right"></i> Returns</a></li>
		  <li class="list-group-item clearfix"><a href="#"><i class="fa fa-angle-right"></i> Newsletter</a></li>
		</ul>
	  </div>
	  <!-- END SIDEBAR -->

	  <!-- BEGIN CONTENT -->
	  <div class="col-md-9 col-sm-9">
		<h2>Reset Your Password</h2>
		<span id="show_message"></span>
		<div class="content-form-page">
		  <div class="row">
		  <?php echo $this->Session->flash(); ?>
			<div class="col-md-7 col-sm-7">
			 <?php echo $this->Form->create('Member', array('url'=>array('controller'=>'Members', 'action'=>'reset_password'), 'id'=>"recovery_form", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
			  <div class="form-group">
				  <label for="email" class="col-lg-4 control-label">Password <span class="require">*</span></label>
				  <div class="col-lg-8">
				  <?php echo $this->Form->input('reset_password',array('id'=>"reset_password",'class'=>"form-control",'div'=>false, 'label'=>false, 'type'=>'password','Placeholder'=>'')); ?>
					<span class="email-required"></span>
					</div>
				</div>
				<div class="form-group">
				  <label for="password" class="col-lg-4 control-label">Re Password <span class="require">*</span></label>
				  <div class="col-lg-8">
				  <?php echo $this->Form->input('re_password',array('id'=>"re_password",'class'=>"form-control",'div'=>false, 'label'=>false, 'type'=>'password','Placeholder'=>'')); ?>
				  <?php echo $this->Form->input('recode',array('id'=>"recode", 'type'=>'hidden', 'value'=>$data)); ?>
					<span class="password-required"></span>
				   </div>
				</div>
				<div class="row">
				  <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">
				  <?php echo $this->Form->button('Submit', array('type' => 'submit','id'=>'reset','class'=>"btn btn-primary"));?>
				</div>
				</div>
			   <?php  echo $this->Form->end(); ?>
			  </div>
			<div class="col-md-4 col-sm-4 pull-right">
			  <div class="form-info">
				<h2><em>Important</em> Information</h2>
				<p>Duis autem vel eum iriure at dolor vulputate velit esse vel molestie at dolore.</p>

				<button type="button" class="btn btn-default">More details</button>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
   
	  <!-- END CONTENT -->
	</div>
</div>
<script type="text/javascript">
 $(document).ready(function(){
	var form3 = $('#recovery_form');
	var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
	
	var validator = form3.validate({
		rules: {
			'data[Member][reset_password]': {
				required: true,
			},
			'data[Member][re_password]': {
				  equalTo: '#reset_password',
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
	
}); 

$('#recovery_form').submit(function(e)
	{

		var password 	= $('#reset_password').val();
		var c_password 	= $('#re_password').val();
		var recode 		= $('#recode').val();
			  
		if(password  !='' && c_password!='' && (password==c_password))
		{
			$.ajax({
				type : 'POST',
				data : {code:recode, password:c_password},
				url : '<?php echo $this->Html->url(
						array(
							'controller'=>'Members',
							'action'=>'reset_password'
						)
					); ?>',
				success : function(result){
				
					if(result == 1)
					{
						$('#show_message').html('Password reset successfully');
					}
					 if(result == 0)
					{
						$('#show_message').html('Check Your Email ID and try again');
					} 
				}
			});
		}
		else
		{
			$('#show_message').html('Password and Confirm Passowrd does not match');	
		}
});
</script>
