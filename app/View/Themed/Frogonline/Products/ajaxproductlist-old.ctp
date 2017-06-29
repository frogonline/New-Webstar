
<?php
$conditionStr = urldecode($data['conditionArr']);
$conditionArr = json_decode($conditionStr, true);
$ThemeSetting=$this->Session->read('ThemeSetting');
$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
$conditions = array();
$conditions = $conditionArr;
//pr($conditions);
//exit;
$order = array('product_name'=>'ASC');
if($ThemeSettingheadertype=='V') {
$limit = 3;
}else{
$limit = 4;
 } 
$products = $this->Layout->productlist($conditions, $order, $limit, $offset=$data['offset']);
//pr($products);

if(!empty($products)){
	?>
<div class="row">	
	<?php
	foreach($products as $product){
	$options = $this->Layout->mouldOptions($product['Product']['id']);
	//pr($options);
?>

	<?php if($ThemeSettingheadertype=='V') {
	?>
	<div class="col-md-4 col-sm-6 main-el">
	<?php }else{ ?>
	<div class="col-md-3 col-sm-6 main-el">
	<?php } ?>
		<div class="shop-col-item">
			<div class="photo">
			  <?php echo $this->Html->link($this->Html->image(IMGPATH.'product_image/original/'.$product['Product']['product_image'], array('alt'=>$product['Product']['product_name'],'class'=>'img-responsive')), SITE_URL.$product['Product']['product_slug'], array('escape'=>false));?>
			</div>
			<div class="info shop-box-background shop-box-text">
				<div>
					<div class="price">
						<h5><?php echo $this->Html->link($product['Product']['product_name'], SITE_URL.$product['Product']['product_slug']) ?></h5>
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
					<?php if(!empty($options)){ ?>
						<p class="btn-add"><i class="fa fa-shopping-cart"></i><?php echo $this->Html->link('Add to cart',SITE_URL.$product['Product']['product_slug']); ?></p>
					<?php } else { ?>
						<p class="btn-add"><?php echo $this->Html->link('<i class="fa fa-shopping-cart"></i> Add to cart','javascript:void(0);', array('onclick'=>'submitcart('.$product['Product']['id'].');', 'escape'=>false));  ?></p>
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
						?>
					<?php } ?>
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
	<?php
} else {
	echo "";
}
?>