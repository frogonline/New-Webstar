<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$headingfrontend_flagArr = array('Y'=>'Yes','N'=>'No');
	$position = array('1'=>'Classic','2'=>'Fancy');
	$position_img = array('1'=>'Portfolio_Text_bottom.jpg','2'=>'Portfolio_Text_body.jpg');
	//pr($this->request->params);
	//exit;
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?> Portfolio
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('Portfolio', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
				
				<?php
					if(empty($id)){
						echo $this->Form->input('date_created', array('type'=>'hidden','value'=>date('Y-m-d')));
					} else {
						echo $this->Form->input('date_modified', array('type'=>'hidden','value'=>date('Y-m-d')));
					}
				?>
	
					<div class="form-body">
					<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"id"=>"portfolio_id","value"=> $id)); ?>
						
						<div class="form-group">
							<label class="control-label col-md-3">Name <span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('name',array('value'=>(isset($data['Portfolio']))?$data['Portfolio']['name']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Portfolio Name", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Show Heading in Frontend <span class="required"> * </span>
							</label>
							<div class="col-md-4">
								<?php
								echo $this->Form->input('headingfrontend_flag', array(
										'options'=>$headingfrontend_flagArr,
										'value'=>(!empty($data))?$data['Portfolio']['headingfrontend_flag']:'',
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
						
						<?php
							if((!empty($id) && ($data['Portfolio']['style'] != 'style5')) || empty($id))
							{
						?>
						<div class="form-group categoriess">
							<label class="control-label col-md-3">Category <span class="required"> * </span>
							</label>
							<div class="col-md-4">
								<?php
								echo $this->Form->input('category_type', array(
										'options'=>$headingfrontend_flagArr,
										'value'=>(!empty($data))?$data['Portfolio']['category_type']:'',
										'type'=>'radio',
										'before' => '<label class="col-md-3">',
										'after' => '</label>',
										'data-error-container'=>'#customerror_div1',
										'separator' => '</label><label class="col-md-3">',
										'legend'=>false,
										'hiddenField'=>false,
										'class'=>'cat_type',
										'disabled'=>empty($id)?false:true
									)
								);
								?>
								<span id="customerror_div1"></span>
							</div>
						</div>
						<?php
							}
						?>
						
						
						<div class="form-group">
							<label class="control-label col-md-3">Type<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
									<?php 
										/* $styles = array(''=>'Select Style','style1'=>'One Toggle Open','style2'=>'Multiple Toggle Open','style1'=>'Category based Accordions');
										echo $this->Form->input('style',
																array('options'=>$stylesArr, 
																	  'default'=>'', 
																	  'data-required'=>1, 
																	  'class'=>"form-control",
																	  'id' =>'styler',
																	  'disabled'=>(isset($data['Portfolio']))?'true':'false',
																	  'selected'=> (isset($data['Portfolio']))?$data['Portfolio']['style']:'')
																); */
									  ?>
								<?php echo $this->Form->input('style',array('value'=>(isset($data['Portfolio']))?$data['Portfolio']['style']:'',  'data-required'=>1, 'class'=>"form-control",'id'=>"styid" ,'placeholder'=>"Enter Portfolio style", 'type'=>"text", 'readonly'=>(!empty($id))?true:false)); ?>		  
							</div>
							<div class="col-md-4">
							<?php 
							if(!empty($id)){
								echo $this->Html->image(IMGPATH.'style_img/'.$accordionStyle['Style']['style_img'], array('alt'=>'', 'class'=>'img-responsive'));
							} else {
								echo $this->Html->link('<i class="fa fa-edit"></i> Choose your Style', 'javascript:;', 
								array('escape' => false,'full_base'=>true,'title'=>"Choose your Style",'class'=>'btn default green','data-target'=>"#stack1", 'data-toggle'=>"modal",'div'=>false)
							    );
							}
							?>	
							</div>
						</div>
						<?php
							if((!empty($id) && ($data['Portfolio']['style'] != 'style6' && $data['Portfolio']['style'] != 'style5' && $data['Portfolio']['style'] != 'style7')) || empty($id))
							{
						?>
						<div class="form-group styler">
							<label class="control-label col-md-3">Style <span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<?php
								echo $this->Form->input('position', array(
										'options'=>$position,
										'value'=>(!empty($data))?$data['Portfolio']['position']:'',
										'type'=>'radio',
										'before' => '<label class="col-md-4">',
										'after' => '</label>',
										'data-error-container'=>'#customerror_div3',
										'separator' => '</label><label class="col-md-4">',
										'legend'=>false,
										'hiddenField'=>false,
										'class'=>'stylerr'
									)
								);
								?>
								<span id="customerror_div3"></span>
							</div>
						</div>
						
						<?php
							}
							if(!empty($id))
							{
						?>
								<input type="hidden" id="hidpos" value="<?php echo (!empty($data))?$data['Portfolio']['position']:''?>" />
						<?php
							}
						?>
						
						<?php 
						if(!empty($id))
						{
							if($data['Portfolio']['category_type']=='Y')
							{
						?>
						
						<div id="category" >
							<?php
								if(isset($id) && !empty($id))
								{
									$category = explode(",",$data['Portfolio']['category']);
									$maxCat = count($category);
									$i=1;	
									foreach($category as $cat)
									{
							?>
								<div class="form-group">
									<label class="control-label col-md-3" id="<?php echo $i; ?>">Category - <?php echo $i; ?>
									</label>
									<div class="col-md-4">
										<?php echo $this->Form->input('category',array('value'=>(isset($data['Portfolio']))?$cat:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Category Name", 'type'=>"text",'name'=>"data[Portfolio][category][]")); ?>
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
									<?php echo $this->Form->input('category',array('value'=>(isset($data['Portfolio']))?$data['Portfolio']['name']:'',  'data-required'=>1, 'disabled'=>(isset($data['Portfolio']))?'true':'false', 'class'=>"form-control", 'placeholder'=>"Enter Category Name", 'type'=>"text",'name'=>"data[Portfolio][category][]")); ?>
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
						
						<?php
							}
						}
						else
						{
						?>
						
					
						<div id="category" style="display:none">
							<?php
								if(isset($id) && !empty($id))
								{
									$category = explode(",",$data['Portfolio']['category']);
									$maxCat = count($category);
									$i=1;	
									foreach($category as $cat)
									{
							?>
								<div class="form-group">
									<label class="control-label col-md-3" id="<?php echo $i; ?>">Category - <?php echo $i; ?>
									</label>
									<div class="col-md-4">
										<?php echo $this->Form->input('category',array('value'=>(isset($data['Portfolio']))?$cat:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Category Name", 'type'=>"text",'name'=>"data[Portfolio][category][]")); ?>
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
									<?php echo $this->Form->input('category',array('value'=>(isset($data['Portfolio']))?$data['Portfolio']['name']:'',  'data-required'=>1, 'disabled'=>(isset($data['Portfolio']))?'true':'false', 'class'=>"form-control", 'placeholder'=>"Enter Category Name", 'type'=>"text",'name'=>"data[Portfolio][category][]")); ?>
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
						<?php
						}
						?>
						
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
																'selected'=> (isset($data['Portfolio']))?$data['Portfolio']['status']:''
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
					<i class="fa fa-cogs"></i>List of Portfolio Contents
					
				</div>
				
				<a data-toggle="modal" href="#responsive" class="btn red add" style="float:right"><i class="fa fa-plus"></i> Add Portfolio Content</a>	
				
			</div>
		
			<div class="portlet-body flip-scroll">
				
				<table class="table table-bordered table-striped table-condensed flip-content">
					<thead class="flip-content">
						<tr>

							<td width="11%" align="center" style="font-weight:bold">
								Image
							</td>
							<td width="11%" align="center" style="font-weight:bold">
								Category
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
						if(count($data['PortfolioContent']) > 0)
						{
							foreach($data['PortfolioContent'] as $databoxcontent)
							{
						?>
						<tr>
							<?php
								/* if($data['Tabs']['style'] == 'style1')
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
									echo (isset($databoxcontent['image']) && $databoxcontent['image']!='')?$this->Html->image(IMGPATH.'portfolio_image/thumb/'.$databoxcontent['image'], array('alt'=>'Image')):'-';
								?>
							</td>
							<td  align="center">
								<?php
									echo (isset($databoxcontent['category']) && $databoxcontent['category']!='')?$databoxcontent['category']:'-';
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
								<a data-toggle="modal" href="#responsive" rel="<?php echo $databoxcontent['id']; ?>" class="btn default btn-xs purple add"><i class="fa fa-edit"></i> Edit</a>
								</div>
								<div class="col-md-6">
								<?php
									echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array('controller'=>'Portfolios', 'action'=>'admin_boxdelete/'.$databoxcontent['id'].'/1'), array('escape'=>false, 'confirm' => 'Do you really want to delete this Tab?', 'full_base'=>true, 'class'=>'btn default btn-xs red'));
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
									
									<span for="PageTemplateRowsColumnColumn" class="help-block" style="display:none" id="validatefor1">Please Select any one Accordion Image</span>
									
									<?php echo $this->Form->create('accordiondataform', array('id'=>"accordiondatafor", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>	
									<?php 
									if(!empty($accordiondata)){
										echo '<div class="modal-body">';
										echo '<div class="row">';
										foreach($accordiondata as $item){
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
 
	$(document).on('click', "a.addmore",function(){
		var id = $(this).attr('id').split("add_");
		$("#category").append('<div class="form-group"><label class="control-label col-md-3" id="'+(parseInt(id[1])+2)+'"></label><div class="col-md-4"><input type="text" name="data[Portfolio][category][]" placeholder="Enter Category name" class="form-control" data-required="1" /><a class="btn btn-xs purple remove" style="display:none" id="" href="javascript:void(0);"><i class="fa fa-times"></i> Remove </a><a class="btn btn-xs green addmore" id="" href="javascript:void(0);"> Add More <i class="fa fa-plus"></i> </a></div></div>');
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
		var portfolio_id = $("#portfolio_id").val();
		if($(".cat_type:checked").val())
		{
			var style = $(".cat_type:checked").val()
		}
		else
		{
			var style = 'N';
		}
		var hidpos = $("#hidpos").val();
		var styler = $('#styid').val();
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
			url:'<?php echo $this->Html->url(array('controller'=>'Portfolios','action'=>'admin_boxmanage','full_base'=>true)); ?>',
			data:{portfolio_id:portfolio_id,style:style,styler:styler,id:id},
			success:function(result){
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
			/* 'data[Portfolio][headingfrontend_flag]': {
				required: true
			},  */
			 
			'data[Portfolio][headingfrontend_flag]': {
				required: true
			}, 
			'data[Portfolio][position]': {
				required: true
			}, 
			'data[Portfolio][category_type]': {
				required: true
			}, 
			'data[Portfolio][style]': {
				required: true
			}, 
			'data[Portfolio][status]': {
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
	
	$('#ok').click(function(e){
		if (!$("#accordiondatafor input[type='radio']:checked").val() ) 
		{  
			$('#validatefor1').show();
			return false;
		
		}
		e.preventDefault();
		var value1=$("#accordiondatafor input[type='radio']:checked").val();	
		$('#stack1').modal("hide");
		$('#styid').val(value1);
		if(value1=="style6" || value1=="style5" || value1=="style7")
		{
			if(value1=="style5")
			{
				$('.categoriess').hide();
				$(".cat_type").rules("remove", "required");
			}
			else
			{
				$('.categoriess').show();
				$(".cat_type").rules("add", "required");
			}
			$('.styler').hide();
			$(".stylerr").rules("remove", "required");
		}
		else
		{
			$('.categoriess').show();
			$('.styler').show();
			$(".cat_type").rules("add", "required");
			$(".stylerr").rules("add", "required");
		}
	});	
	
	$(".cat_type").click(function(){
		if($(".cat_type:checked").val()=='Y')
		{
			$('#category').show();
		}
		else
		{
			$('#category').hide();
		}
	})
	
	
});
/* function preview(a)
{
	if(a)
	{
		alert(a)
	}
} */
</script>