<?php
if($this->Session->read('loggedin_status')){
	$loginStatus = true;
} else {
	$loginStatus = false;
}

$siteSetting = $this->Session->read('siteSettings');
?>
<div class="container">
	<div class="row">
		<div class="col-md-12 main-el">
			<div class="alert alert-noicon">
				<div class="text">
					<center><span class="bold"><img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" /> Please wait while we are redirecting you to the payment page </span></center>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
if(!empty($orderData)){
	if($orderData['Order']['payment_method']=='PAYPAL'){
		$total_amount=number_format((float)$orderData['Order']['order_amount']+(float)$orderData['Order']['shipping_cost'],2);
		
		if ($siteSetting['SiteSetting']['paypal_mode']=='S'){
			$payurl='https://www.sandbox.paypal.com/cgi-bin/webscr';
		}
		else{
			$payurl='https://www.paypal.com/cgi-bin/webscr';
			}
		
		
		?>
		<form action="<?php echo $payurl; ?>" method="post" id="paypalForm" name="f1">
			<input type="hidden" name="cmd" value="_xclick">
			<input type="hidden" name="rm" value="2">
			<input type="hidden" name="currency_code" value="<?php echo $siteSetting['SiteSetting']['currency']; ?>">
			<input type="hidden" name="business" value="<?php echo $siteSetting['SiteSetting']['paypal_business_email']; ?>">
			<input type="hidden" name="item_name" value="<?php echo 'Order From '.$siteSetting['SiteSetting']['meta_title']; ?> ">
			<input type="hidden" name="amount" value="<?php echo $total_amount; ?>">
			<input type="hidden" name="custom" id="UserID" value="<?php echo $orderData['Order']['id']; ?>" />

			<input type="hidden" name="notify_url" value="<?php echo $this->Html->url(array('controller'=>'Orders', 'action'=>'pay', 'full_base'=>true)); ?>" />
			 
			<input type="hidden" name="return" value="<?php echo $this->Html->url(array('controller'=>'Orders', 'action'=>'pay', 'full_base'=>true)); ?>">
			<input type="hidden" name="cancel_return" value="<?php echo $this->Html->url(array('controller'=>'Orders', 'action'=>'cancel', 'full_base'=>true)); ?>">
		</form>
		<?php
	} else {
		
	}
}
?>
<script type="text/javascript">
jQuery(document).ready(function(){
	$('#paypalForm').submit();
});
</script>