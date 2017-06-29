<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i> Manage Email Template
				</div>
			</div>
			<div class="portlet-body form">
				
				<!-- BEGIN FORM-->
				<?php 
				echo $this->Form->create('EmailTemplate', array('action' => 'admin_manage', 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
						<?php echo $this->Form->input('id',array('value'=>(isset($data['EmailTemplate']))?$data['EmailTemplate']['id']:'', 'id'=>'email_hid', 'type' => 'hidden', 'style'=>'display:none'));?>
						<div class="form-group">
							<label class="control-label col-md-3">Template Name<span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<?php echo $this->Form->input('template_name',array('value'=>(isset($data['EmailTemplate']))?$data['EmailTemplate']['template_name']:'', 'id'=>"template_name", 'data-required'=>1, 'class' => "form-control", 'placeholder'=>"Enter Subject")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Subject<span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<?php echo $this->Form->input('email_subject',array('value'=>(isset($data['EmailTemplate']))?$data['EmailTemplate']['email_subject']:'', 'id'=>"email_subject", 'data-required'=>1, 'class' => "form-control", 'placeholder'=>"Enter Subject", 'type'=>"textarea")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Body Text<span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<?php 
									if(isset($data['EmailTemplate']) && $data['EmailTemplate']['email_body']!='')
									{
										$template = $data['EmailTemplate']['email_body'];	
									}
									else
									{
										$template = 'This is a test template';	
									}
									echo $this->Form->input('email_body',array('value'=>$template, 'id'=>"email_body", 'data-required'=>1, 'class' => "ckeditor form-control",'data-error-container'=>'#editor1_error', 'placeholder'=>"Enter Body Text", 'type'=>"textarea")); 
								?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Status
							</label>
							<div class="col-md-4">
								<?php 
									$statusoption = array('Y'=>'Active','N'=>'InActive');
									echo $this->Form->input('status', 
										array(
											'class' => 'form-control', 
											'options' => $statusoption, 
											'label' => false,
											'empty' =>'Select',
											'selected' => (isset($data['EmailTemplate']))?$data['EmailTemplate']['status']:''
											)
										); 
								?>
							</div>
						</div>
						
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
							<?php echo $this->Form->button('Save', array('type' => 'submit', 'name'=>'continue', 'value'=>'s', 'class'=>"btn blue"));?>
							<?php echo $this->Form->button('Save & Close', array('type' => 'submit', 'class'=>"btn blue"));?>
							<?php 
								if(isset($data['EmailTemplate']))	
								{
									echo $this->Html->link(
												'Restore to Default',
												'/admin/EmailTemplates/restore/'.$data['EmailTemplate']['id'],
												array('class' => 'btn default')
									);
								}
							?>
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
		ignore: "", // validate all fields including form hidden input
		rules: {
			'data[EmailTemplate][template_name]': {
				required: true
			},
			'data[EmailTemplate][email_subject]': {
				required: true
			},  
			'data[EmailTemplate][email_body]': {
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
