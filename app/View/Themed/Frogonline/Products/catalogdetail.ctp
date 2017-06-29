<?php
$ThemeSetting=$this->Session->read('ThemeSetting');
$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
echo $this->Layout->pagecrumb('page', $catalogname['Catalog']['name']);
?>
<div class="container">
		<!-- BEGIN SIDEBAR & CONTENT -->
	<div class="row margin-bottom-40">
			<!-- BEGIN SIDEBAR -->
		<div class="sidebar col-md-3 col-sm-3">
			<?php if($ThemeSettingheadertype=='V'){ ?>
			<div class="list-group">
				<?php
					App::import('Model','MenuMaster');
					$menumaster_model = new MenuMaster();
					$menuData = $menumaster_model->findById(12);
				if(!empty($menuData)){
					
					$default = array(
									'menu_slug' => $menuData['MenuMaster']['menu_slug'],
									'container_div' => true,
									'container_class' => 'vtl-navigation',
									'container_id' => '',
									'menu_class' => 'list-group',
									'item_class' => 'list-group-item',
									'submenu_class' => '',
									'item_wrap' => '',
									'after_item' => '',
									'after_item_class' => '',
									'hasChildli_class' => 'list-group-item has-sub',
									'menu_id' => ''
								);
					$menu = $this->MenuitemMasters->cp_menu($default);
					echo $menu;
				}
				?>
			</div>
			<div><br/></div>
			<?php }  ?>
			<div class="list-group">
				<?php
				echo $this->Html->link('My Account', array('controller'=>'Members', 'action'=>'myaccount', 'full_base'=>true), array('class'=>'list-group-item'));
				echo $this->Html->link('My Orders', array('controller'=>'Members', 'action'=>'myorders', 'full_base'=>true), array('class'=>'list-group-item'));
				echo $this->Html->link('Wishlist', array('controller'=>'Members', 'action'=>'wishlist', 'full_base'=>true), array('class'=>'list-group-item'));
				echo $this->Html->link('My Catalog', array('controller'=>'Products', 'action'=>'mycatalog', 'full_base'=>true), array('class'=>'list-group-item'));
				?>
			</div>
				
		</div>
			<!-- END SIDEBAR -->

		<!-- BEGIN CONTENT -->
		<div class="col-md-9 col-sm-7">
		<div class="content-page">
		<div class="row">
		<div class="col-md-12">
			<div class="shop-wrapper clearfix">
				<?php
				if(!empty($catalogidArr)){
					$conditions = array();
					$conditions['Product']['id'] = $catalogidArr;
					$order = array('product_name'=>'ASC');
					$limit = 3;
					$catalogproductdetails = $this->Layout->productlist($conditions, $order, $limit);
				
				} else {
					$catalogproductdetails = array();
				}
				
				if(!empty($catalogproductdetails)){
				?>
				<div class="col-xs-12 product-list">
					<div class="ajax-page-preloader" style="position: relative;">
						<div class="loader spinner">
							<img src="<?php echo $this->webroot.'img/loader.gif'; ?>" width="24" height="24">
						</div>
					</div>
					<div class="row">
					<?php
					foreach($catalogproductdetails as $product){
						$options = $this->Layout->mouldOptions($product['Product']['id']);	
					?>
						<div class="col-md-4 col-sm-6 main-el">
							<div class="shop-col-item">
								<div class="photo">
								<?php echo $this->Html->link($this->Html->image(IMGPATH.'product_image/resize/'.$product['Product']['product_image'], array('alt'=>$product['Product']['product_name'], 'class'=>'img-responsive')), SITE_URL.$product['Product']['product_slug'].'/'.$catalog_id, array('escape'=>false)); ?>
								</div>
								<div class="info shop-box-background shop-box-text">
									<div>
										<div class="price">
											<h5><?php echo $this->Html->link($product['Product']['product_name'], SITE_URL.$product['Product']['product_slug'].'/'.$catalog_id); ?></h5>
											<h5 class="main-text-color"><?php echo CURRENCY.number_format($this->Layout->mainprice($product['Product']['id'],$catalog_id),2); ?></h5>
										</div>
										<div class="rating">
											<i class="main-text-color fa fa-star"></i>
											<i class="main-text-color fa fa-star"></i>
											<i class="main-text-color fa fa-star"></i>
											<i class="main-text-color fa fa-star"></i>
											<i class="fa fa-star"></i>
										</div>
									</div>
									<div class="btns clear-left">
									<?php
									if(!empty($options))
									{
										?>
										<p class="btn-add"><i class="fa fa-shopping-cart"></i><a href="<?php echo SITE_URL.$product['Product']['product_slug'].'/'.$catalog_id; ?>">Add to cart</a></p>
										<?php
									}
									else
									{
										?>
										<p class="btn-add"><i class="fa fa-shopping-cart"></i><a href="javascript:void(0)" onclick="submitcart(<?php echo $product['Product']['id']; ?>)">Add to cart</a></p>
										<?php
								
										echo $this->Form->create('Cart', array('id'=>'singlecart'.$product['Product']['id'], 'onsubmit'=>'return add_to_cart(this);', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										echo $this->Form->input('session_id', array('type'=>'hidden', 'value'=>$this->Session->read('session_id')));
										echo $this->Form->input('product_id', array('type'=>'hidden', 'value'=>$product['Product']['id']));
										echo $this->Form->input('quantity', array('type'=>'hidden', 'value'=>1));
										echo $this->Form->input('unit_price', array('type'=>'hidden', 'value'=>$this->Layout->actualprice($product['Product']['id'],$catalog_id)));
										echo $this->Form->input('CartOption', array('type'=>'hidden', 'name'=>'data[CartOption]', 'value'=>''));
										echo $this->Form->input('add_to_cart_url', array('type'=>'hidden', 'class'=>'addtocarturl', 'value'=>$this->Html->url(array('controller'=>'Products', 'action'=>'ajaxminicart', 'full_base'=>true))));
										echo $this->Form->input('showminicart', array('type'=>'hidden', 'class'=>'showminicart', 'value'=>$this->Html->url(array('controller'=>'Products', 'action'=>'showminicart', 'full_base'=>true))));
										echo $this->Form->end();
									
									}
									?>
									<p class="btn-details">
									<?php
										echo $this->Html->link('<i class="fa fa-list"></i> More details', SITE_URL.$product['Product']['product_slug'], array('escape'=>false));
									?>
									</p>
									<?php echo $this->Layout->wishlistLink($product['Product']['id']); ?>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
					<?php
						}
					?>
					</div>
					
				</div>
				<div class="load inside col-md-12">
				<?php
					$conditionStr = urlencode(json_encode($conditions));
					echo $this->Html->link('<div class="over"><span>load more</span><div class="ajax-preloader">'.$this->Html->image(IMGPATH1.'button-loader.gif', array('alt'=>'loading..')).'</div></div>', 'javascript:void(0);', array('escape'=>false, 'class'=>'button blue solid md', 'id'=>'product-loadmore', "data-conditions"=>$conditionStr, 'data-limit'=>3,'data-offset'=>3, 'data-url'=>$this->Html->url(array('controller'=>'Products', 'action'=>'ajaxproductlist3c/'.$catalog_id, 'full_base'=>true)), 
					'data-productcounturl'=>$this->Html->url(array('controller'=>'Products', 'action'=>'productcount', 'full_base'=>true))
					)
				);
				?>
				</div>
				<?php
				} else {
					?>
					<div class="alert alert-noicon"><center>No Products Available Here.</center></div>
					<?php
				}
				?>
			</div>
			</div>
			</div>
		</div>
		</div>
	<!-- END CONTENT -->
	</div>
		<!-- END SIDEBAR & CONTENT -->
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	Register.init();
});	
</script>