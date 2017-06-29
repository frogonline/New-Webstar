<?php





//Best Sellers
if(in_array('best_seller',$section)){
?>



<div class="container only">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Best Sellers</h4>
                    </div>
					<?php
						$products = $this->Layout->bestseller();
						if(!empty($products)){
							foreach($products as $product){
							$options = $this->Layout->mouldOptions($product['Product']['id']);
						?>
						<div class="col-md-3 col-sm-6 main-el">
                        <div class="shop-col-item">
                            <div class="photo">
							<?php echo $this->Html->link($this->Html->image(IMGPATH.'product_image/resize/'.$product['Product']['product_image'], array('alt'=>$product['Product']['product_name'])), SITE_URL.$product['Product']['product_slug'], array('escape'=>false)); ?>
                               
                            </div>
                            <div class="info">
                                <div>
                                    <div class="price">
                                        <h5><?php echo $this->Html->link($product['Product']['product_name'], SITE_URL.$product['Product']['product_slug'], array('escape'=>false)); ?></h5>
                                        <h5 class="main-text-color"><?php echo CURRENCY.$this->Layout->actualprice($product['Product']['id']); ?></h5>
                                    </div>

                                    
                                </div>

                                <div class="btns clear-left">
                                   <?php if(!empty($options)) :?>
										<p class="btn-add"><i class="fa fa-shopping-cart"></i><?php echo $this->Html->link('Add to cart',SITE_URL.$product['Product']['product_slug']); ?></p>
										<?php else:?>
										<p class="btn-add"><i class="fa fa-shopping-cart"></i><?php echo $this->Html->link('Add to cart','#product-pop-up', array('class'=>' fancybox-fast-view', 'data-id'=>$product['Product']['id'], 'data-url'=>$this->Html->url(array('controller'=>'Products','action'=>'ajaxproductpopup','full_base'=>true)), 'onclick'=>'return fastviewproduct(this);')); ?></p>
										
										<?php endif;?>
                                    <p class="btn-details"><i class="fa fa-list"></i><?php echo $this->Html->link('More Details', SITE_URL.$product['Product']['product_slug'], array('escape'=>false)); ?></p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
					<?php 
                    }
					} else {
					?>
					<div class="item">
						<p>No product available in this list</p>
					</div>
					<?php } ?>
                   

                <?php } ?>                    

                   
                </div>
            </div>
