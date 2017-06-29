<?php
class Member extends AppModel {
	
	public $name = 'Member'; 
	public $virtualFields = array(
		'name' => 'CONCAT(Member.firstname," ",Member.lastname)'
	);
	
	var $validate = array(
			'firstname' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please enter firstname'
			),
			'lastname' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please enter lastname'
			),
			'username' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please enter username'
			),
			'email_id' => array(
						'email' => array(
							'rule' => array('email'),
							'message' => 'Please enter a valid email address'
						),
						'uniqueEmail' => array(
							'rule'=>'isUnique',
							'message' => 'This email id already exists.'
					)
			),
			'password' => array(
						'rule' => 'notEmpty',
						'allowEmpty' => false,
						'on' => 'create',
						'message' => 'Please enter password'		
				),
			'type' => array(
						'rule' => 'notEmpty',
						'allowEmpty' => false,
						'message' => 'Select member type'
				),
			'status' => array(
						'rule' => 'notEmpty',
						'allowEmpty' => false,
						'message' => 'Select status'
				)
		);
	

}
?>