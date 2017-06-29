<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	
?>
<style>
#cke_1_contents {
  height: 150px !important;
}
</style>
<div class="modal-dialog">
	<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h2 class="modal-title"><?php if($id!=''){ ?>Edit<?php }else{ ?> Add<?php } ?> Testimonial Content</h2>
			</div>
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('Testimonial', array('action' => 'admin_boxmanageupdate/'.$tab_id.'/'.$style.'/'.$id, 'id'=>"form_sample_4", 'class'=>"form-horizontal", 'type'=>'file', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
			<div class="modal-body">
				<div class="scroller" data-always-visible="1" data-rail-visible1="1">
					<div class="row">
						<div class="col-md-12">
						<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
						<?php
								if(empty($id)){
									echo $this->Form->input('created_date', array('type'=>'hidden','value'=>date('Y-m-d')));
								} else {
									echo $this->Form->input('modified_date', array('type'=>'hidden','value'=>date('Y-m-d')));
								}
						?>
						<?php echo $this->Form->input('testimonial_id',array("type"=>"hidden","label"=>false,"value"=> $tab_id)); ?>
						<?php echo $this->Form->input('style',array("type"=>"hidden","label"=>false,"value"=> $style)); ?>
						<div class="col-md-12">
							<h4>Name <span class="required">
							* </span>
							</h4>
								<?php echo $this->Form->input('title',array('value'=>(isset($data1['TestimonialContent']))?$data1['TestimonialContent']['title']:'', 'class'=>"form-control", 'placeholder'=>"Enter Name", 'type'=>"text")); ?>
						</div>
						
						<?php 
						if($style!='style3')
						{
						?>
						<div class="col-md-12">
							<h4>Designation <span class="required">
							* </span>
							</h4>
								<?php echo $this->Form->input('heading',array('value'=>(isset($data1['TestimonialContent']))?$data1['TestimonialContent']['heading']:'','class'=>"form-control", 'placeholder'=>"Enter Designation", 'type'=>"text")); ?>
						</div>
						<?php
						}
						?>
						<div class="col-md-12">
							<h4>Testimonial<span class="required">
							* </span>
							</h4>
								<?php	echo $this->Form->input('testimonial', array(
															'type' => "textarea",
															'placeholder'=>"Enter Testimonial",
															'value' => (isset($data1['TestimonialContent']))?$data1['TestimonialContent']['testimonial']:'', 
															'class' => "ckeditor form-control",
															'data-error-container'=>'#editor2_error'
														)); 
								?>
								<div id="editor2_error"></div>
						</div>
						<?php 
						if($style!='style3')
						{
						?>
						<div class="col-md-12">
							<h4>Image <span class="required">*</span></h4>
								<?php
									if(!empty($data1['TestimonialContent']['testimonial_image'])){
										echo '<div class="col-md-3">';
										echo $this->Html->image(IMGPATH.'testimonial_image/thumb/'.$data1['TestimonialContent']['testimonial_image'], array('alt'=>'Image'));
										echo '</div>';
										echo '<div class="col-md-4">';
										echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array(
											'controller'=>'Testimonials',
											'action'=>'admin_imgdelete',
											'image_name'=>$data1['TestimonialContent']['testimonial_image'],
											'id'=>$id,
											't_id'=>$tab_id,
										), 
										array('confirm' => 'Are you Sure?', 'escape'=>false, 'full_base'=>true, 'class'=>'btn default btn-xs red')
										);
										echo '</div>';
										echo $this->Form->input('set_testimonial_image', array('type'=>'hidden','value'=>$data1['TestimonialContent']['testimonial_image'],'class'=>'set'));
									} else {
										echo $this->Form->input('testimonial_image', array(
															'type' => "file"
														));  
										echo " &nbsp "."<font color='red'>(Recommended Size 75 x 75)</font>"; 
										echo $this->Form->input('set_testimonial_image', array('type'=>'hidden','value'=>'','class'=>'set'));
									}
								?>
						</div>
						<?php
						}
						?>
						<!--<div class="col-md-12">
							<h4>Testimonial Date<span class="required">
							* </span>
							</h4>
								<?php 
									echo $this->Form->input('test_date', array(
															'type' => "text",
															'placeholder'=>"Enter Testimonial Date",
															'value' => (!empty($data1['TestimonialContent']['test_date']) && $dat1a['TestimonialContent']['test_date']!='0000-00-00')?date("d/m/Y",strtotime($data1['TestimonialContent']['test_date'])):'',
															'class' => "form-control form-filter input-sm date-picker"
															
															)); 
								?>
						</div>-->
				
						<div class="col-md-12">
							<h4>Select Status <span class="required">
							* </span>
							</h4>
									<?php  
										echo $this->Form->input('status', array(
																'options' => $statusArr,
																'empty' => 'Select Status',	
																'class' => 'form-control',
																'selected'=> (isset($data1['TestimonialContent']))?$data1['TestimonialContent']['status']:''
															));
									?>  
						</div>
					</div>
				</div>
			</div>	
		</div>	
		<div class="modal-footer">
				<?php echo $this->Form->submit('Submit', array('type' => 'submit', 'class'=>"btn blue",'div'=>false));?>
		</div>
	</div>
				<?php echo $this->Form->end(); ?>
				<!-- END FORM-->
</div>
<!-- END VALIDATION STATES-->


<script type="text/javascript">
$(function(){
	var form3 = $('#form_sample_4');
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
			'data[Testimonial][title]': {
				required: true
			},
			'data[Testimonial][heading]': {
				required: true
			},  
			'data[Testimonial][testimonial]': {
				required: true
			},
			'data[Testimonial][test_date]': {
				required: true
			},
			'data[Testimonial][testimonial_image]': {
				required: true
			},
			'data[Testimonial][status]': {
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
<script>
  CKEDITOR.replace( 'data[Testimonial][testimonial]' );
 </script>