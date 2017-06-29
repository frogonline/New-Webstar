<?php
	$statusArr = array('CONFIRM'=>'Confirm','REJECT'=>'Reject');
	$position = array('TOP'=>'Top','BOTTOM'=>'Bottom','LEFT'=>'Left','RIGHT'=>'Right');
	$column   = array('SINGLE'=>'Single','DOUBLE'=>'Double');
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?> Section
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('Section', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
					<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
						
						<div class="form-group">
							<label class="control-label col-md-3">Title <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('title',array('value'=>(isset($data['Section']))?$data['Section']['title']:'', 'id'=>"title", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Section Title", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Description <span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<?php echo $this->Form->input('description',array('value'=>(isset($data['Section']))?$data['Section']['description']:'', 'id'=>"description", 'data-required'=>1, 'class' => "ckeditor form-control",'data-error-container'=>'#editor2_error', 'placeholder'=>"Enter Section Description", 'type'=>"textarea")); ?>
								<div id="editor2_error"></div>
							</div>
						</div>
						
                        
                        <div class="form-group">
							<label class="control-label col-md-3">CSS 
							</label>
							<div class="col-md-8">
								<?php echo $this->Form->input('section_css',array('value'=>(isset($data['Section']))?$data['Section']['section_css']:'', 'id'=>"section_css", 'data-required'=>1, 'class' => "form-control",'placeholder'=>"Enter Section CSS", 'type'=>"textarea")); ?>
								<div id="editor2_error"></div>
							</div>
						</div>
                        
                        <div class="form-group">
							<label class="control-label col-md-3">JS 
							</label>
							<div class="col-md-8">
								<?php echo $this->Form->input('section_js',array('value'=>(isset($data['Section']))?$data['Section']['section_js']:'', 'id'=>"section_js", 'data-required'=>1, 'class' => "form-control",'placeholder'=>"Enter Section JS", 'type'=>"textarea")); ?>
								<div id="editor2_error"></div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Sort Order <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('sort_order',array('value'=>(isset($data['Section']))?$data['Section']['sort_order']:'', 'id'=>"sort_order", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"", 'type'=>"number")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 control-label">Status <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('status', array(
																'options' => $statusArr,
																'empty' => 'Select Status',	
																'class' => 'form-control',
																'selected'=> (isset($data['Section']))?$data['Section']['status']:''
															));
									?>  
								</div>
							</div>
						</div>
						
                        

					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
							<?php echo $this->Form->button('Submit', array('type' => 'submit', 'class'=>"btn blue"));?>
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
			'data[Section][title]': {
				required: true
			},
			'data[Section][description]': {
				required: true
			},  
			'data[Section][sort_order]': {
				required: true
			},
			'data[Section][status]': {
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