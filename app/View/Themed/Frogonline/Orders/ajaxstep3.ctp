<?php
	//pr($data);
	//exit();
?>
<div class="panel-body row">
	<?php echo $this->Form->create('Order', array('id'=>"shippingForm", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
	<div class="col-md-6 col-sm-6">
		<div class="form-group">
			<label for="firstname-dd">First Name <span class="require">*</span></label>
			<!--<input type="text" id="firstname-dd" class="form-control">-->
			<?php echo $this->Form->input('ship_firstname', array('type'=>'text', 'class'=>'form-control','value'=>(!empty($data))?$data['Order']['firstname']:'')); ?>
		</div>
		<div class="form-group">
			<label for="lastname-dd">Last Name <span class="require">*</span></label>
			<?php echo $this->Form->input('ship_lastname', array('type'=>'text', 'class'=>'form-control','value'=>(!empty($data))?$data['Order']['lastname']:'')); ?>
		</div>
		<div class="form-group">
			<label for="email-dd">E-Mail <span class="require">*</span></label>
			<?php echo $this->Form->input('ship_email_id', array('type'=>'text', 'class'=>'form-control','value'=>(!empty($data))?$data['Order']['email_id']:'')); ?>
		</div>
		<div class="form-group">
			<label for="telephone-dd">Telephone <span class="require">*</span></label>
			<?php echo $this->Form->input('ship_telephone', array('type'=>'text', 'class'=>'form-control','value'=>(!empty($data))?$data['Order']['telephone']:'')); ?>
		</div>
		<div class="form-group">
			<label for="fax-dd">Fax</label>
			<?php echo $this->Form->input('ship_fax', array('type'=>'text', 'class'=>'form-control','value'=>(!empty($data))?$data['Order']['fax']:'')); ?>
		</div>
		<div class="form-group">
			<label for="company-dd">Company</label>
			<?php echo $this->Form->input('ship_company', array('type'=>'text', 'class'=>'form-control','value'=>(!empty($data))?$data['Order']['company']:'')); ?>
		</div>
	</div>
	<div class="col-md-6 col-sm-6">
		<div class="form-group">
			<label for="address1-dd">Address 1 <span class="require">*</span></label>
			<?php echo $this->Form->input('ship_address', array('type'=>'text', 'class'=>'form-control','value'=>(!empty($data))?$data['Order']['address']:'')); ?>
		</div>
		<div class="form-group">
			<label for="address2-dd">Address 2</label>
			<?php echo $this->Form->input('ship_address1', array('type'=>'text', 'class'=>'form-control','value'=>(!empty($data))?$data['Order']['address1']:'')); ?>
		</div>
		<div class="form-group">
			<label for="country-dd">Country <span class="require">*</span></label>
			<?php 
				echo $this->Form->input('ship_country', array(
						'options'=>$countries, 
						'empty'=>' --- Please Select --- ',
						'class'=>'form-control input-sm',
						'id'=>'shipping_country',
						'data-url'=>$this->Html->url(array('controller'=>'Orders', 'action'=>'ajaxshippingstate', 'full_base'=>true)),
						'selected'=>(!empty($data))?$data['Order']['country']:''
						)
					); 
			?>
		</div>
		<div class="form-group" id="shipping_state_div">
			<label for="region-state-dd">Region/State <span class="require">*</span></label>
			<?php 
				echo $this->Form->input('ship_state', array(
						'options'=>$states, 
						'empty'=>' --- Please Select --- ',
						'class'=>'form-control input-sm',
						'data-url'=>$this->Html->url(array('controller'=>'Orders', 'action'=>'ajaxshippingcity', 'full_base'=>true)),
						'id'=>'shipping_state1',
						'selected'=>(!empty($data))?$data['Order']['state']:''
						)
					); 
			?>
		</div>
		<div class="form-group" id="shiping_city_divuu">
			<label for="city-dd">City/Town <span class="require">*</span></label>
			<?php echo $this->Form->input('ship_city', array('type'=>'text', 'class'=>'form-control','value'=>(!empty($data))?$data['Order']['city']:'')); ?>
			
		</div>
		<div class="form-group">
			<label for="post-code-dd">Post Code <span class="require">*</span></label>
			<?php echo $this->Form->input('ship_postcode', array('type'=>'text', 'class'=>'form-control','value'=>(!empty($data))?$data['Order']['postcode']:'')); ?>
		</div>
	</div>
	<div class="col-md-12">
		<?php 
			echo $this->Form->input('url',array('type'=>'hidden', 'id'=>'shippingmethodurl', 'value'=>$this->Html->url(array('controller'=>'Orders', 'action'=>'ajaxstep4', 'full_base'=>true))));
			echo $this->Form->button('Continue', array('class'=>'btn btn-primary pull-right brown-bg', 'type'=>'submit', 'data-toggle'=>'collapse', 'data-parent'=>'#checkout-page', 'data-target'=>'#shipping-method-content')); 
		?>
	</div>
	<?php echo $this->Form->end(); ?>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
	Layout.initUniform();
	Checkout.init();
	Checkout.initShippingState();
	Checkout.initShippingCity();
});
</script>