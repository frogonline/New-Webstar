<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$style = array('style1'=>'Top Tabs','style2'=>'Bottom Tabs','style3'=>'Left Tabs','style4'=>'Right Tabs');
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
		<?php echo $this->Html->link('<i class="fa fa-times"></i> Reset Search', array('controller'=>'Tabs','action'=>'admin_index'), array('class'=>"btn red filter-cancel", 'style'=>'float:right;', 'escape'=>false)); ?>
	
	</div>
</div>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-cogs"></i>List of  Tabs
		</div>
	</div>
	
	<div class="portlet-body flip-scroll">
	<?php if(count($data) > 0){ ?>
	<?php echo $this->Form->create('Tabs', array('action' => 'admin_index', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
		<td class="table-checkbox" width="1%">
				<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
		</td>
			<th  align="center"></th>
		
		<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('name', 'Tab Name',array('escape' => false, 'class'=>'sorting_both')); ?>
		</td>
		<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('style', 'Style',array('escape' => false, 'class'=>'sorting_both')); ?>
		</td>
		<td  align="center" style="font-weight:bold">
				Short Code
		</td>
		<td  align="center" style="font-weight:bold">
				Status
		</td>
			<td  align="center" style="font-weight:bold">
				Action
			</td>
		</tr>
		
		
		
		
		<tr role="row" class="filter">
		<td></td>
		<td></td>
		<td>
			<?php echo $this->Form->input('name',array('type'=>'text','label'=>false, 'class'=>'form-control form-filter input-sm','value'=>(isset($searchData['Tabs']))?$searchData['Tabs']['name']:'')); ?>
		</td>
		<td>
			<?php 
				echo $this->Form->input('style', 
					array(
						'options' => $stylesArr,
						'empty' => 'Select Tab Style',	
						'class' => 'form-control',
						'label'=>false,
						'selected' => (isset($searchData['Tabs']))?$searchData['Tabs']['style']:''
					)); 
			?>
		</td>
		<td>
			&nbsp;
		</td>
		<td>
			<?php 
				echo $this->Form->input('status', 
					array(
						'options' => $statusArr,
						'empty' => 'Status',	
						'class' => 'form-control',
						'label'=>false,
						'selected' => (isset($searchData['Tabs']))?$searchData['Tabs']['status']:''
					)); 
			?>
		</td>
		<td align="center" >
			<div class="margin-bottom-5">
				<?php echo $this->Form->button('<i class="fa fa-search"></i> Search', array('type' => 'submit', 'class'=>"btn btn-sm yellow filter-submit margin-bottom", 'escape'=>false)); ?>
			</div>
			
		</td>
	</tr>
	
	
		
		
		</thead>
		<tbody>
		
		<?php
			foreach($data as $post){
				?>
				<tr>
				
				     <td>
						<?php echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$post['Tabs']['id'])); ?>
					</td>
					<td>
						<center>
							<?php 
							if($currentModelPer['edit']=='Y')
					        {
							if($post['Tabs']['status']=='Y'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'Tabs', 'action'=>'admin_status/'.$post['Tabs']['id'].'/N'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'Tabs', 'action'=>'admin_status/'.$post['Tabs']['id'].'/Y'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}
							}
							?>
						</center>
					</td>
					<td align="center">
						<?php echo $post['Tabs']['name']; ?>
					</td>
					<td align="center">
						<?php echo $stylesArr[$post['Tabs']['style']]; ?>
					</td>
					<td align="center">
						<?php echo '[Tab-'.$post['Tabs']['id'].']'; ?>
					</td>
					<td align="center">
						<?php 
							echo ($post['Tabs']['status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
							echo isset($post['Tabs']['status'])?$statusArr[$post['Tabs']['status']]:'';
							echo '</span>';				
						?>
					
					</td>
					
					<td align="center">
					<div class="col-md-6">
						<?php
						if($currentModelPer['edit']=='Y')
						{
							
							
							echo $this->Html->link($this->Html->image(IMGPATH1.'edit.png', array('alt'=>'loading..','Title'=>'Edit')), array('controller'=>'Tabs', 'action'=>'admin_manage/'.$post['Tabs']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>''));
						}
						?>
						</div>
						<div class="col-md-6">
						<?php
						if($currentModelPer['delete']=='Y')
						{
							
						echo $this->Html->link($this->Html->image(IMGPATH1.'delete.png', array('alt'=>'loading..','Title'=>'Delete')), array('controller'=>'Tabs', 'action'=>'admin_delete/'.$post['Tabs']['id']."/1"), array('escape'=>false, 'full_base'=>true,'confirm' => 'Do you really want to delete this record?', 'class'=>''));
		
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
				var url = '<?php echo $this->Html->url(array('controller'=>'Tabs','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>