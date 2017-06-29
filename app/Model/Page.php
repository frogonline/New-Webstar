<?php
class Page extends AppModel {
	public $name = 'Page'; 
		
	public $validate = array(
        'title' => array(
			'title_notEmpty'=>array(
				'rule' => 'notEmpty',
				'message' => 'This field is required'
			)
		),
		'metatitle' => array(
			'metatitle_notEmpty'=>array(
				'rule' => 'notEmpty',
				'message' => 'This field is required'
			)
		),
		'metakeywords' => array(
			'metakeywords_notEmpty'=>array(
				'rule' => 'notEmpty',
				'message' => 'This field is required'
			)
		),
		'metadescription' => array(
			'metadescription_notEmpty'=>array(
				'rule' => 'notEmpty',
				'message' => 'This field is required'
			)
		),
		'categoryid' => array(
			'categoryid_notEmpty'=>array(
				'rule' => 'notEmpty',
				'message' => 'This field is required'
			)
		)
    );
}
?>