<?php
	$deliveryMethodArr = array('E'=>'Send By Email','D'=>'Store To Database');
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i><?php echo (isset($id))?'Edit':'Add' ?> Form
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('FormTable', array('url'=>array('controller'=>'FormTables','action' => 'admin_manage/'.$id), 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
						<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
						
						<h3 class="form-section">Form Setting</h3>
						
						<div class="form-group">
							<label class="control-label col-md-3">Name <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
									echo $this->Form->input('name', array(
															'type' => "text",
															'placeholder'=>"Enter Form Name",
															'value' => (isset($data['FormTable']))?$data['FormTable']['name']:'', 
															'class' => "form-control"
														)); 
								?>
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="control-label col-md-3">Description <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
									echo $this->Form->input('description', array(
															'type' => "textarea",
															'placeholder'=>"Enter Description",
															'value' => (isset($data['FormTable']))?$data['FormTable']['description']:'', 
															'class' => "form-control"
														)); 
								?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 control-label">Delivery Method <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('delivery_method', array(
																'options' => $deliveryMethodArr,
																'empty' => 'Select Method',	
																'class' => 'form-control',
																'id' => 'delivery_method',
																'selected'=> (isset($data['FormTable']))?$data['FormTable']['delivery_method']:''
															));
									?>  
								</div>
							</div>
						</div>
						
						<div id="sendtoemailDiv" style="display:none;">
						<div class="form-group">
							<label class="control-label col-md-3">Email To <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
									echo $this->Form->input('delivery_email', array(
															'type' => "text",
															'placeholder'=>"Enter Email To",
															'value' => (isset($data['FormTable']))?$data['FormTable']['delivery_email']:'', 
															'class' => "form-control"
														)); 
								?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Email Subject <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
									echo $this->Form->input('delivery_email_subject', array(
															'type' => "text",
															'placeholder'=>"Enter Email Subject",
															'value' => (isset($data['FormTable']))?$data['FormTable']['delivery_email_subject']:'', 
															'class' => "form-control"
														)); 
								?>
							</div>
						</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Submit Message <span class="required">
							* </span>
							</label>
							<div class="col-md-6">
								<?php 
									echo $this->Form->input('submit_message', array(
															'type' => "textarea",
															'placeholder'=>"Enter Submit Message",
															'value' => (isset($data['FormTable']))?$data['FormTable']['submit_message']:'', 
															'class' => "form-control"
														)); 
								?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Redirect URL <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('redirect_url',array('value'=>(isset($data['FormTable']))?$data['FormTable']['redirect_url']:'', 'class'=>"form-control", 'placeholder'=>"Enter Redirect URL", 'type'=>"text")); ?>
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
																'selected'=> (isset($data['FormTable']))?$data['FormTable']['status']:''
															));
									?>  
								</div>
							</div>
						</div>
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
							<?php echo $this->Form->button('Save', array('type' => 'submit', 'name'=>'continue', 'value'=>'s', 'class'=>"btn blue"));?>
							<?php echo $this->Form->button('Save & Close', array('type' => 'submit', 'class'=>"btn blue"));?>
							<?php echo $this->Form->button('Cancel', array('type' => 'reset', 'class'=>"btn default",'onclick'=>'window.history.back()'));?>
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
		
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "", // validate all fields including form hidden input
		rules: {
			'data[FormTable][name]': {
				required: true
			},
			'data[FormTable][description]': {
				required: true
			},  
			'data[FormTable][delivery_method]': {
				required: true
			},
			'data[FormTable][delivery_email]': {
				required: function(element){
					if($('#delivery_method').val().trim()!=""){
						if($('#delivery_method').val().trim()=="E"){
							return true
						} else {
							return false
						}
					} else {
						return false
					}
				},
				email: true
			},
			'data[FormTable][delivery_email_subject]': {
				required: function(element){
					if($('#delivery_method').val().trim()!=""){
						if($('#delivery_method').val().trim()=="E"){
							return true
						} else {
							return false
						}
					} else {
						return false
					}
				}
			},
			'data[FormTable][redirect_url]': {
				required: true
			},
			'data[FormTable][submit_message]': {
				required: true
			},
			'data[FormTable][status]': {
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
	
	$('#delivery_method').change(function(){
		var mthd = $(this).val();
		
		if(mthd.trim()!=""){
			if(mthd.trim()=="E"){
				$('#sendtoemailDiv').show();
			} else {
				$('#sendtoemailDiv').hide();
			}
		} else {
			$('#sendtoemailDiv').hide();
		}
	});
	
	var mthd = $('#delivery_method').val();
		
	if(mthd.trim()!=""){
		if(mthd.trim()=="E"){
			$('#sendtoemailDiv').show();
		} else {
			$('#sendtoemailDiv').hide();
		}
	} else {
		$('#sendtoemailDiv').hide();
	}
	
});
</script>