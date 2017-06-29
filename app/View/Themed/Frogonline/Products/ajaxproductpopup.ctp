<div class="product-page product-pop-up">
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-3">
			<div class="product-main-image">
				<?php echo $this->Html->image(IMGPATH.'product_image/original/'.$product['Product']['product_image'], array('alt'=>$product['Product']['product_name'], 'id'=>'main_image', 'class'=>'img-responsive')); ?>
			</div>
			<div class="product-other-images">
			<?php 
				echo $this->Html->link(
					$this->Html->image(IMGPATH.'product_image/thumb/'.$product['Product']['product_image'], array('alt'=>'Gallery')),
					IMGPATH.'product_image/original/'.$product['Product']['product_image'],
					array('escape'=>false,'class'=>'gal active')
				);
				if(!empty($product['ProductGallery'])){
					$i=0;
					foreach($product['ProductGallery'] as $gallery){
			?>
				<?php 
					echo $this->Html->link(
						$this->Html->image(IMGPATH.'product_gallery/thumb/'.$gallery['image_name'],array('alt'=>'Gallery')),
						IMGPATH.'product_gallery/original/'.$gallery['image_name'],
						array('escape'=>false,'class'=>'gal')
					); 
				?>
			<?php
					$i++;
					}
				}
			?>
			</div>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-9">
			<h2><?php echo $product['Product']['product_name']; ?></h2>
			<div class="price-availability-block clearfix">
				<div class="price">
					<strong><span><?php echo CURRENCY; ?></span><?php echo number_format($this->Layout->actualprice($product['Product']['id']),2); ?></strong>
					<?php if($product['Product']['product_discount']!=0){ ?>
					<em><?php echo CURRENCY; ?><span><?php echo number_format($product['Product']['product_price'],2); ?></span></em>
					<?php } ?>
				</div>
				<div class="availability">
					Availability: <strong><?php echo ($product['Product']['stock_flag'])?'In Stock':'Out of stock'; ?></strong>
				</div>
			</div>
			<div class="description">
				<p><?php echo $product['Product']['product_description']; ?></p>
			</div>
			<?php echo $this->Form->create('Cart', array('id'=>"cart_form", 'onsubmit'=>'return add_to_cart(this);', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
			<div class="product-page-options">
				<?php
					if(!empty($options)){
						foreach($options as $optionKey=>$optionVal){
				?>
				<div class="pull-left">
					<label class="control-label"><?php echo ucfirst($optionKey); ?>:</label>
					<select name="data[CartOption][option_value][<?php echo $optionVal['id']; ?>]" class="form-control input-sm">
						<option value="">Select <?php echo ucfirst($optionKey); ?></option>
						<?php foreach($optionVal['values'] as $value){ ?>
						<option value="<?php echo $value['id']; ?>"><?php echo $value['option_value_name']; ?></option>
						<?php } ?>
					</select>
					<?php echo $this->Form->input('', array('type'=>'hidden', 'name'=>'data[CartOption][option_id][]', 'value'=>$optionVal['id'])); ?>
				</div>
				<?php
						}
				
					} else {
						echo "No options available for this product.";
					}
				?>
			</div>
			<div class="product-page-cart">
				<div class="product-quantity">
					<?php echo $this->Form->input('quantity', array('type'=>'text', 'id'=>'product-quantity', 'readonly'=>true, 'value'=>'1', 'class'=>'form-control input-sm')); ?>
				</div>
				<?php 
					echo $this->Form->input('session_id', array('type'=>'hidden','value'=>$this->Session->read('session_id')));
					echo $this->Form->input('product_id', array('type'=>'hidden','value'=>$product['Product']['id']));
					echo $this->Form->input('unit_price', array('type'=>'hidden','value'=>$this->Layout->actualprice($product['Product']['id']) ));
					echo $this->Form->input('add_to_cart_url', array('type'=>'hidden', 'class'=>'addtocarturl', 'value'=>$this->Html->url(array('controller'=>'Products', 'action'=>'ajaxminicart', 'full_base'=>true))));
					echo $this->Form->input('showminicart', array('type'=>'hidden', 'class'=>'showminicart', 'value'=>$this->Html->url(array('controller'=>'Products', 'action'=>'showminicart', 'full_base'=>true))));
					echo $this->Form->button('Add to cart', array('type' => 'submit','class'=>'btn btn-primary')); 
				?>
				<?php echo $this->Html->link('More details',SITE_URL.$product['Product']['product_slug'], array('class'=>'btn btn-default')); ?>
			</div>
			<?php echo $this->Form->end(); ?>
			<div class="note note-success" id="addtocartmsg" style="display:none;">
			</div>
		</div>
		<?php echo ($product['Product']['onsale_flag'])?'<div class="sticker sticker-sale"></div>':''; ?>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function() {
		Layout.initImageZoom();
		Layout.initTouchspin();
		$('.gal').click(function(e){
			e.preventDefault();
			var main_img = $(this).attr('href');
			$('#main_image').attr('src',main_img);
			$('.zoomImg').attr('src',main_img);
			Layout.initImageZoom();
		});
		
		$('#addtocartmsg').click(function(e){
			e.preventDefault();
			$(this).hide();
		});
	});
</script>