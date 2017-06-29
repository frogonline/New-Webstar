<?php
$headerLayoutArr = array('header_layout_1'=>'Header Layout 1', 'header_layout_2'=>'Header Layout 2', 'header_layout_3'=>'Header Layout 3', 'header_layout_4'=>'Header Layout 4', 'header_layout_5'=>'Header Layout 5','custom-1'=>'Header Boxed Style', 'custom-2'=>'Header Iconic Style', 'custom-3'=>'Header IOS Style', 'custom-4'=>'Header Metro Style', 'custom-5'=>'Header Tab Style');

$headermenuArr = array('menu-1'=>'Header Menu Style : V1', 'menu-2'=>'Header Menu Style : V2', 'menu-3'=>'Header Menu Style : V3', 'menu-4'=>'Header Menu Style : V4', 'menu-5'=>'Header Menu Style : V5');
$stickyheaderArr = array('yes'=>'Yes','no'=>'No');
$boxlayoutArr = array('yes'=>'Yes','no'=>'No');
$shadowArr = array('v0'=>'No Shadow', 'v1'=>'Shadow Style 1', 'v2'=>'Shadow Style 2', 'v3'=>'Shadow Style 3', 'v4'=>'Shadow Style 4', 'v5'=>'Shadow Style 5');

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
//pr($data);
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?> Themes
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('ThemeSetting', array('url'=>array('controller'=>'Themes','action' => 'admin_manage/'.$id), 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
						<?php echo $this->Form->input('theme_id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
						<div class="form-group">
							<label class="control-label col-md-3">Header Layout <span class="required">* </span>
							</label>
							<div class="col-md-4">
								<?php 
								echo $this->Form->input('header_layout', array(
										'options'=>$headerLayoutArr,
										'empty'=>'--- Select Layout ---',
										'class'=>'form-control',
										'selected'=>(!empty($data))?$data['ThemeSetting']['header_layout']:''
									)
								); 
								?>
							</div>
						</div>
						<div class="form-group">
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
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Sticky Header <span class="required">* </span>
							</label>
							<div class="col-md-4">
								<?php 
								echo $this->Form->input('sticky_header', array(
										'options'=>$stickyheaderArr,
										'empty'=>'--- Select Layout ---',
										'class'=>'form-control',
										'selected'=>(!empty($data))?$data['ThemeSetting']['sticky_header']:''
									)
								); 
								?>
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
						<div class="form-group">
							<label class="control-label col-md-3">Background Type <span class="required">* </span>
							</label>
							<div class="col-md-4 radio-list">
								<?php 
								echo $this->Form->input('background_type', array(
										'options'=>array('image'=>'Image', 'pattern'=>'Pattern'),
										'before' => '<label>',
										'after' => '</label>',
										'separator' => '</label><label>',
										'type'=>'radio',
										'value'=>(!empty($data))?$data['ThemeSetting']['background_type']:'',
										'class'=>'bgradio',
										'legend'=>false,
										'hiddenField'=>false
									)
								); 
								?>
							</div>
						</div>
						<div class="form-group radioOptDiv" style="display:none;" id="imageDiv">
							<label class="control-label col-md-3">Background Image <span class="required">* </span>
							</label>
							<div class="col-md-4 radio-list">
								<?php 
								echo $this->Form->input('background_img', array(
										'options'=>array(
											'01.png'=>$this->Html->image(CURRENT_THEME_URL.'img/bg/01.png', array('alt'=>'', 'class'=>'img-responsive')),
											'02.png'=>$this->Html->image(CURRENT_THEME_URL.'img/bg/02.png', array('alt'=>'','class'=>'img-responsive')),
											'03.png'=>$this->Html->image(CURRENT_THEME_URL.'img/bg/03.png', array('alt'=>'','class'=>'img-responsive')),
											'04.png'=>$this->Html->image(CURRENT_THEME_URL.'img/bg/04.png', array('alt'=>'','class'=>'img-responsive')),
											'05.png'=>$this->Html->image(CURRENT_THEME_URL.'img/bg/05.png', array('alt'=>'','class'=>'img-responsive'))
											),
										'before' => '<label class="col-md-3">',
										'after' => '</label>',
										'separator' => '</label><label class="col-md-3">',
										'type'=>'radio',
										'value'=>(!empty($data))?$data['ThemeSetting']['background_img']:'',
										'legend'=>false,
										'hiddenField'=>false
									)
								); 
								?>
							</div>
						</div>
						<div class="form-group radioOptDiv" style="display:none;" id="patternDiv">
							<label class="control-label col-md-3">Background Pattern <span class="required">* </span>
							</label>
							<div class="col-md-4 radio-list">
								<?php 
								echo $this->Form->input('background_img', array(
										'options'=>array(
											'black_linen_v2.png'=>$this->Html->image(CURRENT_THEME_URL.'img/pattern/black_linen_v2.png', array('alt'=>'', 'class'=>'img-responsive')),
											'denim.png'=>$this->Html->image(CURRENT_THEME_URL.'img/pattern/denim.png', array('alt'=>'','class'=>'img-responsive')),
											'greyzz.png'=>$this->Html->image(CURRENT_THEME_URL.'img/pattern/greyzz.png', array('alt'=>'','class'=>'img-responsive')),
											'whitey.png'=>$this->Html->image(CURRENT_THEME_URL.'img/pattern/whitey.png', array('alt'=>'','class'=>'img-responsive')),
											'wood_1.png'=>$this->Html->image(CURRENT_THEME_URL.'img/pattern/wood_1.png', array('alt'=>'','class'=>'img-responsive'))
											),
										'before' => '<label class="col-md-3">',
										'after' => '</label>',
										'separator' => '</label><label class="col-md-3">',
										'type'=>'radio',
										'value'=>(!empty($data))?$data['ThemeSetting']['background_img']:'',
										'legend'=>false,
										'hiddenField'=>false
									)
								);  
								?>
							</div>
						</div>
						<!--<div class="form-group">
							<label class="control-label col-md-3">Background Color <span class="required">* </span>
							</label>
								<div class="col-md-4">
									<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($data))?$data['ThemeSetting']['background_color']:'#3865a8'; ?>" data-color-format="rgba">
										<?php echo $this->Form->input('background_color',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text",  'value'=>(!empty($data))?$data['ThemeSetting']['background_color']:'')); ?>
										<span class="input-group-btn">
											<button class="btn default" type="button">
												<i style="background-color: <?php echo (!empty($data))?$data['ThemeSetting']['background_color']:'#3865a8'; ?>;"></i>&nbsp;
											</button>
										</span>
									</div>
								</div>
						</div>-->
						<div class="form-group">
							<label class="control-label col-md-3">Font Family <span class="required">* </span>
							</label>
							<div class="col-md-4">
								<?php 
								echo $this->Form->input('theme_font', array(
										'options'=>$fontfamilyArr,
										'empty'=>'--- Select Layout ---',
										'class'=>'form-control',
										'selected'=>(!empty($data))?$data['ThemeSetting']['theme_font']:''
									)
								); 
								
								echo $this->Form->input('previous_theme_font', array('type'=>'hidden','value'=>(!empty($data))?$data['ThemeSetting']['theme_font']:'"Open Sans",sans-serif' ));
								?>
							</div>
						</div>
						<h3>Colour Sections</h3>
						<div class="form-group">
							<label class="control-label col-md-3">Background Color <span class="required">* </span>
							</label>
								<div class="col-md-4">
									<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($data))?$data['ThemeSetting']['background_color']:'#219fd1'; ?>" data-color-format="rgba">
										<?php echo $this->Form->input('background_color',array('class'=>"form-control",'placeholder'=>"Enter Background Color", 'type'=>"text", 'value'=>(!empty($data))?$data['ThemeSetting']['background_color']:'')); ?>
										<span class="input-group-btn">
											<button class="btn default" type="button">
												<i style="background-color: <?php echo (!empty($data))?(!empty($data['ThemeSetting']['background_color']))?$data['ThemeSetting']['background_color']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
											</button>
										</span>
									</div>
									<?php echo $this->Form->input('previous_background_color', array('type'=>'hidden','value'=>(!empty($data))?$data['ThemeSetting']['background_color']:'#219fd1' )); ?>
								</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Main Color <span class="required">* </span>
							</label>
								<div class="col-md-4">
									<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($data))?$data['ThemeSetting']['foreground_color']:'#219fd1'; ?>" data-color-format="rgba">
										<?php echo $this->Form->input('foreground_color',array('class'=>"form-control",'placeholder'=>"Enter Foreground Color", 'type'=>"text", 'value'=>(!empty($data))?$data['ThemeSetting']['foreground_color']:'')); ?>
										<span class="input-group-btn">
											<button class="btn default" type="button">
												<i style="background-color: <?php echo (!empty($data))?(!empty($data['ThemeSetting']['foreground_color']))?$data['ThemeSetting']['foreground_color']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
											</button>
										</span>
									</div>
									<?php echo $this->Form->input('previous_foreground_color', array('type'=>'hidden','value'=>(!empty($data))?$data['ThemeSetting']['foreground_color']:'#219fd1' )); ?>
									<!-- /input-group -->
								</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Header Top Background Color <span class="required">* </span>
							</label>
								<div class="col-md-4">
									<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($data))?$data['ThemeSetting']['header_top_background_color']:'#219fd1'; ?>" data-color-format="rgba">
										<?php echo $this->Form->input('header_top_background_color',array('class'=>"form-control",'placeholder'=>"Enter Header Top Background Color", 'type'=>"text", 'value'=>(!empty($data))?$data['ThemeSetting']['header_top_background_color']:'')); ?>
										<span class="input-group-btn">
											<button class="btn default" type="button">
												<i style="background-color: <?php echo (!empty($data))?(!empty($data['ThemeSetting']['header_top_background_color']))?$data['ThemeSetting']['header_top_background_color']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
											</button>
										</span>
									</div>
									<?php echo $this->Form->input('previous_header_top_background_color', array('type'=>'hidden','value'=>(!empty($data))?$data['ThemeSetting']['header_top_background_color']:'#219fd1' )); ?>
									<!-- /input-group -->
								</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Header Bottom Background Color <span class="required">* </span>
							</label>
								<div class="col-md-4">
									<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($data))?$data['ThemeSetting']['header_background_color']:'#219fd1'; ?>" data-color-format="rgba">
										<?php echo $this->Form->input('header_background_color',array('class'=>"form-control",'placeholder'=>"Enter Header Background Color", 'type'=>"text", 'value'=>(!empty($data))?$data['ThemeSetting']['header_background_color']:'')); ?>
										<span class="input-group-btn">
											<button class="btn default" type="button">
												<i style="background-color: <?php echo (!empty($data))?(!empty($data['ThemeSetting']['header_background_color']))?$data['ThemeSetting']['header_background_color']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
											</button>
										</span>
									</div>
									<?php echo $this->Form->input('previous_header_background_color', array('type'=>'hidden','value'=>(!empty($data))?$data['ThemeSetting']['header_background_color']:'#219fd1' )); ?>
									<!-- /input-group -->
								</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Footer Top Background Color <span class="required">* </span>
							</label>
								<div class="col-md-4">
									<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($data))?$data['ThemeSetting']['wide_footer_background_color']:'#219fd1'; ?>" data-color-format="rgba">
										<?php echo $this->Form->input('wide_footer_background_color',array('class'=>"form-control",'placeholder'=>"Enter Wide Footer Background Color", 'type'=>"text", 'value'=>(!empty($data))?$data['ThemeSetting']['wide_footer_background_color']:'')); ?>
										<span class="input-group-btn">
											<button class="btn default" type="button">
												<i style="background-color: <?php echo (!empty($data))?(!empty($data['ThemeSetting']['wide_footer_background_color']))?$data['ThemeSetting']['wide_footer_background_color']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
											</button>
										</span>
									</div>
									<?php echo $this->Form->input('previous_wide_footer_background_color', array('type'=>'hidden','value'=>(!empty($data))?$data['ThemeSetting']['wide_footer_background_color']:'#219fd1' )); ?>
								</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Footer Bottom Background Color <span class="required">* </span>
							</label>
								<div class="col-md-4">
									<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($data))?$data['ThemeSetting']['thin_footer_background_color']:'#219fd1'; ?>" data-color-format="rgba">
										<?php echo $this->Form->input('thin_footer_background_color',array('class'=>"form-control",'placeholder'=>"Enter Thin Footer Background Color", 'type'=>"text", 'value'=>(!empty($data))?$data['ThemeSetting']['thin_footer_background_color']:'')); ?>
										<span class="input-group-btn">
											<button class="btn default" type="button">
												<i style="background-color: <?php echo (!empty($data))?(!empty($data['ThemeSetting']['thin_footer_background_color']))?$data['ThemeSetting']['thin_footer_background_color']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
											</button>
										</span>
									</div>
									<?php echo $this->Form->input('previous_thin_footer_background_color', array('type'=>'hidden','value'=>(!empty($data))?$data['ThemeSetting']['thin_footer_background_color']:'#219fd1' )); ?>
									<!-- /input-group -->
								</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Box Background Color <span class="required">* </span>
							</label>
								<div class="col-md-4">
									<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($data))?$data['ThemeSetting']['box_background_color']:'#219fd1'; ?>" data-color-format="rgba">
										<?php echo $this->Form->input('box_background_color',array('class'=>"form-control",'placeholder'=>"Enter Box Background Color", 'type'=>"text", 'value'=>(!empty($data))?$data['ThemeSetting']['box_background_color']:'')); ?>
										<span class="input-group-btn">
											<button class="btn default" type="button">
												<i style="background-color: <?php echo (!empty($data))?(!empty($data['ThemeSetting']['box_background_color']))?$data['ThemeSetting']['box_background_color']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
											</button>
										</span>
									</div>
									<?php echo $this->Form->input('previous_box_background_color', array('type'=>'hidden','value'=>(!empty($data))?$data['ThemeSetting']['box_background_color']:'#219fd1' )); ?>
									<!-- /input-group -->
								</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Box Text Color <span class="required">* </span>
							</label>
								<div class="col-md-4">
									<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($data))?$data['ThemeSetting']['box_text_color']:'#219fd1'; ?>" data-color-format="rgba">
										<?php echo $this->Form->input('box_text_color',array('class'=>"form-control",'placeholder'=>"Enter Box Text Color", 'type'=>"text", 'value'=>(!empty($data))?$data['ThemeSetting']['box_text_color']:'')); ?>
										<span class="input-group-btn">
											<button class="btn default" type="button">
												<i style="background-color: <?php echo (!empty($data))?(!empty($data['ThemeSetting']['box_text_color']))?$data['ThemeSetting']['box_text_color']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
											</button>
										</span>
									</div>
									<?php echo $this->Form->input('previous_box_text_color', array('type'=>'hidden','value'=>(!empty($data))?$data['ThemeSetting']['box_text_color']:'#219fd1' )); ?>
									<!-- /input-group -->
								</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">H1 Tag Color <span class="required">* </span>
							</label>
								<div class="col-md-4">
									<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($data))?$data['ThemeSetting']['h1_tag_color']:'#219fd1'; ?>" data-color-format="rgba">
										<?php echo $this->Form->input('h1_tag_color',array('class'=>"form-control",'placeholder'=>"Enter H1 Color", 'type'=>"text", 'value'=>(!empty($data))?$data['ThemeSetting']['h1_tag_color']:'')); ?>
										<span class="input-group-btn">
											<button class="btn default" type="button">
												<i style="background-color: <?php echo (!empty($data))?(!empty($data['ThemeSetting']['h1_tag_color']))?$data['ThemeSetting']['h1_tag_color']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
											</button>
										</span>
									</div>
									<?php echo $this->Form->input('previous_h1_tag_color', array('type'=>'hidden','value'=>(!empty($data))?$data['ThemeSetting']['h1_tag_color']:'#219fd1' )); ?>
									<!-- /input-group -->
								</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">H2 Tag Color <span class="required">* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($data))?$data['ThemeSetting']['h2_tag_color']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('h2_tag_color',array('class'=>"form-control",'placeholder'=>"Enter H2 Tag Color", 'type'=>"text", 'value'=>(!empty($data))?$data['ThemeSetting']['h2_tag_color']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($data))?(!empty($data['ThemeSetting']['h2_tag_color']))?$data['ThemeSetting']['h2_tag_color']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
								<?php echo $this->Form->input('previous_h2_tag_color', array('type'=>'hidden','value'=>(!empty($data))?$data['ThemeSetting']['h2_tag_color']:'#219fd1' )); ?>
								<!-- /input-group -->
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">H3 Tag Color <span class="required">* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($data))?$data['ThemeSetting']['h3_tag_color']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('h3_tag_color',array('class'=>"form-control",'placeholder'=>"Enter H3 Tag Color", 'type'=>"text", 'value'=>(!empty($data))?$data['ThemeSetting']['h3_tag_color']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($data))?(!empty($data['ThemeSetting']['h3_tag_color']))?$data['ThemeSetting']['h3_tag_color']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
								<?php echo $this->Form->input('previous_h3_tag_color', array('type'=>'hidden','value'=>(!empty($data))?$data['ThemeSetting']['h3_tag_color']:'#219fd1' )); ?>
								<!-- /input-group -->
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">H4, H5, H6 Tag Color <span class="required">* </span>
							</label>
								<div class="col-md-4">
									<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($data))?$data['ThemeSetting']['h4_tag_color']:'#219fd1'; ?>" data-color-format="rgba">
										<?php echo $this->Form->input('h4_tag_color',array('class'=>"form-control",'placeholder'=>"Enter H4, H5, H6 Tag Color", 'type'=>"text", 'value'=>(!empty($data))?$data['ThemeSetting']['h4_tag_color']:'')); ?>
										<span class="input-group-btn">
											<button class="btn default" type="button">
												<i style="background-color: <?php echo (!empty($data))?(!empty($data['ThemeSetting']['h4_tag_color']))?$data['ThemeSetting']['h4_tag_color']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
											</button>
										</span>
									</div>
									<?php echo $this->Form->input('previous_h4_tag_color', array('type'=>'hidden','value'=>(!empty($data))?$data['ThemeSetting']['h4_tag_color']:'#219fd1' )); ?>
									<!-- /input-group -->
								</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Contact Form Color <span class="required">* </span>
							</label>
								<div class="col-md-4">
									<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($data))?$data['ThemeSetting']['contact_form_color']:'#219fd1'; ?>" data-color-format="rgba">
										<?php echo $this->Form->input('contact_form_color',array('class'=>"form-control",'placeholder'=>"Enter Contact Form Color", 'type'=>"text", 'value'=>(!empty($data))?$data['ThemeSetting']['contact_form_color']:'')); ?>
										<span class="input-group-btn">
											<button class="btn default" type="button">
												<i style="background-color: <?php echo (!empty($data))?(!empty($data['ThemeSetting']['contact_form_color']))?$data['ThemeSetting']['contact_form_color']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
											</button>
										</span>
									</div>
									<?php echo $this->Form->input('previous_contact_form_color', array('type'=>'hidden','value'=>(!empty($data))?$data['ThemeSetting']['contact_form_color']:'#219fd1' )); ?>
									<!-- /input-group -->
								</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Anchor Tag Color <span class="required">* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group color colorpicker-default" data-color="<?php echo (!empty($data))?$data['ThemeSetting']['a_tag_color']:'#219fd1'; ?>" data-color-format="rgba">
									<?php echo $this->Form->input('a_tag_color',array('class'=>"form-control",'placeholder'=>"Enter Anchor Color", 'type'=>"text", 'value'=>(!empty($data))?$data['ThemeSetting']['a_tag_color']:'')); ?>
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i style="background-color: <?php echo (!empty($data))?(!empty($data['ThemeSetting']['a_tag_color']))?$data['ThemeSetting']['a_tag_color']:'#219fd1':'#219fd1'; ?>;"></i>&nbsp;
										</button>
									</span>
								</div>
								<?php echo $this->Form->input('previous_a_tag_color', array('type'=>'hidden','value'=>(!empty($data))?$data['ThemeSetting']['a_tag_color']:'#219fd1' )); ?>
								<!-- /input-group -->
							</div>
						</div>
						<div class="form-actions fluid">
							<div class="col-md-offset-3 col-md-9">
								<?php echo $this->Form->button('Save', array('type' => 'submit', 'name'=>'continue', 'value'=>'s', 'class'=>"btn blue"));?>
								<?php echo $this->Form->button('Save & Close', array('type' => 'submit', 'class'=>"btn blue"));?>
								<?php echo $this->Form->button('Cancel', array('type' => 'reset','onclick'=>'window.history.back()', 'class'=>"btn default",'div'=>false));?>
							</div>
						</div>
					</div>
				<?php echo $this->Form->end(); ?>
				<!-- END FORM-->
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

	