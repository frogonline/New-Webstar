<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$currentModelPer=$this->Session->read('currentModelPer');
	//pr($currentModelPer);
?>
<?php
if($currentModelPer['add']=='Y')
{
?>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-plus-square"></i>Add Sidebar
		</div>
	</div>
	<div class="portlet-body flip-scroll">
	<?php echo $this->Form->create('Sidebar', array('action' => 'admin_index', 'id'=>"validate", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<div class="row">
			<div class="col-md-6">
				<?php 
				echo $this->Form->input('name',array(
					'type'=>"text",'value'=>'','data-required'=>1,'placeholder'=>"Enter Sidebar Name", 'class'=>'form-control'
				)); 
				?>
			</div>
			<div class="col-md-6">
				<?php echo $this->Form->submit('submit', array('type'=>'submit','class'=>"btn blue"));?>
			</div>
		</div>
	<?php echo $this->Form->end(); ?>
	</div>
</div>
<?php
}
?>

<div class="row" style="padding:10px 0 10px 0;">
	<div class="col-md-12">
		<?php 
		if($currentModelPer['delete']=='Y')
		{
		?>
		<?php echo $this->Form->button('<span class="fa fa-trash-o"></span> Delete All', array('type' => 'submit', 'id'=>'deleteAll', 'class'=>"btn red"));?>
		<?php
		}
		?>
		<?php echo $this->Html->link('<i class="fa fa-times"></i> Reset Search', array('controller'=>'Sidebars','action'=>'admin_index'), array('class'=>"btn red filter-cancel", 'style'=>'float:right;', 'escape'=>false)); ?>
	</div>
</div>

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-table"></i>Lists of Sidebars
		</div>
	</div>
	<div class="portlet-body flip-scroll">
	<?php if(count($data) > 0){ ?>
	<?php echo $this->Form->create('Sidebar', array('action' => 'admin_index', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
			<td class="table-checkbox" align="center">
				<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
			</td>
			<td width="20%" align="center" style="font-weight:bold">
				Name
			</td>
			<td align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('contents', 'Sidebar Content',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td class="numeric" align="center" style="font-weight:bold">
				Action
			</td>
		</tr>
		<tr role="row" class="filter">
		<td></td>
		<?php echo $this->Form->input('searchvalue',array("type"=>"hidden","label"=>false,"value"=>'searchvalue')); ?>
		<td>
			<?php echo $this->Form->input('name',array('type'=>'text','label'=>false,'class'=>'form-control form-filter input-sm','value'=>(isset($searchData['Sidebar']))?$searchData['Sidebar']['name']:'')); ?>
		</td>
		<td>
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
		
			foreach($data as $item){
				?>
				<tr>
					<td align="center">
						<?php 
							echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$item['Sidebar']['id'])); 
						?>
					</td>
					<td align="center">
						<?php echo $item['Sidebar']['name']; ?>
					</td>
					<td align="center">
						<?php echo "[Sidebar-".$item['Sidebar']['id']."]"; ?>
					</td>
					<td class="numeric" align="center" style="width:200px">
					<?php 
					if($item['Sidebar']['sidebar_type']=='D'){
					?>
					<div class="col-md-6">
					<?php 
					}else {
					?>
					<div class="col-md-12">
					<?php } ?>
						<?php
						if($currentModelPer['edit']=='Y')
						{
							
							echo $this->Html->link($this->Html->image(IMGPATH1.'manage.png', array('alt'=>'loading..','Title'=>'Manage')), array('controller'=>'Sidebars', 'action'=>'admin_manage/'.$item['Sidebar']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>''));
						}
						?>
						</div>
						<div class="col-md-6">
						<?php
						if($currentModelPer['delete']=='Y')
						{
							if($item['Sidebar']['sidebar_type']=='D'){
							
								
							echo $this->Html->link($this->Html->image(IMGPATH1.'delete.png', array('alt'=>'loading..','Title'=>'Delete')), array('controller'=>'Sidebars', 'action'=>'admin_delete/'.$item['Sidebar']['id']), array('escape'=>false, 'full_base'=>true,'confirm' => 'Do you really want to delete this record?', 'class'=>''));
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
	var form3 = $('#validate');
	var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
		
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "", // validate all fields including form hidden input
		rules: {
			'data[Sidebar][name]': {
				required: true
			}
		},
		errorPlacement: function (error, element) { // render error placement for each input type
			if (element.attr("data-error-container")) { 
				error.appendTo(element.attr("data-error-container"));
			} else {
				error.insertAfter(element); // for other inputs, just perform default behavior
			}
		},

		invalidHandler: function (event, validator) { //display error alert on form submit   
			success3.hide();
			error3.show();
			Metronic.scrollTo(error3, -200);
		},

		highlight: function (element) { // hightlight error inputs
		   $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
		},

		unhighlight: function (element) { // revert the change done by hightlight
			$(element)
				.closest('.form-group').removeClass('has-error'); // set error class to the control group
		},

		success: function (label) {
			label.closest('.form-group').removeClass('has-error'); // set success class to the control group
		}

	});
	
	
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
				var url = '<?php echo $this->Html->url(array('controller'=>'Sidebars','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>