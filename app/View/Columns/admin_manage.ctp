<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$headingfrontend_flagArr = array('Y'=>'Yes','N'=>'No');
?>
<style>
#cke_1_contents {
  height: 100px !important;
}
#cke_2_contents {
  height: 100px !important;
}
#cke_3_contents {
  height: 100px !important;
}
#cke_4_contents {
  height: 100px !important;
}
</style>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?> Column
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('Column', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
					<?php 
					echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"id"=>"Column_id","value"=> $id)); 
					?>
					<?php
					if(empty($id))
					{
					?>
					<div class="form-group">
						<label class="control-label col-md-3">Column Name <span class="required"> * </span>
						</label>
						<div class="col-md-4">
							<?php echo $this->Form->input('column_name',array('value'=>(isset($data['Column']))?$data['Column']['column_name']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Column Name", 'type'=>"text")); ?>
						</div>
					</div>
						
					<div class="form-group">
						<label class="control-label col-md-3">Show Heading in Frontend <span class="required"> * </span>
						</label>
						<div class="col-md-4">
							<?php
							echo $this->Form->input('headingfrontend_flag', array(
									'options'=>$headingfrontend_flagArr,
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
						<label class="control-label col-md-3">Column Style<span class="required"> * </span></label>
						<div class="col-md-4">
						<?php 
							/* $styles = array(''=>'Select Style','style1'=>'Style 1','style2'=>'Style 2','style3'=>'Style 3','style4'=>'Style 4');
							echo $this->Form->input('column_style',
													array('options'=>$stylesArr, 
														  'default'=>'',
														  'onchange'=>'myFunction(this.value)',
														  'data-required'=>1, 
														  'class'=>"form-control",
														  'id' =>'styler',
														  'selected'=> (isset($data['Column']))?$data['Column']['column_style']:'')
													); */
						?>
							
						<?php 
							echo $this->Form->input('column_style',array('value'=>(isset($data['Column']))?$data['Column']['column_style']:'',  'data-required'=>1, 'class'=>"form-control",'id'=>"styid" ,'placeholder'=>"Enter Column style", 'type'=>"text")); 
						?>  
						</div>
						<div class="col-md-4">
						<?php 
							echo $this->Html->link('<i class="fa fa-edit"></i> Choose your Style', 'javascript:;', array('escape' => false,'full_base'=>true,'title'=>"Choose your Style",'class'=>'btn default green','data-target'=>"#stack1", 'data-toggle'=>"modal",'div'=>false)
							);
						?>
						</div>
					</div>
					<?php
					}
					?>
					
					<?php
					if(!empty($id)){
					?>
					<div class="form-group">
						<label class="control-label col-md-3">Column Name <span class="required"> * </span>
						</label>
						<div class="col-md-4">
							<?php echo $this->Form->input('column_name',array('value'=>(isset($data['Column']))?$data['Column']['column_name']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Column Name", 'type'=>"text")); ?>
						</div>
					</div>
						
					<div class="form-group">
						<label class="control-label col-md-3">Show Heading in Frontend <span class="required"> * </span>
						</label>
						<div class="col-md-4">
							<?php
							echo $this->Form->input('headingfrontend_flag', array(
									'options'=>$headingfrontend_flagArr,
									'value'=>(!empty($data))?$data['Column']['headingfrontend_flag']:'',
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
						<label class="control-label col-md-3">Column Style<span class="required">
						* </span>
						</label>
						<div class="col-md-4">			
						<?php /* echo $this->Form->input('column_style',array('value'=>(isset($data['Column']))?$data['Column']['column_style']:'',  'data-required'=>1, 'class'=>"form-control",  'type'=>"text",'readonly' => 'readonly')); */ ?>	
						
						
						<?php 
							echo $this->Form->input('column_style',array('value'=>(isset($data['Column']))?$data['Column']['column_style']:'',  'data-required'=>1, 'class'=>"form-control",'id'=>"styid" ,'placeholder'=>"Enter Column style", 'type'=>"text", 'readonly'=>true)); 
						?>  											
						</div>
						<div class="col-md-4">
						<?php 
							echo $this->Html->image(IMGPATH.'style_img/'.$widgetStyle['Style']['style_img'], array('alt'=>'', 'class'=>'img-responsive'));
						?>
						</div>
					</div>
					<?php
						/* echo $this->Form->input('column_style',
												array('type'=>'hidden',
												'value'=> (isset($data['Column']))?$data['Column']['column_style']:'')
												); */
					}
					?>
						
					<?php
					if(empty($id))
					{
					?>
					<div style="display:none" class="fulldiv">
						<div class="form-group"  >
							<div class="Column1" style="display:none" id="textarea_column1">
								<label class="control-label col-md-3">Column1 <span class="required"> * </span></label>
								<div class="col-md-8">
									<?php echo $this->Form->input('column1',array('value'=>(isset($data['Column']))?$data['Column']['column1']:'',  'data-required'=>1, 'class'=>"form-control ckeditor",  'type'=>"textarea")); ?>
								</div>
							</div>
						</div>
						
						<div class="form-group" >
							<div style="display:none" class="Column2" id="textarea_column2">
								<label class="control-label col-md-3">Column2 <span class="required"> * </span>
								</label>
								<div class="col-md-8">
									<?php echo $this->Form->input('column2',array('value'=>(isset($data['Column']))?$data['Column']['column2']:'',  'data-required'=>1, 'class'=>"form-control ckeditor",  'type'=>"textarea")); ?>
								</div>
							</div>
						</div>
						
						<div class="form-group" >
							<div style="display:none" class="Column3" id="textarea_column3">
								<label class="control-label col-md-3">Column3<span class="required"> * </span>
								</label>
								<div class="col-md-8">
									<?php echo $this->Form->input('column3',array('value'=>(isset($data['Column']))?$data['Column']['column3']:'',  'data-required'=>1, 'class'=>"form-control ckeditor", 'type'=>"textarea")); ?>
								</div>
							</div>	
						</div>
						
						<div class="form-group" >
							<div style="display:none" class="Column4" id="textarea_column">
								<label class="control-label col-md-3">Column4 <span class="required"> * </span>
								</label>
								<div class="col-md-8">
									<?php echo $this->Form->input('column4',array('value'=>(isset($data['Column']))?$data['Column']['column4']:'',  'data-required'=>1, 'class'=>"form-control ckeditor",'type'=>"textarea")); ?>
								</div>
							</div>
						</div>
					</div>
					<?php
					}
					?>
						
					<?php 
					if(!empty($id))
					{
					?>
					<?php 
					if($data['Column']['column_style']=='style1' || $data['Column']['column_style']=='style2' || $data['Column']['column_style']=='style3' || $data['Column']['column_style']=='style4'){ ?>
					<div class="form-group" >
						<div class="Column1" id="textarea_column1">
							<label class="control-label col-md-3">Column1 <span class="required"> * </span></label>
							<div class="col-md-8">
								<?php echo $this->Form->input('column1',array('value'=>(isset($data['Column']))?$data['Column']['column1']:'',  'data-required'=>1, 'class'=>"form-control ckeditor",  'type'=>"textarea")); ?>
							</div>
						</div>
					</div>
						
					<div class="form-group" id="textarea_column2">
						<div  class="Column2">
							<label class="control-label col-md-3">Column2 <span class="required"> * </span>
							</label>
							<div class="col-md-8">
								<?php echo $this->Form->input('column2',array('value'=>(isset($data['Column']))?$data['Column']['column2']:'',  'data-required'=>1, 'class'=>"form-control ckeditor",  'type'=>"textarea")); ?>
							</div>
						</div>
					</div>
						
					<?php
					}
					?>
					<?php 
					if($data['Column']['column_style']=='style2' || $data['Column']['column_style']=='style3' )
					{
					?>
						
					<div class="form-group" id="textarea_column3">
						<div  class="Column3">
							<label class="control-label col-md-3">Column3<span class="required"> * </span>
							</label>
							<div class="col-md-8">
								<?php echo $this->Form->input('column3',array('value'=>(isset($data['Column']))?$data['Column']['column3']:'',  'data-required'=>1, 'class'=>"form-control ckeditor", 'type'=>"textarea")); ?>
							</div>
						</div>
					</div>
						
					<?php 
					}
					?>
						
					<?php 
					if($data['Column']['column_style']=='style3' )
					{
					?>
					<div class="form-group" >
						<div  class="Column4" id="textarea_column4">
							<label class="control-label col-md-3">Column4 <span class="required"> * </span>
							</label>
							<div class="col-md-8">
								<?php echo $this->Form->input('column4',array('value'=>(isset($data['Column']))?$data['Column']['column4']:'',  'data-required'=>1, 'class'=>"form-control ckeditor",'type'=>"textarea")); ?>
							</div>
						</div>
					</div>
					<?php 
					}
					?>
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
															'selected'=> (isset($data['Column']))?$data['Column']['status']:''
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

<div id="stack1" class="modal fade" tabindex="-1" data-width="400" >
	<div class="modal-dialog" style="height:5000px; width:1200px; z-index: 1050;">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h2>Select Style</h2>
			</div>
			
			<span for="PageTemplateRowsColumnColumn" class="help-block" style="display:none" id="validatefor1">Please Select any one column Image</span>
			
			<?php echo $this->Form->create('columndataform', array('id'=>"columndataform", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>	
			<?php 
			if(!empty($column_styledata)){
				echo '<div class="modal-body">';
				echo '<div class="row">';
				foreach($column_styledata as $item){
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
			
			'data[Column][headingfrontend_flag]': {
				required: true
			},
			'data[Column][column_style]': {
				required: true
			},  
			'data[Column][status]': {
				required: true
			},
			'data[Column][column1]': {
				required: true
			},
			'data[Column][column2]': {
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
		if (!$("#columndataform input[type='radio']:checked").val() ) 
		{  
			$('#validatefor1').show();
			return false;
		
		}
		e.preventDefault();
		var value1=$("#columndataform input[type='radio']:checked").val();	
		//alert(value1);
		$('#stack1').modal("hide");
		$('#styid').val(value1);
		
		if(value1=='style1')
		{
		
		document.getElementsByClassName("fulldiv")[0].style.display = 'block';
		document.getElementsByClassName("Column1")[0].style.display = 'block';
		document.getElementsByClassName("Column2")[0].style.display = 'block';
		document.getElementsByClassName("Column3")[0].style.display = 'none';
		document.getElementsByClassName("Column4")[0].style.display = 'none';
		}
		
		if(value1=="style2")
		{
		
			document.getElementsByClassName("fulldiv")[0].style.display = 'block';
			document.getElementsByClassName("Column1")[0].style.display = 'block';
			document.getElementsByClassName("Column2")[0].style.display = 'block';
			document.getElementsByClassName("Column3")[0].style.display = 'block';
			document.getElementsByClassName("Column4")[0].style.display = 'none';
		}
		if(value1=="style3")
		{
			
			document.getElementsByClassName("fulldiv")[0].style.display = 'block';
			document.getElementsByClassName("Column1")[0].style.display = 'block';
			document.getElementsByClassName("Column2")[0].style.display = 'block';
			document.getElementsByClassName("Column3")[0].style.display = 'block';
			document.getElementsByClassName("Column4")[0].style.display = 'block';
		}
		if(value1=="style4")
		{
			document.getElementsByClassName("fulldiv")[0].style.display = 'block';
			document.getElementsByClassName("Column1")[0].style.display = 'block';
			document.getElementsByClassName("Column2")[0].style.display = 'block';
			document.getElementsByClassName("Column3")[0].style.display = 'none';
			document.getElementsByClassName("Column4")[0].style.display = 'none';
		}
		
	});	
	
});

</script>
<script>
function myFunction(val) {
var val=val;
	if(val=='style1')
	{
	
	document.getElementsByClassName("fulldiv")[0].style.display = 'block';
    document.getElementsByClassName("Column1")[0].style.display = 'block';
    document.getElementsByClassName("Column2")[0].style.display = 'block';
    document.getElementsByClassName("Column3")[0].style.display = 'none';
	document.getElementsByClassName("Column4")[0].style.display = 'none';
	}
	
	if(val=='style2')
	{
	document.getElementsByClassName("fulldiv")[0].style.display = 'block';
	document.getElementsByClassName("Column1")[0].style.display = 'block';
	document.getElementsByClassName("Column2")[0].style.display = 'block';
	document.getElementsByClassName("Column3")[0].style.display = 'block';
	document.getElementsByClassName("Column4")[0].style.display = 'none';
	}
	
	if(val=='style3')
	{
	document.getElementsByClassName("fulldiv")[0].style.display = 'block';
	document.getElementsByClassName("Column1")[0].style.display = 'block';
	document.getElementsByClassName("Column2")[0].style.display = 'block';
	document.getElementsByClassName("Column3")[0].style.display = 'block';
	document.getElementsByClassName("Column4")[0].style.display = 'block';
	}
	
	if(val=='style4')
	{
	document.getElementsByClassName("fulldiv")[0].style.display = 'block';
	document.getElementsByClassName("Column1")[0].style.display = 'block';
	document.getElementsByClassName("Column2")[0].style.display = 'block';
	document.getElementsByClassName("Column3")[0].style.display = 'none';
	document.getElementsByClassName("Column4")[0].style.display = 'none';
	}
	if(val=='')
	{
	document.getElementsByClassName("fulldiv")[0].style.display = 'none';
	document.getElementsByClassName("Column1")[0].style.display = 'none';
	document.getElementsByClassName("Column2")[0].style.display = 'none';
	document.getElementsByClassName("Column3")[0].style.display = 'none';
	document.getElementsByClassName("Column4")[0].style.display = 'none';
	}
	
	

}
</script>

