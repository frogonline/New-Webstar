<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?> Banner
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('CmsBanner', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
					<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
						
						<div class="form-group">
							<label class="control-label col-md-3">Banner Title <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('banner_name',array('value'=>(isset($data['CmsBanner']))?$data['CmsBanner']['banner_name']:'', 'id'=>"banner_name", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Banner Title", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Banner Image <span class="required">*</span></label>
							<div class="col-md-8">
								<?php
									if(!empty($data['CmsBanner']['banner_image'])){
										echo '<div class="col-md-3">';
										echo $this->Html->image(IMGPATH.'cms_banner_image/thumb/'.$data['CmsBanner']['banner_image'], array('alt'=>'Image'));
										echo '</div>';
										echo '<div class="col-md-4">';
										echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array(
											'controller'=>'CmsBanners',
											'action'=>'admin_imgdelete',
											'image_name'=>$data['CmsBanner']['banner_image'],
											'id'=>$id
										), 
										array('confirm' => 'Are you Sure?', 'escape'=>false, 'full_base'=>true, 'class'=>'btn default btn-xs red')
										);
										echo '</div>';
										echo $this->Form->input('set_banner_image', array('type'=>'hidden','value'=>$data['CmsBanner']['banner_image'],'class'=>'set'));
									} else {
										echo $this->Form->input('banner_image', array(
															'type' => "file"
														));  
										echo " &nbsp "."<font color='red'>(Recommended Size 560 x 480)</font>"; 
									}
								?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Banner Text
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('banner_text',array('value'=>(isset($data['CmsBanner']))?$data['CmsBanner']['banner_text']:'', 'id'=>"banner_text", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Banner Text", 'type'=>"text")); ?>
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="control-label col-md-3">Banner Link 
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('banner_link',array('value'=>(isset($data['CmsBanner']))?$data['CmsBanner']['banner_link']:'', 'id'=>"banner_link", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Banner Link", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 control-label">Select Status <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('banner_status', array(
																'options' => $statusArr,
																'empty' => 'Select Status',	
																'class' => 'form-control',
																'selected'=> (isset($data['CmsBanner']))?$data['CmsBanner']['banner_status']:''
															));
									?>  
								</div>
							</div>
						</div>
						
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
							<?php echo $this->Form->button('Submit', array('type' => 'submit', 'class'=>"btn blue"));?>
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
			'data[CmsBanner][banner_name]': {
				required: true
			},
			'data[CmsBanner][banner_image]': {
				required: true
			},
			'data[CmsBanner][banner_status]': {
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