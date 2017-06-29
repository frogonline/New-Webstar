<label for="region-state">Region/State <span class="require">*</span></label>
<?php 
echo $this->Form->input('ship_state', array(
	'options'=>$states,
	'name'=>'data[Order][state]',
	'data-url'=>$this->Html->url(array('controller'=>'Orders', 'action'=>'ajaxshippingcity', 'full_base'=>true)),
	'empty'=>' --- Please Select --- ',
	'class'=>'form-control input-sm',
	'id'=>'shipping_state',
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