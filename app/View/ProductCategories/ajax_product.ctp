<?php
                        //print_r($_POST);die();
						$conditions = array();
						$conditions['ProductCategory']['slug'] = trim($_POST['slug']);
						$order = array('product_name'=>'ASC');
						$limit = $_POST['limitperpage'];
						$offset =($_POST['page_no']-1)*$limit;
						//echo $limit.'---'.$offset;
						$products = $this->Layout->productlist($conditions, $order, $limit,$offset);
						$totalproducts = $this->Layout->productlist($conditions, $order);
						//pr($products);
						
						if(!empty($products)){
						    
							$key=($_POST['page_no']-1)*$limit;
							foreach($products as $product){
								$options = $this->Layout->mouldOptions($product['Product']['id']);
							$key++;
							$row=ceil($key/3);
							//echo $key;
							//echo $key.'---'.$row;
							$right=(($row-1)*476).'px';
							if($key%3==0)
							{
							  $left='586px';
							}
							if($key%3==1)
							{
							 
							
							 $left='0px';
							}
							if($key%3==2)
							{
							 $left='293px';
							}
							
							
							
							
							
						?>
                            <div class="col-sm-3 col-sm-6 main-el isotope-element isotope-item" style="position: absolute; left: 0px; top: 0px; transform: translate(<?php echo $left;?>, <?php echo $right;?>);">
                                <div class="shop-col-item">
                                    <div class="photo">
                                      <?php echo $this->Html->link($this->Html->image(IMGPATH.'product_image/resize/'.$product['Product']['product_image'], array('alt'=>$product['Product']['product_name'],'class'=>'img-responsive')), SITE_URL.$product['Product']['product_slug'], array('escape'=>false)); ?>
                                    </div>
                                    <div class="info shop-box-background shop-box-text">
                                        <div>
                                            <div class="price">
                                                <h5><?php echo $this->Html->link($product['Product']['product_name'], SITE_URL.$product['Product']['product_slug']) ?></h5>
                                                <h5 class="main-text-color"><?php echo CURRENCY.$this->Layout->actualprice($product['Product']['id']); ?></h5>
                                            </div>

                                           <!-- <div class="rating">
                                                <i class="main-text-color fa fa-star"></i>
                                                <i class="main-text-color fa fa-star"></i>
                                                <i class="main-text-color fa fa-star"></i>
                                                <i class="main-text-color fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div> -->
                                        </div>

                                        <div class="btns clear-left">
                                        <?php if(!empty($options)) :?>
										<p class="btn-add"><i class="fa fa-shopping-cart"></i><?php echo $this->Html->link('Add to cart',SITE_URL.$product['Product']['product_slug']); ?></p>
										<?php else:?>
										<p class="btn-add"><i class="fa fa-shopping-cart"></i><?php echo $this->Html->link('Add to cart','#product-pop-up', array('class'=>' fancybox-fast-view', 'data-id'=>$product['Product']['id'], 'data-url'=>$this->Html->url(array('controller'=>'Products','action'=>'ajaxproductpopup','full_base'=>true)), 'onclick'=>'return fastviewproduct(this);')); ?></p>
										
										<?php endif;?>
                                            <p class="btn-details"><i class="fa fa-list"></i><a href="<?php echo SITE_URL.$product['Product']['product_slug'];  ?>">More details</a></p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        <?php
							}
						} 
						?>
						<?php  $totalpage=ceil((count($totalproducts)/$limit))?>
						==sdsoftware==<?php echo ($totalpage!=$_POST['page_no'])?$_POST['page_no']+1:''; ?>==sdsoftware==<?php echo $row; ?>
						