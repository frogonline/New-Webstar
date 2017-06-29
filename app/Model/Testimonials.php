<?php
class Testimonials extends AppModel {
	public $name = 'Testimonials'; 
	
	var $validate = array(
			'title' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please enter title'
			),
			'heading' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please enter heading'
			),
			'testimonial' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please enter testimonial'
			),
			'test_date' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please enter test_date'
			),
			'status' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please select status'
			)
		);
}
?>