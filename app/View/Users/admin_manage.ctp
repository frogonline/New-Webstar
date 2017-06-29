<?php
	$statusArr = array('CONFIRM'=>'CONFIRM','REJECT'=>'REJECT');
	$usertypeArr = array('admin'=>'Admin','super'=>'Super');

	$admintype=$this->Session->read('admintype');
?>

<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i><?php echo (isset($user_id))?'Edit':'Add' ?> Admin User
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('User', array('action' => 'admin_manage/'.$user_id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"post", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
						<?php echo $this->Form->input('user_id',array("type"=>"hidden", 'id'=>'user_id', "label"=>false,"value"=> $user_id)); ?>
						
						<div class="form-group">
							<label class="control-label col-md-3">First Name <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('firstname',array(
																		'value'=>(!empty($data['User']))?$data['User']['firstname']:'', 
																		'data-required'=>1, 
																		'class'=>"form-control", 'placeholder'=>"Enter Firstname", 'type'=>"text")); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Last Name<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
							<?php  
								echo $this->Form->input('lastname', array(	
														'placeholder'=>"Enter Last Name",
														'class' => 'form-control',
														'type'=>'text',
														'value'=> (!empty($data['User']))?$data['User']['lastname']:''
													));
							?>  
							</div>
							
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">User Name<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
							<?php 
								echo $this->Form->input('username', array(
														'type' => "text",
														'placeholder'=>"Enter User Name",
														'value' => (!empty($data['User']))?$data['User']['username']:'', 
														'class' => "form-control",
														'id'=>'usernameFld'
													)); 
							?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Email Id<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
									echo $this->Form->input('email_id', array(
															'type' => "email",
															'placeholder'=>"Enter Email Id",
															'autocomplete'=>'off',
															'value' => (!empty($data['User']))?$data['User']['email_id']:'', 
															'class' => "form-control",
															'id' => "emailidFld"
														)); 
								?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Password <span class="required">
							* </span></label>
							<div class="col-md-4">
								<?php
								if(!empty($user_id)){
									echo '<div id="editChngPwdLnk" class="form-control">';
									echo $this->Html->link('<i class="fa fa-edit"></i> Change Password', 'javascript:void(0);', array('escape'=>false, 'id'=>'chngPwdlink', 'class'=>'btn btn-xs purple'));
									echo '</div>';
									echo $this->Form->input('New.password', array(
															'type' => "password",
															'placeholder'=>"Enter Password",
															'autocomplete'=>"off",
															'value'=>"",
															'id' => "editChngPwdFld",
															'style' => "display:none;",
															'class' => "form-control"
														));
								} else {
									echo $this->Form->input('New.password', array(
															'type' => "password",
															'placeholder'=>"Enter Password",
															'autocomplete'=>"off",
															'class' => "form-control"
														));
								}
								?>
							</div>
							
							<div class="col-md-1">
							<?php 
							echo $this->Html->link('&times;', 'javascript:void(0);', array('escape'=>false, 'class'=>'btn red', 'id'=>'cnclEditLnk', 'style'=>'display:none;', 'data-status'=>(!empty($user_id))?'off':'on'));
							?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 control-label">User Type<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('user_type', array(
																'options' => $usertypeArr,
																'empty' => 'Select Status',	
																'class' => 'form-control',
																'selected'=> (!empty($data['User']))?$data['User']['user_type']:''
															));
									?>  
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Loc Status<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
							<?php 
								echo $this->Form->input('loc_status', array(
														'type' => "text",
														'readonly'=>"readonly",
														'value' => '0', 
														'class' => "form-control"
													)); 
							?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 control-label">Select Status<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('status', array(
																'options' => $statusArr,
																'empty' => 'Select Status',	
																'class' => 'form-control',
																'selected'=> (!empty($data['User']))?$data['User']['status']:''
															));
									?>  
								</div>
							</div>
						</div>
						<h3 class="form-section">Permission</h3>
						<!---<div class="form-group">
						
							<div class="col-md-1">
								<div class="input-group">
									<div>
										<a class='btn default btn-xs purple' id="allcheck">Check All</a>
									</div>
								</div>
							</div>
							<div class="col-md-1">
								<div class="input-group">
									<div>
										<a class='btn default btn-xs purple' id="allcheck1">Uncheck All</a>
									</div>
								</div>
							</div>
						</div> --->
						<?php
							echo $this->AdminMenu->accessFields($user_id);
							//$this->AdminMenu->accessFields($user_id); pr($arr); 
						?>
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-4">
							<?php echo $this->Form->submit('Save', array('type' => 'submit', 'class'=>"btn blue saveBtn",'div'=>false));?>
							<?php echo $this->Form->submit('Save & Close', array('type' => 'submit', 'class'=>"btn blue saveBtn",'div'=>false));?>
							<?php echo $this->Form->button('Cancel', array('type' => 'reset', 'class'=>"btn default",'div'=>false, 'onclick'=>'window.history.back()'));?>
						</div>
						<div class="col-md-4" id="waitingDiv" style="display:none;"><img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" /> <b>Saving your data. Please wait.</b>
						</div>
					</div>
				<?php echo $this->Form->end(); ?>
				<!-- END FORM-->
			</div>
			<!-- END VALIDATION STATES-->
		</div>
	</div>
