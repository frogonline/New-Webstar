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
	</div>
</div>

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-table"></i>Lists of Posts Comments
		</div>
	</div>
	<div class="portlet-body flip-scroll">
		<?php if(count($data) > 0){ ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
			<th class="table-checkbox">
				<!--<input type="checkbox" class="group-checkable" data-set=".table .checkboxes"/>-->
				<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
			</th>
			<th class="numeric"></th>
			<td align="center" class="numeric" style="font-weight:bold">
				<?php echo $this->Paginator->sort('Post.post_title', 'PostTitle',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td align="center" class="numeric" style="font-weight:bold">
				<?php echo $this->Paginator->sort('Member.name', 'UserName',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td align="center" class="numeric" style="font-weight:bold">
				<?php echo $this->Paginator->sort('PostComment.comment', 'PostComment',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td  align="center" class="numeric" style="font-weight:bold">
				<?php echo $this->Paginator->sort('PostComment.comment_date', 'DateCreated',array('escape' => false, 'class'=>'sorting_both')); ?>
				
			</td>
			<td  align="center" class="numeric" style="font-weight:bold">
				<?php echo $this->Paginator->sort('PostComment.modified_date', 'DateModified',array('escape' => false, 'class'=>'sorting_both')); ?>
				
			</td>
			<td align="center" class="numeric" style="font-weight:bold">
				Status
			</td>
			<td align="center" class="numeric" style="font-weight:bold">
				Action
			</td>
		</tr>
		</thead>
		<tbody>
		
		<?php
			foreach($data as $postComment){
				?>
				<tr>
					<td>
						<?php echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$postComment['PostComment']['id'])); ?>
					</td>
					<td>
						<center>
							<?php 
							if($currentModelPer['edit']=='Y')
					        {
							if($postComment['PostComment']['status']=='Y'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'PostComments', 'action'=>'admin_status/'.$postComment['PostComment']['id'].'/N'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'PostComments', 'action'=>'admin_status/'.$postComment['PostComment']['id'].'/Y'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}
							}
							?>
						</center>
					</td>
					<td>
						<?php echo $postComment['Post']['post_title']; ?>
					</td>
					<td>
						<?php echo $postComment['Member']['name']; ?>
					</td>
					<td>
						<?php echo $postComment['PostComment']['comment']; ?>
					</td>
					<td class="numeric">
						<?php echo strtotime($postComment['PostComment']['comment_date'])?date('d-m-Y',strtotime($postComment['PostComment']['comment_date'])):'-'; ?>
					</td>
					<td class="numeric">
						<?php echo strtotime($postComment['PostComment']['modified_date'])?date('d-m-Y',strtotime($postComment['PostComment']['modified_date'])):'-'; ?>
					</td>
					<td class="numeric">
						<?php 
							echo ($postComment['PostComment']['status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
							echo isset($postComment['PostComment']['status'])?$statusArr[$postComment['PostComment']['status']]:'';
							echo '</span>';				
						?>
					</td>
					<td class="numeric">
						<?php
						    if($currentModelPer['delete']=='Y')
							{
							
							echo $this->Html->link($this->Html->image(IMGPATH1.'delete.png', array('alt'=>'loading..','Title'=>'Delete')), array('controller'=>'PostComments', 'action'=>'admin_delete/'.$postComment['PostComment']['id']), array('escape'=>false, 'full_base'=>true,'confirm' => 'Do you really want to delete this record?', 'class'=>''));
							
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
				var url = '<?php echo $this->Html->url(array('controller'=>'PostComments','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>