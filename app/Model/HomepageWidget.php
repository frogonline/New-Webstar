<?php
class HomepageWidget extends AppModel {
	public $name = 'HomepageWidget';  
	public $validate = array(
	
		'title' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please supply Homepage Widget Title'
				),
		'short_desc' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please supply banner text'
				),
		
		'status' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please supply banner status'
				),
		
		
	);
}
?>