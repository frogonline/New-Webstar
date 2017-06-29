<?php 
$siteSettings = $this->Session->read('siteSettings');
$session_id = $this->Session->read('session_id');
?>
<div class="panel-body row">
	<?php echo $this->Form->create('Order', array('id'=>"shippingmethodForm", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<!---<p>Please select the preferred shipping method to use on this order.</p>
		<h4>Flat Rate</h4>
		<div class="radio-list">
			<label>
				<?php //echo $this->Form->radio('shipping_method', array('FlatShippingRate'=>' Flat Shipping Rate'), array('data-error-container'=>'#shpmthdradiomsg', 'hiddenField'=>false)); ?>
				<!--<input type="radio" name="FlatShippingRate" value="FlatShippingRate"> Flat Shipping Rate
			</label>
			<p id="shpmthdradiomsg"></p>
		</div> --->
		
		
		<?php if($siteSettings['SiteSetting']['free_shipping']=='Y') { ?>
				<?php 
				$cartArr = $this->Layout->totalCartPrice();
				$amount=$siteSettings['SiteSetting']['amount'];
				?>
			<?php if($cartArr>= $amount) { ?>
			
				<div id="schaww" style="" class="form-group control-label">Shipping charges : Free</div>
				<?php echo $this->Form->input('shipping_cost',array("type"=>"hidden","label"=>false,'value'=>0,'id'=>'shipping_cost')); ?>
			
			<?php } else { ?>
					<?php if($siteSettings['SiteSetting']['shipping_flag']=='C'){ ?>
										<div class="col-md-12">
										<p>Select Shipping Methods.</p>
										<div class="radio-list">
											<?php 
												echo $this->Form->input('shipping_rate',
													array(
														'options'=>$shipping,
														'data-error-container'=>'#fff',
														'before' => '<label class="col-md-2">',
														'after' => '</label>',
														'separator' => '</label><label class="col-md-2">',
														'type'=>'radio',
														'class'=>'shippingcart',
														'legend'=>false,
														'hiddenField'=>false
													)
												); 
											?>
											<br/>
											<br/>
											<p id="fff"></p>
										</div>
										<br/>
										<div id="scha" style="display:none;" class="form-group"></div>
										<?php echo $this->Form->input('shipping_cost',array("type"=>"hidden","label"=>false, 'id'=>'shipping_cost')); ?>
									</div>
										
					<?php }else if($siteSettings['SiteSetting']['shipping_flag']=='I') { ?>
							<?php 
							$productinformation = $this->Layout->generateCartArray($session_id);
							//pr($productinformation );
							$valueshipping1=0;
							foreach($productinformation as $productinformationre){
						$valueshipping=$this->Layout->generateShippingArray($productinformationre['Product']['id'],$stateitem);
								foreach($valueshipping[0]['ProductShippingValue'] as $val)
								{
									$count=$productinformationre['Cart']['gross_price']/$productinformationre['Cart']['unit_price'];
									$valueshipping1=$valueshipping1 + ($val*$count);
								}
							}
							?>
							<div id="schaww" style="" class="form-group control-label">Shipping charges : <?php echo CURRENCY."".$valueshipping1;  ?></div>
							<?php echo $this->Form->input('shipping_cost',array("type"=>"hidden","label"=>false,'value'=>$valueshipping1,'id'=>'shipping_cost')); ?>
					<?php } } ?>
		<?php } else { ?>
		
			<?php if($siteSettings['SiteSetting']['shipping_flag']=='C'){ ?>
										<div class="col-md-12">
										<p>Select Shipping Methods.</p>
										<div class="radio-list">
											<?php 
												echo $this->Form->input('shipping_rate',
													array(
														'options'=>$shipping,
														'data-error-container'=>'#fff',
														'before' => '<label class="col-md-2">',
														'after' => '</label>',
														'separator' => '</label><label class="col-md-2">',
														'type'=>'radio',
														'class'=>'shippingcart',
														'legend'=>false,
														'hiddenField'=>false
													)
												); 
											?>
											<br/>
											<br/>
											<p id="fff"></p>
										</div>
										<br/>
										<div id="scha" style="display:none;" class="form-group"></div>
										<?php echo $this->Form->input('shipping_cost',array("type"=>"hidden","label"=>false, 'id'=>'shipping_cost')); ?>
									</div>
										
					<?php }else if($siteSettings['SiteSetting']['shipping_flag']=='I') { ?>
							<?php 
							$productinformation = $this->Layout->generateCartArray($session_id);
							//pr($productinformation );
							$valueshipping1=0;
							foreach($productinformation as $productinformationre){
						$valueshipping=$this->Layout->generateShippingArray($productinformationre['Product']['id'],$stateitem);
								foreach($valueshipping[0]['ProductShippingValue'] as $val)
								{
									$count=$productinformationre['Cart']['gross_price']/$productinformationre['Cart']['unit_price'];
									$valueshipping1=$valueshipping1 + ($val*$count);
								}
							}
							?>
							<div id="schaww" style="" class="form-group control-label">Shipping charges : <?php echo CURRENCY."".$valueshipping1;  ?></div>
							<?php echo $this->Form->input('shipping_cost',array("type"=>"hidden","label"=>false,'value'=>$valueshipping1,'id'=>'shipping_cost')); ?>
					<?php } ?>
		
		<?php } ?>
		</br>
		<div class="row form-group" style="">
			<label for="delivery-comments" class="control-label col-md-12">Add Comments About Your Order</label>
			<div class="control-label col-md-12"><?php echo $this->Form->input('order_comments', array('type'=>'textarea', 'class'=>'form-control', 'row'=>'8')); ?></div>
			<!--<textarea id="delivery-comments" rows="8" class="form-control"></textarea>-->
		<?php 
			echo $this->Form->input('url',array('type'=>'hidden', 'id'=>'paymentmethodsurl', 'value'=>$this->Html->url(array('controller'=>'Orders', 'action'=>'ajaxstep5', 'full_base'=>true))));?>
			<div class="control-label col-md-12">
			<?php echo $this->Form->button('Continue', array('class'=>'btn btn-primary pull-right brown-bg mrgtop5', 'type'=>'submit', 'data-toggle'=>'collapse', 'data-parent'=>'#checkout-page', 'data-target'=>'#payment-method-content')); 
			?>
			</div>
		<!--<button class="btn btn-primary  pull-right" type="submit" id="button-shipping-method" data-toggle="collapse" data-parent="#checkout-page" data-target="#payment-method-content">Continue</button>-->
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
	Layout.initUniform();
	Checkout.init();
	$('.shippingcart').click(function(e){
			if($(this).is(':checked')){
				var shippingvalue = $(this).val();
				$('#scha').show();
				$('#scha').html('Shipping charges: <?php echo CURRENCY ?>'+shippingvalue);
				$('#shipping_cost').val(shippingvalue)
				
				
			}
		});
});
</script>