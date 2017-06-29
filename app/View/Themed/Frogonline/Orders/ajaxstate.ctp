<label for="region-state">Region/State <span class="require">*</span></label>
<?php 
echo $this->Form->input('state', array(
	'options'=>$states,
	'name'=>'data[Order][state]',
	'data-url'=>$this->Html->url(array('controller'=>'Orders', 'action'=>'ajaxcity', 'full_base'=>true)),
	'empty'=>' --- Please Select --- ',
	'class'=>'form-control input-sm',
	'id'=>'billing_state',
	'label'=>false,
	'div'=>false
	)
); 
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	Checkout.initBillingCity();
});
</script>