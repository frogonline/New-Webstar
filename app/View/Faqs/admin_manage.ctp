<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?> FAQ
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('Faq', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"post", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
						<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
						<?php
								if(empty($id)){
									echo $this->Form->input('created_date', array('type'=>'hidden','value'=>date('Y-m-d')));
								} else {
									echo $this->Form->input('modified_date', array('type'=>'hidden','value'=>date('Y-m-d')));
								}
						?>
						<div class="form-group">
							<label class="col-md-3 control-label">Select Category <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('category_id', array(
																'options' => $faqcat,
																'empty' => 'Select Category',	
																'class' => 'form-control',
																'selected'=> (isset($data['Faq']))?$data['Faq']['category_id']:''
															));
									?>  
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Add Questions <span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<?php echo $this->Form->input('faq_questions',array('value'=>(isset($data['Faq']))?$data['Faq']['faq_questions']:'', 
																				'id'=>"name",  
																				'class' => "form-control",
																				'data-error-container'=>'#editor2_error',
																				'placeholder'=>"Enter Questions", 
																				'type'=>"textarea")); ?>
								<div id="editor2_error"></div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Add Answers <span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<?php	echo $this->Form->input('faq_answers', array(
															'type' => "textarea",
															'id' => 'content',
															'placeholder'=>"Enter Answers",
															'value' => (isset($data['Faq']))?$data['Faq']['faq_answers']:'', 
															'class' => "ckeditor form-control",
															'data-error-container'=>'#editor2_error',
														)); 
								?>
								<div id="editor2_error"></div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Sort order <span class="required">
								* </span>
								</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('sort_order',array('value'=>(isset($data['Faq']))?$data['Faq']['sort_order']:'', 
																				'class'=>"form-control", 
																				'type'=>'number',
																				'placeholder'=>"Enter Sort Order")); ?>
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
																'selected'=> (isset($data['Faq']))?$data['Faq']['status']:''
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
			'data[Faq][category_id]': {
				required: true
			},
			'data[Faq][faq_questions]': {
				required: true
			},  
			'data[Faq][faq_answers]': {
				required: true
			},
			'data[Faq][sort_order]': {
				required: true
			},
			'data[Faq][status]': {
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