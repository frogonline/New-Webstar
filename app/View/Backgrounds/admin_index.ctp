<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$currentModelPer=$this->Session->read('currentModelPer');
	$bgtype = array('P'=>'Pattern', 'I'=>'Image');
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
		<?php echo $this->Html->link('<i class="fa fa-times"></i> Reset Search', array('controller'=>'Backgrounds','action'=>'admin_index'), array('class'=>"btn red filter-cancel", 'style'=>'float:right;', 'escape'=>false)); ?>
		
	</div>
</div>

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-table"></i>Lists of Themes Background
		</div>
	</div>
	<div class="portlet-body flip-scroll">
	<?php if(count($data) > 0){ ?>
	<?php echo $this->Form->create('ThemeBackground', array('url'=>array('controller'=>'Backgrounds','action' => 'admin_index'), 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
			<td class="table-checkbox" align="center">
				<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
			</td>
			<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('bgfilename', 'Background Image',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('bgtype', 'Background Type',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td class="numeric" align="center" style="font-weight:bold">
				Action
			</td>
		</tr>
		<tr role="row" class="filter">
		<td>
		</td>
		<td>
		</td>
		<td>
			<?php 
				echo $this->Form->input('bgtype', 
					array(
						'options' => $bgtype,
						'empty' => 'Select Type',	
						'class' => 'form-control',
						'label'=>false,
						'selected' => (isset($searchData['ThemeBackground']))?$searchData['ThemeBackground']['bgtype']:''
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
				if($page['ThemeBackground']['id']==1){
					continue;
				}
				/*** To Escape Home Row ****/
				?>
				<tr>
					<td align="center">
						<?php 
							echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$page['ThemeBackground']['id'])); 
						?>
					</td>
					<!---<td>
						<center>
							<?php 
							/*if($page['Page']['is_active']=='Y'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'Posts', 'action'=>'admin_status/'.$page['Page']['id'].'/N'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'Posts', 'action'=>'admin_status/'.$page['Page']['id'].'/Y'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}*/
							?>
						</center>
					</td>  --->
					<td align="center">
						<?php echo $this->Html->image(IMGPATH.'bgfilename/'.$page['ThemeBackground']['bgfilename'], array('alt'=>'Image','height'=>40, 'width'=>40)); ?>
					</td>
					
					<td align="center">
					    <?php if($page['ThemeBackground']['bgtype']=='P')
						{
							 echo "Pattern";	  
						}
                       else if($page['ThemeBackground']['bgtype']=='I')
					   {
						   echo "Image";
					   }
						?>
						
					</td>
					
					<td class="numeric" align="center" style="width:200px">
					
						<?php
						if($currentModelPer['edit']=='Y')
						{
							
							
							echo $this->Html->link($this->Html->image(IMGPATH1.'edit.png', array('alt'=>'loading..','Title'=>'Edit')), array('controller'=>'Backgrounds', 'action'=>'admin_manage/'.$page['ThemeBackground']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>''));
	
						}
						?>
					
						
						<?php
						if($currentModelPer['delete']=='Y')
						{
							
							echo $this->Html->link($this->Html->image(IMGPATH1.'delete.png', array('alt'=>'loading..','Title'=>'Delete')), array('controller'=>'Backgrounds', 'action'=>'admin_delete/'.$page['ThemeBackground']['id']), array('escape'=>false, 'full_base'=>true,'confirm' => 'Do you really want to delete this record?', 'class'=>'','style'=>'margin-left:20px;'));
						}
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