<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i>Update Details  
				</div>
			</div>
			<?php $this->Html->script('members/check_email',array('inline'=>false)); ?>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('GoogleAnalytic', array('action' => 'admin_manage/', 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"post", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
						<?php 
							echo $this->Form->input('id',array('required' => true, "type"=>"hidden","label"=>false,"value"=> $data['GoogleAnalytic']['id'])); 
							echo $this->Form->input('phase',array('required' => true, "type"=>"hidden","label"=>false,"value"=> $isKeySet==true?'S':'N')); 
						?>

						
							<div class="form-group">
								<label class="control-label col-md-3">YT API KEY <span class="required">
								* </span>
								</label>
								
								<div class="col-md-6">
									<?php echo $this->Form->input('yt_api_key',array('required' => true,'value'=>(isset($data['GoogleAnalytic']))?$data['GoogleAnalytic']['yt_api_key']:'', 'id'=>"yt_api_key", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter YT API KEY", 'type'=>"text")); ?>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3">YT CLIENT KEY <span class="required">
								* </span>
								</label>
								
								<div class="col-md-6">
									<?php echo $this->Form->input('yt_client_key',array('required' => true,'value'=>(isset($data['GoogleAnalytic']))?$data['GoogleAnalytic']['yt_client_key']:'', 'id'=>"yt_client_key", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter YT CLIENT KEY", 'type'=>"text")); ?>
								</div>
							</div>


							<div class="form-group">
								<label class="control-label col-md-3">YT CLIENT SECRET <span class="required">
								* </span>
								</label>
								
								<div class="col-md-6">
									<?php echo $this->Form->input('yt_client_secret',array('required' => true,'value'=>(isset($data['GoogleAnalytic']))?$data['GoogleAnalytic']['yt_client_secret']:'', 'id'=>"name", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter YT CLIENT SECRET", 'type'=>"text")); ?>
								</div>
							</div>

						<?php

							if($isKeySet){

								$btnname = 'Save';
						?>

							<div class="form-group">
								<label class="control-label col-md-3">Profile ID <span class="required">
								* </span>
								</label>
								
								<div class="col-md-6">
									<?php echo $this->Form->input('code',array('required' => true,'value'=>(isset($data['GoogleAnalytic']))?$data['GoogleAnalytic']['code']:'', 'id'=>"code", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Profile ID", 'type'=>"text")); ?>
								</div>
							</div>


							<div class="form-group">
			                    <label class="control-label col-md-3">Access Code</label>

			                    <div class="col-md-6">
				                    <?php
				                    	$access_code_txt = !empty($data['GoogleAnalytic']['token'])?"Do not fill in this file unless you want to renew the access token":"Ex: 4/OCi4kMA5DpQ7Q-wMVl2WJSthTSM-HsWcYub2kdzdI6A";
				                    	$required = !empty($data['GoogleAnalytic']['token'])? "false":"true";
				                    ?>
			                    	<?php echo $this->Form->input('access_code',array('required' => $required, 'value'=>'', 'id'=>"access_code", 'data-required'=>0, 'class'=>"form-control", 'placeholder'=>$access_code_txt, 'type'=>"text")); ?>

			                        <span class="input-group-btn">
			                            <a href="<?php echo $getAccessCodeUrl?>" target="_blank" class="btn btn-info btn-flat" type="button">Get Access Code</a>
			                        </span>
			                    </div>
			                </div>

							<div class="form-group">
			                	<label class="control-label col-md-3"></label>
			                    <label  for="category">
			                    <strong><span class="text-warning">Note</span>: Access Code & Profile ID must be controlled by one user</strong>
			                    </label>
			                </div>

						<?php

							}else{
								$btnname = 'Next';
							}

						?>
		                
						
						
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
							<?php echo $this->Form->button($btnname, array('type' => 'submit', 'name'=>'continue', 'value'=>'s', 'class'=>"btn blue"));?>
							
							<?php echo $this->Form->button('Cancel', array('type' => 'reset', 'class'=>"btn default",'div'=>false, 'onclick'=>'window.history.back()'));?>
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
	
	
	
	/**** Change Password ****/
	$("#editChngPwdFld").val('');
	$("#chngPwdlink").click(function(e){
		e.preventDefault();
		$("#editChngPwdLnk").hide();
		$("#editChngPwdFld").show();
		$("#editChngPwdFld").val('');
		$("#cnclEditLnk").show();
		$("#cnclEditLnk").attr('data-status', 'on');
	});
	
	$("#cnclEditLnk").click(function(e){
		e.preventDefault();
		$("#editChngPwdLnk").show();
		$("#editChngPwdFld").hide();
		$("#cnclEditLnk").hide();
		$("#cnclEditLnk").attr('data-status', 'off');
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
		ignore: ".ignore", // validate all fields including form hidden input
		rules: {
			'data[Member][firstname]': {
				required: true
			},
			'data[Member][lastname]': {
				required: true
			},  
			'data[Member][username]': {
				required: true
			},
			'data[Member][email_id]': {
				required: true
			},
			'data[New][password]': {
				required: function(element){
					var status = $('#cnclEditLnk').attr('data-status');
					
					if(status.trim() == 'off'){
						return false;
					} else {
						return true;
					}
				}
			},
			'data[Member][type]': {
				required: true
			},
			'data[Member][status]': {
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