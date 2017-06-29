<?php
//$paymentMethods = array('PAYPAL'=>'Paypal', 'EWAY'=>'Eway');
$siteSettings=$this->Session->read('siteSettings');
 if($siteSettings['SiteSetting']['payment_method']=='E'){
$paymentMethods = array('EWAY'=>'Eway');
}else {
$paymentMethods = array('PAYPAL'=>'Paypal');
} 
 
?>
<div class="panel-body row">
	<?php echo $this->Form->create('Order', array('id'=>"paymentmethodForm", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
	<div class="col-md-12 col-sm-12 col-xs-12">
		
		<div class="row radio-list">
			<?php 
				echo $this->Form->input('payment_method',
					array(
						'options'=>$paymentMethods,
						'data-error-container'=>'#pmntmthdradiomsg',
						'before' => '<label class="col-md-12 col-sm-12 col-xs-12">',
						'after' => '</label>',
						'separator' => '</label><label class="col-md-12 col-sm-12 col-xs-12">',
						'type'=>'radio',
						'class'=>'paymentMethod',
						'legend'=>false,
						'hiddenField'=>false
					)
				); 
			?>
			<p id="pmntmthdradiomsg"></p>
		</div>
	</div>
	<div id="ewayDiv" class="col-md-7 col-sm-7" style="display:none;">
		<div class="row">
		<div class="col-md-12">
			<h4>Credit Card No. : <span class="require">*</span></h4>
			<div class="form-group">
				<?php echo $this->Form->input('credit_cardno', array('type'=>'text', 'id'=>'creditCardNo', 'class'=>'form-control')); ?>
			</div>
		</div>
		<div class="col-md-6">
			<h4>CVV. : <span class="require">*</span></h4>
			<div class="form-group">
				<?php echo $this->Form->input('cvv_no', array('type'=>'text', 'class'=>'form-control')); ?>
			</div>
		</div>
		
		<div class="col-md-3">
			<h4>Expiry Date : <span class="require">*</span></h4>
			<div class="form-group">
				<?php 
				echo $this->Form->input('month', array(
					'options'=>$monthArr,
					'empty'=>'Month',
					'class'=>'form-control'
					)
				); 
				?>
			</div>
		</div>
		<div class="col-md-3">
			<h4>&nbsp;</h4>
			<div class="form-group">
				<?php 
				echo $this->Form->input('year', array(
					'options'=>$yearArr,
					'empty'=>'Year',
					'class'=>'form-control'
					)
				); 
				?>
			</div>
		</div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
	<?php 
		echo $this->Form->input('url',array('type'=>'hidden', 'id'=>'confirmordersurl', 'value'=>$this->Html->url(array('controller'=>'Orders', 'action'=>'ajaxstep6', 'full_base'=>true))));
		echo $this->Form->button('Continue', array('class'=>'btn btn-primary pull-right brown-bg mrgtop5', 'type'=>'submit', 'data-toggle'=>'collapse', 'data-parent'=>'#checkout-page', 'data-target'=>'#confirm-content')); 
		
		
	?> 
	</div>
	<?php echo $this->Form->end(); ?>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
	Layout.initUniform();
	Checkout.init();
});
</script>