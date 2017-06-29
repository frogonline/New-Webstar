<?php 
$ThemeSetting=$this->Session->read('ThemeSetting');
$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
?>
<div class="container">         
 
  <div class="">
  <?php if($ThemeSettingheadertype=='V'):	?>
    <div class=" col-md-3 main-el">
	 

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
		<?php endif; ?>
	
   <?php if($ThemeSettingheadertype=='V'):	?>
	<div class=" col-md-9 main-el">
	<?php endif;?>	
	
		  <div class="row">
			<div class="shop-wrapper main-el clearfix">
				<div class="col-md-12">
					<div class="sep-heading-container shc4 clearfix">
						<h4>Featured Items</h4>
						<div class="sep-container">
							<div class="the-sep"></div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="ajax-page-preloader" style="position: relative;">
						<div class="loader spinner">
							<img src="<?php echo CURRENT_THEME_URL.'img/loader.gif'; ?>" width="24" height="24">
							<div class="dot1"></div><div class="dot2"></div><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div>
						</div>
					</div>
					
					<?php
						$conditions = array();
						$conditions['Product'] = array('featured_flag'=>'TRUE');
						//$order = array('created_date'=>'DESC');
						$order = array('sequence'=>'ASC');
						$limit = $limit = ($ThemeSettingheadertype=='V')?9:10;
						$featured = $this->Layout->productlist($conditions, $order, $limit);
						//pr($featured);
					if(!empty($featured)){
					?>
					<div class="shop-masonry row isotope-container">
						<?php
						foreach($featured as $ftr){ 
						$options = $this->Layout->mouldOptions($ftr['Product']['id']);
						$rating = $this->Layout->rating($ftr['Product']['id']);	
						$ratingpoint=explode('.',$rating);
						
						?>
						<div class="<?php echo ($ThemeSettingheadertype=='V')?'col-md-4':'col-md-3'; ?> col-sm-6 main-el isotope-element isotope-element">
							<div class="shop-col-item">
								<div class="photo">
								<?php echo $this->Html->link($this->Html->image(IMGPATH.'product_image/resize/'.$ftr['Product']['product_image'], array('alt'=>$ftr['Product']['product_name'],'class'=>'img-responsive')), SITE_URL.$ftr['Product']['product_slug'], array('escape'=>false));?>
								
								</div>
								<div class="info shop-box-background shop-box-text ecombox1_backgound">
									<div>
										<div class="price">
				<h5><?php echo $this->Html->link($ftr['Product']['product_name'], SITE_URL.$ftr['Product']['product_slug'],array('class'=>'ecombox_pname')) ?></h5>
											<h5 class="main-text-color ecombox_pprice"><?php echo CURRENCY.number_format($this->Layout->actualprice($ftr['Product']['id']),2); ?></h5>
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
										
											<p class="btn-add"><i class="fa fa-shopping-cart"></i><?php echo $this->Html->link('Add to cart',SITE_URL.$ftr['Product']['product_slug'],array('class'=>'ecombox_addtocart')); ?></p>
										<?php } else { ?>
											<p class="btn-add"><?php echo $this->Html->link('<i class="fa fa-shopping-cart"></i> Add to cart','javascript:void(0);', array('onclick'=>'submitcart('.$ftr['Product']['id'].');', 'escape'=>false,'class'=>'ecombox_addtocart'));  ?></p>
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
										<p class="btn-details"><i class="fa fa-list ecombox_moredetails"></i>
										<?php echo $this->Html->link('More details', SITE_URL.$ftr['Product']['product_slug'],array('class'=>'ecombox_moredetails')) ?>									
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
							<center><strong>No featured product available here.</strong></center>
						</div>
						<div class="clearfix"></div>
					</div>
					<?php } ?>
				</div>
			</div> 
		</div>
		<div class="row">
			<div class="shop-wrapper main-el clearfix">
				<div class="col-md-12">
					<div class="sep-heading-container shc4 clearfix">
						<h4>New Arrivals</h4>
						<div class="sep-container">
							<div class="the-sep"></div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
				   <div class="ajax-page-preloader" style="position: relative;">
						<div class="loader spinner">
							<img src="<?php echo $this->webroot.'img/loader.gif'; ?>" width="24" height="24">
							<div class="dot1"></div><div class="dot2"></div><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div>
						</div>
					</div>

					
					<?php
						$conditions = array();
						$conditions['Product'] = array('newcollection_flag'=>'TRUE');
						$order = array('created_date'=>'DESC');
						$limit = ($ThemeSettingheadertype=='V')?9:10;
						$newArival = $this->Layout->productlist($conditions, $order, $limit);
						//pr($newArival);
					?>
					<?php 
						if(!empty($newArival)){	   
					?>
					<div class="shop-masonry row isotope-container">
						
						<?php
						foreach($newArival as $newArv){ 
						$options = $this->Layout->mouldOptions($newArv['Product']['id']);
						$rating = $this->Layout->rating($newArv['Product']['id']);	
						$ratingpoint=explode('.',$rating);
						?>
						<div class="<?php echo ($ThemeSettingheadertype=='V')?'col-md-4':'col-md-3'; ?> col-sm-6 main-el isotope-element isotope-element">
							<div class="shop-col-item">
								<div class="photo">
								<?php echo $this->Html->link($this->Html->image(IMGPATH.'product_image/resize/'.$newArv['Product']['product_image'], array('alt'=>$newArv['Product']['product_name'],'class'=>'img-responsive')), SITE_URL.$newArv['Product']['product_slug'], array('escape'=>false));?>
								
								</div>
								<div class="info shop-box-background shop-box-text ecombox1_backgound">
									<div>
										<div class="price">
				<h5><?php echo $this->Html->link($newArv['Product']['product_name'], SITE_URL.$newArv['Product']['product_slug'],array('class'=>'ecombox_pname')) ?></h5>
											<h5 class="main-text-color ecombox_pprice"><?php echo CURRENCY.number_format($this->Layout->actualprice($newArv['Product']['id']),2); ?></h5>
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
										<?php if(!empty($options)) {?>
			<p class="btn-add"><i class="fa fa-shopping-cart"></i><?php echo $this->Html->link('Add to cart',SITE_URL.$newArv['Product']['product_slug'],array('class'=>'ecombox_addtocart')); ?></p>
										<?php } else { ?>
											<p class="btn-add">
											<?php 
	echo $this->Html->link('<i class="fa fa-shopping-cart"></i> Add to cart','javascript:void(0);', array('onclick'=>'submitcart('.$newArv['Product']['id'].');', 'escape'=>false,'class'=>'ecombox_addtocart')); 
											?>
											</p>
											<?php
												echo $this->Form->create('Cart', array('id'=>'singlecart'.$newArv['Product']['id'], 'onsubmit'=>'return add_to_cart(this);', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
												echo $this->Form->input('session_id', array('type'=>'hidden', 'value'=>$this->Session->read('session_id')));
												echo $this->Form->input('product_id', array('type'=>'hidden', 'value'=>$newArv['Product']['id']));
												echo $this->Form->input('quantity', array('type'=>'hidden', 'value'=>1));
												echo $this->Form->input('unit_price', array('type'=>'hidden', 'value'=>$this->Layout->actualprice($newArv['Product']['id'])));
												echo $this->Form->input('CartOption', array('type'=>'hidden', 'name'=>'data[CartOption]', 'value'=>''));
												echo $this->Form->input('add_to_cart_url', array('type'=>'hidden', 'class'=>'addtocarturl', 'value'=>$this->Html->url(array('controller'=>'Products', 'action'=>'ajaxminicart', 'full_base'=>true))));
												echo $this->Form->input('showminicart', array('type'=>'hidden', 'class'=>'showminicart', 'value'=>$this->Html->url(array('controller'=>'Products', 'action'=>'showminicart', 'full_base'=>true))));
												echo $this->Form->end();
											?>
										<?php } ?>
										<p class="btn-details"><i class="fa fa-list ecombox_moredetails"></i>
										<?php echo $this->Html->link('More details', SITE_URL.$newArv['Product']['product_slug'],array('class'=>'ecombox_moredetails')) ?>									
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
							<center><strong>No new arrival product available here.</strong></center>
						</div>
						<div class="clearfix"></div>
					</div> 
					<?php } ?>
				</div>
			</div>  
		</div>		
		
	
	
	
	 <?php if($ThemeSettingheadertype=='V'):	?>
	</div>
	<?php endif;?>	
	</div>
  	
  </div>
  
  
  
  
  
  
  
			
</div>
<script>
$(window).load(function(){
	
	$('.col-md-12 .shop-masonry.row.isotope-container.isotope .col-md-3.col-sm-6.main-el.isotope-element.isotope-element.isotope-item').css('padding-bottom','15px !important');
	
	})
</script>