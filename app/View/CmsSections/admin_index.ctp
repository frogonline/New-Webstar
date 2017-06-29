<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
?>
<div class="row" style="padding:10px 0 10px 0;">
	<div class="col-md-12">
		<?php echo $this->Form->button('<span class="fa fa-trash-o"></span> Delete All', array('type' => 'submit', 'id'=>'deleteAll', 'class'=>"btn red"));?>
		<?php echo $this->Html->link('<i class="fa fa-times"></i> Reset Search', array('controller'=>'Testimonials','action'=>'admin_index'), array('class'=>"btn red filter-cancel", 'style'=>'float:right;', 'escape'=>false)); ?>
	</div>
</div>

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-table"></i>List of Testimonials
		</div>
	</div>
	<div class="portlet-body flip-scroll">
		<?php if(count($data) > 0){ ?>
		<?php echo $this->Form->create('CmsSection', array('action' => 'admin_index', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
			<td class="table-checkbox" width="5%" align="center">
				<!--<input type="checkbox" class="group-checkable" data-set=".table .checkboxes"/>-->
				<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
			</td>
			<td class="numeric" width="5%" align="center" ></td>
			<td width="20%" align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('title', 'Title',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td width="20%" align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('heading', 'Heading',array('escape' => false, 'class'=>'sorting_both')); ?>
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
			foreach($data as $test){
				?>
				<tr>
					<td align="center">
						<!--<input type="checkbox" class="checkboxes" value="1"/>-->
						<?php echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$test['CmsSection']['id'])); ?>
					</td>
					<td align="center">
						<center>
							<?php 
							if($test['CmsSection']['status']=='Y'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'CmsSections', 'action'=>'admin_status/'.$test['CmsSection']['id'].'/N'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'CmsSections', 'action'=>'admin_status/'.$test['CmsSection']['id'].'/Y'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}
							?>
						</center>
					</td>
					<td align="center">
						<?php echo $test['CmsSection']['title']; ?>
					</td>
					<td align="center">
						<?php echo $test['CmsSection']['heading']; ?>
					</td>
					
					<td align="center">
						<?php 
							echo ($test['CmsSection']['status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
							echo isset($test['CmsSection']['status'])?$statusArr[$test['CmsSection']['status']]:'';
							echo '</span>';				
						?>
					</td>
					
					<td class="numeric" align="center">
							<?php
								echo $this->Html->link('<i class="fa fa-edit"></i> Edit', array('controller'=>'CmsSections', 'action'=>'admin_manage/'.$test['CmsSection']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>'btn default btn-xs purple'));?>
								
							<?php echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete',"/admin/CmsSections/delete/".$test['CmsSection']['id']."/1", 
							array('escape' => false,'full_base'=>true,'title'=>"Remove",'class'=>"btn default btn-xs red",'confirm' => 'Do you really want to delete this details?'));
							?>
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
				var url = '<?php echo $this->Html->url(array('controller'=>'CmsSections','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll+'/1';
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>