<div class="panel-body row">
	<div class="col-md-12 clearfix">
		<?php
		$session_id = $this->Session->read('session_id');
		$cartArr = $this->Layout->generateCartArray($session_id);
		//pr($cartArr);
		if(!empty($cartArr)){
			echo $this->Form->create('Order', array('id'=>"orderconfirmForm", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
		?>
		<div class="table-wrapper-responsive">
			<table style="width:100%;">
				<tr>
					<th class="checkout-image">Image</th>
					<th class="checkout-description">Description</th>
					<th class="checkout-model">Model</th>
					<th class="checkout-quantity">Quantity</th>
					<th class="checkout-price">Price</th>
					<th class="checkout-total">Total</th>
				</tr>
				<?php 
					$i = 0;
					foreach($cartArr as $item){ 
				?>
				<tr>
					<td class="checkout-image">
						<?php 
						echo $this->Html->link(
							$this->Html->image(IMGPATH.'product_image/thumb/'.$item['Product']['product_image'], array('alt'=>$item['Product']['product_name'])),
							SITE_URL.$item['Product']['product_slug'],
							array('escape'=>false)
						); 
						?>
					</td>
					<td class="checkout-description">
						<h3><?php echo $this->Html->link($item['Product']['product_name'], SITE_URL.$item['Product']['product_slug']); ?></h3>
						<?php
							foreach($item['CartOption'] as $option){
						?>
						<p>
							<strong><?php echo ucfirst($option['ProductOption']['options_name']); ?></strong> - <?php echo $option['OptionValue']['option_value_name']; ?>
						</p>
						<?php
							}
						?>
					</td>
					<td class="checkout-model">
						<?php echo $item['Product']['product_sku'] ?>
					</td>
					<td class="checkout-quantity">
						<?php echo $item['Cart']['quantity']; ?>
					</td>
					<td class="checkout-price">
						<strong><span><?php echo CURRENCY; ?></span><?php echo $item['Cart']['unit_price']; ?></strong>
					</td>
					<td class="checkout-total">
						<strong><span><?php echo CURRENCY; ?></span><?php echo $item['Cart']['gross_price'] ?></strong>
					</td>
				</tr>
				<?php 
					$i++;
					} 
				?>
			</table>
		</div>
		<div class="col-md-6 main-el pull-right shop-panel">
			<div class="totals alt-bg-color">
				<div class="head main-bg-color alt-text-color">
					Order Total
				</div>
				<div class="inside">
					<div class="line cart-sub clearfix">
						<div class="item">Sub total</div>
						<div class="value"><span><?php echo CURRENCY; ?></span><?php echo $cartArr = $this->Layout->totalCartPrice(); ?></div>
					</div>
					<div class="line cart-sub clearfix">
						<div class="item">Shipping cost</div>
						<div class="value"><span><?php echo CURRENCY; ?></span><?php echo (!empty($data))?number_format($data['Order']['shipping_cost'],2):'0.00'; ?></div>
					</div>
					<div class="line cart-sub clearfix">
						<div class="item">Total</div>
						<div class="value">
						<?php  	$cartprice = $this->Layout->totalCartPrice();
								$cartprice = str_replace(',', '', $cartprice);
								$ship = (!empty($data))?$data['Order']['shipping_cost']:'0.00';
								/* echo $cartprice;
								echo '<br/>';
								echo $ship; */
								$total= number_format(($cartprice + $ship),2);
								
								//echo $total;

						?>
						<span><?php echo CURRENCY; ?><?php echo $total; ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<?php 
			$total = $this->Layout->totalCartPrice();
			echo $this->Form->input('order_amount', array('type'=>'hidden', 'value'=>$total));
			echo $this->Form->input('url',array('type'=>'hidden', 'id'=>'ordersubmiturl', 'value'=>$this->Html->url(array('controller'=>'Orders', 'action'=>'ajaxordersubmit', 'full_base'=>true))));
			echo $this->Form->input('redirecturl',array('type'=>'hidden', 'id'=>'redirecturl', 'value'=>$this->Html->url(array('controller'=>'Orders', 'action'=>'payment', 'full_base'=>true))));
			echo $this->Form->button('Confirm Order', array('class'=>'btn btn-primary pull-right', 'type'=>'submit')); 
		?>
		<!--<button class="btn btn-primary pull-right" type="submit" id="button-confirm">Confirm Order</button>-->
		<!--<button type="button" class="btn btn-default pull-right margin-right-20">Cancel</button>-->
		<?php echo $this->Form->end(); ?>
		<?php } else { ?>
		<div class="note note-success">
			<h1 style="text-align:center;">No Product Available in your cart</h1>
		</div>
		<?php } ?>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
	Layout.initUniform();
	Checkout.init();
});
</script>
			
