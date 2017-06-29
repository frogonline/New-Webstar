<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$currentModelPer=$this->Session->read('currentModelPer');
	//pr($currentModelPer);
?>


<div class="portlet box blue">  
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-table"></i>Lists of Forms Response
		</div>
	</div>
	<div class="portlet-body flip-scroll">
		<?php if(count($formrecord) > 0){ ?>
		
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
			<tr>
			
				<th class="numeric" style="font-weight:bold">
					
					<center>Date</center>
				
				</th>
				<th class="numeric" style="font-weight:bold">
					
					<center>Title</center>
				</th>
				<th class="numeric" style="font-weight:bold">
					
					<center>Form Content</center>
				</th>
				<th style="font-weight:bold">
					<center>Action</center>
				</th>
			</tr>
		</thead>
		<tbody>
		
		<?php
		foreach($formrecord as $item=>$val){
		?>
		
		<?php foreach($val as $vals) { ?>
			<tr>
				<td align="center">
					<?php echo $vals['FormSaveRecord']['submit_date']; ?>
				</td>
				<td align="center">
					<?php echo $item; ?>
				</td>
				<td>
			
				
					<?php echo $vals['FormSaveRecord']['form_content']; ?>
					<?php if(!empty($vals['FormImage'])){ 
						$i=1;
						echo "</br>";
						echo "<strong>Attachments :</strong>";
						echo "</br>";
					?>
					
					<?php foreach($vals['FormImage'] as $image) { ?>
					
					
					<?php echo $this->Html->link('File'.$i,SITE_URL.'img/uploads/form_image/'.$image['image_name'], array('escape'=>false, 'target'=>'_blank', 'full_base'=>true,'class'=>'col-md-2','style'=>'display: block; text-align: center;width: 30%;'));
					$i++;
					?>
					<?php } } ?>
					
				</td>
				<td class="numeric" style="width:175px;" align="center">
					
				
					<div class="col-md-4">
					<?php 
					if($currentModelPer['delete']=='Y')
					{
					
						echo $this->Html->link($this->Html->image(IMGPATH1.'delete.png', array('alt'=>'loading..','Title'=>'Delete')), array('controller'=>'Responses', 'action'=>'admin_delete/'.$vals['FormSaveRecord']['id']), array('escape'=>false, 'confirm' => 'Do you really want to delete this form?', 'full_base'=>true, 'class'=>''));
					}
					?>
					</div>
				</td>
			</tr>
			<?php
		} }
		?>
		</tbody>
		</table>
		<?php echo $this->element('admin_paginator'); ?>
		<?php echo $this->Form->end(); ?>
		<?php }  else { ?>
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
				var url = '<?php echo $this->Html->url(array('controller'=>'FormTables','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>