<?php
class Coupon extends AppModel {
	public $primaryKey = 'id';
	
	public $name = 'Coupon'; 
	
	public $validate = array(
		'coupon_type' => array('rule' => 'notEmpty','message'=>'Please chose coupon type'),
		'code' => array('rule' => 'notEmpty','message'=>'Please enter coupon code'),
		'available_from' => array('rule' => 'notEmpty','message'=>'Please select available data from'),
		'available_to' => array('rule' => 'notEmpty','message'=>'Please select available data to'),
		'discount_amount' => array('rule' => 'notEmpty','message'=>'Please enter discount amount'),
		
			'status' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please select status'
			),				
		
		);
	
	
	}
?>