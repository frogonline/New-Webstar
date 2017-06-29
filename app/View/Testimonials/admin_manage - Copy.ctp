<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?> Testimonial
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('Testimonial', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", 'type'=>'file', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
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
							<label class="control-label col-md-3">Name <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('title',array('value'=>(isset($data['Testimonial']))?$data['Testimonial']['title']:'', 'class'=>"form-control", 'placeholder'=>"Enter Name", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Designation <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('heading',array('value'=>(isset($data['Testimonial']))?$data['Testimonial']['heading']:'','class'=>"form-control", 'placeholder'=>"Enter Designation", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Testimonial<span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<?php	echo $this->Form->input('testimonial', array(
															'type' => "textarea",
															'placeholder'=>"Enter Testimonial",
															'value' => (isset($data['Testimonial']))?$data['Testimonial']['testimonial']:'', 
															'class' => "ckeditor form-control",
															'data-error-container'=>'#editor2_error'
														)); 
								?>
								<div id="editor2_error"></div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Image <span class="required">*</span></label>
							<div class="col-md-8">
								<?php
									if(!empty($data['Testimonial']['testimonial_image'])){
										echo '<div class="col-md-3">';
										echo $this->Html->image(IMGPATH.'testimonial_image/thumb/'.$data['Testimonial']['testimonial_image'], array('alt'=>'Image'));
										echo '</div>';
										echo '<div class="col-md-4">';
										echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array(
											'controller'=>'Testimonials',
											'action'=>'admin_imgdelete',
											'image_name'=>$data['Testimonial']['testimonial_image'],
											'id'=>$id
										), 
										array('confirm' => 'Are you Sure?', 'escape'=>false, 'full_base'=>true, 'class'=>'btn default btn-xs red')
										);
										echo '</div>';
										echo $this->Form->input('set_testimonial_image', array('type'=>'hidden','value'=>$data['Testimonial']['testimonial_image'],'class'=>'set'));
									} else {
										echo $this->Form->input('testimonial_image', array(
															'type' => "file"
														));  
										echo " &nbsp "."<font color='red'>(Recommended Size 75 x 75)</font>"; 
										echo $this->Form->input('set_testimonial_image', array('type'=>'hidden','value'=>'','class'=>'set'));
									}
								?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Testimonial Date<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
									echo $this->Form->input('test_date', array(
															'type' => "text",
															'placeholder'=>"Enter Testimonial Date",
															'value' => (!empty($data['Testimonial']['test_date']) && $data['Testimonial']['test_date']!='0000-00-00')?date("d/m/Y",strtotime($data['Testimonial']['test_date'])):'',
															'class' => "form-control form-filter input-sm date-picker",
															'readonly' => "readonly",
															
															)); 
								?>
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
																'selected'=> (isset($data['Testimonial']))?$data['Testimonial']['status']:''
															));
									?>  
								</div>
							</div>
						</div>
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
							<?php echo $this->Form->submit('Submit', array('type' => 'submit', 'class'=>"btn blue",'div'=>false));?>
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
			'data[Testimonial][title]': {
				required: true
			},
			'data[Testimonial][heading]': {
				required: true
			},  
			'data[Testimonial][testimonial]': {
				required: true
			},
			'data[Testimonial][test_date]': {
				required: true
			},
			'data[Testimonial][testimonial_image]': {
				required: true
			},
			'data[Testimonial][status]': {
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