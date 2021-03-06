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
		<?php echo $this->Html->link('<i class="fa fa-times"></i> Reset Search', array('controller'=>'Newsletters','action'=>'admin_index'), array('class'=>"btn red filter-cancel", 'style'=>'float:right;', 'escape'=>false)); ?>

	</div>
</div>

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-cogs"></i>Lists of Newsletters
		</div>
	</div>
	<div class="portlet-body flip-scroll">
	<?php if(count($data) > 0){ ?>
		<?php echo $this->Form->create('Newsletter', array('action' => 'admin_index', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
			<td class="table-checkbox" width="5%" align="center" style="font-weight:bold">
				<!--<input type="checkbox" class="group-checkable" data-set=".table .checkboxes"/>-->
				<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
			</td>
			<td width="5%" align="center" style="font-weight:bold">
			
			<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('subject', 'Subject',array('escape' => false, 'class'=>'sorting_both')); ?>
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
			<?php echo $this->Form->input('subject',array('type'=>'text', 'class'=>'form-control form-filter input-sm','value'=>(isset($searchData['Newsletter']))?$searchData['Newsletter']['subject']:'')); ?>
		</td>
		
		<td align="center">
			<?php 
				echo $this->Form->input('status', 
					array(
						'options' => $statusArr,
						'empty' =>'Select Status',	
						'class' => 'form-control',
						'selected' => (isset($searchData['Newsletter']))?$searchData['Newsletter']['status']:''
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
				<tr>
					<td align="center">
						<!--<input type="checkbox" class="checkboxes" value="1"/>-->
						<?php echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$user['Newsletter']['id'])); ?>
					</td>
					<td align="center">
						<center>
							<?php 
							if($currentModelPer['edit']=='Y')
					        {
							if($user['Newsletter']['status']=='Y'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'Newsletters', 'action'=>'admin_status/'.$user['Newsletter']['id'].'/N'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'Newsletters', 'action'=>'admin_status/'.$user['Newsletter']['id'].'/Y'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}
							}
							?>
						</center>
					</td>
					<td align="center">
						<?php echo $user['Newsletter']['subject']; ?>
					</td>
					
					<td align="center">
						<?php 
							echo ($user['Newsletter']['status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
							echo isset($user['Newsletter']['status'])?$statusArr[$user['Newsletter']['status']]:'';
							echo '</span>';				
						?>
					</td>
					<td class="numeric" align="center">
					<div class="col-md-4">
						<?php
						if($currentModelPer['edit']=='Y')
						{
							echo $this->Html->link($this->Html->image(IMGPATH1.'edit.png', array('alt'=>'loading..','Title'=>'Edit')), array('controller'=>'Newsletters', 'action'=>'admin_manage/'.$user['Newsletter']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>''));
						}
						?>
						</div>
						<div class="col-md-4">
						<?php
						if($currentModelPer['delete']=='Y')
						{
							echo $this->Html->link($this->Html->image(IMGPATH1.'delete.png', array('alt'=>'loading..','Title'=>'Delete')), array('controller'=>'Newsletters', 'action'=>'admin_delete/'.$user['Newsletter']['id']."/1"), array('escape'=>false, 'full_base'=>true,'confirm' => 'Do you really want to delete this record?', 'class'=>''));
							
						}
						?>
						</div>
						<div class="col-md-4">
						<?php 
						if($currentModelPer['edit']=='Y')
						{
						echo $this->Html->link($this->Html->image(IMGPATH1.'email.png', array('alt'=>'loading..','Title'=>'Send Newsletter')), 'javascript:;', array('escape' => false,'full_base'=>true,'title'=>"Send Newsletter",'class'=>'add','data-target'=>"#stack1", 'data-toggle'=>"modal",'div'=>false,'rel'=>$user['Newsletter']['id'])
							);	
						}	
						?>
						</div>
						<div id="stack1" class="modal fade" tabindex="-1" data-width="400">
											
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
				var url = '<?php echo $this->Html->url(array('controller'=>'Newsletters','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll+'/1';
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
	
	
	$('.add').click(function(e){
		e.preventDefault();
		var box_id = $(this).attr('rel');
	
		$.ajax({
			type:'POST',
			url:'<?php echo $this->Html->url(array('controller'=>'Newsletters','action'=>'admin_boxmanage','full_base'=>true)); ?>',
			data:{box_id:box_id},
			success:function(result){
				//alert()
				$('#stack1').html(result);
			}
		});
	});
	
	
});

function hide_show(fff)
{
var dd=fff;

if(dd=='0')
{
document.getElementById("form-group1").style.display = "block";
}
}

function hide_show1(fff)
{
var dd=fff;

if(dd=='1')
{
document.getElementById("form-group1").style.display = "none";
}
}

</script>

