<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$headingfrontend_flagArr = array('Y'=>'Yes','N'=>'No');
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?> GalleryManagement
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('GalleryManagement', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
					<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
						
						<div class="form-group">
							<label class="control-label col-md-3">Gallery Name <span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('name',array('value'=>(isset($data['GalleryManagement']))?$data['GalleryManagement']['name']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Gallery Title", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Show Heading in Frontend <span class="required"> * </span>
							</label>
							<div class="col-md-4">
								<?php
								echo $this->Form->input('headingfrontend_flag', array(
										'options'=>$headingfrontend_flagArr,
										'value'=>(!empty($data))?$data['GalleryManagement']['headingfrontend_flag']:'',
										'type'=>'radio',
										'before' => '<label class="col-md-3">',
										'after' => '</label>',
										'data-error-container'=>'#customerror_div',
										'separator' => '</label><label class="col-md-3">',
										'legend'=>false,
										'hiddenField'=>false
									)
								);
								?>
								<span id="customerror_div"></span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Image width<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('width',array('value'=>(isset($data['GalleryManagement']))?$data['GalleryManagement']['width']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Image width", 'type'=>"text")); 
								
                                 /*  echo " &nbsp "."<font color='red'>(Recommended Size Must be pixels)</font>";  */?>
							</div>
							<div>px</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Image Height<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('height',array('value'=>(isset($data['GalleryManagement']))?$data['GalleryManagement']['height']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Image Height", 'type'=>"text"));
                                 /*  echo " &nbsp "."<font color='red'>(Recommended Size Must be pixels)</font>"; */ ?>
							</div>
							<div>px</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Style<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
									/* $styles = array(''=>'Please Select','style4'=>'Style 4','style5'=>'Style 5');
									echo $this->Form->input('style',
															array('options'=>$styles, 
																  'default'=>'', 
																  'data-required'=>1, 
																  'class'=>"form-control",
																  'id' =>'styler',
																  'selected'=> (isset($data['GalleryManagement']))?$data['GalleryManagement']['style']:'')
															); */
                                  ?>
								  
								 
								<?php 
								if(empty($id))
								{
								?>
							
								<?php echo $this->Form->input('style',array('value'=>(isset($data['GalleryManagement']))?$data['GalleryManagement']['style']:'',  'data-required'=>1, 'class'=>"form-control",'id'=>"styid" ,'placeholder'=>"Enter Gallery style", 'type'=>"text")); ?> 
								<?php
								}
								else
								{
								?>
                                 <?php echo $this->Form->input('style',array('value'=>(isset($data['GalleryManagement']))?$data['GalleryManagement']['style']:'',  'data-required'=>1, 'class'=>"form-control",'id'=>"styid" , 'type'=>"text",'readonly' => 'readonly')); ?> 								 
								  
								  
							    <?php
							    }
							    ?>
								  <!--<font color="red"><a href="#"  data-toggle="modal" onclick="return preview(this.rel);" id="pre" rel="" style="cursor:pointer">Preview</a></font>-->
							</div>
							
							<div class="col-md-4">
							<?php 
							echo $this->Html->link('<i class="fa fa-edit"></i> Choose your Style', 'javascript:;', array('escape' => false,'full_base'=>true,'title'=>"Choose your Style",'class'=>'btn default green','data-target'=>"#stack1", 'data-toggle'=>"modal",'div'=>false)
							             );	
								
							if(!empty($id)){
								echo $this->Html->image(IMGPATH.'style_img/'.$widgetStyle['Style']['style_img'], array('alt'=>'', 'class'=>'img-responsive'));
							
							}
							?>	
							</div>
							
							
							
							
							
							
							
						</div>
						
						<!--<div class="form-group" id="description">
							<label class="control-label col-md-3">Gallery Description <span class="required">
							* </span>
							</label>
							<div class="col-md-8">
								<?php //echo $this->Form->input('title',array('value'=>(isset($data['GalleryManagement']))?$data['GalleryManagement']['title']:'',  'data-required'=>1, 'class'=>"ckeditor form-control", 'placeholder'=>"Enter Gallery Title", 'type'=>"textarea" )); ?>
								<div id="editor2_error"></div>
							</div>
						</div>-->
						
						
						<div class="form-group other">
							<div>
								<label class="control-label col-md-3">Gallery Image </label>
								<div class="col-md-8">
									<?php echo $this->Form->input('GalleryImage.gallery_image_name', array('type'=>'file', 'id'=>"gallery_image_name", 'multiple'=>true, 'name'=>'data[GalleryImage][gallery_image_name][]'));
									echo " &nbsp "."<font color='red'>(Recommended Size 560 x 480)</font>"; 								?>
									
								</div>
							</div>
							<div align="row">
								<?php  
								if(!empty($data['GalleryImage'])){

								foreach($data['GalleryImage'] as $gallery){
								?>
								<div class="col-md-3" style="margin:5px 0px;">
									<img id="myavtimg" src="<?php echo $this->webroot; ?>img/uploads/gallery_image/thumb/<?php echo $gallery['gallery_image_name']; ?>" alt="image" />
								
								<?php
								echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array('controller'=>'GalleryManagements', 'action'=>'admin_imgdelete', 'img_id'=>$gallery['id'], 'gallery_image_name'=>$gallery['gallery_image_name'], 'id'=>$id
								), array('confirm' => 'Are you Sure?', 'escape'=>false, 'full_base'=>true, 'class'=>'btn default btn-xs red')
								);
								?>
								</div>
								<?php 
									}
								} 
								?>
							</div>
						</div>
						<div class="style6" style="display:none">
							<div class="form-group">
								<label class="control-label col-md-3">&nbsp;
								</label>
								<div class="col-md-4">
									<a class="btn btn-xs green addmore" id="add_1" rel="" href="javascript:void(0);">
										Add More <i class="fa fa-plus"></i>
									</a>
								</div>
							</div>
							
							<div class="category">
								<div class="form-group">
									<label class="control-label col-md-3">Category Name <span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<?php echo $this->Form->input('GalleryImage.cat_id',array('value'=>(isset($data['GalleryManagement']))?$data['GalleryImage']['cat_id']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Category Name", 'type'=>"text", 'name'=>'data[GalleryImage][cat_id][]')); ?>
									</div>
								</div>
								
								
								<div class="form-group">
									<div>
										<label class="control-label col-md-3">Gallery Image </label>
										<div class="col-md-8">
											<?php echo $this->Form->input('GalleryImage.gallery_image_name', array('type'=>'file', 'id'=>"gallery_image_name", 'multiple'=>true, 'name'=>'data[GalleryImage][gallery_cat_image_name][0][]'));
											echo " &nbsp "."<font color='red'>(Recommended Size 560 x 480)</font>"; 								?>
											
										</div>
									</div>
								</div>
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="col-md-3 control-label">Select Status <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('status', array(
																'options' => $statusArr,
																'empty' => 'Select Status',	
																'class' => 'form-control',
																'selected'=> (isset($data['GalleryManagement']))?$data['GalleryManagement']['status']:''
															));
									?>  
								</div>
							</div>
						</div>
						
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
							<?php 
							if(!empty($id)){
								echo $this->Form->input('slug',array('value'=>(isset($data['GalleryManagement']))?$data['GalleryManagement']['slug']:'', 'type'=>"hidden"));
							}
							?>
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

<div id="stack1" class="modal fade" tabindex="-1" data-width="400" >
	<div class="modal-dialog" style="height:5000px; width:1200px; z-index: 1050;">
		<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h2>Select Style</h2>
		</div>
		
		<span for="PageTemplateRowsColumnColumn" class="help-block" style="display:none" id="validatefor1">Please Select any one  Image</span>
		
		<?php echo $this->Form->create('gallerydataform', array('id'=>"gallerydataform", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>	
		<?php 
		if(!empty($Gallery_styledata)){
			echo '<div class="modal-body">';
			echo '<div class="row">';
			foreach($Gallery_styledata as $item){
				echo '<div class="col-md-4">';
					echo $this->Form->input('background_img', array(
							'options'=>array($item['style']['widgetstyle_name']=>$item['style']['name']),
							'type'=>'radio',
							'legend'=>false,
							'label'=>true,
							'hiddenField'=>false,
							'div'=>false
						)
					); 
					echo $this->Html->link($this->Html->image(IMGPATH.'style_img/'.$item['style']['style_img'], array('alt'=>'', 'class'=>'img-responsive')), IMGPATH.'style_img/'.$item['style']['style_img'], array('escape'=>false, 'class'=>'mix-preview fancybox-button') );
					
				
				echo '</div>';
			}
				  
			echo '</div>';
			echo '</div>';
		}
		?>	
		 <div class="modal-footer">
		<?php echo $this->Form->button('Ok', array('type' => 'button', 'class'=>"btn blue",'id'=>"ok")); ?>
		</div>	
		<?php echo $this->Form->end(); ?>
			   
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
			
			'data[GalleryManagement][headingfrontend_flag]': {
				required: true
			},
			'data[GalleryManagement][title]': {
				required: true
			},  
			'data[GalleryManagement][height]': {
				required: true
			},
			
			'data[GalleryManagement][width]': {
				required: true
			},
			'data[GalleryManagement][status]': {
				required: true
			},
			'data[GalleryManagement][style]': {
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
	
	$("#styler").change(function(){
		$("#pre").attr('rel',$(this).val());
		if($(this).val()=='style3')
		{
			$("#description").hide();
			$("#pre").attr('href','#responsive3');
		}
		else
		{
			$("#description").show();
			if($(this).val()=='style1')
			{
				$("#pre").attr('href','#responsive1');
			}
			if($(this).val()=='style2')
			{
				$("#pre").attr('href','#responsive2');
			}
		}
	}).change();
	
	$('#ok').click(function(e){
		if (!$("#gallerydataform input[type='radio']:checked").val() ) 
		{  
			$('#validatefor1').show();
			return false;
		
		}
		e.preventDefault();
		var value1=$("#gallerydataform input[type='radio']:checked").val();	
		//alert(value1);
		$('#stack1').modal("hide");
		$('#styid').val(value1);
		if(value1 == 'style6')
		{
			$(".style6").show();
			$(".other").hide();
		}
		else
		{
			$(".style6").hide();
			$(".other").show();
		}
	});	
	
	$(".addmore").click(function(){
		var x = $(".category").length;
		
		var html = '<div class="category cat_'+x+'"><div class="form-group"><label class="control-label col-md-3">Category Name <span class="required" aria-required="true"> * </span></label><div class="col-md-4"><input type="text" id="GalleryImageCatId" maxlength="11" placeholder="Enter Category Name" class="form-control" data-required="1" value="" name="data[GalleryImage][cat_id][]"></div></div><div class="form-group"><div><label class="control-label col-md-3">Gallery Image </label><div class="col-md-8"><input type="file" multiple="multiple" id="gallery_image_name" name="data[GalleryImage][gallery_cat_image_name]['+x+'][]"> &nbsp; <font color="red">(Recommended Size 560 x 480)</font><a href="javascript:void(0);" rel="" id="add_'+x+'" onclick="remove12('+x+')" class="btn btn-xs red addmore">Remove <i class="fa fa-minus"></i></a></div></div></div></div>';
		
		$(".style6").last().append(html);
		
	})
	
	
});

function remove12(a)
{
	$(".cat_"+a).remove()
}
</script>