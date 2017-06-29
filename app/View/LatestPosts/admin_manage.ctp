<?php
$option = array('style1'=>'Style 1','style2'=>'Style 2','style3'=>'Style 3','style4'=>'Style 4','style5'=>'Style 5', 'style6'=>'Style 6');
$statusArr = array('0'=>'Active','1'=>'Inactive');
$headingfrontend_flagArr = array('Y'=>'Yes','N'=>'No');

?>

<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i> Edit Latest Post Management
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('LatestPost', array('action' => 'admin_manage/', 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
					  <?php echo $this->Form->input('id',array('value'=>(isset($data['LatestPost']))?$data['LatestPost']['id']:'', 'type' => 'hidden'));?>
						<div class="form-group">
							<label class="control-label col-md-3">Name <span class="required">
							</span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('name', array(
																'type' => 'text',
																'placeholder' => 'Latest Post Name',
																'class' => 'form-control',
																'value'=> (isset($data['LatestPost']))?$data['LatestPost']['name']:''
															)); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Show Heading in Frontend <span class="required"> * </span>
							</label>
							<div class="col-md-4">
								<?php
								echo $this->Form->input('headingfrontend_flag', array(
										'options'=>$headingfrontend_flagArr,
										'value'=>(!empty($data))?$data['LatestPost']['headingfrontend_flag']:'',
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
							<label class="control-label col-md-3">Style <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php /* echo $this->Form->input('style', array(
																'options' => $stylesArr,
																'empty' => 'Select Style',	
																'class' => 'form-control',
																'selected'=> (isset($data['LatestPost']))?$data['LatestPost']['style']:''
															)); */ ?>
								
								<?php echo $this->Form->input('style',array('value'=>(isset($data['LatestPost']))?$data['LatestPost']['style']:'',  'data-required'=>1, 'class'=>"form-control",'id'=>"styid" ,'placeholder'=>"Enter LatestPost style", 'type'=>"text")); ?>							
															
							</div>
							<div class="col-md-4">
							<?php 
								echo $this->Html->link('<i class="fa fa-edit"></i> Choose your Style', 'javascript:;', array('escape' => false,'full_base'=>true,'title'=>"Choose your Style",'class'=>'btn default green','data-target'=>"#stack1", 'data-toggle'=>"modal",'div'=>false)
								);	
								
								if(!empty($id)){
									echo $this->Html->image(IMGPATH.'style_img/'.$widgetStyle['Style']['style_img'], array('alt'=>'', 'class'=>'img-responsive'));
								}
							?>	
							</div>
						</div>
						
						
						<!--<div class="form-group">
							<label class="control-label col-md-3">Short Code 
							</label>
							<div class="col-md-4">
								<label class="control-label">[latestpost] </label>
							</div>
						</div>-->
						
						<div class="form-group">
							<label class="col-md-3 control-label">Select Status <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('is_active', array(
																'options' => $statusArr,
																'empty' => 'Select Status',	
																'class' => 'form-control',
																'selected'=> (isset($data['LatestPost']))?$data['LatestPost']['is_active']:''
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
									
									<span for="PageTemplateRowsColumnColumn" class="help-block" style="display:none" id="validatefor1">Please Select any one Image</span>
									
									<?php echo $this->Form->create('lattestpostdataform', array('id'=>"lattestpostdataform", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>	
									<?php 
									if(!empty($lattestpost_styledata)){
										echo '<div class="modal-body">';
										echo '<div class="row">';
										foreach($lattestpost_styledata as $item){
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
			
			'data[LatestPost][headingfrontend_flag]': {
				required: true
			},
			'data[LatestPost][style]': {
				required: true
			},
			/* 'data[LatestPost][shortcode]': {
				required: true
			}, */
			'data[LatestPost][is_active]': {
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
		if (!$("#lattestpostdataform input[type='radio']:checked").val() ) 
		{  
			$('#validatefor1').show();
			return false;
		
		}
		e.preventDefault();
		var value1=$("#lattestpostdataform input[type='radio']:checked").val();	
		$('#stack1').modal("hide");
		$('#styid').val(value1);
	});
});
</script>