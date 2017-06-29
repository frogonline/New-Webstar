<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?> Counter
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('Counter', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
					<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"id"=>"box_id","value"=> $id)); ?>
						
						<div class="form-group">
							<label class="control-label col-md-3">Name <span class="required"> * </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('name',array('value'=>(isset($data['Counter']))?$data['Counter']['name']:'',  'data-required'=>1, 'disabled'=>(isset($data['Counter']))?'true':'false', 'class'=>"form-control", 'placeholder'=>"Enter Counter Name", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Style<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
									$styles = array(''=>'Select Style','style1'=>'One Toggle Open','style2'=>'Multiple Toggle Open');
									echo $this->Form->input('style',
															array('options'=>$styles, 
																  'default'=>'', 
																  'data-required'=>1, 
																  'class'=>"form-control",
																  'id' =>'styler',
																  'disabled'=>(isset($data['Counter']))?'true':'false',
																  'selected'=> (isset($data['Counter']))?$data['Counter']['style']:'')
															);
                                  ?>
							</div>
						</div>
						
						<div id="category">
							<?php
								if(isset($id) && !empty($id))
								{
									$category = explode(",",$data['Counter']['category']);
									$maxCat = count($category);
									$i=1;	
									foreach($category as $cat)
									{
							?>
								<div class="form-group">
									<label class="control-label col-md-3" id="<?php echo $i; ?>">Category - <?php echo $i; ?>
									</label>
									<div class="col-md-4">
										<?php echo $this->Form->input('category',array('value'=>(isset($data['Counter']))?$cat:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Category Name", 'type'=>"text",'name'=>"data[Counter][category][]")); ?>
										<a class="btn btn-xs purple remove" <?php echo $i==$maxCat?'style="display:none"':''?> id="remove_<?php echo ($i-1); ?>"  href="javascript:void(0);">
											<i class="fa fa-times"></i> Remove 
										</a>
										<a class="btn btn-xs green addmore" <?php echo $i==$maxCat?'':'style="display:none"'?> id="add_<?php echo ($i-1); ?>" rel="" href="javascript:void(0);">
											Add More <i class="fa fa-plus"></i>
										</a>
									</div>
								</div>	

							<?php	
										$i++;
									}
								}
								else
								{
							?>
							<div class="form-group">
								<label class="control-label col-md-3" id="1">Category - 1
								</label>
								<div class="col-md-4">
									<?php echo $this->Form->input('category',array('value'=>(isset($data['Counter']))?$data['Counter']['name']:'',  'data-required'=>1, 'disabled'=>(isset($data['Counter']))?'true':'false', 'class'=>"form-control", 'placeholder'=>"Enter Category Name", 'type'=>"text",'name'=>"data[Counter][category][]")); ?>
									<a class="btn btn-xs purple remove" id="remove_0" style="display:none" href="javascript:void(0);">
										<i class="fa fa-times"></i> Remove 
									</a>
									<a class="btn btn-xs green addmore" id="add_0" rel="" href="javascript:void(0);">
										Add More <i class="fa fa-plus"></i>
									</a>
								</div>
							</div>
							<?php
								}
							?>
							
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
																'selected'=> (isset($data['Counter']))?$data['Counter']['status']:''
															));
									?>  
								</div>
							</div>
						</div>
						
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
							<?php echo $this->Form->button('Save', array('type' => 'submit', 'class'=>"btn blue"));?>
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
					<i class="fa fa-cogs"></i>List of  Accordion Contents
					
				</div>
					
				<a data-toggle="modal" href="#responsive" class="btn red add" style="float:right"><span class="fa fa-caret-left"></span>&nbsp; &nbsp; Add Accordion Content</a>	
			</div>
		
			<div class="portlet-body flip-scroll">
				
				<table class="table table-bordered table-striped table-condensed flip-content">
					<thead class="flip-content">
						<tr>
							<?php
							/* 	if($data['Accordion']['style'] == 'style3')
								{ */
							?>
							<td width="15%" align="center" style="font-weight:bold">
								Accordion Category	
							</td>
							<?php
								/* } */
							?>
							<td width="11%" align="center" style="font-weight:bold">
								Accordion Title
							</td>
							<td width="11%" align="center" style="font-weight:bold">
								Accordion Content
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
						if(count($data['AccordionContent']) > 0)
						{
							foreach($data['AccordionContent'] as $databoxcontent)
							{
						?>
						<tr>
							<?php
								/* if($data['Accordion']['style'] == 'style3')
								{ */
							?>
							<td width="15%" align="center">
								<?php
									echo (isset($databoxcontent['category']) && $databoxcontent['category']!='')?$databoxcontent['category']:'-';
								?>
							</td>
							<?php
								/* } */
							?>
							<td width="11%" align="center">
								<?php
									echo (isset($databoxcontent['title']) && $databoxcontent['title']!='')?$databoxcontent['title']:'-';
								?>
							</td>
							<td width="11%" align="center">
								<?php
									echo (isset($databoxcontent['content']) && $databoxcontent['content']!='')?$databoxcontent['content']:'-';
								?>
							</td>
							<td width="11%" align="center">
								<?php 
									echo ($databoxcontent['status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
									echo isset($databoxcontent['status'])?$statusArr[$databoxcontent['status']]:'';
									echo '</span>';				
								?>
							</td>
							<td width="13%" align="center">
								<a data-toggle="modal" href="#responsive" rel="<?php echo $databoxcontent['id']; ?>" class="btn default btn-xs purple add"><i class="fa fa-edit"></i> Edit</a>
								<?php
									echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array('controller'=>'Boxes', 'action'=>'admin_boxdelete/'.$databoxcontent['id'].'/1'), array('escape'=>false, 'confirm' => 'Do you really want to delete this Accordion?', 'full_base'=>true, 'class'=>'btn default btn-xs red'));
								?>
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
 
	$(document).on('click', "a.addmore",function(){
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
	

	$('.add').click(function(e){
		e.preventDefault();
		var box_id = $("#box_id").val();
		var style = $("#styler").val();
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
			url:'<?php echo $this->Html->url(array('controller'=>'Accordions','action'=>'admin_boxmanage','full_base'=>true)); ?>',
			data:{box_id:box_id,style:style,id:id,},
			success:function(result){
				//alert()
				$('#responsive').html(result);
			}
		});
	});


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
			'data[Counter][name]': {
				required: true
			},
			'data[Counter][style]': {
				required: true
			},  
			'data[Counter][status]': {
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
			$("#category").show();
		}
		else
		{
			$("#category").hide();
		}
	}).change();
	
	
});
/* function preview(a)
{
	if(a)
	{
		alert(a)
	}
} */
</script>