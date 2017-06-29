<?php
$headerLayoutArr = array('header_layout_1'=>'Header Layout 1', 'header_layout_2'=>'Header Layout 2', 'header_layout_3'=>'Header Layout 3', 'header_layout_4'=>'Header Layout 4', 'header_layout_5'=>'Header Layout 5','custom-1'=>'Header Boxed Style', 'custom-2'=>'Header Iconic Style', 'custom-3'=>'Header IOS Style', 'custom-4'=>'Header Metro Style', 'custom-5'=>'Header Tab Style');

$headermenuArr = array('menu-1'=>'Header Menu Style : V1', 'menu-2'=>'Header Menu Style : V2', 'menu-3'=>'Header Menu Style : V3', 'menu-4'=>'Header Menu Style : V4', 'menu-5'=>'Header Menu Style : V5');
$stickyheaderArr = array('yes'=>'Yes','no'=>'No');
$boxlayoutArr = array('yes'=>'Yes','no'=>'No');
$shadowArr = array('v0'=>'No Shadow', 'v1'=>'Shadow Style 1', 'v2'=>'Shadow Style 2', 'v3'=>'Shadow Style 3', 'v4'=>'Shadow Style 4', 'v5'=>'Shadow Style 5');

$bgtype = array('P'=>'Pattern', 'I'=>'Image');

if(!empty($themepatten)){
	$patternArr = array();
	foreach($themepatten as $bgpat){
		$patternArr[$bgpat] = $this->Html->image(IMGPATH.'bgfilename/'.$bgpat, array('alt'=>'', 'class'=>'img-responsive'));
	}
} else {
	$patternArr = array();
}

if(!empty($themebg)){
	$backgroundArr = array();
	foreach($themebg as $bgimg){
		$backgroundArr[$bgimg] = $this->Html->image(IMGPATH.'bgfilename/'.$bgimg, array('alt'=>'', 'class'=>'img-responsive'));
	}
} else {
	$backgroundArr = array();
}

//pr($backgroundArr);
//pr($patternArr);
//pr($data);
?>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-table"></i> Add New Background
		</div>
	</div>
	<div class="portlet-body form">
		<?php echo $this->Form->create('ThemeBackground', array('url'=>array('controller'=>'Backgrounds','action' => 'back_ground/'.$id), 'id'=>"form_sample_3", 'class'=>"horizontal-form", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<div class="form-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Background Type <span class="required"> </span> </label>
						<?php 
							echo $this->Form->input('bgtype', array(
													'empty'=>'Select Type',
													'options'=>$bgtype,
													'class'=>'form-control',
													'selected'=> (isset($background_type))?$background_type:''
												)
											); 
						?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>File <span class="required"> </span> </label>
						<br />
						<?php if(!empty($background_image)){ echo $this->Html->image(IMGPATH.'bgfilename/'.$background_image, array('alt'=>'Image','height'=>40, 'width'=>40));
						echo "&nbsp;";
						echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array('controller'=>'Backgrounds', 'action'=>'admin_imgdelete/'.$background_id), array('escape'=>false, 'confirm' => 'Do you really want to delete this Image?', 'full_base'=>true, 'class'=>'btn default btn-xs red'));
						
						}
						else {
						echo $this->Form->input('bgfilename', array('type'=>'file', 'class'=>'form-control', 'id'=>"bgfilename")); } 
						
						echo '<p>Recomanded Size (1920 x 1430) in pixel</p>';
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="form-actions fluid">
			<div class="col-md-offset-5 col-md-6">
				<?php echo $this->Form->button('Save', array('type' => 'submit', 'class'=>"btn blue"));?>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
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
			'data[ThemeSetting][header_layout]': {
				required: true
			},
			'data[ThemeSetting][header_menu_style]': {
				required: true
			},
			'data[ThemeSetting][shadow_style]': {
				required: true
			},
			'data[ThemeSetting][sticky_header]': {
				required: true
			},
			'data[ThemeSetting][box_layout]': {
				required: true
			},
			'data[ThemeBackground][bgtype]': {
				required: true
			},
			'data[ThemeBackground][bgfilename]': {
				required: true
			},
			'data[ThemeBackground][filename][]': {
				required: true
			}
		},
		errorPlacement: function (error, element) { // render error placement for each input type
			error.insertAfter(element); // for other inputs, just perform default behavior
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
	
	$('.bgradio').click(function(){
		var radioval = $(this).val();
		$('.radioOptDiv').hide();
		$('#'+radioval+'Div').show();
	});
	
	if($('input[name="data[ThemeSetting][background_type]"]').is(':checked')){
		var radioval = $('input[name="data[ThemeSetting][background_type]"]').val();
		$('#'+radioval+'Div').show();
	} else {
		$('.radioOptDiv').hide();
	}
	
	
});
</script>

	