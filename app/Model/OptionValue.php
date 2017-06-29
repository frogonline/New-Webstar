<?php
class OptionValue extends AppModel {
	public $name = 'OptionValue';  
	public $validate = array(
		'option_value_name' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please supply options value'
				),
		'option_sort_order' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please supply sort order'
				)
		
	);
}
?>