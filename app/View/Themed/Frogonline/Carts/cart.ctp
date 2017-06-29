<?php
echo $this->Layout->pagecrumb('page', 'Cart');
$ThemeSetting=$this->Session->read('ThemeSetting');
$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
?>
<div class="container">	
	<div class="row">
	<?php  if($ThemeSettingheadertype=='V'){?>
	
	<div class="ecomerce sidebar col-md-3 main-el">
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
	
	
		<div class="col-md-9 shop-panel">
	<?php }else{ ?>
		<div class="col-md-12 shop-panel">
		<?php } ?>
			<div class="row" id="shop-cart-block">
				<?php
				$session_id = $this->Session->read('session_id');
				$cartArr = $this->Layout->generateCartArray($session_id);
				//pr($cartArr);
				if(!empty($cartArr)){
				?>
				<div class="cart-list col-md-12 main-el alt-bg-color">
				
					<div class="head main-bg-color alt-text-color bold clearfix">
						<div class="section product">Product</div>
						<div class="section prc">Price</div>
						<div class="section qty">Quantity</div>
						<div class="section total">Total</div>
					</div>
					<form name="updtcart" id="updatecartform" method="post" action="<?php echo SITE_URL.'carts/FnUpdateCart'?>">
					<?php $i = 0; foreach($cartArr as $item){ ?>
					
					<div class="line clearfix">
						<div class="icon">
						<?php echo $this->Html->link('&nbsp;', '#', array(
									'class'=>'del-goods fa fa-times-circle-o main-text-color', 
									'escape'=>false,
									'data-id'=>$item['Cart']['id'],
									'data-url'=>$this->Html->url(array('controller'=>'Products','action'=>'ajaxremoveminicart', 'full_base'=>true)),
									'data-minicarturl'=>$this->Html->url(array('controller'=>'Products','action'=>'showcorexminicart', 'full_base'=>true)),
									'data-fullcarturl'=>$this->Html->url(array('controller'=>'Carts','action'=>'showfullcart', 'full_base'=>true)),
									'onclick'=>'return removecart(this);'
									)
								); 
							?>
							
						</div>
						<div class="mini-image"><img src="<?php echo IMGPATH.'product_image/thumb/'.$item['Product']['product_image']; ?>" alt="" class="img-responsive center-block"></div>
						<div class="name medium"><a href="<?php echo $item['Product']['product_slug']; ?>"><?php echo $item['Product']['product_name']; ?></a></div>
						<div class="price"><?php echo CURRENCY.''.number_format($item['Cart']['unit_price'], 2); ?></div>
						
						<div class="quantity">
							<span style="text-align:center;float:left;width:100%;">
							<?php
							echo $this->Html->link('<div class="oparetor">-</div>', 'javascript:void(0);', array('class'=>'button grey solid ctrl', 'escape'=>false, 'onclick'=>'fnDecrese(this);'));
							if($ThemeSettingheadertype=='V')
							{
								echo $this->Form->input('quantity', array('type'=>'text', 'readonly'=>true, 'name'=>'quantity[]', 'value'=>$item['Cart']['quantity'], 'data-qty'=>$item['Product']['product_quantity'], 'style'=>"width:55%",'class'=>'amount bold', 'label'=>false, 'div'=>false));
							}else{
								echo $this->Form->input('quantity', array('type'=>'text', 'readonly'=>true, 'name'=>'quantity[]', 'value'=>$item['Cart']['quantity'], 'data-qty'=>$item['Product']['product_quantity'], 'style'=>"width:55%", 'class'=>'amount bold', 'label'=>false, 'div'=>false));
							}
							echo $this->Html->link('<div class="oparetor">+</div>', 'javascript:void(0);', array('class'=>'button grey solid ctrl', 'escape'=>false, 'onclick'=>'fnIncrese(this);'));
							?>
							<input class="amount bold " type="hidden" value="<?php echo $item['Cart']['id'] ?>" name="cartid[]" kl_virtual_keyboard_secure_input="on" style="width:20%;">
							<input class="amount bold " type="hidden" value="<?php echo $item['Cart']['unit_price'] ?>" name="unit_price[]" kl_virtual_keyboard_secure_input="on" style="width:20%;">
							
							</span>
							<span id="error_sub_<?php echo $item['Cart']['id'] ?>" style="display:none; color:red;text-align:center;float:left;width:100%;"></span>
						</div>
						<div class="price total"><?php echo CURRENCY.''.number_format($item['Cart']['gross_price'], 2); ?></div>
						
					</div>
					<?php } ?>
				
					<div class="inputs clearfix">
					<?php if(!empty($cartArr)){ ?>
						<!--<div class="pull-left">
							<?php $this->Form->create('Coupon'); ?>
							<?php $this->Form->input('code', array('class'=>'coupon form-control')); ?>
							
							<?php echo $this->Html->link('<div class="over">Apply Coupon</div>', array('controller'=>'Carts', 'action'=>'ajaxCoupon'), array('class'=>'button solid blue md', 'escape'=>false)); ?>
							<?php $this->Form->end(); ?>
						</div>-->
						<div class="pull-right">
							<a  class="button solid blue md" onclick="FnSubmitForm();"><div class="over addwishlist_btn_backgound">update cart</div></a>
							
							<?php echo $this->Html->link('<div class="over addwishlist_btn_backgound">Proceed to Checkout</div>', array('controller'=>'Orders', 'action'=>'checkout'), array('class'=>'button solid blue md', 'escape'=>false)); ?>
						</div>
					<?php } ?>
					</div>
				 
				</div>
				</form>
				
				<div class="col-md-6 main-el pull-right col-xs-12">
					<div class="totals alt-bg-color">
						<div class="head main-bg-color alt-text-color">
						cart total
						</div>

						<div class="inside">
							<!--<div class="line cart-sub clearfix">
								<div class="item">Cart Subtotal</div>
								<div class="value"><?php //echo CURRENCY.' '.$cartArr = $this->Layout->totalCartPrice(); ?></div>
							</div>
							<div class="line cart-ship clearfix">
								<div class="item">Shipping</div>
								<div class="value"><?php //echo CURRENCY.' 0.00'; ?> </div>
							</div> -->
							<div class="line cart-total clearfix">
								<div class="item">Order Total</div>
				<div class="value main-text-color"><?php echo CURRENCY.''.number_format($cartArr = $this->Layout->totalCartPrice(),2); ?></div>
				
				
							</div>
						</div>
					</div>
				</div>
				<?php } else { ?>
				<div class=" col-sm-12 col-md-6 col-lg-9" style="text-align:center;color:red;">
					<div class="alert alert-success" id="flashMessage"><div>No Product in cart</div></div>
				</div> 
				<div class="col-sm-12 col-md-6 col-lg-3">
					<a class="button solid blue md" href="<?php echo SITE_URL.'ecommerce'; ?>"><div class="over addwishlist_btn_backgound">Continue Shopping</div></a>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12 main-el">
			<div class="sep-line"></div>
		</div>
	</div>
	<?php 
		/* $section = array('category_menu','best_seller');
		echo $this->element('layout_ecommerce_bestseller_footer', array('section'=>$section));	 */	
	?> 
</div>

<script type="text/javascript">
function FnSubmitForm()
{
	$('#updatecartform').submit();
}
</script>