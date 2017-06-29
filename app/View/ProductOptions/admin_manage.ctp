<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
?>
<style>
.error-message {
color:#CF0000;
}
</style>
<div class="row">
				<div class="col-md-12">
					
					<div class="portlet">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-shopping-cart"></i><?php echo isset($data['ProductOption'])?$data['ProductOption']['options_name']:'';?>
								</div>
							</div>
							<div class="portlet-body">
								<div class="tabbable">
								<ul class="nav nav-tabs">
										<li class="active">
											<a href="#tab_images" data-toggle="tab">
											Options </a>
										</li>
									</ul>
									<div class="tab-content no-space">
										<div class="tab-pane active" id="tab_images"><br />
									<?php echo $this->Form->create('ProductOption', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
									
									<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
									<div class="tab-content no-space">
										<div class="form-body">
										<div class="alert alert-danger display-hide">
											<button class="close" data-close="alert"></button>
											You have some form errors. Please check below.
										</div>
										<table class="table table-bordered table-hover table1">
											<tr>
												<td class="col-md-2">Option Name<font color="red"> * </font></td>
												<td>
												<?php echo $this->Form->input('options_name',array('value'=>(isset($data['ProductOption']))?$data['ProductOption']['options_name']:'', 'id'=>"options_name", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Product Option Name", 'type'=>"text")); ?>
												</td>
											</tr>
											
											<tr>
												<td class="col-md-2">Sort Order<font color="red">* </font></td>
												<td>
												<?php echo $this->Form->input('sort_order',array('value'=>(isset($data['ProductOption']))?$data['ProductOption']['sort_order']:'', 'id'=>"sort_order", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Product Option Name", 'type'=>"text")); ?>
												</td>
											</tr>
										</table>
										<input type="hidden" name="Type" id="Type" value="1" />
										<br />
											<table class="table table-bordered table-hover table_option option_div1">
											<thead>
											<tr role="row" class="heading">
												<th width="25%">
													Option Value Name
												</th>
												
												<th width="33%">
													 Sort Order
												</th>
												
												<th width="10%">
												</th>
											</tr>
											</thead>
											<tbody id="itemContainer">
											<div id ="add_related_prod"></div>
											<tr>
												<td colspan="2"></td>
												<td>
													<button type="button" class="btn blue" id="addRow"><i class="fa fa-plus"></i> Add Option Value</button>
												</td>
											</tr>
											<div id="option_div">
											<?php if(!empty($data['OptionValue'])){ $i=1; ?>
											<?php foreach($data['OptionValue'] as $item){ ?>
											<tr class="option_div_name">
											<?php echo $this->Form->input('id',array('type' => 'hidden','name'=>'data[OptionValue][id][]', 'value'=>(isset($item['id']))?$item['id']:'') ); ?>
											<?php echo $this->Form->input('itemnu', array('type' => 'hidden', 'class' => '', 'value' => $i, 'name'=>'data[OptionValue][itemnu][]')); ?>
												<td>
												<?php echo $this->Form->input('option_value_name',array('type' => 'text','name'=>'data[OptionValue][option_value_name][]', 'class' => 'form-control', 'data-required'=>1, 'placeholder' => 'Option Value items', 'value'=>(isset($item['option_value_name']))?$item['option_value_name']:'') ); ?>
												</td>
												
												<td>
												<?php echo $this->Form->input('option_sort_order',array('type' => 'text','name'=>'data[OptionValue][option_sort_order][]', 'class' => 'form-control','data-required'=>1, 'placeholder' => 'Option Value Order', 'value'=>(isset($item['option_sort_order']))?$item['option_sort_order']:0) ); ?>
												</td>
												
												<td>
												<span style="color:red; font-size:20px; margin-left: 39px; cursor:pointer !important;">
												<?php echo $this->Html->link('<i class="fa fa-trash-o"></i> Remove',array('controller'=>'ProductOptions','action'=>'admin_productoption_remove/'.$item['id']), array('class'=>'btn default btn-sm delete_option','escape'=>false,'confirm' => 'Are you Sure?')); ?>
												</span>
												</td>
											</tr>
											<?php $i++; } ?>
											<?php } ?>
											</div>
											</tbody>
											</table>
											
											<div class="form-actions fluid" style="float: right; width: 18.2%;">
											
												<div class="col-md-offset-2 col-md-6">
													
													<button type="submit" class="btn blue"><?php echo (isset($id))?'<i class="fa fa-edit"></i> Edit':'<i class="fa fa-plus"></i> Add'?></button>
													
												</div>
												<div>
												<?php echo $this->Form->button('Save', array('type' => 'submit', 'name'=>'continue', 'div'=>false, 'value'=>'s', 'class'=>"btn blue"));?>
												
												</div>
											</div>
											
											
										</div>
									</div>
									<?php echo $this->Form->end(); ?>
								</div>
							</div>
						</div>
					
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>


<script type="text/javascript">
$(function(){
	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
	
	form3.on('submit', function() {
		for(var instanceName in CKEDITOR.instances) {
			CKEDITOR.instances[instanceName].updateElement();
		}
	});
	
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "", // validate all fields including form hidden input
		rules: {
			'data[ProductOption][options_name]': {
				required: true
			},
			'data[ProductOption][sort_order]': {
				required: true
			},
			'data[OptionValue][option_value_name][]': {
				required: true
			},
			'data[OptionValue][option_sort_order][]': {
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
});
</script>
<script type="text/javascript">
$("#addRow").click(function(e){
		e.preventDefault();
		var c = 1;
		$('#option_div').find('.option_div_name').each(function(){
			c++; 
		});
		//alert(c);
		$.ajax({
			type : 'POST',
			url : '<?php echo $this->Html->url(
					array(
						'controller'=>'ProductOptions',
						'action'=>'admin_addrows'
					)
				); ?>',
			data : {divNo:c},
			success : function(result){
				//alert(result);
				$('table.option_div1>tbody').append(result);
			}
		});
	});

</script>