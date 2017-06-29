<label for="city">City <span class="require">*</span></label>
<?php 
echo $this->Form->input('city', array(
	'options'=>$cities,
	'name'=>'data[Order][city]',
	'empty'=>' --- Please Select --- ',
	'class'=>'form-control input-sm',
	'id'=>'billing_city',
	'label'=>false,
	'div'=>false
	)
); 
?>