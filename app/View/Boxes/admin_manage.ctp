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
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?> Box
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('Box', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
					<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"id"=>"box_id","value"=> $id)); ?>
						
						<div class="form-group">
							<label class="control-label col-md-3">Name <span class="required"> </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('boxname',array('value'=>(isset($data['Box']))?$data['Box']['boxname']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Box Name", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Show Heading in Frontend <span class="required"> * </span>
							</label>
							<div class="col-md-4">
								<?php
								echo $this->Form->input('headingfrontend_flag', array(
										'options'=>$headingfrontend_flagArr,
										'value'=>(!empty($data))?$data['Box']['headingfrontend_flag']:'',
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
							<label class="control-label col-md-3">Style<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
									/* $styles = array(''=>'Select Style','style1'=>'Style 1','style2'=>'Style 2','style3'=>'Style 3','style4'=>'Style 4','style5'=>'Style 5','style6'=>'Style 6','style7'=>'Style 7');
									echo $this->Form->input('boxstyle',
															array('options'=>$stylesArr, 
																  'default'=>'', 
																  'data-required'=>1, 
																  'class'=>"form-control",
																  'id' =>'styler',
																  'disabled'=>(isset($data['Box']))?'true':'false',
																  'selected'=> (isset($data['Box']))?$data['Box']['boxstyle']:'')
															); */
                                ?>
								
								<?php 
									echo $this->Form->input('boxstyle',array('value'=>(isset($data['Box']))?$data['Box']['boxstyle']:'',  'data-required'=>1, 'class'=>"form-control",'id'=>"styid" ,'placeholder'=>"Enter Box style", 'type'=>"text", 'readonly'=>(!empty($id))?true:false)); 
								?> 
							</div>
							<div class="col-md-3">
							<?php
								if(!empty($id)){
									echo $this->Html->image(IMGPATH.'style_img/'.$boxStyle['Style']['style_img'], array('alt'=>'', 'class'=>'img-responsive'));
								} else {
									echo $this->Html->link('<i class="fa fa-edit"></i> Choose your Style', 'javascript:;', 
										array('escape' => false,'full_base'=>true,'title'=>"Choose your Style",'class'=>'btn default green','data-target'=>"#stack1", 'data-toggle'=>"modal",'div'=>false)
									);
								}
							?>	
							</div>
						</div>
						<?php /* if(!empty($id)) {
							echo $this->Form->input('boxstyle',
													array('type'=>'hidden',
													'value'=> (isset($data['Box']))?$data['Box']['boxstyle']:'')
													);
						} */ ?>
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
																'selected'=> (isset($data['Box']))?$data['Box']['status']:''
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
					<i class="fa fa-cogs"></i>List of  Box Contents
					
				</div>
					
				<a data-toggle="modal" href="#responsive" class="btn red add" style="float:right"><i class="fa fa-plus"></i> Add Box Content</a>	
			</div>
		
			<div class="portlet-body flip-scroll">
				
				<table class="table table-bordered table-striped table-condensed flip-content">
					<thead class="flip-content">
						<tr>
							<?php
								if($data['Box']['boxstyle'] == 'style1')
								{
							?>
							<td width="15%" align="center" style="font-weight:bold">
								Box Header Style	
							</td>
							<td width="15%" align="center" style="font-weight:bold">
								Box Header Title	
							</td>
							<?php
								}
								if($data['Box']['boxstyle'] == 'style2' || $data['Box']['boxstyle'] == 'style5' || $data['Box']['boxstyle'] == 'style4')
								{
							?>
							<td width="15%" align="center" style="font-weight:bold">
								Box Side Style	
							</td>
							<?php
								}
								if($data['Box']['boxstyle'] == 'style3')
								{
							?>
							<td width="15%" align="center" style="font-weight:bold">
								Box Header Style	
							</td>
							<td width="15%" align="center" style="font-weight:bold">
								Box Back Ground Style	
							</td>
							<?php
								}
								if($data['Box']['boxstyle'] == 'style7' || $data['Box']['boxstyle'] == 'style6')
								{
							?>
							<td width="15%" align="center" style="font-weight:bold">
								Box Header Style	
							</td>
							<?php
								}
							?>
							<td width="11%" align="center" style="font-weight:bold">
								Box Title
							</td>
							<td width="11%" align="center" style="font-weight:bold">
								Box Content
							</td>
							<td width="11%" align="center" style="font-weight:bold">
								Status
							</td>
							<td  align="center" style="font-weight:bold">
								Action
							</td>
						</tr>
					</thead>
					
					<tbody>
						
						<?php
						if(count($data['BoxContent']) > 0)
						{
							foreach($data['BoxContent'] as $databoxcontent)
							{
						?>
						<tr>
							<?php
								if($data['Box']['boxstyle'] == 'style1')
								{
							?>
							<?php 
							$styles = array('head1'=>'Style 1','head2'=>'Style 2','head3'=>'Style 3'); ?>
							<td width="15%" align="center">
								<?php
									echo (isset($databoxcontent['boxheaderstyle']) && $databoxcontent['boxheaderstyle']!='')?$styles[$databoxcontent['boxheaderstyle']]:'-';
								?>
							</td>
							<td width="15%" align="center">
								<?php
									echo (isset($databoxcontent['boxheadertitle']) && $databoxcontent['boxheadertitle']!='')?$databoxcontent['boxheadertitle']:'-';
								?>
							</td>
							<?php
								}
								if($data['Box']['boxstyle'] == 'style2' || $data['Box']['boxstyle'] == 'style5' || $data['Box']['boxstyle'] == 'style4')
								{
							?>
							<td width="15%" align="center">
								<?php
									echo (isset($databoxcontent['sidestyle']) && $databoxcontent['sidestyle']!='')?$databoxcontent['sidestyle']:'-';
								?>
							</td>
							<?php
								}
								if($data['Box']['boxstyle'] == 'style3')
								{
							?>
							<td width="15%" align="center">
								<?php
									echo (isset($databoxcontent['boxheaderstyle']) && $databoxcontent['boxheaderstyle']!='')?$databoxcontent['boxheaderstyle']:'-';
									
								?>
							</td>
							<td width="15%" align="center">
								<?php
									//echo (isset($databoxcontent['backgroundstyle']) && $databoxcontent['backgroundstyle']!='')?$databoxcontent['backgroundstyle']:'-';
									if(!empty($databoxcontent['backgroundstyle'])){
										echo $this->Html->image(IMGPATH.'backgroundstyle/resize/'.$databoxcontent['backgroundstyle'], array('alt'=>'', 'class'=>'img-responsive'));
										echo $this->Html->link('<i class="fa fa-trash-o"></i>', 
											array('controller'=>'Boxes', 'action'=>'admin_boxbgimgdlt/'.$data['Box']['id'].'/'.$databoxcontent['id']), 
											array('class'=>'btn btn-xs red', 'escape'=>false, 'confirm'=>'Do you want to delete this?')
										);
									}
								?>
							</td>
							<?php
								}
								if($data['Box']['boxstyle'] == 'style7'  || $data['Box']['boxstyle'] == 'style6')
								{
							?>
							<td width="15%" align="center">
								<?php
									echo (isset($databoxcontent['boxheaderstyle']) && $databoxcontent['boxheaderstyle']!='')?$databoxcontent['boxheaderstyle']:'-';
								?>
							</td>
							<?php
								}
							?>
							<td width="11%" align="center">
								<?php
									echo (isset($databoxcontent['boxtitle']) && $databoxcontent['boxtitle']!='')?$databoxcontent['boxtitle']:'-';
								?>
							</td>
							<td width="11%" align="center">
								<?php
									echo (isset($databoxcontent['boxcontent']) && $databoxcontent['boxcontent']!='')?$databoxcontent['boxcontent']:'-';
								?>
							</td>
							<td width="11%" align="center">
								<?php 
									echo ($databoxcontent['status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
									echo isset($databoxcontent['status'])?$statusArr[$databoxcontent['status']]:'';
									echo '</span>';				
								?>
							</td>
							<td  align="center" width="11%" >
								<div class="col-md-6">
								<a data-toggle="modal" href="#responsive" rel="<?php echo $databoxcontent['id']; ?>" class="btn default btn-xs purple add"><i class="fa fa-edit"></i> Edit</a>
								</div>
								<div class="col-md-6">
								<?php
									echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array('controller'=>'Boxes', 'action'=>'admin_boxdelete/'.$databoxcontent['id'].'/1'), array('escape'=>false, 'confirm' => 'Do you really want to delete this Box?', 'full_base'=>true, 'class'=>'btn default btn-xs red'));
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
<div id="responsiveicon" class="modal fade" tabindex="-1" aria-hidden="true"></div>

<div id="stack1" class="modal fade" tabindex="-1" data-width="400" >
	<div class="modal-dialog" style="height:5000px; width:1200px; z-index: 1050;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h2>Select Style</h2>
			</div>
		
			<span for="PageTemplateRowsColumnColumn" class="help-block" style="display:none" id="validatefor1">Please Select any one Box Image</span>
		
			<?php echo $this->Form->create('boxdataform', array('id'=>"boxdataform", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>	
			<?php 
			if(!empty($boxstyledata)){
				echo '<div class="modal-body">';
				echo '<div class="row">';
				foreach($boxstyledata as $item){
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
			url:'<?php echo $this->Html->url(array('controller'=>'Boxes','action'=>'admin_boxmanage','full_base'=>true)); ?>',
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
			
			'data[Box][headingfrontend_flag]': {
				required: true
			},
			'data[Box][boxstyle]': {
				required: true
			},  
			'data[Box][status]': {
				required: true
			}
		},
		errorPlacement: function (error, element) { // render error placement for each input type
			if (element.attr("data-error-container")) { 
				
				error.appendTo(element.attr("data-error-container"));
			} else {
				//alert(element.attr("type"));
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
	
	/* $("#styler").change(function(){
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
	}).change(); */
	
		$('#ok').click(function(e){
		if (!$("#boxdataform input[type='radio']:checked").val() ) 
		{  
			$('#validatefor1').show();
			return false;
		
		}
		e.preventDefault();
		var value1=$("#boxdataform input[type='radio']:checked").val();	
		$('#stack1').modal("hide");
		$('#styid').val(value1);
	});
});
</script>