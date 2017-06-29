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
		<div class="price"><?php echo $item['Cart']['unit_price']; ?></div>
		<div class="quantity">
			<span style="text-align:center;float:left;width:100%;">
			<?php
			echo $this->Html->link('<div class="">-</div>', 'javascript:void(0);', array('class'=>'button grey solid ctrl', 'escape'=>false, 'onclick'=>'fnDecrese(this);'));
			echo $this->Form->input('quantity', array('type'=>'text', 'readonly'=>true, 'name'=>'quantity[]', 'value'=>$item['Cart']['quantity'], 'data-qty'=>$item['Product']['product_quantity'], 'class'=>'amount bold', 'style'=>"width:55%", 'label'=>false, 'div'=>false));
			echo $this->Html->link('<div class="">+</div>', 'javascript:void(0);', array('class'=>'button grey solid ctrl', 'escape'=>false, 'onclick'=>'fnIncrese(this);'));
			?>
			<input class="amount bold " type="hidden" value="<?php echo $item['Cart']['id'] ?>" name="cartid[]" kl_virtual_keyboard_secure_input="on" style="width:20%;">
			<input class="amount bold " type="hidden" value="<?php echo $item['Cart']['unit_price'] ?>" name="unit_price[]" kl_virtual_keyboard_secure_input="on" style="width:20%;">
			
			</span>
			<span id="error_sub_<?php echo $item['Cart']['id'] ?>" style="display:none; color:red;text-align:center;float:left;width:100%;"></span>
		</div>
		<div class="price total"><?php echo CURRENCY; ?></span><?php echo $item['Cart']['gross_price'] ?></div>
	</div>
	<?php } ?>

	<div class="inputs clearfix">
	<?php if(!empty($cartArr)){ ?>
		<!----<div class="pull-left">
			<input class="coupon form-control">
			<a class="button solid blue md"><div class="over"> apply coupon</div></a>
		
		</div> ---->
		<div class="pull-right">
			<a  class="button solid blue md" onclick="FnSubmitForm();"><div class="over addwishlist_btn_backgound">update cart</div></a>
			
			<?php echo $this->Html->link('<div class="over addwishlist_btn_backgound">Proceed to Checkout</div>', array('controller'=>'Orders', 'action'=>'checkout'), array('class'=>'button solid blue md', 'escape'=>false)); ?>
		</div>
	<?php } ?>
	</div>
 
</div>
</form>

<div class="col-md-6 main-el pull-right">
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
				<div class="value"><?php // echo CURRENCY.' 0.00'; ?> </div>
			</div> -->
			<div class="line cart-total clearfix">
				<div class="item">Order Total</div>
				<div class="value main-text-color"><?php echo CURRENCY.' '.$cartArr = $this->Layout->totalCartPrice(); ?></div>
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

<?php
echo $this->Html->script('removecart');
echo $this->Html->script('addtocart');
?>
					