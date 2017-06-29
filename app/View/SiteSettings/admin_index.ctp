<?php
$blogtemplateArr = array(
					'blogclassicfw'=>'Blog Classic Full Width',
					'blogclassicsl'=>'Blog Classic Sidebar-L',
					'blogclassicsr'=>'Blog Classic Sidebar-R',
					'blogthumbfw'=>'Blog Thumbnail Full Width',
					'blogthumbsl'=>'Blog Thumbnail Sidebar-L',
					'blogthumbsr'=>'Blog Thumbnail Sidebar-R',
					'bloggrid4c'=>'Blog Grid 4 Columns',
					'bloggrid3c'=>'Blog Grid 3 Columns',
					'bloggrid2c'=>'Blog Grid 2 Columns',
					'bloggridsr'=>'Blog Grid Sidebar-R',
					'bloggridsl'=>'Blog Grid Sidebar-L',
					'timeline'=>'Blog Timeline Full Width',
					'timelinesr'=>'Blog Timeline Sidebar-R',
					'timelinesl'=>'Blog Timeline Sidebar-L'
				);
				
$blogdetailtemplateArr = array(
					'N'=>"No Sidebar",
					'L'=>"Left Sidebar",
					'R'=>"Right Sidebar",
				);
$ecommerce_flagArr = array('Y'=>'Yes','N'=>'No');
$social_flagArr = array('Y'=>'Yes','N'=>'No');
$currentModelPer=$this->Session->read('currentModelPer');
//pr($currentModelPer);
?>
<?php
if($currentModelPer['edit']=='Y')
{
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i> Edit Site Setting
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('SiteSetting', array('action' => 'admin_index/', 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
					  <?php echo $this->Form->input('id',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['id']:'', 'type' => 'hidden'));?>
						<h3 class="form-section"> Meta Data</h3>
						<div class="form-group">
							<label class="control-label col-md-3">Meta Title <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('meta_title',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['meta_title']:'', 'id'=>"meta_title", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Meta Title", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Meta Keywords <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('meta_keywords',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['meta_keywords']:'', 'id'=>"meta_keywords", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Meta keywords", 'type'=>"textarea")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Meta Description <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('meta_des',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['meta_des']:'', 'id'=>"meta_des", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Meta Description", 'type'=>"textarea")); ?>
							</div>
						</div>
						<h3 class="form-section">Text Content Register page</h3>
						<div class="form-group">
							<label class="control-label col-md-3">Title<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('re_title',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['re_title']:'', 'id'=>"re_title", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Title", 'type'=>"text")); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Description<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
						<?php echo $this->Form->input('re_des',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['re_des']:'', 'id'=>"re_des", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Description", 'type'=>"textarea")); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Button Text<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('re_button_text',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['re_button_text']:'', 'id'=>"re_button_text", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Button Text", 'type'=>"text")); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Button Link<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('re_button_link',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['re_button_link']:'', 'id'=>"re_button_link", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Button Link", 'type'=>"text")); ?>
							</div>
						</div>
						<h3 class="form-section">Controls</h3>
						<div class="form-group">
							<label class="control-label col-md-3">Company Name <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('com',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['com']:'', 'id'=>"com", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Company Name", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Website <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('website',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['website']:'', 'id'=>"website", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Website", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Admin Email <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('admin_email',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['admin_email']:'', 'id'=>"admin_email", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Admin Email", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Contact Email <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('cc_email',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['cc_email']:'', 'id'=>"cc_email", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Contact Email", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">ABN No<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('abn',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['abn']:'', 'id'=>"abn", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter ABN No", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Phone No <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('phone',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['phone']:'', 'id'=>"phone", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Phone No", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Fax  <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('fax',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['fax']:'', 'id'=>"fax", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Fax ", 'type'=>"text")); ?>
							</div>
						</div>
						
						<!---<div class="form-group">
							<label class="control-label col-md-3">Facebook  <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php/*  echo $this->Form->input('facebook',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['facebook']:'', 'id'=>"facebook", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Facebook Url ", 'type'=>"text")); */ ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Twitter <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php /* echo $this->Form->input('twitter',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['twitter']:'', 'id'=>"twitter", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Twitter url", 'type'=>"text")); */ ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Google Plus <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php/*  echo $this->Form->input('googleplus',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['googleplus']:'', 'id'=>"googleplus", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Google Plus url", 'type'=>"text")); */ ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Linkedin <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php /* echo $this->Form->input('linkedin',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['linkedin']:'', 'id'=>"linkedin", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Linkedin url", 'type'=>"text")); */ ?>
							</div>
						</div>
						----->
						<div class="form-group">
							<label class="control-label col-md-3">Call Us <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('callus',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['callus']:'', 'id'=>"callus", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Call Us", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
						<label class="control-label col-md-3">Enable social plugin<span class="required">
							* </span>
						</label>
						<div class="col-md-5">
							<?php
							echo $this->Form->input('social_plugin', array(
									'options'=>$social_flagArr,
									'value'=>(!empty($data))?$data['SiteSetting']['social_plugin']:'',
									'type'=>'radio',
									'data-error-container'=>'#customerror_div',
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
						
						
						<div class="form-group">
							<label class="control-label col-md-3">Site Setting Logo <span class="required">*</span></label>
							<div class="col-md-8">
								<?php
									if(!empty($data['SiteSetting']['logo'])){
										echo '<div class="col-md-3">';
										echo $this->Html->image(IMGPATH.'site_settings_logo/original/'.$data['SiteSetting']['logo'], array('alt'=>'Image', 'class'=>'img-responsive'));
										echo '</div>';
										echo '<div class="col-md-4">';
										echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array(
											'controller'=>'SiteSettings',
											'action'=>'admin_imgdelete',
											'image_name'=>$data['SiteSetting']['logo'],
											'id'=>$data['SiteSetting']['id']
										), 
										array('confirm' => 'Are you Sure?', 'escape'=>false, 'full_base'=>true, 'class'=>'btn default btn-xs red')
										);
										echo '</div>';
										echo $this->Form->input('set_logo', array('type'=>'hidden','value'=>$data['SiteSetting']['logo'],'class'=>'set'));
									} else {
										echo $this->Form->input('logo', array(
															'type' => "file"
														));  
										echo " &nbsp "."<font color='red'>(Recommended Size 560 x 480)</font>"; 
									} 
								?>
							</div>
						</div>
						<!----
						<div class="form-group">
							<label class="control-label col-md-3">Footer Logo <span class="required">*</span></label>
							<div class="col-md-8">
								<?php 
									/* if(!empty($data['SiteSetting']['footer_logo'])){
										echo '<div class="col-md-3">';
										echo $this->Html->image(IMGPATH.'footer_logo/original/'.$data['SiteSetting']['footer_logo'], array('alt'=>'Image', 'class'=>'img-responsive'));
										echo '</div>';
										echo '<div class="col-md-4">';
										echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array(
											'controller'=>'SiteSettings',
											'action'=>'footer_logo_delete',
											'image_name'=>$data['SiteSetting']['footer_logo'],
											'id'=>$data['SiteSetting']['id']
										), 
										array('confirm' => 'Are you Sure?', 'escape'=>false, 'full_base'=>true, 'class'=>'btn default btn-xs red')
										);
										echo '</div>';
										echo $this->Form->input('set_footer_logo', array('type'=>'hidden','value'=>$data['SiteSetting']['footer_logo'],'class'=>'set'));
									} else {
										echo $this->Form->input('footer_logo', array(
															'type' => "file"
														));  
										echo " &nbsp "."<font color='red'>(Recommended Size 233 x 64)</font>"; 
									}  */
								?>
							</div>
						</div> --->
						<!--
						<div class="form-group">
							<label class="control-label col-md-3">Admin Logo <span class="required">*</span></label>
							<div class="col-md-8">
								<?php
									/* if(!empty($data['SiteSetting']['admin_logo'])){
										echo '<div class="col-md-3">';
										echo $this->Html->image(IMGPATH.'admin_logo/original/'.$data['SiteSetting']['admin_logo'], array('alt'=>'Image','class'=>'img-responsive'));
										echo '</div>'; */
										/* echo '<div class="col-md-4">';
										echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array(
											'controller'=>'SiteSettings',
											'action'=>'admin_imgdelete1',
											'image_name'=>$data['SiteSetting']['admin_logo'],
											'id'=>$data['SiteSetting']['id']
										), 
										array('confirm' => 'Are you Sure?', 'escape'=>false, 'full_base'=>true, 'class'=>'btn default btn-xs red')
										);
										echo '</div>'; */
										/* echo $this->Form->input('set_admin_logo', array('type'=>'hidden','value'=>$data['SiteSetting']['admin_logo'],'class'=>'set'));
									} else {
										echo $this->Form->input('admin_logo', array(
															'type' => "file"
														));  
										echo " &nbsp "."<font color='red'>(Recommended Size 560 x 480)</font>"; 
									}  */
								?>
							</div>
						</div>
						--->
						<div class="form-group">
							<label class="control-label col-md-3">Address <span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<?php echo $this->Form->input('address',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['address']:'', 'id'=>"address", 'data-required'=>1, 'class' => "ckeditor form-control",'data-error-container'=>'#editor2_error', 'placeholder'=>"Enter Address", 'type'=>"textarea")); ?>
								<div id="editor2_error"></div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Google Analytics<span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<?php echo $this->Form->input('anlytics_code',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['anlytics_code']:'', 'id'=>"anlytics_code", 'data-required'=>1, 'class' => "form-control",'data-error-container'=>'#editor2_error', 'placeholder'=>"Enter Google Analytics", 'type'=>"textarea")); ?>
								<div id="editor2_error"></div>
							</div>
						</div>
						
						
						
						<div class="form-group">
							<label class="control-label col-md-3">Thin Footer Left Section <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('copyright',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['copyright']:'', 'id'=>"copyright", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter copyright", 'type'=>"textarea")); ?>
							</div>
						</div>
						<!---
						<div class="form-group">
							<label class="control-label col-md-3">Admin Copyright <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
								/* if(empty($data['SiteSetting']['admin_copyright']))
								{ */
								?>
									<?php /* echo $this->Form->input('admin_copyright',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['admin_copyright']:'', 'id'=>"copyright", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Admin copyright", 'type'=>"textarea",)); */ ?>
								<?php
								//}
								//else
								//{
								?>
									<?php /* echo $this->Form->input('admin_copyright',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['admin_copyright']:'', 'id'=>"copyright", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Admin copyright", 'type'=>"textarea",'readonly'=>'readonly')); */ ?>
								<?php 
								//}
								?>
							</div>
						</div>
						--->
					<!--	<div class="form-group">
							<label class="control-label col-md-3">Google Map <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php /* echo $this->Form->input('google_map',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['google_map']:'', 'id'=>"google_map", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Google Map", 'type'=>"textarea")); */ ?>
							</div>
						</div>
						-->
						<!---
						<div class="form-group">
							<label class="control-label col-md-3">Facebook Like Box <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php /* echo $this->Form->input('likebox_url',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['likebox_url']:'', 'id'=>"likebox_url", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Google Map", 'type'=>"textarea")); */ ?>
							</div>
						</div> --->
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
							<?php echo $this->Form->button('Submit', array('type' => 'submit', 'class'=>"btn blue"));?>
							<?php echo $this->Form->button('Cancel', array('type' => 'reset', 'class'=>"btn default",'div'=>false));?>
						</div>
					</div>
				<?php echo $this->Form->end(); ?>
				<!-- END FORM-->
			</div>
			<!-- END VALIDATION STATES-->
		</div>
	</div>
</div>
<?php
}
?>
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
			'data[SiteSetting][meta_title]': {
				required: true
			},
			'data[SiteSetting][meta_keywords]': {
				required: true
			},  
			'data[SiteSetting][meta_des]': {
				required: true
			},
			'data[SiteSetting][re_title]': {
				required: true
			},
			'data[SiteSetting][re_des]': {
				required: true
			},
			'data[SiteSetting][re_button_text]': {
				required: true
			},
			'data[SiteSetting][re_button_link]': {
				required: true
			},
			'data[SiteSetting][com]': {
				required: true
			},
			'data[SiteSetting][website]': {
				required: true
			},
			'data[SiteSetting][admin_email]': {
				required: true
			},
			'data[SiteSetting][cc_email]': {
				required: true
			},
			'data[SiteSetting][abn]': {
				required: true
			},
			'data[SiteSetting][phone]': {
				required: true
			},
			'data[SiteSetting][fax]': {
				required: true
			},
			'data[SiteSetting][facebook]': {
				required: true
			},
			'data[SiteSetting][twitter]': {
				required: true
			},
			'data[SiteSetting][googleplus]': {
				required: true
			},
			'data[SiteSetting][linkedin]': {
				required: true
			},
			'data[SiteSetting][callus]': {
				required: true
			},
			'data[SiteSetting][logo]': {
				required: true
			},
			'data[SiteSetting][address]': {
				required: true
			},
			'data[SiteSetting][copyright]': {
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