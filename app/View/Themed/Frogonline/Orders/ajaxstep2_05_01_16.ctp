<?php
	//pr($data);
	//exit();
?>
<div class="panel-body row">
	<?php echo $this->Form->create('Order', array('id'=>"billingForm", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
	<div class="col-md-12" id="regmsgerr"></div>
	<div class="col-md-6 col-sm-6">
		<h3>Your Personal Details</h3>
		<div class="form-group">
			<label for="firstname">First Name <span class="require">*</span></label>
			<?php echo $this->Form->input('firstname', array('type'=>'text', 'class'=>'form-control')); ?>
		</div>
		<div class="form-group">
			<label for="lastname">Last Name <span class="require">*</span></label>
			<?php echo $this->Form->input('lastname', array('type'=>'text', 'class'=>'form-control')); ?>
		</div>
		<div class="form-group">
			<label for="email">E-Mail <span class="require">*</span></label>
			<?php echo $this->Form->input('email_id', array('type'=>'text', 'class'=>'form-control')); ?>
			<div id="emailmsgerr"></div>
		</div>
		<div class="form-group">
			<label for="telephone">Telephone <span class="require">*</span></label>
			<?php echo $this->Form->input('telephone', array('type'=>'text', 'class'=>'form-control')); ?>
		</div>
		<div class="form-group">
			<label for="fax">Fax</label>
			<?php echo $this->Form->input('fax', array('type'=>'text', 'class'=>'form-control')); ?>
		</div>
		
		<?php
		if(!empty($data)){
			if($data['checkout']['account']=='register'){
		?>
		<h3>Your Password</h3>
		<div class="form-group">
			<label for="password">Password <span class="require">*</span></label>
			<?php echo $this->Form->input('password', array('type'=>'password', 'id'=>'password', 'class'=>'form-control')); ?>
		</div>
		<div class="form-group">
			<label for="password-confirm">Password Confirm <span class="require">*</span></label>
			<?php echo $this->Form->input('password_confirm', array('type'=>'password', 'class'=>'form-control')); ?>
		</div>
		<?php 
			}
		} 
		?>
	</div>
	<div class="col-md-6 col-sm-6">
		<h3>Your Address</h3>
		<div class="form-group">
			<label for="company">Company</label>
			<?php echo $this->Form->input('company', array('type'=>'text', 'class'=>'form-control')); ?>
		</div>
		<div class="form-group">
			<label for="address1">Address 1 <span class="require">*</span></label>
			<?php echo $this->Form->input('address', array('type'=>'text', 'class'=>'form-control')); ?>
		</div>
		<div class="form-group">
			<label for="address2">Address 2</label>
			<?php echo $this->Form->input('address1', array('type'=>'text', 'class'=>'form-control')); ?>
		</div>
		<div class="form-group">
			<label for="country">Country <span class="require">*</span></label>
			<?php 
			echo $this->Form->input('country', array(
				'options'=>$countries, 
				'empty'=>' --- Please Select --- ',
				'class'=>'form-control input-sm',
				'data-url'=>$this->Html->url(array('controller'=>'Orders', 'action'=>'ajaxbillingstate', 'full_base'=>true)),
				'id'=>'billing_country'
				)
			); 
			?>
		</div>
		<div class="form-group" id="billing_state_div">
			<label for="region-state">Region/State <span class="require">*</span></label>
			<?php 
			echo $this->Form->input('state', array(
				'options'=>array(), 
				'empty'=>' --- Please Select --- ',
				'class'=>'form-control input-sm',
				'id'=>'billing_state1'
				)
			); 
			?>
		</div>
		<div class="form-group" id="billing_city_div">
			<label for="city">City </label>
			<?php echo $this->Form->input('city', array('type'=>'text', 'class'=>'form-control')); ?>
			
		</div>
		<div class="form-group">
			<label for="post-code">Post Code <span class="require">*</span></label>
			<?php echo $this->Form->input('postcode', array('type'=>'text', 'class'=>'form-control')); ?>
		</div>
	</div>
	<hr>
	<div class="col-md-12">
		<?php
		if(!empty($data)){
			if($data['checkout']['account']=='register'){
		?>
		<script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>
		<div class="form-group">
			<label>Captcha <span class="require">*</span></label>
			<div class="g-recaptcha" data-sitekey="<?php echo SITE_KEY; ?>"></div>
			<div id="claptchamsg"></div>
		</div>
		<div class="checkbox">
			<label>
				<?php echo $this->Form->checkbox('subscribe_nwlt', array('value'=>'1', 'hiddenField'=>false)); ?> I wish to subscribe to the newsletter.
			</label>
		</div>
		<?php 
			} 
		}
		?>
		<div class="checkbox">
			<label>
				<?php echo $this->Form->checkbox('sameas', array('value'=>'1', 'checked'=>true, 'hiddenField'=>false)); ?>  My delivery and billing addresses are the same.
			</label>
		</div>
		<?php 
			echo $this->Form->input('url',array('type'=>'hidden', 'id'=>'shippingaddressurl', 'value'=>$this->Html->url(array('controller'=>'Orders', 'action'=>'ajaxstep3', 'full_base'=>true))));
			echo $this->Form->input('mode',array('type'=>'hidden', 'id'=>'mode', 'value'=>$data['checkout']['account']));
			echo $this->Form->button('Continue', array('class'=>'btn btn-primary pull-right', 'type'=>'submit', 'data-toggle'=>'collapse', 'data-parent'=>'#checkout-page', 'data-target'=>'#payment-address-content')); 
		?>                  
	</div>
	<?php echo $this->Form->end(); ?>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
	Layout.initUniform();
	Checkout.init();
	Checkout.initBillingState();
	Checkout.initBillingCity();
});
</script>