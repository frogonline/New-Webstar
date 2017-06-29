<?php
$ThemeSetting=$this->Session->read('ThemeSetting');
$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
echo $this->Layout->pagecrumb('page', 'My Catalog');
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
				<div class="row">
					<div class="col-md-12">
						<div class="sep-heading-container shc4 clearfix">
							<h4>Catalog List</h4>
							<div class="sep-container">
								<div class="the-sep"></div>
							</div>
						</div>
					</div>
					<div class="col-md-12 main-el">
						<?php if(!empty($catalogidArr)){ ?>
						<div class="tablewrap">
							<table class="data table table-bordered">
								<thead>
								<tr>
									<td>Catalog Name</td>
									<td>View</td>
								</tr>
								</thead>
								<tbody>
								<?php foreach($catalogidArr as $catalogidAr){ ?>
								<tr>
									<td><?php echo $catalogidAr['Catalog']['name']; ?></td>
								   <td>
								   <?php echo $this->Html->link('<i class=""></i> View', array('controller'=>'products', 'action'=>'catalogdetail/'.$catalogidAr['CatalogUser']['catalog_id']), array('escape'=>false,'full_base'=>true, 
								   'class'=>'btn default btn-xs blue'));
								   ?>
								   </td>
								</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
						<?php } else{ ?>
						<div class="alert alert-noicon"><center>No Result Found.</center></div>
						<?php } ?>
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