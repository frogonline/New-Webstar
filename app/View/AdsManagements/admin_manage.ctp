<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?> Advertisements
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('AdsManagement', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
						<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
						
						<div class="form-group">
							<label class="col-md-3 control-label">Title <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php echo $this->Form->input('title',array('value'=>(isset($data['AdsManagement']))?$data['AdsManagement']['title']:'','data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Advertisements Title", 'type'=>"text")); ?>
								</div>
							</div>
						</div>
						
						<div class="form-group">
						<label class="col-md-3 control-label">Select One <span class="required">
							* </span>
						</label>
							<div class="col-md-4">
								<div class="input-group" id="state_list">
									<?php 
									$options = array('I' => 'Image', 'C' => 'Code');
									$attributes = array('legend' => false,
									'label' => true,										'value'=>(!empty($data['AdsManagement']))?$data['AdsManagement']['type']:'', 
												'hidden'=>false,
												'div'=>false,
												'onclick'=>array('return hide_show(this.value)')
												);
								    echo $this->Form->radio('type',$options,$attributes);
							       ?> 
								</div>
							</div>
						</div>
						
						<div class="form-group" style='display:none;'id='form-group'>
							<label class="control-label col-md-3">Select Image <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php
									if(!empty($data['AdsManagement']['image_ads'])){
										echo '<div class="col-md-3">';
										echo $this->Html->image(IMGPATH.'image_ads/thumb/'.$data['AdsManagement']['image_ads'], array('alt'=>'Image'));
										echo '</div>';
										echo '<div class="col-md-4">';
										echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array(
											'controller'=>'AdsManagements',
											'action'=>'admin_imgdelete',
											'image_name'=>$data['AdsManagement']['image_ads'],
											'id'=>$id
										), 
										array('confirm' => 'Are you Sure?', 'escape'=>false, 'full_base'=>true, 'class'=>'btn default btn-xs red')
										);
										echo '</div>';
										echo $this->Form->input('set_image_ads', array('type'=>'hidden','value'=>$data['AdsManagement']['image_ads'],'class'=>'set'));
									} else {
										echo $this->Form->input('image_ads', array(
															'type' => "file"
														));  
										echo " &nbsp "."<font color='red'>(Recommended Size 560 x 480)</font>"; 
									}
								?>
							</div>
						</div>
						
						
					
						<div class="form-group" style='display:none;'id='form-group1'>
							<label class="col-md-3 control-label">Code <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php echo $this->Form->textarea('code',
								array('class'=>'form-control',  
								'placeholder' => '',
									'value'=>(!empty($data['AdsManagement']))?$data['AdsManagement']['code']:''
								
								)
							);
					?>
								</div>
							</div>
						</div>
						
						<?php 
						if($id>0)
						{
						?>
						<?php 
						if($data['AdsManagement']['type']=='I')
						{
						?>
						
						
						
						<div class="form-group" id="form-groupsm">
							<label class="control-label col-md-3">Select Image <span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<?php
									if(!empty($data['AdsManagement']['image_ads'])){
										echo '<div class="col-md-3">';
										echo $this->Html->image(IMGPATH.'image_ads/thumb/'.$data['AdsManagement']['image_ads'], array('alt'=>'Image'));
										echo '</div>';
										echo '<div class="col-md-4">';
										echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array(
											'controller'=>'AdsManagements',
											'action'=>'admin_imgdelete/'.$data['AdsManagement']['image_ads'].'/'.$id
										), 
										array('confirm' => 'Are you Sure?', 'escape'=>false, 'full_base'=>true, 'class'=>'btn default btn-xs red')
										);
										echo '</div>';
										 echo $this->Form->input('set_image_ads', array('type'=>'hidden','value'=>$data['AdsManagement']['image_ads'],'class'=>'set'));
										 } 
									else {
										echo $this->Form->input('image_ads', array(
															'type' => "file"
														));  
										echo " &nbsp "."<font color='red'>(Recommended Size 560 x 480)</font>"; 
									}
								?>
								
							</div>
						</div>
						<?php 
						}
						?>
						
							<?php 
						if($data['AdsManagement']['type']=='C')
						{
						?>
						
						<div class="form-group" id='form-groupcode'>
							<label class="col-md-3 control-label">Code <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php echo $this->Form->textarea('code',
								array('class'=>'form-control',
								'placeholder' => '',
									'value'=>(!empty($data['AdsManagement']))?$data['AdsManagement']['code']:''
								
								)
							);
					      ?>
						
								</div>
							</div>
						</div>
						<?php 
						}
						?>
						
						<?php 
						}
						?>
						
						<div class="form-group">
							<label class="col-md-3 control-label">Select Status <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('status', array(
																'options' => $statusArr,
																'empty' => 'Select Status',	
																'class' => 'form-control',
																'selected'=> (isset($data['AdsManagement']))?$data['AdsManagement']['status']:''
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
							<?php echo $this->Form->button('Cancel', array('type' => 'reset', 'class'=>"btn default",'onclick'=>'window.history.back()'));?>
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
			 'data[AdsManagement][title]': {
				required: true
			}, 
			/* 'data[AdsManagements][type]': {
				required: true
					
			}, */ 
	 
			'data[AdsManagement][status]': {
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
			$(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
		},

		success: function (label) {
			label.closest('.form-group').removeClass('has-error'); // set success class to the control group
		}

	});
	
});
</script>

<script type="text/javascript">
function hide_show(fff)
{
var dd=fff;

if(dd=='I')
{
document.getElementById("form-group").style.display = "block";
document.getElementById("form-group1").style.display = "none";
document.getElementById("form-groupcode").style.display = "none";
}
if(dd=='C')
{
document.getElementById("form-group1").style.display = "block";

document.getElementById("form-group").style.display = "none";
document.getElementById("form-groupsm").style.display = "none";
}
}
 
</script>