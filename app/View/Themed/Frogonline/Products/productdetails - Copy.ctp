<?php 
//pr($testimonial);exit;
	$this->assign('title', $product['Product']['product_name']); 
	$this->assign('meta_title', $product['Product']['product_name']); 
	$this->assign('meta_keywords', $product['Product']['meta_keyword']); 
	$this->assign('meta_description', $product['Product']['meta_description']); 
	$this->assign('image_path', IMGPATH.'product_image/original/'.$product['Product']['product_image']); 
	$this->assign('url_path', SITE_URL.$product['Product']['product_slug']); 
?>
<?php echo $this->Layout->CorexproductBreadcrumb($slug); ?>


            <div class="product-wrap content single">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 preview main-el">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="large">
                                        <a class="overlay mgp-img" href="<?php echo IMGPATH.'product_image/original/'.$product['Product']['product_image']; ?>">
                                            <i class="fa fa-search md alt-text-color"></i>
                                        </a>
										<?php
									echo $this->Html->image(IMGPATH.'product_image/resize/'.$product['Product']['product_image'], array('alt'=>$product['Product']['product_name'], 'class'=>'img-responsive', 'data-BigImgsrc'=>IMGPATH.'product_image/original/'.$product['Product']['product_image']));
								?>
                                        
                                    </div>
                                </div>
                                <?php if(!empty($product['ProductGallery'])){
									foreach($product['ProductGallery'] as $ProductGallery){ ?>
									 <div class="col-xs-4">
                                    <div class="small">
                                        <a class="overlay mgp-img" href="<?php echo IMGPATH.'product_gallery/original/'.$ProductGallery['image_name']; ?>">
                                            <i class="fa fa-search sm"></i>
                                        </a>
										<?php echo $this->Html->link($this->Html->image(IMGPATH.'product_gallery/thumb/'.$ProductGallery['image_name'],array('alt'=>$product['Product']['product_name'])),
										IMGPATH.'product_gallery/original/'.$ProductGallery['image_name'],
										array('escape'=>false,'class'=>'img-responsive', 'rel'=>'photos-lib')
										); ?>
                                        
                                    </div>
                                 </div>
									
										
								
								<?php
									}
								}
								?>
                               
                               
                                
                            </div>
                        </div>
                        <div class="col-md-6 main-el">
                            <h3><?php echo (!empty($product))?$product['Product']['product_name']:''; ?></h3>
                            <h5 class="main-text-color">
							<strong><span><?php echo CURRENCY; ?></span><?php echo $this->Layout->actualprice($product['Product']['id']); ?></strong>
									<?php if($product['Product']['product_discount']!=0){ ?>
									<em><?php echo CURRENCY; ?><span><?php echo (!empty($product))?$product['Product']['product_price']:'0.00'; ?></span></em>
									<?php } ?>
							</h5>
							<h5 class="main-text-color">
							<?php 
								if(!empty($product)){
									echo ($product['Product']['stock_flag'])?'In Stock':'Out of Stock'; 
								}
							?>
							</h5>
                            <div class="sep-line"></div>
                            <p><?php echo (!empty($product))?$product['Product']['product_shortdesc']:''; ?></p>
                            <?php echo $this->Form->create('Cart', array('id'=>"cart_form", 'onsubmit'=>'return add_to_cart(this);', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
                            <div class="controls">
							
							<?php //echo $this->Session->read('session_id');
									if(!empty($options)){
										foreach($options as $optionKey=>$optionVal){
								?>
								<div class="pull-left" style="width:100%;margin-bottom:10px;">
									<label class="control-label"><?php echo ucfirst($optionKey); ?>:</label>
									<select name="data[CartOption][option_value][<?php echo $optionVal['id']; ?>]" class="">
										<option value="">Select <?php echo ucfirst($optionKey); ?></option>
										<?php foreach($optionVal['values'] as $value){ ?>
										<option value="<?php echo $value['id']; ?>"><?php echo $value['option_value_name']; ?></option>
										<?php } ?>
									</select>
									<?php echo $this->Form->input('', array('type'=>'hidden', 'name'=>'data[CartOption][option_id][]', 'value'=>$optionVal['id'])); ?>
								</div>
								<br/>
								<?php
										}
								
									} else {
										echo "No options available for this product.";
									}
								?>
							
							
							
                               <?php echo $this->Form->input('quantity', array('type'=>'text', 'id'=>'product-quantity', 'readonly'=>true, 'value'=>'1', 'class'=>'form-control input-sm')); ?>
							   <?php 
									echo $this->Form->input('session_id', array('type'=>'hidden','value'=>$this->Session->read('session_id')));
									echo $this->Form->input('product_id', array('type'=>'hidden','value'=>$product['Product']['id']));
									echo $this->Form->input('unit_price', array('type'=>'hidden','value'=>$this->Layout->actualprice($product['Product']['id']) ));
									echo $this->Form->input('add_to_cart_url', array('type'=>'hidden', 'class'=>'addtocarturl', 'value'=>$this->Html->url(array('controller'=>'Products', 'action'=>'ajaxminicart', 'full_base'=>true))));
									echo $this->Form->input('showminicart', array('type'=>'hidden', 'class'=>'showminicart', 'value'=>$this->Html->url(array('controller'=>'Products', 'action'=>'showminicart', 'full_base'=>true)))); ?>
									<div class="over"><?php echo $this->Form->button('Add to cart', array('type' => 'submit','class'=>'button solid blue md add btn-primary')); ?></div> 
								
								<?php echo $this->Form->end(); ?>
                               
                            </div>

                           <!-- <div class="txt-min">SKU: W023 / Categories: <span class="main-text-color"><a>Dresses</a>, <a>Pants</a>, <a>Woman</a></span></div> -->
                            <div id="d-tabs" class="tab def">
                                <ul>
                                    <li><a href="#d-tabs-1"><h6>Description </h6></a></li>
                                    <li><a href="#d-tabs-2"><h6>Information</h6></a></li>
                                    <li><a href="#d-tabs-3"><h6>Reviews (<?php echo count($reviews); ?>)</h6></a></li>
                                </ul>
                                <div id="d-tabs-1">
                                    <p><?php echo (!empty($product))?$product['Product']['product_description']:''; ?></p>
                                </div>
                                <div id="d-tabs-2">
                                   	<table class="datasheet">
										<tr>
											<th colspan="2">Additional Features</th>
										</tr>
										<?php foreach($options as $optionKey=>$optionVal){ ?>
										
										<tr>
											<td class="datasheet-features-type"><?php echo $optionKey; ?></td>
											<td>
												<?php 
													if(!empty($optionVal['values'])){
														foreach($optionVal['values'] as $values){
															$endval = end($optionVal['values']);
															if($endval['id']==$values['id']){
																echo $values['option_value_name'];
															} else {
																echo $values['option_value_name'].', ';
															}
														}
													}
												?>
											</td>
										<? } ?>
									</table>
								</div>
								
                                </div>
                                <div id="d-tabs-3">
								  <?php  
									if(!empty($reviews)){
										foreach($reviews as $review){ 
									?> 
									<div class="review-item clearfix">
										<div class="review-item-submitted">
											<strong><?php echo $review['ProductReview']['name'];?></strong>
											<em><?php echo $review['ProductReview']['review_date'];?></em>
											<div class="rateit" data-rateit-value="<?php echo $review['ProductReview']['rating'];?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
										</div>                                              
										<div class="review-item-content">
											<p><?php echo $review['ProductReview']['review'];?></p>
										</div>
									</div>
									
                                   <?php
										}
									} else {
									?>
									<p>There are no reviews for this product.</p>
									<?php } ?>

									<!-- BEGIN FORM-->
									<div class="nNote nSuccess" style="display:none;" id="rev_msg"></div>
									<?php echo $this->Form->create('ProductReview', array('url'=>array('controller'=>'Products', 'action'=>'Productdetails'), 'id'=>"review_form",'class'=>"reviews-form", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
									<?php echo $this->Form->input('product_id',array("type"=>"hidden","label"=>false,"value"=>$product['Product']['id']));?>
									<h2>Write a review</h2>
									<div class="form-group">
										<label for="name">Name <span class="require">*</span></label>
										<?php echo $this->Form->input('name',array('id'=>"name",'class'=>"form-control",'div'=>false, 'label'=>false, 'type'=>'text')); ?>
									</div>
									<div class="form-group">
										<label for="email">Email<span class="require">*</span></label>
										<?php echo $this->Form->input('email',array('id'=>"email",'class'=>"form-control",'div'=>false, 'label'=>false, 'type'=>'text')); ?>
									</div>
									<div class="form-group">
										<label for="review">Review <span class="require">*</span></label>
										<?php echo $this->Form->textarea('review',array('id'=>"review",  'class'=>"form-control",'rows'=>"8",'div'=>false, 'label'=>false)); ?>
									</div>
									<div class="form-group">
										<label for="email">Rating</label>
										<?php echo $this->Form->input('rating',array('id'=>"backing5",  'class'=>"form-control",'value'=>"4",'div'=>false, 'label'=>false,'type'=>'range')); ?>
										<div class="rateit" data-rateit-backingfld="#backing5" data-rateit-resetable="false"  data-rateit-ispreset="true" data-rateit-min="0" data-rateit-max="5"></div>
									</div>
									<div class="padding-top-20">
										<?php echo $this->Form->input('submitUrl',array('id'=>'submitUrl','value'=>$this->Html->url(array('controller'=>'Products','action'=>'ajaxReview','full_base'=>true), array('full_base'=>true)), 'type'=>'hidden')); ?>
										<?php echo $this->Form->button('Send', array('type' => 'submit','value'=>'Send','class'=>'btn btn-primary'));?>
									</div>
									<?php  echo $this->Form->end(); ?>
									<!-- END FORM--> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>
			
			<?php 
					$section = array('category_menu','best_seller');
					echo $this->element('layout_ecommerce_bestseller_footer', array('section'=>$section)); 
					
			?>

          
