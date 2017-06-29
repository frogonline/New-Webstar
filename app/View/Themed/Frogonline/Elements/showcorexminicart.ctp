<div id="nav-shop" class="panel-collapse collapse">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-9 col-xs-12">
				<div class="items">
				<?php
					$session_id = $this->Session->read('session_id');
					$cartArr = $this->Layout->generateCartArray($session_id);
				?>
				<?php 	if(!empty($cartArr)):	?>
				<?php foreach($cartArr as $item): ?>
						<div class="item">
						<a class="image pull-left mgp-img" href="<?php echo IMGPATH.'product_image/original/'.$item['Product']['product_image']; ?>">
							<img class="img-responsive" alt="" src="<?php echo IMGPATH.'product_image/thumb/'.$item['Product']['product_image']; ?>">
						</a>
						<div class="text pull-left">
							<p><a href="<?php echo $item['Product']['product_slug']; ?>"><?php echo $item['Product']['product_name']; ?> </a></p>
							<p><?php echo $item['Cart']['gross_price'] ?>/<?php echo $item['Cart']['unit_price']; ?></p>
							<h6 class="main-text-color"><?php echo $this->Html->link('&nbsp;', '#', array(
												'class'=>'del-goods fa fa-times-circle-o main-text-color', 
												'escape'=>false,
												'data-id'=>$item['Cart']['id'],
												'data-url'=>$this->Html->url(array('controller'=>'Products','action'=>'ajaxremoveminicart', 'full_base'=>true)),
												'data-minicarturl'=>$this->Html->url(array('controller'=>'Products','action'=>'showcorexminicart', 'full_base'=>true)),
												'data-fullcarturl'=>$this->Html->url(array('controller'=>'Carts','action'=>'showfullcart', 'full_base'=>true)),
												'onclick'=>'return removecart(this);'
												)
											); 
										?></h6>
						</div>
					</div>
				
				<?php endforeach; ?>
				<?php 	endif;	?>
				
				</div>
			</div>

			<div class="col-sm-6 col-md-3 col-xs-12 cart">
				<h4>CART SUBTOTAL <span class="medium"> <?php echo CURRENCY.' '.$cartArr = $this->Layout->totalCartPrice(); ?> </span></h4>
				<div class="sep"></div>
				<a class="button striped md blue" href="<?php echo SITE_URL.'cart'; ?>">view cart</a>
				<a class="button solid md blue" href="<?php echo SITE_URL.'checkout'; ?> "><div class="over">proceed to checkout</div></a>
			</div>
		</div>
	</div>
</div>