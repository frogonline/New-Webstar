<?php
class Country extends AppModel {
	public $primaryKey = 'id';
	
	public $name = 'Country'; 
	
	public $validate = array(
		'Country' => array('rule' => 'notEmpty','message'=>'Please enter Country'),
		'code' => array('rule' => 'notEmpty','message'=>'Please enter country code'),
		
			'status' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please select status'
			),				
		
		);
	
	
	}
?>