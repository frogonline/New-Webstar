<label for="city" class="col-lg-4 control-label">City <span class="require">*</span></label>
<div class="col-lg-8">
<?php 
echo $this->Form->input('city', array(
	'options'=>$cities,
	'name'=>'data[Member][city]',
	'empty'=>' --- Please Select --- ',
	'class'=>'form-control',
	'id'=>'register_city',
	'label'=>false,
	'div'=>false
	)
); 
?>
</div>