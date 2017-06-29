<?php
echo $this->Layout->pagecrumb('page', 'Rate Product');
?>
<div class="container">
	<div class="row">
		
			
			<div class="col-xs-12 product-list">
				<div class="ajax-page-preloader" style="position: relative;">
					<div class="loader spinner">
						<img src="<?php echo $this->webroot.'img/loader.gif'; ?>" width="24" height="24">
					</div>
				</div>
				
				<div class="row">
				<?php
				foreach($productviewArr as $product){
					$options = $this->Layout->mouldOptions($product['Product']['id']);	
				?>
			
				
				<div class="col-md-3 col-sm-6 main-el">
				
				
				
						<div class="shop-col-item">
							<div class="photo">
							<?php echo $this->Html->link($this->Html->image(IMGPATH.'product_image/resize/'.$product['Product']['product_image'], array('alt'=>$product['Product']['product_name'], 'class'=>'img-responsive')), SITE_URL.$product['Product']['product_slug'], array('escape'=>false)); ?>
							</div>
							<div class="info shop-box-background shop-box-text">
								<div>
									<div class="price">
										<h5><?php echo $this->Html->link($product['Product']['product_name'], SITE_URL.$product['Product']['product_slug']); ?></h5>
										<h5 class="main-text-color"><?php echo CURRENCY.number_format($this->Layout->actualprice($product['Product']['id']),2); ?></h5>
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
									<p class="btn-add"><i class="fa fa-shopping-cart"></i><a href="<?php echo SITE_URL.$product['Product']['product_slug']; ?>">Add to cart</a></p>
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
									echo $this->Form->input('unit_price', array('type'=>'hidden', 'value'=>$this->Layout->actualprice($product['Product']['id'])));
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
			<div class="clearfix"></div>
			
			</div>
			
	</div>
</div>



			