<?php
$statusArr = array('Y'=>'Active','N'=>'Inactive');
$headingfrontend_flagArr = array('Y'=>'Yes','N'=>'No');

?>
<style>
#cke_1_contents {
  height: 100px !important;
}
</style>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?>Text
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('Text', array('action' => 'admin_manage/', 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
					  <?php echo $this->Form->input('id',array('value'=>(isset($data['Text']))?$data['Text']['id']:'', 'type' => 'hidden'));?>
						
						<div class="form-group">
							<label class="control-label col-md-3">Name <span class="required"></span>
							</label>
							<div class="col-md-9">
								<?php echo $this->Form->input('name', array(
																'type' => 'textarea',
																'placeholder' => 'Please Insert Name',	
																'class' => 'form-control ckeditor',
																'value'=> (isset($data['Text']))?$data['Text']['name']:''
															)); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Show Heading in Frontend <span class="required"> * </span>
							</label>
							<div class="col-md-4">
								<?php
								echo $this->Form->input('headingfrontend_flag', array(
										'options'=>$headingfrontend_flagArr,
										'value'=>(!empty($data))?$data['Text']['headingfrontend_flag']:'',
										'type'=>'radio',
										'data-error-container'=>'#customerror_div',
										'before' => '<label class="col-md-3">',
										'after' => '</label>',
										'separator' => '</label><label class="col-md-3">',
										'legend'=>false,
										'hiddenField'=>false
									)
								);
								?>
								<span id="customerror_div"></span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Text <span class="required">
							* </span>
							</label>
							<div class="col-md-9">
								<?php echo $this->Form->input('text', array(
																'type' => 'textarea',
																'placeholder' => 'Please Insert Text',	
																'class' => 'ckeditor form-control',
																'value'=> (isset($data['Text']))?$data['Text']['text']:''
															)); ?>
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
																'selected'=> (isset($data['Text']))?$data['Text']['status']:''
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
			
			'data[Text][headingfrontend_flag]': {
				required: true
			},
			'data[Text][text]': {
				required: true
			},
			'data[Text][status]': {
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