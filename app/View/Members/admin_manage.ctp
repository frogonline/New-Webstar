<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$type = array('E'=>'Registered Member','G'=>'Gmail','F'=>'Facebook');
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?> Member
				</div>
			</div>
			<?php $this->Html->script('members/check_email',array('inline'=>false)); ?>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('Member', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"post", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
						<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
						<?php
								if(empty($id)){
									echo $this->Form->input('date_created', array('type'=>'hidden','value'=>date('Y-m-d')));
								} else {
									echo $this->Form->input('date_modified', array('type'=>'hidden','value'=>date('Y-m-d')));
								}
	?>
						<div class="form-group">
							<label class="control-label col-md-3">First Name <span class="required">
							* </span>
							</label>
							
							<div class="col-md-4">
								<?php echo $this->Form->input('firstname',array('value'=>(isset($data['Member']))?$data['Member']['firstname']:'', 'id'=>"name", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter First Name", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Last Name <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('lastname',array('value'=>(isset($data['Member']))?$data['Member']['lastname']:'', 'id'=>"name", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Last Name", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">User Name<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php	echo $this->Form->input('username', array(
															'type' => "text",
															'placeholder'=>"Enter User Name",
															'value' => (isset($data['Member']))?$data['Member']['username']:'', 
															'class' => "form-control"
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
															'value' => (isset($data['Member']))?$data['Member']['email_id']:'', 
															'class' => "form-control"
														)); 
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Password <span class="required">
							* </span></label>
							<div class="col-md-4">
								<?php
								if(!empty($id)){
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
							echo $this->Html->link('&times;', 'javascript:void(0);', array('escape'=>false, 'class'=>'btn red', 'id'=>'cnclEditLnk', 'style'=>'display:none;', 'data-status'=>(!empty($id))?'off':'on'));
							?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 control-label">Select Member Type <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('type', array(
																'options' => $type,
																'empty' => 'Select Member Type',	
																'class' => 'form-control',
																'selected'=> (isset($data['Member']))?$data['Member']['type']:''
															));
									?>  
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 control-label">Select Status <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('status', array(
																'options' => $statusArr,
																'empty' => 'Select Status',	
																'class' => 'form-control',
																'selected'=> (isset($data['Member']))?$data['Member']['status']:''
															));
									?>  
								</div>
							</div>
						</div>
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
							<?php echo $this->Form->button('Save', array('type' => 'submit', 'name'=>'continue', 'value'=>'s', 'class'=>"btn blue"));?>
							<?php echo $this->Form->submit('Save & Close', array('type' => 'submit', 'class'=>"btn blue",'div'=>false));?>
							<?php echo $this->Form->button('Cancel', array('type' => 'reset', 'class'=>"btn default",'div'=>false, 'onclick'=>'window.history.back()'));?>
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
	
	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
	
	form3.on('submit', function() {
		for(var instanceName in CKEDITOR.instances) {
			CKEDITOR.instances[instanceName].updateElement();
		}
	});
	
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: ".ignore", // validate all fields including form hidden input
		rules: {
			'data[Member][firstname]': {
				required: true
			},
			'data[Member][lastname]': {
				required: true
			},  
			'data[Member][username]': {
				required: true
			},
			'data[Member][email_id]': {
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
			'data[Member][type]': {
				required: true
			},
			'data[Member][status]': {
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
});
</script>