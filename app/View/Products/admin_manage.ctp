<?php
	$taxclass = array('1'=>'None', '2'=>'Taxable Goods');
	$stock = array('TRUE'=>'In Stock', 'FALSE'=>'Out of Stock');
	$status = array('Y'=>'Active','N'=>'Inactive');
	if(empty($id))
	{
		foreach($options as $optiondrop)
		{
			$optiondropArray[$optiondrop['ProductOption']['id']]=$optiondrop['ProductOption']['options_name'];
		}
	}else {
	foreach($options as $optiondrop)
		{
			if (in_array($optiondrop['ProductOption']['id'],$optionidArr))
			  {

			  }
			  else{
			  $optiondropArray[$optiondrop['ProductOption']['id']]=$optiondrop['ProductOption']['options_name'];
			  }
		}
	
	
	}
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
				
				<div class="tab-pane" id="tab_4">
					<div class="form-body">
					
						<div class="form-group">
							<label class="control-label col-md-1">
							</label>
							<div class="col-md-6">
								<?php 
									echo $this->Form->input('option_id', array(
																'options' => $optiondropArray,
																'empty' => '--Select--',
																'id'	=> 'selectid',
																'name'  =>'data[ProductAssignNewOption][option_id][]',
																'class' => 'form-control'
															));
								?>
								
							</div>
							<div class="col-md-2">
							<a onclick="check()" style="float:left" class="btn green">Add <i class="fa fa-plus"></i></a>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-12">
							
					<?php 
					if(!empty($data['Product']['id']))
					{
					?>
						<ul style="margin-right: 0px;" class="nav nav-tabs ver">
						<?php
						$i=0;
							foreach($data['ProductAssignNewOption'] as $key=>$ProductShippingValues)
							{
						
							if($i==0)
							{
								$optionname = $this->Layout->optionname($ProductShippingValues['option_id']);
								?>
								<li class="<?php if($i==0) { echo "active"; } ?>"><a data-toggle="tab" href="#tab_6_<?php echo $ProductShippingValues['option_id']; ?>"><?php echo $optionname['ProductOption']['options_name']; ?></a>
								</li>
								
							<?php 
							}else{
									if($data['ProductAssignNewOption'][$key]['option_id']!=$data['ProductAssignNewOption'][$key-1]['option_id'])
										{
										$optionname = $this->Layout->optionname($ProductShippingValues['option_id']);
										?>
										<li class="<?php if($i==0) { echo "active"; } ?>"><a data-toggle="tab" href="#tab_6_<?php echo $ProductShippingValues['option_id']; ?>"><?php echo $optionname['ProductOption']['options_name']; ?></a></li>
										<?php
										}
								}	
						?>
							
							
						<?php 
						$i++;
						}
						?>
						</ul>	
						<div class="tab-content ver-content">
						<?php $j=0; ?> 
						<?php foreach($optionidArr as $key=>$val) { ?>
						
							<div class="tab-pane <?php if($j==0) { echo "active"; } ?>" id="tab_6_<?php echo $val; ?>">
									<table class="table table-bordered table-hover" id="optionstable_<?php echo $val; ?>" style="width:90%">
									<thead>
										<tr role="row" class="heading">
										<th width="20%">Option Value</th>
										
										<th width="25%">Quantity</th>
										<th width="20%">Price</th>
										<th width="20%"></th>
										</tr>
									</thead>
									<tbody>
									
									<?php 	foreach($data['ProductAssignNewOption'] as $key=>$ProductShippingValues) { ?>
										<?php if($val==$ProductShippingValues['option_id']) { ?>
									
									<tr>
									<?php 
									$optionvaluesname = $this->Layout->optionvaluesname($ProductShippingValues['option_id']);


									?>
										<td>
											<div class="input select">
											<select id="option_value_id" class="form-control optionvalues 1" style="width:200px" name="data[ProductAssignNewOption][option_value_id][<?php echo $val; ?>][]">
											<?php foreach($optionvaluesname as $keys=>$valu) { ?>
											
								<option value="<?php echo $keys; ?>" <?php if($ProductShippingValues['option_value_id']==$keys){ echo "selected"; } ?> >
											<?php echo $valu; ?>
											</option>
											<?php } ?>
											</select>
											</div>
	
										</td>
										
										
									
										<td><input type="text" class="form-control" name="data[ProductAssignNewOption][Quantity][<?php echo $val; ?>][]" value="<?php echo $ProductShippingValues['Quantity']; ?>"></td>
										
										
										<td>
										<select style="width:38%; float:left; margin-right:10px" class="form-control" name="data[ProductAssignNewOption][operation][<?php echo $val; ?>][]">
										<option value="1" <?php if($ProductShippingValues['operation']==1){ echo "selected"; } ?>>+</option>
										<option value="0" <?php if($ProductShippingValues['operation']==0){ echo "selected"; } ?>>-</option>
										</select>
										<input type="text" class="form-control" name="data[ProductAssignNewOption][operation_value][<?php echo $val; ?>][]" style="width:40%" value="<?php echo $ProductShippingValues['operation_value']; ?>">
										</td>
										
										<td><input type="hidden" value="1" name="option_id[<?php echo $val; ?>][]"><a class="btn default btn-sm" onclick="$(this).closest('tr').remove();" href="javascript:;"><i class="fa fa-times"></i> Remove </a></td>
									</tr>	
									<?php } ?>
									<?php } ?>
									
									<?php
									$optionname = $this->Layout->optionname($val);
									?>
									<tr>
										<td colspan="4"></td>
										<td><a class="btn blue" href="javascript:addoptions(<?php echo $val; ?>);">
										<i class="fa fa-plus"></i> Add </a>
										<a class="btn blue" href="javascript:deleteoptions('<?php echo $optionname['ProductOption']['options_name'];  ?>','<?php echo $val; ?>');">
										<i class="fa fa-minus"></i> Remove 
										</a>
										</td>
									</tr>
									
									
								</tbody>
							</table>
						  </div>
						<?php $j++; } ?>
						</div>				
					<?php
					
					}else {
					?>
						<ul class="nav nav-tabs ver" style="margin-right:0px;display:none;" >
						</ul>
						<div class="tab-content ver-content">
						</div>	
						<?php 
						}
						?>
							</div>	
						</div>
					</div>
				</div>
				
				
				
				
				
				
				<div class="tab-pane" id="tab_5">
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

