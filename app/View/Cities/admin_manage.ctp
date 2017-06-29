<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	
	
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?> City
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('Cities', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
						<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
						
						<div class="form-group">
							<label class="col-md-3 control-label">Country <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('CountryID', array(
																'options' => $Countries,
																'empty' => 'Select Country',	
																'class' => 'form-control',
																'id' => 'CitiesCountryID',
																'selected'=> (isset($data['Cities']))?$data['Cities']['CountryID']:''
															));
									?>  
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 control-label">State <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group" id="state_list">
									<?php  
										echo $this->Form->input('StateID', array(
																'options' => $paginate2,
																'empty' => 'Select State',	
																'class' => 'form-control',
																'id' => 'CitiesStateID',
																'selected'=> (isset($data['Cities']))?$data['Cities']['StateID']:''
															));
									?>  
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">City <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('City',array('value'=>(isset($data['Cities']))?$data['Cities']['City']:'', 'id'=>"name", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter City Name", 'type'=>"text")); ?>
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
																'selected'=> (isset($data['Cities']))?$data['Cities']['status']:''
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
			'data[Cities][CountryID]': {
				required: true
			},
			'data[Cities][StateID]': {
				required: true
			},  
			'data[Cities][City]': {
				required: true
			},
			'data[Cities][status]': {
				required: true
			}
		},
		errorPlacement: function (error, element) { // render error placement for each input type
			error.insertAfter(element); // for other inputs, just perform default behavior
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
	
	$("#CitiesCountryID").change(function(){
		var countryVal = $(this).val();
	
		$.ajax({
			type:'POST',
			url:'<?php echo $this->Html->url(array('controller'=>'Cities', 'action'=>'admin_ajaxstate')); ?>',
			data:{CountryID:countryVal},
			success:function(result){
				$("#state_list").html(result);
			}
		});	
	});
	
});
</script>





