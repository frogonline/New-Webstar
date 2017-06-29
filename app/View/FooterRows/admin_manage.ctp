<?php
$statusArr = array('Y'=>'Active','N'=>'Inactive');
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
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?> Footer Block
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('FooterBlock', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
					<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
						
						<div class="form-group">
							<label class="control-label col-md-3">Block Title <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('title',array('value'=>(isset($data['FooterBlock']))?$data['FooterBlock']['title']:'', 'id'=>"title", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter block Title", 'type'=>"text")); ?>
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="col-md-3 control-label">Select Footer <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('footer_block', array(
																'options' => $options,
																'empty' => 'Select Footer',	
																'class' => 'form-control',
																'id'=>'footer_block',
																'selected'=> (isset($data['FooterBlock']))?$data['FooterBlock']['footer_block']:''
															));
									?>  
								</div>
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="control-label col-md-3">Block Content <span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<?php echo $this->Form->input('block_content',array('value'=>(isset($data['FooterBlock']))?$data['FooterBlock']['block_content']:'', 'id'=>"block_content", 'data-required'=>1, 'class' => "ckeditor form-control",'data-error-container'=>'#editor2_error', 'placeholder'=>"Enter Homepage Widget Description", 'type'=>"textarea")); ?>
								<div id="editor2_error"></div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Order sequence  <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('order',array('value'=>(isset($data['FooterBlock']))?$data['FooterBlock']['order']:'', 'id'=>"order", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter block order", 'type'=>"text")); ?>
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="col-md-3 control-label">Select Status <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('is_active', array(
																'options' => $statusArr,
																'empty' => 'Select Status',	
																'class' => 'form-control',
																'id'=>'is_active',
																'selected'=> (isset($data['FooterBlock']))?$data['FooterBlock']['is_active']:''
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
			'data[FooterBlock][title]': {
				required: true
			},
			'data[FooterBlock][block_content]': {
				required: true
			},'data[FooterBlock][order]': {
				required: true,
				integer : true
				
			},  
			'data[FooterBlock][is_active]': {
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