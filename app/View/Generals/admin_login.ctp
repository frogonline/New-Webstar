<?php echo $this->Form->create('User', array('url'=>array('controller'=>'Generals','action' => 'admin_login'), 'id'=>"validate", 'class'=>"form login-form", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
	<h3 class="form-title">Login to Admin</h3>
	<?php echo $this->Session->flash(); ?>
	<div class="form-group">
		<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
		<label class="control-label visible-ie8 visible-ie9">Username</label>
		<div class="input-icon">
			<i class="fa fa-user"></i>
			<?php echo $this->Form->input('username',array('id'=>"username", 'class'=>"form-control placeholder-no-fix", 'placeholder'=>'Username',  'autocomplete'=>'off')); ?>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label visible-ie8 visible-ie9">Password</label>
		<div class="input-icon">
			<i class="fa fa-lock"></i>
			<?php echo $this->Form->input('password',array('id'=>"password", 'class'=>"form-control placeholder-no-fix", 'autocomplete'=>'off', 'placeholder'=>'Password')); ?>
		</div>
	</div>
	<div class="form-actions">
		<label class="checkbox"><?php echo $this->Form->checkbox('remember', array('hiddenField' => false, 'value'=>'1')); ?> Remember me </label>
		<?php echo $this->Form->button('Login <i class="m-icon-swapright m-icon-white"></i>', array('type' => 'submit','escape'=>false, 'class'=>'btn green pull-right')); ?>
	</div>
	<div class="forget-password">
		<h4>Forgot your password ?</h4>
		<p>
			 No worries, click <a href="javascript:;" id="forget-password">
			here </a>
			to reset your password.
		</p>
	</div>
<?php echo $this->Form->end(); ?>

<div id="blockui_sample_3_1_element">
<?php echo $this->Form->create('User', array('action' => 'admin_forget', 'id'=>"validate", 'class'=>"forget-form", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<h3>Forget Password ?</h3>
		<p>
			 Enter your e-mail address below to reset your password.
		</p>
		<span id="show_message"></span>
		<div class="form-group">
			<div class="input-icon">
				<i class="fa fa-envelope"></i>
				<?php echo $this->Form->input('email',array('id'=>"email", 'class'=>"form-control placeholder-no-fix", 'autocomplete'=>'off', 'placeholder'=>'Email')); ?>
				<span class="loading" id="loading_login"  style="margin-top:5px; display:none; float:right;"> 
					<?php echo $this->Html->image('input-spinner.gif', array('alt' => 'CakePHP')); ?>
				</span>
			</div>
		</div>
		<div class="form-actions">
			<?php echo $this->Form->button('<i class="m-icon-swapleft"></i> Back', array('type' => 'button','escape'=>false, 'class'=>'btn' ,'id'=>'back-btn')); ?>
			<?php echo $this->Form->button('Submit <i class="m-icon-swapright m-icon-white"></i>', array('type' => 'submit','escape'=>false, 'class'=>'btn green pull-right' ,'id'=>'forgot_pass')); ?>
		</div>
<?php echo $this->Form->end(); ?>
</div>
<script type="text/javascript">
$(document).ready(function(){
$("#forgot_pass").click(function(e){
		e.preventDefault();
		var email = $('#email').val();
		  
		if(email !='')
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
							'action'=>'admin_forget'
						)
					); ?>',
				data : {email_id:email},
				success : function(result){
					Metronic.unblockUI('#blockui_sample_3_1_element');
					if(result == 1)
					{
						$('#show_message').html('A password reset link has been sent to the email address you supplied').css({'color':'green'})	 ;
					}
					else
					{
						$('#show_message').html('Check Your Email ID and try again').css({'color':'red'})	 ;
					}
				}
			});
		}
	});

});
</script>
