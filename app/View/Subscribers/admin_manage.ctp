<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	if(isset($group) && !empty($group))
	{
		foreach($group as $group)
		{
			$grouplist[$group['NewsletterGroups']['id']]=$group['NewsletterGroups']['name'];
		}
	}
	else
	{
		$grouplist = array();
	}
?>
<style>
.error-message {
color:#CF0000;
}
</style>

<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?> Subscriber
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('Subscriber', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
					<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
						
						
						<div class="form-group">
							<label class="col-md-3 control-label">Select Group
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('subscriber_group', array(
																'options' => $grouplist,
																'empty' => 'Select Group',	
																'class' => 'form-control',
																'selected'=> (isset($data['Subscriber']))?$data['Subscriber']['subscriber_group']:''
															));
									?>  
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Name <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('subscriber_name',array('value'=>(isset($data['Subscriber']))?$data['Subscriber']['subscriber_name']:'', 'id'=>"subscriber_name", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Subscriber Name", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Email <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('subscriber_email',array('value'=>(isset($data['Subscriber']))?$data['Subscriber']['subscriber_email']:'', 'id'=>"subscriber_email", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Subscriber Email", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 control-label">Select Status <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('subscriber_status', array(
																'options' => $statusArr,
																'empty' => 'Select Status',	
																'class' => 'form-control',
																'selected'=> (isset($data['Subscriber']))?$data['Subscriber']['subscriber_status']:''
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
							<?php echo $this->Form->button('Cancel', array('type' => 'reset','onclick'=>'window.history.back()', 'class'=>"btn default",'div'=>false));?>
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
			'data[Subscriber][subscriber_name]': {
				required: true
			},
			
			'data[Subscriber][subscriber_email]': {
				required: true
			},
			'data[Subscriber][subscriber_status]': {
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