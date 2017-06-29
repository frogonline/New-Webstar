<?php
	$statusArr = array('Y' => 'Active', 'N' => 'Inactive');
	$currentModelPer=$this->Session->read('currentModelPer');
   
?>
<?php
if($currentModelPer['add']=='Y')
{
?>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-plus-square"></i>Add Menu
		</div>
	</div>
	<div class="portlet-body flip-scroll">
	<?php echo $this->Form->create('MenuMaster', array('action' => 'admin_index', 'id'=>"validate", 'class'=>"form", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<div class="row">
			<div class="col-md-6">
				<?php echo $this->Form->input('menu_name',array(
															'type'=>"text", 'data-required'=>1,'placeholder'=>"Enter Menu Name", 'class'=>'form-control'
														)); ?>
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
		<?php //echo $this->Form->button('<span class="fa fa-trash-o"></span> Delete All', array('type' => 'submit', 'id'=>'deleteAll', 'class'=>"btn red"));?>
	</div>
</div>

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-table"></i>List of Menus
		</div>
	</div>
	<div class="portlet-body flip-scroll">
		<?php if(count($data) > 0){ ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
			<th class="table-checkbox">
				<!--<input type="checkbox" class="group-checkable" data-set=".table .checkboxes"/>-->
				<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
			</th>
			<td class="numeric" align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('menu_name', 'Menu Name',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td class="numeric" align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('menu_slug', 'Menu Slug',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td class="numeric" align="center" style="font-weight:bold">
				Short Code
			</td>
			<td class="numeric" align="center" style="font-weight:bold">
				Action
			</td>
		</tr>
		</thead>
		<tbody>
		
		<?php
			foreach($data as $innerdata){
				?>
				<tr>
					<td align="center">
						<!--<input type="checkbox" class="checkboxes" value="1"/>-->
						<?php echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$innerdata['MenuMaster']['id'])); ?>
					</td>
					<td align="center">
						<?php echo $innerdata['MenuMaster']['menu_name']; ?>
					</td>
					<td class="numeric" align="center">
						<?php echo $innerdata['MenuMaster']['menu_slug']; ?>
					</td>
					<td class="numeric" align="center">
						<?php echo '[Menu-'.$innerdata['MenuMaster']['id'].']'; ?>
					</td>
					<td class="numeric" align="center">
					<?php 
					if($innerdata['MenuMaster']['menu_type']=='D')
					{
					?>
					<div class="col-md-4">
					<?php 
					}else {
					?>
					<div class="col-md-7">
					<?php } ?>
						<?php
						if($currentModelPer['edit']=='Y')
						{
							
							echo $this->Html->link($this->Html->image(IMGPATH1.'manage.png', array('alt'=>'loading..','Title'=>'Manage')), array('controller'=>'MenuMasters', 'action'=>'admin_manage/'.$innerdata['MenuMaster']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>''));
						}
						?>
						</div>
						<div class="col-md-4">
						<?php
						if($currentModelPer['edit']=='Y')
						{
							echo $this->Html->link($this->Html->image(IMGPATH1.'edit.png', array('alt'=>'loading..','Title'=>'Edit')), '#responsive', array('class' =>'menu_edit', 'escape' =>false, 'data-id'=>$innerdata['MenuMaster']['id'], 'data-toggle'=>'modal'));
							
							
						}
						?>
						</div>
						<div class="col-md-4">
						<?php
						if($currentModelPer['delete']=='Y')
						{
							if($innerdata['MenuMaster']['menu_type']=='D')
							{
								echo $this->Html->link($this->Html->image(IMGPATH1.'delete.png', array('alt'=>'loading..','Title'=>'Delete')), array('controller'=>'MenuMasters', 'action'=>'admin_delete1/'.$innerdata['MenuMaster']['id']), array('escape'=>false, 'full_base'=>true,'confirm' => 'Do you really want to delete this record?', 'class'=>''));
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
		<?php } else { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="note note-info"> <center>No Record Found</center></div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>

<div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true"></div>

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
			'data[MenuMaster][menu_name]': {
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
	
	
	//Edit Menu Item
	$('.menu_edit').click(function(e){
		e.preventDefault();
		var menuId = $(this).attr('data-id');
		$.ajax({
			type:'POST',
			url:'<?php echo $this->Html->url(array('controller'=>'MenuMasters','action'=>'admin_menuedit','full_base'=>true)); ?>',
			data:{menu_id:menuId},
			success:function(result){
				$('#responsive').html(result);
			}
		});
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
				var url = '<?php echo $this->Html->url(array('controller'=>'MenuMasters','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>