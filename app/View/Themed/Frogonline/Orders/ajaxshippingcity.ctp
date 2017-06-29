<label for="city">City <span class="require">*</span></label>
<?php 
echo $this->Form->input('ship_city', array(
	'options'=>$cities,
	'name'=>'data[Order][city]',
	'empty'=>' --- Please Select --- ',
	'class'=>'form-control input-sm',
	'id'=>'shipping_city',
	'label'=>false,
	'div'=>false
	)
); 
?>