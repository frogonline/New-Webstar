<?php
$ecommerce_flagArr = array('Y'=>'Yes','N'=>'No');
$shipping_flagArr = array('I'=>'Per Item','C'=>'Per Cart');
$freeshipping_Arr = array('Y'=>'Yes','N'=>'No');
$paypal_mode = array('S'=>'Sandbox','L'=>'Live');
$payment_methods = array('P'=>'Paypal','E'=>'Eway');
$currentModelPer=$this->Session->read('currentModelPer');
$ecommerceTplArr = array('products'=>'Shop Overview: Full Width','productssl'=>'Shop Overview: Sidebar L','productssr'=>'Shop Overview: Sidebar R',);
?>
<?php
if($currentModelPer['add']=='Y' || $currentModelPer['edit']=='Y')
{
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i> Edit Ecommerce Setting
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('SiteSetting', array('url'=>array('controller'=>'EcommerceSettings','action' => 'admin_index/'), 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
					  <?php echo $this->Form->input('id',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['id']:'', 'type' => 'hidden'));?>
						<div class="form-group">
							<label class="control-label col-md-3">Enable Ecommerce <span class="required">* </span>
							</label>
							<div class="col-md-4">
								<?php
								echo $this->Form->input('ecommerce_flag', array(
										'options'=>$ecommerce_flagArr,
										'value'=>(!empty($data))?$data['SiteSetting']['ecommerce_flag']:'',
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
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Ecommerce Template <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
									/* $currency_list = array('AUD'=>'Australian Dollar','EUR'=>'Euro','INR'=>'Indian Rupee','USD'=>'US Dollar'); */
									echo $this->Form->input('ecommerce_template',
											array(
												'class' => 'form-control',
												'empty' => 'Select Template',
												'options' => $ecommerceTplArr,
												'selected' => (isset($data['SiteSetting']))?$data['SiteSetting']['ecommerce_template']:''
											)
									);
								?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Shipping<span class="required">* </span>
							</label>
							<div class="col-md-4">
								<?php
								echo $this->Form->input('shipping_flag', array(
										'options'=>$shipping_flagArr,
										'value'=>(!empty($data))?$data['SiteSetting']['shipping_flag']:'',
										'type'=>'radio',
										'data-error-container'=>'#customerror_div',
										'before' => '<label class="col-md-5">',
										'after' => '</label>',
										'separator' => '</label><label class="col-md-5">',
										'legend'=>false,
										'hiddenField'=>false
									)
								);
								?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Currency <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
									$currency_list = array('AUD'=>'Australian Dollar','EUR'=>'Euro','INR'=>'Indian Rupee','USD'=>'US Dollar');
									echo $this->Form->input('currency',
											array(
												'class' => 'form-control',
												'empty' => 'Select',
												'options' => $currency_list,
												'selected' => (isset($data['SiteSetting']))?$data['SiteSetting']['currency']:''
											)
									);
								?>
							</div>
						</div>
						
						<div class="form-group">
								<label class="control-label col-md-3">Paypal Business Email<span class="required">
								* </span>
								</label>
								<div class="col-md-4">
									<?php echo $this->Form->input('paypal_business_email',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['paypal_business_email']:'', 'id'=>"paypal_business_email", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Paypal Business Email", 'type'=>"text")); ?>
								</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Paypal Mode<span class="required">* </span>
							</label>
							<div class="col-md-4">
								<?php
								echo $this->Form->input('paypal_mode', array(
										'options'=>$paypal_mode,
										'value'=>(!empty($data))?$data['SiteSetting']['paypal_mode']:'',
										'type'=>'radio',
										'data-error-container'=>'#customerror_div',
										'before' => '<label class="col-md-5">',
										'after' => '</label>',
										'separator' => '</label><label class="col-md-5">',
										'legend'=>false,
										'hiddenField'=>false
									)
								);
								?>
							</div>
						</div>
						<div class="form-group">
								<label class="control-label col-md-3">Eway Account No<span class="required">
								* </span>
								</label>
								<div class="col-md-4">
									<?php echo $this->Form->input('eway_account_id',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['eway_account_id']:'', 'id'=>"eway_account_id", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Eway Account No", 'type'=>"text")); ?>
								</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Eway Mode<span class="required">* </span>
							</label>
							<div class="col-md-4">
								<?php
								echo $this->Form->input('eway_mode', array(
										'options'=>$paypal_mode,
										'value'=>(!empty($data))?$data['SiteSetting']['eway_mode']:'',
										'type'=>'radio',
										'data-error-container'=>'#customerror_div',
										'before' => '<label class="col-md-5">',
										'after' => '</label>',
										'separator' => '</label><label class="col-md-5">',
										'legend'=>false,
										'hiddenField'=>false
									)
								);
								?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Payment method<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
									
									echo $this->Form->input('payment_method',
											array(
												'class' => 'form-control',
												'empty' => 'Select payment method',
												'options' => $payment_methods,
												'selected' => (isset($data['SiteSetting']))?$data['SiteSetting']['payment_method']:''
											)
									);
								?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Free Shipping<span class="required">* </span>
							</label>
							<div class="col-md-4">
								<?php
								echo $this->Form->input('free_shipping', array(
										'options'=>$freeshipping_Arr,
								'value'=>(!empty($data))?$data['SiteSetting']['free_shipping']:'',
										'type'=>'radio',
										'data-error-container'=>'#customerror_div',
										'before' => '<label class="col-md-5">',
										'after' => '</label>',
										'separator' => '</label><label class="col-md-5">',
										'legend'=>false,
										'hiddenField'=>false
									)
								);
								?>
							</div>
						</div>
						<?php if(!empty($data['SiteSetting']['free_shipping']) && $data['SiteSetting']['free_shipping']=='Y' ) { ?>
						<div class="form-group" id="shipval">
								<label class="control-label col-md-3">Amount<span class="required">
								* </span>
								</label>
								<div class="col-md-4">
									<?php echo $this->Form->input('amount',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['amount']:'', 'id'=>"amount", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Amount", 'type'=>"text")); ?>
								</div>
						</div>
						<?php }  if ($data['SiteSetting']['free_shipping']=='') { ?>
						<div class="form-group" id="shipval">
								<label class="control-label col-md-3">Amount<span class="required">
								* </span>
								</label>
								<div class="col-md-4">
									<?php echo $this->Form->input('amount',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['amount']:'', 'id'=>"amount", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Amount", 'type'=>"text")); ?>
								</div>
						</div>
						<?php } if($data['SiteSetting']['free_shipping']=='N') { ?>
						<div class="form-group" style="display:none" id="shipval">
								<label class="control-label col-md-3">Amount<span class="required">
								* </span>
								</label>
								<div class="col-md-4">
									<?php echo $this->Form->input('amount',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['amount']:'', 'id'=>"amount", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Amount", 'type'=>"text")); ?>
								</div>
						</div>
						
						<?php } ?>
						
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
			'data[SiteSetting][ecommerce_flag]': {
				required: true
			},
			'data[SiteSetting][currency]': {
				required: true
			},
			'data[SiteSetting][paypal_business_email]': {
				required: true,
				email:true
			},
			'data[SiteSetting][paypal_mode]': {
				required: true
			},
			'data[SiteSetting][eway_account_id]': {
				required: true
			},
			'data[SiteSetting][eway_mode]': {
				required: true
			},'data[SiteSetting][payment_method]': {
				required: true
			},'data[SiteSetting][free_shipping]': {
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

<script>
$('#SiteSettingFreeShippingY').click(function(){

$('#shipval').show();


})
	$('#SiteSettingFreeShippingN').click(function(){

	$('#shipval').hide();
	$('#amount').val('');

	})
</script>