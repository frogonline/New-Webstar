<?php
class ProductCategory extends AppModel {
	public $name = 'ProductCategory';  
	public $actsAs = array('Tree'); 
	
	public function buildCategory( $pid = 0){
		$arr = array();
		$categories = $this->find('all',array('conditions'=>array('ProductCategory.is_del'=>'0', 'ProductCategory.category_status'=>'Y', 'ProductCategory.parent_id'=>$pid), 'fields'=>array('id','parent_id','name')));
		
		$i = 0;
		foreach($categories as $rc){
			$arr[$i] = $rc['ProductCategory'];
			if($this->hasChild($rc['ProductCategory']['id'])){
				$arr[$i]['child'] = $this->buildCategory($rc['ProductCategory']['id']);
			}
			$i++;
		}
		return $arr;
		//return $categories;
	}
	
	private function hasChild($pid){
		$count = $this->find('count',array('conditions'=>array('ProductCategory.is_del'=>0, 'ProductCategory.category_status'=>'Y', 'ProductCategory.parent_id'=>$pid)));
		if($count > 0){
			return true;
		} else {
			return false;
		}
		
	}
}
?>