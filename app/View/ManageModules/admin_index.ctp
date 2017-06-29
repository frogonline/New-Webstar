<?php
	$statusArr = array('Y'=>'ACTIVE','N'=>'INACTIVE');
?>

<div class="row" style="padding:10px 0 10px 0;">
	<div class="col-md-12">
		<?php echo $this->Form->button('<span class="fa fa-trash-o"></span> Delete All', array('type' => 'submit', 'id'=>'deleteAll', 'class'=>"btn red"));?>
		<?php echo $this->Html->link('<i class="fa fa-times"></i> Reset Search', array('controller'=>'ManageModules','action'=>'admin_index'), array('class'=>"btn red filter-cancel", 'style'=>'float:right;', 'escape'=>false)); ?>
	</div>
</div>

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-cogs"></i>List of Sections
		</div>
	</div>
	<div class="portlet-body flip-scroll">
	<?php if(count($data) > 0){ ?>
		<?php echo $this->Form->create('ManageModule', array('action' => 'admin_index', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
			<td class="table-checkbox" width="5%" align="center" style="font-weight:bold">
				<!--<input type="checkbox" class="group-checkable" data-set=".table .checkboxes"/>-->
				<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
			</td>
			<th class="numeric" width="5%" style="font-weight:bold"></th>
			<td width="60%" align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('title', 'Title',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td class="numeric" align="center" style="font-weight:bold">
				Status
			</td>
			
		</tr>
		
		<tr role="row" class="filter">
		<td></td>
		<td></td>
		<td>
			<?php echo $this->Form->input('title',array('type'=>'text', 'class'=>'form-control form-filter input-sm','value'=>(isset($data['Menu']))?$data['Menu']['title']:'')); ?>

		</td>
		
		<td align="center">
			<?php 
				echo $this->Form->input('status', 
					array(
						'options' => $statusArr,
						'empty' =>'Status',	
						'class' => 'form-control',
						'selected' => (isset($data['Menu']))?$data['Menu']['is_active']:''
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
			foreach($data as $section){
				?>
				<tr>
					<td align="center">
						<!--<input type="checkbox" class="checkboxes" value="1"/>-->
						<?php echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$section['Menu']['id'])); ?>
					</td>
					<td align="center">
						<center>
							<?php 
							if($section['Menu']['is_active']=='Y'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'ManageModules', 'action'=>'admin_status/'.$section['Menu']['id'].'/N'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'ManageModules', 'action'=>'admin_status/'.$section['Menu']['id'].'/Y'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}
							?>
						</center>
					</td>
					<td align="center">
						<?php echo ($section['Menu']['controller']?$section['Menu']['controller']:$section['Menu']['title']); ?>
					</td>
					<td align="center" colspan="2">
						<?php 
							echo ($section['Menu']['is_active']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
							echo ($section['Menu']['is_active']=='Y')?'Active':'In-Active';
							echo '</span>';				
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
				var url = '<?php echo $this->Html->url(array('controller'=>'ManageModules','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll+'/1';
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>