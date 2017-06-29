<?php
class ProductCategoriesHelper extends AppHelper {
	var $helpers = array('Cache','Html','Session','Form','Paginator');
	
	public function category($req = '') {
        App::import('Model', 'ProductCategory');
		$product = new ProductCategory();
		$m = $product->buildCategory();
		
		if($req!=''){
			$reqArr = explode(',',$req);
		} else {
			$reqArr = array();
		}
		$str = $this->buildDiv($m, $reqArr);
		return $str;
		//return $m;
    }
	
	private function buildDiv($arr, $reqArr, $c=0){
		$str = '';
		foreach($arr as $item){
			$str .=  '<div class="col-md-12" style="padding:0 0 5px 0;">';
			$str .= ($c!=0)?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':'';
			$str .=  $this->Form->checkbox('product_categoryid', array('hiddenField' => false, 'class'=>'checkboxes', 'name'=>'data[Product][product_categoryid][]', 'value'=>$item['id'], 'checked'=>(in_array($item['id'],$reqArr))?true:false ));
			$str .=  $item['name'];
			$str .=  '</div>';
			if(array_key_exists('child',$item)){
				$i = $c+1;
				$str .= $this->buildDiv($item['child'], $reqArr, $i);
			}
		}
		return $str;
	}
}
?>

