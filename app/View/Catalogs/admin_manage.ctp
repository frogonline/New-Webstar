<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$currentModelPer=$this->Session->read('currentModelPer');
	//pr($currentModelPer);
?>
<div class="col-md-12"><h4>Catalog Name: <?php echo $catalogname[$id];  ?></h4></div>
<div class="row">
<div class="col-md-12">
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-plus-square"></i>Add User
		</div>
	</div>
	<div class="portlet-body flip-scroll">
	<?php echo $this->Form->create('Catalog', array('action' => 'admin_manage', 'id'=>"validate", 'class'=>"form", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<div class="row">
			<div class="col-md-6">
				<?php echo $this->Form->input('muser_id',array(
															'type'=>"text",'value'=>'','id' => 'muser_id', 'data-required'=>1,'placeholder'=>"Enter user Name", 'class'=>'form-control'
														)); ?>
														
														
				<?php 
					
					echo $this->Form->input('membar_id', array('type'=>'hidden','id'=>'hid_muser_id','value' =>''));
				?>
				
				
			</div>
			<?php echo $this->Form->input('calalogidvalue',array("type"=>"hidden","label"=>false,"value"=>$id)); ?>
			<div class="col-md-6">
				<?php echo $this->Form->submit('submit', array('type'=>'submit','class'=>"btn blue"));?>
			</div>
		</div>
	<?php echo $this->Form->end(); ?>
	</div>
</div>
</div>
</div>
<div class="row" style="padding:10px 0 10px 0;">
	<div class="col-md-12">
		<?php // echo $this->Form->button('<span class="fa fa-trash-o"></span> Delete All', array('type' => 'submit', 'id'=>'deleteAll', 'class'=>"btn red"));?>
		
	</div>
</div>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-table"></i>List of Catalog Users
		</div>
	</div>
	<div class="portlet-body flip-scroll">
		<?php if(count($data) > 0){ ?>
		<?php echo $this->Form->create('Catalog', array('action' => 'admin_manage', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
			
			<td  align="center" style="font-weight:bold">
			
				User Name
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
						<?php echo $Member[$item['CatalogUser']['membar_id']];?>
					</td>
					<td class="numeric" align="center" style="width:240px">
					
							
							<?php
						
								echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete',array('controller'=>'Catalogs', 'action'=>'admin_deleteuser/'.$item['CatalogUser']['id'].'/'.$id), array('escape' => false,'full_base'=>true,'title'=>"Remove",'class'=>"btn default btn-xs red",'confirm' => 'Do you want to delete this row?'));
							
							?>
							
					</td>
				</tr>
				<?php
			}
		?>
		</tbody>
		</table>
		
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
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i>
					Add Product 
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('Catalog', array('action' => 'admin_manage', 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
				<?php echo $this->Form->input('searchvalue',array("type"=>"hidden","label"=>false,"value"=>'searchvalue')); ?>
				<?php echo $this->Form->input('catalog_id',array("type"=>"hidden","id"=>"catalogid","label"=>false,"value"=>$id)); ?>
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-3 control-label">Product Category </label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('product_category', array(
																'options' =>$categories,
																'empty' => '--Select--',	
																'class' => 'form-control',
																'escape'=>false,
																'id' => 'product_category_id'
															));
									?>  
								</div>
							</div>
							</div>
							
						<?php echo $this->Form->input('pro_id',array("type"=>"hidden","label"=>false,"value"=>'','id'=>'pro_id')); ?>
						<div class="form-group">
							<label class="control-label col-md-3">Product<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('productdar_id',array('value'=>'', 'id'=>"productdar_id", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Product Title", 'type'=>"text")); ?>
							</div>
						</div>
														
					<?php 
						
						echo $this->Form->input('product_id', array('type'=>'hidden','id'=>'hid_pro_id','value' =>''));
					?>
						
						<div class="form-group">
							<label class="control-label col-md-3">Product Price<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('product_price',array('value'=>'', 'id'=>"product_price", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Product Price", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Sequence<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('sequence',array('value'=>'', 'id'=>"sequence", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Sequence", 'type'=>"text")); ?>
							</div>
						</div>
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-4 col-md-6">
							<?php echo $this->Form->button('Submit', array('type' => 'submit', 'name'=>'continue', 'value'=>'s', 'class'=>"btn blue"));?>
						</div>
					</div>
				<?php echo $this->Form->end(); ?>
				<!-- END FORM-->
			</div>
			<!-- END VALIDATION STATES-->
		</div>
	</div>
</div>
<div class="row" style="padding:10px 0 10px 0;">
	<div class="col-md-12">
		<?php //echo $this->Form->button('<span class="fa fa-trash-o"></span> Delete All', array('type' => 'submit', 'id'=>'deleteAll1', 'class'=>"btn red"));?>
	</div>
</div>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-table"></i>List of Product
		</div>
	</div>
	<div class="portlet-body flip-scroll">
		<?php if(count($data) > 0){ ?>
		<?php echo $this->Form->create('Catalog', array('action' => 'admin_manage', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
			
			<td  align="center" style="font-weight:bold">
				
				Product
			</td>
			<td  align="center" style="font-weight:bold">
				
				Product Price
			</td>
			<td  align="center" style="font-weight:bold">
				
				Sequence
			</td>
			<td class="numeric" align="center" style="font-weight:bold">
				Action
			</td>
		</tr>
		</thead>
		<tbody>
		
		<?php
			foreach($data1 as $item){
				?>
				<tr>
					
					<td align="center">
						<?php echo $product[$item['CatalogProduct']['product_id']];?>
					</td>
					<td align="center">
						<?php echo $item['CatalogProduct']['product_price'];?>
					</td>
					<td align="center">
					<?php echo $item['CatalogProduct']['sequence'];?>
					</td>
					<td class="numeric" align="center" style="width:240px">
							
							<div class="col-md-6">
								<a data-toggle="modal" href="#responsive"  rel="<?php echo $item['CatalogProduct']['id']; ?>" class="btn default btn-xs purple edit"><i class="fa fa-edit"></i>Edit</a>
							</div>
							<div class="col-md-6">
							<?php
						
								echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete',array('controller'=>'Catalogs', 'action'=>'admin_deleteproductcat/'.$item['CatalogProduct']['id'].'/'.$id), array('escape' => false,'full_base'=>true,'title'=>"Remove",'class'=>"btn default btn-xs red",'confirm' => 'Do you want to delete this row?'));
							
							?>
							</div>
							
							
							
					</td>
				</tr>
				<?php
			}
		?>
		</tbody>
		</table>
		
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
			'data[Catalog][muser_id]': {
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
	
	var form4 = $('#form_sample_3');
	var error4 = $('.alert-danger', form4);
    var success4 = $('.alert-success', form4);
	form4.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "", // validate all fields including form hidden input
		rules: {
			'data[Catalog][productdar_id]': {
				required: true
			},
			'data[Catalog][product_price]': {
				required: true
			},
			'data[Catalog][sequence]': {
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
			success4.hide();
			error4.show();
			Metronic.scrollTo(error4, -200);
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
	
	$('#muser_id').autocomplete({
        serviceUrl: '<?php echo $this->Html->url(
			array(
				'controller'=>'Members',
				'action'=>'admin_getListMembers'
			)
		); 
		?>',
		onSelect: function (suggestions) {
			$('#hid_muser_id').val(suggestions.data);
			$('#muser_id').val(suggestions.value);
		}
    });
	$('#muser1_id').autocomplete({
        serviceUrl: '<?php echo $this->Html->url(
			array(
				'controller'=>'Members',
				'action'=>'admin_getListMembers'
			)
		); 
		?>',
		onSelect: function (suggestions) {
			$('#hid_muser1_id').val(suggestions.data);
			$('#muser1_id').val(suggestions.value);
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
				var url = '<?php echo $this->Html->url(array('controller'=>'Catalogs','action'=>'admin_userdeleteAll'), array('full_base'=>true)); ?>/'+idAll+'/<?php echo $id ?>';
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
	
	$("#product_category_id").change(function(){
		var value = $(this).val();
		$('#pro_id').val(value);
		
		$('#productdar_id').autocomplete({
		
        serviceUrl: '<?php echo $this->Html->url(
			array(
				'controller'=>'Products',
				'action'=>'admin_getListProduct'
			)
		); 
		?>',
		params: {prod_id:$(this).val()},
		onSelect: function (suggestions) {
			$('#hid_pro_id').val(suggestions.data);
			$('#productdar_id').val(suggestions.value);
		}
    });
		
		
	});
	
	$('#productdar_id').autocomplete({
        serviceUrl: '<?php echo $this->Html->url(
			array(
				'controller'=>'Products',
				'action'=>'admin_getListProduct1'
			)
		); 
		?>',
		onSelect: function (suggestions) {
			$('#hid_pro_id').val(suggestions.data);
			$('#productdar_id').val(suggestions.value);
		}
    });
	
	$('#deleteAll1').click(function(e){
		e.preventDefault();
		var idAll = [];
		//alert(idAll);
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
				var url = '<?php echo $this->Html->url(array('controller'=>'Catalogs','action'=>'admin_catalogproductdeleteAll'), array('full_base'=>true)); ?>/'+idAll+'/<?php echo $id ?>';
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
		
	$('.edit').click(function(e){
		e.preventDefault();
		var catalog_id = $("#catalogid").val();
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
			url:'<?php echo $this->Html->url(array('controller'=>'Catalogs','action'=>'admin_editproduct/','full_base'=>true)); ?>',
			data:{id:id,catalog_id:catalog_id},
			success:function(result){
				//alert()
				$('#responsive').html(result);
			}
		});
	});  
	  
   
});
</script>