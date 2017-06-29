<?php
class GalleryManagement extends AppModel {
	public $primaryKey = 'id';
	
	public $name = 'GalleryManagement'; 
	
	public $hasMany = array(
        'GalleryImage' => array(
            'className' => 'GalleryImage'
        )
    );
	
	public $validate = array(
		'name' => array('rule' => 'notEmpty','message'=>'Please enter gallery name'),
		'title' => array('rule' => 'notEmpty','message'=>'Please enter gallery title'),
		'height' => array('rule' => 'notEmpty','message'=>'Please enter height'),
		'width' => array('rule' => 'notEmpty','message'=>'Please enter width'),
			'status' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please select status'
			),				
		
		);
	
	
	}
?>