<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
?>
<div class="row" style="padding:10px 0 10px 0;">
	<div class="col-md-12">
		<?php echo $this->Form->button('<span class="fa fa-trash-o"></span> Delete All', array('type' => 'submit', 'id'=>'deleteAll', 'class'=>"btn red"));?>
		<?php echo $this->Html->link('<i class="fa fa-times"></i> Reset Search', array('controller'=>'banners','action'=>'admin_index'), array('class'=>"btn red filter-cancel", 'style'=>'float:right;', 'escape'=>false)); ?>
	</div>
</div>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-cogs"></i>Banners Lists
		</div>
	</div>
	<div class="portlet-body flip-scroll">
	<?php if(count($data) > 0){ ?>
	<?php echo $this->Form->create('Banner', array('action' => 'admin_index', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
			<td class="table-checkbox" align="center">
				<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
			</td>
			<th class="numeric"></th>
			<td width="20%" align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('banner_name', 'Banner Title',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td align="center" style="font-weight:bold">
				Banner Image
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
		<td>
			<?php echo $this->Form->input('banner_name',array('type'=>'text', 'class'=>'form-control form-filter input-sm','value'=>(isset($searchData['Banner']))?$searchData['Banner']['banner_name']:'')); ?>
		</td>
		<td></td>
		<td>
			<?php echo $this->Form->input('date_created',array('type'=>'text', 'class'=>'form-control form-filter input-sm date-picker','value'=>(isset($searchData['Banner']))?$searchData['Banner']['date_created']:'')); ?>
		</td>
		<td>
			<?php echo $this->Form->input('date_modified',array('type'=>'text', 'class'=>'form-control form-filter input-sm date-picker','value'=>(isset($searchData['Banner']))?$searchData['Banner']['date_modified']:'')); ?>
		</td>
		<td>
			<?php 
				echo $this->Form->input('banner_status', 
					array(
						'options' => $statusArr,
						'empty' => 'Status',	
						'class' => 'form-control',
						'selected' => (isset($searchData['Banner']))?$searchData['Banner']['banner_status']:''
					)); 
			?>
		</td>
		<td>
			<div class="margin-bottom-5">
				<?php echo $this->Form->button('<i class="fa fa-search"></i> Search', array('type' => 'submit', 'class'=>"btn btn-sm yellow filter-submit margin-bottom", 'escape'=>false)); ?>
			</div>
		</td>
	</tr>
		</thead>
		<tbody>
		
		<?php
		
			foreach($data as $banner){
			?>
				<tr>
					<td align="center">
						<?php echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$banner['Banner']['id'])); ?>
					</td>
					<td>
						<center>
							<?php 
							if($banner['Banner']['banner_status']=='Y'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'banners', 'action'=>'admin_status/'.$banner['Banner']['id'].'/N'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'banners', 'action'=>'admin_status/'.$banner['Banner']['id'].'/Y'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}
							?>
						</center>
					</td>
					<td align="center">
						<?php echo $banner['Banner']['banner_name']; ?>
					</td>
					<td align="center">
					<?php echo $this->Html->image(IMGPATH.'banner_image/thumb/'.$banner['Banner']['banner_image'], array('alt'=>'Image')); ?>
					</td>	
					
					
					<td class="numeric" align="center">
						<?php echo strtotime($banner['Banner']['date_created'])?date('d-m-Y',strtotime($banner['Banner']['date_created'])):'-'; ?>
					</td>
					<td class="numeric" align="center">
						<?php echo strtotime($banner['Banner']['date_modified'])?date('d-m-Y',strtotime($banner['Banner']['date_modified'])):'-'; ?>
					</td>
					<td class="numeric" align="center">
						<?php 
							echo ($banner['Banner']['banner_status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
							echo isset($banner['Banner']['banner_status'])?$statusArr[$banner['Banner']['banner_status']]:''; 
							echo '</span>';				
						?>
					</td>
					<td class="numeric" align="center">
					<div class="margin-bottom-5">
						<?php
							echo $this->Html->link('<i class="fa fa-edit"></i> Edit', array('controller'=>'banners', 'action'=>'admin_manage/'.$banner['Banner']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>'btn default btn-xs purple'));
						?>
					</div>
					<div class="margin-bottom-5">
						<?php
							echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array('controller'=>'banners', 'action'=>'/delete/'.$banner['Banner']['id']."/1"), array('escape'=>false, 'full_base'=>true,'confirm' => 'Do you really want to delete this record?', 'class'=>'btn default btn-xs red'));
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
				var url = '<?php echo $this->Html->url(array('controller'=>'Banners','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>

