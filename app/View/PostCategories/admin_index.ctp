<?php
	$statusArr = array('Y' => 'Active', 'N' => 'Inactive');
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
		<?php echo $this->Html->link('<i class="fa fa-times"></i> Reset Search', array('controller'=>'PostCategories','action'=>'admin_index'), array('class'=>"btn red filter-cancel", 'style'=>'float:right;', 'escape'=>false));?>
	</div>
</div>

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-table"></i>List of Post Categories
		</div>
	</div>
	<div class="portlet-body flip-scroll">
		<?php if(count($data) > 0){ ?>
		<?php echo $this->Form->create('PostCategory', array('url'=>array('controller'=>'PostCategories','action' => 'admin_index'), 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
			<td  class="table-checkbox" align="center">
				<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
			</td>
			<th  class="numeric"></th>
			<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('category_name', 'Category',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td  class="numeric" align="center" style="font-weight:bold">
				Status
			</td>
			<td  class="numeric" align="center" style="font-weight:bold">
				Action
			</td>
		</tr>
		<tr role="row" class="filter">
		<td></td>
		<td></td>
		<td>
			<?php echo $this->Form->input('category_name',array('type'=>'text','label'=>false,'class'=>'form-control form-filter input-sm','value'=>(isset($searchData['PostCategory']))?$searchData['PostCategory']['category_name']:'')); ?>
		</td>
		<td>
			<?php 
				echo $this->Form->input('status', 
					array(
						'options' => $statusArr,
						'empty' =>'Select Status',	
						'class' => 'form-control',
						'label'=>false,
						'selected' => (isset($searchData['PostCategory']))?$searchData['PostCategory']['status']:''
					)); 
			?>
		</td>
		<td>
			<div align="center" class="margin-bottom-5">
				<?php echo $this->Form->button('<i class="fa fa-search"></i> Search', array('type' => 'submit', 'class'=>"btn btn-sm yellow filter-submit margin-bottom", 'escape'=>false)); ?>
			</div>
		</td>
		</tr>
		</thead>
		<tbody>
		
		<?php
			foreach($data as $postCat){
				?>
				<tr>
					<td align="center">
						<?php echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$postCat['PostCategory']['id'])); ?>
					</td>
					<td>
						<center>
							<?php 
							if($currentModelPer['edit']=='Y')
					        {
							if($postCat['PostCategory']['status']=='Y'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'PostCategories', 'action'=>'admin_status/'.$postCat['PostCategory']['id'].'/N'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'PostCategories', 'action'=>'admin_status/'.$postCat['PostCategory']['id'].'/Y'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}
							}
							?>
						</center>
					</td>
					<td align="center">
						<?php echo $postCat['PostCategory']['category_name']; ?>
					</td>
					<td class="numeric" align="center">
						<?php 
							echo ($postCat['PostCategory']['status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
							echo isset($postCat['PostCategory']['status'])?$statusArr[$postCat['PostCategory']['status']]:'';
							echo '</span>';				
						?>
					</td>
					<td class="numeric" align="center" style="width:160px">
					<div class="col-md-6">
							<?php
						    if($currentModelPer['edit']=='Y')
							{
						
							echo $this->Html->link($this->Html->image(IMGPATH1.'edit.png', array('alt'=>'loading..','Title'=>'Edit')), array('controller'=>'PostCategories', 'action'=>'admin_manage/'.$postCat['PostCategory']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>''));
							
							
							}
							?>
							</div>
							<div class="col-md-6">
							<?php
							if($currentModelPer['delete']=='Y')
							{
							
							echo $this->Html->link($this->Html->image(IMGPATH1.'delete.png', array('alt'=>'loading..','Title'=>'Delete')), array('controller'=>'PostCategories', 'action'=>'admin_delete/'.$postCat['PostCategory']['id']), array('escape'=>false, 'full_base'=>true,'confirm' => 'Do you really want to delete this record?', 'class'=>''));
							
							
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
				var url = '<?php echo $this->Html->url(array('controller'=>'PostCategories','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>