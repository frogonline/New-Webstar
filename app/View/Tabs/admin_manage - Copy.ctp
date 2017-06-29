<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
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
				<?php echo $this->Form->create('Tab', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
					<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"id"=>"Column_id","value"=> $id)); ?>
						
						<div class="form-group">
							<label class="control-label col-md-3">Tab Name <span class="required"> * </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('column_name',array('value'=>(isset($data['Tab']))?$data['Tab']['name']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Tab Name", 'type'=>"text",'disabled'=>(isset($data['Tab']))?'true':'false')); ?>
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="control-label col-md-3">Tab Style<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
									$styles = array(''=>'Select Style','style1'=>'Style 1','style2'=>'Style 2','style3'=>'Style 3','style4'=>'Style 4');
									echo $this->Form->input('column_style',
															array('options'=>$styles, 
																  'default'=>'',
																  'onchange'=>'myFunction(this.value)',
																  'data-required'=>1, 
																  'class'=>"form-control",
																  'id' =>'styler',
																  'selected'=> (isset($data['Tab']))?$data['Tab']['style']:'',
																  'disabled'=>(isset($data['Tab']))?'true':'false',
															));
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
																'selected'=> (isset($data['Tab']))?$data['Tab']['status']:''
															));
									?>  
								</div>
							</div>
						</div>
						
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
							<?php echo $this->Form->button('Submit', array('type' => 'submit', 'class'=>"btn blue"));?>
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
			'data[Column][column_name]': {
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