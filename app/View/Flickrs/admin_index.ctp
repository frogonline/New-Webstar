<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
?>
<div class="row" style="padding:10px 0 10px 0;">
	
</div>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-cogs"></i>List of  Social Widgets Contents
		</div>
	</div>
	
	<div class="portlet-body flip-scroll">
	<?php if(count($data) > 0){ ?>
	<?php echo $this->Form->create('Flickr', array('action' => 'admin_index', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
		
			<th width="2%" align="center"></th>
		
		<td width="20%" align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('name', 'Image Name',array('escape' => false, 'class'=>'sorting_both')); ?>
		</td>
		<td width="20%" align="center" style="font-weight:bold">
				Shortcode
		</td>
		<td width="11%" align="center" style="font-weight:bold">
				Status
		</td>
		<td width="13%" align="center" style="font-weight:bold">
			Action
		</td>
		</tr>
	
		</thead>
		<tbody>
		
		<?php
			foreach($data as $post){
				?>
				<tr>
				
				     
					<td>
						<center>
							<?php 
							if($post['Flickr']['status']=='Y'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'Flickrs', 'action'=>'admin_status/'.$post['Flickr']['id'].'/N'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'Flickrs', 'action'=>'admin_status/'.$post['Flickr']['id'].'/Y'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}
							?>
						</center>
					</td>
					<td align="center">
						<?php echo $post['Flickr']['name']; ?>
					</td>
					<td align="center">
						<?php echo '[flickrphoto-'.$post['Flickr']['id'].']'; ?>
					</td>
					
					<td align="center">
						<?php 
							echo ($post['Flickr']['status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
							echo isset($post['Flickr']['status'])?$statusArr[$post['Flickr']['status']]:'';
							echo '</span>';				
						?>
					
					</td>
					
					<td align="center">
						<?php
							echo $this->Html->link('<i class="fa fa-edit"></i> Edit', array('controller'=>'Flickrs', 'action'=>'admin_manage/'.$post['Flickr']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>'btn default btn-xs purple'));
							
							echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array('controller'=>'Flickrs', 'action'=>'admin_delete/'.$post['Flickr']['id']."/1"), array('escape'=>false, 'confirm' => 'Do you really want to delete this Flickr?', 'full_base'=>true, 'class'=>'btn default btn-xs red'));
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
				var url = '<?php echo $this->Html->url(array('controller'=>'Flickrs','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>