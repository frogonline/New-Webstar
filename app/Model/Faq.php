<?php
class Faq extends AppModel {
	public $name = 'Faq'; 
	
	var $validate = array(
			'category_id' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please select category'
			),
			'faq_questions' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please enter questions'
			),
			'faq_answers' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please enter answers'
			),
			'sort_order' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please enter sort_order'
			),
			'status' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please select status'
			)
		);
}
?>