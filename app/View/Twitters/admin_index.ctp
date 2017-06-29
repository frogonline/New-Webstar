<?php
$currentModelPer=$this->Session->read('currentModelPer');
//pr($currentModelPer);
?>
<?php
if($currentModelPer['edit']=='Y')
{
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i> Edit Twitter Management
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('Twitter', array('action' => 'admin_index/', 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
					  <?php echo $this->Form->input('id',array('value'=>(isset($data['Twitter']))?$data['Twitter']['id']:'', 'type' => 'hidden'));?>
						
						<div class="form-group">
							<label class="control-label col-md-3">Twitter App ID <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('twiiter_appid',array('value'=>(isset($data['Twitter']))?$data['Twitter']['twiiter_appid']:'', 'id'=>"twiiter_id", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Twitter App ID", 'type'=>"text")); ?>
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="control-label col-md-3">Limit <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('limit',array('value'=>(isset($data['Twitter']))?$data['Twitter']['limit']:'', 'id'=>"limit", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Twitter Limit", 'type'=>"text")); ?>
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="control-label col-md-3">Short Code
							</label>
							<div class="col-md-4">
								<label class="control-label">[twitter] </label>
							</div>
						</div>
						
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
							<?php echo $this->Form->button('Submit', array('type' => 'submit', 'class'=>"btn blue"));?>
							<?php echo $this->Form->button('Cancel', array('type' => 'reset', 'class'=>"btn default",'div'=>false));?>
						</div>
					</div>
				<?php echo $this->Form->end(); ?>
				<!-- END FORM-->
			</div>
			<!-- END VALIDATION STATES-->
		</div>
	</div>
</div>
<?php
}
?>
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
			'data[Twitter][twiiter_appid]': {
				required: true
			},
			'data[Twitter][limit]': {
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