<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
?>
<div class="row" style="padding:10px 0 10px 0;">
	<div class="col-md-12">
		<?php echo $this->Form->button('<span class="fa fa-trash-o"></span> Delete All', array('type' => 'submit', 'id'=>'deleteAll', 'class'=>"btn red"));?>
	</div>
</div>

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-table"></i>List of CMS Gallery
		</div>
	</div>
	<div class="portlet-body flip-scroll">
	<?php if(count($data) > 0){ ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
			<td class="table-checkbox" align="center">
				<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
			</td>
			<td width="20%" align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('gallery_name', 'Gallery Title',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('gallery_slug', 'Gallery Slug',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td class="numeric" align="center" style="font-weight:bold">
				ShortCode
			</td>
			<td class="numeric" align="center" style="font-weight:bold">
				Action
			</td>
		</tr>
		</thead>
		<tbody>
		
		<?php
		
			foreach($data as $item){
				?>
				<tr>
					<td align="center">
						<?php 
							echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$item['CmsGallery']['id'])); 
						?>
					</td>
					<td align="center">
						<?php echo $item['CmsGallery']['gallery_name']; ?>
					</td>
					<td align="center">
						<?php echo $item['CmsGallery']['gallery_slug']; ?>
					</td>
					<td align="center">
						<?php echo '[Banner-'.$item['CmsGallery']['id'].']'; ?>
					</td>
					<td class="numeric" align="center">
						<?php
							echo $this->Html->link('<i class="fa fa-edit"></i> Edit', array('controller'=>'CmsGalleries', 'action'=>'admin_manage/'.$item['CmsGallery']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>'btn default btn-xs purple'));
							
							echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array('controller'=>'Pages', 'action'=>'admin_delete/'.$item['CmsGallery']['id']), array('escape'=>false, 'confirm' => 'Do you really want to delete this Post?', 'full_base'=>true, 'class'=>'btn default btn-xs red'));
						?>
					</td>
				</tr>
				<?php
			}
		?>
		</tbody>
		</table>
		<?php echo $this->element('admin_paginator'); ?>
		<?php //echo $this->Form->end(); ?>
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