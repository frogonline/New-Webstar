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
		<?php echo $this->Html->link('<i class="fa fa-times"></i> Reset Search', array('controller'=>'News','action'=>'admin_index'), array('class'=>"btn red filter-cancel", 'style'=>'float:right;', 'escape'=>false)); ?>
	</div>
</div>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-cogs"></i>News Lists
		</div>
	</div>
	<div class="portlet-body flip-scroll">
		<?php if(count($data) > 0){ ?>
		<?php echo $this->Form->create('News', array('action' => 'admin_index', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
			<td class="table-checkbox" width="2%" align="center">
				<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
			</td>
			<th class="numeric"></th>
			<td width="20%" align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('news_title', 'News Title',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td align="center" style="font-weight:bold">
				News Image
			</td>
			
			<td class="numeric" align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('date_created', 'Date Created',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td class="numeric" align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('date_modified', 'Date Modified',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td class="numeric" align="center" style="font-weight:bold">
				Status
			</td>
			<td class="numeric" align="center" style="font-weight:bold">
				Action
			</td>
		</tr>
		
		<tr role="row" class="filter">
		<td></td>
		<td></td>
		<td align="center">
			<?php echo $this->Form->input('news_title',array('type'=>'text', 'class'=>'form-control form-filter input-sm','value'=>(isset($searchData['News']))?$searchData['News']['news_title']:'')); ?>
		</td>
		<td>
		</td>
		<td align="center">
			<?php echo $this->Form->input('date_created',array('type'=>'text', 'class'=>'form-control form-filter input-sm date-picker','value'=>(isset($searchData['News']))?$searchData['News']['date_created']:'')); ?>
		</td>
		<td align="center">
			<?php echo $this->Form->input('date_modified',array('type'=>'text', 'class'=>'form-control form-filter input-sm date-picker','value'=>(isset($searchData['News']))?$searchData['News']['date_modified']:'')); ?>
		</td>
		<td align="center">
			<?php 
				echo $this->Form->input('news_status', 
					array(
						'options' => $statusArr,
						'empty' =>'Status',	
						'class' => 'form-control',
						'selected' => (isset($searchData['News']))?$searchData['News']['news_status']:''
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
		
			foreach($data as $news){
			?>
				<tr>
					<td align="center">
						<?php echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$news['News']['id'])); ?>
					</td>
					<td>
						<center>
							<?php 
							if($currentModelPer['edit']=='Y')
					        {
							if($news['News']['news_status']=='Y'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'news', 'action'=>'admin_status/'.$news['News']['id'].'/N'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'news', 'action'=>'admin_status/'.$news['News']['id'].'/Y'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}
							}
							?>
						</center>
					</td>
					<td align="center">
						<?php echo $news['News']['news_title']; ?>
					</td>
					<td align="center">
					<?php echo $this->Html->image(IMGPATH.'news_image/thumb/'.$news['News']['news_image'], array('alt'=>'Image')); ?>
					</td>	
					
					
					<td class="numeric" align="center">
						<?php echo strtotime($news['News']['date_created'])?date('d-m-Y',strtotime($news['News']['date_created'])):'-'; ?>
					</td>
					<td class="numeric" align="center">
						<?php echo strtotime($news['News']['date_modified'])?date('d-m-Y',strtotime($news['News']['date_modified'])):'-'; ?>
					</td>
					<td class="numeric" align="center" style="width:100px;">
						<?php 
							echo ($news['News']['news_status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
							echo isset($news['News']['news_status'])?$statusArr[$news['News']['news_status']]:'';
							echo '</span>';				
						?>
						
					</td>
					<td class="numeric" align="center" style="width:155px;">
					<div class="col-md-6">
						<?php
						    if($currentModelPer['edit']=='Y')
							{
							echo $this->Html->link('<i class="fa fa-edit"></i> Edit', array('controller'=>'News', 'action'=>'admin_manage/'.$news['News']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>'btn default btn-xs purple'));
							}
						?>
						</div>
						<div class="col-md-6">
						<?php
						if($currentModelPer['delete']=='Y')
						{
							echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array('controller'=>'News', 'action'=>'/delete/'.$news['News']['id']."/1"), array('escape'=>false, 'full_base'=>true,'confirm' => 'Do you really want to delete this record?', 'class'=>'btn default btn-xs red'));
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
				var url = '<?php echo $this->Html->url(array('controller'=>'News','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>
