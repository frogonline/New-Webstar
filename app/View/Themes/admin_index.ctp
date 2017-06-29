<?php
/* $headerLayoutArr = array('header_layout_1'=>'Header Layout 1', 'header_layout_2'=>'Header Layout 2', 'header_layout_3'=>'Header Layout 3', 'header_layout_4'=>'Header Layout 4', 'header_layout_5'=>'Header Layout 5','custom-1'=>'Header Boxed Style', 'custom-2'=>'Header Iconic Style', 'custom-3'=>'Header IOS Style', 'custom-4'=>'Header Metro Style', 'custom-5'=>'Header Tab Style');

$headermenuArr = array('menu-1'=>'Header Menu Style : V1', 'menu-2'=>'Header Menu Style : V2', 'menu-3'=>'Header Menu Style : V3', 'menu-4'=>'Header Menu Style : V4', 'menu-5'=>'Header Menu Style : V5');*/
$stickyheaderArr = array('yes'=>'Yes','no'=>'No'); 
$boxlayoutArr = array('yes'=>'Yes','no'=>'No');
$shadowArr = array('v0'=>'No Shadow', 'v1'=>'Shadow Style 1', 'v2'=>'Shadow Style 2', 'v3'=>'Shadow Style 3', 'v4'=>'Shadow Style 4', 'v5'=>'Shadow Style 5');

$headertype = array('H'=>'Horizontal', 'V'=>'Vertical');
$bgtype = array('P'=>'Pattern', 'I'=>'Image');
  
$fontfamilyArr = array(
				'"Open Sans", sans-serif'=>'Open Sans, sans-serif', 
				'Georgia, serif'=>'Georgia, serif',
				'"Palatino Linotype", "Book Antiqua", Palatino, serif'=>'Palatino Linotype, Book Antiqua, Palatino, serif',
				'"Times New Roman", Times, serif'=>'Times New Roman, Times, serif',
				'Arial, Helvetica, sans-serif'=>'Arial, Helvetica, sans-serif',
				'"Arial Black", Gadget, sans-serif'=>'Arial Black, Gadget, sans-serif',
				'Impact, Charcoal, sans-serif'=>'Impact, Charcoal, sans-serif',
				'"Lucida Sans Unicode", "Lucida Grande", sans-serif'=>'Lucida Sans Unicode, Lucida Grande, sans-serif',
				'Tahoma, Geneva, sans-serif'=>'Tahoma, Geneva, sans-serif',
				);
$datasiteArrb=array('normal'=>'Normal','bold'=>'Bold');
				
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

