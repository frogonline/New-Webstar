<?php 
//pr($product);exit;
	$this->assign('title', $product['Product']['product_name']); 
	$this->assign('meta_title', $product['Product']['product_name']); 
	$this->assign('meta_keywords', $product['Product']['meta_keyword']); 
	$this->assign('meta_description', $product['Product']['meta_description']); 
	$this->assign('image_path', IMGPATH.'product_image/original/'.$product['Product']['product_image']); 
	$this->assign('url_path', SITE_URL.$product['Product']['product_slug']); 
	$ThemeSetting=$this->Session->read('ThemeSetting');
	$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
	echo $this->Layout->pagecrumb('product', $product['Product']['product_name'], $product['Product']['product_slug']);
?>
<!--<div class="pagecrumbs">
	<div class="container">
		<div class="row">
			<div class="col-xs-4">
				<h5 class="medium"><?php echo $product['Product']['product_name']; ?></h5>
			</div>
			<div class="col-xs-8">
				<div class="location pull-right">
					<span class="medium">You are here: </span><?php echo $this->Layout->productBreadcrumb($product['Product']['product_slug']); ?></a>
				</div>
			</div>
		</div>
	</div>
</div>-->
<div class="product-wrap single">
	<div class="container">
		
		<?php //echo $this->Layout->CorexproductBreadcrumb($slug); ?>
			<?php if($ThemeSettingheadertype=='V') {?>
			<div class="col-md-3" >
			
			<?php
					App::import('Model','MenuMaster');
					$menumaster_model = new MenuMaster();
					$menuData = $menumaster_model->findById(12);
				if(!empty($menuData)){
					
					$default = array(
									'menu_slug' => $menuData['MenuMaster']['menu_slug'],
									'container_div' => true,
									'container_class' => 'vtl-navigation hidden-xs hidden-sm',
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
			<div class="row col-md-9">
			<?php }else{?>
			<div class="row">
			<?php } ?>
			<div class="col-md-6 preview main-el">
				<div class="row">
					<div class="col-xs-12">
						<div class="large">
							<?php
								echo $this->Html->link('<i class="fa fa-search md alt-text-color"></i>', IMGPATH.'product_image/original/'.$product['Product']['product_image'], array('class'=>'overlay mgp-img', 'escape'=>false));
							
								echo $this->Html->image(IMGPATH.'product_image/original/'.$product['Product']['product_image'], array('alt'=>$product['Product']['product_name'], 'class'=>'img-responsive', 'data-BigImgsrc'=>IMGPATH.'product_image/original/'.$product['Product']['product_image']));
							?>
							
						</div>
					</div>
					</div>
					<div class="row">
					<?php 
					if(!empty($product['ProductGallery'])){
						foreach($product['ProductGallery'] as $ProductGallery){ 
					?>
						<div class="col-xs-4">
							<div class="small">
							<?php
								echo $this->Html->link('<i class="fa fa-search sm"></i>', IMGPATH.'product_gallery/original/'.$ProductGallery['image_name'], array('class'=>'overlay mgp-img', 'escape'=>false));
							
								echo $this->Html->link($this->Html->image(IMGPATH.'product_gallery/original/'.$ProductGallery['image_name'],array('alt'=>$product['Product']['product_name'])),
								IMGPATH.'product_gallery/original/'.$ProductGallery['image_name'],
								array('escape'=>false,'class'=>'img-responsive', 'rel'=>'photos-lib')
								); 
							?>
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
				<strong><span><?php echo CURRENCY; ?></span><?php echo number_format($this->Layout->actualprice($product['Product']['id'],$catalogid),2); ?></strong>
				<?php if($product['Product']['product_discount']!=0){ ?>
				<em><?php echo CURRENCY; ?><span class="main-price"><?php echo (!empty($product))?number_format($this->Layout->mainprice($product['Product']['id'],$catalogid),2):'0.00'; ?></span></em>
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
				<div class="form-3">
				
				<?php //echo $this->Session->read('session_id');
				if(!empty($options)){
					foreach($options as $optionKey=>$optionVal){
				?>
					<div class="row">
						<div class="col-md-2">
							<label class="control-label"><?php echo ucfirst($optionKey); ?>:</label>
						</div>
						<div class="col-md-4">
							<select name="data[CartOption][option_value][<?php echo $optionVal['id']; ?>]" class="form-control">
								<option value="">Select <?php echo ucfirst($optionKey); ?></option>
								<?php foreach($optionVal['values'] as $value){ ?>
								<option value="<?php echo $value['id']; ?>"><?php echo $value['option_value_name']; ?></option>
								<?php } ?>
							</select>
							<?php echo $this->Form->input('', array('type'=>'hidden', 'name'=>'data[CartOption][option_id][]', 'value'=>$optionVal['id'])); ?>
						</div>
					</div>
				<?php
					}
				}/*  else {
					echo "No options available for this product.";
				} */
				?>
				<div class="row controls">
					<div class="col-md-2">
						<label class="control-label">Qty:</label>
					</div>
					<?php if($ThemeSettingheadertype=='V') {?>
					<div class="col-md-5">
					<?php }else{ ?>
					<div class="col-md-4">
					<?php } ?>
					
					<?php
						echo $this->Html->link('<div class="">-</div>', 'javascript:void(0);', array('class'=>'button grey solid ctrl', 'escape'=>false, 'onclick'=>'fnDecrese(this);'));
						echo $this->Form->input('quantity', array('type'=>'text', 'id'=>'product-quantity', 'readonly'=>true, 'value'=>'1', 'data-qty'=>$product['Product']['product_quantity'], 'class'=>'amount bold'));
						echo $this->Html->link('<div class="">+</div>', 'javascript:void(0);', array('class'=>'button grey solid ctrl', 'escape'=>false, 'onclick'=>'fnIncrese(this);'));
					?>
					</div>
				</div>
				<?php
				echo $this->Form->input('session_id', array('type'=>'hidden','value'=>$this->Session->read('session_id')));
				echo $this->Form->input('product_id', array('type'=>'hidden','value'=>$product['Product']['id']));
				echo $this->Form->input('unit_price', array('type'=>'hidden','value'=>$this->Layout->actualprice($product['Product']['id'], $catalogid) ));
				echo $this->Form->input('add_to_cart_url', array('type'=>'hidden', 'class'=>'addtocarturl', 'value'=>$this->Html->url(array('controller'=>'Products', 'action'=>'ajaxminicart', 'full_base'=>true))));
				echo $this->Form->input('showminicart', array('type'=>'hidden', 'class'=>'showminicart', 'value'=>$this->Html->url(array('controller'=>'Products', 'action'=>'showminicart', 'full_base'=>true)))); 
				
				echo $this->Form->button('<div class="over">Add to cart</div>', array('type' => 'submit','class'=>'button solid blue md add', 'escape'=>false)); 
				
				echo $this->Form->end(); 
				?>
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
						<div class="col-md-8" id="waitingDiv" style="display:none;margin-left:12%;margin-top:-5%" ><img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" /> <b>Saving your data. Please wait.</b>
						</div>
						<?php  echo $this->Form->end(); ?>
						<!-- END FORM--> 
						<div class="nNote nSuccess" style="display:none;" id="rev_msg"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	

</div>
<div class="container">     
	<div class="row">
		<div class="col-md-12 main-el hidden-xs">
			<?php
			$conditions = array();
			if(count($crossProductlist)==1){
				$conditions['Product'] = array('id'=>current($crossProductlist));
				$order = array('product_name'=>'DESC');
				$limit = 12;
				$crsproducts = $this->Layout->productlist($conditions, $order, $limit);
			} else if(count($crossProductlist)>1) {
				$conditions['Product'] = array('id'=>$crossProductlist);
				$order = array('product_name'=>'DESC');
				$limit = 12;
				$crsproducts = $this->Layout->productlist($conditions, $order, $limit);
			} else {
				$crsproducts = array();
			}
			
			
			//pr($conditions);
			if(!empty($crsproducts)){
				$count = 0;
				$r = 0;
			?>
			<!---<div class="col-md-12 main-el">
			<h2 class="main-text-color">YOU MAY ALSO LIKE THESE</h2>
			</div> --->
			<div class="crsl-wrap spaced-top">
				<div data-ride="carousel" class="carousel slide carousel-fade shop-crsl" id="shop-crsl-1">
					<!-- Wrapper for slides -->
					<div class="carousel-inner">
						<?php
							foreach($crsproducts as $crsproduct){
								$options = $this->Layout->mouldOptions($crsproduct['Product']['id']);	
								$count++;
								if($count%4==1){
									$r++;
									echo ($r==1)?'<div class="item active">':'<div class="item">';
									echo '<div class="row">';
								}
								?>
								<div class="col-sm-3">
									<div class="shop-col-item">
										<div class="photo">
										<?php 
											echo $this->Html->link($this->Html->image(IMGPATH.'product_image/resize/'.$crsproduct['Product']['product_image'], array('alt'=>$crsproduct['Product']['product_name'], 'class'=>'img-responsive')), SITE_URL.$crsproduct['Product']['product_slug'], array('escape'=>false));
										?>
										</div>
										<div class="info">
											<div>
												<div class="price">
													<h5>
													<?php echo $this->Html->link($crsproduct['Product']['product_name'], SITE_URL.$crsproduct['Product']['product_slug']); ?>
													</h5>
													<h5 class="main-text-color"><?php echo CURRENCY.number_format($this->Layout->actualprice($crsproduct['Product']['id']),2); ?></h5>
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
													<p class="btn-add">
													<?php
													echo $this->Html->link('<i class="fa fa-shopping-cart"></i> Add to cart', SITE_URL.$crsproduct['Product']['product_slug'], array('escape'=>false));
													?>
													</p>
													<?php
												}
												else
												{
													?>
													<p class="btn-add">
													<?php
													echo $this->Html->link('<i class="fa fa-shopping-cart"></i> Add to cart', 'javascript:void(0);', array('escape'=>false, 'onclick'=>'submitcart('.$crsproduct['Product']['id'].')'));
													?>
													</p>
													<?php
													echo $this->Form->create('Cart', array('id'=>'singlecart'.$crsproduct['Product']['id'], 'onsubmit'=>'return add_to_cart(this);', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
													echo $this->Form->input('session_id', array('type'=>'hidden', 'value'=>$this->Session->read('session_id')));
													echo $this->Form->input('product_id', array('type'=>'hidden', 'value'=>$crsproduct['Product']['id']));
													echo $this->Form->input('quantity', array('type'=>'hidden', 'value'=>1));
													echo $this->Form->input('unit_price', array('type'=>'hidden', 'value'=>$this->Layout->actualprice($crsproduct['Product']['id'])));
													echo $this->Form->input('CartOption', array('type'=>'hidden', 'name'=>'data[CartOption]', 'value'=>''));
													echo $this->Form->input('add_to_cart_url', array('type'=>'hidden', 'class'=>'addtocarturl', 'value'=>$this->Html->url(array('controller'=>'Products', 'action'=>'ajaxminicart', 'full_base'=>true))));
													echo $this->Form->input('showminicart', array('type'=>'hidden', 'class'=>'showminicart', 'value'=>$this->Html->url(array('controller'=>'Products', 'action'=>'showminicart', 'full_base'=>true))));
													echo $this->Form->end();
												
												}
												?>
												<p class="btn-details">
												<?php
												echo $this->Html->link('<i class="fa fa-list"></i> More details', SITE_URL.$crsproduct['Product']['product_slug'], array('escape'=>false));
												echo $this->Layout->wishlistLink($crsproduct['Product']['id']);
												?>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
								<?php
								if( ($count == count($crsproducts)) || ($count%4 == 0)){
									echo '</div></div>';
								}
								
							}
							?>
						</div>
						<div class="controls">
							<a data-slide="prev" href="#shop-crsl-1" class="left fa fa-chevron-left"> </a>
							<a data-slide="next" href="#shop-crsl-1" class="right fa fa-chevron-right"> </a>
						</div>
					</div>
				</div>
			</div>
			<?php }  ?>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function(){
	var form3 = $('#review_form');
	var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
		
	var validator = form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "", // validate all fields including form hidden input
		rules: {
			'data[ProductReview][name]': {
				required: true
			},
			'data[ProductReview][email]': {
				required: true,
				email:true
			},
			'data[ProductReview][review]': {
				required: true
			}
		},
		errorPlacement: function (error, element) { // render error placement for each input type
			if (element.attr("data-error-container")) { 
				error.appendTo(element.attr("data-error-container"));
			} else {
				error.insertAfter(element); // for other inputs, just perform default behavior
			}
		},

		invalidHandler: function (event, validator) { //display error alert on form submit   
			success3.hide();
			error3.show();
		},

		highlight: function (element) { // hightlight error inputs
		   $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
		},

		unhighlight: function (element) { // revert the change done by hightlight
			$(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
		},

		success: function (label) {
			label.closest('.form-group').removeClass('has-error'); // set success class to the control group
		}

	});
	
	$('#review_form').submit(function(e){
		e.preventDefault();
		
		if(validator.form()){
			var data = $(this).serialize();
			
			$.ajax({
				type:'POST',
				url:'<?php echo $this->Html->url(array('controller'=>'Products', 'action'=>'ajaxReview', 'full_base'=>true)); ?>',
				data:data,
				beforeSend:function(){
						$('#waitingDiv').show();
					},
					complete:function(){
						$('#waitingDiv').hide();
					},
				success:function(result){
					if(result== '1')
					{
						$('#rev_msg').show();
						$('#rev_msg').html('Review saved successfully! Once approved by administrator review will be shown');
					}else if(result== '2')
					{
						$('#rev_msg').show();
						$('#rev_msg').html('This product is not registered with this email address.');
					}else {
						$('#rev_msg').show();
						$('#rev_msg').html('No order received by this email address.');
					
					}
				}
			});
		}
	});
});
</script>