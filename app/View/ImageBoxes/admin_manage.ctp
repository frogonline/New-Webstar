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
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?> Image Box
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('ImageBox', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
				
				<?php
					if(empty($id)){
						echo $this->Form->input('date_created', array('type'=>'hidden','value'=>date('Y-m-d')));
					} else {
						echo $this->Form->input('date_modified', array('type'=>'hidden','value'=>date('Y-m-d')));
					}
				?>
	
					<div class="form-body">
					<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"id"=>"image_box_id","value"=> $id)); ?>
						
						<div class="form-group">
							<label class="control-label col-md-3">Name <span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('name',array('value'=>(isset($data['ImageBox']))?$data['ImageBox']['name']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Image Box Name", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Show Heading in Frontend <span class="required"> * </span>
							</label>
							<div class="col-md-4">
								<?php
								echo $this->Form->input('headingfrontend_flag', array(
										'options'=>$headingfrontend_flagArr,
										'value'=>(!empty($data))?$data['ImageBox']['headingfrontend_flag']:'',
										'type'=>'radio',
										'before' => '<label class="col-md-3">',
										'after' => '</label>',
										'separator' => '</label><label class="col-md-3">',
										'legend'=>false
									)
								);
								?>
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
																'selected'=> (isset($data['ImageBox']))?$data['ImageBox']['status']:''
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
					<i class="fa fa-cogs"></i>List of Image Box Contents
					
				</div>
				<?php
					if(count($data['ImageBoxContent']) == 0)
					{	
				?>
				<a data-toggle="modal" href="#responsive" class="btn red add" style="float:right"><i class="fa fa-plus"></i> Add Image Box Content</a>	
				<?php
					}
				?>
			</div>
		
			<div class="portlet-body flip-scroll">
				
				<table class="table table-bordered table-striped table-condensed flip-content">
					<thead class="flip-content">
						<tr>

							<td width="11%" align="center" style="font-weight:bold">
								Image
							</td>
							<td width="11%" align="center" style="font-weight:bold">
								Title
							</td>
							<td width="11%" align="center" style="font-weight:bold">
								Content
							</td>
							<td width="11%" align="center" style="font-weight:bold">
								Status
							</td>
							<td width="13%" align="center" style="font-weight:bold">
								Action
							</td>
						</tr>
					</thead>
					
					<tbody>
						
						<?php
						if(count($data['ImageBoxContent']) > 0)
						{
							foreach($data['ImageBoxContent'] as $databoxcontent)
							{
						?>
						<tr>
							<?php
								/* if($data['Tabs']['style'] == 'style3')
								{
							?>
							<td width="15%" align="center">
								<?php
									echo (isset($databoxcontent['category']) && $databoxcontent['category']!='')?$databoxcontent['category']:'-';
								?>
							</td>
							<?php
								} */
							?>
							<td  align="center">
								<?php
									echo (isset($databoxcontent['image']) && $databoxcontent['image']!='')?$this->Html->image(IMGPATH.'box_image/thumb/'.$databoxcontent['image'], array('alt'=>'Image')):'-';
								?>
							</td>
							<td  align="center">
								<?php
									echo (isset($databoxcontent['title']) && $databoxcontent['title']!='')?$databoxcontent['title']:'-';
								?>
							</td>
							<td  align="center">
								<?php
									echo (isset($databoxcontent['content']) && $databoxcontent['content']!='')?$databoxcontent['content']:'-';
								?>
							</td>
							<td  align="center">
								<?php 
									echo ($databoxcontent['status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
									echo isset($databoxcontent['status'])?$statusArr[$databoxcontent['status']]:'';
									echo '</span>';				
								?>
							</td>
							<td width="13%" align="center">
							<div class="col-md-6">
								<a data-toggle="modal" href="#responsive" id="auto_<?php echo $databoxcontent['id']; ?>" rel="<?php echo $databoxcontent['id']; ?>" class="btn default btn-xs purple add"><i class="fa fa-edit"></i> Edit</a>
								</div>
								<div class="col-md-6">
								<?php
									echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array('controller'=>'ImageBoxes', 'action'=>'admin_boxdelete/'.$databoxcontent['id'].'/1'), array('escape'=>false, 'confirm' => 'Do you really want to delete this Tab?', 'full_base'=>true, 'class'=>'btn default btn-xs red'));
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
			/* 'data[ImageBox][headingfrontend_flag]': {
				required: true
			},  */
			
			'data[ImageBox][status]': {
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