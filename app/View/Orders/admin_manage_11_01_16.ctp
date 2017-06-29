<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$order = array('S'=>'Successful','P'=>'Pending');
	$deliver = array('Y'=>'Delivered','N'=>'Not Delivered');
	$pay = array('Y'=>'Paid','N'=>'Due');
	$payment = array('COD'=>'Cash On Delivery','PAYPAL'=>'Paypal','EWAY'=>'eway');
	$siteSettings = $this->Session->read('siteSettings');
	$currentModelPer=$this->Session->read('currentModelPer');
//pr($currentModelPer);
//pr($productoption);exit;
?>
<div class="row">
				<div class="col-md-12">
					<!-- Begin: life time stats -->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-shopping-cart" style="font-size: 20px"> Order # <?php echo $data[0]['Order']['id']; ?></i>
							</div>
							<div class="actions">
								<!-- <a href="#" class="btn default yellow-stripe">
								<i class="fa fa-angle-left"></i>
								<span class="hidden-480">
								Back </span>
								</a> -->								
							</div>
						</div>
						<div class="portlet-body">
							<div class="tabbable">
								<ul class="nav nav-tabs nav-tabs-lg">
									<li class="active">
										<a href="#tab_1" data-toggle="tab">
										Details </a>
									</li>
									<li>
										<a href="#tab_2" data-toggle="tab">
										Invoices
										</a>
									</li>
								</div>
							</div>
					<div class="tab-content">
									<div class="tab-pane active" id="tab_1">
										<div class="row">
											<div class="col-md-6 col-sm-12">
												<div class="portlet yellow-crusta box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Order Details
														</div>
														<div class="actions">
															<!--<a href="#" class="btn btn-default btn-sm">
															<i class="fa fa-pencil"></i> Edit </a>-->
														</div>
													</div>
													<?php foreach($data as $datas) {?>
													<div class="portlet-body">
														<div class="row static-info">
															<div class="col-md-5 name">
																 Order #:
															</div>
															<div class="col-md-7 value">
																 <?php echo $datas['Order']['id']; ?>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Order Date & Time:
															</div>
															<div class="col-md-7 value">
																 <?php echo date("d-m-Y, H:i",strtotime($datas['Order']['order_date'])); ?>
															</div>
														</div>
														<!---<div class="row static-info">
															<div class="col-md-5 name">
																 Order Status:
															</div>
															<div class="col-md-7 value">
																<span class="label label-success">
																	<?php 
																	/*echo ($datas['Order']['order_status']=='S')?'<span class="label label-success">':'<span class="label label-danger">';
																	echo isset($datas['Order']['order_status'])?$order[$datas['Order']['order_status']]:'';
																	echo */ '</span>';				
																	?>	 
																</span>
															</div>
														</div>
														----->
														
														<div class="row static-info">
															<div class="col-md-5 name">
																Order Status:
															</div>
															<div class="col-md-7 value">
																<div>
																	<span class="label label-success" id="for_Successful" style="display:none">Successful</span>
																	
																	<span class="label label-danger" id="for_Pending" style="display:none">Pending</span>
																	
																	<span id="all_status_for_Order">
																	<?php if($datas['Order']['order_status']=='P')
																	{ ?>
																	<span class="label label-danger">Pending</span>
																	<?php }
																	else if($datas['Order']['order_status']=='S'){ ?>
																	<span class="label label-success">Successful</span>
																	<?php }
																	?>
																	</span>
																	<?php 
																	if($currentModelPer['edit']=='Y')
																	{
																	echo "&nbsp";
																	echo $this->Html->link(
																	'<i class="fa fa-edit"></i> Change Status',
																	'javascript:void(0)', 
																	array(
																	'escape'=>false,
																	'div'=>false,
																	'class'=>'btn default btn-xs yellow',
																	'id' => 'link3',
																	'confirm'=>'Are you sure?'
																	));
																	}
																	?>
																</div>
															</div>	
														</div>
														
														<div class="row static-info">
															<div class="col-md-5 name">
																 Delivery Status:
															</div>
															<div class="col-md-7 value">
																<div>
																	<span id="all_status_for_deliverd">
																	<?php if($datas['Order']['delivery_status']=='N')
																	{ ?>
																	<span class="label label-danger">Not Delivered</span>
																	<?php }
																	else if($datas['Order']['delivery_status']=='Y'){ ?>
																	<span class="label label-success">Delivered</span>
																	<?php }
																	?>
																	</span>
																	
																	<?php 
																	if($currentModelPer['edit']=='Y')
																	{
																	?>
																	
																	<a data-toggle="modal" href="#responsive" rel="<?php echo $datas['Order']['id']; ?>" class="btn default btn-xs yellow edit"><i class="fa fa-edit"></i>Change Status</a>
																	
																	<?php 
																	}
																	?>
																</div>
															</div>	
														</div>
														
														<div class="row static-info">
															<div class="col-md-5 name">
																 Payment Status:
															</div>
															<div class="col-md-7 value">
																<div>
																	<span class="label label-success" id="Paid" style="display:none">Paid</span>
																	
																	<span class="label label-danger" id="Due" style="display:none">Due</span>
																	
																	<span id="all_status_for_payment">
																	<?php if($datas['Order']['payment_status']=='N')
																	{ ?>
																	<span class="label label-danger">Due</span>
																	<?php }
																	else if($datas['Order']['payment_status']=='Y'){ ?>
																	<span class="label label-success">Paid</span>
																	<?php }
																	?>
																	</span>
																	<?php 
																	if($currentModelPer['edit']=='Y')
																	{
																		echo "&nbsp";
																		echo $this->Html->link('<i class="fa fa-edit"></i> Change Status','javascript:void(0)', array('escape'=>false, 'div'=>false, 'class'=>'btn default btn-xs yellow', 'id' => 'link2', 'confirm'=>'Are you sure?'));
																	}
																	?>
																</div>
															</div>	
														</div>
														<?php foreach($order_detail as $order_details){ ?>
																<?php foreach($pro as $products){ ?>
														<?php 
																$price = ($order_details['OrderDetail']['quantity']*$order_details['OrderDetail']['unit_price']); 
																$disc = (($price*$products['Product']['product_discount'])/100); 
																$grtotal = ($price - $disc);
																?>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Grand Total:
															</div>
															<div class="col-md-7 value">
																<?php
																	if($products['Product']['product_discount'] == 0)
																	{
																	 echo "$".$price;
																	}
																	else
																	{
																	echo "$".$grtotal;
																	}
																?>
															</div>
														</div>
															<?php } ?>
														<?php } ?>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Payment Information:
															</div>
															<div class="col-md-7 value">
																<?php if(!empty($datas['Order']['payment_method'])){ ?>
																 <?php echo $payment[$datas['Order']['payment_method']]; ?>
																 <?php } ?>
															</div>
														</div>
													</div>
													<?php } ?>
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="portlet blue-hoki box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Customer Information
														</div>
														<div class="actions">
															<!--<a href="#" class="btn btn-default btn-sm">
															<i class="fa fa-pencil"></i> Edit </a>-->
														</div>
													</div>
													<?php if($datas['Order']['user_id']!== 0) { ?>
													<div class="portlet-body">
														<div class="row static-info">
															<div class="col-md-5 name">
																 Customer Name:
															</div>
															<div class="col-md-7 value">
																 <?php echo $find[0]['Member']['firstname']." ".$find[0]['Member']['lastname']; ?>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Email:
															</div>
															<div class="col-md-7 value">
																 <?php echo $find[0]['Member']['email_id']; ?>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 State:
															</div>
															<div class="col-md-7 value">
																 <?php echo $state[$find[0]['Member']['state']]; ?>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Phone Number:
															</div>
															<div class="col-md-7 value">
																 <?php echo $find[0]['Member']['telephone']; ?>
															</div>
														</div>
													</div>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 col-sm-12">
												<div class="portlet green-meadow box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Billing Address
														</div>
														<div class="actions">
															<!--<a href="#" class="btn btn-default btn-sm">
															<i class="fa fa-pencil"></i> Edit </a>-->
														</div>
													</div>
													<div class="portlet-body">
														<div class="row static-info">
															<div class="col-md-12 value">
																 <?php echo $datas['Order']['firstname']." ".$datas['Order']['lastname']; ?><br>
																 <?php echo $datas['Order']['address']." ".$datas['Order']['address1']; ?><br>
																 <?php echo $city[$datas['Order']['city']].","; ?><br>
																 <?php echo $state[$datas['Order']['state']]." ".$datas['Order']['postcode'].","; ?><br>
																 <?php echo $country[$datas['Order']['country']]; ?><br>
																 T: <?php echo $datas['Order']['telephone']; ?><br>
																 F: <?php 
																 if($datas['Order']['fax']== NULL){
																 echo "N/A";
																 }
																 else{
																 echo $datas['Order']['fax']; 
																 }
																 ?><br>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="portlet red-sunglo box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Shipping Address
														</div>
														<div class="actions">
															<!--<a href="#" class="btn btn-default btn-sm">
															<i class="fa fa-pencil"></i> Edit </a>-->
														</div>
													</div>
													<div class="portlet-body">
														<div class="row static-info">
															<div class="col-md-12 value">
																 <?php echo $datas['Order']['ship_firstname']." ".$datas['Order']['ship_lastname']; ?><br>
																 <?php echo $datas['Order']['ship_address']." ".$datas['Order']['ship_address1']; ?><br>
																 <?php //echo $city[$data[0]['Order']['ship_city']].","; ?>
																 <?php echo $state[$datas['Order']['ship_state']]." ".$datas['Order']['ship_postcode'].","; ?><br>
																 <?php echo $country[$datas['Order']['ship_country']]; ?><br>
																 T: <?php echo $datas['Order']['ship_telephone']; ?><br>
																 F: <?php 
																 if($datas['Order']['ship_fax']== NULL){
																 echo "N/A";
																 }
																 else{
																 echo $datas['Order']['ship_fax']; 
																 }
																 ?><br>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 col-sm-12">
												<div class="portlet grey-cascade box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Shopping Cart
														</div>
														<div class="actions">
															<!--<a href="#" class="btn btn-default btn-sm">
															<i class="fa fa-pencil"></i> Edit </a>-->
														</div>
													</div>
													
													<div class="portlet-body">
														<div class="table-responsive">
															<table class="table table-hover table-bordered table-striped">
															<thead>
															<tr>
																<th>
																	 Product
																</th>
																<th>
																	 Item Status
																</th>
																<th>
																	 Original Price
																</th>
																<th>
																	 Quantity
																</th>
																<th>
																	 Total Price
																</th>
																
																<th>
																	 Discount Amount
																</th>
																<th>
																	 Total
																</th>
															</tr>
															</thead>
															
															<tbody>
															<?php foreach($order_detail as $order_details){ ?>
																<?php foreach($pro as $products){ ?>
															<tr>
																<td>
																	<a href="#">
																	<?php echo $products['Product']['product_name']; ?> </a>
																</td>
																<td>
																	<span class="label label-sm label-success">
																	<?php echo $statusArr[$products['Product']['product_status']]; ?>
																</td>
																<td>
																	 $<?php echo $order_details['OrderDetail']['unit_price']; ?>
																</td>
																<td>
																	 <?php echo $order_details['OrderDetail']['quantity']; ?>
																</td>
																<td>
																	 $<?php echo $order_details['OrderDetail']['gross_price']; ?>
																</td>
																
																
																<td>
																	 <?php echo $products['Product']['product_discount']." %"; ?>
																</td>
																<td>
																<?php 
																$price = ($order_details['OrderDetail']['quantity']*$order_details['OrderDetail']['unit_price']); 
																$disc = (($price*$products['Product']['product_discount'])/100); 
																$grtotal = ($price - $disc);
																?>
																<?php
																	if($products['Product']['product_discount'] == 0)
																	{
																	 echo "$".$price;
																	}
																	else
																	{
																	echo "$".$grtotal;
																	}
																?>
																</td>
															</tr>
																<?php } ?>
															<?php } ?>
															</tbody>
															
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
											</div>
											<div class="col-md-6">
												<div class="well">
													<div class="row static-info align-reverse">
														<div class="col-md-8 name">
															 Sub Total:
														</div>
														<div class="col-md-3 value">
															 <?php
																	if($products['Product']['product_discount'] == 0)
																	{
																	 echo "$".$price;
																	}
																	else
																	{
																	echo "$".$grtotal;
																	}
																?>
														</div>
													</div>
													<div class="row static-info align-reverse">
														<div class="col-md-8 name">
															 Shipping:
														</div>
														<div class="col-md-3 value">
															 $<?php echo $datas['Order']['shipping_cost']; ?>
														</div>
													</div>
													<div class="row static-info align-reverse">
														<div class="col-md-8 name">
															 Grand Total:
														</div>
														<div class="col-md-3 value">
															 <?php
																	if($products['Product']['product_discount'] == 0)
																	{
																	 echo "$".($price + $datas['Order']['shipping_cost']);
																	}
																	else
																	{
																	echo "$".($grtotal + $datas['Order']['shipping_cost']);
																	}
																?>
														</div>
													</div>
													<div class="row static-info align-reverse">
														<div class="col-md-8 name">
															 Order Date:
														</div>
														<div class="col-md-3 value">
															 <?php echo date("d M Y",strtotime($datas['Order']['order_date'])); ?>
														</div>
													</div>
													<div class="row static-info align-reverse">
														<div class="col-md-8 name">
															 Delivery Date:
														</div>
														<div class="col-md-3 value">
															 <?php 
															 if($datas['Order']['delivery_date']== NULL)
															 {
																echo "N/A";
															 }
															 else
															 {
																echo date("d M Y",strtotime($datas['Order']['delivery_date']));
															 }
															 ?>
														</div>
													</div>
													<!--<div class="row static-info align-reverse">
														<div class="col-md-8 name">
															 Total Due:
														</div>
														<div class="col-md-3 value">
															 $1,124.50
														</div>
													</div>-->
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="tab_2">
										<div class="invoice">
											<div class="row invoice-logo">
												<div class="col-md-6 invoice-logo-space">
													<img  src="<?php echo IMGPATH."admin_logo/original/".$siteSettings['SiteSetting']['admin_logo']; ?>" height="50px" width="250px" alt=""/>
												</div>
												<div class="col-md-6">
													<p>
														 #<?php echo $datas['Order']['id']; ?> / <?php echo date("d M Y", strtotime($datas['Order']['order_date'])); ?> <!--<span class="muted">
														Consectetuer adipiscing elit </span>-->
													</p>
												</div>
											</div>
										<hr/>
											<div class="row">
												<div class="col-md-6">
													<h3>Billing Details:</h3>
													<ul class="list-unstyled">
													<?php foreach($data as $datas){ ?>
														<li>
															 <b>User Id: </b> <?php echo $datas["Order"]["user_id"]; ?>
														</li>
														<li>
															 <b>Name: </b> <?php echo $datas["Order"]["firstname"]." ".$datas["Order"]["lastname"]; ?>
														</li>
														<li>
															 <b>Email Id: </b><?php echo $datas["Order"]["email_id"]; ?>
														</li>
														<li>
															 <b>T: </b> <?php echo $datas["Order"]["telephone"]; ?>
														</li>
														<li>
															 <b>F: </b> <?php 
																if($datas["Order"]["fax"] == "")
																{
																	echo "N/A";
																}
																 else
																 {
																	echo $datas["Order"]["fax"]; 
																 }
																 ?>
														</li>
														<li>
															 <b>Company: </b> 
															 <?php 
																if($datas["Order"]["company"] == "")
																{
																	echo "N/A";
																}
																 else
																 {
																	echo $datas["Order"]["company"]; 
																 } 
																 ?>
														</li>
														<li>
															 <b>Address: </b> <?php echo $datas["Order"]["address"]; ?>
														</li>
														
														<li>
															 <?php echo $datas["Order"]["address1"]; ?>
														</li>
														<li>
															 <?php echo $city[$datas["Order"]["city"]]; ?>
														</li>
														<li>
															 <?php echo $state[$datas["Order"]["state"]]; ?>
														</li>
														<li>
															 <?php echo $datas["Order"]["postcode"]; ?>
														</li>
														<li>
															 <?php echo $country[$datas["Order"]["country"]]; ?>
														</li>
													<?php	} ?>
													</ul>
												</div>
												<div class="col-md-6">
													<h3>Shipping Details:</h3>
													<ul class="list-unstyled">
														<?php foreach($data as $datas){ ?>
														<li>
															 <b>User Id: </b> <?php echo $datas["Order"]["user_id"]; ?>
														</li>
														<li>
															 <b>Name: </b> <?php echo $datas["Order"]["ship_firstname"]." ".$datas["Order"]["ship_lastname"]; ?>
														</li>
														<li>
															 <b>Email Id: </b><?php echo $datas["Order"]["ship_email_id"]; ?>
														</li>
														<li>
															 <b>T: </b> <?php echo $datas["Order"]["ship_telephone"]; ?>
														</li>
														<li>
															 <b>F: </b> <?php 
																if($datas["Order"]["ship_fax"] == "")
																{
																	echo "N/A";
																}
																 else
																 {
																	echo $datas["Order"]["ship_fax"]; 
																 }
																 ?>
														</li>
														<li>
															 <b>Company: </b> 
															 <?php 
																if($datas["Order"]["ship_company"] == "")
																{
																	echo "N/A";
																}
																 else
																 {
																	echo $datas["Order"]["ship_company"]; 
																 } 
																 ?>
														</li>
														<li>
															 <b>Address: </b> <?php echo $datas["Order"]["ship_address"]; ?>
														</li>
														
														<li>
															 <?php echo $datas["Order"]["ship_address1"]; ?>
														</li>
														<!--<li>
															 <?php //echo $city[$datas["Order"]["city"]]; ?>
														</li>-->
														<li>
															 <?php echo $state[$datas["Order"]["ship_state"]]; ?>
														</li>
														<li>
															 <?php echo $datas["Order"]["ship_postcode"]; ?>
														</li>
														<li>
															 <?php echo $country[$datas["Order"]["ship_country"]]; ?>
														</li>
													<?php	} ?>
													</ul>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<table class="table table-striped table-hover">
													<thead>
													<tr>
														<th>
															 #
														</th>
														<th>
															 Item
														</th>
														<th class="hidden-480">
															 Description
														</th>
														<th class="hidden-480">
															 Quantity
														</th>
														<th class="hidden-480">
															 Unit Cost
														</th>
														<th>
															 Total
														</th>
													</tr>
													</thead>
													<?php foreach($pro as $product){ ?>
													<tbody>
													<tr>
														<td>
															 1
														</td>
														<td>
															 <?php echo $product['Product']['product_name']; ?>
														</td>
														<td class="hidden-480">
														<?php
														foreach($prodet as $prodets){
														echo "<b>".$productoption[$prodets['ProductAssignOption']['option_id']]."</b>".": ";
														
														?>
														<?php
														
														echo $option_val[$prodets['ProductAssignOption']['option_value_id']]." ";
														}
														?>
															 
														</td>
														<td class="hidden-480">
															 <?php echo $order_details['OrderDetail']['quantity']; ?>
														</td>
														<td class="hidden-480">
															 $<?php echo $order_details['OrderDetail']['unit_price']; ?>
														</td>
														<td>
														<?php $price = ($order_details['OrderDetail']['quantity']*$order_details['OrderDetail']['unit_price']); ?>
															 $<?php echo $price; ?>
														</td>
													</tr>
													</tbody>
													<?php } ?>
													</table>
												</div>
											</div>
											<br/>
											<div class="row">
												<div class="col-md-4">
													<div class="well">
														<address>
														<strong><?php echo $siteSettings['SiteSetting']['com']; ?> </strong><br/>
														<?php echo $siteSettings['SiteSetting']['address']; ?>
														<?php echo $siteSettings['SiteSetting']['post_address']; ?><br/>
														<abbr title="Phone">P:</abbr> <?php echo $siteSettings['SiteSetting']['phone']; ?> </address>
														<address>
														<strong>Full Name</strong><br/>
														<a href="mailto:#">
														<?php echo $siteSettings['SiteSetting']['admin_email']; ?> </a>
														</address>
													</div>
												</div>
												<div class="col-md-8 invoice-block">
													<ul class="list-unstyled amounts">
														<li>
															<strong>Sub - Total amount:</strong> $<?php echo $price; ?>
														</li>
														<li>
															<strong>Discount:</strong> <?php echo $product['Product']['product_discount']; ?>%
														</li>
														<?php 
														$disc = (($price*$product['Product']['product_discount'])/100); 
														$grtotal = ($price - $disc);
														?>
														<li>
															<strong>Grand Total:</strong> 
															<?php
																if($product['Product']['product_discount'] == 0)
																{
																 echo "$".$price;
																}
																else
																{
																echo "$".$grtotal;
																}
															?>
														</li>
													</ul>
													<br/>
													<a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
													Print <i class="fa fa-print"></i>
													</a>
													
													<!--<a class="btn btn-lg green hidden-print margin-bottom-5">
													Submit Your Invoice <i class="fa fa-check"></i>
													</a>-->
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
<div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true"></div>

<script>
$(document).ready(function(){
	$('#link1').click(function(){
			$.ajax({
					url:'<?php echo $this->Html->url(array('controller'=>'Orders','action'=>'admin_deliver_status/'.$datas['Order']['id']), array('full_base'=>true)); ?>',
					success:function(result){
							if(result == 'N')
							{
							$('#not_delivered').show();
							$('#delivered').hide();
							$('#all_status_for_deliverd').hide();
							}
							if(result == 'Y')
							{
							$('#delivered').show();
							$('#not_delivered').hide();
							$('#all_status_for_deliverd').hide();
							}
					}
				}); 
		});
		
		$('#link2').click(function(){
		$.ajax({
		url:'<?php echo $this->Html->url(array(
									'controller'=>'Orders',
									'action'=>'admin_payment_status/'.$datas['Order']['id']),
									array(
									'full_base'=>true
									)); ?>',
		success:function(result){
				if(result == 'N')
							{
							$('#Due').show();
							$('#Paid').hide();
							$('#all_status_for_payment').hide();
							}
							if(result == 'Y')
							{
							$('#Paid').show();
							$('#Due').hide();
							$('#all_status_for_payment').hide();
							}
					}
		});
		});
		
		$('#link3').click(function(){
			$.ajax({
					url:'<?php echo $this->Html->url(array('controller'=>'Orders','action'=>'admin_order_status/'.$datas['Order']['id']), array('full_base'=>true)); ?>',
					success:function(result){
							if(result == 'P')
							{
							$('#for_Pending').show();
							$('#for_Successful').hide();
							$('#all_status_for_Order').hide();
							}
							if(result == 'S')
							{
							$('#for_Successful').show();
							$('#for_Pending').hide();
							$('#all_status_for_Order').hide();
							}
					}
				}); 
		});
		
		$('.edit').click(function(e){
		e.preventDefault();
		if($(this).attr('rel'))
		{
			var id = $(this).attr('rel');
		}
		else
		{
			var id = '';
		}
		$.ajax({
			type:'POST',
			url:'<?php echo $this->Html->url(array('controller'=>'Orders','action'=>'admin_editdeliverystatus/','full_base'=>true)); ?>',
			data:{id:id},
			success:function(result){
				//alert()
				$('#responsive').html(result);
			}
		});
	});
});
</script>	
				
			