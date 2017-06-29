<?php
	$statusArr = array('Y'=>'Approve','N'=>'Pending');
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
			<i class="fa fa-table"></i>Lists of Reviews
		</div>
	</div>
	<div class="portlet-body flip-scroll">
	<?php if(count($data) > 0){ ?>
		<?php echo $this->Form->create('ProductReviews', array('action' => 'admin_index', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
			<th class="table-checkbox" width="1%">
				
				<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
			</th>
			
			<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('name', 'Name',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('product_id', 'Product Name',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('email', 'Email',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('review', 'Review',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('rating', 'Rating',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('review_date', 'Review Date',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<!---<td  align="center" style="font-weight:bold">
				<?php //echo $this->Paginator->sort('modified_date', 'Modified Date',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td> --->
			<td class="numeric" align="center" style="font-weight:bold"  >
				Status
			</td>
			<td class="numeric" align="center" style="font-weight:bold"  >
				Action
			</td>
		</tr>
		</thead>
		<tbody>
		<?php
			foreach($data as $review){?>
				<tr>
				<td align="center">
					<?php echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$review['ProductReviews']['id'])); ?>
				</td>
				
				<td align="center">
					<?php echo $review['ProductReviews']['name']; ?>
				</td>
				<td align="center">
					<?php echo $review['Product']['product_name']; ?>
				</td>
				<td align="center">
					<?php echo $review['ProductReviews']['email']; ?>
				</td>
				<td align="center">
					<?php echo $review['ProductReviews']['review']; ?>
				</td>
				<td class="numeric" align="center">
					<?php echo $review['ProductReviews']['rating']; ?>
				</td>
				<td class="numeric" align="center">
						<?php echo strtotime($review['ProductReviews']['review_date'])?date('Y-m-d',strtotime($review['ProductReviews']['review_date'])):'-'; ?>
				</td>
				<!---<td class="numeric" align="center">
						<?php //echo strtotime($review['ProductReviews']['modified_date'])?date('Y-m-d',strtotime($review['ProductReviews']['modified_date'])):'-'; ?>
				</td> --->
				<td class="numeric" align="center">
					<?php 
					echo ($review['ProductReviews']['status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
					echo isset($review['ProductReviews']['status'])?$statusArr[$review['ProductReviews']['status']]:'';
					echo '</span>';				
					?>
				</td>
				<td class="numeric" style="width:280px">
					<div class="col-md-4">
						<?php
					    if($currentModelPer['edit']=='Y')
						{
						
						echo $this->Html->link($this->Html->image(IMGPATH1.'approve.png', array('alt'=>'loading..','Title'=>'Approve')), array('controller'=>'ProductReviews', 'action'=>'admin_status/'.$review['ProductReviews']['id']."/Y"), array('escape'=>false, 'full_base'=>true, 'class'=>'','confirm' => 'Do you really want to Approve this ProductReviews details?'));
						
						
						} 
						?>
						</div>
						<div class="col-md-4">
						<?php
						if($currentModelPer['edit']=='Y')
						{
						
						echo $this->Html->link($this->Html->image(IMGPATH1.'pending.png', array('alt'=>'loading..','Title'=>'Pending')), array('controller'=>'ProductReviews', 'action'=>'admin_status/'.$review['ProductReviews']['id']."/N"), array('escape'=>false, 'full_base'=>true, 'class'=>'','confirm' => 'Do you really want to Pending this ProductReviews details?'));
						}
						?>
						</div>
						<div class="col-md-4">
						<?php
						if($currentModelPer['delete']=='Y')
						{
						
							echo $this->Html->link($this->Html->image(IMGPATH1.'delete.png', array('alt'=>'loading..','Title'=>'Delete')), array('controller'=>'ProductReviews', 'action'=>'admin_delete/'.$review['ProductReviews']['id']."/1"), array('escape'=>false, 'full_base'=>true,'confirm' => 'Do you really want to delete this record?', 'class'=>''));
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
				var url = '<?php echo $this->Html->url(array('controller'=>'ProductReviews','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>