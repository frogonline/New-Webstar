<style>
.error-message{
color:red;
}
</style>
<?php

$siteSettings=$this->Session->read('siteSettings');
//pr($siteSettings);
$ThemeSetting=$this->Session->read('ThemeSetting');
$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
echo $this->Layout->pagecrumb('page', 'Register');
?>
<div class="container">
	<div class="row margin-bottom-40">
	  <!-- BEGIN CONTENT -->
	  
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
				
		<div class="col-md-9 col-sm-12">
		<?php }else { ?>
			<div class="col-md-12 col-sm-12">
			<?php } ?>
		
			<h1>Create an account</h1>
			<span class="mail-sent"><?php echo $this->Session->flash(); ?></span>
			<div class="content-form-page">
				<div class="row">
					<div class="col-md-7 col-sm-7">
						<?php echo $this->Form->create('Member', array('url'=>array('controller'=>'Members', 'action'=>'register'), 'id'=>"register_form", 'class'=>'form-horizontal', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
						<fieldset>
							<legend>Your personal details</legend>
							<div class="form-group">
								<label for="firstname" class="col-lg-4 control-label">First Name <span class="require">*</span></label>
								<div class="col-lg-8">
									<?php echo $this->Form->input('firstname',array('id'=>"firstname",'class'=>"form-control",'div'=>false, 'label'=>false, 'type'=>'text','Placeholder'=>'')); ?>
								</div>
							</div>
							<div class="form-group">
								<label for="lastname" class="col-lg-4 control-label">Last Name <span class="require">*</span></label>
								<div class="col-lg-8">
									<?php echo $this->Form->input('lastname',array('id'=>"lastname",'class'=>"form-control",'div'=>false, 'label'=>false, 'type'=>'text','Placeholder'=>'')); ?>
								</div>
							</div>
							<div class="form-group">
								<label for="email" class="col-lg-4 control-label">Email <span class="require">*</span></label>
								<div class="col-lg-8">
									<?php echo $this->Form->input('email_id',array('id'=>"email_id",'class'=>"form-control",'div'=>false, 'label'=>false, 'type'=>'text','data-url'=>$this->Html->url(array('controller'=>'Members', 'action'=>'ajaxcheckemail', 'full_base'=>true)))); ?>
									<span class="email-required"></span>
								</div>
							</div>
							<div class="form-group">
								<label for="email" class="col-lg-4 control-label">Telephone <span class="require">*</span></label>
								<div class="col-lg-8">
									<?php echo $this->Form->input('telephone',array('class'=>"form-control", 'type'=>'text')); ?>
								</div>
							</div>
							<div class="form-group">
								<label for="email" class="col-lg-4 control-label">Fax</label>
								<div class="col-lg-8">
									<?php echo $this->Form->input('fax',array('class'=>"form-control", 'type'=>'text')); ?>
								</div>
							</div>
							<div class="form-group">
								<label for="email" class="col-lg-4 control-label">Company </label>
								<div class="col-lg-8">
									<?php echo $this->Form->input('company',array('class'=>"form-control", 'type'=>'text')); ?>
								</div>
							</div>
							<div class="form-group">
								<label for="email" class="col-lg-4 control-label">Address <span class="require">*</span></label>
								<div class="col-lg-8">
									<?php echo $this->Form->input('address',array('class'=>"form-control", 'type'=>'text')); ?>
								</div>
							</div>
							<div class="form-group">
								<label for="email" class="col-lg-4 control-label">Address Line 1 </label>
								<div class="col-lg-8">
									<?php echo $this->Form->input('address1',array('class'=>"form-control", 'type'=>'text')); ?>
								</div>
							</div>
							<div class="form-group">
								<label for="email" class="col-lg-4 control-label">Country <span class="require">*</span></label>
								<div class="col-lg-8">
									<?php 
										echo $this->Form->input('country',array(
											'class'=>"form-control", 
											'id'=>"register_country", 
											'options'=>$countries,
											'data-url'=>$this->Html->url(array('controller'=>'Members','action'=>'ajaxstate', 'full_base'=>true)),
											'empty'=> ' --- Please Select --- '
											)
										); 
									?>
								</div>
							</div>
							<div class="form-group" id="register_state_div">
								<label for="state" class="col-lg-4 control-label">State <span class="require">*</span></label>
								<div class="col-lg-8">
									<?php 
										echo $this->Form->input('state',array(
											'class'=>"form-control", 
											'id'=>"register_state11",
											'options'=>array(),
											'empty'=> ' --- Please Select --- '
											)
										); 
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="city" class="col-lg-4 control-label">City <span class="require">*</span></label>
								<div class="col-lg-8">
									<?php echo $this->Form->input('city',array('id'=>"city",'class'=>"form-control",'div'=>false, 'label'=>false, 'type'=>'text','Placeholder'=>'')); ?>
								</div>
							</div>
							
							<div class="form-group">
								<label for="email" class="col-lg-4 control-label">Postcode <span class="require">*</span></label>
								<div class="col-lg-8">
									<?php echo $this->Form->input('postcode',array('class'=>"form-control", 'type'=>'text')); ?>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Your password</legend>
							<div class="form-group">
								<label for="password" class="col-lg-4 control-label">Password <span class="require">*</span></label>
								<div class="col-lg-8">
									<?php echo $this->Form->input('New.password',array('id'=>"password",'class'=>"form-control",'div'=>false, 'label'=>false, 'type'=>'password','Placeholder'=>'')); ?>
									<span class="password-required"></span>
								</div>
							</div>
							<div class="form-group">
								<label for="confirm-password" class="col-lg-4 control-label">Confirm password <span class="require">*</span></label>
								<div class="col-lg-8">
									<?php echo $this->Form->input('New.con_password',array('id'=>"con_password",'class'=>"form-control",'div'=>false, 'label'=>false, 'type'=>'password','Placeholder'=>'')); ?>
									<span class="confpassword-required"></span>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Newsletter</legend>
							<div class="checkbox form-group">
								<label>
									<div class="col-lg-4 col-sm-4">Singup for Newsletter</div>
									<div class="col-lg-8 col-sm-8">
										<input type="checkbox">
									</div>
								</label>
							</div>
						</fieldset>
						<div class="row">
							<div class="col-lg-10 col-md-offset-4 padding-left-0 padding-top-20">
								<?php
									echo $this->Form->input('url', array(
											'type'=>'hidden', 
											'value'=>$this->Html->url(array('controller'=>'Members', 'action'=>'ajaxregister', 'full_base'=>true)),
											'id'=>'formUrl'
											)
										);
										echo $this->Form->input('redirecturl', array(
											'type'=>'hidden', 
											'value'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'success', 'full_base'=>true)),
											'id'=>'formredirectUrl'
											)
										);
									echo $this->Form->button('Create an account', array('type' => 'submit', 'class'=>"btn btn-primary"));
								?>
								<?php echo $this->Form->button('Cancel', array('type' => 'reset','class'=>"btn btn-default",'div'=>false));?>
							</div>
						</div>
						<?php  echo $this->Form->end(); ?>
					</div>
					<div class="col-md-4 col-sm-4 pull-right">
						<div class="form-info">
							<h2><?php echo $siteSettings['SiteSetting']['re_title']; ?> </h2>
							<p><?php echo $siteSettings['SiteSetting']['re_des']; ?></p>

							<a href="<?php echo $siteSettings['SiteSetting']['re_button_link']; ?>"><button type="button" class="btn btn-default"><?php echo $siteSettings['SiteSetting']['re_button_text']; ?></button></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	  <!-- END CONTENT -->
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	Register.init();
	Register.initState();
});	
</script>