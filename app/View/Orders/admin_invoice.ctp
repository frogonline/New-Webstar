<?php 
$siteSettings = $this->Session->read('siteSettings');

?>

<?php foreach($data as $datas) {?>
<div>
<table class="table table-bordered mail-page table-responsive" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%"><img  src="<?php echo IMGPATH."site_settings_logo/original/".$siteSettings['SiteSetting']['logo']; ?>" height="50px" width="250px" class="img-responsive" alt=""/></td>
    <td width="50%" align="right" style="font-size:20px;"><?php echo date("d M Y", strtotime($datas['Order']['order_date'])); ?></td>
  </tr>
  <tr>
    <td colspan="2"><hr style="height:4px; outline:none; background:#2C303B; border:0; line-height:4px; display:block;"></td>
  </tr>
  <tr>
    <td>
    	<h2>Booking Details</h2>
    	<table  width="100%" cellspacing="0" cellpadding="0" style="background-color:#CCC" class="table table-bordered">
			<?php foreach($data as $datas){ ?>
        
          <tr>
            	<td bgcolor="#FFFFFF"><strong>Name:</strong></td>
            	<td bgcolor="#FFFFFF"> <?php echo $datas["Order"]["ship_firstname"]." ".$datas["Order"]["ship_lastname"]; ?>  </td>
          </tr>
          <tr>
            	<td bgcolor="#FFFFFF"><strong>Email Id:</strong></td>
            	<td bgcolor="#FFFFFF"> <?php echo $datas["Order"]["email_id"]; ?> </td>
          </tr>
          <tr>
            	<td bgcolor="#FFFFFF"><strong>Contact No:</strong></td>
            	<td bgcolor="#FFFFFF">  
					<?php echo $datas["Order"]["telephone"]; ?>
				</td>
          </tr>
          <tr>
            	<td bgcolor="#FFFFFF"><strong>Fax No:</strong></td>
            	<td bgcolor="#FFFFFF"> <?php 
										if($datas["Order"]["fax"] == "")
										{
											echo "N/A";
										}
										 else
										 {
											echo $datas["Order"]["fax"]; 
										 }
										 ?> 
				</td>
          </tr>
          <tr>
            	<td bgcolor="#FFFFFF"><strong>Company</strong></td>
            	<td bgcolor="#FFFFFF">  
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
				</td>
          </tr>
          <tr>
            	<td bgcolor="#FFFFFF"><strong>Address:</strong></td>
            	<td bgcolor="#FFFFFF">  <?php echo $datas["Order"]["address"]; ?>
				 <?php echo $datas["Order"]["address1"]; ?><br>
				 <?php echo $city[$datas["Order"]["city"]]; ?><br>
				 <?php echo $state[$datas["Order"]["state"]]; ?><br>
				 <?php echo $datas["Order"]["postcode"]; ?><br>
				 <?php echo $country[$datas["Order"]["country"]]; ?>  </td>
          </tr>
		  <?php } ?>
        </table>
    </td>
    
    <td>
    	<h2>Shipping Details</h2>
    		<table  width="100%" cellspacing="0" cellpadding="0" style="background-color:#CCC" class="table table-bordered">
		<?php foreach($data as $datas){ ?>
        
          <tr>
            	<td bgcolor="#FFFFFF"><strong>Name:</strong></td>
            	<td bgcolor="#FFFFFF"> <?php echo $datas["Order"]["ship_firstname"]." ".$datas["Order"]["ship_lastname"]; ?>  </td>
          </tr>
          <tr>
            	<td bgcolor="#FFFFFF"><strong>Email Id:</strong></td>
            	<td bgcolor="#FFFFFF"> <?php echo $datas["Order"]["ship_email_id"]; ?>  </td>
          </tr>
          <tr>
            	<td bgcolor="#FFFFFF"><strong>Contact No:</strong></td>
            	<td bgcolor="#FFFFFF">  <?php echo $datas["Order"]["ship_telephone"]; ?> </td>
          </tr>
          <tr>
            	<td bgcolor="#FFFFFF"><strong>Fax No:</strong></td>
            	<td bgcolor="#FFFFFF"> <?php 
										if($datas["Order"]["ship_fax"] == "")
										{
											echo "N/A";
										}
										 else
										 {
											echo $datas["Order"]["ship_fax"]; 
										 }
										 ?> 
				</td>
          </tr>
          <tr>
            	<td bgcolor="#FFFFFF"><strong>Company</strong></td>
            	<td bgcolor="#FFFFFF">   
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
				</td>
          </tr>
          <tr>
            	<td bgcolor="#FFFFFF"><strong>Address:</strong></td>
            	<td bgcolor="#FFFFFF">  <?php echo $datas["Order"]["ship_address"]; ?>
				<?php echo $datas["Order"]["ship_address1"]; ?><br>
				 
				 <?php echo $state[$datas["Order"]["ship_state"]]; ?><br>
				 <?php echo $datas["Order"]["ship_postcode"]; ?><br>
				<?php echo $country[$datas["Order"]["ship_country"]]; ?>  
				</td>
          </tr>
		  <?php } ?>
        </table>
    </td>
  </tr>
  <tr>
    <td colspan="2" style="padding-top:10px;">
   <table  width="100%" cellspacing="0" cellpadding="0" style="background-color:#CCC" class="table table-bordered">
        <tr>
          <th width="5%" bgcolor="#FFFFFF">No</th>
          <th width="20%" bgcolor="#FFFFFF">Item</th>
        
          <th width="11%" bgcolor="#FFFFFF">Quantity</th>
          <th width="19%" bgcolor="#FFFFFF" align="right">Unit Cost</th>
          <th width="20%" bgcolor="#FFFFFF" align="right">Total</th>
        </tr>
		<?php $i=1 ?>
			<?php foreach($order_detail as $order_details){ ?>  
        <tr>
          <td bgcolor="#FFFFFF"><?php echo $i; ?></td>
          <td width="5%" bgcolor="#FFFFFF">
			  <?php foreach($pro as $products){
				if($products['Product']['id']==$order_details['OrderDetail']['product_id']){
				?>
				
					<a href="#">
					<?php echo $products['Product']['product_name']; ?> </a>
					
				<?php } } ?>
		</td>
        										
          <td bgcolor="#FFFFFF" align="center"> <?php echo $order_details['OrderDetail']['quantity']; ?></td>
          <td bgcolor="#FFFFFF" align="right"> $<?php echo number_format($order_details['OrderDetail']['unit_price'],2); ?></td>
          <td bgcolor="#FFFFFF" align="right"><?php $price = ($order_details['OrderDetail']['quantity']*$order_details['OrderDetail']['unit_price']); ?>
															 $<?php echo number_format($price,2); ?></td>
        </tr>
        <?php $i++; }  ?>	      
        <tr>
		
          <td colspan="3" bgcolor="#f1f1f1">
          	<?php echo $siteSettings['SiteSetting']['com']; ?>
            
           <?php echo $siteSettings['SiteSetting']['address']; ?>
            
          
			<a>
			<?php echo $siteSettings['SiteSetting']['admin_email']; ?> </a>
          </td>
          <td colspan="3" bgcolor="#f1f1f1" align="right">
		  <span style="float:left;">Shipping amount</span> <strong> $<?php echo $datas['Order']['shipping_cost']; ?></strong><br/>
		  <span style="float:left;">Grand Total</span> <strong> $<?php
						$total=($datas['Order']['order_amount']+$datas['Order']['shipping_cost']);
															echo $total;
																?></strong>
		  </td>
        </tr>
		
    </table></td>
  </tr>
  
</table>
</div>
<?php } ?>
									
<script type="text/javascript">

$(document).ready(function(){

window.print();

});

</script>
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<style>
.table{	
	margin:0 auto;
}
.mail-page{width:70%; font-family:Arial, Helvetica, sans-serif; font-size:14px;}
</style>