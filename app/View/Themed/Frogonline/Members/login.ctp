<?php
$ThemeSetting=$this->Session->read('ThemeSetting');
$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
echo $this->Layout->pagecrumb('page', 'Logon');
?>

<div class="content">
	<div class="container">
		<div class="row">
		<?php if($ThemeSettingheadertype=='V'){ ?>
		<div class="col-md-3 main-el">
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
				
		<div class="col-sm-9 main-el">
		<?php }else { ?>
			<div class="col-sm-12 main-el">
			<?php } ?>
				<?php echo $this->Form->create('Member', array('url'=>array('controller'=>'Members', 'action'=>'login'), 'id'=>"login_form", 'class'=>"form-horizontal form-without-legend", 'role'=>"form", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
				<div class="form login-form">
					<div class="head main-text-color">
					I'm a returning customer
					</div>
					<div id="loginErr" style="display:none;" class="alert alert-icon alert-danger"></div>
					<?php 
						echo $this->Form->input('email_id',array('id'=>"email_id",'class'=>"form-control main-form",'div'=>false, 'label'=>false, 'type'=>'text','Placeholder'=>'Email Address *')); 
						echo $this->Form->input('password',array('id'=>"password",'class'=>"form-control main-form",'div'=>false, 'label'=>false, 'type'=>'password','Placeholder'=>'Password *'));
					?>
					<div class="buttons">
						<?php
							echo $this->Form->input('loginsubmiturl', array('type'=>'hidden', 'id'=>'submitLoginUrl', 'value'=>$this->Html->url(array('controller'=>'Members', 'action'=>'ajaxlogin', 'full_base'=>true))));
							echo $this->Form->input('loginredirecturl', array('type'=>'hidden', 'id'=>'redirectLoginUrl', 'value'=>$this->Html->url(array('controller'=>'Members', 'action'=>'myaccount', 'full_base'=>true))));
						
							echo $this->Form->button('<div class="over">Login</div>', array('type' => 'submit', 'class'=>"btn btn-primary", 'escape'=>false));
							echo ' OR ';
							echo $this->Html->link('Register New Account', array('controller'=>'Members', 'action'=>'register', 'full_base'=>true), array('class'=>''));
						?>
						<span class="lost main-text-color">
						(<?php echo $this->Html->link('Forgot Password?', array('controller'=>'Members', 'action'=>'forgotpassword'), array('escape' => false) ); ?>)
						</span>

					</div>

				</div>
				<?php  echo $this->Form->end(); ?>
			</div>

		</div>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	Account.init();
});
</script>