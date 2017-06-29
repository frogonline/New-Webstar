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
		?>
		<?php echo $this->Form->button('<span class="fa fa-trash-o"></span> Delete All', array('type' => 'submit', 'id'=>'deleteAll', 'class'=>"btn red"));?>
		<?php
		}
		?>
		<?php echo $this->Html->link('<i class="fa fa-times"></i> Reset Search', array('controller'=>'Posts','action'=>'admin_index'), array('class'=>"btn red filter-cancel", 'style'=>'float:right;', 'escape'=>false)); ?>
	</div>
</div>

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-table"></i>Lists of Forms
		</div>
	</div>
	<div class="portlet-body flip-scroll">
		<?php if(count($data) > 0){ ?>
		<?php echo $this->Form->create('FormTable', array('url'=>array('controller'=>'FormTables','action' => 'admin_index'), 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
			<tr>
				<th class="table-checkbox" width="2%">
					<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
				</th>
				<th class="numeric" width="3%"></th>
				<th class="numeric" style="font-weight:bold">
					<center><?php echo $this->Paginator->sort('name', 'Title',array('escape' => false, 'class'=>'sorting_both')); ?></center>
				</th>
				<th style="font-weight:bold">
					<center>Action</center>
				</th>
			</tr>
		</thead>
		<tbody>
		
		<?php
		foreach($data as $item){
			?>
			<tr>
				<td class="table-checkbox">
					<?php echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$item['FormTable']['id'])); ?>
				</td>
				<td>
					<center>
						<?php 
						if($currentModelPer['edit']=='Y')
						{
						if($item['FormTable']['status']=='Y'){
							echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'FormTables', 'action'=>'admin_status/'.$item['FormTable']['id'].'/N'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
						} else {
							echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'FormTables', 'action'=>'admin_status/'.$item['FormTable']['id'].'/Y'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
						}
						}
						?>
					</center>
				</td>
				<td align="center">
					<?php echo $item['FormTable']['name']; ?>
				</td>
				<td class="numeric" style="width:175px;" align="center">
					<div class="col-md-4">
					<?php 
					if($currentModelPer['edit']=='Y')
					{
					
						echo $this->Html->link($this->Html->image(IMGPATH1.'edit.png', array('alt'=>'loading..','Title'=>'Edit')), array('controller'=>'FormTables', 'action'=>'admin_manage/'.$item['FormTable']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>''));
						
						
						
					}
					?>
					</div>
					
					<!--<div class="col-md-3">
					<?php 
				/* 	if($currentModelPer['edit']=='Y')
					{
					
						
						echo $this->Html->link($this->Html->image(IMGPATH1.'show.png', array('alt'=>'loading..','Title'=>'Show Form Record')), array('controller'=>'FormTables', 'action'=>'admin_showrecord/'.$item['FormTable']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>''));
				
					} */
					?>
					</div> -->
					
					
					
					
					
					
					<div class="col-md-4">
					<?php
						echo $this->Html->link('<i class="fa fa-gear"></i>', array('controller'=>'FormTables', 'action'=>'admin_setting/'.$item['FormTable']['id']), array('escape'=>false, 'full_base'=>true));
					?>
					</div>
					<div class="col-md-4">
					<?php 
					if($currentModelPer['delete']=='Y')
					{
					
						echo $this->Html->link($this->Html->image(IMGPATH1.'delete.png', array('alt'=>'loading..','Title'=>'Delete')), array('controller'=>'FormTables', 'action'=>'admin_delete/'.$item['FormTable']['id']), array('escape'=>false, 'confirm' => 'Do you really want to delete this form?', 'full_base'=>true, 'class'=>''));
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
				var url = '<?php echo $this->Html->url(array('controller'=>'FormTables','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>