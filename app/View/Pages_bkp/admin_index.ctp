<?php
	 $admintype=$this->Session->read('admintype');
	//die;
		
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$currentModelPer=$this->Session->read('currentModelPer');
	//pr($currentModelPer);
?>
<div class="row" style="padding:10px 0 10px 0;">
	<div class="col-md-12">
		<div class="col-md-2">
		<?php 
		if($currentModelPer['delete']=='Y')
		{
		echo $this->Form->button('<span class="fa fa-trash-o"></span> Delete All', array('type' => 'submit', 'id'=>'deleteAll', 'class'=>"btn red"));
		}
		?>
		</div>
		
		<div class="col-md-2">
			<?php
			echo $this->Form->button('<span class="fa fa-recycle"></span> Restore', array('type' => 'submit', 'id'=>'Restore', 'class'=>"btn blue"));
			?>
		</div>
		
		<div class="col-md-8">
		<?php echo $this->Html->link('<i class="fa fa-times"></i> Reset Search', array('controller'=>'Pages','action'=>'admin_index'), array('class'=>"btn red filter-cancel", 'style'=>'float:right;', 'escape'=>false)); ?>
		</div>
	</div>
</div>

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-table"></i>Lists of Pages
		</div>
	</div>
	<div class="portlet-body flip-scroll">
	<?php if(count($data) > 0){ ?>
	<?php echo $this->Form->create('Page', array('action' => 'admin_index', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
			<td class="table-checkbox" align="center">
				<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
			</td>
			<th class="numeric"></th>
			<td width="20%" align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('title', 'Page Title',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('page_url', 'Page URL',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('created_date', 'Date Created',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<!--<td align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('updated_date', 'Date Updated',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>-->
			<td class="numeric" align="center" style="font-weight:bold">
				Save Status
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
			<?php echo $this->Form->input('title',array('type'=>'text','label'=>false,'class'=>'form-control form-filter input-sm','value'=>(isset($searchData['Page']))?$searchData['Page']['title']:'')); ?>
		</td>
		
		<td>
		</td>
		
		
		<td align="center">
		<?php echo $this->Form->input('created_date',array('type'=>'text', 'label'=>false, 'class'=>'form-control form-filter input-sm date-picker','value'=>(isset($searchData['Page']))?$searchData['Page']['created_date']:'')); ?>
		</td>
		<td>
		</td>
		<td>
			<?php 
				echo $this->Form->input('is_active', 
					array(
						'options' => $statusArr,
						'empty' =>'Select Status',	
						'class' => 'form-control',
						'label'=>false,
						'selected' => (isset($searchData['Page']))?$searchData['Page']['is_active']:''
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
		
			foreach($data as $page){
				/*** To Escape Home Row ****/
				if($page['Page']['id']==1){
					continue;
				}
				/*** To Escape Home Row ****/
				?>
				<tr>
					<td align="center">
						<?php 
							echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$page['Page']['id'])); 
						?>
					</td>
					<td>
						<center>
							<?php 
							if($currentModelPer['edit']=='Y')
							{
							if($page['Page']['is_active']=='Y'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'Posts', 'action'=>'admin_status/'.$page['Page']['id'].'/N'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'Posts', 'action'=>'admin_status/'.$page['Page']['id'].'/Y'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}
							}
							?>
						</center>
					</td>
					<td align="center">
						<?php echo $page['Page']['title']; ?>
					</td>
					<td align="center">
						<?php 
						echo $this->Html->link($page['Page']['page_url'], $page['Page']['page_url'], array('target'=>'_blank'));
						
						/* echo $this->Html->link(SITE_URL.$page['Page']['slug'], SITE_URL.$page['Page']['slug'], array('target'=>'_blank')); */
						
						?>
					</td>
					<td align="center">
						<?php echo strtotime($page['Page']['created_date'])?date('d-m-Y',strtotime($page['Page']['created_date'])):'-'; ?>
					</td>
					<!--<td class="numeric" align="center">
						<?php echo strtotime($page['Page']['updated_date'])?date('d-m-Y',strtotime($page['Page']['updated_date'])):'-'; ?>
					</td>-->
					<td class="numeric" align="center">
						<?php 
							
								if($page['Page']['save']==0)
								{
									echo '<span class="label label-success">Save</span>';
								}else if($page['Page']['save']==1)
								{
									echo '<span class="label label-danger">Not save</span>';
								}
						
						?>
					</td>
					<td class="numeric" align="center">
						<?php 
							if($page['Page']['is_del']=='0')
							{
								if($page['Page']['is_active']=='Y')
								{
									echo '<span class="label label-success">Active</span>';
								}else if($page['Page']['is_active']=='N')
								{
									echo '<span class="label label-danger">Inactive</span>';
								}
							}
							else if($page['Page']['is_del']=='1')
							{
								echo '<span class="label label-danger">Deleted</span>';
							}
						?>
					</td>
					<td class="numeric" align="center" >
						<div class="col-md-6">
						<?php
							
							if($currentModelPer['edit']=='Y'){
							if($admintype=='admin')
							{
						
							 echo $this->Html->link($this->Html->image(IMGPATH1.'edit.png', array('alt'=>'loading..','Title'=>'Edit')), array('controller'=>'Pages', 'action'=>'admin_clientmanage/'.$page['Page']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>''));
							}else {
							
							 echo $this->Html->link($this->Html->image(IMGPATH1.'edit.png', array('alt'=>'loading..','Title'=>'Edit')), array('controller'=>'Pages', 'action'=>'admin_manage/'.$page['Page']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>''));
							
							}
							}
						?>
					
					
					
						</div>
						<div class="col-md-6">
							<?php
						if($page['Page']['is_del']=='0')
						{
						if($currentModelPer['delete']=='Y')
							{
								
								echo $this->Html->link($this->Html->image(IMGPATH1.'delete.png', array('alt'=>'loading..','Title'=>'Delete')), array('controller'=>'Pages', 'action'=>'admin_delete/'.$page['Page']['id']."/1"), array('escape'=>false, 'full_base'=>true,'confirm' => 'Do you really want to delete this record?', 'class'=>''));
								
							
							}
						}else if($page['Page']['is_del']=='1') {
							if($currentModelPer['delete']=='Y')
							{
							
							echo $this->Html->link($this->Html->image(IMGPATH1.'restore.png', array('alt'=>'loading..','Title'=>'Restore')), array('controller'=>'Pages', 'action'=>'/restore/'.$page['Page']['id']."/0"), array('escape'=>false, 'full_base'=>true,'confirm' => 'Do you really want to restore this record?', 'class'=>''));
							
							}
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
				var url = '<?php echo $this->Html->url(array('controller'=>'Pages','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
	
	
	$('#Restore').click(function(e){
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
				var url = '<?php echo $this->Html->url(array('controller'=>'Pages','action'=>'admin_restoreAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
	
});
</script>
<script type="text/javascript">
	$(document).ready(function(e){
		$( "#dialog" ).dialog({
      	autoOpen: false,
	    maxWidth:600,
		maxHeight: 500,
		width: 600,
		height: 500,
		modal: true,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
		$('.add_section').click(function(e){
			var data_layout		=	$(this).attr('data-layout');
			var data_id			=	$(this).attr('data-id');
			$.ajax({
				type:"POST",
				url:"<?=SITE_URL?>Pages/add_layout/" + data_id + "/" + data_layout,
				success:function(data)
				{
					$("#dialog").html(data);
					$( "#dialog" ).dialog( "open" );
				}
			});
			
		});
	});
</script>