<?php
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
		<?php echo $this->Html->link('<i class="fa fa-times"></i> Reset Search', array('controller'=>'PageTemplates','action'=>'admin_index'), array('class'=>"btn red filter-cancel", 'style'=>'float:right;', 'escape'=>false)); ?>
	</div>
</div>

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-table"></i>Lists of Page Templates
		</div>
	</div>
	<div class="portlet-body flip-scroll">
	<?php if(count($data) > 0){ ?>
	<?php echo $this->Form->create('PageTemplate', array('action' => 'admin_index', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
			<td width="5%" class="table-checkbox" align="center">
				<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
			</td>
			<td  align="center" style="font-weight:bold">Show to client</td>
			<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('template_name', 'Page Template Name',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('template_for', 'Template Type',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td class="numeric" align="center" style="font-weight:bold">
				Action
			</td>
		</tr>
		<tr role="row" class="filter">
		<td></td>
		<td></td>
		<td>
			<?php echo $this->Form->input('template_name',array('type'=>'text','label'=>false,'class'=>'form-control form-filter input-sm','value'=>(isset($searchData['PageTemplate']))?$searchData['PageTemplate']['template_name']:'')); ?>
		</td>
		<td></td>
		<td>
			<div align="center" class="margin-bottom-5">
				<?php echo $this->Form->button('<i class="fa fa-search"></i> Search', array('type' => 'submit', 'class'=>"btn btn-sm yellow filter-submit margin-bottom", 'escape'=>false)); ?>
			</div>
		</td>
	</tr>
		</thead>
		<tbody>
		
		<?php
		
			foreach($data as $page){
				/*** To Escape Home Row ****/
				
				/*** To Escape Home Row ****/
				?>
				<tr>
					<td align="center">
						<?php 
							if($page['PageTemplate']['template_type']=='CUSTOM')
							{
								echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$page['PageTemplate']['id'])); 
							}
						 ?>
					</td>
					<td>
						<center>
							<?php
							if($page['PageTemplate']['show_flag']=='Y'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'PageTemplates', 'action'=>'admin_status/'.$page['PageTemplate']['id'].'/N'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'PageTemplates', 'action'=>'admin_status/'.$page['PageTemplate']['id'].'/Y'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}
							?>
						</center>
					</td>
					<td align="center">
						<?php echo $page['PageTemplate']['template_name']; ?>
					</td>
					<td align="center">
						<?php echo ($page['PageTemplate']['template_for']=='H')?"Home Page":'Inner Pages'; ?>
					</td>					
					<td class="numeric" align="center">
						<?php
						
							if($currentModelPer['delete']=='Y')
							{
								if($page['PageTemplate']['template_type']=='CUSTOM')
								{
										echo $this->Html->link($this->Html->image(IMGPATH1.'delete.png', array('alt'=>'loading..','Title'=>'Delete')), array('controller'=>'PageTemplates', 'action'=>'admin_delete/'.$page['PageTemplate']['id']), array('escape'=>false, 'full_base'=>true,'confirm' => 'Do you really want to delete this record?', 'class'=>''));
									
								}
							}
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
<div id="dialog" title="Basic dialog">
  
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
				var url = '<?php echo $this->Html->url(array('controller'=>'PageTemplates','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>