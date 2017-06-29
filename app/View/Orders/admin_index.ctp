<?php
	//$statusArr = array('Y'=>'Delivered','N'=>'Pending');
	$order = array('S'=>'Successful','P'=>'Pending');
	$deliver = array('Y'=>'Delivered','N'=>'Not Delivered');
	$pay = array('Y'=>'Paid','N'=>'Due');
	//pr($data);exit;
	$currentModelPer=$this->Session->read('currentModelPer');
	//pr($currentModelPer);
?>
<div class="row" style="padding:10px 0 10px 0;">
	<div class="col-md-12">
		<?php 
		if($currentModelPer['delete']=='Y')
		{
		echo $this->Form->button('<span class="fa fa-trash-o"></span> Delete All', array('type' => 'submit', 'id'=>'deleteAll', 'class'=>"btn red"));
		}
		?>	
	</div>
</div>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-cogs"></i>List of Orders
		</div>
	</div>
	
	<div class="portlet-body flip-scroll">
	<?php if(count($data) > 0){ ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
		<td class="table-checkbox" width="1%">
				<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
		</td>
			<th align="center" class="numeric"></th>
		
		<td align="center" style="font-weight:bold" class="numeric">
				<?php echo $this->Paginator->sort('ship_name', 'Name',array('escape' => false, 'class'=>'sorting_both')); ?>
		</td>
		
		
		<td  align="center" style="font-weight:bold" class="numeric">
				<?php echo $this->Paginator->sort('email', 'Email',array('escape' => false, 'class'=>'sorting_both')); ?>
		</td>
		
		<td align="center" style="font-weight:bold" class="numeric">
				<?php echo $this->Paginator->sort('created_date', 'Order Date', array('escape' => false, 'class'=>'sorting_both')); ?>
		</td>
		
		<td  align="center" style="font-weight:bold" class="numeric">
				<?php echo $this->Paginator->sort('amount', 'Amount',array('escape' => false, 'class'=>'sorting_both')); ?>
		</td>
		<!--<td width="10%" align="center" style="font-weight:bold">
				Shipped
		</td>-->
		
		<td  align="center" style="font-weight:bold" class="numeric">
				Order Status
		</td>
		
		<td  align="center" style="font-weight:bold" class="numeric">
				Delivery Status
		</td>
		
		<td  align="center" style="font-weight:bold" class="numeric">
				Payment Status
		</td>
		
		<td  align="center" style="font-weight:bold" class="numeric">
				Actions
		</td>
		</tr>	
		</thead>
		<tbody>
		
		<?php
			foreach($data as $post){
				?>
				<tr>
				
				     <td>
						<?php echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$post['Order']['id'])); ?>
					</td>
					<td>
						<center>
							<?php 
							if($currentModelPer['edit']=='Y')
					        {
							if($post['Order']['order_status']=='S'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'Orders', 'action'=>'admin_status/'.$post['Order']['id'].'/P'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'Orders', 'action'=>'admin_status/'.$post['Order']['id'].'/S'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}
							}
							?>
						</center>
					</td>
			
							
					<td align="center" >
					<?php echo $post['Order']['firstname']." ".$post['Order']['lastname']; ?>
					</td>
					
					<td align="center" >
					<?php echo $post['Order']['email_id']; ?>
					</td>
					
					<td align="center" >
					<?php echo date("d-m-Y, H:i",strtotime($post['Order']['order_date'])); ?>
					</td>
					
					<td align="center" >
					<?php if($post['Order']['order_amount']!=="0")
					{
					$totalcost=$post['Order']['order_amount']+$post['Order']['shipping_cost'];
					echo CURRENCY.$totalcost;
					}
					else
					{
					echo $post['Order']['order_amount'];
					}
					?>
					</td>
					
					<td align="center" >
						<?php 
							echo ($post['Order']['order_status']=='S')?'<span class="label label-success">':'<span class="label label-danger">';
							echo isset($post['Order']['order_status'])?$order[$post['Order']['order_status']]:'';
							echo '</span>';				
						?>	
					</td>
					
					<td align="center" >
						<?php 
							echo ($post['Order']['delivery_status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
							echo isset($post['Order']['delivery_status'])?$deliver[$post['Order']['delivery_status']]:'';
							echo '</span>';				
						?>	
					</td>
					
					<td align="center" >
						<?php 
							echo ($post['Order']['payment_status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
							echo isset($post['Order']['payment_status'])?$pay[$post['Order']['payment_status']]:'';
							echo '</span>';				
						?>	
					</td>
					
					<!--<td align="center">
						<?php 
							/* echo ($post['Order']['status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
							echo isset($post['Order']['status'])?$statusArr[$post['Order']['status']]:'';
							echo '</span>';	 */			
						?>
					
					</td>-->
					
					<td align="center" style="width:160px">
					<div class="col-md-6" align="center">
						<?php 
						if($currentModelPer['view']=='Y')
							{
							
							echo $this->Html->link($this->Html->image(IMGPATH1.'review.png', array('alt'=>'loading..','Title'=>'View')), array('controller'=>'Orders', 'action'=>'admin_manage/'.$post['Order']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>''));
							}							
						?>
						</div>
						<div class="col-md-6" align="center">
						<?php
							if($currentModelPer['delete']=='Y')
							{
							
							echo $this->Html->link($this->Html->image(IMGPATH1.'delete.png', array('alt'=>'loading..','Title'=>'Delete')), array('controller'=>'Orders', 'action'=>'admin_delete/'.$post['Order']['id']."/1"), array('escape'=>false, 'full_base'=>true,'confirm' => 'Do you really want to delete this record?', 'class'=>''));
							}
						?>
						</div>
					</td>
				
				</tr>
				<?php
			}
		?>
		</tbody>
		</table>
		<?php echo $this->element('admin_paginator'); ?>
		<?php } else { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="note note-info"> <center>No Record Found</center></div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>

<script type="text/javascript">
$(function(){
	$('#deleteAll').click(function(e){
		e.preventDefault();
		var idAll = [];
		var set = jQuery('.table .group-checkable').attr("data-set");
		
		jQuery(set).each(function () {
			var checked = jQuery(this).is(":checked");
			if (checked) {
				var presentId = $(this).val();
				idAll.push(presentId);
			}
		});
		if(idAll.length > 0){
			if(confirm('Are you sure ? ')){
				var url = '<?php echo $this->Html->url(array('controller'=>'Orders','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>