<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i><?php echo (isset($data))?'Edit':'Add' ?> Themes
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<div class="form-horizontal">
				<?php //echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_index'), 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); 
				
				if(!empty($data)){
					echo $this->Form->input('theme_id',array("type"=>"hidden","label"=>false, 'id'=>'theme_id', "value"=>$data['ThemeSetting']['theme_id']));
				}
				?>
					<div class="form-body">
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetheader/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_1', 'onsubmit'=>'return confirm("Do you want to reset?");', 'class'=>'note note-info', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<h3>Header Section</h3>
						<div class="form-group">
							<label class="control-label col-md-3">Header Type <span class="required">* </span>
							</label>
							<div class="col-md-4">
								<?php 
								echo $this->Form->input('header_type', array(
										'options'=>$headertype,
										'empty'=>'--- Select Type ---',
										'class'=>'form-control',
										'data-url'=>$this->Html->url(array('controller'=>'Themes', 'action'=>'admin_hederchangeopt', 'full_base'=>true)),
										'selected'=>(!empty($data))?$data['ThemeSetting']['header_type']:''
									)
								); 
								?>
							</div>
							
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Header Layout <span class="required">* </span>
							</label>
							<div class="col-md-4">
								<?php 
								echo $this->Form->input('header_layout', array(
										'options'=>$headerLayoutArr,
										'empty'=>'--- Select Layout ---',
										'class'=>'form-control',
										'id'=>'headerLayouFld',
										'data-url'=>$this->Html->url(array('controller'=>'Themes', 'action'=>'admin_hederchangeopt', 'full_base'=>true)),
										'selected'=>(!empty($data))?$data['ThemeSetting']['header_layout']:''
									)
								); 
								?>
							</div>
							
						</div>
						<div class="form-group" id="ajaxheaderMenuStyleDiv">
							<?php if(!empty($headermenuArr)){ ?>
							<label class="control-label col-md-3">Header Menu Style <span class="required">* </span>
							</label>
							<div class="col-md-4">
								<?php 
								echo $this->Form->input('header_menu_style', array(
										'options'=>$headermenuArr,
										'empty'=>'--- Select Layout ---',
										'class'=>'form-control',
										'selected'=>(!empty($data))?$data['ThemeSetting']['header_menu_style']:''
									)
								); 
								?>
							</div>
							<?php } ?>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Header Shadow Style <span class="required">* </span>
							</label>
							<div class="col-md-4">
								<?php 
								echo $this->Form->input('shadow_style', array(
										'options'=>$shadowArr,
										'empty'=>'--- Select Layout ---',
										'class'=>'form-control',
										'selected'=>(!empty($data))?$data['ThemeSetting']['shadow_style']:''
									)
								); 
								?>
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_1_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
							<?php
							echo $this->Form->button('Reset', array('class'=>'btn red', 'type'=>'submit'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv1" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Box Layout <span class="required">* </span>
							</label>
							<div class="col-md-4">
								<?php 
								echo $this->Form->input('box_layout', array(
										'options'=>$boxlayoutArr,
										'empty'=>'--- Select Layout ---',
										'class'=>'form-control',
										'selected'=>(!empty($data))?$data['ThemeSetting']['box_layout']:''
									)
								); 
								?>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_1');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									'data[ThemeSetting][header_type]': {
										required: true
									},
									'data[ThemeSetting][header_layout]': {
										required: true
									},
									'data[ThemeSetting][header_menu_style]': {
										required: true
									},
									'data[ThemeSetting][shadow_style]': {
										required: true
									},
									'data[ThemeSetting][box_layout]': {
										required: true
									}
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_1_btn').click(function(e){
								e.preventDefault();
								
								$('#form_1').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_1').serialize();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxgeneralupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv1").show(); 
											},
											complete: function() {
												$("#waitingDiv1").hide(); 
											},
											success:function(result){
												toastr.success('Header Section saved!', 'Success :',{closeButton:true});
											}
										});
									}
								}
								
							});
						});
						</script>
						
						<?php echo $this->Form->create('ThemeBackground', array('url'=>array('controller'=>'Themes','action' => 'admin_uploadbg/'.$data['ThemeSetting']['id']), 'id'=>"form_2", 'class'=>"note note-info", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
						<h3>Background Section</h3>
						<div class="form-group">
							<div class="col-md-3">
							</div>
							<div class="col-md-4">
								<label>File <span class="required"> * </span></label>
								<?php
									echo $this->Form->input('bgfilename', array('type'=>'file', 'class'=>'form-control')); 
								?>
							</div>
							<div class="col-md-2">
								<?php
									echo $this->Form->button('Upload', array('type'=>'submit', 'class'=>'btn btn-primary', 'style'=>'margin:25px 0 0 0;'));
								?>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_2');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									'data[ThemeBackground][bgtype]': {
										required: true
									},
									'data[ThemeBackground][bgfilename]': {
										required: true
									}
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetbackground/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_3', 'onsubmit'=>'return confirm("Do you want to reset?");', 'class'=>'note note-info', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Background Type <span class="required">* </span>
							</label>
							<div class="col-md-4 radio-list">
								<?php 
								echo $this->Form->input('background_type', array(
										'options'=>array('image'=>'Image', 'pattern'=>'Pattern'),
										'selected'=>(!empty($data))?$data['ThemeSetting']['background_type']:'',
										'class'=>'form-control bgselect',
										'legend'=>false,
										'hiddenField'=>false
									)
								);
								?>
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_3_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
							<?php
							echo $this->Form->button('Reset', array('class'=>'btn red', 'type'=>'submit'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv2" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<div class="form-group radioOptDiv" style="<?php echo (!empty($data))?($data['ThemeSetting']['background_type']=='image')?'display:block;':'display:none;':'display:none;' ?>" id="imageDiv">
							<label class="control-label col-md-3">Background Image <span class="required">* </span>
							</label>
							<div class="col-md-4 radio-list">
							<?php 
								echo $this->Form->input('background_img', array(
										'options'=>$backgroundArr,
										'before' => '<label class="col-md-3">',
										'after' => '</label>',
										'separator' => '</label><label class="col-md-3">',
										'type'=>'radio',
										'value'=>(!empty($data))?$data['ThemeSetting']['background_img']:'',
										'legend'=>false,
										'hiddenField'=>false,
										'data-error-container'=>'#errorDiv',
										'class'=>'radio1'
									)
								); 
								?>
							</div>
						</div>
						<div class="form-group radioOptDiv" style="<?php echo (!empty($data))?($data['ThemeSetting']['background_type']=='pattern')?'display:block;':'display:none;':'display:none;' ?>" id="patternDiv">
							<label class="control-label col-md-3">Background Pattern <span class="required">* </span>
							</label>
							<div class="col-md-4 radio-list">
								<?php 
								echo $this->Form->input('background_img', array(
										'options'=>$patternArr,
										'before' => '<label class="col-md-3">',
										'after' => '</label>',
										'separator' => '</label><label class="col-md-3">',
										'type'=>'radio',
										'value'=>(!empty($data))?$data['ThemeSetting']['background_img']:'',
										'legend'=>false,
										'hiddenField'=>false,
										'data-error-container'=>'#errorDiv',
										'class'=>'radio1'
									)
								);  
								?>
							</div>
						</div>
						<div id="errorDiv"></div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_3');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									
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
									$(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
								},

								success: function (label) {
									label.closest('.form-group').removeClass('has-error'); // set success class to the control group
								}

							});
							
							$('#form_3_btn').click(function(e){
								e.preventDefault();
								
								$('#form_3').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_3').serialize();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxgeneralupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv2").show(); 
											},
											complete: function() {
												$("#waitingDiv2").hide(); 
											},
											success:function(result){
												toastr.success('Background Section saved!', 'Success :',{closeButton:true})
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						<hr>
						<div class="row">
						  <div class="col-sm-4">Color Settings :</div>
						  <div class="col-sm-8">
						     <div class="col-md-4">
							    <button type="button" id="backupcss" class="btn btn-primary">Backup Css</button>
								<img id="backupcssloader" style="display:none;" src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
							 </div>
							<div class="col-md-4">
							    <button type="button" id="restorecss" class="btn btn-primary">Restore Css</button>
								<img id="restorecssloader" style="display:none;" src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
							 </div>
						  </div>
						  
						</div>
						
						<hr>
						
				<div id="accordion-1">		
						   <div class="panel panel-default">
						      <div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px; height: 44px;">
                                           <h6 class="panel-title accordion_title" style="height: 30px;">
                                                <a href="#bdy-1-1" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">
                                    
														<h3 style="margin-top: 6px; margin-bottom: 0px;">Body Color Control</h3><br/>
                                                </a>
                                            </h6>
                                        </div>
								<div class="panel-collapse box-text collapse" id="bdy-1-1" style="height: 0px;">
                                            <div class="panel-body">
                                               <?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_143', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Body Background Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['control_body_background-color']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('control_body_background-color',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['control_body_background-color']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['control_body_background-color']))?$datasiteArr['SiteManagement']['control_body_background-color']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'control_body_background-color' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_143_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv143" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_143');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_143_btn').click(function(e){
								e.preventDefault();
								
								$('#form_143').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_143').serialize();
								var color = $('input[name="data[ThemeSetting][text_title_color]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv143").show(); 
											},
											complete: function() {
												$("#waitingDiv143").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][previous_text_title_color]"]').val(color);
													toastr.success('Body Background Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
							<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_144', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Body Text Color<span class="required"> </span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['control_body']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('control_body',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['control_body']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['control_body']))?$datasiteArr['SiteManagement']['control_body']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'control_body' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_144_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv144" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_144');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][control_body]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_144_btn').click(function(e){
								e.preventDefault();
								
								$('#form_144').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_144').serialize();
								var color = $('input[name="data[ThemeSetting][text_title_color]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv144").show(); 
											},
											complete: function() {
												$("#waitingDiv144").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][previous_text_title_color]"]').val(color);
													toastr.success('Body Text Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_155', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Body Font Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('control_body_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['control_body_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'control_body_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_155_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv155" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_155');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][control_body_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_155_btn').click(function(e){
								e.preventDefault();
								
								$('#form_155').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_155').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv155").show(); 
											},
											complete: function() {
												$("#waitingDiv155").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Body Font Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
					

					
						
					
						
						
							<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_214', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Anchor Tag<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['a']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('a',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['a']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['a']))?$datasiteArr['SiteManagement']['a']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'a' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_214_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv214" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_214');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][control_body]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_214_btn').click(function(e){
								e.preventDefault();
								
								$('#form_214').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_214').serialize();
								var color = $('input[name="data[ThemeSetting][a]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv214").show(); 
											},
											complete: function() {
												$("#waitingDiv214").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][a]"]').val(color);
													toastr.success('Anchor Tag saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						
				<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_921', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Anchor Tag Hover Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['a_hover']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('a_hover',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['a_hover']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['a_hover']))?$datasiteArr['SiteManagement']['a_hover']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'a_hover' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_921_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv921" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_921');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][a_hover]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_921_btn').click(function(e){
								e.preventDefault();
								
								$('#form_921').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_921').serialize();
								var color = $('input[name="data[ThemeSetting][a_hover]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv921").show(); 
											},
											complete: function() {
												$("#waitingDiv921").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][a_hover]"]').val(color);
													toastr.success('Anchor Tag Hover Text Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						
							<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_215', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Magnify Glass<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['magnify_glass']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('magnify_glass',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['magnify_glass']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['magnify_glass']))?$datasiteArr['SiteManagement']['magnify_glass']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'magnify_glass' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_215_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv215" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_215');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][control_body]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_215_btn').click(function(e){
								e.preventDefault();
								
								$('#form_215').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_215').serialize();
								var color = $('input[name="data[ThemeSetting][magnify_glass]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv215").show(); 
											},
											complete: function() {
												$("#waitingDiv215").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][magnify_glass]"]').val(color);
													toastr.success('Magnify glass color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						
							<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_216', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Social Icon Background<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_socialicon']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('submenu_socialicon',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_socialicon']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_socialicon']))?$datasiteArr['SiteManagement']['submenu_socialicon']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_socialicon' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_216_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv216" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_216');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][control_body]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_216_btn').click(function(e){
								e.preventDefault();
								
								$('#form_216').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_216').serialize();
								var color = $('input[name="data[ThemeSetting][submenu_socialicon]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv216").show(); 
											},
											complete: function() {
												$("#waitingDiv216").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][submenu_socialicon]"]').val(color);
													toastr.success('Social Icon background saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_banlr', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Banner Left And Right Arrow Button Hover Background Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_blrhbc']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('submenu_blrhbc',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_blrhbc']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_blrhbc']))?$datasiteArr['SiteManagement']['submenu_blrhbc']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_blrhbc' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_banlr_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDivbanlr" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_banlr');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][control_body]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_banlr_btn').click(function(e){
								e.preventDefault();
								
								$('#form_banlr').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_banlr').serialize();
								var color = $('input[name="data[ThemeSetting][submenu_blrhbc]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDivbanlr").show(); 
											},
											complete: function() {
												$("#waitingDivbanlr").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][submenu_blrhbc]"]').val(color);
													toastr.success('Banner Left And Right Button Hover Background Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						
						
							<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_albuthbc', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">All Button Hover Backgound Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_albuthbc']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('submenu_albuthbc',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_albuthbc']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_albuthbc']))?$datasiteArr['SiteManagement']['submenu_albuthbc']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_albuthbc' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_albuthbc_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDivalbuthbc" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_albuthbc');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][control_body]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_albuthbc_btn').click(function(e){
								e.preventDefault();
								
								$('#form_albuthbc').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_albuthbc').serialize();
								var color = $('input[name="data[ThemeSetting][submenu_albuthbc]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDivalbuthbc").show(); 
											},
											complete: function() {
												$("#waitingDivalbuthbc").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][submenu_blrhbc]"]').val(color);
													toastr.success('Button Hover Background Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						
						
							<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_allbhtco', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">All Button Hover Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_allbhtco']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('submenu_allbhtco',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_allbhtco']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_allbhtco']))?$datasiteArr['SiteManagement']['submenu_allbhtco']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_allbhtco' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_allbhtco_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDivallbhtco" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_allbhtco');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][control_body]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_allbhtco_btn').click(function(e){
								e.preventDefault();
								
								$('#form_banlr').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_allbhtco').serialize();
								var color = $('input[name="data[ThemeSetting][submenu_allbhtco]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDivallbhtco").show(); 
											},
											complete: function() {
												$("#waitingDivallbhtco").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][submenu_blrhbc]"]').val(color);
													toastr.success('Button Hover Text Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_allbhtcohover', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Background overlay on hover<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_ohallbhtco']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('submenu_ohallbhtco',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_ohallbhtco']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_ohallbhtco']))?$datasiteArr['SiteManagement']['submenu_ohallbhtco']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_ohallbhtco' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_allbhtco_allbhtcohover', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDivallbhtcohover" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_allbhtco');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][control_body]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_allbhtco_allbhtcohover').click(function(e){
								e.preventDefault();
								
								$('#form_allbhtcohover').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_allbhtcohover').serialize();
								var color = $('input[name="data[ThemeSetting][submenu_ohallbhtco]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDivallbhtcohover").show(); 
											},
											complete: function() {
												$("#waitingDivallbhtcohover").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][submenu_blrhbc]"]').val(color);
													toastr.success('Background Overlay On Hover Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
							   
							</div>
						</div>
					</div>
					
						<div class="panel panel-default">
							<div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px; height: 44px;">
								<h6 class="panel-title accordion_title" style="height: 30px;">
									<a href="#head-1-1" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">
										
											<h3 style="margin-top: 6px; margin-bottom: 0px;">Header Color Control</h3><br/>
									</a>
								</h6>
							</div>
			
						    <div class="panel-collapse box-text collapse" id="head-1-1" style="height: 0px;">
                                            <div class="panel-body">
                                               
													
						
							<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_145', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Header Top Background Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['headertop_backgound']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('headertop_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['headertop_backgound']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['headertop_backgound']))?$datasiteArr['SiteManagement']['headertop_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'headertop_backgound' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_145_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv145" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_145');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][headertop_backgound]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_145_btn').click(function(e){
								e.preventDefault();
								
								$('#form_145').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_145').serialize();
								var color = $('input[name="data[ThemeSetting][headertop_backgound]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv145").show(); 
											},
											complete: function() {
												$("#waitingDiv145").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][previous_text_title_color]"]').val(color);
													toastr.success('Header Top Background Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
							<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_172', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Header Top Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['headertop_control']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('headertop_control',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['headertop_control']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['headertop_control']))?$datasiteArr['SiteManagement']['headertop_control']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'headertop_control' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_172_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv172" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_172');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][headertop_control]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_172_btn').click(function(e){
								e.preventDefault();
								
								$('#form_172').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_172').serialize();
								var color = $('input[name="data[ThemeSetting][headertop_backgound]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv172").show(); 
											},
											complete: function() {
												$("#waitingDiv172").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][previous_text_title_color]"]').val(color);
													toastr.success('Header Top Text Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_171', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Header Top Text Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('headertop_control_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['headertop_control_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'headertop_control_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_171_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv171" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_171');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][headertop_control_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_171_btn').click(function(e){
								e.preventDefault();
								
								$('#form_171').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_171').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv171").show(); 
											},
											complete: function() {
												$("#waitingDiv171").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Header Top Text Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						
						
							<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_146', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Header Bottom Backgound Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['headerbutton_backgound']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('headerbutton_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['control_title']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['headerbutton_backgound']))?$datasiteArr['SiteManagement']['control_title']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'headerbutton_backgound' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_146_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv146" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_146');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][headerbutton_backgound]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_146_btn').click(function(e){
								e.preventDefault();
								
								$('#form_146').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_146').serialize();
								var color = $('input[name="data[ThemeSetting][headerbutton_backgound]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv146").show(); 
											},
											complete: function() {
												$("#waitingDiv146").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][previous_text_title_color]"]').val(color);
													toastr.success('Header Bottom Background Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						   
						</div>
					</div>
				</div>
				
				
				  <div class="panel panel-default">
                                       <div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px; height: 44px;">
                                            <h6 class="panel-title accordion_title" style="height: 30px;">
                                                <a href="#bedcrumb-1-1" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">
                                                    
														<h3 style="margin-top: 6px; margin-bottom: 0px;">Bedcrumb Color Control</h3><br/>
                                                </a>
                                            </h6>
                                        </div>
                                        <div class="panel-collapse box-text collapse" id="bedcrumb-1-1" style="height: 0px;">
                                            <div class="panel-body">
                                               
									<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_176', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">BedCrumb Background Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['bedcrumb_backgound']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('bedcrumb_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['bedcrumb_backgound']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['bedcrumb_backgound']))?$datasiteArr['SiteManagement']['bedcrumb_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'bedcrumb_backgound' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_176_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv176" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_176');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][bedcrumb_backgound]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_176_btn').click(function(e){
								e.preventDefault();
								
								$('#form_176').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_176').serialize();
								var color = $('input[name="data[ThemeSetting][bedcrumb_backgound]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv176").show(); 
											},
											complete: function() {
												$("#waitingDiv176").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][bedcrumb_backgound]"]').val(color);
													toastr.success('BedCrumb Background Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
							</script>
							
							
							
							<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_177', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Left side Page Title Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['bedcrumbleft_control']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('bedcrumbleft_control',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['bedcrumbleft_control']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['bedcrumbleft_control']))?$datasiteArr['SiteManagement']['bedcrumbleft_control']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'bedcrumbleft_control' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_177_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv177" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_177');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_title_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_177_btn').click(function(e){
								e.preventDefault();
								
								$('#form_177').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_177').serialize();
								var color = $('input[name="data[ThemeSetting][bedcrumbleft_control]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv177").show(); 
											},
											complete: function() {
												$("#waitingDiv177").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][bedcrumbleft_control]"]').val(color);
													toastr.success('Left Page Title Text Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
							</script>
							
							
					<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_180', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Left Side Page Title Text Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('bedcrumbleft_control_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['bedcrumbleft_control_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'bedcrumbleft_control_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_180_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv180" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_180');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][bedcrumbleft_control_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_180_btn').click(function(e){
								e.preventDefault();
								
								$('#form_180').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_180').serialize();
								var color = $('input[name="data[ThemeSetting][bedcrumbleft_control_size]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv180").show(); 
											},
											complete: function() {
												$("#waitingDiv180").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
										toastr.success('Left side Text Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
							
							
							<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_178', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Right Side Page Location Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['bedcrumbright_control']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('bedcrumbright_control',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['bedcrumbright_control']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['bedcrumbright_control']))?$datasiteArr['SiteManagement']['bedcrumbright_control']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'bedcrumbright_control' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_178_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv178" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_178');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_title_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_178_btn').click(function(e){
								e.preventDefault();
								
								$('#form_178').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_178').serialize();
								var color = $('input[name="data[ThemeSetting][bedcrumbright_control]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv178").show(); 
											},
											complete: function() {
												$("#waitingDiv178").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][bedcrumbright_control]"]').val(color);
													toastr.success('Right Title Text Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
							</script>
							
									
				<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_179', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Right Side Page Location Text Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('bedcrumbright_control_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['bedcrumbright_control_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'bedcrumbright_control_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_179_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv179" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_179');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
/* 									'data[ThemeSetting][bedcrumbright_control_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_179_btn').click(function(e){
								e.preventDefault();
								
								$('#form_179').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_179').serialize();
								var color = $('input[name="data[ThemeSetting][bedcrumbright_control_size]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv179").show(); 
											},
											complete: function() {
												$("#waitingDiv179").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
										toastr.success('Right side Text Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
										   
				</div>
			</div>
		</div>
			  
					<div class="panel panel-default">
                                       <div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px; height: 44px;">
                                         <h6 class="panel-title accordion_title" style="height: 30px;">
                                                <a href="#foot-1-1" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">
                                                   
													<h3 style="margin-top: 6px; margin-bottom: 0px;">Footer Color Control</h3><br/>
                                                </a>
                                            </h6>
                                        </div>
					          <div class="panel-collapse box-text collapse" id="foot-1-1" style="height: 0px;">
                                <div class="panel-body">
                                               
										<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_147', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Footer Top Background Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['fottertop_backgound']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('fottertop_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['fottertop_backgound']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['fottertop_backgound']))?$datasiteArr['SiteManagement']['fottertop_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'fottertop_backgound' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_147_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv147" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_147');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][fottertop_backgound]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_147_btn').click(function(e){
								e.preventDefault();
								
								$('#form_147').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_147').serialize();
								var color = $('input[name="data[ThemeSetting][fottertop_backgound]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv147").show(); 
											},
											complete: function() {
												$("#waitingDiv147").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][fottertop_backgound]"]').val(color);
													toastr.success('Footer Top Background Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
							<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_148', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Footer Bottom Backgound Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['fotterbutton_backgound']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('fotterbutton_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['fotterbutton_backgound']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['fotterbutton_backgound']))?$datasiteArr['SiteManagement']['fotterbutton_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'fotterbutton_backgound' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_148_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv148" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_148');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][fotterbutton_backgound]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_148_btn').click(function(e){
								e.preventDefault();
								
								$('#form_148').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_148').serialize();
								var color = $('input[name="data[ThemeSetting][fotterbutton_backgound]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv148").show(); 
											},
											complete: function() {
												$("#waitingDiv148").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][fotterbutton_backgound]"]').val(color);
													toastr.success('Footer Bottom Background Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_149', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Footer  Top Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['fottertop_control']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('fottertop_control',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['fottertop_control']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['fottertop_control']))?$datasiteArr['SiteManagement']['fottertop_control']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'fottertop_control' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_149_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv149" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_149');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][fottertop_control]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_149_btn').click(function(e){
								e.preventDefault();
								
								$('#form_149').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_149').serialize();
								var color = $('input[name="data[ThemeSetting][fottertop_control]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv149").show(); 
											},
											complete: function() {
												$("#waitingDiv149").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][fottertop_control]"]').val(color);
													toastr.success('Footer Top Text Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
				<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_174', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Footer Top Text Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('fottertop_control_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['fottertop_control_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'fottertop_control_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_174_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv174" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_156');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][fottertop_control_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_174_btn').click(function(e){
								e.preventDefault();
								
								$('#form_174').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_174').serialize();
								var color = $('input[name="data[ThemeSetting][fottertop_control_size]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv174").show(); 
											},
											complete: function() {
												$("#waitingDiv174").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
										toastr.success('Footer Top Text Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_173', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Footer  Bottom Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['fotterbutton_control']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('fotterbutton_control',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['fotterbutton_control']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['fotterbutton_control']))?$datasiteArr['SiteManagement']['fotterbutton_control']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'fotterbutton_control' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_173_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv173" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_173');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][fotterbutton_control]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_173_btn').click(function(e){
								e.preventDefault();
								
								$('#form_173').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_173').serialize();
								var color = $('input[name="data[ThemeSetting][fotterbutton_control]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv173").show(); 
											},
											complete: function() {
												$("#waitingDiv173").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][fotterbutton_control]"]').val(color);
													toastr.success('Footer Bottom Text Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
				<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_175', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Footer Bottom Text Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('fotterbutton_control_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['fotterbutton_control_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'fotterbutton_control_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_175_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv175" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_175');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][fotterbutton_control_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_175_btn').click(function(e){
								e.preventDefault();
								
								$('#form_175').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_175').serialize();
								var color = $('input[name="data[ThemeSetting][fotterbutton_control_size]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv175").show(); 
											},
											complete: function() {
												$("#waitingDiv175").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
										toastr.success('Footer Bottom Text Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
					   
					</div>
				</div>
			</div>
			
			
			<div class="panel panel-default">
                                       <div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px; height: 44px;">
                                           <h6 class="panel-title accordion_title" style="height: 30px;">
                                                <a href="#menu-1-1" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">

													<h3 style="margin-top: 6px; margin-bottom: 0px;">Menu Color Control</h3><br/>
                                                </a>
                                            </h6>
                                        </div>
						
						<div class="panel-collapse box-text collapse" id="menu-1-1" style="height: 0px;">
                         <div class="panel-body">
						 
						 
						 
						 <?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_2bol', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Menu Text Bold/Normal<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('submenu_weight', array(
										'options'=>$datasiteArrb,
										'empty'=>'--- Select Font Weight---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_weight']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_weight' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_2bol_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv2bol" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_2bol');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][submenu_theme_font]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_2bol_btn').click(function(e){
								e.preventDefault();
								
								$('#form_2bol').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_2bol').serialize();
								var color = $('select[name="data[ThemeSetting][submenu_theme_font]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv2bol").show(); 
											},
											complete: function() {
												$("#waitingDiv2bol").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Menu Text Font-Weight Save!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						 
						 
						 
						 
						 
						 
						 
						 
						 
						 
						 
						 
						 
						 	<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_217', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Font Family<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('submenu_theme_font', array(
										'options'=>$fontsArr,
										'empty'=>'--- Select Font Theme ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_theme_font']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_theme_font' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_217_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv217" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_217');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][submenu_theme_font]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_217_btn').click(function(e){
								e.preventDefault();
								
								$('#form_217').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_217').serialize();
								var color = $('select[name="data[ThemeSetting][submenu_theme_font]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv217").show(); 
											},
											complete: function() {
												$("#waitingDiv217").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Theme Font Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						
						 
						 
						 
						 
						 
						 
						 
						 <?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_mobn', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Mobile Navigation Background Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_mobbackgound']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('submenu_mobbackgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_mobbackgound']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_mobbackgound']))?$datasiteArr['SiteManagement']['submenu_mobbackgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_mobbackgound' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_mobn_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDivmobn" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_mobn');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][menu_control]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_mobn_btn').click(function(e){
								e.preventDefault();
								
								$('#form_mobn').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_mobn').serialize();
								var color = $('input[name="data[ThemeSetting][submenu_mobbackgound]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDivmobn").show(); 
											},
											complete: function() {
												$("#waitingDivmobn").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][submenu_mobbackgound]"]').val(color);
													toastr.success('Mobile Navigation Background Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						 
						 
                                               
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_150', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Menu Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['menu_control']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('menu_control',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['menu_control']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['menu_control']))?$datasiteArr['SiteManagement']['menu_control']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'menu_control' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_150_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv150" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_150');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][menu_control]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_150_btn').click(function(e){
								e.preventDefault();
								
								$('#form_150').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_150').serialize();
								var color = $('input[name="data[ThemeSetting][menu_control]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv150").show(); 
											},
											complete: function() {
												$("#waitingDiv150").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][menu_control]"]').val(color);
													toastr.success('Menu Text Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
							<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_151', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Sub Menu Backgound Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_backgound']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('submenu_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_backgound']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_backgound']))?$datasiteArr['SiteManagement']['submenu_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_backgound' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_151_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv151" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_151');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][submenu_backgound]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_151_btn').click(function(e){
								e.preventDefault();
								
								$('#form_151').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_151').serialize();
								var color = $('input[name="data[ThemeSetting][submenu_backgound]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv151").show(); 
											},
											complete: function() {
												$("#waitingDiv151").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][submenu_backgound]"]').val(color);
													toastr.success('Sub Menu Background Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_152', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Sub Menu Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_control']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('submenu_control',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_control']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_control']))?$datasiteArr['SiteManagement']['submenu_control']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_control' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_152_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv152" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_152');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][submenu_control]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_152_btn').click(function(e){
								e.preventDefault();
								
								$('#form_152').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_152').serialize();
								var color = $('input[name="data[ThemeSetting][submenu_control]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv152").show(); 
											},
											complete: function() {
												$("#waitingDiv152").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][submenu_control]"]').val(color);
													toastr.success('Sub Menu Text Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_153', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Sub Menu Hover Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_hover']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('submenu_hover',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_hover']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_hover']))?$datasiteArr['SiteManagement']['submenu_hover']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_hover' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_153_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv153" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_153');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][submenu_hover]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_153_btn').click(function(e){
								e.preventDefault();
								
								$('#form_153').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_153').serialize();
								var color = $('input[name="data[ThemeSetting][submenu_hover]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv153").show(); 
											},
											complete: function() {
												$("#waitingDiv153").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][submenu_hover]"]').val(color);
													toastr.success('Sub Menu Hover Text Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_154', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Active Menu/Sub Menu Hover Background Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_hoverbackgound']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('submenu_hoverbackgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_hoverbackgound']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_hoverbackgound']))?$datasiteArr['SiteManagement']['submenu_hoverbackgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_hoverbackgound' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_154_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv154" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_154');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_title_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_154_btn').click(function(e){
								e.preventDefault();
								
								$('#form_154').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_154').serialize();
								var color = $('input[name="data[ThemeSetting][submenu_hoverbackgound]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv154").show(); 
											},
											complete: function() {
												$("#waitingDiv154").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][submenu_hoverbackgound]"]').val(color);
													toastr.success('Sub Menu Hover Backgound Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_156', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Menu Font Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('menu_control_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['menu_control_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'menu_control_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_156_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv156" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_156');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][menu_control_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_156_btn').click(function(e){
								e.preventDefault();
								
								$('#form_156').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_156').serialize();
								var color = $('input[name="data[ThemeSetting][menu_control_size]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv156").show(); 
											},
											complete: function() {
												$("#waitingDiv156").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
										toastr.success('Menu Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
		
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_211', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
			            <label class="control-label col-md-3">Active menu text color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_menu_ac_color']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('submenu_menu_ac_color',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_menu_ac_color']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_menu_ac_color']))?$datasiteArr['SiteManagement']['submenu_menu_ac_color']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_menu_ac_color' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_211_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv211" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_211');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_title_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_211_btn').click(function(e){
								e.preventDefault();
								
								$('#form_211').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_211').serialize();
								var color = $('input[name="data[ThemeSetting][submenu_menu_ac_color]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv211").show(); 
											},
											complete: function() {
												$("#waitingDiv211").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][submenu_menu_ac_color]"]').val(color);
													toastr.success('active menu text color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_210', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
			            <label class="control-label col-md-3">Active menu background color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_menu_ac_backg']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('submenu_menu_ac_backg',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_menu_ac_backg']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_menu_ac_backg']))?$datasiteArr['SiteManagement']['submenu_menu_ac_backg']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_menu_ac_backg' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_210_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv210" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_210');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_title_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_210_btn').click(function(e){
								e.preventDefault();
								
								$('#form_210').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_210').serialize();
								var color = $('input[name="data[ThemeSetting][submenu_menu_ac_backg]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv210").show(); 
											},
											complete: function() {
												$("#waitingDiv210").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][submenu_menu_ac_backg]"]').val(color);
													toastr.success('active menu background color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						
		</div>
	</div>
</div>







		<div class="panel panel-default">
	 <div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px; height: 44px;">
                                           <h6 class="panel-title accordion_title" style="height: 30px;">
                                                <a href="#site-navigate-manage-1-1" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">

													<h3 style="margin-top: 6px; margin-bottom: 0px;">SiteBar Navigation Color Control</h3><br/>
                                                </a>
                                            </h6>
                                        </div>
	<div class="panel-collapse box-text collapse" id="site-navigate-manage-1-1" style="height: 0px;">
		<div class="panel-body">
		   
		       <?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_644', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Navigation background Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_navigt_bkgrnd_clr']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('submenu_navigt_bkgrnd_clr',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_navigt_bkgrnd_clr']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_navigt_bkgrnd_clr']))?$datasiteArr['SiteManagement']['submenu_navigt_bkgrnd_clr']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_navigt_bkgrnd_clr' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_644_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv644" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_644');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][submenu_leftsearch_backgound]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_644_btn').click(function(e){
				e.preventDefault();
				
				$('#form_644').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_644').serialize();
				var color = $('input[name="data[ThemeSetting][submenu_navigt_bkgrnd_clr]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv644").show(); 
							},
							complete: function() {
								$("#waitingDiv644").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][submenu_navigt_bkgrnd_clr]"]').val(color);
									toastr.success('Navigation background Color saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_645', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Navigation Hover background Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_navigt_hover_bkgrnd']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('submenu_navigt_hover_bkgrnd',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_navigt_hover_bkgrnd']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_navigt_hover_bkgrnd']))?$datasiteArr['SiteManagement']['submenu_navigt_hover_bkgrnd']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_navigt_hover_bkgrnd' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_645_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv645" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_645');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][submenu_leftsearch_backgound]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_645_btn').click(function(e){
				e.preventDefault();
				
				$('#form_645').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_645').serialize();
				var color = $('input[name="data[ThemeSetting][submenu_navigt_hover_bkgrnd]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv645").show(); 
							},
							complete: function() {
								$("#waitingDiv645").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][submenu_navigt_hover_bkgrnd]"]').val(color);
									toastr.success('Navigation hover background Color saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_646', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Navigation Text Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_navigt_txt_clr']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('submenu_navigt_txt_clr',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_navigt_txt_clr']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_navigt_txt_clr']))?$datasiteArr['SiteManagement']['submenu_navigt_txt_clr']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_navigt_txt_clr' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_646_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv646" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_646');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][submenu_leftsearch_backgound]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_646_btn').click(function(e){
				e.preventDefault();
				
				$('#form_646').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_646').serialize();
				var color = $('input[name="data[ThemeSetting][submenu_navigt_txt_clr]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv646").show(); 
							},
							complete: function() {
								$("#waitingDiv646").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][submenu_navigt_txt_clr]"]').val(color);
									toastr.success('Navigation Text Color saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
	<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_647', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Navigation text hover Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_navigt_hover_txt']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('submenu_navigt_hover_txt',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_navigt_hover_txt']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_navigt_hover_txt']))?$datasiteArr['SiteManagement']['submenu_navigt_hover_txt']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_navigt_hover_txt' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_647_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv647" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_647');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][submenu_leftsearch_backgound]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_647_btn').click(function(e){
				e.preventDefault();
				
				$('#form_647').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_647').serialize();
				var color = $('input[name="data[ThemeSetting][submenu_navigt_hover_txt]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv647").show(); 
							},
							complete: function() {
								$("#waitingDiv647").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][submenu_navigt_hover_txt]"]').val(color);
									toastr.success('Navigation text hover Color saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
						
		</div>
	</div>
</div>


		<div class="panel panel-default">
	 <div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px; height: 44px;">
                                           <h6 class="panel-title accordion_title" style="height: 30px;">
                                                <a href="#searchbar-manage-1-1" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">

													<h3 style="margin-top: 6px; margin-bottom: 0px;">Search Bar Color Control</h3><br/>
                                                </a>
                                            </h6>
                                        </div>
	<div class="panel-collapse box-text collapse" id="searchbar-manage-1-1" style="height: 0px;">
		<div class="panel-body">
		   
				
				
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_219', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Search dropdown Text Size <span class="required"></span>
			</label>
			<div class="col-md-4">
				<?php
				echo $this->Form->input('searchdrop_control_size', array(
						'options'=>$fontsizeArr,
						'empty'=>'--- Select Font Size ---',
						'class'=>'form-control',
						'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['searchdrop_control_size']:''
					)
				); 
				
				
				?>
				<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'searchdrop_control_size' )); ?>
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_219_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv219" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_219');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][searchdrop_control_size]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_219_btn').click(function(e){
				e.preventDefault();
				
				$('#form_219').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_219').serialize();
				var color = $('select[name="data[ThemeSetting][searchdrop_control_size]"]').val();
				//alert(color);
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv219").show(); 
							},
							complete: function() {
								$("#waitingDiv219").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][searchdrop_control_size]"]').val(color);
									toastr.success('Search Dropdown Text Size Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_240', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Left side search button background Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_leftsearch_backgound']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('submenu_leftsearch_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_leftsearch_backgound']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_leftsearch_backgound']))?$datasiteArr['SiteManagement']['submenu_leftsearch_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_leftsearch_backgound' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_240_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv240" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_240');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][submenu_leftsearch_backgound]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_240_btn').click(function(e){
				e.preventDefault();
				
				$('#form_240').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_240').serialize();
				var color = $('input[name="data[ThemeSetting][submenu_leftsearch_backgound]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv240").show(); 
							},
							complete: function() {
								$("#waitingDiv240").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][submenu_leftsearch_backgound]"]').val(color);
									toastr.success('Left side search button background Color saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_220', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Search dropdown Text Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['searchdrop_control']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('searchdrop_control',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['searchdrop_control']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['searchdrop_control']))?$datasiteArr['SiteManagement']['searchdrop_control']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'searchdrop_control' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_220_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv220" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_220');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][searchdrop_control]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_220_btn').click(function(e){
				e.preventDefault();
				
				$('#form_220').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_220').serialize();
				var color = $('input[name="data[ThemeSetting][searchdrop_control]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv220").show(); 
							},
							complete: function() {
								$("#waitingDiv220").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][searchdrop_control]"]').val(color);
									toastr.success('Search dropdown Text Color saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_221', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Right search Button background Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_rightsearch_backgound']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('submenu_rightsearch_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_rightsearch_backgound']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_rightsearch_backgound']))?$datasiteArr['SiteManagement']['submenu_rightsearch_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_rightsearch_backgound' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_221_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv221" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_221');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][submenu_rightsearch_backgound]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_221_btn').click(function(e){
				e.preventDefault();
				
				$('#form_221').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_221').serialize();
				var color = $('input[name="data[ThemeSetting][submenu_rightsearch_backgound]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv221").show(); 
							},
							complete: function() {
								$("#waitingDiv221").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][submenu_rightsearch_backgound]"]').val(color);
									toastr.success('Right Search Button background Color saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>	
		
		
		
			<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_600', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Search Bar background Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_searchcon']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('submenu_searchcon',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_searchcon']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_searchcon']))?$datasiteArr['SiteManagement']['submenu_searchcon']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_searchcon' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_600_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv600" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_600');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][submenu_searchcon]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_600_btn').click(function(e){
				e.preventDefault();
				
				$('#form_600').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_600').serialize();
				var color = $('input[name="data[ThemeSetting][submenu_searchcon]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv600").show(); 
							},
							complete: function() {
								$("#waitingDiv600").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][submenu_searchcon]"]').val(color);
									toastr.success('Search Bar background Color saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
				
		</div>
	</div>
</div>


<div class="panel panel-default">
	 <div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px; height: 44px;">
                                           <h6 class="panel-title accordion_title" style="height: 30px;">
                                                <a href="#Blog-1" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">

													<h3 style="margin-top: 6px; margin-bottom: 0px;">Blog Color Control</h3><br/>
                                                </a>
                                            </h6>
                                        </div>
	<div class="panel-collapse box-text collapse" id="Blog-1" style="height: 0px;">
		<div class="panel-body">
		   
		   
		   
		   
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_920', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Blog Box Background<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['blog_box_backgound']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('blog_box_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['blog_box_backgound']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['blog_box_backgound']))?$datasiteArr['SiteManagement']['blog_box_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'blog_box_backgound' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_920_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv920" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_920');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][blog_box_backgound]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_920_btn').click(function(e){
				e.preventDefault();
				
				$('#form_920').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_920').serialize();
				var color = $('input[name="data[ThemeSetting][blog_box_backgound]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv920").show(); 
							},
							complete: function() {
								$("#waitingDiv920").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][blog_box_backgound]"]').val(color);
									toastr.success('Blog Box Backgound Color saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		   
				
				
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_700', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Blog Name Size<span class="required"></span>
			</label>
			<div class="col-md-4">
				<?php
				echo $this->Form->input('blog_name_control_size', array(
						'options'=>$fontsizeArr,
						'empty'=>'--- Select Font Size ---',
						'class'=>'form-control',
						'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['blog_name_control_size']:''
					)
				); 
				
				
				?>
				<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'blog_name_control_size' )); ?>
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_700_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv700" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_700');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][blog_name_control_size]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_700_btn').click(function(e){
				e.preventDefault();
				
				$('#form_700').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_700').serialize();
				var color = $('select[name="data[ThemeSetting][blog_name_control_size]"]').val();
				//alert(color);
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv700").show(); 
							},
							complete: function() {
								$("#waitingDiv700").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][blog_name_control_size]"]').val(color);
									toastr.success('Blog Name Size Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_701', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Blog Name Text Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['blog_name_control']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('blog_name_control',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['blog_name_control']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['blog_name_control']))?$datasiteArr['SiteManagement']['blog_name_control']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'blog_name_control' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_701_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv701" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_701');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][blog_name_control]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_701_btn').click(function(e){
				e.preventDefault();
				
				$('#form_701').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_701').serialize();
				var color = $('input[name="data[ThemeSetting][blog_name_control]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv701").show(); 
							},
							complete: function() {
								$("#waitingDiv701").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][blog_name_control]"]').val(color);
									toastr.success('Blog Name Color saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_751', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Blog Name Size<span class="required"></span>
			</label>
			<div class="col-md-4">
				<?php
				echo $this->Form->input('blog_summery_control_size', array(
						'options'=>$fontsizeArr,
						'empty'=>'--- Select Font Size ---',
						'class'=>'form-control',
						'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['blog_summery_control_size']:''
					)
				); 
				
				
				?>
				<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'blog_summery_control_size' )); ?>
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_751_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv751" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_751');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][blog_summery_control_size]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_751_btn').click(function(e){
				e.preventDefault();
				
				$('#form_751').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_751').serialize();
				var color = $('select[name="data[ThemeSetting][blog_summery_control_size]"]').val();
				//alert(color);
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv751").show(); 
							},
							complete: function() {
								$("#waitingDiv751").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][blog_summery_control_size]"]').val(color);
									toastr.success('Blog Summery Size Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_750', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Blog Summery Text Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['blog_summery_control']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('blog_summery_control',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['blog_summery_control']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['blog_summery_control']))?$datasiteArr['SiteManagement']['blog_summery_control']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'blog_summery_control' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_750_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv750" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_750');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][blog_summery_control]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_750_btn').click(function(e){
				e.preventDefault();
				
				$('#form_750').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_750').serialize();
				var color = $('input[name="data[ThemeSetting][blog_summery_control]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv750").show(); 
							},
							complete: function() {
								$("#waitingDiv750").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][blog_summery_control]"]').val(color);
									toastr.success('Blog Summery Color saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_702', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Blog Comment Size<span class="required"></span>
			</label>
			<div class="col-md-4">
				<?php
				echo $this->Form->input('blog_comment_control_size', array(
						'options'=>$fontsizeArr,
						'empty'=>'--- Select Font Size ---',
						'class'=>'form-control',
						'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['blog_comment_control_size']:''
					)
				); 
				
				
				?>
				<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'blog_comment_control_size' )); ?>
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_702_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv702" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_702');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][blog_comment_control_size]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_702_btn').click(function(e){
				e.preventDefault();
				
				$('#form_702').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_702').serialize();
				var color = $('select[name="data[ThemeSetting][blog_comment_control_size]"]').val();
				//alert(color);
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv702").show(); 
							},
							complete: function() {
								$("#waitingDiv702").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][blog_comment_control_size]"]').val(color);
									toastr.success('Blog Comment Text Size Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_703', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Blog Comment Text Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['blog_comment_control']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('blog_comment_control',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['blog_comment_control']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['blog_comment_control']))?$datasiteArr['SiteManagement']['blog_comment_control']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'blog_comment_control' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_703_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv703" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_703');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][blog_comment_control]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_703_btn').click(function(e){
				e.preventDefault();
				
				$('#form_703').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_703').serialize();
				var color = $('input[name="data[ThemeSetting][blog_comment_control]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv703").show(); 
							},
							complete: function() {
								$("#waitingDiv703").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][blog_comment_control]"]').val(color);
									toastr.success('Blog Comment Text Color saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_704', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Blog Date Size<span class="required"></span>
			</label>
			<div class="col-md-4">
				<?php
				echo $this->Form->input('blog_date_control_size', array(
						'options'=>$fontsizeArr,
						'empty'=>'--- Select Font Size ---',
						'class'=>'form-control',
						'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['blog_date_control_size']:''
					)
				); 
				
				
				?>
				<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'blog_date_control_size' )); ?>
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_704_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv704" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_704');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][blog_date_control_size]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_704_btn').click(function(e){
				e.preventDefault();
				
				$('#form_704').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_704').serialize();
				var color = $('select[name="data[ThemeSetting][blog_date_control_size]"]').val();
				//alert(color);
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv704").show(); 
							},
							complete: function() {
								$("#waitingDiv704").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][blog_date_control_size]"]').val(color);
									toastr.success('Blog Date Text Size Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_705', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Blog Date Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['blog_date_control']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('blog_date_control',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['blog_date_control']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['blog_date_control']))?$datasiteArr['SiteManagement']['blog_date_control']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'blog_date_control' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_705_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv705" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_705');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][blog_date_control]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_705_btn').click(function(e){
				e.preventDefault();
				
				$('#form_705').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_705').serialize();
				var color = $('input[name="data[ThemeSetting][blog_date_control]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv705").show(); 
							},
							complete: function() {
								$("#waitingDiv705").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][blog_date_control]"]').val(color);
									toastr.success('Blog Date Text Color saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_706', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Comment Heading Size<span class="required"></span>
			</label>
			<div class="col-md-4">
				<?php
				echo $this->Form->input('blog_heading_control_size', array(
						'options'=>$fontsizeArr,
						'empty'=>'--- Select Font Size ---',
						'class'=>'form-control',
						'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['blog_heading_control_size']:''
					)
				); 
				
				
				?>
				<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'blog_heading_control_size' )); ?>
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_706_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv706" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_706');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][blog_heading_control_size]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_706_btn').click(function(e){
				e.preventDefault();
				
				$('#form_706').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_706').serialize();
				var color = $('select[name="data[ThemeSetting][blog_heading_control_size]"]').val();
				//alert(color);
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv706").show(); 
							},
							complete: function() {
								$("#waitingDiv706").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][blog_heading_control_size]"]').val(color);
									toastr.success('Blog Heading Text Size Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_707', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Comment Heading Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['blog_heading_control']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('blog_heading_control',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['blog_heading_control']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['blog_heading_control']))?$datasiteArr['SiteManagement']['blog_heading_control']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'blog_heading_control' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_707_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv707" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_707');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][blog_heading_control]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_707_btn').click(function(e){
				e.preventDefault();
				
				$('#form_707').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_707').serialize();
				var color = $('input[name="data[ThemeSetting][blog_heading_control]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv707").show(); 
							},
							complete: function() {
								$("#waitingDiv707").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][blog_heading_control]"]').val(color);
									toastr.success('Blog Heading Color saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_708', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Comment Button Text Size<span class="required"></span>
			</label>
			<div class="col-md-4">
				<?php
				echo $this->Form->input('blog_button_control_size', array(
						'options'=>$fontsizeArr,
						'empty'=>'--- Select Font Size ---',
						'class'=>'form-control',
						'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['blog_button_control_size']:''
					)
				); 
				
				
				?>
				<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'blog_button_control_size' )); ?>
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_708_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv708" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_708');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][blog_button_control_size]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_708_btn').click(function(e){
				e.preventDefault();
				
				$('#form_708').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_708').serialize();
				var color = $('select[name="data[ThemeSetting][blog_button_control_size]"]').val();
				//alert(color);
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv708").show(); 
							},
							complete: function() {
								$("#waitingDiv708").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][blog_button_control_size]"]').val(color);
									toastr.success('Blog Button Text Size Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_709', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Comment Button Text Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['blog_button_control']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('blog_button_control',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['blog_button_control']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['blog_button_control']))?$datasiteArr['SiteManagement']['blog_button_control']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'blog_button_control' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_709_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv709" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_709');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][blog_button_control]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_709_btn').click(function(e){
				e.preventDefault();
				
				$('#form_709').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_709').serialize();
				var color = $('input[name="data[ThemeSetting][blog_button_control]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv709").show(); 
							},
							complete: function() {
								$("#waitingDiv709").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][blog_button_control]"]').val(color);
									toastr.success('Blog Button Text Color saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_910', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Comment Button Background Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['blog_button_backgound']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('blog_button_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['blog_button_backgound']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['blog_button_backgound']))?$datasiteArr['SiteManagement']['blog_button_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'blog_button_backgound' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_910_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv910" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_910');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][blog_button_backgound]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_910_btn').click(function(e){
				e.preventDefault();
				
				$('#form_910').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_910').serialize();
				var color = $('input[name="data[ThemeSetting][blog_button_backgound]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv910").show(); 
							},
							complete: function() {
								$("#waitingDiv910").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][blog_button_backgound]"]').val(color);
									toastr.success('Blog button background Color saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
				
		</div>
	</div>
</div>






<div class="panel panel-default">
				 <div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px; height: 44px;">
					   <h6 class="panel-title accordion_title" style="height: 30px;">
							<a href="#e-commerce-manage-1-1" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">

									<h3 style="margin-top: 6px; margin-bottom: 0px;">E-commerce Color Control</h3><br/> 
							</a>
						</h6>
					</div>			
						
	 <div class="panel-collapse box-text collapse" id="e-commerce-manage-1-1" style="height: 0px;">
            <div class="panel-body">
                     
								<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_501', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Product Name Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['ecombox_pname']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('ecombox_pname',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['ecombox_pname']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['ecombox_pname']))?$datasiteArr['SiteManagement']['ecombox_pname']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'ecombox_pname' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_501_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv501" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_501');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_title_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_501_btn').click(function(e){
								e.preventDefault();
								
								$('#form_501').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_501').serialize();
								var color = $('input[name="data[ThemeSetting][ecombox_pname]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv501").show(); 
											},
											complete: function() {
												$("#waitingDiv501").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][ecombox_pname]"]').val(color);
													toastr.success('Product Name Text Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
	<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_537', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Box Background Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['ecombox1_backgound']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('ecombox1_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['ecombox1_backgound']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['ecombox1_backgound']))?$datasiteArr['SiteManagement']['ecombox1_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'ecombox1_backgound' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_537_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv537" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_537');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_title_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_537_btn').click(function(e){
								e.preventDefault();
								
								$('#form_537').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_537').serialize();
								var color = $('input[name="data[ThemeSetting][ecombox1_backgound]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv537").show(); 
											},
											complete: function() {
												$("#waitingDiv537").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][ecombox1_backgound]"]').val(color);
													toastr.success('Box Background Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						
						
						
	<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_502', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Product Price Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['ecombox_pprice']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('ecombox_pprice',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['ecombox_pprice']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['ecombox_pprice']))?$datasiteArr['SiteManagement']['ecombox_pprice']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'ecombox_pprice' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_502_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv502" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_502');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_title_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_502_btn').click(function(e){
								e.preventDefault();
								
								$('#form_502').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_502').serialize();
								var color = $('input[name="data[ThemeSetting][ecombox_pprice]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv502").show(); 
											},
											complete: function() {
												$("#waitingDiv502").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][ecombox_pprice]"]').val(color);
													toastr.success('Product Price Text Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						
<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_517', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Add to Cart Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['ecombox_addtocart']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('ecombox_addtocart',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['ecombox_addtocart']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['ecombox_addtocart']))?$datasiteArr['SiteManagement']['ecombox_addtocart']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'ecombox_addtocart' )); ?>
							
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_517_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv517" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_517');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_des_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_517_btn').click(function(e){
								e.preventDefault();
								
								$('#form_517').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_517').serialize();
								var color = $('input[name="data[ThemeSetting][ecombox_addtocart]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv517").show(); 
											},
											complete: function() {
												$("#waitingDiv517").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][ecombox_addtocart]"]').val(color);
													toastr.success('Add to cart text Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>	
						
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_503', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">More Details Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['ecombox_moredetails']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('ecombox_moredetails',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['ecombox_moredetails']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['ecombox_moredetails']))?$datasiteArr['SiteManagement']['ecombox_moredetails']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'ecombox_moredetails' )); ?>
							
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_503_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv503" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_503');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_des_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_503_btn').click(function(e){
								e.preventDefault();
								
								$('#form_503').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_503').serialize();
								var color = $('input[name="data[ThemeSetting][ecombox_moredetails]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv503").show(); 
											},
											complete: function() {
												$("#waitingDiv503").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][ecombox_moredetails]"]').val(color);
													toastr.success('Add to Cart Text Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_505', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Load more Background Color<span class="required"></span>
							</label>
							<div class="col-md-4">
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['ecombox_load_backgound']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('ecombox_load_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['ecombox_load_backgound']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['ecombox_load_backgound']))?$datasiteArr['SiteManagement']['ecombox_load_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'ecombox_load_backgound' )); ?>
							
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_505_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv505" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_505');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_des_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_505_btn').click(function(e){
								e.preventDefault();
								
								$('#form_505').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_505').serialize();
								var color = $('input[name="data[ThemeSetting][ecombox_load_backgound]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv505").show(); 
											},
											complete: function() {
												$("#waitingDiv505").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][ecombox_load_backgound]"]').val(color);
													toastr.success('Load more background Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_506', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Load More Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['ecombox_loadmore']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('ecombox_loadmore',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['ecombox_loadmore']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['ecombox_loadmore']))?$datasiteArr['SiteManagement']['ecombox_loadmore']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'ecombox_loadmore' )); ?>
							
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_506_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv506" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_506');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_des_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_506_btn').click(function(e){
								e.preventDefault();
								
								$('#form_506').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_506').serialize();
								var color = $('input[name="data[ThemeSetting][ecombox_loadmore]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv506").show(); 
											},
											complete: function() {
												$("#waitingDiv506").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][ecombox_loadmore]"]').val(color);
													toastr.success('Load more Text Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_507', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Recent/Best Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['ecombox_reproducttext']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('ecombox_reproducttext',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['ecombox_reproducttext']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['ecombox_reproducttext']))?$datasiteArr['SiteManagement']['ecombox_reproducttext']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'ecombox_reproducttext' )); ?>
							
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_507_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv507" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_507');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_des_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_507_btn').click(function(e){
								e.preventDefault();
								
								$('#form_507').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_507').serialize();
								var color = $('input[name="data[ThemeSetting][ecombox_reproducttext]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv507").show(); 
											},
											complete: function() {
												$("#waitingDiv507").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][ecombox_reproducttext]"]').val(color);
													toastr.success('Recent/Best Product Text Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_508', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Recent/Best Product Box Background Color<span class="required"></span>
							</label>
							<div class="col-md-4">
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['ecombox_recent_backgound']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('ecombox_recent_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['ecombox_recent_backgound']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['ecombox_recent_backgound']))?$datasiteArr['SiteManagement']['ecombox_recent_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'ecombox_recent_backgound' )); ?>
							
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_508_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv508" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_508');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_des_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_508_btn').click(function(e){
								e.preventDefault();
								
								$('#form_508').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_508').serialize();
								var color = $('input[name="data[ThemeSetting][ecombox_recent_backgound]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv508").show(); 
											},
											complete: function() {
												$("#waitingDiv508").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][ecombox_recent_backgound]"]').val(color);
													toastr.success('Recent/Best Product Box Background Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						
			<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_509', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Recent/Best Product hover Background Color<span class="required"></span>
							</label>
							<div class="col-md-4">
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_ecombox_hover']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('submenu_ecombox_hover',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_ecombox_hover']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['submenu_ecombox_hover']))?$datasiteArr['SiteManagement']['submenu_ecombox_hover']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_ecombox_hover' )); ?>
							
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_509_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv509" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_509');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_des_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_509_btn').click(function(e){
								e.preventDefault();
								
								$('#form_509').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_509').serialize();
								var color = $('input[name="data[ThemeSetting][submenu_ecombox_hover]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv509").show(); 
											},
											complete: function() {
												$("#waitingDiv509").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][submenu_ecombox_hover]"]').val(color);
													toastr.success('Recent/Best Product Hover Background Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
	<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_510', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Recent/Best Product Name Color<span class="required"></span>
							</label>
							<div class="col-md-4">
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['ecombox_reproduct_name']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('ecombox_reproduct_name',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['ecombox_reproduct_name']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['ecombox_reproduct_name']))?$datasiteArr['SiteManagement']['ecombox_reproduct_name']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'ecombox_reproduct_name' )); ?>
							
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_510_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv510" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_510');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_des_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_510_btn').click(function(e){
								e.preventDefault();
								
								$('#form_510').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_510').serialize();
								var color = $('input[name="data[ThemeSetting][ecombox_reproduct_name]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv510").show(); 
											},
											complete: function() {
												$("#waitingDiv510").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][ecombox_reproduct_name]"]').val(color);
													toastr.success('Recent/Best Product Name Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
					<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_511', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Recent/Best Product Price Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['ecombox_reproduct_price']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('ecombox_reproduct_price',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['ecombox_reproduct_price']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['ecombox_reproduct_price']))?$datasiteArr['SiteManagement']['ecombox_reproduct_price']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'ecombox_reproduct_price' )); ?>
							
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_511_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv511" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_511');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_des_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_511_btn').click(function(e){
								e.preventDefault();
								
								$('#form_511').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_511').serialize();
								var color = $('input[name="data[ThemeSetting][ecombox_reproduct_price]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv511").show(); 
											},
											complete: function() {
												$("#waitingDiv511").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][ecombox_reproduct_price]"]').val(color);
													toastr.success('Recent/Best Product Price Text Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
				<br/>&nbsp;&nbsp;<h3 style="margin-top: 6px; margin-bottom: 0px;">Product Details Control</h3><br/><br/><br/> 
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_512', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Add to Cart / product quality increase and decrease / View cart button background Color<span class="required"></span>
							</label>
							<div class="col-md-4">
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['addcart_btn_backgound']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('addcart_btn_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['addcart_btn_backgound']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['addcart_btn_backgound']))?$datasiteArr['SiteManagement']['addcart_btn_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'addcart_btn_backgound' )); ?>
							
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_512_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv512" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_512');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_des_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_512_btn').click(function(e){
								e.preventDefault();
								
								$('#form_512').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_512').serialize();
								var color = $('input[name="data[ThemeSetting][addcart_btn_backgound]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv512").show(); 
											},
											complete: function() {
												$("#waitingDiv512").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][addcart_btn_backgound]"]').val(color);
													toastr.success('Add to cart button background Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>	

         <?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_513', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Add wishlist / Proceed to checkout / update cart button background Color<span class="required"></span>
							</label>
							<div class="col-md-4">
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['addwishlist_btn_backgound']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('addwishlist_btn_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['addwishlist_btn_backgound']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['addwishlist_btn_backgound']))?$datasiteArr['SiteManagement']['addwishlist_btn_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'addwishlist_btn_backgound' )); ?>
							
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_513_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv513" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_513');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_des_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_513_btn').click(function(e){
								e.preventDefault();
								
								$('#form_513').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_513').serialize();
								var color = $('input[name="data[ThemeSetting][addwishlist_btn_backgound]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv513").show(); 
											},
											complete: function() {
												$("#waitingDiv513").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][addwishlist_btn_backgound]"]').val(color);
													toastr.success('Add wishlist button background Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>		


<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_514', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Add wishlist / View cart button Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['addwishlist_btn_txt_clr']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('addwishlist_btn_txt_clr',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['addwishlist_btn_txt_clr']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['addwishlist_btn_txt_clr']))?$datasiteArr['SiteManagement']['addwishlist_btn_txt_clr']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'addwishlist_btn_txt_clr' )); ?>
							
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_514_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv514" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_514');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_des_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_514_btn').click(function(e){
								e.preventDefault();
								
								$('#form_514').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_514').serialize();
								var color = $('input[name="data[ThemeSetting][addwishlist_btn_txt_clr]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv514").show(); 
											},
											complete: function() {
												$("#waitingDiv514").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][addwishlist_btn_txt_clr]"]').val(color);
													toastr.success('Add wishlist button Text Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>						
						
					

<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_515', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Review Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['review_txt_clr']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('review_txt_clr',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['review_txt_clr']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['review_txt_clr']))?$datasiteArr['SiteManagement']['review_txt_clr']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'review_txt_clr' )); ?>
							
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_515_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv515" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_515');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_des_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_515_btn').click(function(e){
								e.preventDefault();
								
								$('#form_515').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_515').serialize();
								var color = $('input[name="data[ThemeSetting][review_txt_clr]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv515").show(); 
											},
											complete: function() {
												$("#waitingDiv515").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][review_txt_clr]"]').val(color);
													toastr.success('Review Text Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>					
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_516', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Send Button Background Color<span class="required"></span>
							</label>
							<div class="col-md-4">
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['send_btn_backgound_clr']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('send_btn_backgound_clr',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['send_btn_backgound_clr']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['send_btn_backgound_clr']))?$datasiteArr['SiteManagement']['send_btn_backgound_clr']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'send_btn_backgound_clr' )); ?>
							
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_516_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv516" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_516');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_des_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_516_btn').click(function(e){
								e.preventDefault();
								
								$('#form_516').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_516').serialize();
								var color = $('input[name="data[ThemeSetting][send_btn_backgound_clr]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv516").show(); 
											},
											complete: function() {
												$("#waitingDiv516").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][send_btn_backgound_clr]"]').val(color);
													toastr.success('Send Button Background Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_538', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Stock/Out of Stock Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['stock_txt_clr']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('stock_txt_clr',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['stock_txt_clr']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['stock_txt_clr']))?$datasiteArr['SiteManagement']['stock_txt_clr']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'stock_txt_clr' )); ?>
							
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_538_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv538" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_538');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_des_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_538_btn').click(function(e){
								e.preventDefault();
								
								$('#form_538').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_538').serialize();
								var color = $('input[name="data[ThemeSetting][stock_txt_clr]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv538").show(); 
											},
											complete: function() {
												$("#waitingDiv538").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][stock_txt_clr]"]').val(color);
													toastr.success('Stock/Out of Stock Text Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_539', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Product Description Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['product_describe_txt_clr']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('product_describe_txt_clr',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['product_describe_txt_clr']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['product_describe_txt_clr']))?$datasiteArr['SiteManagement']['product_describe_txt_clr']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'product_describe_txt_clr' )); ?>
							
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_539_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv539" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_539');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_des_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_539_btn').click(function(e){
								e.preventDefault();
								
								$('#form_539').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_539').serialize();
								var color = $('input[name="data[ThemeSetting][product_describe_txt_clr]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv539").show(); 
											},
											complete: function() {
												$("#waitingDiv539").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][product_describe_txt_clr]"]').val(color);
													toastr.success('Product Description Text Color  Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
				<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_550', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Active Tab Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_active_txt_clr']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('submenu_active_txt_clr',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_active_txt_clr']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['submenu_active_txt_clr']))?$datasiteArr['SiteManagement']['submenu_active_txt_clr']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_active_txt_clr' )); ?>
							
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_550_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv550" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_550');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_des_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_550_btn').click(function(e){
								e.preventDefault();
								
								$('#form_550').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_550').serialize();
								var color = $('input[name="data[ThemeSetting][submenu_active_txt_clr]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv550").show(); 
											},
											complete: function() {
												$("#waitingDiv550").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][submenu_active_txt_clr]"]').val(color);
													toastr.success('Active Tab Text Color  Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_uni550', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Order process button / cart page header background color<span class="required"></span>
							</label>
							<div class="col-md-4">
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_order_cart']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('submenu_order_cart',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_order_cart']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['submenu_order_cart']))?$datasiteArr['SiteManagement']['submenu_order_cart']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_order_cart' )); ?>
							
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_uni550_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDivuni550" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_uni550');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_des_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_uni550_btn').click(function(e){
								e.preventDefault();
								
								$('#form_uni550').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_uni550').serialize();
								var color = $('input[name="data[ThemeSetting][submenu_order_cart]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDivuni550").show(); 
											},
											complete: function() {
												$("#waitingDivuni550").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][submenu_order_cart]"]').val(color);
													toastr.success('Order process button / cart page header background color Saved!', 'Success :',{closeButton:true});
													
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_uni551', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Order process button / cart page header text color<span class="required"></span>
							</label>
							<div class="col-md-4">
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_order_cart_text']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('submenu_order_cart_text',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_order_cart_text']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['submenu_order_cart_text']))?$datasiteArr['SiteManagement']['submenu_order_cart_text']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_order_cart_text' )); ?>
							
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_uni551_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDivuni551" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_uni551');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_des_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_uni551_btn').click(function(e){
								e.preventDefault();
								
								$('#form_uni551').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_uni551').serialize();
								var color = $('input[name="data[ThemeSetting][submenu_order_cart_text]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDivuni551").show(); 
											},
											complete: function() {
												$("#waitingDivuni551").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][submenu_order_cart_text]"]').val(color);
													toastr.success('Order process button / cart page header text color  Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
										   
						</div>
					</div>
				</div>
				
	<div class="panel panel-default">
				 <div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px; height: 44px;">
					   <h6 class="panel-title accordion_title" style="height: 30px;">
							<a href="#text-manage-1-1" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">

									<h3 style="margin-top: 6px; margin-bottom: 0px;">Text Management Color Control</h3><br/> 
							</a>
						</h6>
					</div>			
						
						 <div class="panel-collapse box-text collapse" id="text-manage-1-1" style="height: 0px;">
                                            <div class="panel-body">
                                               
													<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_100', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Text Title Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['control_title']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('control_title',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['control_title']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['control_title']))?$datasiteArr['SiteManagement']['control_title']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'control_title' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_100_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv100" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_100');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_title_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_100_btn').click(function(e){
								e.preventDefault();
								
								$('#form_100').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_100').serialize();
								var color = $('input[name="data[ThemeSetting][text_title_color]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv100").show(); 
											},
											complete: function() {
												$("#waitingDiv100").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][previous_text_title_color]"]').val(color);
													toastr.success('Text Ttitle Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
					<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_103', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Text Title Size <span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								echo $this->Form->input('control_title_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['control_title_size']:''
									)
								); 
								
								
								?>
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'control_title_size' )); ?>
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_103_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv103" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_103');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_title_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_103_btn').click(function(e){
								e.preventDefault();
								
								$('#form_103').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_103').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv103").show(); 
											},
											complete: function() {
												$("#waitingDiv103").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][previous_text_title_size]"]').val(color);
													toastr.success('Text Title Font Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_101', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Text Description Color<span class="required"></span>
							</label>
							<div class="col-md-4">
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['control_des']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('control_des',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['control_des']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']))?$datasiteArr['SiteManagement']['control_des']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'control_des' )); ?>
							
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_101_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv101" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_101');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_des_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_101_btn').click(function(e){
								e.preventDefault();
								
								$('#form_101').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_101').serialize();
								var color = $('input[name="data[ThemeSetting][text_des_color]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv101").show(); 
											},
											complete: function() {
												$("#waitingDiv101").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][previous_text_des_color]"]').val(color);
													toastr.success('Text Description Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_102', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Text Description Size <span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('control_des_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['control_des_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'control_des_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_102_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv102" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_102');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][text_des_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_102_btn').click(function(e){
								e.preventDefault();
								
								$('#form_102').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_102').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv102").show(); 
											},
											complete: function() {
												$("#waitingDiv102").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][previous_text_des_size]"]').val(color);
													toastr.success('Text Descriptiones Font Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
					</script>
										   
						</div>
					</div>
				</div>

				<div class="panel panel-default">
								<div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px; height: 44px;">
									<h6 class="panel-title accordion_title" style="height: 30px;">
										<a href="#acc-1-1" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">
											
												<h3 style="margin-top: 6px; margin-bottom: 0px;">Accordion Color Control</h3><br/>
										</a>
									</h6>
								</div>
								
								 <div class="panel-collapse box-text collapse" id="acc-1-1" style="height: 0px;">
                                            <div class="panel-body">
                                               
													<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_105', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Accordion Header Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['accordion_head']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('accordion_head',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['accordion_head']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['accordion_head']))?$datasiteArr['SiteManagement']['accordion_head']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'accordion_head' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_105_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv105" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_105');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][accordion_head]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_105_btn').click(function(e){
								e.preventDefault();
								
								$('#form_105').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_105').serialize();
								var color = $('input[name="data[ThemeSetting][accordion_head]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv105").show(); 
											},
											complete: function() {
												$("#waitingDiv105").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
													toastr.success('Accordion Header Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_106', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Accordion Header Text Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('accordion_head_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['accordion_head_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'accordion_head_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_106_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv106" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_106');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][accordion_head_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_106_btn').click(function(e){
								e.preventDefault();
								
								$('#form_106').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_106').serialize();
								var color = $('input[name="data[ThemeSetting][accordion_head_size]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv106").show(); 
											},
											complete: function() {
												$("#waitingDiv106").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
										toastr.success('Accordion Header Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						
						
						
							<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_107', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Background Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['accordion_backgound']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('accordion_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['accordion_backgound']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['accordion_backgound']))?$datasiteArr['SiteManagement']['accordion_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'accordion_backgound' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_107_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv107" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_107');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][accordion_backgound]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_107_btn').click(function(e){
								e.preventDefault();
								
								$('#form_107').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_107').serialize();
								var color = $('input[name="data[ThemeSetting][text_title_color]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv107").show(); 
											},
											complete: function() {
												$("#waitingDiv107").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
			toastr.success('Accordion Backgound Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
					<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_108', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Accordion Title Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['accordion_title']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('accordion_title',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['accordion_title']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['accordion_title']))?$datasiteArr['SiteManagement']['accordion_title']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'accordion_title' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_108_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv108" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_108');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][accordion_title]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_108_btn').click(function(e){
								e.preventDefault();
								
								$('#form_108').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_108').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv108").show(); 
											},
											complete: function() {
												$("#waitingDiv108").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
													toastr.success('Accordion Title Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_109', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Accordion Title Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('accordion_title_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['accordion_title_size']:''
									)
								); 
								?> 
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'accordion_title_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_109_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv109" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_109');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][accordion_title_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_109_btn').click(function(e){
								e.preventDefault();
								
								$('#form_109').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_109').serialize();
								var color = $('input[name="data[ThemeSetting][text_des_color]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv109").show(); 
											},
											complete: function() {
												$("#waitingDiv109").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Accordion Title Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_110', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Accordion Content Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['accordion_des']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('accordion_des',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['accordion_des']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['accordion_des']))?$datasiteArr['SiteManagement']['accordion_des']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'accordion_des' )); ?>
								<!-- /input-group -->
							</div>
							
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_110_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv110" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_110');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][accordion_des]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_110_btn').click(function(e){
								e.preventDefault();
								
								$('#form_110').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_110').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv110").show(); 
											},
											complete: function() {
												$("#waitingDiv110").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Accordion Description Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_111', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Accordion Content Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('accordion_des_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['accordion_des_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'accordion_des_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_111_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv102" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_111');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][accordion_des_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_111_btn').click(function(e){
								e.preventDefault();
								
								$('#form_111').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_111').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv111").show(); 
											},
											complete: function() {
												$("#waitingDiv111").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Text Descriptiones Font Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
                                               
                                            </div>
                                        </div>
                                    </div>
						
						
						<div class="panel panel-default">
                                       <div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px; height: 44px;">
                                           <h6 class="panel-title accordion_title" style="height: 30px;">
                                                <a href="#imgbox-1-1" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">
                                                  
													<h3 style="margin-top: 6px; margin-bottom: 0px;">Image Box Color Control</h3><br/>
                                                </a>
                                            </h6>
                                        </div>
                                        <div class="panel-collapse box-text collapse" id="imgbox-1-1" style="height: 0px;">
                                          <div class="panel-body">
                                               
													<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_115', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Image Box Header Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['imagebox_header']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('imagebox_header',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['imagebox_header']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['imagebox_header']))?$datasiteArr['SiteManagement']['imagebox_header']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'imagebox_header' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_115_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv115" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_115');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][imagebox_header]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_115_btn').click(function(e){
								e.preventDefault();
								
								$('#form_115').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_115').serialize();
								var color = $('input[name="data[ThemeSetting][theme_size]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv115").show(); 
											},
											complete: function() {
												$("#waitingDiv115").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
													toastr.success('Image Box Header Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_116', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Image Box Header Text Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('imagebox_header_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['imagebox_header_size']:''
									)
								); 
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'imagebox_header_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_116_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv106" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_106');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][imagebox_header_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_116_btn').click(function(e){
								e.preventDefault();
								
								$('#form_116').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_116').serialize();
								var color = $('input[name="data[ThemeSetting][theme_size]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv116").show(); 
											},
											complete: function() {
												$("#waitingDiv116").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
										toastr.success('Image Box Header Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
					
					<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_117', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Image Box Title Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['imagebox_title']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('imagebox_title',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['imagebox_title']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['imagebox_title']))?$datasiteArr['SiteManagement']['imagebox_title']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'imagebox_title' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_117_btn', 'type'=>'button'));
							?>
							</div>
							
							<div class="col-md-1">
								<div id="waitingDiv117" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_117');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][imagebox_title]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_117_btn').click(function(e){
								e.preventDefault();
								
								$('#form_117').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_117').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv117").show(); 
											},
											complete: function() {
												$("#waitingDiv117").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
													toastr.success('Image Box Title Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_118', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Image Box Title Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('imagebox_title_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['imagebox_title_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'imagebox_title_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_118_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv118" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_118');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][imagebox_title_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_118_btn').click(function(e){
								e.preventDefault();
								
								$('#form_118').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_118').serialize();
								var color = $('input[name="data[ThemeSetting][text_des_color]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv118").show(); 
											},
											complete: function() {
												$("#waitingDiv118").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Image Box Title Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_119', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Image Box Content Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['imagebox_des']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('imagebox_des',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['imagebox_des']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['imagebox_des']))?$datasiteArr['SiteManagement']['imagebox_des']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'imagebox_des' )); ?>
								<!-- /input-group -->
							</div>
							
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_119_btn', 'type'=>'button'));
							?>
							</div>
							
							<div class="col-md-1">
								<div id="waitingDiv119" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_119');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][imagebox_des]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_119_btn').click(function(e){
								e.preventDefault();
								
								$('#form_119').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_119').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv119").show(); 
											},
											complete: function() {
												$("#waitingDiv119").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Image Box Content Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_120', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Image Box Content Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('imagebox_des_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['imagebox_des_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'imagebox_des_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_120_btn', 'type'=>'button'));
							?>
							</div>
							
							<div class="col-md-1">
								<div id="waitingDiv102" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_120');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][imagebox_des_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_120_btn').click(function(e){
								e.preventDefault();
								
								$('#form_120').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_120').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv120").show(); 
											},
											complete: function() {
												$("#waitingDiv120").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Image Box Content Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_121', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Image Box Link Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['imagebox_button']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('imagebox_button',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['imagebox_button']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['imagebox_button']))?$datasiteArr['SiteManagement']['imagebox_button']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'imagebox_button' )); ?>
								<!-- /input-group -->
							</div>
							
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_121_btn', 'type'=>'button'));
							?>
							</div>
						
							<div class="col-md-1">
								<div id="waitingDiv121" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_121');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][imagebox_button]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_121_btn').click(function(e){
								e.preventDefault();
								
								$('#form_121').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_121').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv121").show(); 
											},
											complete: function() {
												$("#waitingDiv121").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Image Box Button Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_122', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Image Box Link Text Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('imagebox_button_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['imagebox_button_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'imagebox_button_size' )); ?>
								
							</div>
							<div class="col-md-1">
						<?php
							echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_122_btn', 'type'=>'button'));
						?>
							</div>
							
							<div class="col-md-1">
								<div id="waitingDiv122" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_122');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][imagebox_button_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_122_btn').click(function(e){
								e.preventDefault();
								
								$('#form_122').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_122').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv122").show(); 
											},
											complete: function() {
												$("#waitingDiv122").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Image Box Button Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						   
						</div>
					</div>
				</div>  
					

				<div class="panel panel-default">
							<div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px; height: 44px;">
									<h6 class="panel-title accordion_title" style="height: 30px;">
										<a href="#scroll-1-1" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">

												<h3 style="margin-top: 6px; margin-bottom: 0px;">Scroll Banner Color Control</h3><br/>
										</a>
									</h6>
								</div>
						
						  <div class="panel-collapse box-text collapse" id="scroll-1-1" style="height: 0px;">
                                            <div class="panel-body">
                                               
													<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_124', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Scroll Banner Header Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['scb_header']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('scb_header',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['scb_header']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['scb_header']))?$datasiteArr['SiteManagement']['scb_header']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'scb_header' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_124_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv115" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_124');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][scb_header]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_124_btn').click(function(e){
								e.preventDefault();
								
								$('#form_124').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_124').serialize();
								var color = $('input[name="data[ThemeSetting][theme_size]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv124").show(); 
											},
											complete: function() {
												$("#waitingDiv124").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
													toastr.success('Scroll Banner Header Text Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_125', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Scroll Banner Header Text Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('scb_header_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['scb_header_size']:''
									)
								); 
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'scb_header_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_125_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv125" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_125');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][scb_header_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_125_btn').click(function(e){
								e.preventDefault();
								
								$('#form_125').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_125').serialize();
								var color = $('input[name="data[ThemeSetting][theme_size]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv125").show(); 
											},
											complete: function() {
												$("#waitingDiv125").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
										toastr.success('Scroll Banner Header Text Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
					
					<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_126', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Scroll Banner Title Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['scb_title']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('scb_title',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['scb_title']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['scb_title']))?$datasiteArr['SiteManagement']['scb_title']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'scb_title' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_126_btn', 'type'=>'button'));
							?>
							</div>
							
							<div class="col-md-1">
								<div id="waitingDiv126" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_126');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][scb_title]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_126_btn').click(function(e){
								e.preventDefault();
								
								$('#form_126').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_126').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv126").show(); 
											},
											complete: function() {
												$("#waitingDiv126").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
													toastr.success('Scroll Banner Title Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_127', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Scroll Banner Title Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('scb_title_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['scb_title_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'scb_title_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_127_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv127" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_127');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][scb_title_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_127_btn').click(function(e){
								e.preventDefault();
								
								$('#form_127').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_127').serialize();
								var color = $('input[name="data[ThemeSetting][text_des_color]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv127").show(); 
											},
											complete: function() {
												$("#waitingDiv127").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Scroll Banner Title Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_128', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Scroll Banner Content Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['scb_des']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('scb_des',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['scb_des']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['scb_des']))?$datasiteArr['SiteManagement']['scb_des']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'scb_des' )); ?>
								<!-- /input-group -->
							</div>
							
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_128_btn', 'type'=>'button'));
							?>
							</div>
							
							<div class="col-md-1">
								<div id="waitingDiv128" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_128');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][scb_des]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_128_btn').click(function(e){
								e.preventDefault();
								
								$('#form_128').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_128').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv128").show(); 
											},
											complete: function() {
												$("#waitingDiv128").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Scroll Banner Content Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_129', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Scroll Banner Content Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('scb_des_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['scb_des_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'scb_des_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_129_btn', 'type'=>'button'));
							?>
							</div>
							
							<div class="col-md-1">
								<div id="waitingDiv129" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_129');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][scb_des_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_129_btn').click(function(e){
								e.preventDefault();
								
								$('#form_129').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_129').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv129").show(); 
											},
											complete: function() {
												$("#waitingDiv129").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Scroll Banner Content Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_130', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Scroll Banner Button Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['scb_button']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('scb_button',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['scb_button']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['scb_button']))?$datasiteArr['SiteManagement']['scb_button']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'scb_button' )); ?>
								<!-- /input-group -->
							</div>
							
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_130_btn', 'type'=>'button'));
							?>
							</div>
						
							<div class="col-md-1">
								<div id="waitingDiv130" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_130');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][scb_button]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_130_btn').click(function(e){
								e.preventDefault();
								
								$('#form_130').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_130').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv130").show(); 
											},
											complete: function() {
												$("#waitingDiv130").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Scroll Banner Button Text Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_131', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Scroll Banner Button Text Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('scb_button_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['scb_button_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'scb_button_size' )); ?>
								
							</div>
							<div class="col-md-1">
						<?php
							echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_131_btn', 'type'=>'button'));
						?>
							</div>
							
							<div class="col-md-1">
								<div id="waitingDiv131" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_131');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][scb_button_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_131_btn').click(function(e){
								e.preventDefault();
								
								$('#form_131').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_131').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv131").show(); 
											},
											complete: function() {
												$("#waitingDiv131").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Scroll Banner Button Text Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						
						
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_246', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">First Button Background Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['scbone_backgound']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('scbone_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['scbone_backgound']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['scbone_backgound']))?$datasiteArr['SiteManagement']['scbone_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'scbone_backgound' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_246_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv246" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_246');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][scbone_backgound]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_246_btn').click(function(e){
								e.preventDefault();
								
								$('#form_246').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_246').serialize();
								var color = $('input[name="data[ThemeSetting][scbone_backgound]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv246").show(); 
											},
											complete: function() {
												$("#waitingDiv246").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
													toastr.success('First Button Background Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>				
						
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_247', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Second Button Background Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['scbtwo_backgound']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('scbtwo_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['scbtwo_backgound']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['scbtwo_backgound']))?$datasiteArr['SiteManagement']['scbtwo_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'scbtwo_backgound' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_247_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv247" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_247');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][scbtwo_backgound]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_247_btn').click(function(e){
								e.preventDefault();
								
								$('#form_247').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_247').serialize();
								var color = $('input[name="data[ThemeSetting][scbtwo_backgound]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv247").show(); 
											},
											complete: function() {
												$("#waitingDiv247").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
													toastr.success('Second Button background Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						
			<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_248', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">First Button Hover Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_scbone_overtext_color']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('submenu_scbone_overtext_color',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_scbone_overtext_color']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_scbone_overtext_color']))?$datasiteArr['SiteManagement']['submenu_scbone_overtext_color']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_scbone_overtext_color' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_248_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv248" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_248');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][submenu_scbone_overtext_color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_248_btn').click(function(e){
								e.preventDefault();
								
								$('#form_248').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_248').serialize();
								var color = $('input[name="data[ThemeSetting][submenu_scbone_overtext_color]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv248").show(); 
											},
											complete: function() {
												$("#waitingDiv248").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
													toastr.success('First Button Hover Text Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>


						     
						
						     
						   
						</div>
					</div>
				</div>
						<div class="panel panel-default">
                                       <div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px; height: 44px;">
                                           <h6 class="panel-title accordion_title" style="height: 30px;">
                                                <a href="#testimonial-1-1" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">
                                                   
													<h3 style="margin-top: 6px; margin-bottom: 0px;">Testimonial Color Control</h3><br/>
                                                </a>
                                            </h6>
                                        </div>
						
						<div class="panel-collapse box-text collapse" id="testimonial-1-1" style="height: 0px;">
                                            <div class="panel-body">
                                               
													<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_132', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						
						<div class="form-group">
							<label class="control-label col-md-3">Testimonial Back Ground Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['testimonial_background-color']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('testimonial_background-color',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['testimonial_background-color']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['testimonial_background-color']))?$datasiteArr['SiteManagement']['testimonial_background-color']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'testimonial_background-color' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_132_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv132" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						
							$(function(){
							var form = $('#form_132');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][testimonial_background-color]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_132_btn').click(function(e){
								e.preventDefault();
								
								$('#form_132').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_132').serialize();
								var color = $('input[name="data[ThemeSetting][theme_size]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv132").show(); 
											},
											complete: function() {
												$("#waitingDiv132").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
													toastr.success('Testimonial Back Ground Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_133', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Testimonial Header Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['testimonial_header']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('testimonial_header',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['testimonial_header']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['testimonial_header']))?$datasiteArr['SiteManagement']['testimonial_header']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'testimonial_header' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_133_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv133" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_133');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][testimonial_header]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_133_btn').click(function(e){
								e.preventDefault();
								
								$('#form_133').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_133').serialize();
								var color = $('input[name="data[ThemeSetting][theme_size]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv133").show(); 
											},
											complete: function() {
												$("#waitingDiv133").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
													toastr.success('Testimonial Header Text Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_134', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Testimonial Header Text Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('testimonial_header_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['testimonial_header_size']:''
									)
								); 
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'testimonial_header_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_134_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv134" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_134');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][testimonial_header_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_134_btn').click(function(e){
								e.preventDefault();
								
								$('#form_134').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_134').serialize();
								var color = $('input[name="data[ThemeSetting][theme_size]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv134").show(); 
											},
											complete: function() {
												$("#waitingDiv134").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
										toastr.success('Testimonial Header Text Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
					
					<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_135', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Testimonial Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['testimonial_text']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('testimonial_text',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['testimonial_text']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['testimonial_text']))?$datasiteArr['SiteManagement']['testimonial_text']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'testimonial_text' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_135_btn', 'type'=>'button'));
							?>
							</div>
							
							<div class="col-md-1">
								<div id="waitingDiv135" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_135');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][testimonial_text]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_135_btn').click(function(e){
								e.preventDefault();
								
								$('#form_135').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_135').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv135").show(); 
											},
											complete: function() {
												$("#waitingDiv135").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
													toastr.success('Testimonial Text Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_136', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Testimonial Text Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('testimonial_text_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['testimonial_text_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'testimonial_text_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_136_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv136" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_136');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][testimonial_text_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_136_btn').click(function(e){
								e.preventDefault();
								
								$('#form_136').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_136').serialize();
								var color = $('input[name="data[ThemeSetting][text_des_color]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv136").show(); 
											},
											complete: function() {
												$("#waitingDiv136").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Testimonial Text Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_137', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Testimonial Name Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['testimonial_name']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('testimonial_name',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['testimonial_name']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['testimonial_name']))?$datasiteArr['SiteManagement']['testimonial_name']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'testimonial_name' )); ?>
								<!-- /input-group -->
							</div>
							
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_137_btn', 'type'=>'button'));
							?>
							</div>
							
							<div class="col-md-1">
								<div id="waitingDiv137" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_137');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][testimonial_name]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_137_btn').click(function(e){
								e.preventDefault();
								
								$('#form_137').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_137').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv137").show(); 
											},
											complete: function() {
												$("#waitingDiv137").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Testimonial Name Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_138', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Testimonial Name Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('testimonial_name_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['testimonial_name_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'testimonial_name_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_138_btn', 'type'=>'button'));
							?>
							</div>
							
							<div class="col-md-1">
								<div id="waitingDiv138" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_138');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][testimonial_name_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_138_btn').click(function(e){
								e.preventDefault();
								
								$('#form_138').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_138').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv138").show(); 
											},
											complete: function() {
												$("#waitingDiv138").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Testimonial Name Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_139', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Designation Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['testimonial_designation']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('testimonial_designation',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['testimonial_designation']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['testimonial_designation']))?$datasiteArr['SiteManagement']['testimonial_designation']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'testimonial_designation' )); ?>
								<!-- /input-group -->
							</div>
							
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_139_btn', 'type'=>'button'));
							?>
							</div>
						
							<div class="col-md-1">
								<div id="waitingDiv139" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_139');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][testimonial_designation]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_139_btn').click(function(e){
								e.preventDefault();
								
								$('#form_139').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_139').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv139").show(); 
											},
											complete: function() {
												$("#waitingDiv139").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Designation Text Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_140', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Designation Text Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('testimonial_designation_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['testimonial_designation_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'testimonial_designation_size' )); ?>
								
							</div>
							<div class="col-md-1">
						<?php
							echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_140_btn', 'type'=>'button'));
						?>
							</div>
							
							<div class="col-md-1">
								<div id="waitingDiv140" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_140');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][testimonial_designation_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_140_btn').click(function(e){
								e.preventDefault();
								
								$('#form_140').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_140').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv140").show(); 
											},
											complete: function() {
												$("#waitingDiv140").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Designation Text Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_141', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?> 
						<div class="form-group">
							<label class="control-label col-md-3">Content Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['testimonial_content']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('testimonial_content',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['testimonial_content']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['testimonial_content']))?$datasiteArr['SiteManagement']['testimonial_content']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'testimonial_content' )); ?>
								<!-- /input-group -->
							</div>
							
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_141_btn', 'type'=>'button'));
							?>
							</div>
						
							<div class="col-md-1">
								<div id="waitingDiv141" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_141');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][testimonial_content]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_141_btn').click(function(e){
								e.preventDefault();
								
								$('#form_141').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_141').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv141").show(); 
											},
											complete: function() {
												$("#waitingDiv141").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Content Text Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
							
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_142', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Content Text Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('testimonial_content_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['testimonial_content_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'testimonial_content_size' )); ?>
								
							</div>
							<div class="col-md-1">
						<?php
							echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_142_btn', 'type'=>'button'));
						?>
							</div>
							
							<div class="col-md-1">
								<div id="waitingDiv142" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_142');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][testimonial_content_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_142_btn').click(function(e){
								e.preventDefault();
								
								$('#form_142').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_142').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv142").show(); 
											},
											complete: function() {
												$("#waitingDiv142").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Content Text Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
                                               
                                            </div>
                                        </div>
                                    </div>
						
				<div class="panel panel-default">
                                      <div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px; height: 44px;">
                                           <h6 class="panel-title accordion_title" style="height: 30px;">
                                                <a href="#callout-box-1-1" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">
                                                  
								
											<h3 style="margin-top: 6px; margin-bottom: 0px;">Callout Box Control</h3><br/>	
                                                </a>
                                            </h6>
                                        </div>
				
						<div class="panel-collapse box-text collapse" id="callout-box-1-1" style="height: 0px;">
                                            <div class="panel-body">
                                               
													<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_158', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Callout Box Header Text Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('calloutheader_title_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['calloutheader_title_size']:''
									)
								); 
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'calloutheader_title_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_158_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv158" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_158');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][calloutheader_title_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_158_btn').click(function(e){
								e.preventDefault();
								
								$('#form_158').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_158').serialize();
								var color = $('input[name="data[ThemeSetting][theme_size]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv158").show(); 
											},
											complete: function() {
												$("#waitingDiv158").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
										toastr.success('Callout Box Header Text Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_159', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?> 
						<div class="form-group">
							<label class="control-label col-md-3">Callout box Header Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['calloutheader_title']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('calloutheader_title',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['calloutheader_title']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['calloutheader_title']))?$datasiteArr['SiteManagement']['calloutheader_title']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'calloutheader_title' )); ?>
								<!-- /input-group -->
							</div>
							
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_159_btn', 'type'=>'button'));
							?>
							</div>
						
							<div class="col-md-1">
								<div id="waitingDiv159" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_159');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][calloutheader_title]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_159_btn').click(function(e){
								e.preventDefault();
								
								$('#form_159').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_159').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv159").show(); 
											},
											complete: function() {
												$("#waitingDiv159").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Callout Box header Text Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_160', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Callout Box Description Text Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('calloutdes_content_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['calloutdes_content_size']:''
									)
								); 
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'calloutdes_content_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_160_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv160" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_160');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][calloutdes_content_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_160_btn').click(function(e){
								e.preventDefault();
								
								$('#form_160').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_160').serialize();
								var color = $('input[name="data[ThemeSetting][theme_size]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv160").show(); 
											},
											complete: function() {
												$("#waitingDiv160").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
										toastr.success('Callout Box Description Text Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_161', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?> 
						<div class="form-group">
							<label class="control-label col-md-3">Callout box Description Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['calloutdes_content']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('calloutdes_content',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['calloutdes_content']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['calloutdes_content']))?$datasiteArr['SiteManagement']['calloutdes_content']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'calloutdes_content' )); ?>
								<!-- /input-group -->
							</div>
							
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_161_btn', 'type'=>'button'));
							?>
							</div>
						
							<div class="col-md-1">
								<div id="waitingDiv161" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_161');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][calloutdes_content]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_161_btn').click(function(e){
								e.preventDefault();
								
								$('#form_161').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_161').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv161").show(); 
											},
											complete: function() {
												$("#waitingDiv161").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Callout Box Description Text Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_162', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?> 
						<div class="form-group">
							<label class="control-label col-md-3">Callout box Backgound Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['callout_backgound']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('callout_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['callout_backgound']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['callout_backgound']))?$datasiteArr['SiteManagement']['callout_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'callout_backgound' )); ?>
								<!-- /input-group -->
							</div>
							
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_162_btn', 'type'=>'button'));
							?>
							</div>
						
							<div class="col-md-1">
								<div id="waitingDiv162" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_162');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][callout_backgound]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_162_btn').click(function(e){
								e.preventDefault();
								
								$('#form_162').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_162').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv162").show(); 
											},
											complete: function() {
												$("#waitingDiv162").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Callout Box Backgound Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_164', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Callout Box Button Text Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('callout_button_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['callout_button_size']:''
									)
								); 
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'callout_button_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_164_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv164" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_164');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][callout_button_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_164_btn').click(function(e){
								e.preventDefault();
								
								$('#form_164').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_164').serialize();
								var color = $('input[name="data[ThemeSetting][theme_size]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv164").show(); 
											},
											complete: function() {
												$("#waitingDiv164").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
										toastr.success('Callout Box Button Text Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_163', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?> 
						<div class="form-group">
							<label class="control-label col-md-3">Callout box Button Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['callout_button']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('callout_button',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['callout_button']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['callout_button']))?$datasiteArr['SiteManagement']['callout_button']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'callout_button' )); ?>
								<!-- /input-group -->
							</div>
							
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_163_btn', 'type'=>'button'));
							?>
							</div>
						
							<div class="col-md-1">
								<div id="waitingDiv163" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_163');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][callout_button]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_163_btn').click(function(e){
								e.preventDefault();
								
								$('#form_163').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_163').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv163").show(); 
											},
											complete: function() {
												$("#waitingDiv163").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Callout Box Button Text Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_181', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?> 
						<div class="form-group">
							<label class="control-label col-md-3">Callout box Button Background<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['calloutbutton_backgound']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('calloutbutton_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['calloutbutton_backgound']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['calloutbutton_backgound']))?$datasiteArr['SiteManagement']['calloutbutton_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'calloutbutton_backgound' )); ?>
								<!-- /input-group -->
							</div>
							
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_181_btn', 'type'=>'button'));
							?>
							</div>
						
							<div class="col-md-1">
								<div id="waitingDiv181" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_181');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][calloutbutton_backgound]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_181_btn').click(function(e){
								e.preventDefault();
								
								$('#form_181').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_181').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv181").show(); 
											},
											complete: function() {
												$("#waitingDiv181").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Callout Box Button Background Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script> 
			   
			</div>
		</div>
	</div>
                <div class="panel panel-default">
                                       <div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px; height: 44px;">
                                           <h6 class="panel-title accordion_title" style="height: 30px;">
                                                <a href="#list-1-1" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">
                                                   
														<h3 style="margin-top: 6px; margin-bottom: 0px;"> List Style Color Control </h3><br/>
                                                </a>
                                            </h6>
                                        </div>
                                        <div class="panel-collapse box-text collapse" id="list-1-1" style="height: 0px;">
                                            <div class="panel-body">
                                               
												
									<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_189', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Header Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['list_header']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('list_header',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['list_header']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['list_header']))?$datasiteArr['SiteManagement']['list_header']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'list_header' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_189_btn', 'type'=>'button'));
							?>
							</div>
							
							<div class="col-md-1">
								<div id="waitingDiv189" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_189');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][list_header]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_189_btn').click(function(e){
								e.preventDefault();
								
								$('#form_189').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_189').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv189").show(); 
											},
											complete: function() {
												$("#waitingDiv189").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
													toastr.success('Header Text Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_190', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Header Text Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('list_header_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['list_header_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'list_header_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_190_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv190" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_190');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][list_header_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_190_btn').click(function(e){
								e.preventDefault();
								
								$('#form_190').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_190').serialize();
								var color = $('input[name="data[ThemeSetting][text_des_color]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv190").show(); 
											},
											complete: function() {
												$("#waitingDiv190").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Header Text Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
										<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_191', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">List Style Content Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['list_content']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('list_content',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['list_content']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['list_content']))?$datasiteArr['SiteManagement']['list_content']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'list_content' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_191_btn', 'type'=>'button'));
							?>
							</div>
							
							<div class="col-md-1">
								<div id="waitingDiv191" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_191');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][list_content]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_191_btn').click(function(e){
								e.preventDefault();
								
								$('#form_191').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_191').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv191").show(); 
											},
											complete: function() {
												$("#waitingDiv191").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
													toastr.success('List Style content Text Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_192', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">List Style Content Text Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('list_content_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['list_content_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'list_content_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_192_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv192" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_192');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][list_content_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_192_btn').click(function(e){
								e.preventDefault();
								
								$('#form_192').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_192').serialize();
								var color = $('input[name="data[ThemeSetting][text_des_color]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv192").show(); 
											},
											complete: function() {
												$("#waitingDiv192").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Header Text Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
				
										<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_193', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Icon Background Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['listicon_backgound']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('listicon_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['listicon_backgound']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['listicon_backgound']))?$datasiteArr['SiteManagement']['listicon_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'listicon_backgound' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_193_btn', 'type'=>'button'));
							?>
							</div>
							
							<div class="col-md-1">
								<div id="waitingDiv193" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_193');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][listicon_backgound]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_193_btn').click(function(e){
								e.preventDefault();
								
								$('#form_193').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_193').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv193").show(); 
											},
											complete: function() {
												$("#waitingDiv193").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
													toastr.success('Icon Background Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>	
						
				</div>
			</div>
		</div>
		
		
		
		
		 <div class="panel panel-default">
                                       <div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px; height: 44px;">
                                          <h6 class="panel-title accordion_title" style="height: 30px;">
                                                <a href="#box-1-1" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">
                                                    
														<h3 style="margin-top: 6px; margin-bottom: 0px;"> Box Color Control </h3><br/>
                                                </a>
                                            </h6>
                                        </div>
                                        <div class="panel-collapse box-text collapse" id="box-1-1" style="height: 0px;">
                                            <div class="panel-body">
                                               
												
									<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_194', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3"> Box Header Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['box_header']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('box_header',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['box_header']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['box_header']))?$datasiteArr['SiteManagement']['box_header']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'box_header' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_194_btn', 'type'=>'button'));
							?>
							</div>
							
							<div class="col-md-1">
								<div id="waitingDiv194" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_194');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][box_header]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_194_btn').click(function(e){
								e.preventDefault();
								
								$('#form_194').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_194').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv194").show(); 
											},
											complete: function() {
												$("#waitingDiv194").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
													toastr.success('Box Header Text Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_195', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Box Header Text Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('box_header_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['box_header_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'box_header_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_195_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv195" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_195');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][box_header_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_195_btn').click(function(e){
								e.preventDefault();
								
								$('#form_195').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_195').serialize();
								var color = $('input[name="data[ThemeSetting][text_des_color]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv195").show(); 
											},
											complete: function() {
												$("#waitingDiv195").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Box Header Text Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
							
									<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_196', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3"> Box Title Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['box_title']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('box_title',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['box_title']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['box_title']))?$datasiteArr['SiteManagement']['box_title']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'box_title' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_196_btn', 'type'=>'button'));
							?>
							</div>
							
							<div class="col-md-1">
								<div id="waitingDiv196" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_196');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][box_title]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_196_btn').click(function(e){
								e.preventDefault();
								
								$('#form_196').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_196').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv196").show(); 
											},
											complete: function() {
												$("#waitingDiv196").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
													toastr.success('Box Title Text Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_197', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Box Title Text Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('box_title_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['box_title_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'box_title_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_197_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv197" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_197');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][box_title_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_197_btn').click(function(e){
								e.preventDefault();
								
								$('#form_197').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_197').serialize();
								var color = $('input[name="data[ThemeSetting][text_des_color]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv197").show(); 
											},
											complete: function() {
												$("#waitingDiv197").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Box Title Text Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
										
									<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_198', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3"> Box Content Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['box_content']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('box_content',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['box_content']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['box_content']))?$datasiteArr['SiteManagement']['box_content']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'box_content' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_198_btn', 'type'=>'button'));
							?>
							</div>
							
							<div class="col-md-1">
								<div id="waitingDiv198" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_198');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][box_content]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_198_btn').click(function(e){
								e.preventDefault();
								
								$('#form_198').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_198').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv198").show(); 
											},
											complete: function() {
												$("#waitingDiv198").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
													toastr.success('Box Content Text Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_199', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Box Content Text Size<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('box_content_size', array(
										'options'=>$fontsizeArr,
										'empty'=>'--- Select Font Size ---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['box_content_size']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'box_content_size' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_199_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv199" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_199');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][box_content_size]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_199_btn').click(function(e){
								e.preventDefault();
								
								$('#form_199').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_199').serialize();
								var color = $('input[name="data[ThemeSetting][text_des_color]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv199").show(); 
											},
											complete: function() {
												$("#waitingDiv199").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Box Content Text Size Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_200', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Icon Background Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['boxicon_backgound']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('boxicon_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['boxicon_backgound']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['boxicon_backgound']))?$datasiteArr['SiteManagement']['boxicon_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'boxicon_backgound' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_200_btn', 'type'=>'button'));
							?>
							</div>
							
							<div class="col-md-1">
								<div id="waitingDiv200" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_200');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][boxicon_backgound]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_200_btn').click(function(e){
								e.preventDefault();
								
								$('#form_200').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_200').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv200").show(); 
											},
											complete: function() {
												$("#waitingDiv200").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
													toastr.success('Icon Background Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_2991', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Icon Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['boxicon_text']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('boxicon_text',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['boxicon_text']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['boxicon_text']))?$datasiteArr['SiteManagement']['boxicon_text']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'boxicon_text' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_2991_btn', 'type'=>'button'));
							?>
							</div>
							
							<div class="col-md-1">
								<div id="waitingDiv2991" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_2991');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][listicon_backgound]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_2991_btn').click(function(e){
								e.preventDefault();
								
								$('#form_2991').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_2991').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv2991").show(); 
											},
											complete: function() {    
												$("#waitingDiv2991").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
													toastr.success('Icon Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>	
						
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_201', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3"> Box Background Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['box_backgound']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('box_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['box_backgound']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['box_backgound']))?$datasiteArr['SiteManagement']['box_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'box_backgound' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_201_btn', 'type'=>'button'));
							?>
							</div>
							
							<div class="col-md-1">
								<div id="waitingDiv201" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_201');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][box_backgound]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_201_btn').click(function(e){
								e.preventDefault();
								
								$('#form_201').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_201').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv201").show(); 
											},
											complete: function() {
												$("#waitingDiv201").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
													toastr.success('Box Background Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_20C', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3"> Box Background Hover Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_box_backgound_hover_co']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('submenu_box_backgound_hover_co',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_box_backgound_hover_co']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_box_backgound_hover_co']))?$datasiteArr['SiteManagement']['submenu_box_backgound_hover_co']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_box_backgound_hover_co' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_20C_btn', 'type'=>'button'));
							?>
							</div>
							
							<div class="col-md-1">
								<div id="waitingDiv20C" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_20C');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][box_backgound]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_20C_btn').click(function(e){
								e.preventDefault();
								
								$('#form_20C').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_20C').serialize();
								var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv20C").show(); 
											},
											complete: function() {
												$("#waitingDiv20C").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
												
													toastr.success('Box Background Hover Color Saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						</div>
						</div>
		</div>			
						
		<div class="panel panel-default">
						<div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px; height: 44px;">
							<h6 class="panel-title accordion_title" style="height: 30px;">
								<a href="#column-1-1" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">
									
										<h3 style="margin-top: 6px; margin-bottom: 0px;"> Column Color Control </h3><br/>
								</a>
							</h6>
						</div>
<div class="panel-collapse box-text collapse" id="column-1-1" style="height: 0px;">
<div class="panel-body">
							   
								
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_250', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Header Text Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['column_header']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('column_header',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['column_header']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['column_header']))?$datasiteArr['SiteManagement']['column_header']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'column_header' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_250_btn', 'type'=>'button'));
			?>
			</div>
			
			<div class="col-md-1">
				<div id="waitingDiv250" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_250');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
/* 					'data[ThemeSetting][column_header]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_250_btn').click(function(e){
				e.preventDefault();
				
				$('#form_250').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_250').serialize();
				var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
				//alert(color);
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv250").show(); 
							},
							complete: function() {
								$("#waitingDiv250").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
								
									toastr.success('Header Text Color Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
			
			
		});
		</script>
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_251', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Header Text Size<span class="required"></span>
			</label>
			<div class="col-md-4">
				<?php
				
				echo $this->Form->input('column_header_size', array(
						'options'=>$fontsizeArr,
						'empty'=>'--- Select Font Size ---',
						'class'=>'form-control',
						'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['column_header_size']:''
					)
				);   
				
				
				?> 
				
				<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'column_header_size' )); ?>
				
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_251_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv251" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_251');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][column_header_size]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_251_btn').click(function(e){
				e.preventDefault();
				
				$('#form_251').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_251').serialize();
				var color = $('input[name="data[ThemeSetting][text_des_color]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv251").show(); 
							},
							complete: function() {
								$("#waitingDiv251").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									
									toastr.success('Header Text Size Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_252', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Column Content Text Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['column_content']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('column_content',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['column_content']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['column_content']))?$datasiteArr['SiteManagement']['column_content']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'column_content' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_252_btn', 'type'=>'button'));
			?>
			</div>
			
			<div class="col-md-1">
				<div id="waitingDiv252" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_252');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][column_content]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_252_btn').click(function(e){
				e.preventDefault();
				
				$('#form_252').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_252').serialize();
				var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
				//alert(color);
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv252").show(); 
							},
							complete: function() {
								$("#waitingDiv252").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
								
									toastr.success('Column content Text Color Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
			
			
		});
		</script>
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_253', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Column Content Text Size<span class="required"></span>
			</label>
			<div class="col-md-4">
				<?php
				
				echo $this->Form->input('column_content_size', array(
						'options'=>$fontsizeArr,
						'empty'=>'--- Select Font Size ---',
						'class'=>'form-control',
						'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['column_content_size']:''
					)
				);   
				
				
				?> 
				
				<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'column_content_size' )); ?>
				
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_253_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv253" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_253');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][column_content_size]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_253_btn').click(function(e){
				e.preventDefault();
				
				$('#form_253').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_253').serialize();
				var color = $('input[name="data[ThemeSetting][text_des_color]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv253").show(); 
							},
							complete: function() {
								$("#waitingDiv253").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									
									toastr.success('Column Content Size Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		
 


		
</div>		
	</div>
</div>

        <div class="panel panel-default">
						<div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px; height: 44px;">
							<h6 class="panel-title accordion_title" style="height: 30px;">
								<a href="#contacttestlals" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">
									
										<h3 style="margin-top: 6px; margin-bottom: 0px;"> Contact Form Color  Control </h3><br/>
								</a>
							</h6>
						</div>
<div class="panel-collapse box-text collapse" id="contacttestlals" style="height: 0px;">
<div class="panel-body">
							   
								
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_260', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Contact Form Background Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['contact_backgound']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('contact_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['contact_backgound']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['contact_backgound']))?$datasiteArr['SiteManagement']['contact_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'contact_backgound' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_260_btn', 'type'=>'button'));
			?>
			</div>
			
			<div class="col-md-1">
				<div id="waitingDiv260" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_260');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][contact_backgound]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_260_btn').click(function(e){
				e.preventDefault();
				
				$('#form_260').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_260').serialize();
				var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
				//alert(color);
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv260").show(); 
							},
							complete: function() {
								$("#waitingDiv260").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
								
									toastr.success('Contact Form Background Color Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
			
			
		});
		</script>
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_261', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Header Text Size<span class="required"></span>
			</label>
			<div class="col-md-4">
				<?php
				
				echo $this->Form->input('contact_header_size', array(
						'options'=>$fontsizeArr,
						'empty'=>'--- Select Font Size ---',
						'class'=>'form-control',
						'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['contact_header_size']:''
					)
				);   
				
				
				?> 
				
				<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'contact_header_size' )); ?>
				
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_261_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv261" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_261');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][contact_header_size]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_261_btn').click(function(e){
				e.preventDefault();
				
				$('#form_261').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_261').serialize();
				var color = $('input[name="data[ThemeSetting][text_des_color]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv261").show(); 
							},
							complete: function() {
								$("#waitingDiv261").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									
									toastr.success('Header Text Size Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_262', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Header Text Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['contact_header']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('contact_header',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['contact_header']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['contact_header']))?$datasiteArr['SiteManagement']['contact_header']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'contact_header' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_262_btn', 'type'=>'button'));
			?>
			</div>
			
			<div class="col-md-1">
				<div id="waitingDiv262" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_262');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][contact_header]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_262_btn').click(function(e){
				e.preventDefault();
				
				$('#form_262').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_262').serialize();
				var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
				//alert(color);
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv262").show(); 
							},
							complete: function() {
								$("#waitingDiv262").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
								
									toastr.success('Header Text Color Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
			
			
		});
		</script>
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_263', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Button Text Size<span class="required"></span>
			</label>
			<div class="col-md-4">
				<?php
				
				echo $this->Form->input('contact_button_size', array(
						'options'=>$fontsizeArr,
						'empty'=>'--- Select Font Size ---',
						'class'=>'form-control',
						'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['contact_button_size']:''
					)
				);   
				
				
				?> 
				
				<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'contact_button_size' )); ?>
				
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_263_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv263" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_263');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][contact_button_size]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_263_btn').click(function(e){
				e.preventDefault();
				
				$('#form_263').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_263').serialize();
				var color = $('input[name="data[ThemeSetting][text_des_color]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv263").show(); 
							},
							complete: function() {
								$("#waitingDiv263").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									
									toastr.success('Button Text Size Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		
				<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_264', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Button Text Color<span class="required"> </span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['contact_button']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('contact_button',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['contact_button']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['contact_button']))?$datasiteArr['SiteManagement']['contact_button']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'contact_button' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_264_btn', 'type'=>'button'));
			?>
			</div>
			
			<div class="col-md-1">
				<div id="waitingDiv264" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_264');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][contact_button]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_264_btn').click(function(e){
				e.preventDefault();
				
				$('#form_264').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_264').serialize();
				var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
				//alert(color);
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv264").show(); 
							},
							complete: function() {
								$("#waitingDiv264").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
								
									toastr.success('Button Text Color Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
			
			
		});
		</script>
		
				<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_265', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Button Backgound Color<span class="required"> </span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['contactbutton_backgound']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('contactbutton_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['contactbutton_backgound']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['contactbutton_backgound']))?$datasiteArr['SiteManagement']['contactbutton_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'contactbutton_backgound' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_265_btn', 'type'=>'button'));
			?>
			</div>
			
			<div class="col-md-1">
				<div id="waitingDiv265" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_265');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][contactbutton_backgound]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_265_btn').click(function(e){
				e.preventDefault();
				
				$('#form_265').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_265').serialize();
				var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
				//alert(color);
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv265").show(); 
							},
							complete: function() {
								$("#waitingDiv265").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
								
									toastr.success('Button Backgound Color Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
			
			
		});
		</script>
		
		
			<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_540', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Clear All link text Color<span class="required"> </span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['clearall_control']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('clearall_control',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['clearall_control']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['clearall_control']))?$datasiteArr['SiteManagement']['clearall_control']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'clearall_control' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_540_btn', 'type'=>'button'));
			?>
			</div>
			
			<div class="col-md-1">
				<div id="waitingDiv540" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_540');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][contactbutton_backgound]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_540_btn').click(function(e){
				e.preventDefault();
				
				$('#form_540').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_540').serialize();
				var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
				//alert(color);
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv540").show(); 
							},
							complete: function() {
								$("#waitingDiv540").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
								
									toastr.success('Clear All link text Color Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
			
			
		});
		</script>
		
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_541', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Clear All link Text Size<span class="required"></span>
			</label>
			<div class="col-md-4">
				<?php
				
				echo $this->Form->input('clearall_control_size', array(
						'options'=>$fontsizeArr,
						'empty'=>'--- Select Font Size ---',
						'class'=>'form-control',
						'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['clearall_control_size']:''
					)
				);   
				
				
				?> 
				
				<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'clearall_control_size' )); ?>
				
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_541_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv541" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_541');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][contact_button_size]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_541_btn').click(function(e){
				e.preventDefault();
				
				$('#form_541').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_541').serialize();
				var color = $('input[name="data[ThemeSetting][clearall_control_size]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv541").show(); 
							},
							complete: function() {
								$("#waitingDiv541").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									
									toastr.success('Clear All link Text Size Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		
		
 


		
</div>		
	</div>
</div>

        <div class="panel panel-default">
						<div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px; height: 44px;">
							<h6 class="panel-title accordion_title" style="height: 30px;">
								<a href="#portfoliolal" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">
									
										<h3 style="margin-top: 6px; margin-bottom: 0px;"> Portfolio Color  Control </h3><br/>
								</a>
							</h6>
						</div>
<div class="panel-collapse box-text collapse" id="portfoliolal" style="height: 0px;">
<div class="panel-body">
							   
								
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_273', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Portfolio Title Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['portfolio_title']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('portfolio_title',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['portfolio_title']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['portfolio_title']))?$datasiteArr['SiteManagement']['portfolio_title']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'portfolio_title' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_273_btn', 'type'=>'button'));
			?>
			</div>
			
			<div class="col-md-1">
				<div id="waitingDiv273" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_273');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][portfolio_title]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_273_btn').click(function(e){
				e.preventDefault();
				
				$('#form_273').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_273').serialize();
				var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
				//alert(color);
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv273").show(); 
							},
							complete: function() {
								$("#waitingDiv273").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
								
									toastr.success('Portfolio Title Color Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
			
			
		});
		</script>
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_272', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Portfolio Title Size<span class="required"> </span>
			</label>
			<div class="col-md-4">
				<?php
				
				echo $this->Form->input('portfolio_title_size', array(
						'options'=>$fontsizeArr,
						'empty'=>'--- Select Font Size ---',
						'class'=>'form-control',
						'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['portfolio_title_size']:''
					)
				);   
				
				
				?> 
				
<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'portfolio_title_size' )); ?>
				
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_272_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv272" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_272');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][portfolio_title_size]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_272_btn').click(function(e){
				e.preventDefault();
				
				$('#form_272').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_272').serialize();
				var color = $('input[name="data[ThemeSetting][text_des_color]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv272").show(); 
							},
							complete: function() {
								$("#waitingDiv272").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									
									toastr.success('Portfolio Title Size Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_271', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Portfolio Breadcrumb Color<span class="required"> </span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['portfolio_category']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('portfolio_category',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['portfolio_category']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['portfolio_category']))?$datasiteArr['SiteManagement']['portfolio_category']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'portfolio_category' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_271_btn', 'type'=>'button'));
			?>
			</div>
			
			<div class="col-md-1">
				<div id="waitingDiv271" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_271');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][portfolio_category]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_271_btn').click(function(e){
				e.preventDefault();
				
				$('#form_271').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_271').serialize();
				var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
				//alert(color);
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv271").show(); 
							},
							complete: function() {
								$("#waitingDiv271").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
								
									toastr.success('Portfolio Breadcrumb Color Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
			
			
		});
		</script>
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_270', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Portfolio Breadcrumb Size<span class="required"> </span>
			</label>
			<div class="col-md-4">
				<?php
				
				echo $this->Form->input('portfolio_category_size', array(
						'options'=>$fontsizeArr,
						'empty'=>'--- Select Font Size ---',
						'class'=>'form-control',
						'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['portfolio_category_size']:''
					)
				);   
				
				
				?> 
				
				<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'portfolio_category_size' )); ?>
				
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_270_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv270" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_270');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][portfolio_category_size]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_270_btn').click(function(e){
				e.preventDefault();
				
				$('#form_270').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_270').serialize();
				var color = $('input[name="data[ThemeSetting][text_des_color]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv270").show(); 
							},
							complete: function() {
								$("#waitingDiv270").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									
									toastr.success('Portfolio Breadcrumb Size Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		
		
</div>		
	</div>
</div>

        <div class="panel panel-default">
						<div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px; height: 44px;">
							<h6 class="panel-title accordion_title" style="height: 30px;">
								<a href="#tabcontrollal" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">
									
										<h3 style="margin-top: 6px; margin-bottom: 0px;"> Tab Color  Control </h3><br/>
								</a>
							</h6>
						</div>
<div class="panel-collapse box-text collapse" id="tabcontrollal" style="height: 0px;">
<div class="panel-body">
							   
								
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_290', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Tab Title Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['tab_title']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('tab_title',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['tab_title']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['tab_title']))?$datasiteArr['SiteManagement']['tab_title']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'tab_title' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_290_btn', 'type'=>'button'));
			?>
			</div>
			
			<div class="col-md-1">
				<div id="waitingDiv290" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_290');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][tab_title]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_290_btn').click(function(e){
				e.preventDefault();
				
				$('#form_290').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_290').serialize();
				var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
				//alert(color);
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv290").show(); 
							},
							complete: function() {
								$("#waitingDiv290").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
								
									toastr.success('Tab Title Color Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
			
			
		});
		</script>
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_291', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Tab Title Size<span class="required"> </span>
			</label>
			<div class="col-md-4">
				<?php
				
				echo $this->Form->input('tab_title_size', array(
						'options'=>$fontsizeArr,
						'empty'=>'--- Select Font Size ---',
						'class'=>'form-control',
						'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['tab_title_size']:''
					)
				);   
				
				
				?> 
				
<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'tab_title_size' )); ?>
				
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_291_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv291" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_291');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][tab_title_size]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_291_btn').click(function(e){
				e.preventDefault();
				
				$('#form_291').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_291').serialize();
				var color = $('input[name="data[ThemeSetting][text_des_color]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv291").show(); 
							},
							complete: function() {
								$("#waitingDiv291").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									
									toastr.success('Tab Title Size Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_292', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Tab Name Color<span class="required"> </span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['tab_name']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('tab_name',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['tab_name']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['tab_name']))?$datasiteArr['SiteManagement']['tab_name']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'tab_name' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_292_btn', 'type'=>'button'));
			?>
			</div>
			
			<div class="col-md-1">
				<div id="waitingDiv292" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_292');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][tab_name]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_292_btn').click(function(e){
				e.preventDefault();
				
				$('#form_292').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_292').serialize();
				var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
				//alert(color);
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv292").show(); 
							},
							complete: function() {
								$("#waitingDiv292").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
								
									toastr.success('Tab Name Color Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
			
			
		});
		</script>
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_293', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Tab Name Size<span class="required"></span>
			</label>
			<div class="col-md-4">
				<?php
				
				echo $this->Form->input('tab_name_size', array(
						'options'=>$fontsizeArr,
						'empty'=>'--- Select Font Size ---',
						'class'=>'form-control',
						'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['tab_name_size']:''
					)
				);   
				
				
				?> 
				
				<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'tab_name_size' )); ?>
				
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_293_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv293" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_293');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][tab_name_size]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_293_btn').click(function(e){
				e.preventDefault();
				
				$('#form_293').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_293').serialize();
				var color = $('input[name="data[ThemeSetting][text_des_color]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv293").show(); 
							},
							complete: function() {
								$("#waitingDiv293").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									
									toastr.success('Tab Name Size Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		
			<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_303', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Tab Header Background Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['tabname_backgound']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('tabname_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['tabname_backgound']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['tabname_backgound']))?$datasiteArr['SiteManagement']['tabname_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'tabname_backgound' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_303_btn', 'type'=>'button'));
			?>
			</div>
			
			<div class="col-md-1">
				<div id="waitingDiv303" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_303');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][tabname_backgound]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_303_btn').click(function(e){
				e.preventDefault();
				
				$('#form_303').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_303').serialize();
				var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
				//alert(color);
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv303").show(); 
							},
							complete: function() {
								$("#waitingDiv303").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
								
									toastr.success('Tab Header Background Color Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
			
			
		});
		</script>
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_302', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Tab Content Size<span class="required"></span>
			</label>
			<div class="col-md-4">
				<?php
				
				echo $this->Form->input('tab_content_size', array(
						'options'=>$fontsizeArr,
						'empty'=>'--- Select Font Size ---',
						'class'=>'form-control',
						'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['tab_content_size']:''
					)
				);   
				
				
				?> 
				
<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'tab_content_size' )); ?>
				
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_302_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv302" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_302');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][tab_content_size]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_302_btn').click(function(e){
				e.preventDefault();
				
				$('#form_302').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_302').serialize();
				var color = $('input[name="data[ThemeSetting][text_des_color]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv302").show(); 
							},
							complete: function() {
								$("#waitingDiv302").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									
									toastr.success('Tab Content Size Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
	   <?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_301', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Tab Content Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['tab_content']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('tab_content',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['tab_content']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['tab_content']))?$datasiteArr['SiteManagement']['tab_content']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'tab_content' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_301_btn', 'type'=>'button'));
			?>
			</div>
			
			<div class="col-md-1">
				<div id="waitingDiv301" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_301');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][tab_content]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_301_btn').click(function(e){
				e.preventDefault();
				
				$('#form_301').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_301').serialize();
				var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
				//alert(color);
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv301").show(); 
							},
							complete: function() {
								$("#waitingDiv301").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
								
									toastr.success('Tab Contact Color Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
			
			
		});
		</script>
		
		
		 <?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_300', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Tab Content Background Color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['tabcontent_backgound']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('tabcontent_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['tabcontent_backgound']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['tabcontent_backgound']))?$datasiteArr['SiteManagement']['tabcontent_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'tabcontent_backgound' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_300_btn', 'type'=>'button'));
			?>
			</div>
			
			<div class="col-md-1">
				<div id="waitingDiv300" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_300');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][tabcontent_backgound]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_300_btn').click(function(e){
				e.preventDefault();
				
				$('#form_300').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_300').serialize();
				var color = $('select[name="data[ThemeSetting][theme_size]"]').val();
				//alert(color);
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv300").show(); 
							},
							complete: function() {
								$("#waitingDiv300").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
								
									toastr.success('Tab Content Background Color Saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
			
			
		});
		</script>
		
		
		
</div>		
	</div>
</div>


<div class="panel panel-default">
							<div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px; height: 44px;">
								<h6 class="panel-title accordion_title" style="height: 30px;">
									<a href="#revolution-1-1" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">
										
											<h3 style="margin-top: 6px; margin-bottom: 0px;">Revolution Slider Color Control</h3><br/>
									</a>
								</h6>
							</div>
			
						    <div class="panel-collapse box-text collapse" id="revolution-1-1" style="height: 0px;">
                                            <div class="panel-body">
                                               
								

								 
						 <?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_rehtbn', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Header Text Bold/Normal<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php
								
								echo $this->Form->input('submenu_reweight', array(
										'options'=>$datasiteArrb,
										'empty'=>'--- Select Font Weight---',
										'class'=>'form-control',
										'selected'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_reweight']:''
									)
								);   
								
								
								?> 
								
								<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_reweight' )); ?>
								
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_rehtbn_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDivrehtbn" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_rehtbn');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][submenu_theme_font]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_rehtbn_btn').click(function(e){
								e.preventDefault();
								
								$('#form_rehtbn').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_rehtbn').serialize();
								var color = $('select[name="data[ThemeSetting][submenu_theme_font]"]').val();
								//alert(color);
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDivrehtbn").show(); 
											},
											complete: function() {
												$("#waitingDivrehtbn").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													
													toastr.success('Text Font-Weight Save!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
							
							
						});
						</script>
						 
		
						
							<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_775', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
							?>
						<div class="form-group">
							<label class="control-label col-md-3">Header Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['revolutionhead']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('revolutionhead',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['revolutionhead']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['revolutionhead']))?$datasiteArr['SiteManagement']['revolutionhead']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'revolutionhead' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_775_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv775" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_775');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][headertop_backgound]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_775_btn').click(function(e){
								e.preventDefault();
								
								$('#form_775').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_775').serialize();
								var color = $('input[name="data[ThemeSetting][revolutionhead]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv775").show(); 
											},
											complete: function() {
												$("#waitingDiv775").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][previous_text_title_color]"]').val(color);
													toastr.success('Header Text  Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
							<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_776', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Description Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['revolutiondes']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('revolutiondes',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['revolutiondes']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['revolutiondes']))?$datasiteArr['SiteManagement']['revolutiondes']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'revolutiondes' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_776_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv776" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_776');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][headertop_control]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_776_btn').click(function(e){
								e.preventDefault();
								
								$('#form_776').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_776').serialize();
								var color = $('input[name="data[ThemeSetting][revolutiondes]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv776").show(); 
											},
											complete: function() {
												$("#waitingDiv776").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][previous_text_title_color]"]').val(color);
													toastr.success('Description Text Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_778', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Button Text Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['revolutionbutton']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('revolutionbutton',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['revolutionbutton']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['revolutionbutton']))?$datasiteArr['SiteManagement']['revolutionbutton']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'revolutionbutton' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_778_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv778" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_778');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][headerbutton_backgound]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_778_btn').click(function(e){
								e.preventDefault();
								
								$('#form_778').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_778').serialize();
								var color = $('input[name="data[ThemeSetting][revolutionbutton]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv778").show(); 
											},
											complete: function() {
												$("#waitingDiv778").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][previous_text_title_color]"]').val(color);
													toastr.success('Button Text Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						
						
						
							<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_777', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
														
						?>
						<div class="form-group">
							<label class="control-label col-md-3">Button Backgound Color<span class="required"></span>
							</label>
							<div class="col-md-4">
							
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['revolution_backgound']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('revolution_backgound',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['revolution_backgound']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['revolution_backgound']))?$datasiteArr['SiteManagement']['revolution_backgound']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
									<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'revolution_backgound' )); ?>
								<!-- /input-group -->
							</div>
							<div class="col-md-1">
							<?php
								echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_777_btn', 'type'=>'button'));
							?>
							</div>
							<div class="col-md-1">
								<div id="waitingDiv777" class="pull-right" style="display:none;">
									<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						<script type="text/javascript">
						$(function(){
							var form = $('#form_777');
							var error = $('.alert-danger', form);
							var success = $('.alert-success', form);
							
							var validator = form.validate({
								errorElement: 'span', //default input error message container
								errorClass: 'help-block', // default input error message class
								focusInvalid: false, // do not focus the last invalid input
								ignore: "", // validate all fields including form hidden input
								rules: {
									/* 'data[ThemeSetting][headerbutton_backgound]': {
										required: true
									} */
								},
								errorPlacement: function (error, element) { // render error placement for each input type
									error.insertAfter(element); // for other inputs, just perform default behavior
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
							
							$('#form_777_btn').click(function(e){
								e.preventDefault();
								
								$('#form_777').submit(function(e){
									//e.preventDefault();
								});
								
								var themeId = $('#theme_id').val();
								var data = $('#form_777').serialize();
								var color = $('input[name="data[ThemeSetting][revolution_backgound]"]').val();
								if(validator.form()){
									if(themeId.trim()!=''){
										$.ajax({
											type:'POST',
											url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
											data:data,
											beforeSend : function(res){
												$("#waitingDiv777").show(); 
											},
											complete: function() {
												$("#waitingDiv777").hide(); 
											},
											success:function(result){
												if(result.trim()==1){
													$('input[name="data[ThemeSetting][previous_text_title_color]"]').val(color);
													toastr.success('Button Background Color saved!', 'Success :',{closeButton:true});
												}
											}
										});
									}
								}
								
							});
						});
						</script>
						   
						</div>
					</div>
				</div>


<div class="panel panel-default">
	 <div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px; height: 44px;">
                                           <h6 class="panel-title accordion_title" style="height: 30px;">
                                                <a href="#latest-1-1" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">

													<h3 style="margin-top: 6px; margin-bottom: 0px;">Latest Post Color Control</h3><br/>
                                                </a>
                                            </h6>
                                        </div>
	<div class="panel-collapse box-text collapse" id="latest-1-1" style="height: 0px;">
		<div class="panel-body">
		   
		   	<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_3994', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Latest post header text color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['latestpost_textheader']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('latestpost_textheader',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['latestpost_textheader']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['latestpost_textheader']))?$datasiteArr['SiteManagement']['latestpost_textheader']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'latestpost_textheader' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_3994_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv3994" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_3994');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][submenu_leftsearch_backgound]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_3994_btn').click(function(e){
				e.preventDefault();
				
				$('#form_3994').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_3994').serialize();
				var color = $('input[name="data[ThemeSetting][latestpost_textheader]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv3994").show(); 
							},
							complete: function() {
								$("#waitingDiv3994").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][latestpost_textheader]"]').val(color);
									toastr.success('Latest post header text Color saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		    
		   
		   
		   
		   
		       <?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_3990', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Latest post background color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_latest_bkgrnd_clr']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('submenu_latest_bkgrnd_clr',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_latest_bkgrnd_clr']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_latest_bkgrnd_clr']))?$datasiteArr['SiteManagement']['submenu_latest_bkgrnd_clr']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_latest_bkgrnd_clr' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_3990_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv3990" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_3990');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][submenu_leftsearch_backgound]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_3990_btn').click(function(e){
				e.preventDefault();
				
				$('#form_3990').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_3990').serialize();
				var color = $('input[name="data[ThemeSetting][submenu_latest_bkgrnd_clr]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv3990").show(); 
							},
							complete: function() {
								$("#waitingDiv3990").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][submenu_latest_bkgrnd_clr]"]').val(color);
									toastr.success('Latest post background Color saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_3991', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Latest post hover background color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_latest_hover_bkgrnd']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('submenu_latest_hover_bkgrnd',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_latest_hover_bkgrnd']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_latest_hover_bkgrnd']))?$datasiteArr['SiteManagement']['submenu_latest_hover_bkgrnd']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_latest_hover_bkgrnd' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_3991_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv3991" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_3991');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][submenu_leftsearch_backgound]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_3991_btn').click(function(e){
				e.preventDefault();
				
				$('#form_3991').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_3991').serialize();
				var color = $('input[name="data[ThemeSetting][submenu_latest_hover_bkgrnd]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv3991").show(); 
							},
							complete: function() {
								$("#waitingDiv3991").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][submenu_latest_hover_bkgrnd]"]').val(color);
									toastr.success('Latest post hover background Color saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
		
		<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_3992', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Latest post text color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_latest_txt_clr']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('submenu_latest_txt_clr',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_latest_txt_clr']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_latest_txt_clr']))?$datasiteArr['SiteManagement']['submenu_latest_txt_clr']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_latest_txt_clr' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_3992_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv3992" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_3992');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][submenu_leftsearch_backgound]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_3992_btn').click(function(e){
				e.preventDefault();
				
				$('#form_3992').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_3992').serialize();
				var color = $('input[name="data[ThemeSetting][submenu_latest_txt_clr]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv3992").show(); 
							},
							complete: function() {
								$("#waitingDiv3992").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][submenu_latest_txt_clr]"]').val(color);
									toastr.success('Latest Post Text Color saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>
		
	<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_3993', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));
										
		?>
		<div class="form-group">
			<label class="control-label col-md-3">Latest post text hover color<span class="required"></span>
			</label>
			<div class="col-md-4">
			
				<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_latest_hover_txt']:'#219fd1'; ?>" data-color-format="rgba">
					<?php echo $this->Form->input('submenu_latest_hover_txt',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_latest_hover_txt']:'')); ?>
					<span class="input-group-btn">
						<button class="btn default" type="button">
							<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_latest_hover_txt']))?$datasiteArr['SiteManagement']['submenu_latest_hover_txt']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
						</button>
					</span>
				</div>
					<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_latest_hover_txt' )); ?>
				<!-- /input-group -->
			</div>
			<div class="col-md-1">
			<?php
				echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_3993_btn', 'type'=>'button'));
			?>
			</div>
			<div class="col-md-1">
				<div id="waitingDiv3993" class="pull-right" style="display:none;">
					<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<script type="text/javascript">
		$(function(){
			var form = $('#form_3993');
			var error = $('.alert-danger', form);
			var success = $('.alert-success', form);
			
			var validator = form.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					/* 'data[ThemeSetting][submenu_leftsearch_backgound]': {
						required: true
					} */
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); // for other inputs, just perform default behavior
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
			
			$('#form_3993_btn').click(function(e){
				e.preventDefault();
				
				$('#form_3993').submit(function(e){
					//e.preventDefault();
				});
				
				var themeId = $('#theme_id').val();
				var data = $('#form_3993').serialize();
				var color = $('input[name="data[ThemeSetting][submenu_latest_hover_txt]"]').val();
				if(validator.form()){
					if(themeId.trim()!=''){
						$.ajax({
							type:'POST',
							url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
							data:data,
							beforeSend : function(res){
								$("#waitingDiv3993").show(); 
							},
							complete: function() {
								$("#waitingDiv3993").hide(); 
							},
							success:function(result){
								if(result.trim()==1){
									$('input[name="data[ThemeSetting][submenu_latest_hover_txt]"]').val(color);
									toastr.success('Latest post text hover Color saved!', 'Success :',{closeButton:true});
								}
							}
						});
					}
				}
				
			});
		});
		</script>




		
		
						
		</div>
	</div>
</div>









<div class="panel panel-default">
	<div class="panel-heading box-background alt-bg-color" style="padding-top: 1px; padding-bottom: 1px;height: 44px;">
		<h6 class="panel-title accordion_title" style="height: 30px;">
			<a href="#pricetable-manage-1-1" data-parent="#accordion-1" data-toggle="collapse" class="box-text collapsed">

				<h3 style="margin-top: 6px; margin-bottom: 0px;">Pricing Table Color Control</h3><br/>
			</a>
		</h6>
	</div>
	<div class="panel-collapse box-text collapse" id="pricetable-manage-1-1" style="height: 0px;">
		<div class="panel-body">


			<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_4000', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));											
			?>
			<div class="form-group">
				<label class="control-label col-md-3">Table Background Color<span class="required"></span>
				</label>
				<div class="col-md-4">
				
					<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_pricetable_bg']:'#219fd1'; ?>" data-color-format="rgba">
						<?php echo $this->Form->input('submenu_pricetable_bg',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['submenu_pricetable_bg']:'')); ?>
						<span class="input-group-btn">
							<button class="btn default" type="button">
								<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['submenu_pricetable_bg']))?$datasiteArr['SiteManagement']['submenu_pricetable_bg']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
							</button>
						</span>
					</div>
						<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'submenu_pricetable_bg' )); ?>
					<!-- /input-group -->
				</div>
				<div class="col-md-1">
				<?php
					echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_4000_btn', 'type'=>'button'));
				?>
				</div>
				<div class="col-md-1">
					<div id="waitingDiv4000" class="pull-right" style="display:none;">
						<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
					</div>
				</div>
			</div>
			<?php echo $this->Form->end(); ?>
			<script type="text/javascript">
			$(function(){
				var form = $('#form_4000');
				var error = $('.alert-danger', form);
				var success = $('.alert-success', form);
				
				var validator = form.validate({
					errorElement: 'span', //default input error message container
					errorClass: 'help-block', // default input error message class
					focusInvalid: false, // do not focus the last invalid input
					ignore: "", // validate all fields including form hidden input
					rules: {
						/* 'data[ThemeSetting][submenu_pricetable_bg]': {
							required: true
						} */
					},
					errorPlacement: function (error, element) { // render error placement for each input type
						error.insertAfter(element); // for other inputs, just perform default behavior
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
				
				$('#form_4000_btn').click(function(e){
					e.preventDefault();
					
					$('#form_4000').submit(function(e){
						//e.preventDefault();
					});
					
					var themeId = $('#theme_id').val();
					var data = $('#form_4000').serialize();
					var color = $('input[name="data[ThemeSetting][submenu_pricetable_bg]"]').val();
					if(validator.form()){
						if(themeId.trim()!=''){
							$.ajax({
								type:'POST',
								url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
								data:data,
								beforeSend : function(res){
									$("#waitingDiv4000").show(); 
								},
								complete: function() {
									$("#waitingDiv4000").hide(); 
								},
								success:function(result){
									if(result.trim()==1){
										$('input[name="data[ThemeSetting][submenu_pricetable_bg]"]').val(color);
										toastr.success('Table background color saved!', 'Success :',{closeButton:true});
									}
								}
							});
						}
					}
					
				});
			});
			</script>



			<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_4001', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));											
			?>
			<div class="form-group">
				<label class="control-label col-md-3">Table Content Color<span class="required"></span>
				</label>
				<div class="col-md-4">
				
					<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['pricetable_txt_clr']:'#219fd1'; ?>" data-color-format="rgba">
						<?php echo $this->Form->input('pricetable_txt_clr',array('class'=>"form-control",'placeholder'=>"Enter Content Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['pricetable_txt_clr']:'')); ?>
						<span class="input-group-btn">
							<button class="btn default" type="button">
								<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['pricetable_txt_clr']))?$datasiteArr['SiteManagement']['pricetable_txt_clr']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
							</button>
						</span>
					</div>
						<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'pricetable_txt_clr' )); ?>
					<!-- /input-group -->
				</div>
				<div class="col-md-1">
				<?php
					echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_4001_btn', 'type'=>'button'));
				?>
				</div>
				<div class="col-md-1">
					<div id="waitingDiv4001" class="pull-right" style="display:none;">
						<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
					</div>
				</div>
			</div>
			<?php echo $this->Form->end(); ?>
			<script type="text/javascript">
			$(function(){
				var form = $('#form_4001');
				var error = $('.alert-danger', form);
				var success = $('.alert-success', form);
				
				var validator = form.validate({
					errorElement: 'span', //default input error message container
					errorClass: 'help-block', // default input error message class
					focusInvalid: false, // do not focus the last invalid input
					ignore: "", // validate all fields including form hidden input
					rules: {
						/* 'data[ThemeSetting][pricetable_txt_clr]': {
							required: true
						} */
					},
					errorPlacement: function (error, element) { // render error placement for each input type
						error.insertAfter(element); // for other inputs, just perform default behavior
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
				
				$('#form_4001_btn').click(function(e){
					e.preventDefault();
					
					$('#form_4001').submit(function(e){
						//e.preventDefault();
					});
					
					var themeId = $('#theme_id').val();
					var data = $('#form_4001').serialize();
					var color = $('input[name="data[ThemeSetting][pricetable_txt_clr]"]').val();
					if(validator.form()){
						if(themeId.trim()!=''){
							$.ajax({
								type:'POST',
								url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
								data:data,
								beforeSend : function(res){
									$("#waitingDiv4001").show(); 
								},
								complete: function() {
									$("#waitingDiv4001").hide(); 
								},
								success:function(result){
									if(result.trim()==1){
										$('input[name="data[ThemeSetting][pricetable_txt_clr]"]').val(color);
										toastr.success('Table content color saved!', 'Success :',{closeButton:true});
									}
								}
							});
						}
					}
					
				});
			});
			</script>



			<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_4002', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));											
			?>
			<div class="form-group">
				<label class="control-label col-md-3">Table Button Color<span class="required"></span>
				</label>
				<div class="col-md-4">
				
					<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['pricetable_btn_background-color']:'#219fd1'; ?>" data-color-format="rgba">
						<?php echo $this->Form->input('pricetable_btn_background-color',array('class'=>"form-control",'placeholder'=>"Enter Button Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['pricetable_btn_background-color']:'')); ?>
						<span class="input-group-btn">
							<button class="btn default" type="button">
								<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['pricetable_btn_background-color']))?$datasiteArr['SiteManagement']['pricetable_btn_background-color']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
							</button>
						</span>
					</div>
						<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'pricetable_btn_background-color' )); ?>
					<!-- /input-group -->
				</div>
				<div class="col-md-1">
				<?php
					echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_4002_btn', 'type'=>'button'));
				?>
				</div>
				<div class="col-md-1">
					<div id="waitingDiv4002" class="pull-right" style="display:none;">
						<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
					</div>
				</div>
			</div>
			<?php echo $this->Form->end(); ?>
			<script type="text/javascript">
			$(function(){
				var form = $('#form_4002');
				var error = $('.alert-danger', form);
				var success = $('.alert-success', form);
				
				var validator = form.validate({
					errorElement: 'span', //default input error message container
					errorClass: 'help-block', // default input error message class
					focusInvalid: false, // do not focus the last invalid input
					ignore: "", // validate all fields including form hidden input
					rules: {
						/* 'data[ThemeSetting][pricetable_btn_background-color]': {
							required: true
						} */
					},
					errorPlacement: function (error, element) { // render error placement for each input type
						error.insertAfter(element); // for other inputs, just perform default behavior
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
				
				$('#form_4002_btn').click(function(e){
					e.preventDefault();
					
					$('#form_4002').submit(function(e){
						//e.preventDefault();
					});
					
					var themeId = $('#theme_id').val();
					var data = $('#form_4002').serialize();
					var color = $('input[name="data[ThemeSetting][pricetable_btn_background-color]"]').val();
					if(validator.form()){
						if(themeId.trim()!=''){
							$.ajax({
								type:'POST',
								url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
								data:data,
								beforeSend : function(res){
									$("#waitingDiv4002").show(); 
								},
								complete: function() {
									$("#waitingDiv4002").hide(); 
								},
								success:function(result){
									if(result.trim()==1){
										$('input[name="data[ThemeSetting][pricetable_btn_background-color]"]').val(color);
										toastr.success('Button color saved!', 'Success :',{closeButton:true});
									}
								}
							});
						}
					}
					
				});
			});
			</script>




			<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_resetcolorupdate/'.$data['ThemeSetting']['id']), "type"=>"file", 'id'=>'form_4003', 'onsubmit'=>'return confirm("Do you want to reset?");', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));											
			?>
			<div class="form-group">
				<label class="control-label col-md-3">Button Text Color<span class="required"></span>
				</label>
				<div class="col-md-4">
				
					<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($datasiteArr))?$datasiteArr['SiteManagement']['pricetable_btn_txt_clr']:'#219fd1'; ?>" data-color-format="rgba">
						<?php echo $this->Form->input('pricetable_btn_txt_clr',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($datasiteArr))?$datasiteArr['SiteManagement']['pricetable_btn_txt_clr']:'')); ?>
						<span class="input-group-btn">
							<button class="btn default" type="button">
								<i style="background-color: <?php echo (!empty($datasiteArr))?(!empty($datasiteArr['SiteManagement']['control_des']['pricetable_btn_txt_clr']))?$datasiteArr['SiteManagement']['pricetable_btn_txt_clr']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
							</button>
						</span>
					</div>
						<?php echo $this->Form->input('field_name', array('type'=>'hidden','value'=>'pricetable_btn_txt_clr' )); ?>
					<!-- /input-group -->
				</div>
				<div class="col-md-1">
				<?php
					echo $this->Form->button('Save', array('class'=>'btn btn-primary', 'id'=>'form_4003_btn', 'type'=>'button'));
				?>
				</div>
				<div class="col-md-1">
					<div id="waitingDiv4003" class="pull-right" style="display:none;">
						<img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" />
					</div>
				</div>
			</div>
			<?php echo $this->Form->end(); ?>
			<script type="text/javascript">
			$(function(){
				var form = $('#form_4003');
				var error = $('.alert-danger', form);
				var success = $('.alert-success', form);
				
				var validator = form.validate({
					errorElement: 'span', //default input error message container
					errorClass: 'help-block', // default input error message class
					focusInvalid: false, // do not focus the last invalid input
					ignore: "", // validate all fields including form hidden input
					rules: {
						/* 'data[ThemeSetting][pricetable_btn_txt_clr]': {
							required: true
						} */
					},
					errorPlacement: function (error, element) { // render error placement for each input type
						error.insertAfter(element); // for other inputs, just perform default behavior
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
				
				$('#form_4003_btn').click(function(e){
					e.preventDefault();
					
					$('#form_4003').submit(function(e){
						//e.preventDefault();
					});
					
					var themeId = $('#theme_id').val();
					var data = $('#form_4003').serialize();
					var color = $('input[name="data[ThemeSetting][pricetable_btn_txt_clr]"]').val();
					if(validator.form()){
						if(themeId.trim()!=''){
							$.ajax({
								type:'POST',
								url:'<?php echo $this->Html->url(array('controller'=>'Themes', 'action'=>'admin_ajaxcolorupdate/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>',
								data:data,
								beforeSend : function(res){
									$("#waitingDiv4003").show(); 
								},
								complete: function() {
									$("#waitingDiv4003").hide(); 
								},
								success:function(result){
									if(result.trim()==1){
										$('input[name="data[ThemeSetting][pricetable_btn_txt_clr]"]').val(color);
										toastr.success('Button text color saved!', 'Success :',{closeButton:true});
									}
								}
							});
						}
					}
					
				});
			});
			</script>



		</div>
	</div>
</div>











				
				
				<?php //echo $this->Form->end(); ?>
				<!-- END FORM-->
			<!-- END VALIDATION STATES-->
		</div>
	</div>
</div>
</div>

<script type="text/javascript">
$(function(){
	$('#headerLayouFld').change(function(e){
		var layout = $(this).val();
		var submitUrl = $(this).attr("data-url");
		
		if(layout.trim()!=""){
			$.ajax({
				type:"POST",
				url:submitUrl,
				data:{layout:layout},
				success:function(result){
					if(result.trim()!=""){
						$('#ajaxheaderMenuStyleDiv').html(result);
					} else {
						$('#ajaxheaderMenuStyleDiv').html(result);
					}
				}
			});
		}
	});
	
	$('#backupcss').click(function(e){
		$("#backupcssloader").show(); 
		var url='<?php echo $this->Html->url(array('controller'=>'Themes','action'=>'admin_ajaxbackupcss/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>';
		$.post(url,{id:1},function(res){
		    $("#backupcssloader").hide(); 
			if(res)
			{
			  toastr.success('The css file has been backed up in the system!', 'Success :',{closeButton:true});
			}
			
		});	
	});
	
$('#restorecss').click(function(e){
	$("#restorecssloader").show(); 
		var url='<?php echo $this->Html->url(array('controller'=>'Themes','action'=>'admin_ajaxbackupcss/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>';
		var url='<?php echo $this->Html->url(array('controller'=>'Themes','action'=>'admin_ajaxrestorecss/'.$data['ThemeSetting']['id'], 'full_base'=>true)); ?>';
		$.post(url,{id:1},function(res){
		    $("#restorecssloader").hide(); 
			if(res)
			{
			  toastr.success('The css file has been restored in the system!', 'Success :',{closeButton:true});
			}
			
		});	
		
	});
	
		
	$('.bgselect').change(function(e){
		
		var radioval = $(this).val();
		// alert();
		$('.radioOptDiv').hide();
		$('#'+radioval+'Div').show();
		//$('input[name="data[ThemeSetting][background_img]"]').attr('checked', null); 
		
		
		$('.radio1').each(function(){
		 $(this).attr('checked', false);
		 });
		
	});
	
	
});
</script>

