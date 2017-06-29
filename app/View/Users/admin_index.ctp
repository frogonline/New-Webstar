<?php
	$statusArr = array('CONFIRM'=>'CONFIRM','REJECT'=>'REJECT');
	$currentModelPer=$this->Session->read('currentModelPer');
  	$admintype=$this->Session->read('admintype');

?>

<div class="row" style="padding:10px 0 10px 0;">
	<div class="col-md-12">
		<?php 
		if($currentModelPer['delete']=='Y')
		{
		echo $this->Form->button('<span class="fa fa-trash-o"></span> Delete All', array('type' => 'submit', 'id'=>'deleteAll', 'class'=>"btn red"));
		}
		?>
		<?php echo $this->Html->link('<i class="fa fa-times"></i> Reset Search', array('controller'=>'Users','action'=>'admin_index'), array('class'=>"btn red filter-cancel", 'style'=>'float:right;', 'escape'=>false)); ?>
	</div>
</div>

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-cogs"></i>List of Admin Users
		</div>
	</div>
	<div class="portlet-body flip-scroll">
	<?php if(count($data) > 0){ ?>
		<?php echo $this->Form->create('User', array('action' => 'admin_index', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
			<td class="" width="5%" align="center" style="font-weight:bold">
				<!--<input type="checkbox" class="group-checkable" data-set=".table .checkboxes"/>-->
				<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
			</td>
			<th class="numeric" width="5%" style="font-weight:bold"></th>
			<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('firstname', 'Name',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('username', 'Username',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('email_id', 'Email',array('escape' => false, 'class'=>'sorting_both')); ?>
				
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
			<?php  //echo $this->Form->input('name',array('type'=>'text', 'class'=>'form-control form-filter input-sm','value'=>(isset($searchData['User']))?$searchData['User']['name']:'')); ?>

		</td>
		<td align="center">
			<?php echo $this->Form->input('username',array('type'=>'text', 'class'=>'form-control form-filter input-sm','value'=>(isset($searchData['User']))?$searchData['User']['username']:'')); ?>
		</td>
		<td align="center">
			<?php echo $this->Form->input('email_id',array('type'=>'text', 'class'=>'form-control form-filter input-sm','value'=>(isset($searchData['User']))?$searchData['User']['email_id']:'')); ?>
		</td>
		<td align="center">
			<?php 
				echo $this->Form->input('status', 
					array(
						'options' => $statusArr,
						'empty' =>'Status',	
						'class' => 'form-control',
						'selected' => (isset($searchData['User']))?$searchData['User']['status']:''
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
			foreach($data as $user){
				?>
				<?php if($admintype=='admin') {?>
				<?php if($user['User']['user_type']=='admin'){ ?>
				<tr>
					<td align="center">
						<!--<input type="checkbox" class="checkboxes" value="1"/>-->
						<?php echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$user['User']['user_id'])); ?>
					</td>
					<td align="center">
						<center>
							<?php
							if($currentModelPer['edit']=='Y')
					        {							
							if($user['User']['status']=='CONFIRM'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'Users', 'action'=>'admin_status/'.$user['User']['user_id'].'/REJECT'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'Users', 'action'=>'admin_status/'.$user['User']['user_id'].'/CONFIRM'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}
							}
							?>
						</center>
					</td>
					<td align="center">
						<?php echo $user['User']['firstname']." ".$user['User']['lastname']; ?>
					</td>
					<td align="center">
						<?php echo $user['User']['username']; ?>
					</td>
					<td align="center">
						<?php echo $user['User']['email_id']; ?>
					</td>
					<td align="center">
						<?php 
							echo ($user['User']['status']=='CONFIRM')?'<span class="label label-success">':'<span class="label label-danger">';
							echo isset($user['User']['status'])?$user['User']['status']:'';
							echo '</span>';				
						?>
					</td>
					
					<td class="numeric" align="center">
					
					<div class="col-md-2"></div>
					<div class="col-md-4">
						<?php
						if($currentModelPer['edit']=='Y')
						{
							echo $this->Html->link($this->Html->image(IMGPATH1.'edit.png', array('alt'=>'loading..','Title'=>'Edit')), array('controller'=>'Users', 'action'=>'admin_manage/'.$user['User']['user_id']), array('escape'=>false, 'full_base'=>true, 'class'=>''));
						}
						?>
						</div>
						<div class="col-md-4">
							<?php 
							if($currentModelPer['delete']=='Y')
							{
							echo $this->Html->link($this->Html->image(IMGPATH1.'delete.png', array('alt'=>'loading..','Title'=>'Delete')),"/admin/Users/delete/".$user['User']['user_id']."/1", 
						array('escape' => false,'full_base'=>true,'title'=>"Remove",'class'=>"",'confirm' => 'Do you really want to delete this details?'));
							}
						?>
						</div>
						
					</td>
				
				</tr>
				<?php
				}
				}
				?>
				
				<?php if($admintype=='super') {?>
				<tr>
					<td align="center">
						<!--<input type="checkbox" class="checkboxes" value="1"/>-->
						<?php echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$user['User']['user_id'])); ?>
					</td>
					<td align="center">
						<center>
							<?php
							if($currentModelPer['edit']=='Y')
					        {							
							if($user['User']['status']=='CONFIRM'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'Users', 'action'=>'admin_status/'.$user['User']['user_id'].'/REJECT'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'Users', 'action'=>'admin_status/'.$user['User']['user_id'].'/CONFIRM'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}
							}
							?>
						</center>
					</td>
					<td align="center">
						<?php echo $user['User']['firstname']." ".$user['User']['lastname']; ?>
					</td>
					<td align="center">
						<?php echo $user['User']['username']; ?>
					</td>
					<td align="center">
						<?php echo $user['User']['email_id']; ?>
					</td>
					<td align="center">
						<?php 
							echo ($user['User']['status']=='CONFIRM')?'<span class="label label-success">':'<span class="label label-danger">';
							echo isset($user['User']['status'])?$user['User']['status']:'';
							echo '</span>';				
						?>
					</td>
					
					<td class="numeric" align="center">
					
					<div class="col-md-2"></div>
					<div class="col-md-4">
						<?php
						if($currentModelPer['edit']=='Y')
						{
							echo $this->Html->link($this->Html->image(IMGPATH1.'edit.png', array('alt'=>'loading..','Title'=>'Edit')), array('controller'=>'Users', 'action'=>'admin_manage/'.$user['User']['user_id']), array('escape'=>false, 'full_base'=>true, 'class'=>''));
						}
						?>
						</div>
						<div class="col-md-4">
							<?php 
							if($currentModelPer['delete']=='Y')
							{
							echo $this->Html->link($this->Html->image(IMGPATH1.'delete.png', array('alt'=>'loading..','Title'=>'Delete')),"/admin/Users/delete/".$user['User']['user_id']."/1", 
						array('escape' => false,'full_base'=>true,'title'=>"Remove",'class'=>"",'confirm' => 'Do you really want to delete this details?'));
							}
						?>
						</div>
						
					</td>
				
				</tr>
				<?php
				}
				?>
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
				var url = '<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll+'/1';
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>