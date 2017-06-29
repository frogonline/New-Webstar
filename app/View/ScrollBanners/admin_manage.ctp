<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$headingfrontend_flagArr = array('Y'=>'Yes','N'=>'No');
	//pr($this->request->params);
	//exit;
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add'?> Scroll Banner
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('ScrollBanner', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
				
					<div class="form-body">
					<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
					
						<div class="form-group">
							<label class="control-label col-md-3">Name <span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('name',array('value'=>(isset($data['ScrollBanner']))?$data['ScrollBanner']['name']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Scroll Banner Name", 'type'=>"text")); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Button one text<span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('button_one_text',array('value'=>(isset($data['ScrollBanner']))?$data['ScrollBanner']['button_one_text']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Button one text", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Button two text <span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('button_two_text',array('value'=>(isset($data['ScrollBanner']))?$data['ScrollBanner']['button_two_text']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Button two text", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Button one link <span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('button_one_link',array('value'=>(isset($data['ScrollBanner']))?$data['ScrollBanner']['button_one_link']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Button one link", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Button two link <span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('button_two_link',array('value'=>(isset($data['ScrollBanner']))?$data['ScrollBanner']['button_two_link']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Button two link", 'type'=>"text")); ?>
							</div>
						</div>
						
						
						
						<div class="form-group">
							<label class="control-label col-md-3">Show Heading in Frontend <span class="required"> * </span>
							</label>
							<div class="col-md-4">
								<?php
								echo $this->Form->input('headingfrontend_flag', array(
										'options'=>$headingfrontend_flagArr,
										'value'=>(!empty($data))?$data['ScrollBanner']['headingfrontend_flag']:'',
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
							<label class="control-label col-md-3">Title <span class="required">  </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('title',array('value'=>(isset($data['ScrollBanner']))?$data['ScrollBanner']['title']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Scroll Banner Title", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Content <span class="required"> * </span>
							</label>
								<div class="col-md-9">
									<?php echo $this->Form->input('content',array('value'=>(isset($data['ScrollBanner']))?$data['ScrollBanner']['content']:'',  'data-required'=>1, 'class'=>"ckeditor form-control", 'placeholder'=>"Enter Content", 'type'=>"textarea")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Image <span class="required"> * </span>
							</label>
							<div class="col-md-4">
								<?php
									if(!empty($data['ScrollBanner']['scroll_image'])){
										echo $this->Html->image(IMGPATH.'scroll_image/thumb/'.$data['ScrollBanner']['scroll_image'], array('alt'=>'Image'));
										echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array(
											'controller'=>'ScrollBanners',
											'action'=>'admin_imgdelete',
											'image_name'=>$data['ScrollBanner']['scroll_image'],
											'id'=>$id,
											//'mid'=>$image_box_id
										), 
										array('confirm' => 'Are you Sure?', 'escape'=>false, 'full_base'=>true, 'class'=>'btn default btn-xs red')
										);
										echo $this->Form->input('set_image', array('type'=>'hidden','value'=>$data['ScrollBanner']['scroll_image']));
									} else {
										echo $this->Form->input('scroll_image', array(
															'type' => "file"
														));  
										echo " &nbsp "."<font color='red'>(Recommended Size 1920 x 1280)</font>"; 
										echo $this->Form->input('set_image', array('type'=>'hidden','value'=>''));
									}
								?>
								<?php /*  echo $this->Form->input('image',array('value'=>(isset($data1['ImageBoxContent']))?$data1['ImageBoxContent']['image']:'',  'data-required'=>1, 'class'=>"form-control", 'enctype'=>"multipart/form-data"));  */ ?>
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
																'selected'=> (isset($data['ScrollBanner']))?$data['ScrollBanner']['status']:''
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
		var image_box_id = $("#image_box_id").val();
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
			url:'<?php echo $this->Html->url(array('controller'=>'ImageBoxes','action'=>'admin_boxmanage','full_base'=>true)); ?>',
			data:{image_box_id:image_box_id,id:id,},
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
						
			'data[ScrollBanner][headingfrontend_flag]': {
				required: true
			},
			 
			'data[ScrollBanner][content]': {
				required: true
			},
			'data[ScrollBanner][scroll_image]': {
				required: true
			},
			'data[ScrollBanner][status]': {
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
/* function preview(a)
{
	if(a)
	{
		alert(a)
	}
} */
</script>