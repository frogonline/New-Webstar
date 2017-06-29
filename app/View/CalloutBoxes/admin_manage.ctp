<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$currentModelPer=$this->Session->read('currentModelPer');
	//pr($currentModelPer);
?>
<?php
if($currentModelPer['add']=='Y')
{
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?> CalloutBoxes
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('CalloutBox', array('url'=>array('controller'=>'CalloutBoxes','action' => 'admin_manage/'.$id), 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
				<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"id"=>"callout_box_id","value"=> $id)); ?>
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-3">Box Title<span class="required">
							</span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('heading',array('value'=>(isset($data['CalloutBox']))?$data['CalloutBox']['heading']:'', 'id'=>"heading", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Box Title", 'type'=>"text")); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Box Description<span class="required">
							* </span>
							</label>
							<div class="col-md-9">
								<?php echo $this->Form->input('description',array('value'=>(isset($data['CalloutBox']))?$data['CalloutBox']['description']:'', 'id'=>"description", 'data-required'=>1, 'class' => 'ckeditor form-control', 'placeholder'=>"Enter Box Description", 'type'=>"textarea")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Style <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('style',array('value'=>(isset($data['CalloutBox']))?$data['CalloutBox']['style']:'',  'data-required'=>1, 'class'=>"form-control",'id'=>"styid" ,'placeholder'=>"Enter Callout Box style", 'type'=>"text")); ?>							
															
							</div>
							<div class="col-md-4">
							<?php 
							echo $this->Html->link('<i class="fa fa-edit"></i> Choose your Style', 'javascript:;', 
								array('escape' => false,'full_base'=>true,'title'=>"Choose your Style",'class'=>'btn default  green','data-target'=>"#stack1", 'data-toggle'=>"modal",'div'=>false)
							);
								
							if(!empty($id)){
								echo $this->Html->image(IMGPATH.'style_img/'.$widgetStyle['style']['style_img'], array('alt'=>'', 'class'=>'img-responsive'));
							
							}
							?>	
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="control-label col-md-3">Button Text<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('button_text',array('value'=>(isset($data['CalloutBox']))?$data['CalloutBox']['button_text']:'', 'id'=>"button_text", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Button Text", 'type'=>"text")); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Button Link<span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('button_link',array('value'=>(isset($data['CalloutBox']))?$data['CalloutBox']['button_link']:'', 'id'=>"button_link", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Button Link", 'type'=>"text")); ?>
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
<?php
}
?>
<div id="stack1" class="modal fade" tabindex="-1" data-width="400" >
	<div class="modal-dialog" style="height:5000px; width:1200px; z-index: 1050;">
		<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h2>Select Style</h2>
		</div>
		
		<span for="PageTemplateRowsColumnColumn" class="help-block" style="display:none" id="validatefor1">Please Select any one Image</span>
		
		<?php echo $this->Form->create('contactdataform', array('id'=>"contactdataform", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>	
		<?php 
		if(!empty($caloutstyledata)){
			echo '<div class="modal-body">';
			echo '<div class="row">';
			foreach($caloutstyledata as $item){
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
			
			'data[CalloutBox][description]': {
				required: true
			},
			'data[CalloutBox][button_text]': {
				required: true
			},
			'data[CalloutBox][button_link]': {
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
		if (!$("#contactdataform input[type='radio']:checked").val() ) 
		{  
			$('#validatefor1').show();
			return false;
		
		}
		e.preventDefault();
		var value1=$("#contactdataform input[type='radio']:checked").val();	
		$('#stack1').modal("hide");
		$('#styid').val(value1);
	});
	
	
});
</script>