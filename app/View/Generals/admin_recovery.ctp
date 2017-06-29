<div id="blockui_sample_3_1_element">
<?php echo $this->Form->create('User', array('action' => 'admin_reset', 'id'=>"validate", 'class'=>"form login-form", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
	<h3 class="form-title">Reset Your Password</h3>
	<div class="alert alert-danger display-hide">
		<button class="close" data-close="alert"></button>
		<span>
		Reset Your Password. </span>
	</div>
	<span id="show_message"></span>
	<div class="form-group">
		<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
		<label class="control-label visible-ie8 visible-ie9">Password</label>
		<div class="input-icon">
			<i class="fa fa-lock"></i>
			<?php echo $this->Form->input('reset_password',array('id'=>"reset_password", 'class'=>"form-control placeholder-no-fix", 'placeholder'=>'Password',  'autocomplete'=>'off', 'type'=>'password')); ?>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label visible-ie8 visible-ie9">Password</label>
		<div class="input-icon">
			<i class="fa fa-check"></i>
			<?php echo $this->Form->input('re_password',array('id'=>"re_password", 'class'=>"form-control placeholder-no-fix", 'autocomplete'=>'off', 'placeholder'=>'Confirm Password', 'type'=>'password')); ?>
			<?php echo $this->Form->input('recode',array('id'=>"recode", 'type'=>'hidden', 'value'=>$data)); ?>
		</div>
	</div>
	<div class="form-actions">
		<?php echo $this->Form->button('Back <i class="m-icon-swapleft"></i>', array('type' => 'button','escape'=>false, 'class'=>'btn', 'onclick'=>'window.location.href=\''.SITE_URL.'admin\'')); ?>
		<?php echo $this->Form->button('Submit <i class="m-icon-swapright m-icon-white"></i>', array('type' => 'submit','escape'=>false, 'class'=>'btn green pull-right', 'id'=>'reset')); ?>
	</div>
	
<?php echo $this->Form->end(); ?>
</div>
<script type="text/javascript">
$(document).ready(function(){
$("#reset").click(function(e){
		e.preventDefault();
		
		var password 	= $('#reset_password').val();
		var c_password 	= $('#re_password').val();
		var recode 		= $('#recode').val();
			  
		if(password  !='' && c_password!='' && (password==c_password))
		{
			Metronic.blockUI({
                target: '#blockui_sample_3_1_element',
                boxed: true
            });
			$.ajax({
				type : 'POST',
				url : '<?php echo $this->Html->url(
						array(
							'controller'=>'Generals',
							'action'=>'admin_reset'
						)
					); ?>',
				data : {code:recode, password:c_password},
				success : function(result){
					Metronic.unblockUI('#blockui_sample_3_1_element');
					if(result == 1)
					{
						$('#show_message').html('Password reset successfully').css({'color':'green'});
					}
					/* else
					{
						$('#show_message').html('Check Your Email ID and try again').css({'color':'red'});
					} */
				}
			});
		}
		else
		{
			$('#show_message').html('Password and Confirm Password does not match').css({'color':'red'})	 ;
		}
	});

});
</script>
