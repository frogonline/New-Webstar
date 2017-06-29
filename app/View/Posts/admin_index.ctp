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
			<i class="fa fa-table"></i>Lists of Posts
		</div>
	</div>
	<div class="portlet-body flip-scroll">
		<?php if(count($data) > 0){ ?>
		<?php echo $this->Form->create('Page', array('url'=>array('controller'=>'Posts','action' => 'admin_index'), 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
			<th class="table-checkbox">
				<!--<input type="checkbox" class="group-checkable" data-set=".table .checkboxes"/>-->
				<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
			</th>
			<th class="numeric"></th>
			<td align="center" class="numeric" style="font-weight:bold">
				<?php echo $this->Paginator->sort('title', 'Title',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td align="center" class="numeric" style="font-weight:bold">
				<?php echo $this->Paginator->sort('PostCategory.category_name', 'Category',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td align="center" class="numeric" style="font-weight:bold">Image</td>
			
			<th class="numeric" align="center">
				<?php echo $this->Paginator->sort('created_date', 'DateCreated',array('escape' => false, 'class'=>'sorting_both')); ?>
				
			</th>
			<th class="numeric" align="center">
				<?php echo $this->Paginator->sort('updated_date', 'DateModified',array('escape' => false, 'class'=>'sorting_both')); ?>
			</th>
			<td align="center" class="numeric" style="font-weight:bold">
				Status
			</td>
			<td align="center" class="numeric" style="font-weight:bold">
				Action
			</td>
		</tr>
		<tr role="row" class="filter">
		<td></td>
		<td></td>
		<td>
			<?php echo $this->Form->input('title',array('type'=>'text', 'class'=>'form-control form-filter input-sm','value'=>(isset($searchData['Page']))?$searchData['Page']['title']:'')); ?>
		</td>
		<td></td>
		<td>
			<?php //echo $this->Form->input('created_date',array('type'=>'text', 'class'=>'form-control form-filter input-sm date-picker','value'=>(isset($searchData['Page']))?$searchData['Page']['created_date']:'')); ?>
		</td>
		<td></td>
		<td>
			<?php echo $this->Form->input('updated_date',array('type'=>'text', 'class'=>'form-control form-filter input-sm date-picker','value'=>(isset($searchData['Page']))?$searchData['Page']['updated_date']:'')); ?>
		</td>
		<td>
			<?php 
				 echo $this->Form->input('is_active', 
					array(
						'options' => $statusArr,
						'empty' => 'Status',	
						'class' => 'form-control',
						'selected' => (isset($searchData['Page']))?$searchData['Page']['is_active']:''
					));  
			?>
		</td>
		<td>
			<div class="margin-bottom-5" align="center">
				<?php echo $this->Form->button('<i class="fa fa-search"></i> Search', array('type' => 'submit', 'class'=>"btn btn-sm yellow filter-submit margin-bottom", 'escape'=>false)); ?>
			</div>
		</td>
	</tr>
		</thead>
		<tbody>
		
		<?php
		//pr($data);
			foreach($data as $post){
				?>
				<tr>
					<td>
						<!--<input type="checkbox" class="checkboxes" value="1"/>-->
						<?php echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$post['Page']['id'])); ?>
					</td>
					<td>
						<center>
							<?php 
							if($currentModelPer['edit']=='Y')
					        {
							if($post['Page']['is_active']=='Y'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'Posts', 'action'=>'admin_status/'.$post['Page']['id'].'/N'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'Posts', 'action'=>'admin_status/'.$post['Page']['id'].'/Y'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}
							}
							?>
						</center>
					</td>
					<td align="center">
						<?php echo $post['Page']['title']; ?>
					</td>
					<td align="center">
						<?php echo $post['PostCategory']['category_name']; ?>
					</td>
					<td align="center">
						<?php echo $this->Html->image(IMGPATH.'cms_image/thumb/'.$post['Page']['cms_image'], array('alt'=>'Image')); ?>
					</td>
					<td class="numeric" align="center">
						<?php echo strtotime($post['Page']['created_date'])?date('d-m-Y',strtotime($post['Page']['created_date'])):'-'; ?>
					</td>
					<td class="numeric" align="center">
						<?php echo strtotime($post['Page']['updated_date'])?date('d-m-Y',strtotime($post['Page']['updated_date'])):'-'; ?>
					</td>
					<td class="numeric" align="center" style="width:110px">
						<?php 
							echo ($post['Page']['is_active']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
							echo isset($post['Page']['is_active'])?$statusArr[$post['Page']['is_active']]:'';
							echo '</span>';				
						?>
					</td>
					<td class="numeric" style="width:175px;" align="center">
					<div class="col-md-6">
					    <?php 
						if($currentModelPer['edit']=='Y')
						{
						
							echo $this->Html->link($this->Html->image(IMGPATH1.'edit.png', array('alt'=>'loading..','Title'=>'Edit')), array('controller'=>'Posts', 'action'=>'admin_manage/'.$post['Page']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>''));
					
						}
						?>
						</div>
						<div class="col-md-6">
						<?php 
						if($currentModelPer['delete']=='Y')
						{
						
								echo $this->Html->link($this->Html->image(IMGPATH1.'delete.png', array('alt'=>'loading..','Title'=>'Delete')), array('controller'=>'Posts', 'action'=>'admin_delete/'.$post['Page']['id']), array('escape'=>false, 'full_base'=>true,'confirm' => 'Do you really want to delete this record?', 'class'=>''));
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
				var url = '<?php echo $this->Html->url(array('controller'=>'Posts','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>