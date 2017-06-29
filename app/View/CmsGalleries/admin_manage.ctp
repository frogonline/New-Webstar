<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	//$sliderTypeArr = array('1'=>'Revolution Slider','2'=>'Normal Slider');
	$style = array('1'=>'Background Image','2'=>'Video','3'=>'Call To Action');
	//pr($data);exit;
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
				<div class="form-body">
					<div class="row">
						<div class="col-md-12">
							<h2>Slider Type : <?php echo $sliderTypeArr[$data['CmsGallery']['style']]; ?></h2>
						</div>
					</div>
					<div class="row">
					<?php 
					//pr($data); 
					if(!empty($data['CmsBanner'])){
						foreach($data['CmsBanner'] as $slider){
						?>
						<div class="col-md-4">
							<div class="note note-warning">
							<?php
							if(!empty($slider['banner_image'])){
								echo "<h4>Banner Background Image</h4>";
								echo $this->Html->image(IMGPATH.'banner_image/thumb/'.$slider['banner_image'], array('alt'=>'Slider'));
								echo "&nbsp;";
								echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array('controller'=>'CmsGalleries', 'action'=>'admin_bannerimgdelete/'.$slider['id'].'/'.$data['CmsGallery']['id']), array('escape'=>false, 'confirm' => 'Do you really want to delete this Image?', 'full_base'=>true, 'class'=>'btn default btn-xs red'));
							} else {
								echo $this->Html->image(IMGPATH.'cms_banner_image/no-image-found.jpg', array('alt'=>'Slider'));
							}
							
							if(!empty($slider['banner_back_image'])){
								echo "<h4 style='margin:10px 0 10px 0;'>Banner Foreground Image</h4>";
								echo $this->Html->image(IMGPATH.'banner_back_image/thumb/'.$slider['banner_back_image'], array('alt'=>'Slider'));
								echo "&nbsp;";
								echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array('controller'=>'CmsGalleries', 'action'=>'admin_bannerimgdeleteback/'.$slider['id'].'/'.$data['CmsGallery']['id']), array('escape'=>false, 'confirm' => 'Do you really want to delete this Image?', 'full_base'=>true, 'class'=>'btn default btn-xs red'));
							}
							?>
							<div style="margin:10px 0 0 0;">
							<?php
							echo $this->Html->link('<i class="fa fa-edit"></i> Edit Slide', 'javascript:void(0);', array(
									'escape'=>false,
									'data-sliderid'=>$slider['id'],
									'data-galleryid'=>$data['CmsGallery']['id'],
									'class'=>'btn blue editSlide'
								)
							);
							?>
							<?php echo $this->Html->link('<i class="fa fa-trash-o"></i> Remove Row', array('controller'=>'CmsGalleries','action'=>'admin_removerow/'.$slider['id'].'/'.$data['CmsGallery']['id']), array('escape'=>false,'class'=>"btn red remove", 'confirm' => 'Do you really want to delete this Row?', 'data-id'=>'#div_'.$id, 'onclick'=>'return remove_div(this);')); ?>
							</div>
							</div>
						</div>
						<?php
						}
					}
					?>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="pull-right">
							<?php
							echo $this->Html->link('<i class="fa fa-plus"></i> Add Slide', 'javascript:void(0);', array(
									'escape'=>false,
									'data-gallerytype'=>$data['CmsGallery']['style'],
									'data-galleryid'=>$data['CmsGallery']['id'],
									'class'=>'btn green addSlide'
								)
							);
							?>	
							</div>
						</div>
					</div>
				</div>
				<div class="form-actions fluid">
					<div class="col-md-offset-3 col-md-9">
						<?php echo $this->Form->button('Close', array('type' => 'reset','onclick'=>'window.history.back()', 'class'=>"btn default",'div'=>false));?>
					</div>
				</div>
				<!-- END FORM-->
			</div>
			<!-- END VALIDATION STATES-->
		</div>
	</div>
</div>
<div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true"></div>
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
	
	/******* Edit Slide ********/
	$('.editSlide').click(function(e){
		e.preventDefault();
		var slideId = $(this).attr('data-sliderid');
		var galleryId = $(this).attr('data-galleryid');
		if((slideId.trim()!="") && (galleryId.trim()!="")){
			$.ajax({
				type:'POST',
				url:'<?php echo $this->Html->url(array('controller'=>'CmsGalleries', 'action'=>'admin_editslideform', 'full_base'=>true)); ?>',
				data:{slideId:slideId, galleryId:galleryId},
				success:function(result){
					$('#responsive').html(result);
					$('#responsive').modal('show');
				}
			});
		}
	});
	/******* Edit Slide ********/
	
	/******* Add Slide ********/
	$('.addSlide').click(function(e){
		e.preventDefault();
		var galleryType = $(this).attr('data-gallerytype');
		var galleryId = $(this).attr('data-galleryid');
		if((galleryType.trim()!="") && (galleryId.trim()!="")){
			$.ajax({
				type:'POST',
				url:'<?php echo $this->Html->url(array('controller'=>'CmsGalleries', 'action'=>'admin_addslideform', 'full_base'=>true)); ?>',
				data:{galleryType:galleryType, galleryId:galleryId},
				success:function(result){
					$('#responsive').html(result);
					$('#responsive').modal('show');
				}
			});
		}
	});
	/******* Add Slide ********/
	
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