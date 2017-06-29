<?php $id = $this->Session->read('id'); ?>
<?php
$ThemeSetting=$this->Session->read('ThemeSetting');
$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
echo $this->Layout->pagecrumb('page', 'My Orders');
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
				<?php 
					$orderlist = $this->Layout->orderlist($id);
					//pr($orderlist);
				?>
				<div class="col-md-12">
					<div class="sep-heading-container shc4 clearfix">
						<h4>Order Table List</h4>
						<div class="sep-container">
							<div class="the-sep"></div>
						</div>
					</div>
				</div>
					<div class="col-md-12 main-el">
					<?php if(!empty($orderlist)){ ?>
						<div class="tablewrap">
						<div class="row">
							<div class="col-md-12 shop-panel">
								<div id="shop-cart-block" class="row">
									<div class="cart-list col-md-12 main-el alt-bg-">
										<?php 
										$i=1;
										
						
							
										foreach($orderlist as $orderlists)
										{
										$str=Null;
										//pr($orderlists);
											 $str.= '<div class="alert alert-noicon"><div class="row">
											 <div class="col-md-3">
												Order Date: '.date("d-m-Y",strtotime($orderlists['Order']['order_date']));
												
												$str.= '</div><div class="col-md-3">
												Payment Status: ';
												
												$str.=($orderlists['Order']['payment_status']=='Y')?
												'Paid':'Due';	
												
												$str.= '</div><div class="col-md-3">
												Delivery Status: ';
												
												$str.=($orderlists['Order']['delivery_status']=='Y')?
												'Delivered':'Not Delivered';
												
												$str.= '</div><div class="col-md-3">
												Delivery Date: ';
												
												$str.=(!empty($orderlists['Order']['delivery_date']))?
												date("d-m-Y",strtotime($orderlists['Order']['delivery_date'])):'';
												
												
												$str.='</div>
												</div></div>';
												echo $str;?>
												<div class="head main-bg-color alt-text-color bold clearfix">
											<div class="section product">Product</div>
											<div class="section prc">Price</div>
											<div class="section qty">Quantity</div>
											<div class="section total">Total</div>
										</div>
										<?php 
											foreach($orderlists['OrderDetail'] as $orderdetail)
											{
											//pr($orderdetail);
												$orderlistdetails = $this->Layout->orderlistdetails($orderdetail['product_id']);
												//pr($orderlistdetails);
										?>
										<div class="line clearfix">
												<div class="mini-image">
												<?php echo $this->Html->image(IMGPATH.'product_image/thumb/'.$orderlistdetails['Product']['product_image'], array('alt'=>"", 'class'=>'img-responsive center-block')); ?>
												</div>
												
												<div class="name medium">
												<a href="choco-ice-cream">
												<?php echo $orderlistdetails['Product']['product_name']; ?>
												</a>
												</div>
												<div class="price" style="width:160px;"><?php
													echo CURRENCY.number_format($orderdetail['unit_price'],2);
														
												?></div>
												<div class="quantity" style="margin-top:30px">
													<?php echo $orderdetail['quantity'];  ?>
												</div>
												<div class="price total">
												<?php echo CURRENCY.number_format($orderdetail['gross_price'],2);?>
												
												</div>
											</div>
										<?php 
											}
											$i++;
											$sudprice=number_format($orderlists['Order']['order_amount'],2);
											$sudprices = str_replace(',', '', $sudprice);
											$strr=null;
											 $strr.= 
											 '<div class="alert alert-noicon">
												&nbsp  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
													Total &nbsp &nbsp = &nbsp Sub Total &nbsp + &nbsp Shipping Cost &nbsp = &nbsp '.CURRENCY.number_format($orderlists['Order']['order_amount'],2).'&nbsp + &nbsp 
													'.CURRENCY.number_format($orderlists['Order']['shipping_cost'],2).'&nbsp = &nbsp '.CURRENCY.number_format(($sudprices + $orderlists['Order']['shipping_cost']),2).'
											 
											 </div>';
											 echo $strr;
											echo "<br/>";
											
											
										}
										
										?>
									</div>
								</div>
							</div>
						</div>
						</div>
						<?php } else { ?>
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