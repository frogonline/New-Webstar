<?php
	echo $this->Session->flash('FailedImport');
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
			<i class="fa fa-upload"></i>Import CSV
		</div>
	</div>
	<div class="portlet-body flip-scroll">
	<?php echo $this->Form->create('Product', array('action' => 'admin_importdata', 'id'=>"validate-import", "type"=>"file", 'class'=>"form", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<div class="row">
			<div class="col-md-6">
				<?php 
					echo $this->Form->input('csv',array('type'=>"file", 'data-required'=>1, 'class'=>'form-control')); 
				?>
			</div>
			<div class="col-md-6">
				<?php echo $this->Form->submit('Upload', array('type'=>'submit','class'=>"btn green"));?>
			</div>
		</div>
	<?php echo $this->Form->end(); ?>
	</div>
</div>
<?php
}
?>

<div class="row" style="padding:10px 0 10px 0;">
	<div class="col-md-2">
		<?php 
		if($currentModelPer['delete']=='Y')
		{
			echo $this->Form->button('<span class="fa fa-trash-o"></span> Delete All', array('type' => 'submit', 'id'=>'deleteAll', 'class'=>"btn red"));
			
			
		}
		?>
	</div>
	
	<div class="col-md-2">
		<?php
		echo $this->Form->button('<span class="fa fa-recycle"></span> Restore', array('type' => 'submit', 'id'=>'Restore', 'class'=>"btn blue"));
		?>
	</div>
	
	<div class="col-md-2">
		<?php
		echo $this->Form->button('<span class="fa fa-download"></span> Export To CSV', array('type' => 'submit', 'id'=>'exportCSV', 'class'=>"btn blue"));
		?>
	</div>
	<div class="col-md-6">
		<?php echo $this->Html->link('<i class="fa fa-times"></i> Reset Search', array('controller'=>'Products','action'=>'admin_index'), array('class'=>"btn red filter-cancel", 'style'=>'float:right;', 'escape'=>false)); ?>
	</div>
</div>

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-table"></i>Lists of Products
		</div>
	</div>
	<div class="portlet-body flip-scroll">
		<?php if(count($data) > 0){ ?>
		<?php echo $this->Form->create('Product', array('action' => 'admin_index', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
			<th class="table-checkbox" style="width:2%">
				<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
			</th>
			<th align="center" style="font-weight:bold;width:4%;" class="numeric"></th>
			<td  style="font-weight:bold;width:16%;" class="numeric" >
				<?php echo $this->Paginator->sort('Product.product_name', 'Product Name',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td  style="font-weight:bold;width:3%" class="numeric" >
				<?php echo $this->Paginator->sort('Product.product_sku', 'SKU',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td align="center" style="font-weight:bold;width:11%" class="numeric">
				<?php echo $this->Paginator->sort('Product.product_categoryid', 'Category',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td align="center" style="font-weight:bold;width:4%" class="numeric" >
				<?php echo $this->Paginator->sort('Product.product_price', 'Price',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td align="center" style="font-weight:bold;width:2%" class="numeric">
				Sequence
			</td>
			<td align="center" style="font-weight:bold;width:8%" class="numeric">
				Slug
			</td>
			
			<td align="center" style="font-weight:bold;width:8%" class="numeric">
				Status
			</td>
			<td align="center" style="font-weight:bold;width:3%;" class="numeric">
				Action
			</td>
		</tr>
		<tr role="row" class="filter">
		<td></td>
		<td></td>
		<td>
			<?php echo $this->Form->input('product_name',array('type'=>'text', 'class'=>'form-control form-filter input-sm','value'=>(isset($searchData['Product']))?$searchData['Product']['product_name']:'')); ?>
		</td>
		<td></td>

		<td>
			<?php 
				echo $this->Form->input('product_categoryid', 
					array(
						'options' => $categories,
						'empty' => '--Select--',	
						'class' => 'form-control',
						'selected' => (isset($searchData['Product']))?$searchData['Product']['product_categoryid']:'',
						'escape'=>false
					)); 
			?>
		</td>
		<td>
			
		</td>
		<td>
			
		</td>
		<td>
			
		</td>
		<td>
			<?php 
				echo $this->Form->input('product_status', 
					array(
						'options' => $statusArr,
						'empty' => 'Status',	
						'class' => 'form-control',
						'selected' => (isset($searchData['Product']))?$searchData['Product']['product_status']:''
					)); 
			?>
		</td>
		<td>
			<div class="margin-bottom-5" align="center">
				<?php echo $this->Form->button('<i class="fa fa-search"></i> Search', array('type' => 'submit', 'class'=>"btn btn-sm yellow filter-submit margin-bottom", 'escape'=>false)); ?>
			</div>
		</td>
	</tr>
		</thead>
		<tbody>
		
		<?php
		
			foreach($data as $product){
				?>
				<tr>
					<td>
						<?php echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$product['Product']['id'])); ?>
					</td>
					<td>
						<center>
							<?php 
							if($currentModelPer['edit']=='Y')
					        {
							if($product['Product']['product_status']=='Y'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'Products', 'action'=>'admin_status/'.$product['Product']['id'].'/N'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'Products', 'action'=>'admin_status/'.$product['Product']['id'].'/Y'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}
							}
							?>
						</center>
					</td>
					<td align="center">
						<?php
							echo isset($product['Product']['product_name'])?$product['Product']['product_name']:'';
						?>
					</td>
					<td align="center">
						<?php 
							echo isset($product['Product']['product_sku'])?$product['Product']['product_sku']:'';
						 ?>
					</td>
					<td align="center">
						<?php
							//pr($categoriesArr);
							$pcategory = $product['Product']['product_categoryid'];
							//$prodcategory = $categoriesArr[explode(",",$pcategory)];
							$prodcategorys = explode(',',$pcategory);
							$i=1;
							foreach($prodcategorys as $prodcategory)
							{
								$categoryArr=$categories[$prodcategory];
								//pr($categoryArr);
								 if($i==1)
								 $image=$categoryArr.'<br/>';
								 
								if($i==2)
								 $image.='<span>'.$categoryArr.'</span><br/>';

								if($i==3)
								 $image.='<span>'.$categoryArr.'</span>' ; 
								 
								if($i==4)
								$image.='<span>'.$categoryArr.'</span>' ;
								 
								 if($i==5)
								 $image.='<span>'.$categoryArr.'</span>' ;
								
								$i++; 
							}
							echo $image;
							//echo isset($prodcategory)?$prodcategory:'';
						?>
					</td>
					
					<td align="center">
						
						<span style="float:left">
						<?php echo $this->Form->input('product_price',array('value'=>(isset($product['Product']))?$product['Product']['product_price']:'', 'data-required'=>1, 'class'=>"form-control",'type'=>"text",'onblur'=>"javascript:priceupdate('".$product['Product']['id']."');",'id'=>'price-'.$product['Product']['id'])); ?>
						</span>
						<span style="float:left">
						<div  id="waitingDiv-<?php echo $product['Product']['id']; ?>" style="display:none;"><img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
						</div>
						</span>
							
					</td>
					
					<td align="center">
						
						
						<?php echo $this->Form->input('sequence',array('value'=>(isset($product['Product']))?$product['Product']['sequence']:'', 'data-required'=>1, 'class'=>"form-control",'type'=>"text",'onblur'=>"javascript:sequenceupdate('".$product['Product']['id']."');",'id'=>'sequence-'.$product['Product']['id'])); ?>
						<div  id="sequencediv-<?php echo $product['Product']['id']; ?>" style="display:none;"><img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
						</div>
							
					</td>
					
					
					<td class="numeric" align="center">
						<?php 
							echo isset($product['Product']['product_slug'])?$product['Product']['product_slug']:'';
						?>
					</td>
					
					<td class="numeric" align="center" style="width:11%">
						<?php 
						
							if($product['Product']['isdel']=='0')
							{
								if($product['Product']['product_status']=='Y')
								{
									echo '<span class="label label-success">Active</span>';
								}else if($product['Product']['product_status']=='N')
								{
									echo '<span class="label label-danger">Inactive</span>';
								}
							}
							else if($product['Product']['isdel']=='1')
							{
								echo '<span class="label label-danger">Deleted</span>';
							}
						?>
					</td>
					<td  align="center">
					<div class="col-md-6">
						<?php
						if($currentModelPer['edit']=='Y')
							{
								echo $this->Html->link($this->Html->image(IMGPATH1.'edit.png', array('alt'=>'loading..','Title'=>'Edit')), array('controller'=>'products', 'action'=>'admin_manage/'.$product['Product']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>''));
							}
						?>
						</div>
						<div clsss="col-md-6">
						<?php
						if($product['Product']['isdel']=='0')
						{
						if($currentModelPer['delete']=='Y')
							{
							echo $this->Html->link($this->Html->image(IMGPATH1.'delete.png', array('alt'=>'loading..','Title'=>'Delete')), array('controller'=>'products', 'action'=>'admin_delete/'.$product['Product']['id']."/1"), array('escape'=>false, 'full_base'=>true,'confirm' => 'Do you really want to delete this record?', 'class'=>''));
							
							}
						}else if($product['Product']['isdel']=='1') {
							if($currentModelPer['delete']=='Y')
							{
							
								echo $this->Html->link($this->Html->image(IMGPATH1.'restore.png', array('alt'=>'loading..','Title'=>'Restore')), array('controller'=>'products', 'action'=>'/restore/'.$product['Product']['id']."/0"), array('escape'=>false, 'full_base'=>true,'confirm' => 'Do you really want to restore this record?', 'class'=>''));
							
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
				var url = '<?php echo $this->Html->url(array('controller'=>'Products','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
	
	
	$('#Restore').click(function(e){
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
				var url = '<?php echo $this->Html->url(array('controller'=>'Products','action'=>'admin_restoreAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
	
	
	var form3 = $('#validate-import');
	var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
		
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "", // validate all fields including form hidden input
		rules: {
			'data[Product][csv]': {
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
	
	$('#exportCSV').click(function(e){
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
				var url = '<?php echo $this->Html->url(array('controller'=>'Products','action'=>'admin_exportproducts'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>
<script>

   function priceupdate(id)
   {
		var price=$('#price-'+id).val();
		$.ajax({
					type:'POST',
					url:'<?php echo $this->Html->url(array('controller'=>'Products', 'action'=>'admin_priceupdate', 'full_base'=>true)); ?>',
					data:{price:price,id:id},
					beforeSend:function(){
						$('#waitingDiv-'+id).show();
					},
					complete:function(){
						$('#waitingDiv-'+id).hide();
					},
					success:function(result){
					
					}
					
			});
   }
   
    function sequenceupdate(id)
	{
	
		var sequence=$('#sequence-'+id).val();
		//alert(sequence);
		$.ajax({
					type:'POST',
					url:'<?php echo $this->Html->url(array('controller'=>'Products', 'action'=>'admin_sequenceupdate', 'full_base'=>true)); ?>',
					data:{sequence:sequence,id:id},
					beforeSend:function(){
						$('#sequencediv-'+id).show();
					},
					complete:function(){
						$('#sequencediv-'+id).hide();
					},
					success:function(result){
					//alert(result);
					}
					
			});
	}

</script>