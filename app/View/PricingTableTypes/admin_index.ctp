<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$currentModelPer=$this->Session->read('currentModelPer');
?>
<div class="row" style="padding:10px 0 10px 0;">
	<div class="col-md-12">
		<?php 
		if($currentModelPer['delete']=='Y')
		{
		echo $this->Form->button('<span class="fa fa-trash-o"></span> Delete All', array('type' => 'submit', 'id'=>'deleteAll', 'class'=>"btn red"));
		}
		?>
		<?php echo $this->Html->link('<i class="fa fa-times"></i> Reset Search', array('controller'=>'Users','action'=>'admin_index'), array('class'=>"btn red filter-cancel", 'style'=>'float:right;', 'escape'=>false)); ?>
	</div>
</div>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-cogs"></i>List of  Pricing Table
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
		<th  align="center"></th>
		
		<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('name', 'Name',array('escape' => false, 'class'=>'sorting_both')); ?>
		</td>
		<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('style', 'Style',array('escape' => false, 'class'=>'sorting_both')); ?>
		</td>

		
		<td  align="center" style="font-weight:bold">
				Short Code
		</td>
		<td  align="center" style="font-weight:bold">
				Status
		</td>
			<td  align="center" style="font-weight:bold">
				Action
			</td>
		</tr>
	
		</thead>
		<tbody>
		
		<?php
			foreach($data as $post){
				?>
				<tr>
				
				     <td>
						<?php echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$post['PricePlanType']['id'])); ?>
					</td>
					<td>
						<center>
							<?php 
							if($currentModelPer['edit']=='Y')
					        {
							if($post['PricePlanType']['status']=='Y'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'PricingTableTypes', 'action'=>'admin_status/'.$post['PricePlanType']['id'].'/N'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'PricingTableTypes', 'action'=>'admin_status/'.$post['PricePlanType']['id'].'/Y'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}
							}
							?>
						</center>
					</td>
					<td align="center">
						<?php echo $post['PricePlanType']['name']; ?>
					</td>
					<td align="center">
						<?php echo $stylesArr[$post['PricePlanType']['style']]; ?>
					</td>
					<td align="center" >
					<?php echo '[PricePlanType-'.$post['PricePlanType']['id'].']'; ?>
					</td>
					<td align="center">
						<?php 
							echo ($post['PricePlanType']['status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
							echo isset($post['PricePlanType']['status'])?$statusArr[$post['PricePlanType']['status']]:'';
							echo '</span>';				
						?>
					
					</td>
					
					<td align="center">
						<div class="col-md-6">
						<?php
						if($currentModelPer['edit']=='Y')
						{
							echo $this->Html->link($this->Html->image(IMGPATH1.'edit.png', array('alt'=>'loading..','Title'=>'Edit')), array('controller'=>'PricingTableTypes', 'action'=>'admin_manage/'.$post['PricePlanType']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>''));
						}
						?>
						</div>
						<div class="col-md-6">
						<?php
						if($currentModelPer['delete']=='Y')
						{
							echo $this->Html->link($this->Html->image(IMGPATH1.'delete.png', array('alt'=>'loading..','Title'=>'Delete')), array('controller'=>'PricingTableTypes', 'action'=>'admin_delete/'.$post['PricePlanType']['id']."/1"), array('escape'=>false, 'confirm' => 'Do you really want to delete this Price Plan?', 'full_base'=>true, 'class'=>''));
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
				var url = '<?php echo $this->Html->url(array('controller'=>'PricingTableTypes','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>