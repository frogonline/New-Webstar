<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$currentModelPer=$this->Session->read('currentModelPer');
	//pr($currentModelPer);
?>
<?php
if($currentModelPer['add']=='Y')
{
?>
<?php 
if($total<4)
{
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?> Price Plan
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('PricePlan', array('url'=>array('controller'=>'PricingTables','action' => 'admin_index/'), 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-3">Plan Name<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('plan_name',array('id'=>"plan_name", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Plan Name", 'type'=>"text")); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Plan Price<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('plan_price',array('id'=>"plan_price", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Plan Price", 'type'=>"text")); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Plan Description<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('plan_description',array('id'=>"plan_description", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Plan Description", 'type'=>"textarea")); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Link<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('buy_link',array('id'=>"buy_link", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Link", 'type'=>"text")); ?>
							</div>
						</div>
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-4 col-md-8">
							<?php echo $this->Form->button('Save', array('type' => 'submit', 'name'=>'continue', 'value'=>'s', 'class'=>"btn blue"));?>
						</div>
					</div>
				<?php echo $this->Form->end(); ?>
				<!-- END FORM-->
			</div>
			<!-- END VALIDATION STATES-->
		</div>
	</div>
</div>
<?php
}
?>
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
		<?php echo $this->Html->link('<i class="fa fa-times"></i> Reset Search', array('controller'=>'PricingTables','action'=>'admin_index'), array('class'=>"btn red filter-cancel", 'style'=>'float:right;', 'escape'=>false)); ?>
	</div>
</div>

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-table"></i>List of Price Plan
		</div>
	</div>
	<div class="portlet-body flip-scroll">
		<?php if(count($data) > 0){ ?>
		<?php echo $this->Form->create('PricePlan', array('url'=>array('controller'=>'PricingTables','action' => 'admin_index'),'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
			<td class="table-checkbox" width="5%" align="center">
				<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
			</td>
			<td class="numeric" width="5%" align="center" ></td>
			<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('plan_name', 'Plan Name',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('plan_price', 'Price',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('plan_description', 'Description',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td  align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('buy_link', 'Link',array('escape' => false, 'class'=>'sorting_both')); ?>
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
		<?php echo $this->Form->input('searchvalue',array("type"=>"hidden","label"=>false,"value"=>'searchvalue')); ?>
		<td>
			<?php echo $this->Form->input('plan_name',array('type'=>'text','label'=>false,'class'=>'form-control form-filter input-sm','value'=>(isset($searchData['PricePlan']))?$searchData['PricePlan']['plan_name']:'')); ?>
		</td>
		<td>
			<?php echo $this->Form->input('plan_price',array('type'=>'text','label'=>false,'class'=>'form-control form-filter input-sm','value'=>(isset($searchData['PricePlan']))?$searchData['PricePlan']['plan_price']:'')); ?>
		</td>
		<td></td>
		<td></td>
		<td>
			<?php 
				echo $this->Form->input('status', 
					array(
						'options' => $statusArr,
						'empty' => 'Status',	
						'class' => 'form-control',
						'label'=>false,
						'selected' => (isset($searchData['PricePlan']))?$searchData['PricePlan']['status']:''
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
			foreach($data as $item){
				?>
				<tr>
					<td align="center">
						<?php echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$item['PricePlan']['id'])); ?>
					</td>
					<td align="center">
						<center>
							<?php 
							if($currentModelPer['edit']=='Y')
					        {
							if($item['PricePlan']['status']=='Y'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'PricingTables', 'action'=>'admin_status/'.$item['PricePlan']['id'].'/N'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'PricingTables', 'action'=>'admin_status/'.$item['PricePlan']['id'].'/Y'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}
							}
							?>
						</center>
					</td>
					<td align="center">
						<?php echo $item['PricePlan']['plan_name']; ?>
					</td>
					<td align="center">
						<?php echo $item['PricePlan']['plan_price']; ?>
					</td>
					<td align="center">
						<?php echo $item['PricePlan']['plan_description']; ?>
					</td>
					<td align="center">
						<?php echo $item['PricePlan']['buy_link']; ?>
					</td>
					<td align="center"  style="width:94px">
						<?php 
							echo ($item['PricePlan']['status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
							echo isset($item['PricePlan']['status'])?$statusArr[$item['PricePlan']['status']]:'';
							echo '</span>';				
						?>
					</td>
					
					<td  style="width:310px">
							<?php
							if($currentModelPer['edit']=='Y')
							{
							?>
							<div class="col-md-3">
							<a data-toggle="modal" href="#responsive" rel="<?php echo $item['PricePlan']['id']; ?>" class="btn default btn-xs purple edit"><i class="fa fa-edit"></i>Edit</a>
							</div>
							<?php
							}
							?>
							<?php
							if($currentModelPer['edit']=='Y')
							{
							?>
							<div class="col-md-6">
							<?php
							echo $this->Html->link('<i class="fa fa-edit"></i> Manage Feature', array('controller'=>'PricingTables', 'action'=>'admin_manage/'.$item['PricePlan']['id']), array('escape'=>false, 'class'=>'btn default btn-xs purple'));
							?>
							<!--<a data-toggle="modal" href="#responsive1" rel="<?php echo $item['PricePlan']['id']; ?>" class="btn default btn-xs purple edit1"><i class="fa fa-edit"></i>Manage Feature</a>-->
							</div>
							<?php
							}
							?>
							<div class="col-md-3">
							<?php
							if($currentModelPer['delete']=='Y')
							{
								echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete',"/admin/PricingTables/delete/".$item['PricePlan']['id'], 
								array('escape' => false,'full_base'=>true,'title'=>"Remove",'class'=>"btn default btn-xs red",'confirm' => 'Do you really want to delete this Price Plan details?'));
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
<div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true"></div>
<div id="responsive1" class="modal fade" tabindex="-1" aria-hidden="true"></div>

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
				var url = '<?php echo $this->Html->url(array('controller'=>'PricingTables','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll+'/1';
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
	
	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "", // validate all fields including form hidden input
		rules: {
			'data[PricePlan][plan_name]': {
				required: true
			},
			'data[PricePlan][plan_price]': {
				required: true
			},
			'data[PricePlan][plan_description]': {
				required: true
			},
			'data[PricePlan][buy_link]': {
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
	
	$('.edit').click(function(e){
		e.preventDefault();
		if($(this).attr('rel'))
		{
			var id = $(this).attr('rel');
		}
		else
		{
			var id = '';
		}
		$.ajax({
			type:'POST',
			url:'<?php echo $this->Html->url(array('controller'=>'PricingTables','action'=>'admin_edit/','full_base'=>true)); ?>',
			data:{id:id,},
			success:function(result){
				//alert()
				$('#responsive').html(result);
			}
		});
	});	
	
	$('.edit1').click(function(e){
		e.preventDefault();
		if($(this).attr('rel'))
		{
			var id = $(this).attr('rel');
		}
		else
		{
			var id = '';
		}
		$.ajax({
			type:'POST',
			url:'<?php echo $this->Html->url(array('controller'=>'PricingTables','action'=>'admin_managefeature/','full_base'=>true)); ?>',
			data:{id:id,},
			success:function(result){
				//alert()
				$('#responsive1').html(result);
			}
		});
	});	
	
});
</script>