<?php
class LayoutHelper extends AppHelper {
	var $helpers = array('Cache','Html','Session','Form','Paginator');
	
	public function themeSettings() {
		App::import('Model', 'Theme');
		$theme = new Theme();
		
		$theme->bindModel(array(
				'hasOne'=>array(
					'ThemeSetting'=>array(
						'className'=>'ThemeSetting',
						'foreignKey'=>'theme_id'
					)
				)
			)
		);
		
		$data = $theme->findByZipFile(THEME_NAME);
		return $data;
	}
	
	
	public function slider() {
        App::import('Model', 'Banner');
		$banner = new Banner();
		$banners = $banner->find('all',
			array(
				'conditions'=>array('Banner.banner_status'=>'Y','Banner.is_del'=>'0'),
				'order'=>array('Banner.sequence DESC')
			)
		);
		
		return $banners;
    }
	
	public function brands() {
        App::import('Model', 'GalleryManagement');
		$gallery = new GalleryManagement();
		$gallery->bindModel(array(
				'hasMany'=>array(
					'GalleryImage'=>array(
						'className'=>'GalleryImage',
						'foreignKey'=>'gallery_management_id'
					)
				)
			)
		);
		$brands = $gallery->findBySlug('gallery-name-9');
		
		return $brands;
    }
	
	public function categoryDetails($slug){
		App::import('Model', 'ProductCategory');
		$ProductCategory = new ProductCategory();
		
		$category = $ProductCategory->findByCategoriesSlug($slug);
		return $category;
	}
	
