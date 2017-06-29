<label for="region-state">Region/State <span class="require">*</span></label>
<?php 
echo $this->Form->input('state', array(
	'options'=>$states,
	'name'=>'data[Order][state]',
	'data-url'=>$this->Html->url(array('controller'=>'Orders', 'action'=>'ajaxbillingcity', 'full_base'=>true)),
	'empty'=>' --- Please Select --- ',
	'class'=>'form-control input-sm',
	'id'=>'billing_state1',
	'label'=>false,
	'div'=>false
	)
); 
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	Checkout.initShippingCity();
});
</script>
<script type="text/javascript">
jQuery(document).ready(function() {
	Checkout.initBillingCity();
});
</script>