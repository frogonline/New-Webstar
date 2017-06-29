<?php
class City extends AppModel {
	public $primaryKey = 'id';
	
	public $name = 'City'; 
	
	public $validate = array(
		'CountryID' => array('rule' => 'notEmpty','message'=>'Please select Country'),
		'StateID' => array('rule' => 'notEmpty','message'=>'Please select state'),
		'City' => array('rule' => 'notEmpty','message'=>'Please enter city'),
		
			'status' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please select status'
			),				
		
		);
	
	
	}
?>