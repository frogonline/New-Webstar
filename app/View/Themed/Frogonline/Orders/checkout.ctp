<?php
if($this->Session->read('loggedin_status')){
	$loginStatus = true;
} else {
	$loginStatus = false;
}

echo $this->Layout->pagecrumb('page', 'Checkout');
$ThemeSetting=$this->Session->read('ThemeSetting');
$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
?>

<div class="container">
	<!-- BEGIN SIDEBAR & CONTENT -->
		<div class="row margin-bottom-40">
		<!-- BEGIN CONTENT -->
		<?php  if($ThemeSettingheadertype=='V'){?>
		<div class="ecomerce sidebar col-md-3 main-el" style="margin-top:-17px">
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
		<div class="col-md-9 col-sm-12">
		<?php }else{ ?>
		<div class="col-md-12 col-sm-12">
		<?php } ?>
			<!-- BEGIN CHECKOUT PAGE -->
			<div class="panel-group checkout-page accordion scrollable" id="checkout-page">

				<!-- BEGIN CHECKOUT -->
				<div id="checkout" class="panel panel-default">
					<div class="panel-heading">
						<h2 class="panel-title">
						<a data-toggle="collapse" data-parent="#checkout-page" href="#checkout-content" class="accordion-toggle">
							Step 1: Checkout Options
						</a>
						</h2>
					</div>
					<div id="checkout-content" class="panel-collapse collapse <?php echo ($loginStatus)?'':'in'; ?>">
					<?php if(!$this->Session->read('loggedin_status')) { ?>
						<div class="panel-body row">
							<?php echo $this->Form->create('checkout', array('id'=>"chkopt", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
							<div class="col-md-6 col-sm-6">
								<h3>New Customer</h3>
								<p>Checkout Options:</p>
								<div class="radio-list">
								<span>
									<?php echo $this->Form->radio('account', array('register'=>' Register Account'), array('data-error-container'=>'#radiomsg', 'hiddenField'=>false)); ?>
								</span>
								<span>
									<?php echo $this->Form->radio('account', array('guest'=>' Guest Checkout'), array('data-error-container'=>'#radiomsg', 'hiddenField'=>false)); ?>
								</span> 
								<div id="radiomsg"></div>
								</div>
								<p>By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.</p>
								<?php echo $this->Form->input('url',array('type'=>'hidden', 'id'=>'paymentaddressurl', 'value'=>$this->Html->url(array('controller'=>'Orders', 'action'=>'ajaxstep2', 'full_base'=>true)))); ?>
								<?php echo $this->Form->button('Continue', array('class'=>'btn btn-primary brown-bg', 'id'=>'checkout_option_button', 'type'=>'submit', 'data-toggle'=>'collapse', 'data-parent'=>'#checkout-page', 'data-target'=>'#payment-address-content')); ?>
							</div>
							<?php echo $this->Form->end(); ?>
							<div class="col-md-6 col-sm-6 mobpadtop15">
								<h3>Returning Customer</h3>
								<p>I am a returning customer.</p>
								<?php echo $this->Form->create('Member', array('id'=>"chklogin", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
								<div class="form-group">
									<label for="email-login">E-Mail</label>
									<?php echo $this->Form->input('email_id', array('type'=>'text', 'class'=>'form-control')); ?>
									<!--<input type="text" id="email-login" class="form-control">-->
								</div>
								<div class="form-group">
									<label for="password-login">Password</label>
									<?php echo $this->Form->input('password', array('type'=>'password', 'class'=>'form-control')); ?>
								</div>
									<!--<a href="#">Forgotten Password?</a>-->
								<div class="padding-top-20">
									<?php 
										echo $this->Form->input('returnuserurl', array('type'=>'hidden', 'id'=>'returnuserurl', 'value'=>$this->Html->url(array('controller'=>'Members', 'action'=>'ajaxlogin', 'full_base'=>true))));
										echo $this->Form->button('Login', array('type'=>'submit', 'class'=>'btn btn-primary brown-bg')); 
									?>
								</div>
								<hr>
								<!--<div class="login-socio">
									<p class="text-muted">or login using:</p>
									<ul class="social-icons">
										<li><a href="#" data-original-title="facebook" class="facebook" title="facebook"></a></li>
										<li><a href="#" data-original-title="Twitter" class="twitter" title="Twitter"></a></li>
										<li><a href="#" data-original-title="Google Plus" class="googleplus" title="Google Plus"></a></li>
										<li><a href="#" data-original-title="Linkedin" class="linkedin" title="LinkedIn"></a></li>
									</ul>
								</div>-->
								<?php echo $this->Form->end(); ?>
								<div class="col-md-12" id="loginmsg"></div>
							</div>
						</div>
					<?php } ?>
					</div>
				</div>
				<!-- END CHECKOUT -->

				<!-- BEGIN PAYMENT ADDRESS -->
				<div id="payment-address" class="panel panel-default">
					<div class="panel-heading">
						<h2 class="panel-title">
						<a data-toggle="collapse" data-parent="#checkout-page" href="#payment-address-content" class="accordion-toggle">
							Step 2: Billing Details
						</a>
						</h2>
					</div>
					<div id="payment-address-content" class="panel-collapse collapse <?php echo ($loginStatus)?'in':''; ?>">
					<?php if($this->Session->read('loggedin_status')){ ?>
						<div class="panel-body row">
							<?php echo $this->Form->create('Order', array('id'=>"billingForm", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
							<div class="col-md-6 col-sm-6">
								<h3>Your Personal Details</h3>
								<div class="form-group">
									<label for="firstname">First Name <span class="require">*</span></label>
									<?php echo $this->Form->input('firstname', array('type'=>'text', 'class'=>'form-control', 'value'=>(!empty($user))?$user['Member']['firstname']:'')); ?>
								</div>
								<div class="form-group">
									<label for="lastname">Last Name <span class="require">*</span></label>
									<?php echo $this->Form->input('lastname', array('type'=>'text', 'class'=>'form-control', 'value'=>(!empty($user))?$user['Member']['lastname']:'')); ?>
								</div>
								<div class="form-group">
									<label for="email">E-Mail <span class="require">*</span></label>
									<?php echo $this->Form->input('email_id', array('type'=>'text', 'class'=>'form-control', 'value'=>(!empty($user))?$user['Member']['email_id']:'')); ?>
								</div>
								<div class="form-group">
									<label for="telephone">Telephone <span class="require">*</span></label>
									<?php echo $this->Form->input('telephone', array('type'=>'text', 'class'=>'form-control', 'value'=>(!empty($user))?$user['Member']['telephone']:'')); ?>
								</div>
								<div class="form-group">
									<label for="fax">Fax</label>
									<?php echo $this->Form->input('fax', array('type'=>'text', 'class'=>'form-control', 'value'=>(!empty($user))?$user['Member']['fax']:'')); ?>
								</div>
								
							</div>
							<div class="col-md-6 col-sm-6">
								<h3>Your Address</h3>
								<div class="form-group">
									<label for="company">Company</label>
									<?php echo $this->Form->input('company', array('type'=>'text', 'class'=>'form-control', 'value'=>(!empty($user))?$user['Member']['company']:'')); ?>
								</div>
								<div class="form-group">
									<label for="address1">Address 1 <span class="require">*</span></label>
									<?php echo $this->Form->input('address', array('type'=>'text', 'class'=>'form-control', 'value'=>(!empty($user))?$user['Member']['address']:'')); ?>
								</div>
								<div class="form-group">
									<label for="address2">Address 2</label>
									<?php echo $this->Form->input('address1', array('type'=>'text', 'class'=>'form-control', 'value'=>(!empty($user))?$user['Member']['address1']:'')); ?>
								</div>
								<div class="form-group">
									<label for="country">Country <span class="require">*</span></label>
									<?php 
									echo $this->Form->input('country', array(
										'options'=>$countries, 
										'empty'=>' --- Please Select --- ',
										'class'=>'form-control input-sm',
										'data-url'=>$this->Html->url(array('controller'=>'Orders', 'action'=>'ajaxstate', 'full_base'=>true)),
										'id'=>'billing_country',
										'selected'=>(!empty($user))?$user['Member']['country']:''
										)
									); 
									?>
								</div>
								<div class="form-group" id="billing_state_div">
									<label for="region-state">Region/State <span class="require">*</span></label>
									<?php 
									echo $this->Form->input('state', array(
										'options'=>$states, 
										'empty'=>' --- Please Select --- ',
										'class'=>'form-control input-sm',
										'id'=>'billing_state',
										'data-url'=>$this->Html->url(array('controller'=>'Orders', 'action'=>'ajaxcity', 'full_base'=>true)),
										'selected'=>(!empty($user))?$user['Member']['state']:''
										)
									); 
									?>
								</div>
								<div class="form-group" id="billing_city_divuuu">
									<label for="city">City/Town <span class="require">*</span></label>
									<?php 
									/* echo $this->Form->input('city', array(
										'options'=>$cities, 
										'empty'=>' --- Please Select --- ',
										'class'=>'form-control input-sm',
										'selected'=>(!empty($user))?$user['Member']['city']:''
										)
									);  */
									?>
									<?php echo $this->Form->input('city', array('type'=>'text', 'class'=>'form-control input-sm', 'value'=>(!empty($user))?$user['Member']['city']:'')); ?>
									
								</div>
								<div class="form-group">
									<label for="post-code">Post Code <span class="require">*</span></label>
									<?php echo $this->Form->input('postcode', array('type'=>'text', 'class'=>'form-control', 'value'=>(!empty($user))?$user['Member']['postcode']:'')); ?>
								</div>
							</div>
							<hr>
							<div class="col-md-12">
								<div class="checkbox">
									<label>
										<?php echo $this->Form->checkbox('sameas', array('value'=>'1', 'checked'=>true, 'hiddenField'=>false)); ?>  My delivery and billing addresses are the same.
									</label>
								</div>
								<?php 
									echo $this->Form->input('user_id', array('type'=>'hidden', 'value'=>$user['Member']['id']));
									echo $this->Form->input('url',array('type'=>'hidden', 'id'=>'shippingaddressurl', 'value'=>$this->Html->url(array('controller'=>'Orders', 'action'=>'ajaxstep3', 'full_base'=>true))));
									echo $this->Form->input('mode',array('type'=>'hidden', 'value'=>'loggedin'));
									echo $this->Form->button('Continue', array('class'=>'btn btn-primary pull-right brown-bg', 'type'=>'submit', 'data-toggle'=>'collapse', 'data-parent'=>'#checkout-page', 'data-target'=>'#payment-address-content')); 
								?>                     
							</div>
							<?php echo $this->Form->end(); ?>
						</div>
					<?php } ?>
					</div>
				</div>
				<!-- END PAYMENT ADDRESS -->

				<!-- BEGIN SHIPPING ADDRESS -->
				<div id="shipping-address" class="panel panel-default">
					<div class="panel-heading">
						<h2 class="panel-title">
							<a data-toggle="collapse" data-parent="#checkout-page" href="#shipping-address-content" class="accordion-toggle"> Step 3: Delivery Details</a>
						</h2>
					</div>
					<div id="shipping-address-content" class="panel-collapse collapse"></div>
				</div>
				<!-- END SHIPPING ADDRESS -->

				<!-- BEGIN SHIPPING METHOD -->
				<div id="shipping-method" class="panel panel-default">
					<div class="panel-heading">
						<h2 class="panel-title">
							<a data-toggle="collapse" data-parent="#checkout-page" href="#shipping-method-content" class="accordion-toggle"> Step 4: Delivery Method </a>
						</h2>
					</div>
					<div id="shipping-method-content" class="panel-collapse collapse">
					</div>
				</div>
				<!-- END SHIPPING METHOD -->

			<!-- BEGIN PAYMENT METHOD -->
			<div id="payment-method" class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">
					<a data-toggle="collapse" data-parent="#checkout-page" href="#payment-method-content" class="accordion-toggle"> Step 5: Payment Method </a>
					</h2>
				</div>
				<div id="payment-method-content" class="panel-collapse collapse">
				</div>
			</div>
			<!-- END PAYMENT METHOD -->

			<!-- BEGIN CONFIRM -->
			<div id="confirm" class="panel panel-default">
				<div class="panel-heading">
					<h2 class="panel-title">
						<a data-toggle="collapse" data-parent="#checkout-page" href="#confirm-content" class="accordion-toggle"> Step 6: Confirm Order </a>
					</h2>
				</div>
				<div id="confirm-content" class="panel-collapse collapse">
				</div>
			</div>
			<!-- END CONFIRM -->
			</div>
			<!-- END CHECKOUT PAGE -->
		</div>
		<!-- END CONTENT -->
		</div>
	<!-- END SIDEBAR & CONTENT -->
</div>
<div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" /> Please wait while your order is being processed.
			</div>
		</div>
		<!-- END VALIDATION STATES-->
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	Checkout.init();
	Checkout.initBillingState();
	Checkout.initBillingCity();
});
</script>