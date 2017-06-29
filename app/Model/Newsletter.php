<?php
class Newsletter extends AppModel {
	
	public $name = 'Newsletter'; 
	
	var $validate = array(
			'subject' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please enter subject'
			),
			'newsletter' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please enter newsletter'
			),
			'status' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please select status'
			)
		);

}

?>