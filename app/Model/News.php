<?php
App::uses('AuthComponent', 'Controller/Component');
class News extends AppModel 
{
	public $name = 'News'; 
	
	
	public $validate = array(
	
		'news_title' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please supply news Title'
				),
		'news_desc' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please supply news Description'
				),
		'news_status' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please supply news Description'
				),
		'sort_order' => array(
					'rule' => 'notEmpty', 
					'allowEmpty' => false,
					'message'=>'Please supply news Description'
				)
		
	); 
	/* public function chkImageExtension($data) {
       $return = true; 

       if($data['news_image']['name'] != ''){
            $fileData   = pathinfo($data['news_image']['name']);
            $ext        = $fileData['extension'];
            $allowExtension = array('gif', 'jpeg', 'png', 'jpg');

            if(in_array($ext, $allowExtension)) {
                $return = true; 
            } else {
                $return = false;
            }   
        } else {
            $return = false; 
        }   

        return $return;
    }    */

}