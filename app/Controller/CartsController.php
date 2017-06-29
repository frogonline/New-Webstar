<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');

class CartsController extends AppController {

	//public $name = 'Products';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('Product','ProductCategory', 'ProductOption', 'OptionValue', 'Cart', 'CartOption','ajaxFnCheckProductCount');
	public $paginate = array();

	public function beforeFilter() 
	{
		parent::beforeFilter();
		
		$this->Auth->allow('cart', 'showfullcart','FnUpdateCart');
		
		if(isset($this->request->params['users'])){
			$this->Security->requireSecure();			
		}
		$this->Security->blackHoleCallback = 'blackhole';
	}
    
	public function blackhole($type) {
	
		// handle errors.
	}	
	
	public function cart(){
		$this->theme = THEME_NAME;
		$this->layout = 'ecommerce_inner';
		
	}
	
	public function showfullcart(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
	}
	
	public function FnUpdateCart()
	{
	  $updatearr=array_combine($_POST['cartid'],$_POST['quantity']);
	  for($i=0;$i<=count($updatearr)-1;$i++)
	  {
	     $data['Cart']['id']=$_POST['cartid'][$i];
		 $data['Cart']['quantity']=$_POST['quantity'][$i];
		 $data['unit_price']=$data['Cart']['quantity']*$_POST['unit_price'][$i];
		 $data['Cart']['gross_price']=$data['unit_price'];
		 if($data['Cart']['quantity']==0)
		 {
		   $this->Cart->delete($data['Cart']['id']);
		 }
		 else
		 {
		    $this->Cart->save($data);
		 }
		
	  }
	  $this->redirect(array('controller'=>'Carts','action'=>'cart'));
	  
	  
	 // print_r($data);die();
	}
	
	public function ajaxFnCheckProductCount()
	{
	  print_r($_POST);die();
	}
	
	public function ajaxCoupon()
	{
	  //print_r($_POST);die();
	}
	
	
}
?>