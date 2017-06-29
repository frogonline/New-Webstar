<?php
class Menu extends AppModel {
	public $name = 'Menu';  
	public function getAdminMenuData(){
        
		$data = $this->find('all',
			array(
				'conditions'=>array(
					'is_active'=>'Y'
				)
			)
		);
		$arr = $this->getMenuArr($data);
		return $data;
    }
	
}