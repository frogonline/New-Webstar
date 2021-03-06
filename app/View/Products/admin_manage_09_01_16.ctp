<?php
	$taxclass = array('1'=>'None', '2'=>'Taxable Goods');
	$stock = array('TRUE'=>'In Stock', 'FALSE'=>'Out of Stock');
	$status = array('Y'=>'Active','N'=>'Inactive');
?>
<div class="alert alert-success" id="flashMessage1" style="display:none">Image Delete Successfully</div>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-edit"></i><?php echo (isset($id))?'Edit':'Add' ?> Product
		</div>
	</div>
	<div class="portlet-body form">
		<div class="tabbable tabbable-custom boxless tabbable-reversed" style="margin-bottom:0px;">
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#tab_0" data-toggle="tab">
					General Information </a>
				</li>
				<li>
					<a href="#tab_1" data-toggle="tab">
					Price and Stock </a>
				</li>
				<li>
					<a href="#tab_2" data-toggle="tab">
					Descriptions and Meta Tags </a>
				</li>
				<li>
					<a href="#tab_3" data-toggle="tab">
					Images </a>
				</li>
				<li>
					<a href="#tab_4" data-toggle="tab">
					Options </a>
				</li>
				<li>
					<a href="#tab_5" data-toggle="tab">
					Shipping </a>
				</li>
			</ul>
			<?php echo $this->Form->create('Product', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
			<div class="tab-content">
				<?php echo $this->Form->input('id',array("type"=>"hidden","id"=>"idhed","label"=>false,"value"=> $id)); ?>
				<div class="tab-pane active" id="tab_0" style="margin-left:-12%;">
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-3">Product Name <span class="required">
							* </span>
							</label>
							<div class="col-md-9">
								<?php echo $this->Form->input('product_name',array('value'=>(isset($data['Product']))?$data['Product']['product_name']:'', 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Product Name", 'type'=>"text")); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Product SKU 
							</label>
							<div class="col-md-9">
								<?php echo $this->Form->input('product_sku',array('value'=>(isset($data['Product']))?$data['Product']['product_sku']:'', 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Product SKU", 'type'=>"text")); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Product Weight 
							</label>
							<div class="col-md-9">
								<?php echo $this->Form->input('product_weight',array('value'=>(isset($data['Product']))?$data['Product']['product_weight']:'', 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Product Weight", 'type'=>"text")); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Product Category <span class="required">
							* </span>
							</label>
							<div class="col-md-9">
								<div class="form-control" style="height:auto;">
								<?php 
									if(!empty($data['Product'])){
										echo $cat = $this->ProductCategories->category($data['Product']['product_categoryid']); 
									} else {
										echo $cat = $this->ProductCategories->category(); 
										//pr($cat);
									}
								?>
								<div style="clear:both"></div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Tax Class 
							</label>
							<div class="col-md-4">
								<?php 
									echo $this->Form->input('product_taxclass', array(
																'options' => $taxclass,	
																'class' => 'form-control',
																'selected'=> (isset($data['Product']))?$data['Product']['product_taxclass']:''
															));
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">On Sale </label>
							<div class="col-md-4">
								<?php 
								if(isset($data['Product'])){
									echo $this->Form->checkbox('onsale_flag', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>'TRUE', 'checked'=>($data['Product']['onsale_flag']=='TRUE')?true:false ));
								} else {
									echo $this->Form->checkbox('onsale_flag', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>'TRUE'));
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Featured </label>
							<div class="col-md-4">
								<?php 
								if(isset($data['Product'])){
									echo $this->Form->checkbox('featured_flag', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>'TRUE', 'checked'=>($data['Product']['featured_flag']=='TRUE')?true:false ));
								} else {
									echo $this->Form->checkbox('featured_flag', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>'TRUE'));
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">New Collection </label>
							<div class="col-md-4">
								<?php 
								if(isset($data['Product'])){
									echo $this->Form->checkbox('newcollection_flag', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>'TRUE', 'checked'=>($data['Product']['newcollection_flag']=='TRUE')?true:false ));
								} else {
									echo $this->Form->checkbox('newcollection_flag', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>'TRUE'));
								}
								?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Cross Sell </label>
							<div class="col-md-4">
								<input type="hidden" class="form-control" id="tags" value="" name="select2tags">
								<?php 
									echo $this->Form->input('crosssellid', array('class' => 'form-control', 'id'=>"crsProductlist",'label' => false, 'value'=>$prdAssignIDString)); 
									echo $this->Form->input('set_crosssellid', array('type'=>'hidden', 'value'=>$prdAssignIDString)); 
								?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Status <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
									echo $this->Form->input('product_status', array(
																'options' => $status,
																'empty' => 'Select Status',
																'class' => 'form-control',
																'selected'=> (isset($data['Product']))?$data['Product']['product_status']:''
															));
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab_1" style="margin-left:-12%;">
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-3">Product Price <span class="required">
							* </span>
							</label>
							<div class="col-md-9">
								<?php echo $this->Form->input('product_price',array('value'=>(isset($data['Product']))?$data['Product']['product_price']:'', 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Product Price", 'type'=>"text")); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Product Discount <span class="required">
							* </span>
							</label>
							<div class="col-md-9">
								<?php echo $this->Form->input('product_discount',array('value'=>(isset($data['Product']))?$data['Product']['product_discount']:'', 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Product Price Discount", 'type'=>"text")); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Product Quantity <span class="required">
							* </span>
							</label>
							<div class="col-md-9">
								<?php echo $this->Form->input('product_quantity',array('value'=>(isset($data['Product']))?$data['Product']['product_quantity']:'', 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Product Quantity", 'type'=>"text")); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Product Stock
							</label>
							<div class="col-md-9">
								<?php 
									echo $this->Form->input('stock_flag', array(
																'options' => $stock,
																'class' => 'form-control',
																'selected'=> (isset($data['Product']))?$data['Product']['product_taxclass']:''
															));
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab_2" style="margin-left:-5%;">
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-3">Meta Title <span class="required">
							* </span>
							</label>
							<div class="col-md-9">
								<?php echo $this->Form->input('meta_title',array('value'=>(isset($data['Product']))?$data['Product']['meta_title']:'', 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Meta Title", 'type'=>"text")); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Meta Keywords 
							</label>
							<div class="col-md-9">
								<?php echo $this->Form->input('meta_keyword',array('value'=>(isset($data['Product']))?$data['Product']['meta_keyword']:'', 'rows'=>2, 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Meta Keywords", 'type'=>"textarea")); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Meta Description 
							</label>
							<div class="col-md-9">
								<?php echo $this->Form->input('meta_description',array('value'=>(isset($data['Product']))?$data['Product']['meta_description']:'', 'rows'=>3, 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Meta Description", 'type'=>"textarea")); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Product Description 
							</label>
							<div class="col-md-9">
								<?php echo $this->Form->input('product_description',array('value'=>(isset($data['Product']))?$data['Product']['product_description']:'', 'rows'=>3, 'data-required'=>1, 'class'=>"ckeditor form-control", 'type'=>"textarea", 'data-error-container'=>'#error_product_description')); ?>
								<div id="error_product_description"></div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Product Short Description 
							</label>
							<div class="col-md-9">
								<?php echo $this->Form->input('product_shortdesc',array('value'=>(isset($data['Product']))?$data['Product']['product_shortdesc']:'', 'rows'=>3, 'data-required'=>1, 'class'=>"ckeditor form-control", 'type'=>"textarea", 'data-error-container'=>'#error_product_shortdescription')); ?>
								<div id="error_product_shortdescription"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab_3" style="margin-left:-8%;">
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-3">Product Front Image <span class="required">
							* </span>
							</label>
							<div class="col-md-9">
								<?php 
								if(!empty($data['Product'])){
									if(!empty($data['Product']['product_image'])){
										echo '<div id="main_'.$data['Product']['id'].'"><div class="col-md-3" >';
										echo $this->Html->image(IMGPATH.'product_image/thumb/'.$data['Product']['product_image'], array('alt'=>'Product Image','style'=>'margin-top:10px'));
										echo "<a  style='margin-top:4px' class='btn default btn-xs red ajaxdeimage' >
										<i class='fa fa-trash-o ajaxdeimage'></i> Delete</a>";	
										echo '</div>';
										
										/* echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete' ,
										array(
											  'controller'=>'Products',
											'action'=>'admin_imgdelete',
											'image_name'=>$data['Product']['product_image'],
											'id'=>$id   
										), 
										array('confirm' => 'Are you Sure?', 'escape'=>false, 'full_base'=>true, 'class'=>'btn default btn-xs red ajaxdeimage')
										); */
										
									
									echo '</div>';
									
									echo $this->Form->input('set_product_image', array('type'=>'hidden','value'=>$data['Product']['product_image'],'class'=>'set','id'=>"imagename"));
									echo '<div class="main_'.$data['Product']['id'].'">';
									echo '</div>';
									} else {
									echo '<div class="main_'.$data['Product']['id'].'">';
									echo $this->Form->input('product_image', array(
															'type' => "file"
														));  
									echo '</div>';
									}
								} else {
									echo '<div class="main_pimg">';
									echo $this->Form->input('product_image', array(
															'type' => "file"
														));  
									/* echo $this->Form->input('product_image',array('data-required'=>1, 'class'=>"form-control", 'type'=>"file"));  */
									echo '</div>';
								}
								
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Product Gallery Images </label>
							<div class="col-md-9">
								<?php 
								
								if(!empty($data['ProductGallery'])){
								
									foreach($data['ProductGallery'] as $gallery){
										
										
										echo '<div class="col-md-3" id="main_'.$gallery['id'].'" >';
										
										 echo $this->Form->input('img_id',array("type"=>"hidden","id"=>"img_id","label"=>false,"value"=> $gallery['id']));
										
										echo $this->Form->input('image_name',array("type"=>"hidden","id"=>"image_name","label"=>false,"value"=> $gallery['image_name']));
										
										
								echo $this->Html->image(IMGPATH.'product_gallery/thumb/'.$gallery['image_name'], array('alt'=>'Product Image','style'=>'margin-top:10px'));
										/* echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array(
											'controller'=>'Products',
											'action'=>'admin_galleryimgdelete',
											'img_id'=>$gallery['id'],
											'image_name'=>$gallery['image_name'],
											'id'=>$id
										), 
										array('confirm' => 'Are you Sure?', 'escape'=>false, 'full_base'=>true, 'class'=>'btn default btn-xs red')
										); */
										
										
										echo "<a  class='btn default btn-xs red ajaxdeimagegallery' style='margin-top:4px' >
										<i class='fa fa-trash-o'></i> Delete</a>";	
										
										
										echo '</div>';
										echo '<div class="main_'.$gallery['id'].'">';
										
										echo '</div>';
										
										
									}
									
									echo $this->Form->input('gallery_image',array('data-required'=>1, 'class'=>"form-control", 'name'=>'data[ProductGallery][image_name][]', 'type'=>"file", 'multiple'=>true,'style'=>'margin-top:45%')); 
								} else {
									echo $this->Form->input('gallery_image',array('data-required'=>1, 'class'=>"form-control", 'name'=>'data[ProductGallery][image_name][]', 'type'=>"file", 'multiple'=>true)); 
								}
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane row" id="tab_4" >
				<div class="col-md-12">
				<?php
				$m = 0;
				foreach($options as $option){
					$m++;
				?>
				<div class="col-md-6">
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption"><?php echo $option['ProductOption']['options_name']; ?></div>
						</div>
						<div class="portlet-body form">
						<div class="form-body">
							<div class="form-group">
							<div class="col-md-12">
							<?php 
							//pr($data['ProductAssignOption']);
								//$assignid = 0;
								$assignid = array();
								if(!empty($data['ProductAssignOption'])){
									
									foreach($data['ProductAssignOption'] as $assign){
										if($assign['option_id']==$option['ProductOption']['id']){
											//$assignid = $assign['option_value_id'];
											array_push($assignid,$assign['option_value_id']);
											
											echo $this->Form->input('option_id', array('type'=>'hidden', 'name'=>'data[ProductAssignOption][id][]', 'value'=>$assign['id']));
											//break;
										}
									}
									/* if($assignid == 0){
										echo $this->Form->input('option_id', array('type'=>'hidden', 'name'=>'data[ProductAssignOption][id][]', 'value'=>''));
									} */
									if(empty($assignid)){
										echo $this->Form->input('option_id', array('type'=>'hidden', 'name'=>'data[ProductAssignOption][id][]', 'value'=>''));
									}
								}
								//pr($assignid);
								
								echo $this->Form->input('product_options', array(
															'options' => $option['ProductOption']['values'],
															'name' => 'data[ProductAssignOption][option_value_id]['.$option['ProductOption']['id'].']',
															'empty' => 'Select Value',
															'class' => 'form-control multiselect',
															'id' => 'multiselect'.$m,
															'multiple' =>true,
															'selected'=> (!empty($assignid))?$assignid:''
														));
								
							?>
							</div>
							
							</div>
						</div>
						</div>
					</div>
				</div>
				<?php } ?>
				</div>
				</div>
				<div class="tab-pane" id="tab_5" style="margin-left:-16%;">
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-3 control-label">Shipping Rate
						</div>
							
							<?php if(!empty($data['ProductShippingValue'])){ ?>
							<?php echo $this->Form->input('id',array("type"=>"hidden",'name'=>'data[ProductShippingValue][id]',"label"=>false,"value"=>$data['ProductShippingValue'][0]['id'])); ?>
							<?php } else { ?>
							<?php echo $this->Form->input('id',array("type"=>"hidden",'name'=>'data[ProductShippingValue][id]',"label"=>false,"value"=>'')); ?>
							<?php } ?>
							<div class="form-group">
							<label class="control-label col-md-3">VIC:<span class="required">
							* </span>
							</label>
							<div class="col-md-3">
								<?php echo $this->Form->input('VIC',array('value'=>(isset($data['ProductShippingValue'][0]))?$data['ProductShippingValue'][0]['VIC']:'','name'=>'data[ProductShippingValue][VIC]', 'data-required'=>1, 'class'=>"form-control",  'type'=>"text")); ?>
								
							</div>
							</div>
							
							<div class="form-group">
							<label class="control-label col-md-3">NT:<span class="required">
							* </span>
							</label>
							<div class="col-md-3">
								<?php echo $this->Form->input('NT',array('value'=>(isset($data['ProductShippingValue'][0]))?$data['ProductShippingValue'][0]['NT']:'','name'=>'data[ProductShippingValue][NT]', 'data-required'=>1, 'class'=>"form-control",  'type'=>"text")); ?>
								
							</div>
							</div>
							
							<div class="form-group">
							<label class="control-label col-md-3">QLD:<span class="required">
							* </span>
							</label>
							<div class="col-md-3">
								<?php echo $this->Form->input('QLD',array('value'=>(isset($data['ProductShippingValue'][0]))?$data['ProductShippingValue'][0]['QLD']:'','name'=>'data[ProductShippingValue][QLD]', 'data-required'=>1, 'class'=>"form-control",  'type'=>"text")); ?>
								
							</div>
							</div>
							
							<div class="form-group">
							<label class="control-label col-md-3">NSW:<span class="required">
							* </span>
							</label>
							<div class="col-md-3">
								<?php echo $this->Form->input('NSW',array('value'=>(isset($data['ProductShippingValue'][0]))?$data['ProductShippingValue'][0]['NSW']:'','name'=>'data[ProductShippingValue][NSW]', 'data-required'=>1, 'class'=>"form-control",  'type'=>"text")); ?>
								
							</div>
							</div>
							
							<div class="form-group">
							<label class="control-label col-md-3">TAS:<span class="required">
							* </span>
							</label>
							<div class="col-md-3">
								<?php echo $this->Form->input('TAS',array('value'=>(isset($data['ProductShippingValue'][0]))?$data['ProductShippingValue'][0]['TAS']:'','name'=>'data[ProductShippingValue][TAS]', 'data-required'=>1, 'class'=>"form-control",  'type'=>"text")); ?>
								
							</div>
							</div>
							
							<div class="form-group">
							<label class="control-label col-md-3">WA:<span class="required">
							* </span>
							</label>
							<div class="col-md-3">
								<?php echo $this->Form->input('WA',array('value'=>(isset($data['ProductShippingValue'][0]))?$data['ProductShippingValue'][0]['WA']:'','name'=>'data[ProductShippingValue][WA]', 'data-required'=>1, 'class'=>"form-control",  'type'=>"text")); ?>
								
							</div>
							</div>
							
							<div class="form-group">
							<label class="control-label col-md-3">SA:<span class="required">
							* </span>
							</label>
							<div class="col-md-3">
								<?php echo $this->Form->input('SA',array('value'=>(isset($data['ProductShippingValue'][0]))?$data['ProductShippingValue'][0]['SA']:'','name'=>'data[ProductShippingValue][SA]', 'data-required'=>1, 'class'=>"form-control",  'type'=>"text")); ?>
								
							</div>
							</div>
						   
						
						
					</div>
				</div>
			</div>
			<div class="form-actions fluid">
				<div class="col-md-offset-3 col-md-9">
					<?php echo $this->Form->button('Save', array('type' => 'submit', 'name'=>'continue', 'value'=>'s', 'class'=>"btn blue"));?>
					<?php echo $this->Form->button('Save & Close', array('type' => 'submit', 'class'=>"btn blue"));?>
					<?php echo $this->Form->button('Cancel', array('type' => 'reset', 'class'=>"btn default", 'onclick'=>'window.history.back()'));?>
				</div>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
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
			'data[Product][product_name]': {
				required: true
			},
			
			'data[Product][product_categoryid][]': {
				required: true
			},
			'data[Product][product_taxclass]': {
				required: true
			},
			'data[Product][product_status]': {
				required: true
			},
			'data[Product][product_price]': {
				required: true
			},
			'data[Product][product_discount]': {
				required: true
			},
			'data[Product][product_quantity]': {
				required: true
			},
			'data[Product][stock_flag]': {
				required: true
			},
			'data[Product][meta_title]': {
				required: true
			},
			'data[Product][product_image]': {
				required: true
			},
			'data[ProductShippingValue][VIC]': {
				required: true
			},
			'data[ProductShippingValue][NT]': {
				required: true
			},
			'data[ProductShippingValue][QLD]': {
				required: true
			},
			'data[ProductShippingValue][NSW]': {
				required: true
			},
			'data[ProductShippingValue][TAS]': {
				required: true
			},
			'data[ProductShippingValue][WA]': {
				required: true
			},
			'data[ProductShippingValue][SA]': {
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
	
	$("#crsProductlist").select2({
		tags:<?php echo $prdString; ?>
	});
	
	
	$('.ajaxdeimage').click(function(){
				var confirmval=confirm("Are you Sure");
				if(confirmval==true)
				{
				var id = $('#idhed').val(); 
				//alert(id);
				var imagename = $('#imagename').val(); //alert(id);
					//alert(imagename);
			 	$.ajax({
					type:'POST',
					url : '<?php echo $this->Html->url(
						array(
							'controller'=>'Products',
							'action'=>'admin_ajaximagedelete'
						)
					); ?>',
					data:{id:id,imagename:imagename},
					success:function(result){
						$('#main_'+id).remove();
						$('.main_'+id).append('<input id="ProductProductImage" type="file" name="data[Product][product_image]">');
							$('#flashMessage1').show();
						
						
					}
				}); 
			}
			});
			
			$('.ajaxdeimagegallery').click(function(){
				var confirmval=confirm("Are you Sure");
				//alert(confirmval);
				if(confirmval==true)
				{
				var numItems = $('.ajaxdeimagegallery').length;
				//alert(numItems);
				var id = $('#idhed').val(); 
				var img_id = $('#img_id').val(); 
				var image_name = $('#image_name').val(); //alert(id);
			 	$.ajax({
					type:'POST',
					url : '<?php echo $this->Html->url(
						array(
							'controller'=>'Products',
							'action'=>'admin_ajaxgalleryimagedelete'
						)
					); ?>',
					data:{id:id,img_id:img_id,image_name:image_name},
					success:function(result){
						$('#main_'+img_id).remove();
						if(numItems=='1')
						{
						$('.main_'+img_id).append('<input type="file" id="ProductGalleryImage" multiple="multiple" class="form-control" data-required="1" name="data[ProductGallery][image_name][]">');
						}
						$('#flashMessage1').show();
						
					}
				}); 
			}
			});
			
	
	
});
</script>


			
	