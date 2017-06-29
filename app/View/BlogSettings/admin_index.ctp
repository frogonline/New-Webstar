<?php
$ThemeSetting=$this->Session->read('ThemeSetting');
$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
if($ThemeSettingheadertype=='V'){
	$blogtemplateArr = array(
					'blogclassicsl'=>'Blog Classic Sidebar-L',
					'blogthumbsl'=>'Blog Thumbnail Sidebar-L',
					'bloggridsl'=>'Blog Grid Sidebar-L',
					'timelinesl'=>'Blog Timeline Sidebar-L'
				);

}else{
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
	}
if($ThemeSettingheadertype=='V'){
	$blogdetailtemplateArr = array(
					'L'=>"Left Sidebar",
				);

}else{	
$blogdetailtemplateArr = array(
					'N'=>"No Sidebar",
					'L'=>"Left Sidebar",
					'R'=>"Right Sidebar",
				);
}
$currentModelPer=$this->Session->read('currentModelPer');
$blog_flagArr = array('Y'=>'Yes','N'=>'No');
//pr($currentModelPer);
?>
<?php
if($currentModelPer['add']=='Y' || $currentModelPer['edit']=='Y')
{
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i> Edit Blog Setting
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('SiteSetting', array('url'=>array('controller'=>'BlogSettings','action' => 'admin_index/'), 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
					  <?php echo $this->Form->input('id',array('value'=>(isset($data['SiteSetting']))?$data['SiteSetting']['id']:'', 'type' => 'hidden'));?>
					  <div class="form-group">
							<label class="control-label col-md-3">Enable Blog<span class="required">* </span>
							</label>
							<div class="col-md-4">
								<?php
								echo $this->Form->input('blog_flag', array(
										'options'=>$blog_flagArr,
										'value'=>(!empty($data))?$data['SiteSetting']['blog_flag']:'',
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
							<label class="control-label col-md-3">Blog Template <span class="required">* </span>
							</label>
							<div class="col-md-4">
								<?php 
								echo $this->Form->input('blog_template', array(
										'options'=>$blogtemplateArr,
										'empty'=>'--- Select Layout ---',
										'class'=>'form-control',
										'selected'=>(!empty($data))?$data['SiteSetting']['blog_template']:''
									)
								); 
								
								?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Blog Detail Template <span class="required">* </span>
							</label>
							<div class="col-md-4">
								<?php 
								echo $this->Form->input('blogdetail_template', array(
										'options'=>$blogdetailtemplateArr,
										'empty'=>'--- Select Layout ---',
										'class'=>'form-control',
										'selected'=>(!empty($data))?$data['SiteSetting']['blogdetail_template']:''
									)
								); 
								
								?>
							</div>
						</div>
					
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
			'data[SiteSetting][blog_flag]': {
				required: true
			},
			'data[SiteSetting][blog_template]': {
				required: true
			},
			'data[SiteSetting][blogdetail_template]': {
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