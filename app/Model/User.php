<?php
class User extends AppModel {
	public $primaryKey = 'user_id';
	
	public $name = 'User'; 
	public $virtualFields = array(
		'name' => 'CONCAT(User.firstname," ",User.lastname)'
	);
	
	public $validate = array(
		'username' => array('rule' => 'notEmpty','message'=>'Please enter username'),
		'password' => array('rule' => 'notEmpty','message'=>'Please enter password'),
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
			'password' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please enter password',
					'on'=>'create'
			),							
			'email_id' => array(
				'email' => array(
					'rule' => array('email'),
					'message' => 'Please enter a valid email address'
				),
				'uniqueEmail' => array(
					'rule'=>'isUnique',
					'message' => 'This email id already exists.',
					'on'=>'create'
				)
			),
			'user_type' => array(
					'rule' => 'notEmpty',
					'allowEmpty' => false,
					'message' => 'Select user type'
			),
			'status' => array(
					'rule' => 'notEmpty',
					'allowEmpty' => false,
					'message' => 'Select status'
			)
		);
	
	
	}
?>