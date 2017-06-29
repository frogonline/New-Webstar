<?php
class FaqCategory extends AppModel {
	public $name = 'FaqCategory'; 
	
	var $validate = array(
			'category' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please enter category'
			),
			'status' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please select status'
			)
		);
}
?>