<?php
echo $this->Layout->pagecrumb('page', 'Forgot Password');
?>
<div class="container">
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
		<h2>Forgot Your Password?</h2>
		<div class="content-form-page">
		  <div class="row">
		  <?php echo $this->Session->flash(); ?>
			<div class="col-md-7 col-sm-7">
			 <?php echo $this->Form->create('Member', array('url'=>array('controller'=>'Members', 'action'=>'forgot_password'), 'id'=>"forgot_password_form", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
			  <div class="form-group">
				  <label for="email" class="col-lg-4 control-label">Email <span class="require">*</span></label>
				  <div class="col-lg-8">
				  <?php echo $this->Form->input('email_id',array('id'=>"email_id",'class'=>"form-control",'div'=>false, 'label'=>false, 'type'=>'text','Placeholder'=>'')); ?>
					<span class="email-required"></span>
					</div>
				</div>
				
				<div class="row">
				  <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">
				  <?php echo $this->Form->button('Send', array('type' => 'submit', 'class'=>"btn btn-primary"));?>
				</div>
				</div>
				<?php  echo $this->Form->end(); ?>
			 </div>
			<div class="col-md-4 col-sm-4 pull-right">
			  <div class="form-info">
				<h2><em>Important</em> Information</h2>
			   <p>Enter the e-mail address associated with your account. Click submit to have your password e-mailed to you.</p>

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
	var form3 = $('#forgot_password_form');
	var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
	
	var validator = form3.validate({
		rules: {
			'data[Member][email_id]': {
				required: true,
				email: true
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
</script>