<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$layoutArr = array('FULL_WIDTH'=>'Full Width','LEFT_BAR_2_COLS'=>'Left Bar(2 Cols)','RIGHT_BAR_2_COLS'=>'Right Bar(2 Cols)','LEFT_RIGHT_BAR_3_COLS'=>'Left/Right Bar(3 Cols)');
	if(isset($data['Page']) && $data['Page']['slug']=='home')
	{
		$page_style = array('home shop'=>'Home Shop','home blog'=>'Home Blog','home corporate : v1'=>'Home Corporate Version 1','home corporate : v2'=>'Home Corporate Version 2','home corporate : v3'=>'Home Corporate Version 3','home corporate : v5'=>'Home Corporate Version 4','home corporate : v6'=>'Home Corporate Version 5');
	}
	else
	{
		$page_style = array('About Us'=>'About Us','Contact Page 1'=>'Contact Page 1','Contact Page 2'=>'Contact Page 2','Page: Sidebar - L'=>'Page: Sidebar - L','Page: Sidebar - R'=>'Page: Sidebar - R','F.A.Q.'=>'F.A.Q.','Product Launch'=>'Product Launch','Services'=>'Services','404'=>'404 Page','Typography'=>'Typography','Login'=>'Login','Forum'=>'Forum');
	}

	$VerArray = array();	
	if(isset($data['PageVersion']))
	{
		foreach($data['PageVersion'] as $pageVersions)
		{
			array_push($VerArray,$pageVersions['date']);
		}
	}
	
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i><?php echo (isset($id))?'Edit':'Add' ?> Page
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('Page', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
						<?php echo $this->Form->input('id',array("id"=>"id","type"=>"hidden","label"=>false,"value"=> $id)); ?>
						
						<h3 class="form-section">Meta Data</h3>
						
						<div class="form-group">
							<label class="control-label col-md-3">Meta Title <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
									echo $this->Form->input('metatitle', array(
															'type' => "text",
															'placeholder'=>"Enter Page Meta Title",
															'value' => (isset($data['Page']))?$data['Page']['metatitle']:'', 
															'class' => "form-control"
														)); 
								?>
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="control-label col-md-3">Meta Keywords <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
									echo $this->Form->input('metakeywords', array(
															'type' => "text",
															'placeholder'=>"Enter Page Meta Keywords",
															'value' => (isset($data['Page']))?$data['Page']['metakeywords']:'', 
															'class' => "form-control"
														)); 
								?>
							</div>
						</div>
						
						
						
						
						
						<div class="form-group">
							<label class="control-label col-md-3">Meta Description <span class="required">
							* </span>
							</label>
							<div class="col-md-6">
								<?php 
									echo $this->Form->input('metadescription', array(
															'type' => "textarea",
															'placeholder'=>"Enter Page Meta Description",
															'value' => (isset($data['Page']))?$data['Page']['metadescription']:'', 
															'class' => "form-control"
														)); 
								?>
							</div>
						</div>
						
						<h3 class="form-section"><?php 
							if(isset($data['Page']['type']) && $data['Page']['type']=='Page')
							{
								echo 'Page Details';
							}
							else
							{
								echo 'Post Details';
							}

						?>  </h3>
						
						<?php if(isset($id)){ ?>
						<div class="form-group">
							<label class="control-label col-md-3">Page Slug <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('slug',array('value'=>(isset($data['Page']))?$data['Page']['slug']:'', 'id'=>"slug", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Page Slug", 'type'=>"text")); ?>
								<?php echo $this->Form->input('set_slug',array('value'=>(isset($data['Page']))?$data['Page']['slug']:'', 'type'=>"hidden")); ?>
							</div>
						</div>
						<?php } ?>
						
						<?php if(!empty($id)){ ?>
						<div class="form-group">
							<label class="control-label col-md-3">Page URL <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('page_url',array('value'=>(isset($data['Page']))?$data['Page']['page_url']:'', 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Page URL", 'type'=>"text")); ?>
							</div>
						</div>
						<?php } ?>
						
						<div class="form-group">
							<label class="control-label col-md-3"> Title <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('title',array('value'=>(isset($data['Page']))?$data['Page']['title']:'', 'id'=>"title", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Page Title", 'type'=>"text")); ?>
							</div>
						</div>
						<?php if(isset($data['Page']['type']) && $data['Page']['type']=='Page'){ ?>
						<div class="form-group">
							<label class="control-label col-md-3">Summary 
							</label>
							<div class="col-md-6">
								<?php 
									echo $this->Form->input('summery', array(
										'type' => "textarea",
										'id' => 'summery',
										'value' => (isset($data['Page']))?$data['Page']['summery']:'', 
										'class' => "form-control"
									)); 
								?>
								<div id="editor2_error"></div>
							</div>
						</div>
						<?php } ?>
						
						<div class="form-group">
							<label class="col-md-3 control-label">Page Template
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('template', array(
																'options' => $page_style,
																'empty' => 'Select Template',	
																'class' => 'form-control',
																'id'=>'template',
																'selected'=> (isset($data['Page']))?$data['Page']['template']:''
															));
									?>  
								</div>
							</div>
						</div>
						
						
						
						
						<div class="form-group" id="pos">
							<label class="control-label col-md-3">Page Content <span class="required">
							* </span>
							</label>
							<div class="col-md-12">
								<?php 
									echo $this->Form->input('content', array(
										'type' => "textarea",
										'id' => 'content',
										'value' => (isset($data['Page']))?$data['Page']['content']:'', 
										'class' => "ckeditor form-control",
										'data-error-container'=>'#editor2_error'
									)); 
								?>
								<div id="editor2_error"></div>
							</div>
						</div>
												
						<!--<div class="form-group">
							<label class="control-label col-md-3">Image </label>
							<div class="col-md-8">
								<?php
									if(!empty($data['Page']['cms_image'])){
										echo '<div class="col-md-3">';
										echo $this->Html->image(IMGPATH.'cms_image/thumb/'.$data['Page']['cms_image'], array('alt'=>'Image'));
										echo '</div>';
										echo '<div class="col-md-4">';
										echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array(
											'controller'=>'Pages',
											'action'=>'admin_imgdelete',
											'image_name'=>$data['Page']['cms_image'],
											'id'=>$id
										), 
										array('confirm' => 'Are you Sure?', 'escape'=>false, 'full_base'=>true, 'class'=>'btn default btn-xs red')
										);
										echo '</div>';
										echo $this->Form->input('set_cms_image', array('type'=>'hidden','value'=>$data['Page']['cms_image'],'class'=>'set'));
									} else {
										echo $this->Form->input('cms_image', array(
															'type' => "file"
														));  
										echo " &nbsp "."<font color='red'>(Recommended Size 560 x 480)</font>"; 
										echo $this->Form->input('set_cms_image', array('type'=>'hidden','value'=>'','class'=>'set'));
									}
								?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Image Caption </label>
							<div class="col-md-4">
								<?php 
									echo $this->Form->input('image_caption', array(
															'type' => "text",
															'placeholder'=>"Enter Page Image Caption",
															'value' => (isset($data['Page']))?$data['Page']['image_caption']:'', 
															'class' => "form-control"
														)); 
								?>
							</div>
						</div>-->
						
						<div class="form-group">
							<label class="col-md-3 control-label">Latest Version</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										$i=1;
										foreach($VerArray as $ver)
										{
									?>
										<a href="javascript:void(0)" rel="<?php echo $ver; ?>" class="version btn btn-small">Version - <?php echo $i; ?></a>
									<?php		
											$i++;
										}
									?>  
								</div>
							</div>
						</div>
						
						
						<!--<div class="form-group">
							<label class="col-md-3 control-label">Select Gallery 
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('cms_gallery_id', array(
																'options' => $cmsGallery,
																'empty' => 'Select Status',	
																'class' => 'form-control',
																'selected'=> (isset($data['Page']))?$data['Page']['cms_gallery_id']:''
															));
									?>  
								</div>
							</div>
						</div>-->
						
						<!--<div class="form-group">
							<label class="col-md-3 control-label">Select Page Layout <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('page_layout', array(
																'options' => $layoutArr,
																'empty' => 'Select Layout',	
																'class' => 'form-control',
																'selected'=> (isset($data['Page']))?$data['Page']['page_layout']:''
															));
									?>  
								</div>
							</div>
						</div>-->
                        
                        <div class="form-group">
							<label class="col-md-3 control-label">Select Status <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('is_active', array(
																'options' => $statusArr,
																'empty' => 'Select Status',	
																'class' => 'form-control',
																'selected'=> (isset($data['Page']))?$data['Page']['is_active']:''
															));
									?>  
								</div>
							</div>
						</div>
						
						
						
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
							<?php echo $this->Form->button('Save', array('type' => 'submit', 'name'=>'continue', 'value'=>'s', 'class'=>"btn blue"));?>
							<?php echo $this->Form->button('Save & Close', array('type' => 'submit', 'class'=>"btn blue"));?>
							<?php echo $this->Form->button('Cancel', array('type' => 'reset', 'class'=>"btn default",'onclick'=>'window.history.back()'));?>
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
			'data[Page][title]': {
				required: true
			},
			'data[Page][content]': {
				required: true
			},
			'data[Page][metatitle]': {
				required: true
			}, 
			'data[Page][metakeywords]': {
				required: true
			},
			'data[Page][metadescription]': {
				required: true
			},
			'data[Page][is_active]': {
				required: true
			},
			'data[Page][page_layout]': {
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

<script type="text/javascript">
$(document).ready(function() {
   $("#template").change(function(){
		var val = $(this).val();
		$.ajax({
			type:'POST',
			url:'<?php echo $this->Html->url(array('controller'=>'Pages','action'=>'admin_template','full_base'=>true)); ?>',
			data:{template:val},
			success:function(result){
				CKEDITOR.instances['content'].setData(result)
			}
		});
   })
   
   
   $(".version").click(function(){
		var id = $("#id").val();
		
		var val = $(this).attr('rel');
		
		$.ajax({
			type:'POST',
			url:'<?php echo $this->Html->url(array('controller'=>'Pages','action'=>'admin_version','full_base'=>true)); ?>',
			data:{id:id,version:val},
			success:function(result){
				CKEDITOR.instances['content'].setData(result);
				$('html, body').animate({scrollTop:$('#pos').position().top}, 'slow');
			}
		});
   })
   
   
});
</script>

<div id="content"></div>



