<label>City <span class="require">*</span></label>
<?php 
echo $this->Form->input('city', array(
	'options'=>$cities, 
	'name'=>'data[Member][city]',
	'class'=>'form-control',
	'selected'=>(!empty($data))?$data['Member']['city']:'',
	'label'=>false,
	'div'=>false 
	)); 
?>