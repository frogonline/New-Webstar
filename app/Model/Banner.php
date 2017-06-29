<?php
class Banner extends AppModel {
	public $name = 'Banner';  
	public $validate = array(
	
		'banner_name' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please supply banner name'
				),
		'banner_text' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please supply banner text'
				),
		'banner_link' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please supply banner link'
				),
		'banner_status' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please supply banner status'
				),
		
		
	);
}
?>