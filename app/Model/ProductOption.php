<?php
class ProductOption extends AppModel {
	public $name = 'ProductOption';  
	public $validate = array(
		'options_name' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please supply options name'
				),
		'sort_order' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please supply sort order'
				)
	);
}
?>