</div>

<script type="text/javascript">
$(function(){
	
	/**** Change Password ****/
	$("#editChngPwdFld").val('');
	$("#chngPwdlink").click(function(e){
		e.preventDefault();
		$("#editChngPwdLnk").hide();
		$("#editChngPwdFld").show();
		$("#editChngPwdFld").val('');
		$("#cnclEditLnk").show();
		$("#cnclEditLnk").attr('data-status', 'on');
	});
	
	$("#cnclEditLnk").click(function(e){
		e.preventDefault();
		$("#editChngPwdLnk").show();
		$("#editChngPwdFld").hide();
		$("#cnclEditLnk").hide();
		$("#cnclEditLnk").attr('data-status', 'off');
	});
	/**** Change Password ****/
	
	/**** Form Validation ****/
	var form3 = $('#form_sample_3');
	var pass = $('#password');
	var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
		
	var validator = form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: ".ignore", // validate all fields including form hidden input
		rules: {
			'data[User][firstname]': {
				required: true
			},
			'data[User][lastname]': {
				required: true
			},  
			'data[User][username]': {
				required: true
			},
			'data[User][email_id]': {
				required: true
			},
			'data[New][password]': {
				required: function(element){
					var status = $('#cnclEditLnk').attr('data-status');
					
					if(status.trim() == 'off'){
						return false;
					} else {
						return true;
					}
				}
			},
			'data[User][user_type]': {
				required: true
			},
			'data[User][status]': {
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

		invalidHandler: function (event, validator) { //display error alert on form submit   
			success3.hide();
			error3.show();
			Metronic.scrollTo(error3, -200);
		},

		highlight: function (element) { // hightlight error inputs
		   $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
		},

		unhighlight: function (element) { // revert the change done by hightlight
			$(element)
				.closest('.form-group').removeClass('has-error'); // set error class to the control group
		},

		success: function (label) {
			label.closest('.form-group').removeClass('has-error'); // set success class to the control group
		}

	});
	
	$('.saveBtn').click(function(e){
		e.preventDefault();
		var continueBtn = $(this).val();
		$('#form_sample_3').submit(function(e){
			
		});
		if(validator.form()){
		
			var username = $('#usernameFld').val();
			var email = $('#emailidFld').val();
			var userId = $('#user_id').val();
			var data = $('#form_sample_3').serialize();
			if(userId.trim()==''){
				$.ajax({
					type:'POST',
					url:'<?php echo $this->Html->url(array('controller'=>'Users', 'action'=>'admin_usernamechk', 'full_base'=>true)); ?>',
					data:{username:username},
					beforeSend:function(){
						$('#waitingDiv').show();
					},
					complete:function(){
						$('#waitingDiv').hide();
					},
					success:function(result){
						if(result.trim()==0){
							$.ajax({
								type:'POST',
								url:'<?php echo $this->Html->url(array('controller'=>'Users', 'action'=>'admin_emailchk', 'full_base'=>true)); ?>',
								data:{email:email},
								beforeSend:function(){
									$('#waitingDiv').show();
								},
								complete:function(){
									$('#waitingDiv').hide();
								},
								success:function(result){
									if(result.trim()==0){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Users', 'action'=>'admin_ajaxusermanage/'.$user_id, 'full_base'=>true)); ?>',
											data:data,
											beforeSend:function(){
												$('#waitingDiv').show();
											},
											complete:function(){
												$('#waitingDiv').hide();
											},
											success:function(result){
												if(result.trim()!=0){
													if(continueBtn == "Save"){
														window.location.href = '<?php echo $this->Html->url(array('controller'=>'Users', 'action'=>'admin_manage/', 'full_base'=>true)); ?>'+'/'+result;
													} else {
														window.location.href = '<?php echo $this->Html->url(array('controller'=>'Users', 'action'=>'admin_index', 'full_base'=>true)); ?>';
													}
												} else {
													toastr.error('Failed to save user details', 'Error :',{closeButton:true});
												}
											}
										});
									} else {
										toastr.error('Email already exists', 'Error :',{closeButton:true});
									}
								}
							});
						} else {
							toastr.error('Username already exists', 'Error :',{closeButton:true});
						}
					}
				});
			} else {
				$.ajax({
					type:'POST',
					url:'<?php echo $this->Html->url(array('controller'=>'Users', 'action'=>'admin_ajaxusermanage/'.$user_id, 'full_base'=>true)); ?>',
					data:data,
					beforeSend:function(){
						$('#waitingDiv').show();
					},
					complete:function(){
						$('#waitingDiv').hide();
					},
					success:function(result){
						if(result.trim()!=0){
							if(continueBtn == "Save"){
								window.location.href = '<?php echo $this->Html->url(array('controller'=>'Users', 'action'=>'admin_manage', 'full_base'=>true)); ?>'+'/'+result;
							} else {
								window.location.href = '<?php echo $this->Html->url(array('controller'=>'Users', 'action'=>'admin_index', 'full_base'=>true)); ?>';
							}
						} else {
							toastr.error('Failed to save user details', 'Error :',{closeButton:true});
						}
					}
				});
			}
		}
	});
	
	/**** Form Validation ****/
	
	/**** Select All Permission Checkbox ****/
	$("#allcheck").click(function (e) {
		$('.checkBoxClass').each(function(){
			$(this).attr('checked', true);
		});
		$.uniform.update('.checkBoxClass');
	});
	/**** Select All Permission Checkbox ****/
	
	/**** Deselect All Permission Checkbox ****/
	$("#allcheck1").click(function (e) {
		$('.checkBoxClass').each(function(){
			$(this).attr('checked', false);
		});
		$.uniform.update('.checkBoxClass');
	});
	/**** Deselect All Permission Checkbox ****/
	
	/**** Edit Select Operation ****/	
	$(".editbox").click(function(){
		var viewid=$(this).attr('data-id');
		var addid=$(this).attr('add-id');
		var deleteid=$(this).attr('delete-id');
		var parentid=$(this).attr('data-parentid');
				
		var chflag=$(this).is(':checked');
		if(chflag)
		{
			$(viewid).prop('checked', true);
			$.uniform.update(viewid);
			
			while(parentid != "#view0"){
				$(parentid).prop('checked', true);
				$.uniform.update(parentid);
				parentid = $(parentid).attr('data-parentid');
			}
			
		}
		else if($(addid).prop('checked'))
		{
			$(viewid).prop('checked', true);
			$.uniform.update(viewid);
		}
		else if($(deleteid).prop('checked'))
		{
			$(viewid).prop('checked', true);
			$.uniform.update(viewid);
		}
		else
		{
			$(viewid).prop('checked', false);
			$.uniform.update(viewid);
		}
	});
	/**** Edit Select Operation ****/
		
	/**** Add Select Operation ****/	
	$(".addbox").click(function(){
		var viewid=$(this).attr('data-id');
		var editid=$(this).attr('edit-id');
		var deleteid=$(this).attr('delete-id');
		var parentid=$(this).attr('data-parentid');
		
		var chflag=$(this).is(':checked');
		if(chflag)
		{
			$(viewid).prop('checked', true);
			$.uniform.update(viewid);
			
			while(parentid != "#view0"){
				$(parentid).prop('checked', true);
				$.uniform.update(parentid);
				parentid = $(parentid).attr('data-parentid');
			}
		}
		
		else if($(editid).prop('checked')) {
		
			$(viewid).prop('checked', true);
			$.uniform.update(viewid);
		}
		else if($(deleteid).prop('checked'))
		{
			$(viewid).prop('checked', true);
			$.uniform.update(viewid);
		}
		else
		{
			 $(viewid).prop('checked', false);
			 $.uniform.update(viewid);
		}
	});
	/**** Add Select Operation ****/
	
	/**** Delete Select Operation ****/
	$(".deletebox").click(function(){
		var viewid=$(this).attr('data-id');
		var editid=$(this).attr('edit-id');
		var addid=$(this).attr('add-id');
		var parentid=$(this).attr('data-parentid');
		
		var chflag=$(this).is(':checked');
		if(chflag)
		{
			$(viewid).prop('checked', true);
			$.uniform.update(viewid);
			
			while(parentid != "#view0"){
				$(parentid).prop('checked', true);
				$.uniform.update(parentid);
				parentid = $(parentid).attr('data-parentid');
			}
		}
		
		else if($(editid).prop('checked')) {
		
			$(viewid).prop('checked', true);
			$.uniform.update(viewid);
		}
		else if($(addid).prop('checked'))
		{
			$(viewid).prop('checked', true);
			$.uniform.update(viewid);
		}
		else
		{
			 $(viewid).prop('checked', false);
			 $.uniform.update(viewid);
		}
	});
	
	$('.viewbox').click(function(){
		var parentid=$(this).attr('data-parentid');
		
		var chflag=$(this).is(':checked');
		if(chflag)
		{
			while(parentid != "#view0"){
				$(parentid).prop('checked', true);
				$.uniform.update(parentid);
				parentid = $(parentid).attr('data-parentid');
			}
		}
	}); 
	/**** Delete Select Operation ****/	
	
	$('.maindiv').click(function(){
		var parentmainid=$(this).attr('nes');
		if($("#view"+parentmainid).prop('checked'))
		{
			$("#view"+parentmainid).prop('checked', true);
			$.uniform.update("#view"+parentmainid);
			$('.divshow'+parentmainid).show();
			$('.chealldiv'+parentmainid).show();
			$('.unchealldiv'+parentmainid).show();
			
			
		}
		else
		{
			 $("#view"+parentmainid).prop('checked', false);
			 $.uniform.update("#view"+parentmainid);
			 $('.divshow'+parentmainid).hide();
			  $('.chealldiv'+parentmainid).hide();
			  $('.unchealldiv'+parentmainid).hide();
		}
	});
	
	/* $('.forcheckclass').click(function(){
	var parentmainid=$(this).attr('df');
		var vdg=$('.permimodel').val();
		alert(parentmainid);
	});
	
	$('.foruncheckclass').click(function(){
	
	}); */
}); 
function checkuncheck1(imp)
{
			$('.permode'+imp).each(function(){
			$(this).attr('checked', true);
			});
			
			$("#view"+imp).prop('checked', true);
			$.uniform.update('.permode'+imp);
			$.uniform.update("#view"+imp);
}
function checkuncheck11(imp)
{
			$('.permode'+imp).each(function(){
			 $(this).attr('checked', false);
			 });
			 $("#view"+imp).prop('checked', false);
			 $.uniform.update('.permode'+imp);
			 $.uniform.update("#view"+imp);
}
</script>

		