<?php
$ThemeSetting=$this->Session->read('ThemeSetting');
$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
echo $this->Layout->pagecrumb('page', 'My Account');
?>
<div class="container">
	<!-- BEGIN SIDEBAR & CONTENT -->
	<div class="row margin-bottom-40">
		<!-- BEGIN SIDEBAR -->
		<div class="sidebar col-md-3 col-sm-3">
		<?php if($ThemeSettingheadertype=='V'){ ?>
			<div class="list-group">
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
			<div><br/></div>
			<?php }  ?>
			<div class="list-group">
				<?php
				echo $this->Html->link('My Account', array('controller'=>'Members', 'action'=>'myaccount', 'full_base'=>true), array('class'=>'list-group-item'));
				echo $this->Html->link('My Orders', array('controller'=>'Members', 'action'=>'myorders', 'full_base'=>true), array('class'=>'list-group-item'));
				echo $this->Html->link('Wishlist', array('controller'=>'Members', 'action'=>'wishlist', 'full_base'=>true), array('class'=>'list-group-item'));
				echo $this->Html->link('My Catalog', array('controller'=>'Products', 'action'=>'mycatalog', 'full_base'=>true), array('class'=>'list-group-item'));
				?>
			</div>
			
		</div>
		<!-- END SIDEBAR -->

	<!-- BEGIN CONTENT -->
		<div class="col-md-9 col-sm-7">
			
			<div class="content-page">
				<div class="row" id="personal_info_div">
					<div class="col-md-12">
						<h3>Persional Info 
						<?php echo $this->Html->link('<i class="fa fa-edit"></i>', 'javascript:void(0);', array('class'=>'btn default pull-right', 'escape'=>false, 'data-ajaxurl'=>$this->Html->url(array('controller'=>'Members', 'action'=>'ajaxpersonalinfo', 'full_base'=>true)), 'id'=>'info_display')); ?>
						</h3>
					</div>
					<div class="form-group col-md-6">
						<label>Name</label>
						<div class="form-control"><?php echo (!empty($data))?$data['Member']['firstname'].' '.$data['Member']['lastname']:''; ?></div>
					</div>
					<div class="form-group col-md-6">
						<label>Email</label>
						<div class="form-control"><?php echo (!empty($data))?$data['Member']['email_id']:''; ?></div>
					</div>
					<div class="form-group col-md-6">
						<label>Telephone</label>
						<div class="form-control"><?php echo (!empty($data))?$data['Member']['telephone']:''; ?></div>
					</div>
					<div class="form-group col-md-6">
						<label>Fax</label>
						<div class="form-control"><?php echo (!empty($data))?$data['Member']['fax']:''; ?></div>
					</div>
					<div class="form-group col-md-6">
						<label>Company</label>
						<div class="form-control"><?php echo (!empty($data))?$data['Member']['company']:''; ?></div>
					</div>
				</div>
				<hr>
				
				<div class="row" id="address_info_div">
					<div class="col-md-12">
						<h3>Address Info 
						<!--<a href="#" class="btn default pull-right"><i class="fa fa-edit"></i></a>-->
						<?php echo $this->Html->link('<i class="fa fa-edit"></i>', 'javascript:void(0);', array('class'=>'btn default pull-right', 'escape'=>false, 'data-ajaxurl'=>$this->Html->url(array('controller'=>'Members', 'action'=>'ajaxaddressinfo', 'full_base'=>true)), 'id'=>'address_display')); ?>
						</h3>
					</div>
					<div class="form-group col-md-12">
						<label>Address</label>
						<div class="form-control" style="min-height:100px; overflow:hidden;">
						<?php
							echo (!empty($data))?$data['Member']['address'].','.$data['Member']['address1'].'<br />':'';
							echo (!empty($data))?$data['Country']['Country'].', '.$data['State']['State'].', '.$data['City']['City'].' - '.$data['Member']['postcode']:'';
						?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<!-- END CONTENT -->
	</div>
	<!-- END SIDEBAR & CONTENT -->
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	Register.init();
});	
</script>