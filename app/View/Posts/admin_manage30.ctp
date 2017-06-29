<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i>
					<?php pr($data); ?>
					<?php echo (isset($id))?'Edit':'Add' 
					
					?> Page
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('Page', array('controller'=>'Posts','action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
						<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
						<h3 class="form-section">Meta Data</h3>
						
						<div class="form-group">
							<label class="control-label col-md-3">Meta Title <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
									echo $this->Form->input('metatitle', array(
															'type' => "text",
															'placeholder'=>"Enter Page Meta Title",
															'value' => (isset($data['Page']))?$data['Page']['metatitle']:'', 
															'class' => "form-control"
														)); 
								?>
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="control-label col-md-3">Meta Keywords <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
									echo $this->Form->input('metakeywords', array(
															'type' => "text",
															'placeholder'=>"Enter Page Meta Keywords",
															'value' => (isset($data['Page']))?$data['Page']['metakeywords']:'', 
															'class' => "form-control"
														)); 
								?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Meta Description <span class="required">
							* </span>
							</label>
							<div class="col-md-6">
								<?php 
									echo $this->Form->input('metadescription', array(
															'type' => "textarea",
															'placeholder'=>"Enter Page Meta Description",
															'value' => (isset($data['Page']))?$data['Page']['metadescription']:'', 
															'class' => "form-control"
														)); 
								?>
							</div>
						</div>
						
						<h3 class="form-section">Page Details </h3>
						<div class="form-group">
							<label class="control-label col-md-3">Page Title <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('title',array('value'=>(isset($data['Page']))?$data['Page']['title']:'', 'id'=>"name", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Page Title", 'type'=>"text")); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Type <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('type',array('value'=>(isset($data['Page']))?$data['Page']['type']:'', 'id'=>"type", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Page Title", 'type'=>"text")); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Page Category <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('categoryid', array(
																'options' => $pcategory,
																'empty' => 'Select Category',	
																'class' => 'form-control',
																'selected'=> (isset($data['Page']))?$data['Page']['categoryid']:''
															));
									?>  
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Image Caption <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
									echo $this->Form->input('image_caption', array(
															'type' => "text",
															'placeholder'=>"Enter Page Image Caption",
															'value' => (isset($data['Page']))?$data['Page']['image_caption']:'', 
															'class' => "form-control"
														)); 
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Select Image <span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<?php
									if(!empty($data['Page']['cms_image'])){
										echo '<div class="col-md-3">';
										echo $this->Html->image(IMGPATH.'cms_image/thumb/'.$data['Page']['cms_image'], array('alt'=>'Image'));
										echo '</div>';
										echo '<div class="col-md-4">';
										echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array(
											'controller'=>'Pages',
											'action'=>'admin_imgdelete',
											'image_name'=>$data['Page']['cms_image'],
											'id'=>$id
										), 
										array('confirm' => 'Are you Sure?', 'escape'=>false, 'full_base'=>true, 'class'=>'btn default btn-xs red')
										);
										echo '</div>';
										echo $this->Form->input('set_cms_image', array('type'=>'hidden','value'=>$data['Page']['cms_image'],'class'=>'set'));
									} else {
										echo $this->Form->input('cms_image', array(
															'type' => "file"
														));  
										echo " &nbsp "."<font color='red'>(Recommended Size 560 x 480)</font>"; 
										echo $this->Form->input('set_cms_image', array('type'=>'hidden','value'=>'','class'=>'set'));
									}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Content <span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<?php 
									echo $this->Form->input('content', array(
										'type' => "textarea",
										'id' => 'content',
										'value' => (isset($data['Page']))?$data['Page']['content']:'', 
										'class' => "ckeditor form-control",
										'data-error-container'=>'#editor2_error'
									)); 
								?>
								<div id="editor2_error"></div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Select Status <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('is_active', array(
																'options' => $statusArr,
																'empty' => 'Select Status',	
																'class' => 'form-control',
																'selected'=> (isset($data['Page']))?$data['Page']['is_active']:''
															));
									?>  
								</div>
							</div>
						</div>
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
							<?php echo $this->Form->button('Submit', array('type' => 'submit', 'class'=>"btn blue"));?>
							<?php echo $this->Form->button('Cancel', array('type' => 'reset', 'class'=>"btn default", 'onclick'=>'window.history.back()'));?>
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
			'data[Page][post_title]': {
				required: true
			},
			'data[Page][post_categoryid]': {
				required: true
			},  
			'data[Page][post_image_caption]': {
				required: true
			},
			'data[Page][post_image]': {
				required: true
			},
			'data[Page][post_content]': {
				required: true
			},
			'data[Page][post_status]': {
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