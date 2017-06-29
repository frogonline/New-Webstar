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
		<?php echo $this->Html->link('<i class="fa fa-times"></i> Reset Search', array('controller'=>'ProductCategories','action'=>'admin_index'), array('class'=>"btn red filter-cancel", 'style'=>'float:right;', 'escape'=>false)); ?>
	</div>
</div>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-cogs"></i>Product Category Lists
		</div>
	</div>
	<div class="portlet-body flip-scroll">
		<?php if(count($data) > 0){ ?>
		<?php echo $this->Form->create('ProductCategory', array('action' => 'admin_index', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
			<td class="table-checkbox" align="center">
				<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
			</td>
			<th class="numeric"></th>
			<td class="numeric" align="center" style="font-weight:bold">
			<?php echo $this->Paginator->sort('name', 'Category Name',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td class="numeric" align="center" style="font-weight:bold;width:180px">
			
				Category Description
			</td>
			<td class="numeric" align="center" style="font-weight:bold;width:60px">
			 
				Sequence
			</td>
			<td class="numeric" align="center" style="font-weight:bold;width:180px">
			
				Slug
			</td>
			<td class="numeric" align="center" style="font-weight:bold">
				Image
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
			<?php echo $this->Form->input('name',array('type'=>'text', 'class'=>'form-control form-filter input-sm','value'=>(isset($searchData['ProductCategory']))?$searchData['ProductCategory']['name']:'')); ?>
		</td>
		<td></td>
		<td></td>
		<td></td>
		
		<td align="center">
			<?php 
				echo $this->Form->input('category_status', 
					array(
						'options' => $statusArr,
						'empty' => 'Status',	
						'class' => 'form-control',
						'selected' => (isset($searchData['ProductCategory']))?$searchData['ProductCategory']['category_status']:''
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
	
			foreach($data as $productCategory){
		
			?> 
				<tr>
					<td align="center">
						<?php echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$productCategory['ProductCategory']['id'])); ?>
					</td>
					
					<td>
						<center>
							<?php 
							if($currentModelPer['edit']=='Y')
					        {
							if($productCategory['ProductCategory']['category_status']=='Y'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'ProductCategories', 'action'=>'admin_status/'.$productCategory['ProductCategory']['id'].'/N'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'ProductCategories', 'action'=>'admin_status/'.$productCategory['ProductCategory']['id'].'/Y'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}
							}
							?>
						</center>
					</td>
					
					<td class="numeric" align="center">
						<?php echo isset($productCategory['ProductCategory']['name'])?$productCategory['ProductCategory']['name']:''; ?>
					</td>
					<td class="numeric" align="center">
						<?php echo isset($productCategory['ProductCategory']['category_desc'])?$productCategory['ProductCategory']['category_desc']:''; ?>
					</td>
					<td align="center">
						
						
						<?php echo $this->Form->input('sequence',array('value'=>(isset($productCategory['ProductCategory']))?$productCategory['ProductCategory']['sequence']:'', 'data-required'=>1, 'class'=>"form-control",'type'=>"text",'onblur'=>"javascript:sequenceupdate('".$productCategory['ProductCategory']['id']."');",'id'=>'sequence-'.$productCategory['ProductCategory']['id'])); ?>
						
						<div  id="sequencediv-<?php echo $productCategory['ProductCategory']['id']; ?>" style="display:none;"><img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
						</div>
							
					</td>
					<td class="numeric" align="center">
						<?php echo isset($productCategory['ProductCategory']['categories_slug'])?$productCategory['ProductCategory']['categories_slug']:''; ?>
					</td>
					
					<td class="numeric" align="center">
					<?php echo $this->Html->image(IMGPATH.'category_image/thumb/'.$productCategory['ProductCategory']['category_image'], array('alt'=>'Image')); ?>
					</td>
					
					<td class="numeric" align="center">
						<?php 
							echo ($productCategory['ProductCategory']['category_status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
							echo isset($productCategory['ProductCategory']['category_status'])?$statusArr[$productCategory['ProductCategory']['category_status']]:'';
							echo '</span>';				
						?>
						
					</td>
					
					<td class="numeric" align="center">
							<div class="col-md-5">
							<?php
						    if($currentModelPer['edit']=='Y')
							{
							
							echo $this->Html->link($this->Html->image(IMGPATH1.'edit.png', array('alt'=>'loading..','Title'=>'Edit')), array('controller'=>'ProductCategories', 'action'=>'admin_manage/'.$productCategory['ProductCategory']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>''));
							}
							?>
							</div>
							<div class="col-md-5">
							<?php
							if($currentModelPer['delete']=='Y')
							{
							
							echo $this->Html->link($this->Html->image(IMGPATH1.'delete.png', array('alt'=>'loading..','Title'=>'Delete')), array('controller'=>'ProductCategories', 'action'=>'admin_delete/'.$productCategory['ProductCategory']['id']."/1"), array('escape'=>false, 'full_base'=>true,'confirm' => 'Do you really want to delete this record?', 'class'=>''));
							
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
				var url = '<?php echo $this->Html->url(array('controller'=>'ProductCategories','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>
<script>
  function sequenceupdate(id)
	{
	
		var sequence=$('#sequence-'+id).val();
		//alert(sequence);
		$.ajax({
					type:'POST',
					url:'<?php echo $this->Html->url(array('controller'=>'ProductCategories', 'action'=>'admin_sequenceupdate', 'full_base'=>true)); ?>',
					data:{sequence:sequence,id:id},
					beforeSend:function(){
						$('#sequencediv-'+id).show();
					},
					complete:function(){
						$('#sequencediv-'+id).hide();
					},
					success:function(result){
					//alert(result);
					}
					
			});
	}
</script>
