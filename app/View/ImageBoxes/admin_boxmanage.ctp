<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	//pr($data); exit;
?>
<style>
#cke_1_contents {
  height: 100px !important;
}
</style>
<?php
	$popupArr = array('Y'=>'Yes','N'=>'No');
	//pr($data); exit;
?>
<div class="modal-dialog">
	<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h2 class="modal-title"><?php if($id!=''){ ?>Edit<?php }else{ ?> Add<?php } ?> Image Box Content</h2>
			</div>
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('ImageBox', array('action' => 'admin_boxmanageupdate/'.$image_box_id.'/'.$id, 'id'=>"form_sample_2", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
				
				<?php
					if(empty($id)){
						echo $this->Form->input('date_created', array('type'=>'hidden','value'=>date('Y-m-d')));
					} else {
						echo $this->Form->input('date_modified', array('type'=>'hidden','value'=>date('Y-m-d')));
					}
				?>
	
			<div class="modal-body">
				<div class="scroller" data-always-visible="1" data-rail-visible1="1">
					<div class="row">
						<div class="col-md-12">
					<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
					<?php echo $this->Form->input('image_box_id',array("type"=>"hidden","label"=>false,"value"=> $image_box_id)); ?>
					
					
					<?php
						/* if($style == 'style3')
						{ */
					?>
					
							<!--<div class="col-md-12">
								<h4>Style<span class="required">
								* </span>
								</h4>-->
								
									<?php 
									
										/* $styles = explode(",",$data_id['Tabs']['name']);
										foreach($styles as $style)
										{
											$aa[$style]=$style;
										}
									
							
										echo $this->Form->input('category',
																array('options'=>$aa, 
																	  'default'=>'', 
																	  'data-required'=>1, 
																	  'class'=>"form-control",
																	  'id' =>'styler',
																	  'disabled'=>(isset($data['TabContent']))?'true':'false',
																	  'selected'=> (isset($data['TabContent']))?$data['TabContent']['category']:'')
																); */
									  ?>
							<!--</div>-->
							
							
					
					<?php
						//}
					?>
						<div class="col-md-12">
								<h4>Image<span class="required"> </span></h4>
								<?php
									
										
										if(!empty($data1['ImageBoxContent']['image']))
										{
										echo $this->Html->image(IMGPATH.'box_image/thumb/'.$data1['ImageBoxContent']['image'], array('alt'=>'Image'));
										
										echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array(
											'controller'=>'ImageBoxes',
											'action'=>'admin_imgdelete',
											'image_name'=>$data1['ImageBoxContent']['image'],
											'id'=>$id,
											'mid'=>$image_box_id
										), 
										array('confirm' => 'Are you Sure?', 'escape'=>false, 'full_base'=>true, 'class'=>'btn default btn-xs red')
										);
										}
										if(!empty($data1['ImageBoxContent']['image'])){
											$value=$data1['ImageBoxContent']['image'];
										}else {
											$value='';
										
										}
										echo $this->Form->input('set_image', array('type'=>'hidden','value'=>$value));
										
										echo $this->Form->input('image', array(
															'type' => "file"
														));  
										echo " &nbsp "."<font color='red'>(Recommended Size 768 x 512)</font>"; 
										
									
								?>
								<?php /*  echo $this->Form->input('image',array('value'=>(isset($data1['ImageBoxContent']))?$data1['ImageBoxContent']['image']:'',  'data-required'=>1, 'class'=>"form-control", 'enctype'=>"multipart/form-data"));  */ ?>
						</div>
						
						
						<div class="col-md-12">
								<h4>Title<span class="required"> * </span></h4>
								<?php echo $this->Form->input('title',array('value'=>(isset($data1['ImageBoxContent']))?$data1['ImageBoxContent']['title']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Title", 'type'=>"text")); ?>
						</div>
						
						
						<div class="col-md-12">
								<h4>Content<span class="required">  </span></h4>
								<?php echo $this->Form->input('content',array('value'=>(isset($data1['ImageBoxContent']))?$data1['ImageBoxContent']['content']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Content", 'type'=>"textarea")); ?>
						</div>
						
						<div class="col-md-12">
								<h4>Link<span class="required"> * </span></h4>
								<?php echo $this->Form->input('link',array('value'=>(isset($data1['ImageBoxContent']))?$data1['ImageBoxContent']['link']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Read More Link", 'type'=>"text")); ?>
						</div>
						
						
						
						<div class="col-md-12">
								<h4>Popup<span class="required"> * </span></h4>
									<?php  
										echo $this->Form->input('popup', array(
																'options' => $popupArr,
																'empty' => 'Select Status',	
																'class' => 'form-control',
																'selected'=> (isset($data1['ImageBoxContent']))?$data1['ImageBoxContent']['popup']:''
															));
									?>  
						</div>
						
						
						
						<div class="col-md-12">
								<h4>Status<span class="required"> * </span></h4>
									<?php  
										echo $this->Form->input('status', array(
																'options' => $statusArr,
																'empty' => 'Select Status',	
																'class' => 'form-control',
																'selected'=> (isset($data1['ImageBoxContent']))?$data1['ImageBoxContent']['status']:''
															));
									?>  
						</div>
						
						</div>
					</div>
				</div>
			</div>	
			<div class="modal-footer">
				<?php echo $this->Form->button('Submit', array('type' => 'submit', 'class'=>"btn blue"));?>
			</div>
				<?php echo $this->Form->end(); ?>
				<!-- END FORM-->
			</div>
			<!-- END VALIDATION STATES-->
		</div>


<script type="text/javascript">
$(function(){
	var form3 = $('#form_sample_2');
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
		ignore: "data[ImageBox][set_image]", // validate all fields including form hidden input
		rules: {
			
			'data[ImageBox][title]': {
				required: true
			},
			'data[ImageBox][popup]': {
				required: true
			},
			'data[ImageBox][status]': {
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
  CKEDITOR.replace( 'data[ImageBox][content]' );
 </script>