<?php
	$social_flagArr = array('Y'=>'Yes','N'=>'No');
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h2>Edit Slide</h2>
		</div>
		<!-- BEGIN FORM-->
		<?php echo $this->Form->create('CmsBanner', array('url'=>array('controller'=>'CmsGalleries', 'action'=>'admin_manageslide'),'id'=>"addColumnsForm", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<div class="modal-body">
			<div class="scroller" data-always-visible="1" data-rail-visible1="1">
				<div class="row">
					<?php 
						echo $this->Form->input('gallery_id',array("type"=>"hidden", "value"=>$reqdata['galleryId']));
						echo $this->Form->input('id',array("type"=>"hidden", "value"=>(array_key_exists('slideId', $reqdata))?$reqdata['slideId']:''));
					?>
					<div class="col-md-12">
						<h4>Banner Background Image<span class="required"> * </span></h4>
						<?php
						if(!empty($data['CmsBanner']['banner_image'])){
							echo $this->Html->image(IMGPATH.'banner_image/thumb/'.$data['CmsBanner']['banner_image'], array('alt'=>'Slider'));
						} else {
							echo $this->Form->input('banner_image',array('data-required'=>1, 'class'=>"form-control", 'type'=>"file", 'label'=>false, 'div'=>false));
						}
						?>
						<p>Recomanded Size (960 x 562) in pixel</p>
					</div>
				</div>
				
				<?php
				if($data['CmsBanner']['rev_slider_type']!=0){
					if($data['CmsBanner']['rev_slider_type']==1){
				?>
					<div id="rev_1" data-mode="on">
						<div class="row">		
							<div class="col-md-12">
								<h4>Banner Foreground Image<span class="required"> * </span> </h4>
								<?php 
								if(!empty($data['CmsBanner']['banner_back_image'])){
									echo $this->Html->image(IMGPATH.'banner_back_image/thumb/'.$data['CmsBanner']['banner_back_image'], array('alt'=>'Slider'));
								} else {
									echo $this->Form->input('banner_back_image',array('data-required'=>1, 'class'=>"form-control", 'type'=>"file", 'label'=>false, 'div'=>false));
								}
								?>
							</div>
						</div>
					</div>
					<?php } else if($data['CmsBanner']['rev_slider_type']==2) { ?>
					<div id="rev_2" data-mode="on">		
						<div class="row">		
							<div class="col-md-12">
								<h4>Video Link<span class="required"> * </span> </h4>
								<?php 
								echo $this->Form->input('rev_video_link',array('value'=>(isset($data['CmsBanner']['rev_video_link']))?$data['CmsBanner']['rev_video_link']:'','data-required'=>1, 'class'=>"form-control",'type'=>"textarea", 'label'=>false, 'div'=>false));
								?>
							</div>
						</div>
					</div>
					<?php } else if($data['CmsBanner']['rev_slider_type']==3) { ?>
					<div id="rev_3" data-mode="on">
						
						<div class="row">		
							<div class="col-md-12">
								<h4>Text Heading </h4>
								<?php 
									echo $this->Form->input('detailheading',array('value'=>(isset($data))?$data['CmsBanner']['detailheading']:'','data-required'=>1, 'class'=>"form-control", 'type'=>"text", 'label'=>false, 'div'=>false));
								?>
							</div>
						</div>
						<div class="row">		
							<div class="col-md-12">
								<h4>Text Description </h4>
								<?php 
									echo $this->Form->input('banner_text',array('value'=>(isset($data))?$data['CmsBanner']['banner_text']:'','data-required'=>1, 'class'=>"form-control", 'type'=>"text", 'label'=>false, 'div'=>false));
								?>
							</div>
						</div>
						<div class="row">		
							<div class="col-md-12">
								<h4>Call To Action Text  </h4>
								<?php 
									echo $this->Form->input('button_text',array('value'=>(isset($data))?$data['CmsBanner']['button_text']:'','data-required'=>1, 'class'=>"form-control", 'type'=>"text", 'label'=>false, 'div'=>false));
								?>
							</div>
						</div>
						<div class="row">		
							<div class="col-md-12">
								<h4>Call To Action Link  </h4>
								<?php 
									echo $this->Form->input('button_link',array('value'=>(isset($data))?$data['CmsBanner']['button_link']:'','data-required'=>1, 'class'=>"form-control", 'type'=>"text", 'label'=>false, 'div'=>false));
								?>
							</div>
						</div>
					</div>
					<?php } ?>
				<?php } else { ?>
				<div class="row">		
					<div class="col-md-12">
						<h4>Banner Link </h4>
						<?php 
							echo $this->Form->input('banner_link',array('value'=>(isset($data))?$data['CmsBanner']['banner_link']:'','data-required'=>1, 'class'=>"form-control", 'type'=>"text", 'label'=>false, 'div'=>false));
						?>
					</div>
				</div>
				<?php } ?>
				
			</div>
			<div class="row">		
							<div class="col-md-12">
								<h4>Target Blank </h4>
								<?php
							echo $this->Form->input('target', array(
									'options'=>$social_flagArr,
									'value'=>(!empty($data))?$data['CmsBanner']['target']:'',
									'type'=>'radio',
									'before' => '<label class="col-md-3">',
									'after' => '</label>',
									'separator' => '</label><label class="col-md-3">',
									'legend'=>false,
									'hiddenField'=>false
								)
							);
							?>
							</div>
						</div>
		</div>	
		<div class="modal-footer">
			<?php 
				echo $this->Form->button('Submit', array('type' => 'submit', 'class'=>"btn blue"));
			?>
		</div>
		<?php echo $this->Form->end(); ?>
		<!-- END FORM-->
	</div>
	<!-- END VALIDATION STATES-->
</div>
<script type="text/javascript">
$(document).ready(function() {
	$('.resliderDiv').hide();
	$('.resliderDiv').attr('data-mode', "off");
	$('#rev_slider_type').change(function(){
		var val = $(this).val();
		$('.resliderDiv').hide();
		$('.resliderDiv').attr('data-mode', "off");
		$('#rev_'+val).show();
		$('#rev_'+val).attr('data-mode', "on");
	});
	
	
	var form3 = $('#addColumnsForm');
	var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
		
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "", // validate all fields including form hidden input
		rules: {
			'data[CmsBanner][banner_image]': {
				required: true
			},
			'data[CmsBanner][rev_slider_type]': {
				required: true
			},
			/*'data[CmsBanner][banner_link]': {
				required: true
			},  */
			'data[CmsBanner][banner_back_image]': {
				required: function(element){
					var status = $('#rev_1').attr('data-mode');
					if(status=="off"){
						return false;
					} else {
						return true;
					}
				}
			},
			'data[CmsBanner][rev_video_link]': {
				required: function(element){
					var status = $('#rev_2').attr('data-mode');
					if(status=="off"){
						return false;
					} else {
						return true;
					}
				}
			},
			/*'data[CmsBanner][banner_text]': {
				required: function(element){
					var status = $('#rev_3').attr('data-mode');
					if(status=="off"){
						return false;
					} else {
						return true;
					}
				}
			},
			'data[CmsBanner][detailheading]': {
				required: function(element){
					var status = $('#rev_3').attr('data-mode');
					if(status=="off"){
						return false;
					} else {
						return true;
					}
				}
			},
			'data[CmsBanner][button_text]': {
				required: function(element){
					var status = $('#rev_3').attr('data-mode');
					if(status=="off"){
						return false;
					} else {
						return true;
					}
				}
			},
			'data[CmsBanner][button_link]': {
				required: function(element){
					var status = $('#rev_3').attr('data-mode');
					if(status=="off"){
						return false;
					} else {
						return true;
					}
				}
			}*/
		},
		errorPlacement: function (error, element) { // render error placement for each input type
			if (element.attr("data-error-container")) { 
				error.appendTo(element.attr("data-error-container"));
			} else {
				error.insertAfter(element); // for other inputs, just perform default behavior
			}
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