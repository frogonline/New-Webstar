<?php
	//$statusArr = array('Y'=>'Active','N'=>'Inactive');
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?> SocialWidgets
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('SocialWidget', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
						<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
						
						
						
						<div class="form-group">
							<label class="control-label col-md-3">Title <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('title',array('value'=>(isset($data['SocialWidget']))?$data['SocialWidget']['title']:'', 'id'=>"title1",'class'=>"form-control", 'placeholder'=>"Enter Title", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">URL <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('link',array('value'=>(isset($data['SocialWidget']))?$data['SocialWidget']['link']:'', 'class'=>"form-control", 'placeholder'=>"Enter URL", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">CSS Class <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('class',array('value'=>(isset($data['SocialWidget']))?$data['SocialWidget']['class']:'', 'id'=>"class",'class'=>"form-control", 'placeholder'=>"Enter Class", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Link Class <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('link_class',array('value'=>(isset($data['SocialWidget']))?$data['SocialWidget']['link_class']:'', 'id'=>"class",'class'=>"form-control", 'placeholder'=>"Enter Link Class", 'type'=>"text")); ?>
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
			'data[SocialWidget][title]': {
				required: true
			},
			'data[SocialWidget][link]': {
				required: true
			},
            'data[SocialWidget][link_class]': {
				required: true
			},			
			'data[SocialWidget][class]': {
				required: true
			},
			'data[SocialWidget][class]': {
				required: true
			},
			'data[SocialWidget][status]': {
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