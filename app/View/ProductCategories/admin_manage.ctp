<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	//pr($ProductCategoryArr);
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i>
					<?php echo (isset($id))?'Edit':'Add' ?> Product Category
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('ProductCategory', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
					<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
					<?php echo $this->Form->input('categories_slug',array("type"=>"hidden","label"=>false,'value'=>(isset($data['ProductCategory']))?$data['ProductCategory']['categories_slug']:'')); ?>
					
						<h3 class="form-section">Meta Data</h3>
						
						<div class="form-group">
							<label class="control-label col-md-3">Meta Title <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('meta_title',array('value'=>(isset($data['ProductCategory']))?$data['ProductCategory']['meta_title']:'', 'id'=>"meta_title", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Meta Title", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Meta Keywords <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('meta_keywords',array('value'=>(isset($data['ProductCategory']))?$data['ProductCategory']['meta_keywords']:'', 'id'=>"meta_keywords", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Meta keywords", 'type'=>"textarea")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Meta Description <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('meta_desc',array('value'=>(isset($data['ProductCategory']))?$data['ProductCategory']['meta_desc']:'', 'id'=>"meta_desc", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Meta Description", 'type'=>"textarea")); ?>
							</div>
						</div>
						<h3 class="form-section">Category</h3>
						
							<div class="form-group">
							<label class="col-md-3 control-label">Parent Category </label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('parent_id', array(
																'options' => $categories,
																'empty' => '--Select--',	
																'class' => 'form-control',
																'selected'=> (isset($data['ProductCategory']))?$data['ProductCategory']['parent_id']:'',
																'escape'=>false
															));
									?>  
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Name <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('name',array('value'=>(isset($data['ProductCategory']))?$data['ProductCategory']['name']:'', 'id'=>"category_name", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Product Category name", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Description <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('category_desc',array('value'=>(isset($data['ProductCategory']))?$data['ProductCategory']['category_desc']:'', 'id'=>"category_desc", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Product Description", 'type'=>"textarea")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Image <span class="required">*</span></label>
							<div class="col-md-8">
								<?php
									if(!empty($data['ProductCategory']['category_image'])){
										echo '<div class="col-md-3">';
										echo $this->Html->image(IMGPATH.'category_image/thumb/'.$data['ProductCategory']['category_image'], array('alt'=>'Image'));
										echo '</div>';
										echo '<div class="col-md-4">';
										echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array(
											'controller'=>'ProductCategories',
											'action'=>'admin_imgdelete',
											'image_name'=>$data['ProductCategory']['category_image'],
											'id'=>$id
										), 
										array('confirm' => 'Are you Sure?', 'escape'=>false, 'full_base'=>true, 'class'=>'btn default btn-xs red')
										);
										echo '</div>';
										echo $this->Form->input('set_category_image', array('type'=>'hidden','value'=>$data['ProductCategory']['category_image'],'class'=>'set'));
									} else {
										echo $this->Form->input('category_image', array(
															'type' => "file"
														));  
										echo " &nbsp "."<font color='red'>(Recommended Size 560 x 480)</font>"; 
									}
								?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 control-label">Status <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('category_status', array(
																'options' => $statusArr,
																'empty' => 'Select Status',	
																'class' => 'form-control',
																'selected'=> (isset($data['ProductCategory']))?$data['ProductCategory']['category_status']:''
															));
									?>  
								</div>
							</div>
						</div>
						
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
							<?php echo $this->Form->button('Save', array('type' => 'submit', 'name'=>'continue', 'value'=>'s', 'class'=>"btn blue"));?>
							<?php echo $this->Form->button('Save & Close', array('type' => 'submit', 'class'=>"btn blue"));?>
							<?php echo $this->Form->button('Cancel', array('type' => 'reset','onclick'=>'window.history.back()', 'class'=>"btn default",'div'=>false));?>
						</div>
					</div>
				<?php echo $this->Form->end(); ?>
				<!-- END FORM-->
			</div>
			<!-- END VALIDATION STATES-->
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
			'data[ProductCategory][meta_title]': {
				required: true
			},
			'data[ProductCategory][meta_keywords]': {
				required: true
			},  
			'data[ProductCategory][meta_desc]': {
				required: true
			},
			'data[ProductCategory][name]': {
				required: true
			},
			'data[ProductCategory][category_desc]': {
				required: true
			},
			'data[ProductCategory][category_status]': {
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