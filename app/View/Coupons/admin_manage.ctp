<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i><?php echo (isset($id))?'Edit':'Add' ?> Coupon
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('Coupons', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
						<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
						
						
						
						<?php if($id>0)
                            {							
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Select Type <span class="required">
							* </span>
							</label>
					
							<div class="col-md-4">
							
								<?php 
									$options = array('Percentage' => 'Percentage', 'Flat' => 'Flat');
									$attributes = array('legend' => false,
									'label' => true,
                                  'class' => 'radio-inline',
								'value'=>(!empty($data['Coupons']))?$data['Coupons']['coupon_type']:'', 
												'hidden'=>false,
												'div'=>false
												
												);
												
								    echo $this->Form->radio('coupon_type', $options,$attributes);
							       ?> 
								   
							</div>
						</div>
						<?php
						}
						else
						{
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Select Type <span class="required">
							* </span>
							</label>
					
							<div class="col-md-4">
								<?php 
									 $options = array('Percentage' => 'Percentage', 'Flat' => 'Flat');
									$attributes = array('legend' => false,
									'label' => true,
                                   'class' => 'radio-inline',								'value'=>(!empty($data['Coupons']))?$data['Coupons']['coupon_type']:'', 
												'hidden'=>false,
												'div'=>false,
												 'value' => 'Percentage',
												 'style'=>'padding-left: 5000px;'
												
												);
								    echo $this->Form->radio('coupon_type',$options,$attributes);
							       ?> 
							
							</div>
						</div>
						<?php 
						}
						?>
						
						
						
						<div class="form-group">
							<label class="col-md-3 control-label">Code <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php echo $this->Form->input('code',array('value'=>(isset($data['Coupons']))?$data['Coupons']['code']:'','data-required'=>1, 'class' => 'form-control',  'placeholder'=>"Enter Coupon Code", 'type'=>"text")); ?>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 control-label">Available Date:<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									
										<?php echo $this->Form->input('available_from',array('type'=>'text', 'class'=>'form-control form-filter input-sm date-picker','value' => (!empty($data['Coupons']['available_from']) && $data['Coupons']['available_from']!='0000-00-00')?date('d-m-Y',strtotime($data['Coupons']['available_from'])):'')); ?>
									               <span class="input-group-addon">
												to </span>
												<?php echo $this->Form->input('available_to',array('type'=>'text', 'class'=>'form-control form-filter input-sm date-picker',/* 'value'=>(isset($data['Coupons']))?$data['Coupons']['available_to']:'')); */
                                                    'value' => (!empty($data['Coupons']['available_to']) && $data['Coupons']['available_to']!='0000-00-00')?date('d-m-Y',strtotime($data['Coupons']['available_to'])):''));
												?>
								</div>
							</div>
						</div>
						
					<div class="form-group">
							<label class="col-md-3 control-label">Discount Amount<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php echo $this->Form->input('discount_amount',array('value'=>(isset($data['Coupons']))?$data['Coupons']['discount_amount']:'','data-required'=>1, 'class'=>"radio-inline", 'class' => 'form-control','placeholder'=>"Enter Coupon Discount Amount", 'type'=>"text")); ?>
								</div>
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
																'selected'=> (isset($data['Coupons']))?$data['Coupons']['status']:''
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
							<?php echo $this->Form->button('Cancel', array('type' => 'reset', 'class'=>"btn default", 'onclick'=>'window.history.back()'));?>
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
			/* 'data[Coupons][coupon_type]': {
				required: true
			}, */
			'data[Coupons][code]': {
				required: true
			},
			'data[Coupons][available_from]': {
				required: true
			},  
			'data[Coupons][available_to]': {
				required: true
			},
			'data[Coupons][discount_amount]': {
				required: true
			},
			
			'data[Coupons][status]': {
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