	public function productlist($conditionsArr=NULL, $order=NULL, $limit=0, $offset=0){
		App::import('Model', 'Product');
		$product = new Product();
		
		
		$likekeyArr = array('product_name','product_sku');
		$datekeyArr = array('created_date');
		$conditions = array();
		if(!empty($conditionsArr)){
			$categoryArr = array();
			if(array_key_exists('ProductCategory',$conditionsArr)){
				if(!empty($conditionsArr['ProductCategory'])){
					App::import('Model', 'ProductCategory');
					$ProductCategory = new ProductCategory();
					
					foreach($conditionsArr['ProductCategory'] as $cat){
						$catdata = $ProductCategory->findByCategoriesSlug($cat);
						//return $catdata;
						if(!empty($catdata)){
							array_unshift($categoryArr, $catdata['ProductCategory']['id']);
							while($catdata['ProductCategory']['parent_id']!=0){
								$catdata = $ProductCategory->findById($catdata['ProductCategory']['parent_id']);
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
		
		//Order By
		$orderArr = array();
		if(!empty($order)){
			foreach($order as $key=>$val){
				$orderArr['Product.'.$key] = $val;
			}
		} else {
			$orderArr = array('Product.id' => 'DESC');
		}
		
		//Limit And Offset
		$limit = ($limit!=0)?$limit:PAGINATION_PER_PAGE_LIMIT;
		$offset = ($offset!=0)?$offset:0;
		
		
		
		$products = $product->find('all',array(
				'conditions' => $conditions,
				'limit' => $limit,
				'offset' => $offset,
				'order'=>$orderArr
			)
		);
		//echo $this->element('sql_dump');die();
		//$products=$this->paginate('Product');
		
		return $products;
	}
	
	
	public function mouldOptions($product_id){
		//$this->loadModel('ProductAssignOption');
		App::import('Model', 'ProductAssignOption');
		$ProductAssignOption = new ProductAssignOption();
		
		$ProductAssignOption->bindModel(array(
				'belongsTo'=>array(
					'ProductOption'=>array(
						'className'=>'ProductOption',
						'foreignKey'=>'option_id',
						'fields'=>array('id','options_name')
					),
					'OptionValue'=>array(
						'className'=>'OptionValue',
						'foreignKey'=>'option_value_id',
						'fields'=>array('id','option_value_name')
					)
				)
			)
		);
		
		$options = $ProductAssignOption->find('all', array(
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
	
	
	public function bestseller(){
		App::import('Model','OrderDetail');
		$OD = new OrderDetail();
		
		$data = $OD->find('all', array(
				'fields'=>array(
					'OrderDetail.product_id'
				),
				'group'=>array('OrderDetail.product_id'),
				//'order'=>array('OrderDetail.count DESC'),
				'limit'=>10
			)
		);
		$pidArr = array();
		if(!empty($data)){
			foreach($data as $item){
				array_unshift($pidArr, $item['OrderDetail']['product_id']);
			}
		}
		
		$products = array();
		if(!empty($pidArr)){
			$conditions = array();
			$conditions['Product']['id IN'] = $pidArr;
			$order = array('product_name'=>'ASC');
			$limit = 10;
			$products = $this->productlist($conditions, $order, $limit);
		}
		return $products;
	}
	/**** Metronic Mini Cart ****/
	/*
	public function minicart(){
		$session_id = $this->Session->read('session_id');
		$arr = $this->generateCartArray($session_id);
		$count = count($arr);
		
		?>
		<div class="top-cart-info">
			<a href="javascript:void(0);" class="top-cart-info-count"><?php echo ($count > 1)?$count.' items':$count.' item'; ?></a>
			<a href="javascript:void(0);" class="top-cart-info-value"><?php echo CURRENCY.$this->totalCartPrice(); ?></a>
		</div>
		<i class="fa fa-shopping-cart"></i>
		<div class="top-cart-content-wrapper">
			<div class="top-cart-content">
			<?php 
				if($count > 0){
			?>
			
				<ul class="scroller" style="height: 250px;">
					<?php foreach($arr as $item){ ?>
					<li>
					<?php
						echo $this->Html->link($this->Html->image(IMGPATH.'product_image/resize/'.$item['Product']['product_image'], array('alt'=>$item['Product']['product_name'],'width'=>'37','height'=>'34')),
						SITE_URL.'productdetails/'.$item['Product']['product_slug'],
						array('escape'=>false)
						);
					?>
					<span class="cart-content-count"><?php echo '&times;'.$item['Cart']['quantity']; ?></span>
					<strong><?php echo $this->Html->link($item['Product']['product_name'], SITE_URL.'productdetails/'.$item['Product']['product_slug']); ?></strong>
					<em><?php echo CURRENCY.$item['Cart']['gross_price'] ?></em>
					<?php echo $this->Html->link('&nbsp;', 'javascript:void(0);', array('class'=>'del-goods', 'escape'=>false, 'onclick'=>'return removeminicart(this);', 'data-url'=>$this->Html->url(array('controller'=>'Products', 'action'=>'ajaxremoveminicart', 'full_base'=>true)), 'data-minicarturl'=>$this->Html->url(array('controller'=>'Products', 'action'=>'showminicart', 'full_base'=>true)), 'data-id'=>$item['Cart']['id'])); ?>
					</li>
					<?php } ?>
				</ul>
				<div class="text-right">
					<?php
						echo $this->Html->link('View Cart', array('controller'=>'Carts','action'=>'cart', 'full_base'=>true), array('class'=>'btn btn-default'));
						echo $this->Html->link('Checkout', array('controller'=>'Orders','action'=>'checkout', 'full_base'=>true), array('class'=>'btn btn-primary'));
					?>
				</div>
				<?php 
				} else {
					echo "No product in cart.";
				}
				?>
			</div>
		</div>
		<?php
		
	}
	*/
	/**** Metronic Mini Cart ****/
	
	/**** Corex Mini Cart ****/
	public function minicart(){
		$session_id = $this->Session->read('session_id');
		$cartArr = $this->generateCartArray($session_id);
		$count = count($cartArr);
		if($count!=0){
		?>
		<div class="col-sm-6 col-md-9 col-xs-12">
			<div class="items">
			<?php
				/* $session_id = $this->Session->read('session_id');
				$cartArr = $this->Layout->generateCartArray($session_id); */
			?>
			<?php 
			if(!empty($cartArr)){
				foreach($cartArr as $item){
			?>
				<div class="item">
					<?php
					echo $this->Html->link(
						$this->Html->image(IMGPATH.'product_image/thumb/'.$item['Product']['product_image'], array('alt'=>$item['Product']['product_name'], 'class'=>'img-responsive')),
						SITE_URL.$item['Product']['product_slug'],
						array('class'=>'image pull-left mgp-img', 'escape'=>false)
					);
					?>
					<div class="text pull-left">
						<p><?php echo $this->Html->link($item['Product']['product_name'], SITE_URL.$item['Product']['product_slug']); ?></p>
						<p><?php echo $item['Cart']['gross_price'] ?>/<?php echo $item['Cart']['unit_price']; ?></p>
						<h6 class="main-text-color">
						<?php echo $this->Html->link('&nbsp;', '#', array(
							'class'=>'del-goods fa fa-times-circle-o main-text-color', 
							'escape'=>false,
							'data-id'=>$item['Cart']['id'],
							'data-url'=>$this->Html->url(array('controller'=>'Products','action'=>'ajaxremoveminicart', 'full_base'=>true)),
							'data-minicarturl'=>$this->Html->url(array('controller'=>'Products','action'=>'showminicart', 'full_base'=>true)),
							'data-fullcarturl'=>$this->Html->url(array('controller'=>'Carts','action'=>'showfullcart', 'full_base'=>true)),
							'onclick'=>'return removecart(this);'
							)
						); 
						?>
						</h6>
					</div>
				</div>
			
			<?php
				}
			}
			?>
			
			</div>
		</div>

		<div class="col-sm-6 col-md-3 col-xs-12 cart">
			<h4>CART SUBTOTAL <span class="medium"> <?php echo CURRENCY.' '.number_format($cartArr = $this->totalCartPrice(), 2); ?> </span></h4>
			<div class="sep"></div>
			<?php
			echo $this->Html->link('View Cart', SITE_URL.'cart', array('class'=>'button striped md blue'));
			echo $this->Html->link('<div class="over">Proceed to Checkout</div>', SITE_URL.'checkout', array('class'=>'button solid md blue', 'escape'=>false));
			?>
			<!--<a class="button striped md blue" href="<?php echo SITE_URL.'cart'; ?>">view cart</a>
			<a class="button solid md blue" href="<?php echo SITE_URL.'checkout'; ?> "><div class="over">proceed to checkout</div></a>-->
		</div>
		<?php
		} else {
			
		?>
		<div class="col-sm-12 col-md-12 col-xs-12 cart">
			<div class="alert alert-noicon sc">
				<div class="text col-md-12 col-sm-7">
					<center><strong>Your cart is empty!</strong></center>
				</div>
				<div class="clearfix"></div>
			</div> 
		</div>
		<?php
		}
		
	}
	/**** Corex Mini Cart ****/
	
	public function totalCartPrice(){
		App::import('Model', 'Cart');
		$cart = new Cart();
		
		$session_id = $this->Session->read('session_id');
		$cartData = $cart->find('all', array(
				'conditions'=>array(
					'Cart.session_id'=>$session_id
				),
				'fields'=>array('gross_price')
			)
		);
		$total = 0;
		foreach($cartData as $item){
			$total += $item['Cart']['gross_price'];
		}
		return $total;
	}
	
	public function actualprice($id, $catalogid=NULL){
		App::import('Model', 'Product');
		$Product = new Product();
		$data = $Product->findById($id);
		
		App::import('Model', 'CatalogProduct');
		$CatalogProduct = new CatalogProduct();
		
		
		if(!empty($catalogid)){
			$catalogdata = $CatalogProduct->findByProductIdAndCatalogId($id, $catalogid);
			if(!empty($catalogdata)){
				if($data['Product']['product_discount']!=""){
					if($data['Product']['product_discount']!=0){
						$price = (float)($catalogdata['CatalogProduct']['product_price'] - ($catalogdata['CatalogProduct']['product_price']*$data['Product']['product_discount']/100));
					} else {
						$price = (float)$catalogdata['CatalogProduct']['product_price'];
					}
				} else {
					$price = (float)$catalogdata['CatalogProduct']['product_price'];
				}
			} else {
				return $this->actualprice($id);
			}
		} else {
			
			if($data['Product']['product_discount']!=""){
				if($data['Product']['product_discount']!=0){
					$price = (float)($data['Product']['product_price'] - ($data['Product']['product_price']*$data['Product']['product_discount']/100));
				} else {
					$price = (float)$data['Product']['product_price'];
				}
			} else {
				$price = (float)$data['Product']['product_price'];
			}
		}
		
		return $price;
	}
	
	public function mainprice($id, $catalogid=NULL){
		App::import('Model', 'Product');
		$Product = new Product();
		$data = $Product->findById($id);
		
		App::import('Model', 'CatalogProduct');
		$CatalogProduct = new CatalogProduct();
		
		
		if(!empty($catalogid)){
			$catalogdata = $CatalogProduct->findByProductIdAndCatalogId($id, $catalogid);
			if(!empty($catalogdata)){
				$price = (float)$catalogdata['CatalogProduct']['product_price'];
			} else {
				return $this->mainprice($id);
			}
		} else {
			$price = (float)$data['Product']['product_price'];
		}
		
		return $price;
	}
	
	public function generateShippingArray($id,$statevalue)
	{
		$stateArray=array('NSW'=>'15','VIC'=>'16','QLD'=>'17','WA'=>'18','SA'=>'19','TAS'=>'21','NT'=>'22');
		 foreach($stateArray as $key=>$value)
		{
			if($value==$statevalue)
			{
			$shortnamestate=$key;
			}
		}
		//echo $shortnamestate;
		App::import('Model', 'ProductShippingValue');
		$productobjValue = new ProductShippingValue();
		$valueshipping = $productobjValue->find('all', array(
					'conditions'=>array('ProductShippingValue.product_id'=>$id),
					'fields' => array($shortnamestate)
				)
			);
		return $valueshipping;
		
		
		
	}
	
	public function generateCartArray($session_id){
		App::import('Model', 'Cart');
		App::import('Model', 'OptionValue');
		$cart = new Cart();
		$optionvalue = new OptionValue();
		
		$cart->bindModel(array(
				'hasMany'=>array(
					'CartOption'=>array(
						'className'=>'CartOption',
						'foreignKey'=>'cart_id'
					)
				),
				'belongsTo'=>array(
					'Product'=>array(
						'className'=>'Product',
						'foreignKey'=>'product_id'
					)
				)
			)
		);
		
		if($this->Session->read('loggedin_status')){
			$user_id = $this->Session->read('id');
			$cartData = $cart->find('all', array(
					'conditions'=>array(
						'OR'=>array(
							'Cart.session_id'=>$session_id,
							'Cart.user_id'=>$user_id
						)
					)
				)
			);
		} else {
			$cartData = $cart->find('all', array(
					'conditions'=>array(
						'Cart.session_id'=>$session_id
					)
				)
			);
		}
		
		//$opt = $optionvalue->findById(7);
		if(!empty($cartData)){
			$i = 0;
			foreach ($cartData as $item){
				if(!empty($item['CartOption'])){
					$j = 0;
					foreach($item['CartOption'] as $cartopt){
						$optionvalue->bindModel(array(
							'belongsTo'=>array(
									'ProductOption'=>array(
										'className'=>'ProductOption',
										'foreignKey'=>'option_id'
									)
								)
							)
						);
						$cartData[$i]['CartOption'][$j] = $optionvalue->findById($cartopt['option_value_id']);
						$j++;
					}
				}
				$i++;
			}
		}
		
		return $cartData;
	}
	
	public function wishlistLink($product_id, $uniqueid=NULL){
		App::import('Model', 'Wishlist');
		$wishlistObj = new Wishlist();
		
		$loginStatus = $this->Session->read('loggedin_status');
		$member_id = $this->Session->read('id');
		
		$str = '';
		
		if(!empty($product_id)){
			if($loginStatus){
				$wishlistProducts = $wishlistObj->find('list', array(
						'conditions'=>array(
							'Wishlist.member_id'=>$member_id
						),
						'fields'=>array(
							'Wishlist.product_id'
						)
					)
				);
				
				if(in_array($product_id, $wishlistProducts)){
					$str .= $this->Html->link('<i class="fa fa-heart"></i>', 'javascript:void(0);', array('escape'=>false, 'class'=>'customize_mergleft addtowishlist', 'id'=>'prd-wishlst-'.$uniqueid.$product_id, 'onclick'=>'return wishlist(this);', 'data-product_id'=>$product_id, 'data-member_id'=>$member_id, 'data-url'=>$this->Html->url(array('controller'=>'Products', 'action'=>'ajaxaddtowishlist', 'full_base'=>true))));
				} else {
					$str .= $this->Html->link('<i class="fa fa-heart-o"></i>', 'javascript:void(0);', array('escape'=>false, 'class'=>'customize_mergleft addtowishlist', 'id'=>'prd-wishlst-'.$uniqueid.$product_id, 'onclick'=>'return wishlist(this);', 'data-product_id'=>$product_id, 'data-member_id'=>$member_id, 'data-url'=>$this->Html->url(array('controller'=>'Products', 'action'=>'ajaxaddtowishlist', 'full_base'=>true))));
				}
			}
		}
		return $str;
	}
	
	public function pagecrumb($type, $title, $slug=NULL, $opt=NULL){
		App::import('Model', 'ThemeSetting');
		$themesettingObj = new ThemeSetting();
		
		$setting = $themesettingObj->find('first');
		$typeArr = array('page', 'post', 'single-post', 'product');
		
		$str = '';
		
		if(!empty($setting)){
			if($setting['ThemeSetting']['header_type']=='H'){
				if(in_array($type, $typeArr)){
					if($type == 'product'){
						if(!empty($opt)){
							$breadcrumb = $breadcrumb = $this->Html->link('Home', SITE_URL) . ' / '.$title;
						} else {
							$breadcrumb = $this->productBreadcrumb($slug);
						}
					} else if($type == 'single-post') {
						$breadcrumb = $this->Html->link('Home', SITE_URL).' / '.$this->Html->link('Blog', SITE_URL.'blog/').' / '.$title;
					} else {
						$breadcrumb = $this->Html->link('Home', SITE_URL).' / '.$title;
					}
					
					if(!empty($opt)){
						$title = 'Search results for: '.$slug;
					}
					
					$str .= '<div class="pagecrumbs">
								<div class="container">
									<div class="row">
										<div class="col-xs-4">
											<h5 class="medium">'.$title.'</h5>
										</div>
										<div class="col-xs-8">
											<div class="location pull-right">
												<span class="medium">You are here: </span> '.$breadcrumb.'
											</div>
										</div>
									</div>
								</div>
							</div>';
				}
			}
		}
		
		return $str;
	}
	
	public function productBreadcrumb($slug=NULL){
		App::import('Model', 'ProductCategory');
		$ProductCategory = new ProductCategory();
		
		App::import('Model', 'Product');
		$Product = new Product();
		
		$action = $this->action;
		//$breadcrumbArr = array();
		$productlistActionsArr = array('products', 'productssl', 'productssr');
		$str	=	$this->Html->link('Home',SITE_URL).' / ';
		
		if(in_array($action, $productlistActionsArr)){
			$data = $ProductCategory->findByCategoriesSlug($slug);
			//pr($data); exit();
			if(!empty($data)){
				if($data['ProductCategory']['parent_id']==0){
					if($slug == $data['ProductCategory']['categories_slug']) {
						$str	.=	$data['ProductCategory']['name'];
					} else {
						$str	.=	$this->Html->link($data['ProductCategory']['name'], SITE_URL.$data['ProductCategory']['categories_slug']).' / ';
					}
				} else {
					$pid = $data['ProductCategory']['parent_id'];
					$newstr = "";
					while($pid!=0){
						$pid = $data['ProductCategory']['parent_id'];
						if($slug == $data['ProductCategory']['categories_slug']) {
							$newstr	=	$data['ProductCategory']['name'].' / ' . $newstr;
						} else {
							$newstr	=	$this->Html->link($data['ProductCategory']['name'], SITE_URL.$data['ProductCategory']['categories_slug']).' / '. $newstr;
						}
						if($pid==0){
							break;
						} else {
							$data = $ProductCategory->findById($pid);
						}
						
					}
					$str .= $newstr;
				}
			}
		} else if($action == "productdetails") {
			$proddata = $Product->findByProductSlug($slug);
			if(!empty($proddata)){
				$categories = explode(",", $proddata['Product']['product_categoryid']);
				$adjcategory = end($categories);
				$data = $ProductCategory->findById($adjcategory);
				$pid = $data['ProductCategory']['parent_id'];
				$newstr = "";
				do{
					$pid = $data['ProductCategory']['parent_id'];
					$newstr	=	$this->Html->link($data['ProductCategory']['name'], SITE_URL.$data['ProductCategory']['categories_slug']).' / '. $newstr;
					$data = $ProductCategory->findById($pid);
				}while($pid!=0);
				$str .= $newstr;
				$str .= $proddata['Product']['product_name'];
			}
		}
		$str.= '</ul>';
		return $str;
	}
	public function orderlist($id)
	{
		App::import('Model', 'Order');
		App::import('Model', 'OrderDetail');
		App::import('Model', 'Product');
		$order = new Order();
		$orderdetail = new OrderDetail();
		$order->bindModel(array(
				'hasMany'=>array(
					'OrderDetail'=>array(
						'className'=>'OrderDetail',
						'foreignKey'=>'order_id'
					)
				)
			)
		);
		$orderlist = $order->find('all', array(
					'conditions'=>array('Order.user_id'=>$id),
					'order'=>array('Order.id DESC'),
				)
			);
		
	
		return $orderlist;
		
		
	}
	public function orderlistdetails($productid)
	{
		
		App::import('Model', 'Product');
		$product = new Product();
		$orderlistdetails = $product->findById($productid);
		//pr($orderlistdetails);
		
		return $orderlistdetails;
		
		
	}
	
	
}
?>