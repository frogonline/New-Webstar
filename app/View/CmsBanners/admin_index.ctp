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
			<i class="fa fa-cogs"></i>Banners Lists
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
			<th class="numeric"></th>
			<td width="20%" align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('banner_name', 'Banner Title',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td align="center" style="font-weight:bold">
				Banner Image
			</td>
			
			<td class="numeric" align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('date_created', 'Date Created',array('escape' => false, 'class'=>'sorting_both')); ?>
				</td>
			<td class="numeric" align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('date_modified', 'Date Modified',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td class="numeric" align="center" style="font-weight:bold">
				Status
			</td>
			<td class="numeric" align="center" style="font-weight:bold">
				Action
			</td>
		</tr>
		</thead>
		<tbody>
		
		<?php
		
			foreach($data as $banner){
			?>
				<tr>
					<td align="center">
						<?php echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$banner['CmsBanner']['id'])); ?>
					</td>
					<td>
						<center>
							<?php 
							if($banner['CmsBanner']['banner_status']=='Y'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'banners', 'action'=>'admin_status/'.$banner['CmsBanner']['id'].'/N'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'banners', 'action'=>'admin_status/'.$banner['CmsBanner']['id'].'/Y'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}
							?>
						</center>
					</td>
					<td align="center">
						<?php echo $banner['CmsBanner']['banner_name']; ?>
					</td>
					<td align="center">
					<?php echo $this->Html->image(IMGPATH.'cms_banner_image/thumb/'.$banner['CmsBanner']['banner_image'], array('alt'=>'Image')); ?>
					</td>	
					
					
					<td class="numeric" align="center">
						<?php echo strtotime($banner['CmsBanner']['date_created'])?date('d-m-Y',strtotime($banner['CmsBanner']['date_created'])):'-'; ?>
					</td>
					<td class="numeric" align="center">
						<?php echo strtotime($banner['CmsBanner']['date_modified'])?date('d-m-Y',strtotime($banner['CmsBanner']['date_modified'])):'-'; ?>
					</td>
					<td class="numeric" align="center">
						<?php 
							echo ($banner['CmsBanner']['banner_status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
							echo isset($banner['CmsBanner']['banner_status'])?$statusArr[$banner['CmsBanner']['banner_status']]:''; 
							echo '</span>';				
						?>
					</td>
					<td class="numeric" align="center">
						<?php
							echo $this->Html->link('<i class="fa fa-edit"></i> Edit', array('controller'=>'CmsBanners', 'action'=>'admin_manage/'.$banner['CmsBanner']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>'btn default btn-xs purple'));
						
							echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array('controller'=>'CmsBanners', 'action'=>'/delete/'.$banner['CmsBanner']['id']."/1"), array('escape'=>false, 'full_base'=>true,'confirm' => 'Do you really want to delete this record?', 'class'=>'btn default btn-xs red'));
						?>
					</td>
				</tr>
				<?php
			}
		?>
		</tbody>
		</table>
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
				var url = '<?php echo $this->Html->url(array('controller'=>'CmsBanners','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>

