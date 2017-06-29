<?php
echo $this->Layout->pagecrumb('product', 'Product Search', $productname, 'search');
?>

<!--<div class="pagecrumbs">
	<div class="container">
		<div class="row">
			<div class="col-xs-4">
				<h5 class="medium">Search results for: <?php echo $productname; ?></h5>
			</div>
			<div class="col-xs-8">
				<div class="location pull-right">
					<span class="medium">You are here: </span><a href="<?php echo SITE_URL;?>">Home</a> / <a href="#">Product Search</a>
				</div>
			</div>
		</div>
	</div>
</div>-->
<div class="content">
<div class="container">         
  
	<div class="row">
		<div class="shop-wrapper main-el clearfix">
			<div class="col-md-12">
				<div class="ajax-page-preloader" style="position: relative;">
					<div class="loader spinner">
						<img src="<?php echo CURRENT_THEME_URL.'img/loader.gif'; ?>" width="24" height="24">
						<div class="dot1"></div><div class="dot2"></div><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div>
					</div>
				</div>
				
				<?php
				if(!empty($featured)){
				?>
				<div class="shop-masonry row isotope-container">
					<?php
					foreach($featured as $ftr){ 
					$options = $this->Layout->mouldOptions($ftr['Product']['id']);
					$rating = $this->Layout->rating($ftr['Product']['id']);	
					$ratingpoint=explode('.',$rating);
					
					?>
					<div class="col-md-3 col-sm-6 main-el isotope-element isotope-element">
						<div class="shop-col-item">
							<div class="photo">
							<?php echo $this->Html->link($this->Html->image(IMGPATH.'product_image/resize/'.$ftr['Product']['product_image'], array('alt'=>$ftr['Product']['product_name'],'class'=>'img-responsive')), SITE_URL.$ftr['Product']['product_slug'], array('escape'=>false));?>
							
							</div>
							<div class="info shop-box-background shop-box-text">
								<div>
									<div class="price">
										<h5><?php echo $this->Html->link($ftr['Product']['product_name'], SITE_URL.$ftr['Product']['product_slug']) ?></h5>
										<h5 class="main-text-color"><?php echo CURRENCY.number_format($this->Layout->actualprice($ftr['Product']['id']),2); ?></h5>
									</div>
									<?php 									
								if(!empty($rating)){
							?>
							<div class="rating">
							<?php 
								$s=1;
								if($ratingpoint[0]!=5)
								{
									for($s=1; $s<=$ratingpoint[0]; $s++)
									{
							?>
							<i class="main-text-color fa fa-star" style="color:red"></i>
							<?php 
									}
								}
								else 
								{
								
								for($s=1; $s<=5; $s++)
									{
								?>	
							<i class="main-text-color fa fa-star" style="color:red"></i>
								<?php 
									}
								}
								if(!empty($ratingpoint[1]))
								{
								?>
							<i class="main-text-color fa fa-star" style="color:red"></i>
								<?php 	
									$s=$s+1;
									$s1=$s;
									for($s1=$s; $s1<=5; $s1++)
									{
								?>
								<i class="main-text-color fa fa-star"></i>
								<?php 
									}
								}
								?>
								<?php 
									if(empty($ratingpoint[1]))
									{
									?>	
									<?php 	
										$s=$s;
										$s1=$s;
										for($s1=$s; $s1<=5; $s1++)
										{
									?>
									<i class="main-text-color fa fa-star"></i>
									<?php 
										}
										
									
									}
									?>
								</div>
								<?php 
								}
								
								if(empty($ratingpoint[0])) {
								?>
								<div class="rating">										
								<i class="main-text-color fa fa-star"></i>
								<i class="main-text-color fa fa-star"></i>
								<i class="main-text-color fa fa-star"></i>
								<i class="main-text-color fa fa-star"></i>
								<i class="main-text-color fa fa-star"></i>
								</div>
							<?php
								
								}
								?>
								</div>
								<div class="btns clear-left">
									<?php if(!empty($options)){ ?>
										<p class="btn-add"><i class="fa fa-shopping-cart"></i><?php echo $this->Html->link('Add to cart',SITE_URL.$ftr['Product']['product_slug']); ?></p>
									<?php } else { ?>
										<p class="btn-add"><?php echo $this->Html->link('<i class="fa fa-shopping-cart"></i> Add to cart','javascript:void(0);', array('onclick'=>'submitcart('.$ftr['Product']['id'].');', 'escape'=>false));  ?></p>
										<?php
											echo $this->Form->create('Cart', array('id'=>'singlecart'.$ftr['Product']['id'], 'onsubmit'=>'return add_to_cart(this);', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
											echo $this->Form->input('session_id', array('type'=>'hidden', 'value'=>$this->Session->read('session_id')));
											echo $this->Form->input('product_id', array('type'=>'hidden', 'value'=>$ftr['Product']['id']));
											echo $this->Form->input('quantity', array('type'=>'hidden', 'value'=>1));
											echo $this->Form->input('unit_price', array('type'=>'hidden', 'value'=>$this->Layout->actualprice($ftr['Product']['id'])));
											echo $this->Form->input('CartOption', array('type'=>'hidden', 'name'=>'data[CartOption]', 'value'=>''));
											echo $this->Form->input('add_to_cart_url', array('type'=>'hidden', 'class'=>'addtocarturl', 'value'=>$this->Html->url(array('controller'=>'Products', 'action'=>'ajaxminicart', 'full_base'=>true))));
											echo $this->Form->input('showminicart', array('type'=>'hidden', 'class'=>'showminicart', 'value'=>$this->Html->url(array('controller'=>'Products', 'action'=>'showminicart', 'full_base'=>true))));
											echo $this->Form->end();
										?>
									<?php } ?>
									<p class="btn-details"><i class="fa fa-list"></i>
									<?php echo $this->Html->link('More details', SITE_URL.$ftr['Product']['product_slug']) ?>									
									</p>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
				   
					<?php } ?>
				</div>
				<?php } else { ?>
				<div class="alert alert-noicon sc">
					<div class="text col-md-12 col-sm-7">
						<center><strong>No products available here. </strong></center>
					</div>
					<div class="clearfix"></div>
				</div>
				<?php } ?>
			</div>
		</div> 
	</div>
</div>
</div>