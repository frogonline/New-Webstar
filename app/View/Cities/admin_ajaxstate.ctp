<?php  
echo $this->Form->input('Cities.StateID',
		array(
			'options' => $states,
			'empty' => 'Select State',	
			'class' => 'form-control',
			'data-required' => '1',
			'label'=>false,
			'div'=>false
		)
	);
?>  

