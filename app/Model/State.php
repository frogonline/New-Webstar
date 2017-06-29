<?php
class State extends AppModel {
	public $primaryKey = 'id';
	
	public $name = 'State'; 
	
	public $validate = array(
		'CountryID' => array('rule' => 'notEmpty','message'=>'Please select Country'),
		'State' => array('rule' => 'notEmpty','message'=>'Please enter state'),
		
			'status' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please select status'
			),				
		
		);
	
	
	}
?>