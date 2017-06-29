<?php
$ThemeSetting=$this->Session->read('ThemeSetting');
$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
echo $this->Layout->pagecrumb('page', 'Forgot Password');
?>

<div class="content">
	<div class="container">
		<div class="row">
		<?php if($ThemeSettingheadertype=='V') { ?>
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
		<?php } else { ?>
			<div class="col-sm-12 main-el">
		<?php } ?>
				<?php echo $this->Form->create('Member', array('url'=>array('controller'=>'Members', 'action'=>'forgotpassword'), 'id'=>"forgot_password_form", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
				<div class="form login-form">
					<div class="head main-text-color">
					Reset Your Password
					</div>
					<?php echo $this->Session->flash(); ?>
					<?php 
						echo $this->Form->input('email_id',array('class'=>"form-control main-form",'div'=>false, 'label'=>false, 'type'=>'text','Placeholder'=>'Enter your email address'));
					?>
					<div class="buttons">
						<?php
							echo $this->Form->button('<div class="over">Send </div>', array('type' => 'submit', 'class'=>"btn btn-primary", 'escape'=>false));
						?>
						<span class="lost main-text-color">
						<?php
							echo $this->Html->link('<div class="over">Back To Login <i class="fa fa-long-arrow-right"></i></div>', array('controller'=>'Members', 'action'=>'login', 'full_base'=>true), array('class'=>"btn btn-primary", 'escape'=>false));
						?>
						</span>
					</div>

				</div>
				<?php  echo $this->Form->end(); ?>
			</div>

		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	var form3 = $('#forgot_password_form');
	var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
	
	var validator = form3.validate({
		rules: {
			'data[Member][email_id]': {
				required: true,
				email: true
			}
		},
		errorPlacement: function (error, element) { // render error placement for each input type
			if (element.attr("data-error-container")) { 
				error.appendTo(element.attr("data-error-container"));
			} else {
				error.insertAfter(element); // for other inputs, just perform default behavior
			}
		},
	});
	
});
</script>