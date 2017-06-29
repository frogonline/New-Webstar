<?php
class AdsManagement extends AppModel {
	public $primaryKey = 'id';
	
	public $name = 'AdsManagement'; 
	
	public $validate = array(
		'title' => array('rule' => 'notEmpty','message'=>'Please enter title'),
		'type' => array('rule' => 'notEmpty','message'=>'Please select any type'),
		
			'status' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please select status'
			),				
		
		);
	
	
	}
?>