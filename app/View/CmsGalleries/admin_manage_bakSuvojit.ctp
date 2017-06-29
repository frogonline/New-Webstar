<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$sliderTypeArr = array('1'=>'Revolution Slider','2'=>'Normal Slider');
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?> Gallery
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('CmsGallery', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
					<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
						
						<div class="form-group">
							<label class="control-label col-md-3">Gallery Title <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('gallery_name',array('value'=>(isset($data['CmsGallery']))?$data['CmsGallery']['gallery_name']:'', 'class'=>"form-control", 'placeholder'=>"Enter Gallery Title", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Gallery Style <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
									echo $this->Form->input('style',
														array(
															'empty'=>'Select Style',
															'options'=>$sliderTypeArr,
															'selected'=>(!empty($data))?$data['CmsGallery']['style']:'',
															'class'=>'form-control',
															'id'=>'gallery_style'
														)
													); 
								?>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12" id="myrow">
							<!--- Single Images Of the gallery --->
							<?php 
							$i=1; 
								
							if(!empty($id)){ 
								foreach($data['CmsBanner'] as $banner){
									
									/** Form Start Here **/
									echo $this->Form->input('banner_image_id', array('type'=>'hidden','name'=>'data[CmsBanner][id][]', 'value'=>$banner['id'])); 
							?>
									<div class="col-md-4" style="border:1px solid #4B8DF8; min-height:275px;" id="div_<?php echo $id; ?>">
										<div class="form-group" style="margin:10px 0 0 0;">
											<?php if(!empty($banner['banner_image'])){ ?>
												<img src="<?php echo IMGPATH.'cms_banner_image/thumb/'.$banner['banner_image']; ?>" alt="<?php echo $banner['banner_text']; ?>" />
											
												<?php echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array('controller'=>'CmsGalleries', 'action'=>'admin_bannerimgdelete/'.$banner['id'].'/'.$data['CmsGallery']['id']), array('escape'=>false, 'confirm' => 'Do you really want to delete this Image?', 'full_base'=>true, 'class'=>'btn default btn-xs red')); 
											
											} else { 
												echo $this->Form->input('banner_image',array('data-required'=>1, 'name'=>'data[CmsBanner][b_image][]', 'class'=>"form-control", 'type'=>"file", 'label'=>false, 'div'=>false));
											} 
											echo $this->Form->input('set_b_image', array('type'=>'hidden','name'=>'data[CmsBanner][set_b_image][]', 'value'=>(!empty($banner['banner_image']))?$banner['banner_image']:''));
											?>
										</div>
										<div class="form-group" style="margin:10px 0 0 0;">
											<?php if(!empty($banner['banner_back_image'])){ ?>
											<img src="<?php echo IMGPATH.'cms_banner_image/background/thumb/'.$banner['banner_back_image']; ?>" alt="<?php echo $banner['banner_text']; ?>" />
											<?php echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array('controller'=>'CmsGalleries', 'action'=>'admin_bannerimgdelete_back/'.$banner['id'].'/'.$data['CmsGallery']['id']), array('escape'=>false, 'confirm' => 'Do you really want to delete this Image?', 'full_base'=>true, 'class'=>'btn default btn-xs red')); 
											
											} else { 
												echo $this->Form->input('banner_background_image',array('data-required'=>1, 'name'=>'data[CmsBanner][b_back_image][]', 'class'=>"form-control", 'type'=>"file", 'label'=>false, 'div'=>false));
											} 
											echo $this->Form->input('set_b_back_image', array('type'=>'hidden','name'=>'data[CmsBanner][set_b_back_image][]', 'value'=>(!empty($banner['banner_back_image']))?$banner['banner_back_image']:''));
											?>
										</div>
										
										<div class="form-group" style="margin:10px 0 0 0;">
											<label>Banner Caption </label>
											<?php echo $this->Form->input('banner_text',array('value'=>(isset($banner['banner_text']))?$banner['banner_text']:'','name'=>'data[CmsBanner][banner_text][]', 'class'=>"form-control", 'type'=>"text", 'label'=>false, 'div'=>false)); ?>
										</div>
										<div class="form-group" style="margin:10px 0 0 0;">
											<label>Style 
											</label>
								
											<?php echo $this->Form->input('style', array('value'=>(isset($banner['style']))?$banner['style']:'','name'=>'data[CmsBanner][style][]','id'=>'select','options' => $st_value,'empty' => 'Select Style',	'class' => 'form-control'));?>  
										</div>
											
										<div class="form-group" style="margin:10px 0 0 0;">
											<label>Call To Action Text </label> 
											<?php echo $this->Form->input('actiontext',array('value'=>(isset($banner['actiontext']))?$banner['actiontext']:'','name'=>'data[CmsBanner][actiontext][]', 'class'=>"form-control", 'type'=>"text", 'label'=>false, 'div'=>false)); ?>
										</div>
										<div class="form-group" style="margin:10px 0 0 0;">
											<label>Call To Action Link </label> 
											<?php echo $this->Form->input('banner_link',array('value'=>(isset($banner['banner_link']))?$banner['banner_link']:'','name'=>'data[CmsBanner][banner_link][]', 'class'=>"form-control", 'type'=>"text", 'label'=>false, 'div'=>false)); ?>
										</div>	
								
										<div class="input-group" style="margin:10px 0;">
											<?php echo $this->Html->link('Remove Row',array('controller'=>'CmsGalleries','action'=>'admin_removerow/'.$banner['id'].'/'.$data['CmsGallery']['id']), array('class'=>"btn red remove", 'confirm' => 'Do you really want to delete this Row?', 'data-id'=>'#div_'.$id, 'onclick'=>'return remove_div(this);')); ?>
										</div>
									</div>
							<?php 
								} 
							}
							?>
							<!--- Single Images Of the gallery --->
							</div>
							<div class="col-md-3" style="margin:10px 0 0 0;">
								<?php echo $this->Form->button('Add Row', array('id' => 'add_row', 'class'=>"btn green", 'rel'=>'1'));?>
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
		
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "", // validate all fields including form hidden input
		rules: {
			'data[CmsGallery][gallery_name]': {
				required: true
			},
			'data[CmsGallery][style][]': {
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
	
	$('#add_row').click(function(e){
		var rel = $(this).attr('rel');
		var p = parseInt(rel) +1;
		$(this).attr('rel',p);
		e.preventDefault();
		var gallery_id = $('#gallery_style').val();
		if(gallery_id.trim()!=''){
			$.ajax({
				type:'POST',
				data:{gallery_id:gallery_id,id:rel},
				url:'<?php echo $this->Html->url(array('controller'=>'CmsGalleries', 'action'=>'admin_addrow','full_base'=>true)); ?>',
				success:function(result){
					$('#myrow').append(result);
				}
			});
		} else {
			alert('PLease select any gallery style.');
		}
	});
	
});
</script>