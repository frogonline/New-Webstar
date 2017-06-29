<?php
class Resource extends AppModel {
	public $name = 'Resource'; 
	var $validate = array(    'resource_name' => array(        'notempty' => array(           'rule' => '/^[A-Za-z0-9_-]+$/',            'message' => 'Only alphabets and numbers allowed',        )    ),);
}
?>