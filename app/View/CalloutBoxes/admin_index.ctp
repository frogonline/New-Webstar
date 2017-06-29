<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
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
			<i class="fa fa-table"></i>List of Callout Boxes
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
			<td class="numeric" width="5%" align="center" ></td>
			<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('heading', 'Box Title',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('description', 'Box Description',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('button_text', 'Button Text',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td  align="center" style="font-weight:bold">
				Short Code
			</td>
			<td class="numeric" align="center" style="font-weight:bold">
				Status
			</td>
			<td class="numeric" align="center" style="font-weight:bold">
				Action
			</td>
		</tr>
		</thead>
		<tbody>
		
		<?php
			foreach($data as $item){
				?>
				<tr>
					 <td>
						<?php echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$item['CalloutBox']['id'])); ?>
					</td>
					<td align="center">
						<center>
							<?php 
							if($currentModelPer['edit']=='Y')
					        {
							if($item['CalloutBox']['status']=='Y'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'CalloutBoxes', 'action'=>'admin_status/'.$item['CalloutBox']['id'].'/N'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'CalloutBoxes', 'action'=>'admin_status/'.$item['CalloutBox']['id'].'/Y'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}
							}
							?>
						</center>
					</td>
					<td align="center">
						<?php echo $item['CalloutBox']['heading']; ?>
					</td>
					<td align="center">
						<?php echo $item['CalloutBox']['description']; ?>
					</td>
					<td align="center">
						<?php echo $item['CalloutBox']['button_text']; ?>
					</td>
					<td align="center">
						<?php echo '[CalloutBox-'.$item['CalloutBox']['id'].']'; ?>
					</td>
					<td align="center"  style="width:94px">
						<?php 
							echo ($item['CalloutBox']['status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
							echo isset($item['CalloutBox']['status'])?$statusArr[$item['CalloutBox']['status']]:'';
							echo '</span>';				
						?>
					</td>
					
					<td >
					
							<?php
							if($currentModelPer['edit']=='Y')
							{
							?>
							<div class="col-md-6">
							<?php echo $this->Html->link($this->Html->image(IMGPATH1.'edit.png', array('alt'=>'loading..','Title'=>'Edit')), array('controller'=>'CalloutBoxes', 'action'=>'admin_manage/'.$item['CalloutBox']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>'')); ?>
							</div>
							<?php
							}
							?>
							
							<div class="col-md-3">
							<?php
							if($currentModelPer['delete']=='Y')
							{
								echo $this->Html->link($this->Html->image(IMGPATH1.'delete.png', array('alt'=>'loading..','Title'=>'Delete')),"/admin/CalloutBoxes/delete/".$item['CalloutBox']['id'], 
								array('escape' => false,'full_base'=>true,'title'=>"Remove",'class'=>"",'confirm' => 'Do you really want to delete this Callout Box details?'));
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
		<?php echo $this->Form->end(); ?>
		<?php } else { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="note note-info"> <center>No Record Found</center></div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true"></div>
<div id="responsive1" class="modal fade" tabindex="-1" aria-hidden="true"></div>


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
				var url = '<?php echo $this->Html->url(array('controller'=>'CalloutBoxes','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>