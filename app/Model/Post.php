<?php
class Post extends AppModel {
	public $name = 'Post'; 
	//public $useTable = 'Page';
	public $validate = array(
		'title' => array(
			'notEmpty' => array(
			'rule' => array('notEmpty'),
			'message' => "You must specify your title.",
			),
		),
	); 
}
?>