<script>

	function check()

	{
		var optionsvalue = $("#selectid").val();

		var optionstext  = $("#selectid option:selected").text();
		
		if(optionsvalue!='')

		{

			var e = document.getElementById("selectid");

			e.remove(e.selectedIndex);

		

			var x=$("ul.ver li.active a").attr("href");

			$("ul.ver li.active").removeClass("active");

			$(x).removeClass("active");

			

			

			var t='<li class="active">';

				t+='<a href="#tab_6_'+optionsvalue+'" data-toggle="tab">'+optionstext+'</a>';

				t+='</li>';
			$('ul.ver').show();
			$('ul.ver').append(t);

			

			var s='<div class="tab-pane active" id="tab_6_'+optionsvalue+'">';

				s+='<table class="table table-bordered table-hover" id="optionstable_'+optionsvalue+'"  style="width:90%" >';

				s+='<thead><tr role="row" class="heading"><th width="20%">Option Value</th>';
				
			

				s+='<th width="25%">Quantity</th><th width="20%">Price</th><th width="20%"></th></tr></thead>';

				s+='<tbody><tr><td colspan="4"></td><td><a href="javascript:addoptions('+optionsvalue+');" class="btn blue"><i class="fa fa-plus"></i> Add </a><a href="javascript:deleteoptions('+'\''+optionstext+'\''+','+optionsvalue+');" class="btn blue"><i class="fa fa-minus"></i> Remove </a></td></tr></tbody>';

				s+='</table></div>';

			$('.ver-content').append(s);

			

		}

		else

		{

			alert("Please select a value");

		}

	}
	
		function addoptions(a)

		{
			
		var check_empty=0

		$("."+a).each(function(){

			if($(this).val()=='')

			{
				check_empty++;
			}

		});
		
		if(check_empty==0)

		{

			var len= $("."+a).length;

			

			var checkValues = $("."+a).map(function()

						{
							return $(this).val();
						}).get();
			var checkValues=0;
			$.ajax({
					type:'POST',
						url : '<?php echo $this->Html->url(
							array(
								'controller'=>'Products',
								'action'=>'admin_ajaxaddoption'
							)
							); ?>',
							data: { id: a , length:len, latestval:checkValues },

							success:function(data){

								if(data==0)

								{

									alert("Option value limit exceed");

								}

								else

								{

									$('#optionstable_'+a+' > tbody > tr:first').before(data);	

								}

									

							}

						});

		}

		else

		{

			alert("Please first select a value");

		}

	}
	
	function deleteoptions(a,b)

	{

			var x = document.getElementById("selectid");

			var option = document.createElement("option");

			option.text = a;

			option.value = b;

			x.add(option);

			var index = $("ul.ver li.active").index();

			var divindex = $("div.ver-content div.active").index();

			

			

			$("ul.ver li.active").remove();

			$("div.ver-content div.active").remove();

			

			if(index==0 && divindex==0)

			{

				$('ul.ver li:nth-child('+(index+1)+')').addClass("active");

				$(".ver-content div:nth-child("+(divindex+1)+")").addClass("active");
				$('ul.ver').hide();

			}

			else

			{

				$('ul.ver li:nth-child('+(index)+')').addClass("active");

				$(".ver-content div:nth-child("+(divindex)+")").addClass("active");

			}

	}

</script>


			
	