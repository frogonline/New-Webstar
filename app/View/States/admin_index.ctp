<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$currentModelPer=$this->Session->read('currentModelPer');
	//pr($currentModelPer);
?>
<div class="row" style="padding:10px 0 10px 0;">
	<div class="col-md-12">
		<?php //echo $this->Form->button('<span class="fa fa-trash-o"></span> Delete All', array('type' => 'submit', 'id'=>'deleteAll', 'class'=>"btn red"));?>
		<?php echo $this->Html->link('<i class="fa fa-times"></i> Reset Search', array('controller'=>'States','action'=>'admin_index'), array('class'=>"btn red filter-cancel", 'style'=>'float:right;', 'escape'=>false)); ?>
	
	</div>
</div>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-cogs"></i>Lists of States
		</div>
	</div>
	<div class="portlet-body flip-scroll">
	<?php if(count($data) > 0){ ?>
	<?php echo $this->Form->create('States', array('action' => 'admin_index', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
		<!--<th class="table-checkbox" width="2%">
				<?php //echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
			</th>-->
			<th width="3%"></th>
			<td   align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('CountryID', 'Country',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			
			
			<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('State', 'State',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			
			
			
			
			<td   align="center" style="font-weight:bold">
				Status
			</td>
			<td   align="center" style="font-weight:bold">
				Action
			</td>
		</tr>
		<tr role="row" class="filter">
		<td>
		</td>
		<td>
		</td>
		<td>
			<?php echo $this->Form->input('State',array('type'=>'text','label'=>false,'class'=>'form-control form-filter input-sm','value'=>(isset($searchData['States']))?$searchData['States']['State']:'')); ?>
		</td>
		<td>
			<?php 
				echo $this->Form->input('status', 
					array(
						'options' => $statusArr,
						'empty' => 'Status',	
						'class' => 'form-control',
						'label'=>false,
						'selected' => (isset($searchData['States']))?$searchData['States']['status']:''
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
			
			foreach($data as $States){
				?>
				
				
				<tr>
				
				<!--<td align="center">
						<?php //echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$States['States']['id'])); ?>
					</td>-->
					
					<td align="center">
						<center>
						<?php if($States['States']['CountryID']!=1) { ?>
							<?php 
							if($currentModelPer['edit']=='Y')
					        {
							if($States['States']['status']=='Y'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'States', 'action'=>'admin_status/'.$States['States']['id'].'/N'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'States', 'action'=>'admin_status/'.$States['States']['id'].'/Y'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}
							}
							?>
						<?php } ?>
						</center>
					</td>
					
				
					<td align="center">
						
			
               
				<?php
				echo $emp[$States['States']['CountryID']];
				
				?>
				

					</td>
					
					<td align="center">
						<?php echo $States['States']['State']; ?>
					</td>
					
					
					
					<td align="center">
					
					<?php 
							echo ($States['States']['status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
							echo isset($States['States']['status'])?$statusArr[$States['States']['status']]:'';
							echo '</span>';				
						?>
					
					
						
					</td>
					<td align="center" style="width:200px">
					<?php 
					if($States['States']['CountryID']!=1) { 
					?>
						<div class="col-md-6">
					<?php }else { ?>
						<div class="col-md-12">
					<?php } ?>
				
						<?php
						if($currentModelPer['edit']=='Y')
						{
							
							echo $this->Html->link($this->Html->image(IMGPATH1.'edit.png', array('alt'=>'loading..','Title'=>'Edit')), array('controller'=>'States', 'action'=>'admin_manage/'.$States['States']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>''));
	
						}
						?>
						</div>
						<div class="col-md-6">
						<?php
						if($currentModelPer['delete']=='Y')
						{
							 if($States['States']['CountryID']!=1) { 
						
						
							echo $this->Html->link($this->Html->image(IMGPATH1.'delete.png', array('alt'=>'loading..','Title'=>'Delete')), array('controller'=>'States', 'action'=>'admin_delete/'.$States['States']['id']."/1"), array('escape'=>false, 'full_base'=>true,'confirm' => 'Do you really want to delete this record?', 'class'=>''));
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
				var url = '<?php echo $this->Html->url(array('controller'=>'States','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});

	$('#country_name').autocomplete({
        serviceUrl: <?php echo $this->Html->url(array('controller'=>'Countries', 'action'=>'admin_getListEmp')); ?>',
		
		onSelect: function (suggestions) {
			$('#hid_reqs').val(suggestions.data);
			$('#country_name').val(suggestions.value);
		}
    });
	
	
	 $('#country_name').blur(function(){
		var data = $(this).val();
		 $.ajax({
			type:'POST',
			url:'<?php echo $this->Html->url(array('controller'=>'Countries', 'action'=>'admin_checkDhead')); ?>',
			data:{dhead:data},
			success:function(result){
				  if(result<=0){
					$('#country_name').val("");
					$('#hid_reqs').val("");
				}  
				
			}
		});  
	}); 
});
</script>