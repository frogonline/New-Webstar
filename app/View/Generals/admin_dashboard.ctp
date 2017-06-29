<div class="row">
	<div class="col-md-12">
		<!--<h3>Welcome To Admin Panel</h3>-->
		<div class="row">			    		
			<div class="col-lg-6 col-md-3 col-sm-12 col-xs-12">					
				<div class="dashboard-stat red-intense">						
					<div class="visual"><i class="fa fa-check"></i>	</div>                       
										
					<div class="details">							
						<div class="number"><?php echo isset($subscribercount)?$subscribercount:'0';?></div>							
						<div class="desc"> Subscribers</div>						
					</div>						
					<a class="more" href="<?=SITE_URL?>admin/Subscribers/index">View more 
					<i class="m-icon-swapright m-icon-white"></i>
					</a>					
				</div>				
			</div>
			<!----<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat green-haze">
						<div class="visual">
							<i class="fa fa-user"></i>
						</div>                       
						<div class="details">
							<div class="number">
								<?php echo isset($memcount)?$memcount:'0';?>
							</div>
							<div class="desc">
								  Members
							</div>
						</div>
						<a class="more" href="<?=SITE_URL?>admin/Members/index">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div> ---->
			<div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat green-haze">
						<div class="visual">
							<i class="fa fa-shopping-cart"></i>
						</div>                       
						
						<div class="details">
							<div class="number">
								<?php echo isset($ordercount)?$ordercount:'0';?>
							</div>
							<div class="desc">
								Orders
							</div>
						</div>
						<a class="more" href="<?=SITE_URL?>admin/Orders/index">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<!---<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat purple-plum">
						<div class="visual">
							<i class="fa fa-user"></i>
						</div>                  
						
						<div class="details">
							<div class="number">
								<?php //echo $num1;?>
							</div>
							<div class="desc">
								 New Orders
							</div>
						</div>
						<a class="more" href="<?=SITE_URL?>admin/Members/index">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div> --->
			</div>
		<div class="clearfix">
			</div>
		
			<div class="clearfix">
			</div>
			<div class="row ">
				<div class="col-md-6 col-sm-6">
					<div class="portlet box blue-steel">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-user"></i>Latest 10 Subscribers
							</div>
							
						</div>
						<div class="portlet-body">
							<div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
							
								<ul class="feeds">
								<?php
								$class_color=array("label-success","label-success","label-success","label-success");
								$class_array=array("fa fa-user","fa fa-user","fa fa-user","fa fa-user","fa fa-user","fa fa-user");
								$i=0;
								
								foreach($subscribers as $subscriber)
								{
									$a=$i%4;
									$b=$i%6;
								?>
									<li>
										<a href="">
										<div class="col1">
											<div class="cont">
												<div class="cont-col1">
													<div class="label label-sm <?=$class_color[$a]?>">
														<i class="<?=$class_array[$b]?>"></i>
													</div>
												</div>
												<div class="cont-col2">
													<div class="desc">
														 <?php echo $subscriber['Subscriber']['subscriber_email'];?>
													</div>
												</div>
											</div>
										</div>
										</a>
									</li>
								<?php
										
									}
								?>
								</ul>
							</div>
							
						</div>
					</div>
				</div>
				<!--<div class="col-md-6 col-sm-6">
					<div class="portlet box purple-wisteria">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-bullhorn"></i>Latest 10 Orders
							</div>
							
						</div>
						<div class="portlet-body">
							<div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
								<?php
								$class_color=array("label-default","label-default","label-default","label-default");
								$class_array=array("fa fa-bullhorn","fa fa-bullhorn","fa fa-bullhorn","fa fa-bullhorn","fa fa-bullhorn","fa fa-bullhorn");
								?>
								<ul class="feeds">
								<?php
									$i=0;
									
									foreach($order as $orderss)
									{
										$a=$i%4;
										$b=$i%6;
								?>
									<li>
										<a href="#">
										<div class="col1">
											<div class="cont">
												<div class="cont-col1">
													<div class="label label-sm <?=$class_color[$a]?>">
														<i class="<?=$class_array[$b]?>"></i>
													</div>
												</div>
												<div class="cont-col2">
													<div class="desc">
														 <?php echo $orderss['Order']['id'];?>
													</div>
												</div>
											</div>
										</div>
				
										</a>
									</li>
								<?php
										$i++;
									}
								?>
								</ul>
							</div>
							
						</div>
					</div>
				</div>	
			</div>
			<div class="clearfix">
			</div>		--->	
			<!---<div class="row ">
				<div class="col-md-6 col-sm-6">
					<div class="portlet box green-haze">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-bar-chart-o"></i> Latest 10 Members
							</div>
							
						</div>
						<div class="portlet-body">
							<div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
								<?php
								/* $class_color=array("label-success","label-success","label-success","label-success");
								$class_array=array("fa fa-bar-chart-o","fa fa-bar-chart-o","fa fa-bar-chart-o","fa fa-bar-chart-o","fa fa-bar-chart-o","fa fa-bar-chart-o"); */
								?>
								<ul class="feeds">
								<?php
									/* $i=0;
									foreach($members as $member)
									{
										$a=$i%4;
										$b=$i%6; */
								?>
									<li>
										<a href="">
										<div class="col1">
											<div class="cont">
												<div class="cont-col1">
													<div class="label label-sm <?//=$class_color[$a]?>">
														<i class="<?//=$class_array[$b]?>"></i>
													</div>
												</div>
												<div class="cont-col2">
													<div class="desc">
														 <?php //echo $member['Member']['name'];?>
													</div>
												</div>
											</div>
										</div>
										
										</a>
									</li>
								<?php
										/* $i++;
									} */
								?>
								</ul>
							</div>
							
						</div>
					</div>
				</div>
				---->
				<div class="col-md-6 col-sm-6">	
					<div class="portlet box red-intense">
						<div class="portlet-title">		
							<div class="caption">			
								<i class="fa fa-shopping-cart"></i>Latest 10 orders
							</div>	
						</div>					
						<div class="portlet-body">	
						<div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">	
						<?php 
							$class_color=array("label-danger","label-danger","label-danger","label-danger");		
							$class_array=array("fa fa-shopping-cart","fa fa-shopping-cart","fa fa-shopping-cart","fa fa-shopping-cart","fa fa-shopping-cart","fa fa-shopping-cart"); 			
						?>					
						<ul class="feeds">			
						<?php						
						 $i=0;							
						foreach($order as $orderss)	
						{								
							$a=$i%4;						
							$b=$i%6;					
						?>									
							<li>									
							<a href="#">					
							<div class="col1">				
								<div class="cont">					
									<div class="cont-col1">				
										<div class="label label-sm <?=$class_color[$a]?>">		
											<i class="<?=$class_array[$b]?>"></i>						
										</div>										
									</div>											
									<div class="cont-col2">										
										<div class="desc">  		
											<?php echo $orderss['Order']['firstname']." ".$orderss['Order']['lastname']; ?>
										</div>										
									</div>										
								</div>									
							</div>																
							</a>								
							</li>								
						<?php							
							 $i++;								
						}					
						?>							
						</ul>						
						</div>									
						</div>				
					</div>				
				</div>
			</div> 
			<div class="clearfix">
			</div>
	</div>
</div>