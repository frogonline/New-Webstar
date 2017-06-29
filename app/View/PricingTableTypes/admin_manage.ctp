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
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?> Pricing Table
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('PricePlanType', array('url'=>array('controller'=>'PricingTableTypes','action' => 'admin_manage/'.$id), 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
					<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"id"=>"box_id","value"=> $id)); ?>
						
						<div class="form-group">
							<label class="control-label col-md-3">Name <span class="required"></span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('name',array('value'=>(isset($data['PricePlanType']))?$data['PricePlanType']['name']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Price Plan Name", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Show Heading in Frontend <span class="required"> * </span>
							</label>
							<div class="col-md-4">
								<?php
								echo $this->Form->input('headingfrontend_flag', array(
										'options'=>$headingfrontend_flagArr,
										'value'=>(!empty($data))?$data['PricePlanType']['headingfrontend_flag']:'',
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
								<?php echo $this->Form->input('style',array('value'=>(isset($data['PricePlanType']))?$data['PricePlanType']['style']:'',  'data-required'=>1, 'class'=>"form-control",'id'=>"styid" ,'placeholder'=>"Enter style", 'type'=>"text", 'readonly'=>(!empty($id))?true:false)); ?>		  
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
						if(!empty($id))
						{
						if($data['PricePlanType']['style']=='style2')
						{
						?>
						
						<div id="category" >
							<?php
								if(isset($id) && !empty($id))
								{
									$category = explode(",",$data['PricePlanType']['category']);
									$maxCat = count($category);
									$i=1;	
									foreach($category as $cat)
									{
							?>
								<div class="form-group">
									<label class="control-label col-md-3" id="<?php echo $i; ?>">Category - <?php echo $i; ?>
									</label>
									<div class="col-md-4">
										<?php echo $this->Form->input('category',array('value'=>(isset($data['PricePlanType']))?$cat:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Category Name", 'type'=>"text",'name'=>"data[PricePlanType][category][]")); ?>
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
									<?php echo $this->Form->input('category',array('value'=>(isset($data['PricePlanType']))?$data['PricePlanType']['name']:'',  'data-required'=>1, 'disabled'=>(isset($data['PricePlanType']))?'true':'false', 'class'=>"form-control", 'placeholder'=>"Enter Category Name", 'type'=>"text",'name'=>"data[PricePlanType][category][]")); ?>
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
						?>
						
					
						<div id="category" style="display:none">
							<?php	
									
								if(empty($id))
								{
							?>
							<div class="form-group">
								<label class="control-label col-md-3" id="1">Category - 1
								</label>
								<div class="col-md-4">
									<?php echo $this->Form->input('category',array('value'=>(isset($data['PricePlanType']))?$data['PricePlanType']['name']:'',  'data-required'=>1, 'disabled'=>(isset($data['PricePlanType']))?'true':'false','id'=>'category1', 'class'=>"form-control", 'placeholder'=>"Enter Category Name", 'type'=>"text",'name'=>"data[PricePlanType][category][]")); ?>
									<span for="PricePlanTypeName" class="help-block" id="errstyle" style="display:none">This field is required.</span>
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
																'selected'=> (isset($data['PricePlanType']))?$data['PricePlanType']['status']:''
															));
									?>  
								</div>
							</div>
						</div>
						
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
							<?php echo $this->Form->button('Save', array('type' => 'submit', 'name'=>'continue', 'value'=>'s', 'class'=>"btn blue validatefor"));?>
							<?php echo $this->Form->button('Save & Close', array('type' => 'submit', 'class'=>"btn blue validatefor"));?>
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
					<i class="fa fa-cogs"></i>List of  Pricing Table Contents
					
				</div>
				<?php if($data['PricePlanType']['style']=='style1'){
						if($totalcou<4){
				?>
				<a data-toggle="modal" href="#responsive" class="btn red add" style="float:right"><i class="fa fa-plus"></i> Add Pricing Table Content</a>	
				<?php } } ?>
				
				<?php if($data['PricePlanType']['style']=='style2'){
						if($totalcou<3){
				?>
				<a data-toggle="modal" href="#responsive" class="btn red add" style="float:right"><i class="fa fa-plus"></i> Add Pricing Table Content</a>	
				<?php } } ?>
			</div>
		
			<div class="portlet-body flip-scroll">
				
				<table class="table table-bordered table-striped table-condensed flip-content">
					<thead class="flip-content">
						<tr>
							
							<td width="7%" align="center" style="font-weight:bold">
								Plan Name
							</td>
							<td width="7%" align="center" style="font-weight:bold">
								Price
							</td>
							<td width="11%" align="center" style="font-weight:bold">
								Description
							</td>
							<td width="11%" align="center" style="font-weight:bold">
								Link
							</td>
							<td class="numeric" align="center" style="font-weight:bold">
								Status
							</td>
							<td class="numeric" align="center" style="font-weight:bold">
								Action
							</td>
						</tr>
					</thead>
					
					<tbody>
						
						<?php
						if(count($data['PricePlan']) > 0)
						{
							foreach($data['PricePlan'] as $databoxcontent)
							{
						?>
						<tr>
						
							<td width="7%" align="center">
								<?php
									echo (isset($databoxcontent['plan_name']) && $databoxcontent['plan_name']!='')?$databoxcontent['plan_name']:'-';
								?>
							</td>
							<td width="7%" align="center">
								<?php
									echo (isset($databoxcontent['plan_price']) && $databoxcontent['plan_price']!='')?$databoxcontent['plan_price']:'-';
								?>
							</td>
							<td width="6%" align="center">
								<?php
									echo (isset($databoxcontent['plan_description']) && $databoxcontent['plan_description']!='')?$databoxcontent['plan_description']:'-';
								?>
							</td>
							<td width="6%" align="center">
								<?php
									echo (isset($databoxcontent['buy_link']) && $databoxcontent['buy_link']!='')?$databoxcontent['buy_link']:'-';
								?>
							</td>
							<td width="6%" align="center">
								<?php 
									echo ($databoxcontent['status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
									echo isset($databoxcontent['status'])?$statusArr[$databoxcontent['status']]:'';
									echo '</span>';				
								?>
							</td>
							<td  align="center" width="27%" >
							<div class="col-md-1"></div>
								<div class="col-md-3">
								<a data-toggle="modal" href="#responsive" rel="<?php echo $databoxcontent['id']; ?>" class="btn default btn-xs purple add"><i class="fa fa-edit"></i> Edit</a>
								</div>
								
								<div class="col-md-4">
								<a data-toggle="modal" href="#responsive1" rel="<?php echo $databoxcontent['id']; ?>" class="btn default btn-xs purple add1"><i class="fa fa-edit"></i> Feature</a>
								</div>
								
								<div class="col-md-4">
								<?php
									echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array('controller'=>'PricingTableTypes', 'action'=>'admin_boxcontentdelete/'.$databoxcontent['id'].'/'.$id), array('escape'=>false, 'confirm' => 'Do you really want to delete this Pricing Table Contents?', 'full_base'=>true, 'class'=>'btn default btn-xs red'));
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


<div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true"></div>
<div id="responsive1" class="modal fade" tabindex="-2" aria-hidden="true"></div>



<div id="stack1" class="modal fade" tabindex="-1" data-width="400" >
								<div class="modal-dialog" style="height:5000px; width:1200px; z-index: 1050;">
									<div class="modal-content">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								    <h2>Select Style</h2>
									</div>
									
									<span for="PageTemplateRowsColumnColumn" class="help-block" style="display:none" id="validatefor1">Please Select any one pricing Table Image</span>
									
									<?php echo $this->Form->create('accordiondataform', array('id'=>"pricingdatafor", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>	
									<?php 
									if(!empty($pricingdata)){
										echo '<div class="modal-body">';
										echo '<div class="row">';
										foreach($pricingdata as $item){
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
		$("#category").append('<div class="form-group"><label class="control-label col-md-3" id="'+(parseInt(id[1])+2)+'"></label><div class="col-md-4"><input type="text" name="data[PricePlanType][category][]" placeholder="Enter Category name" class="form-control" data-required="1" /><a class="btn btn-xs purple remove" style="display:none" id="" href="javascript:void(0);"><i class="fa fa-times"></i> Remove </a><a class="btn btn-xs green addmore" id="" href="javascript:void(0);"> Add More <i class="fa fa-plus"></i> </a></div></div>');
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
			url:'<?php echo $this->Html->url(array('controller'=>'PricingTableTypes','action'=>'admin_boxmanage','full_base'=>true)); ?>',
			data:{box_id:box_id,style:style,id:id,},
			success:function(result){
				//alert()
				$('#responsive').html(result);
			}
		});
	});
	
	$('.add1').click(function(e){
		e.preventDefault();
		var box_id = $("#box_id").val();
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
			url:'<?php echo $this->Html->url(array('controller'=>'PricingTableTypes','action'=>'admin_feature','full_base'=>true)); ?>',
			data:{box_id:box_id,style:style,id:id,},
			success:function(result){
				//alert()
				$('#responsive1').html(result);
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
			
			'data[PricePlanType][headingfrontend_flag]': {
				required: true
			},
			'data[PricePlanType][style]': {
				required: true
			},  
			'data[PricePlanType][status]': {
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
		if (!$("#pricingdatafor input[type='radio']:checked").val() ) 
		{  
			$('#validatefor1').show();
			return false;
		
		}
		e.preventDefault();
		var value1=$("#pricingdatafor input[type='radio']:checked").val();	
		$('#stack1').modal("hide");
		$('#styid').val(value1);
		if(value1=="style2")
		{
		$('#category').show();
		}
		else
		{
		$('#category').hide();
		}
	});	
	
	
	$('.validatefor').click(function(e){
	var styval=$('#styid').val();
	var catval=$('#category1').val();
	
	if(styval=='style2')
	{
		if(catval=='')
		{
		('#errstyle').show();
		return false;
		}
	}
	});	
	
});

</script>
