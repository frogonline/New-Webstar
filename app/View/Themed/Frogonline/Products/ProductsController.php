<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');

class ProductsController extends AppController {

	//public $name = 'Products';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('Product','ProductCategory', 'ProductAssignOption', 'ProductGallery', 'ProductOption', 'OptionValue', 'ProductAssignCrossproduct', 'Cart', 'CartOption','FooterBlock','ProductShippingValue','CatalogProduct', 'Wishlist');
	public $paginate = array();

	public function beforeFilter() 
	{
		parent::beforeFilter();
		$this->Auth->allow('home','products','productssl','productssr','ajaxproductlist', 'ajaxproductlist3c', 'ajaxaddtowishlist', 'productcount', 'ajaxproductpopup','productdetails','ajaxReview','ajaxminicart','showminicart','ajaxremoveminicart','showcorexminicart','search','admin_getListProduct','admin_getListProduct1','mycatalog','catalogdetail','admin_priceupdate','admin_sequenceupdate');
		
		if(isset($this->request->params['users'])){
			$this->Security->requireSecure();			
		}
		$this->Security->blackHoleCallback = 'blackhole';
	}
    
	public function blackhole($type) {
	
		// handle errors.
	}	
	
	public function admin_index()
	{
		$this->layout = 'adminInner';
		$this->loadModel('ProductCategory');
		$categories = $this->ProductCategory->generateTreeList(null, null, null, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
		$this->set(compact('categories')); 
		$categoriesArr = 	ClassRegistry::init("ProductCategory")->find('list', array(
																'fields' => array('ProductCategory.id','ProductCategory.name')
																));
		$this->set(compact('categoriesArr')); 
		if($this->request->is("post"))
		{
			$data = $this->request->data;
			
			$likekeyArr = array('product_name','product_sku');
			$datekeyArr = array('created_date');
			$conditionArr = array();
			foreach($data['Product'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['Product.'.$k.' LIKE'] = '%'.$v.'%';
					} 
					else if(in_array($k,$datekeyArr)){
							$conditionArr['Product.'.$k] = date('Y-m-d',strtotime($v)); 
						}
					else {
							$conditionArr['Product.'.$k] = $v; 
					}
				}
			}
			
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Product.id' => 'DESC')
			);
			//pr($conditionArr);
			$this->set('searchData',$data);
			
		}  else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					
					'order'=>array('Product.id' => 'DESC')
					);
			
		}
		$data=$this->paginate('Product');
		//pr($data); exit;
		$this->set('data', $data);
	}
	
	public function admin_manage($id=NULL){	
		$this->layout = 'adminInner';
		
		/******* Add and Edit Product *******/
		if($this->request->is('post')){	
			if($this->Product->validates()){
				$data = $this->request->data;
				
				if(array_key_exists('product_categoryid',$data['Product'])){
					$data['Product']['product_categoryid'] = implode(',',$data['Product']['product_categoryid']);
				}
				
				if($id!=NULL){
					$data['Product']['modified_date'] = date("Y-m-d");
					$this->Product->id = $id;
				} else {
					$data['Product']['created_date'] = date("Y-m-d");
					$slugArr = array('controller_name'=>'Products','action_name'=>'productdetails');
					$data['Product']['product_slug']=AppController::get_slug($data['Product']['product_name'],$slugArr);
					$this->Product->create();
				}
				
				
				$data['Product']['onsale_flag'] = (array_key_exists('onsale_flag',$data['Product']))?$data['Product']['onsale_flag']:'FALSE';
				$data['Product']['featured_flag'] = (array_key_exists('featured_flag',$data['Product']))?$data['Product']['featured_flag']:'FALSE';
				$data['Product']['newcollection_flag'] = (array_key_exists('newcollection_flag',$data['Product']))?$data['Product']['newcollection_flag']:'FALSE';
				$data['Product']['stock_flag'] = (array_key_exists('stock_flag',$data['Product']))?$data['Product']['stock_flag']:'FALSE';
				//pr($data); exit();
				if(!empty($data['Product']['product_image']['name']))
				{
					list($file1,$error1,$update_field1) = AppController::upload($data['Product']['product_image'],UPLOADS_FOLDER. DS .'product_image'. DS.'original'. DS ,'jpg,jpeg,JPG,JPEG,gif,GIF,png,PNG');
					
					if($error1 == ""){
					$image	=	new SimpleImage();
					$image->load(UPLOADS_FOLDER . DS .'product_image'. DS .'original'. DS .$file1); // original image path
					$image_size=AppController::resize_to_save(UPLOADS_FOLDER . DS .'product_image'. DS .'original'. DS .$file1,560,480); // get small image size to be saved in
					$image->resize($image_size['0'],$image_size['1']); // image size to be saved in
					$image->save(UPLOADS_FOLDER . DS .'product_image'. DS . "resize". DS .$file1); // small image
					
					$thumb	=	new SimpleImage();
					
					$thumb->load(UPLOADS_FOLDER . DS .'product_image'. DS .'original'. DS .$file1); // original image path
					$image_size=AppController::resize_to_save(UPLOADS_FOLDER . DS .'product_image'. DS .'original'. DS .$file1,160,145); // get small image size to be saved in
					$thumb->resize($image_size['0'],$image_size['1']); // image size to be saved in
					$thumb->save(UPLOADS_FOLDER . DS .'product_image'. DS . "thumb". DS .$file1); // small image
					
					$data['Product']['product_image'] = $file1;
					}
					else{
						$data['Product']['product_image'] = "";
					}
				} else if (!empty($data['Product']['set_product_image'])){
					$data['Product']['product_image'] = $data['Product']['set_product_image'];
				}
				
				if(empty($data['Product']['product_weight']) || $data['Product']['product_weight'] == '' || $data['Product']['product_weight'] == null) {
					$data['Product']['product_weight'] = '0.00';
				}
				$saveFlag = $this->Product->save($data);
				$saveId = $this->Product->id;
				
				if($saveFlag){
					if($id!=NULL){
						$product_id = $id;
					} else {
						$product_id = $this->Product->id;
					}
					
					//Cross Selling Product Entry
					if($data['Product']['crosssellid'] != $data['Product']['set_crosssellid']){
						$str = $data['Product']['crosssellid'];
						$prdsArr = explode(",",$str);
						
						$delFlag = $this->ProductAssignCrossproduct->deleteAll(array('ProductAssignCrossproduct.product_id'=>$product_id));
						
						if($delFlag){
							
							foreach($prdsArr as $prdAsig){
								$saveAssignPrd['ProductAssignCrossproduct']['product_id'] = $product_id;
								if(is_numeric($prdAsig)){
									$saveAssignPrd['ProductAssignCrossproduct']['crossproduct_id'] = $prdAsig;
								} else {
									$productData = $this->Product->findByProductName($prdAsig);
									if(!empty($productData)){
										$saveAssignPrd['ProductAssignCrossproduct']['crossproduct_id'] = $productData['Product']['id'];
									}
								}
								
								if(!empty($saveAssignPrd['ProductAssignCrossproduct']['crossproduct_id'])){
									$this->ProductAssignCrossproduct->create();
									$saveAssignFl = $this->ProductAssignCrossproduct->save($saveAssignPrd);
								}
								$saveAssignPrd = array();
							}
						}
						
					}
					
					//Product Option Add And Update
					
					if($option = array_filter($data['ProductAssignOption']['option_value_id'])){
						//$c = 0;
						
						foreach($option as $key=>$val){
							foreach($val as $ov){
								$cnt = $this->ProductAssignOption->find('count', array(
										'conditions'=>array(
											'ProductAssignOption.product_id'=>$product_id,
											'ProductAssignOption.option_id'=>$key,
											'ProductAssignOption.option_value_id'=>$ov,
											)
									)
								);
								
								if($cnt == 0) {
								
									$saveArr['ProductAssignOption']['product_id'] = $product_id;
									$saveArr['ProductAssignOption']['option_id'] = $key;
									$saveArr['ProductAssignOption']['option_value_id'] = $ov;
									$this->ProductAssignOption->create();
									if(array_key_exists('id', $data['ProductAssignOption'])){
										if(!empty($data['ProductAssignOption']['id'][$key])){
											$this->ProductAssignOption->id = $data['ProductAssignOption']['id'][$key];
										} else {
											$this->ProductAssignOption->create();
										}
									} else {
										
									}
									$this->ProductAssignOption->save($saveArr);
								} else {
									$assignoption = $this->ProductAssignOption->findByProductIdAndOptionIdAndOptionValueId($product_id,$key,$ov);
									$data['ProductAssignOption']['id'] = array_diff($data['ProductAssignOption']['id'],$assignoption['ProductAssignOption']);
									//continue;
								}
							}
						}
						
						if(!empty($data['ProductAssignOption']['id'])){
							foreach($data['ProductAssignOption']['id'] as $assignoptid){
								$this->ProductAssignOption->delete($assignoptid);
							}
						}
					} else {
						if(!empty($id)){
							$delFlag = $this->ProductAssignOption->deleteAll(array('ProductAssignOption.product_id'=>$product_id));
							if($delFlag){
								$this->Session->setFlash('Product updated successfully', 'default', array('class' => 'alert alert-success'));
							} else {
								$this->Session->setFlash('Failed to updated product option', 'default', array('class' => 'alert alert-danger'));
								$this->redirect(array('controller'=>'Products','action'=>'admin_index'));
							}
						}
						
					}
					
					//Product Gallery Add
					if(!empty($data['ProductGallery']['image_name'][0]['name'])){
						//$c = 0;
						foreach($data['ProductGallery']['image_name'] as $gallery){
							list($file1,$error1,$update_field1) = AppController::upload($gallery,UPLOADS_FOLDER. DS .'product_gallery'. DS.'original'. DS ,'jpg,jpeg,JPG,JPEG,gif,GIF,png,PNG');
					
							if($error1 == ""){
								$image	=	new SimpleImage();
								$image->load(UPLOADS_FOLDER . DS .'product_gallery'. DS .'original'. DS .$file1); // original image path
								$image_size=AppController::resize_to_save(UPLOADS_FOLDER . DS .'product_gallery'. DS .'original'. DS .$file1,560,480); // get small image size to be saved in
								$image->resize($image_size['0'],$image_size['1']); // image size to be saved in
								$image->save(UPLOADS_FOLDER . DS .'product_gallery'. DS . "resize". DS .$file1); // small image
								
								$thumb	=	new SimpleImage();
								
								$thumb->load(UPLOADS_FOLDER . DS .'product_gallery'. DS .'original'. DS .$file1); // original image path
								$image_size=AppController::resize_to_save(UPLOADS_FOLDER . DS .'product_gallery'. DS .'original'. DS .$file1,160,145); // get small image size to be saved in
								$thumb->resize($image_size['0'],$image_size['1']); // image size to be saved in
								$thumb->save(UPLOADS_FOLDER . DS .'product_gallery'. DS . "thumb". DS .$file1); // small image
							
								$saveArr['ProductGallery']['image_name'] = $file1;
								$saveArr['ProductGallery']['product_id'] = $product_id;
								$this->ProductGallery->create();
								$this->ProductGallery->save($saveArr);
							}
							else{
								$this->Session->setFlash('Failed to upload product other images', 'default', array('class' => 'alert alert-danger'));
								$this->redirect(array('controller'=>'Products','action'=>'admin_index'));
							}
							
						}
					}
					
					if(!empty($data['ProductShippingValue']))
					{
						$productshippingvalueArr=array();
						if(!empty($data['ProductShippingValue']['id']))
						{
						$productshippingvalueArr['ProductShippingValue']['id']=$data['ProductShippingValue']['id'];
						$productshippingvalueArr['ProductShippingValue']['product_id']=$id;
						}
						else
						{
						$this->ProductShippingValue->create();
						$productshippingvalueArr['ProductShippingValue']['product_id']=$this->Product->id;
						}
						
						$productshippingvalueArr['ProductShippingValue']['VIC']=$data['ProductShippingValue']['VIC'];
						$productshippingvalueArr['ProductShippingValue']['NT']=$data['ProductShippingValue']['NT'];
						$productshippingvalueArr['ProductShippingValue']['QLD']=$data['ProductShippingValue']['QLD'];
						$productshippingvalueArr['ProductShippingValue']['NSW']=$data['ProductShippingValue']['NSW'];
						$productshippingvalueArr['ProductShippingValue']['TAS']=$data['ProductShippingValue']['TAS'];
						$productshippingvalueArr['ProductShippingValue']['WA']=$data['ProductShippingValue']['WA'];
						$productshippingvalueArr['ProductShippingValue']['SA']=$data['ProductShippingValue']['SA'];
						
						$this->ProductShippingValue->save($productshippingvalueArr);
					}
					
					if(!empty($id)){
						$this->Session->setFlash('Product updated successfully!', 'default', array('class' => 'alert alert-success'));
					} else {
						$this->Session->setFlash('Product added successfully!', 'default', array('class' => 'alert alert-success'));
					}
					//$this->redirect(array('controller'=>'Products','action'=>'admin_index'));
					
				} else {
					$this->Session->setFlash('Failed to add product', 'default', array('class' => 'alert alert-danger'));
				}
				if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'Products','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'Products','action'=>'admin_index'));
				}
				//$this->redirect(array('controller'=>'Products','action'=>'admin_index'));
			} else {
				$this->set('errors', $this->Product->invalidFields());
			}
		}
		/******* Add and Edit Product *******/
		
		/****** Fetching Data For View Product ******/
		//Set Data For Edit
		if($id != NULL || $id !== '')
		{
			$this->Product->bindModel(array(
								'hasMany' => array(
									'ProductGallery' => array(
										'className'    => 'ProductGallery',
										'foreignKey'   => 'product_id'
									),
									'ProductAssignOption' => array(
										'className'    => 'ProductAssignOption',
										'foreignKey'   => 'product_id'
									),
									'ProductShippingValue' => array(
										'className'    => 'ProductShippingValue',
										'foreignKey'   => 'product_id'
									)
								)
							));
			$data = $this->Product->findById($id);
			
			$this->loadModel('ProductAssignCrossproduct');
			$prdassignidArr = $this->ProductAssignCrossproduct->find('list', array(
								'conditions'=>array('ProductAssignCrossproduct.product_id'=>$id),
								'fields'=>array('ProductAssignCrossproduct.id','ProductAssignCrossproduct.crossproduct_id')
								)
							);
							
			$prdAssignIDString = implode(",",$prdassignidArr);
			
			
			$prd=$this->Product->find('list', array(
											'conditions'=>array(
												'Product.isdel'=>'0',
												'Product.id !='=>$id,
											),
											'fields'=>array('id','product_name'),
											) 
										);
			$prdArr = array();
			if(!empty($prd)){
				$i=0;
				foreach($prd as $k=>$v){
					$prdArr[$i]['id'] = $k;
					$prdArr[$i]['text'] = $v;
					$i++;
				}
			}
			$prdString = json_encode($prdArr);
			
			$this->set('data', $data);
		} else {
			$prdAssignIDString = "";
			
			$prd=$this->Product->find('list', array(
											'conditions'=>array('Product.isdel'=>'0'),
											'fields'=>array('id','product_name'),
											) 
										);
			$prdArr = array();
			if(!empty($prd)){
				$i=0;
				foreach($prd as $k=>$v){
					$prdArr[$i]['id'] = $k;
					$prdArr[$i]['text'] = $v;
					$i++;
				}
			}
			$prdString = json_encode($prdArr);
		}
		
		
		
		$options = $this->getProductOptions();
		$this->set(compact('id', 'options', 'prdString', 'prdAssignIDString'));
		 
		/****** Fetching Data For View Product ******/
	}
	
	private function getProductOptions(){
		$data = $this->ProductOption->find('all',
			array(
				'conditions'=>array('ProductOption.is_del'=>0, 'ProductOption.options_status'=>'Y'),
				'fields'=>array('ProductOption.id','ProductOption.options_name'),
				'order'=> array('ProductOption.sort_order ASC')
			)
		);
		
		$i = 0;
		foreach ($data as $opt){
			$values = $this->OptionValue->find('list',
				array(
					'conditions'=>array('OptionValue.is_del'=>0, 'OptionValue.option_id'=>$opt['ProductOption']['id']),
					'fields'=>array('OptionValue.id','OptionValue.option_value_name'),
					'order'=> array('OptionValue.option_sort_order ASC')
				)
			);
			$data[$i]['ProductOption']['values'] = $values;
			$i++;
		}
		return $data;
	}
	
	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Product']['isdel'] = $isdel; 
		$this->Product->id = $id;
		$this->Product->save($data);
		$this->Session->setFlash('<p>Product details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Product']['product_status'] = $stat;
		
		$this->Product->id = $id;
		$updateFlag = $this->Product->save($data);
		
		if($updateFlag){
			$this->Session->setFlash('Product status changed successfully!', 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('Failed to change status!', 'default', array('class' => 'alert alert-danger'));
		}
		$this->redirect($this->referer());
	}
	
	public function admin_restore ($id=NULL, $isdel='1')	{		
	$this->layout = '';	
	$this->autoRender = false;		
	$data['Product']['isdel'] = $isdel; 		
	$this->Product->id = $id;		
	$this->Product->save($data);	
	$this->Session->setFlash('<p>Product details has been restore successfully!</p>', 'default', array('class' => 'alert alert-success'));		
	$this->redirect($this->referer());	
	}

	public function admin_restoreAll($idAll=NULL, $isdel='0')	{	
	$idArr = explode(',',$idAll);	
	$this->layout = '';		
	$this->autoRender = false;			
	foreach($idArr as $id){		
	$data = $this->Product->findById($id);		
	$data['Product']['isdel'] = $isdel; 		
	$this->Product->id = $id;			
	$restoreFlag = $this->Product->save($data);				
	if($restoreFlag){			
	$this->Session->setFlash('Product Restore Successfully!', 'default', array('class' => 'alert alert-success'));
	} else {
	$this->Session->setFlash('Failed to Restore Products!', 'default', array('class' => 'alert alert-danger'));				
	break;			
	}		
	}		
	$this->redirect($this->referer());		
	}	
	
	public function admin_exportproducts($idAll=NULL, $isdel='1')
	{	
		//pr($id); exit();
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		$productArr = $this->product_export($idArr);
		
		//pr($productArr); exit();
		
		$this->download_send_headers("data_export_" . date("Y-m-d") . ".csv");
		echo $this->array2csv($productArr);
		die();
		
		$this->redirect($this->referer());	
	}
	
	private function product_export($idArr){
		if(!empty($idArr)){
			$data = $this->Product->find('all', array(
					'conditions'=>array(
						'Product.id IN'=>$idArr
					)
				)
			);
			
			if(!empty($data)){
				$i = 0;
				foreach($data as $product){
					foreach($product['Product'] as $k=>$v){
						if($k=="product_categoryid"){
							$categoryArr = explode(",", $v);
							if(count($categoryArr)==1){
								$catData = $this->ProductCategory->find('list', array(
										'conditions'=>array(
											'ProductCategory.id'=>$v
										),
										'fields'=>array(
											'ProductCategory.id','ProductCategory.categories_slug',
										)
									)
								);
								
							} else {
								$catData = $this->ProductCategory->find('list', array(
										'conditions'=>array(
											'ProductCategory.id IN'=>$categoryArr
										),
										'fields'=>array(
											'id','ProductCategory.categories_slug',
										)
									)
								);
							}
							//return $catData;
							$data[$i]['Product'][$k] = implode(",", $catData);
						}
					}
					$i++;
				}
			}
			return $data;
		}
	}
	
	private function array2csv($array)
	{
	   if (count($array) == 0) {
		 return null;
	   }
	   ob_start();
	   $df = fopen("php://output", 'w');
	   $key = array_keys($this->Product->schema());
	   fputcsv($df, $key);
	   foreach ($array as $row) {
		  fputcsv($df, $row['Product']);
	   }
	   fclose($df);
	   return ob_get_clean();
	}

	private function download_send_headers($filename) {
		// disable caching
		$now = gmdate("D, d M Y H:i:s");
		header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
		header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
		header("Last-Modified: {$now} GMT");

		// force download  
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");

		// disposition / encoding on response body
		header("Content-Disposition: attachment;filename={$filename}");
		header("Content-Transfer-Encoding: binary");
	}
	
	public function admin_importdata(){
		if($this->request->is('post')){
			$data = $this->request->data;
			
			$arr = explode(".", $data['Product']['csv']['name']);
			$ext = strtolower(end($arr));
			if($ext != "csv"){
				$this->Session->setFlash('Please upload csv file only', 'default', array('class' => 'alert alert-danger'));
				$this->redirect(array('controller'=>'Products', 'action'=>'admin_index'));
				exit();
			}
			/******** Initialization ********/
			$handle = fopen($data['Product']['csv']['tmp_name'], "r");
			$c = 1;
			$saveArr['Product'] = array();
			//$categoryArr = array('T'=>'theme attraction','A'=>'hotel','P'=>'restaurant');
			$keyArr = array_keys($this->Product->schema());
			$failedIdArr = array();
			//pr($keyArr); exit();
			/******** Initialization ********/
			
			
			while (($csvdata = fgetcsv($handle, 1000, ",")) !== FALSE) {
				//pr($csvdata);
				if($c > 1){
					foreach($csvdata as $k=>$v){
						if($k==0){
							continue;
						}
						$key = $keyArr[$k];
						switch($key){
							case "product_slug":
								if($v!=""){
									$slugArr = array('controller_name'=>'Products','action_name'=>'productdetails');
									$saveArr['Product']['product_slug']=AppController::get_slug($v,$slugArr);
								}
								break;
							case "product_categoryid":
								if(!empty($v)){
									$categories = explode(",", $v);
									$catIdArr = array();
									foreach($categories as $category){
										$catData = $this->ProductCategory->findByCategoriesSlug($category);
										if(!empty($catData)){
											array_push($catIdArr, $catData['ProductCategory']['id']);
										} else {
											array_push($failedIdArr, $csvdata[0]);
										}
									}
									$saveArr['Product'][$key] = implode(",", $catIdArr);
								}
								break;
							default:
								if($v!=""){
									$saveArr['Product'][$key] = $v;
								}
								break;	
						}
						
					}
					$saveArr['Product']['created_date'] = date("Y-m-d");				
					if(!empty($saveArr['Product'])){
						if(!in_array($csvdata[0], $failedIdArr)){
							$this->Product->create();
							$this->Product->save($saveArr);
						}
					}
				}
				
				$c++;
				$saveArr['Product'] = array();
			}
			//exit();
			$this->Session->setFlash('Data successfully imported', 'default', array('class' => 'alert alert-success'));
			if(!empty($failedIdArr)){
				$this->Session->setFlash('Failed to upload the product with id : '.implode(",", $failedIdArr), 'default', array('class' => 'alert alert-danger'), 'FailedImport');
			}
			$this->redirect(array('controller'=>'Products', 'action'=>'admin_index'));
		} else {
			$this->Session->setFlash('Failed to import data', 'default', array('class' => 'alert alert-danger'));
			$this->redirect(array('controller'=>'Products', 'action'=>'admin_index'));
		}
	}
	
	public function admin_deleteAll($idAll=NULL, $isdel='1')
	{	
		//pr($id); exit();
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->Product->findById($id);
			$data['Product']['isdel'] = $isdel; 
			$this->Product->id = $id;
			$deleteFlag = $this->Product->save($data);
			
			if($deleteFlag){
				$this->Session->setFlash('The Product has been successfully removed!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete the Product!', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
		
	public function admin_imgdelete( )
	{
		$data=$this->request->params['named'];
		//pr($data);exit();
		if($data['id']){
			$original_path=UPLOADS_FOLDER . DS .'product_image'. DS.'original'. DS .$data['image_name'];
			$resize_path=UPLOADS_FOLDER . DS .'product_image'. DS.'resize'. DS .$data['image_name'];
			$thumb_path=UPLOADS_FOLDER . DS .'product_image'. DS.'thumb'. DS .$data['image_name'];
			
			if(file_exists($original_path)){
				unlink($original_path);
			}
			if(file_exists($resize_path)){
				unlink($resize_path);
			}
			if(file_exists($thumb_path)){
				unlink($thumb_path);
			}
			
			$mydata['Product']['product_image']="";
			
			$this->Product->id = $data['id'];
			$this->Product->save($mydata);
			
			$this->Session->setFlash('<p>Image delete successfully!</p>', 'default', array('class' => 'alert alert-success'));
			
			$this->redirect('/admin/Products/manage/'.$data['id']);
		}
	}
	
	
	
	public function admin_ajaximagedelete( )
	{
		$this->layout = 'ajax';
		
		$data = $this->request->data;
		$id = $data['id'];
		$imagename = $data['imagename']; 
		$this->loadModel('Product');
		
			if($id){
			$original_path=UPLOADS_FOLDER . DS .'product_image'. DS.'original'. DS .$imagename;
			$resize_path=UPLOADS_FOLDER . DS .'product_image'. DS.'resize'. DS .$imagename;
			$thumb_path=UPLOADS_FOLDER . DS .'product_image'. DS.'thumb'. DS .$imagename;
			
			if(file_exists($original_path)){
				unlink($original_path);
			}
			if(file_exists($resize_path)){
				unlink($resize_path);
			}
			if(file_exists($thumb_path)){
				unlink($thumb_path);
			}
			
			$mydata['Product']['product_image']="";
			
			$this->Product->id = $id;
			$this->Product->save($mydata);
			
			echo "1";
			exit;
		}
	}
	
	public function admin_ajaxgalleryimagedelete( )
	{
		$this->layout = 'ajax';
		
		$data = $this->request->data;
		$id = $data['id'];
		$img_id = $data['img_id']; 
		$image_name = $data['image_name']; 
		$model=ClassRegistry::init('ProductGallery');
		if($img_id){
			$original_path=WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'product_gallery'. DS.'original'. DS .$image_name;
			
			$resize_path=WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'product_gallery'. DS.'resize'. DS .$image_name;
			$thumb_path=WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'product_gallery'. DS.'thumb'. DS .$image_name;
			
			if(file_exists($original_path)){
				unlink($original_path);
			}
			if(file_exists($resize_path)){
				unlink($resize_path);
			}
			if(file_exists($thumb_path)){
				unlink($thumb_path);
			}
			
			$model->delete($img_id);		
			
			echo "1";
			exit;
		}
	}
	
	
	public function admin_galleryimgdelete( )
	{
		$data=$this->request->params['named'];
		$model=ClassRegistry::init('ProductGallery');
		if($data['img_id']){
			$original_path=WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'product_gallery'. DS.'original'. DS .$data['image_name'];
			
			$resize_path=WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'product_gallery'. DS.'resize'. DS .$data['image_name'];
			$thumb_path=WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'product_gallery'. DS.'thumb'. DS .$data['image_name'];
			
			if(file_exists($original_path)){
				unlink($original_path);
			}
			if(file_exists($resize_path)){
				unlink($resize_path);
			}
			if(file_exists($thumb_path)){
				unlink($thumb_path);
			}
			
			$model->delete($data['img_id']);		
			
			$this->Session->setFlash('<p>Image delete successfully!</p>', 'default', array('class' => 'alert alert-success'));
			
			$this->redirect('/admin/Products/manage/'.$data['id']);
		}
	}
	
	/********** Frontend Functions ************/
	
	public function home(){
		$this->theme = THEME_NAME;
		$this->layout = 'ecommerce_home';
		$this->loadModel('Pages');
		
		$this->loadModel('GalleryManagement');
		$this->GalleryManagement->bindModel(array(
				'hasMany'=>array(
					'GalleryImage'=>array(
						'className'=>'GalleryImage',
						'foreignKey'=>'gallery_management_id'
					)
				)
			)
		);
		$secondaryGallery = $this->GalleryManagement->findBySlug('ecommerce-seccondary-gallery');
		
		
	    // get record from the shop page in the admin section of the site
		$this->set(compact('secondaryGallery'));
	
	}
	
	public function products($slug=NULL)
	{
		$this->theme = THEME_NAME;
		$this->layout = 'ecommerce_inner';
		$category = $this->ProductCategory->findByCategoriesSlug($slug);
		
		$this->set(compact('slug','category'));
	}
	
	public function productssl($slug=NULL)
	{
		$this->theme = THEME_NAME;
		$this->layout = 'ecommerce_inner';
		$category = $this->ProductCategory->findByCategoriesSlug($slug);
		//echo $slug;
		//pr($category);
		$this->set(compact('slug','category'));
	}
	
	public function productssr($slug=NULL)
	{
		$this->theme = THEME_NAME;
		$this->layout = 'ecommerce_inner';
		$category = $this->ProductCategory->findByCategoriesSlug($slug);
		//echo $slug;
		//pr($category);
		$this->set(compact('slug','category'));
	}
	
	public function ajaxproductlist(){
		$this->theme = THEME_NAME;
		$this->layout = "ajax";
		
		if($this->request->is('post')){
			$data = $this->request->data;
			//pr($data);
			$this->set(compact('data'));
		}
	}
	
	public function ajaxproductlist3c($catalog_id=NULL){
		$this->theme = THEME_NAME;
		$this->layout = "ajax";
		
		if($this->request->is('post')){
			$data = $this->request->data;
			$this->set(compact('data','catalog_id'));
		}
	}
	
	public function productcount(){
		$this->theme = THEME_NAME;
		$this->layout = "ajax";
		
		if($this->request->is('post')){
			$data = $this->request->data;
			$conditionStr = urldecode($data['conditionArr']);
			$conditionsArr = json_decode($conditionStr, true);
			
			$likekeyArr = array('product_name','product_sku');
			$datekeyArr = array('created_date');
			$conditions = array();
			if(!empty($conditionsArr)){
				$categoryArr = array();
				if(array_key_exists('ProductCategory',$conditionsArr)){
					if(!empty($conditionsArr['ProductCategory'])){
						$this->loadModel('ProductCategory');
						
						foreach($conditionsArr['ProductCategory'] as $cat){
							$catdata = $this->ProductCategory->findByCategoriesSlug($cat);
							//return $catdata;
							if(!empty($catdata)){
								array_unshift($categoryArr, $catdata['ProductCategory']['id']);
								while($catdata['ProductCategory']['parent_id']!=0){
									$catdata = $this->ProductCategory->findById($catdata['ProductCategory']['parent_id']);
									array_unshift($categoryArr, $catdata['ProductCategory']['id']);
								}
							} else {
								return array();
							}
						}
					}
				}
				
				if(!empty($categoryArr)){
					$categoryStr = implode(',',$categoryArr);
					$conditions['Product.product_categoryid LIKE'] = '%'.$categoryStr.'%';
				}
				if(array_key_exists('Product',$conditionsArr)){
					foreach($conditionsArr['Product'] as $k => $v){
						if( ($v != NULL) ){
							if( in_array($k,$likekeyArr) ){
								$conditions['Product.'.$k.' LIKE'] = '%'.$v.'%';
							} 
							else if(in_array($k,$datekeyArr)){
								$conditions['Product.'.$k] = date('Y-m-d',strtotime($v)); 
							}
							else {
								$conditions['Product.'.$k] = $v; 
							}
						}
					}
				}
			}
					
			$conditions['Product.isdel'] = 0; 
			
			
			echo $count = $this->Product->find('count', array(
					'conditions'=>$conditions
				)
			);
			exit();
		}
	}
	
	public function ajaxproductpopup(){
		
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$product_id = $this->request->data['id'];
			
			$this->Product->bindModel(array(
							'hasMany' => array(
								'ProductGallery' => array(
									'className'    => 'ProductGallery',
									'foreignKey'   => 'product_id'
								)
							)
						)
					);
			
			$product = $this->Product->findById($product_id);
			
			//Function mouldOptions() is used to get all options assigned to a product by id
			$options = $this->mouldOptions($product_id);
			//pr($options); exit();
						
			$this->set(compact('product','options'));
			//exit();
		}
		
	}
	
	private function mouldOptions($product_id){
		//$this->loadModel('ProductAssignOption');
		$this->ProductAssignOption->bindModel(array(
				'belongsTo'=>array(
					'ProductOption'=>array(
						'className'=>'ProductOption',
						'foreignKey'=>'option_id',
						'fields'=>array('id','options_name'),
						'order'=>array('sort_order')
					),
					'OptionValue'=>array(
						'className'=>'OptionValue',
						'foreignKey'=>'option_value_id',
						'fields'=>array('id','option_value_name'),
						'order'=>array('option_sort_order')
					)
				)
			)
		);
		
		$options = $this->ProductAssignOption->find('all', array(
				'conditions'=>array(
					'ProductAssignOption.product_id'=>$product_id
				)
			)
		);
		
		
		$mouldOptions = array();
		if(!empty($options)){
			foreach($options as $option){
				if(!array_key_exists($option['ProductOption']['options_name'],$mouldOptions)){
					$mouldOptions[$option['ProductOption']['options_name']]['id']= $option['ProductOption']['id'];
					$mouldOptions[$option['ProductOption']['options_name']]['values']= array();
					array_push($mouldOptions[$option['ProductOption']['options_name']]['values'], $option['OptionValue']);
				} else {
					array_push($mouldOptions[$option['ProductOption']['options_name']]['values'], $option['OptionValue']);
				}
			}
		}
		
		return $mouldOptions;
		//return $options;
	}
	
	public function productdetails($slug=NULL, $catalogid=NULL)
	{
		$this->theme = THEME_NAME;
		$this->layout = 'ecommerce_inner';
		
		//$this->loadModel('ProductGallery');
		//$this->loadModel('ProductOption');
		$this->loadModel('ProductReview');
		$this->Product->bindModel(
					array(
						'hasMany' => array(
							'ProductGallery' => array(
								'className'    => 'ProductGallery',
								'foreignKey'   => 'product_id'
								
							)
						)
					)
				);
		//$product = $this->Product->findByProductSlugAndProductStatusAndIsdel($slug,'Y',0);
		$product = $this->Product->findByProductSlug($slug);
		//pr($product); exit();
		$options = array();
		if(!empty($product)){
			//Function mouldOptions() is used to get all options assigned to a product by id
			$options = $this->mouldOptions($product['Product']['id']);
			//pr($options); exit();
			$reviews =$this->ProductReview->find('all',array('conditions'=>array('ProductReview.product_id'=>$product['Product']['id'],'ProductReview.isdel'=>0,'ProductReview.status'=>'Y')));
			
			//cross selling product list
			$crossProductlist = $this->ProductAssignCrossproduct->find('list', array(
					'conditions'=>array(
						'ProductAssignCrossproduct.product_id'=>$product['Product']['id']
					),
					'fields'=>array('ProductAssignCrossproduct.crossproduct_id')
				)
			);
			//pr($crossProductlist); exit();
		}
		
		$this->set(compact('product', 'options','reviews', 'slug','catalogid','crossProductlist')); 
	}
	
	public function ajaxminicart(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			if($this->Session->read('loggedin_status')){
				$reqdata['Cart']['user_id'] = $this->Session->read('id');
			}
			//pr($reqdata); exit();
			$flag = $this->savetocart($reqdata);
			//pr($flag); exit();
			if($flag){
				echo 1; exit();
			} else {
				echo ''; exit();
			}
		} else {
			$this->set(compact('session_id'));
		}
		
	}
	
	public function showminicart(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
	}
	
	public function showcorexminicart(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
	}
	
	private function savetocart($reqdata){
		
		if(!empty($reqdata)){
			$check = $this->checkCart($reqdata);
						
			if($check > 0){
				$this->Cart->id = $check;
				$cart = $this->Cart->findById($check);
				$reqdata['Cart']['quantity'] = (int)$cart['Cart']['quantity'] + (int)$reqdata['Cart']['quantity'];
				$reqdata['Cart']['gross_price'] = $reqdata['Cart']['quantity'] * floatval($reqdata['Cart']['unit_price']);
				$flag = $this->Cart->save($reqdata);
				if($flag){
					return true;
				} else {
					return false;
				}
			} else {
				$this->Cart->create();
				$reqdata['Cart']['gross_price'] = $reqdata['Cart']['quantity'] * $reqdata['Cart']['unit_price'];
				$flag = $this->Cart->save($reqdata);
				if($flag){
					$cart_id = $this->Cart->id;
					if(!empty($reqdata['CartOption'])){
						foreach ($reqdata['CartOption']['option_value'] as $k=>$v){
							if(!empty($v)){
								$saveData['CartOption']['cart_id'] = $cart_id;
								$saveData['CartOption']['option_id'] = $k;
								$saveData['CartOption']['option_value_id'] = $v;
								
								$this->CartOption->create();
								$this->CartOption->save($saveData);
							}
						}
					}
					return true;
				} else {
					return false;
				}
			}
			
		} else {
			return false;
		}
	}
	
	private function checkCart($reqdata){
		$this->Cart->bindModel(array(
				'hasMany'=>array(
					'CartOption'=>array(
						'className'=>'CartOption',
						'foreignKey'=>'cart_id'
					)
				)
			)
		);
		
		$check = $this->Cart->findBySessionIdAndProductId($reqdata['Cart']['session_id'],$reqdata['Cart']['product_id']);
			
		if(!empty($check)){
			if(!empty($reqdata['CartOption'])){
				$option_id = array_filter( array_keys($reqdata['CartOption']['option_value']));
				$option_value_id = array_filter(array_values($reqdata['CartOption']['option_value']));
				
				
				if(!empty($option_id) && !empty($option_value_id)) {
					$arrCount = $this->CartOption->find('count', array(
							'conditions'=>array(
								'CartOption.cart_id'=>$check['Cart']['id'],
								'CartOption.option_id IN'=>$option_id,
								'CartOption.option_value_id IN'=>$option_value_id
							)
						)
					);
					$threadCount = $this->CartOption->find('count', array(
							'conditions'=>array(
								'CartOption.cart_id'=>$check['Cart']['id']
							)
						)
					);
					
					//return $arr;
					if($arrCount == $threadCount){
						return $check['Cart']['id'];
					} else {
						return 0;
					}
				} else {
					return $check['Cart']['id'];
				}
			} else {
				return $check['Cart']['id'];
			}
		} else {
			return 0;
		}
	}
	
	public function ajaxremoveminicart(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$reqdata = $this->request->data; //pr($reqdata); exit();
			$flag = $this->Cart->delete($reqdata['id']);
			if($flag){
				$alldeleteflag = $this->CartOption->deleteAll($reqdata['id']);
				if($alldeleteflag){
					echo 1;
				} else {
					echo 2;
				}
			} else {
				echo 3;
			}
		}
		exit();
	}
	
	public function ajaxReview(){
		$this->layout = 'ajax';
		$this->loadModel('ProductReview');
		$this->loadModel('Order');
		$this->loadModel('OrderDetail');
		if($this->request->is("post")){
			$data = $this->request->data;
			if(!empty($data)){
					$emailcheck= $this->Order->find('all', array(
									'conditions'=>array(
										'Order.email_id'=>$data['ProductReview']['email']
									)
								)
							);
						if(!empty($emailcheck))
						{
							$i=1;
							$productchecks=array();
							$productcheck=array();
							foreach($emailcheck as $emailcheckr){
							
								$productcheck= $this->OrderDetail->findByProductIdAndOrderId($data['ProductReview']['product_id'],$emailcheckr['Order']['id']); 
								if(!empty($productcheck)){
									$productchecks[$i]=$productcheck;
								}
									$i++;
							}
							
							if(!empty($productchecks)){
								date_default_timezone_set('Asia/Calcutta');
								$data['ProductReview']['review_date'] = date('Y-m-d H:i:s');
								$this->ProductReview->create();
								$flag = $this->ProductReview->save($data);
								if($flag)
								{
									echo 1; exit();
								}
												
							}else {
								echo 2; exit();
							}
						}
						else {
							echo 3; exit();
						}
			}
		} 
	}
	
	public function ajaxaddtowishlist(){
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			//pr($reqdata); exit();
			if(!empty($reqdata)){
				$data = $this->Wishlist->findByProductIdAndMemberId($reqdata['product_id'], $reqdata['member_id']);
				
				if(!empty($data)){
					$dltFlag = $this->Wishlist->delete($data['Wishlist']['id']);
					echo ($dltFlag)?"R":"F"; exit();
				} else {
					$this->Wishlist->create();
					
					$saveData = array();
					$saveData['Wishlist'] = $reqdata;
					$saveFlag = $this->Wishlist->save($saveData);
					echo ($saveFlag)?"A":"F"; exit();
				}
			}
		}
	}
	
	public function search($productname)
	{
		$this->theme = THEME_NAME;
		$this->layout = 'ecommerce_home';
		$featured = $this->Product->find('all',array(
				'conditions' => array('Product.isdel'=>'0','Product.product_name LIKE'=>'%'.$productname.'%'),
				//'order'=>array('Product.id' => 'DESC')
				'order'=>array('Product.sequence' => 'ASC')
			)
		);
		$this->set('featured',$featured); 
		$this->set('productname',$productname); 
		
	}
	
	public function admin_getListProduct(){
		$this->layout = 'ajax';
		$qdata1 = $this->params->query['prod_id'];
		$qdata = $this->params->query['query']; 
		$this->loadModel('Product');
		if(!empty($qdata1))
		{
			$data = $this->Product->find('all',
			array(
				'conditions'=>array(
					'Product.id'=>$qdata1,
					'Product.product_name LIKE'=>"%".$qdata."%",
					'Product.isdel' => 0
				),
				'fields'=>'Product.id,Product.product_name'
			)
		);
		}
		else
		{
			$data = $this->Product->find('all',
			array(
				'conditions'=>array(
					'Product.product_name LIKE'=>"%".$qdata."%",
					'Product.isdel' => 0
				),
				'fields'=>'Product.id,Product.product_name'
			)
			);	
		}
		$myArr = array();
		foreach($data as $dt){
			$obj = new stdClass();
			$obj->data = $dt['Product']['id'];
			$obj->value = $dt['Product']['product_name'];
			array_push($myArr, $obj);
		}
		
		$arr = array('suggestions'=>$myArr);
		echo json_encode($arr);
		exit();
	}
	
	public function admin_getListProduct1(){
		$this->layout = 'ajax';
		$qdata = $this->params->query['query']; 
		$this->loadModel('Product');
			$data = $this->Product->find('all',
			array(
				'conditions'=>array(
					'Product.product_name LIKE'=>"%".$qdata."%",
					'Product.isdel' => 0
				),
				'fields'=>'Product.id,Product.product_name'
			)
			);	
		$myArr = array();
		foreach($data as $dt){
			$obj = new stdClass();
			$obj->data = $dt['Product']['id'];
			$obj->value = $dt['Product']['product_name'];
			array_push($myArr, $obj);
		}
		
		$arr = array('suggestions'=>$myArr);
		echo json_encode($arr);
		exit();
	}
	
	public function mycatalog(){
		$this->theme = THEME_NAME;
		$this->layout = 'ecommerce_inner';
		$this->loadModel('CatalogProduct');
		$this->loadModel('ProductCategory');
		$this->loadModel('CatalogUser');
		$id = $this->Session->read('id');
		/* $this->CatalogProduct->bindModel(
				array(
					'belongsTo' => array(
						'ProductCategory' => array(
								'className'    => 'ProductCategory',
								'foreignKey'   => 'product_id'
							)
					)
					
					
				)
			); */
			$this->CatalogUser->bindModel(
				array(
					'belongsTo' => array(
						'Catalog' => array(
								'className'    => 'Catalog',
								'foreignKey'   => 'catalog_id'
							)
					)
					
					
				)
			);
		
		$catalogidArr=$this->CatalogUser->find('all',array(
													'conditions'=>array('CatalogUser.membar_id'=>$id)
											));
		/* pr($catalogidArr);
		exit; */
		
		/* $categoryArr=array();
		foreach($catalogidArr as $catalogidAr)
		{
			$categoryArr[$catalogidAr['Catalog']['name']]=$this->CatalogProduct->find('all',array(
													'conditions'=>array('CatalogProduct.catalog_id'=>$catalogidAr['CatalogUser']['catalog_id'])
												));
		}
		pr($categoryArr);
		exit; */
		$this->set('catalogidArr',$catalogidArr); 
		
	}
	public function catalogdetail($catalog_id=NULL){
		$this->theme = THEME_NAME;
		$this->layout = 'ecommerce_inner';
		$this->loadModel('CatalogProduct');
		$this->loadModel('Catalog');
		$this->loadModel('ProductCategory');
		$this->loadModel('Product');
		$this->loadModel('CatalogUser');
		$this->CatalogProduct->bindModel(
				array(
					'belongsTo' => array(
						'Product' => array(
								'className'    => 'Product',
								'foreignKey'   => 'product_id'
							)
					)
					
					
				)
			);
		$offset=1;
		$catalogproductdetails=$this->CatalogProduct->find('all',array(
													'conditions'=>array('CatalogProduct.catalog_id'=>$catalog_id),
													'limit' => 3,
													'offset' => $offset,
												));
		$this->set(compact('catalogproductdetails','catalog_id')); 
		
		$catalogidArr = $this->CatalogProduct->find('list', array(
				'conditions'=>array(
					'CatalogProduct.catalog_id'=>$catalog_id
				),
				'fields'=>array('product_id')
			)
		);
		$catalogname=$this->Catalog->findById($catalog_id);
		$this->set(compact('catalog_id', 'catalogidArr','catalogname')); 
		
	}
	
	public function admin_priceupdate(){
		$this->layout = 'ajax';
		$this->loadModel('Product');
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			$data['Product']['product_price'] = $reqdata['price'];
			
			$this->Product->id = $reqdata['id'];
			$updateFlag = $this->Product->save($data);
			if($updateFlag)
			{
				echo 1; exit();
			}
		}
	}
	
	public function admin_sequenceupdate(){
		$this->layout = 'ajax';
		$this->loadModel('Product');
		$reqdata=array();
		$data=array();
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			$data['Product']['sequence'] = $reqdata['sequence'];
			$data['Product']['id']= $reqdata['id'];
			$this->Product->save($data);
			echo "1";
			exit();
				
		}
	}

}
?>