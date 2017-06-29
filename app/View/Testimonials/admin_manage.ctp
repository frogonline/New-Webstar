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
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?> Tab
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('Testimonials', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
				
				<?php
					if(empty($id)){
						echo $this->Form->input('date_created', array('type'=>'hidden','value'=>date('Y-m-d')));
					} else {
						echo $this->Form->input('date_modified', array('type'=>'hidden','value'=>date('Y-m-d')));
					}
				?>
	
					<div class="form-body">
					<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"id"=>"tab_id","value"=> $id)); ?>
						
						<div class="form-group">
							<label class="control-label col-md-3">Name <span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('name',array('value'=>(isset($data['Testimonials']))?$data['Testimonials']['name']:'',  'data-required'=>1,'class'=>"form-control", 'placeholder'=>"Enter Testimonial Name", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Show Heading in Frontend <span class="required"> * </span>
							</label>
							<div class="col-md-4">
								<?php
								echo $this->Form->input('headingfrontend_flag', array(
										'options'=>$headingfrontend_flagArr,
										'value'=>(!empty($data))?$data['Testimonials']['headingfrontend_flag']:'',
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
								<span id="customerror_div"></span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Style<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
									/* $styles = array('style1'=>'Style 1','style2'=>'Style 2','style3'=>'Style 3');
									echo $this->Form->input('style',
															array('options'=>$stylesArr, 
																  'default'=>'',
																  'empty'=>'Select Style',
																  'data-required'=>1, 
																  'class'=>"form-control",
																  'id' =>'styler',
																  'disabled'=>(isset($data['Testimonials']))?'true':'false',
																  'selected'=> (isset($data['Testimonials']))?$data['Testimonials']['style']:'')
															); */
                                  ?>
								
							
							
								<?php
								if(empty($id))
								{
								echo $this->Form->input('style',array('value'=>(isset($data['Testimonials']))?$data['Testimonials']['style']:'',  'data-required'=>1, 'class'=>"form-control",'id'=>"styid" ,'placeholder'=>"Enter Testimonial style", 'type'=>"text"));
                                }
								else
								{
								echo $this->Form->input('style',array('value'=>(isset($data['Testimonials']))?$data['Testimonials']['style']:'',  'data-required'=>1, 'class'=>"form-control",'id'=>"styid" ,'readonly' => 'readonly', 'type'=>"text"));
								}
								?>  
								  
							</div>
							<div class="col-md-4">
								
								<?php 
								if(empty($id))
								{
								echo $this->Html->link('<i class="fa fa-edit"></i> Choose your Style', 'javascript:;', array('escape' => false,'full_base'=>true,'title'=>"Choose your Style",'class'=>'btn default green','data-target'=>"#stack1", 'data-toggle'=>"modal",'div'=>false)
							             );	
								}
								?>	
							  <?php
							   if(!empty($id)){
									echo $this->Html->image(IMGPATH.'style_img/'.$widgetStyle['Style']['style_img'], array('alt'=>'', 'class'=>'img-responsive'));
								}
								?>
							 
								  
							</div>
						</div>
						<?php /* if(!empty($id)) {
							echo $this->Form->input('style',
													array('type'=>'hidden',
													'value'=> (isset($data['Testimonials']))?$data['Testimonials']['style']:'')
													);
						} */ ?>
						
						
						<?php
						if(!empty($id)){
                        if($data['Testimonials']['style']=='style1'){	
						?>
						<div class="form-group style1" id="testimonial_text_box_style1">
							<label class="control-label col-md-3">Text <span class="required"> * </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('text',array('value'=>(isset($data['Testimonials']))?$data['Testimonials']['text']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Testimonial Text", 'type'=>"textarea")); ?>
							</div>
						</div>
							<?php 
							}
						}
						?>
						
						<?php
						if(!empty($id)){
                        if($data['Testimonials']['style']=='style3'){	
						?>
						<div class="form-group style1" id="testimonial_text_box_style1">
							<label class="control-label col-md-3">Text <span class="required"> * </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('text',array('value'=>(isset($data['Testimonials']))?$data['Testimonials']['text']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Testimonial Text", 'type'=>"textarea")); ?>
							</div>
						</div>
						<?php 
						} } ?>
						<?php 
						if(empty($id)){
						?>
						<div class="form-group style1" style="display:none" id="testimonial_text_box_style1">
							<label class="control-label col-md-3">Text <span class="required"> * </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('text',array('value'=>(isset($data['Testimonials']))?$data['Testimonials']['text']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Testimonial Text", 'type'=>"textarea")); ?>
							</div>
						</div>
						
						<?php } ?>
					<!--	<div id="category">
							<?php
								/* if(isset($id) && !empty($id))
								{
									$category = explode(",",$data['Tabs']['category']);
									$maxCat = count($category);
									$i=1;	
									foreach($category as $cat)
									{ */
							?>
								<div class="form-group">
									<label class="control-label col-md-3" id="<?php /* echo $i; ?>">Category - <?php echo $i;  */?>
									</label>
									<div class="col-md-4">
										<?php /* echo $this->Form->input('category',array('value'=>(isset($data['Tabs']))?$cat:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Category Name", 'type'=>"text",'name'=>"data[Tabs][category][]")); ?>
										<a class="btn btn-xs purple remove" <?php echo $i==$maxCat?'style="display:none"':''?> id="remove_<?php echo ($i-1);  */?>"  href="javascript:void(0);">
											<i class="fa fa-times"></i> Remove 
										</a>
										<a class="btn btn-xs green addmore" <?php /* echo $i==$maxCat?'':'style="display:none"'?> id="add_<?php echo ($i-1); */ ?>" rel="" href="javascript:void(0);">
											Add More <i class="fa fa-plus"></i>
										</a>
									</div>
								</div>	

							<?php	/* 
										$i++;
									}
								}
								else
								{ */
							?>
							<div class="form-group">
								<label class="control-label col-md-3" id="1">Category - 1
								</label>
								<div class="col-md-4">
									<?php /* echo $this->Form->input('category',array('value'=>(isset($data['Tabs']))?$data['Tabs']['name']:'',  'data-required'=>1, 'disabled'=>(isset($data['Tabs']))?'true':'false', 'class'=>"form-control", 'placeholder'=>"Enter Category Name", 'type'=>"text",'name'=>"data[Tabs][category][]")); */ ?>
									<a class="btn btn-xs purple remove" id="remove_0" style="display:none" href="javascript:void(0);">
										<i class="fa fa-times"></i> Remove 
									</a>
									<a class="btn btn-xs green addmore" id="add_0" rel="" href="javascript:void(0);">
										Add More <i class="fa fa-plus"></i>
									</a>
								</div>
							</div>
							<?php
								//}
							?>
							
						</div>-->
						
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
																'selected'=> (isset($data['Testimonials']))?$data['Testimonials']['status']:''
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
							<?php echo $this->Form->button('Cancel', array('type' => 'reset','onclick'=>'window.history.back()', 'class'=>"btn default",'div'=>false));?>
						</div>
					</div>
				<?php echo $this->Form->end(); ?>
				<!-- END FORM-->
			</div>
			<!-- END VALIDATION STATES-->
		</div>
		
		
		
		<?php
			if(isset($id))
			{
		?>
		
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-cogs"></i>List of Tab Contents
					
				</div>
					
				<a data-toggle="modal" href="#responsive" class="btn red add" style="float:right"><i class="fa fa-plus"></i> Add Tab Content</a>	
			</div>
		
			<div class="portlet-body flip-scroll">
				
				<table class="table table-bordered table-striped table-condensed flip-content">
					<thead class="flip-content">
						<tr>
							<td  align="center" style="font-weight:bold">
								Name
							</td>
							<?php
								if($data['Testimonials']['style']!='style3')
								{
							?>
							<td  align="center" style="font-weight:bold">
								Designation
							</td>
							<?php
								}
							?>
							<td  align="center" style="font-weight:bold">
								Testimonial
							</td>
							<?php
								if($data['Testimonials']['style']!='style3')
								{
							?>
							<td align="center" style="font-weight:bold">
								Image
							</td>
							<?php
								}
							?>
							<td align="center" style="font-weight:bold">
								Status
							</td>
							<td  align="center" style="font-weight:bold">
								Action
							</td>
						</tr>
					</thead>
					
					<tbody>
						
						<?php
						if(count($data['TestimonialContent']) > 0)
						{
							foreach($data['TestimonialContent'] as $datatestimonialcontent)
							{
						?>
						<tr>
							<td width="11%" align="center">
								<?php
									echo (isset($datatestimonialcontent['title']) && $datatestimonialcontent['title']!='')?$datatestimonialcontent['title']:'-';
								?>
							</td>
							<?php
								if($data['Testimonials']['style']!='style3')
								{
							?>
							<td width="11%" align="center">
								<?php
									echo (isset($datatestimonialcontent['heading']) && $datatestimonialcontent['heading']!='')?$datatestimonialcontent['heading']:'-';
								?>
							</td>
							<?php
								}
							?>
							<td width="35%" align="center">
								<?php
									echo (isset($datatestimonialcontent['testimonial']) && $datatestimonialcontent['testimonial']!='')?$datatestimonialcontent['testimonial']:'-';
								?>
							</td>
							<?php
								if($data['Testimonials']['style']!='style3')
								{
							?>
							<td align="center">
								<?php
									echo (isset($datatestimonialcontent['testimonial_image']) && $datatestimonialcontent['testimonial_image']!='')?$this->Html->image(IMGPATH.'testimonial_image/thumb/'.$datatestimonialcontent['testimonial_image'], array('alt'=>'Image')):'-';
								?>
							</td>
							<?php
								}
							?>
							<td  align="center">
								<?php 
									echo ($datatestimonialcontent['status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
									echo isset($datatestimonialcontent['status'])?$statusArr[$datatestimonialcontent['status']]:'';
									echo '</span>';				
								?>
							</td>
							<td width="20%" align="center">
							<div class="col-md-6">
								<a data-toggle="modal" href="#responsive" id="auto_<?php echo $datatestimonialcontent['id']; ?>" rel="<?php echo $datatestimonialcontent['id']; ?>" class="btn default btn-xs purple add"><i class="fa fa-edit"></i> Edit</a>
								</div>
								<div class="col-md-6">
								<?php
									echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array('controller'=>'Testimonials', 'action'=>'admin_boxdelete/'.$datatestimonialcontent['id'].'/1'), array('escape'=>false, 'confirm' => 'Do you really want to delete this Testimonial?', 'full_base'=>true, 'class'=>'btn default btn-xs red'));
								?>
								</div>
							</td>
						</tr>
						<?php
							}
						}
						else
						{
						?>
						<tr>
							<td colspan="7" align="center">
								No Results Found
							</td>
						</tr>
						<?php
						}
						?>
					</tbody>
					
				</table>
			
			</div>
		</div>
		
		<?php
			}
		?>
		
	</div>

</div>

<div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true">
	
</div>


<div id="stack1" class="modal fade" tabindex="-1" data-width="400" >
								<div class="modal-dialog" style="height:5000px; width:1200px; z-index: 1050;">
									<div class="modal-content">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								    <h2>Select Style</h2>
									</div>
									
									<span for="PageTemplateRowsColumnColumn" class="help-block" style="display:none" id="validatefor1">Please Select any one  Image</span>
									
									<?php echo $this->Form->create('testimonialdataform', array('id'=>"testimonialdataform", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>	
									<?php 
									if(!empty($testimonial_styledata)){
										echo '<div class="modal-body">';
										echo '<div class="row">';
										foreach($testimonial_styledata as $item){
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
 
	/* $(document).on('click', "a.addmore",function(){
		var id = $(this).attr('id').split("add_");
		$("#category").append('<div class="form-group"><label class="control-label col-md-3" id="'+(parseInt(id[1])+2)+'"></label><div class="col-md-4"><input type="text" name="data[Accordion][category][]" placeholder="Enter Category name" class="form-control" data-required="1" /><a class="btn btn-xs purple remove" style="display:none" id="" href="javascript:void(0);"><i class="fa fa-times"></i> Remove </a><a class="btn btn-xs green addmore" id="" href="javascript:void(0);"> Add More <i class="fa fa-plus"></i> </a></div></div>');
		var maxlength = $(".addmore").length;
		//alert(maxlength);
		
		var i=0
		$(".addmore").each(function(){
			$(this).attr('id','add_'+i);
			if(i!=(parseInt(maxlength-1)))
			{
				$("#add_"+i).hide();
			}
			i++;
			$("#"+i).text('Category - '+i);
		})
		var j=0
		$(".remove").each(function(){
			$(this).attr('id','remove_'+j);
			if(j!=(parseInt(maxlength-1)))
			{
				$("#remove_"+j).show();
			}
			j++;
		})
	})
	
	
	$(document).on('click', "a.remove",function(){
		$(this).parent().parent().remove();
		
		var i=0
		$(".addmore").each(function(){
			$(this).attr('id','add_'+i);
			i++;
			$("#"+i).text('Category - '+i);
		})
		var j=0
		$(".remove").each(function(){
			$(this).attr('id','remove_'+j);
			j++;
		})
		
	})
	 */

	$('.add').click(function(e){
		e.preventDefault();
		var tab_id = $("#tab_id").val();
		var style = $("#styid").val();
		if($(this).attr('rel'))
		{
			var id = $(this).attr('rel');
		}
		else
		{
			var id = '';
		}
		$.ajax({
			type:'POST',
			url:'<?php echo $this->Html->url(array('controller'=>'Testimonials','action'=>'admin_boxmanage','full_base'=>true)); ?>',
			data:{tab_id:tab_id,style:style,id:id,},
			success:function(result){
				//alert()
				$('#responsive').html(result);
			}
		});
	});
	
	<?php
		if(isset($this->request->params['pass'][1]))
		{
	?>
		$("#auto_<?php echo $this->request->params['pass'][1]; ?>").trigger('click');
	<?php
		}
	?>


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
			
			'data[Testimonials][headingfrontend_flag]': {
				required: true
			},
			'data[Testimonials][style]': {
				required: true
			},  
			'data[Testimonials][status]': {
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
		if($(this).val()=='style1' || $(this).val()=='style3')
		{
			$(".style1").show();
		}
		else
		{
			$(".style1").hide();
		}
	}).change();
	
	$('#ok').click(function(e){
		if (!$("#testimonialdataform input[type='radio']:checked").val() ) 
		{  
			$('#validatefor1').show();
			return false;
		
		}
		e.preventDefault();
		var value1=$("#testimonialdataform input[type='radio']:checked").val();	
		//alert(value1);
		$('#stack1').modal("hide");
		$('#styid').val(value1);
		if(value1=="style1")
		{
			$('#testimonial_text_box_style1').show();
		}
		else if(value1=="style2")
		{
			
			$('#testimonial_text_box_style1').hide();
		}
		else if(value1=="style3")
		{
			$('#testimonial_text_box_style1').show();
		}
		else
		{
			$('#testimonial_text_box_style1').hide();
		}
		
		/* if(value1=="style3")
		{
			$('#testimonial_text_box_style2').show();
		}
		else
		{
			$('#testimonial_text_box_style2').hide();
		} */
	});	
});

</script>