<?php
$isrequiredArr = array('Y'=>'Yes', 'N'=>'No');
$ismultipleArr = array('Y'=>'Yes', 'N'=>'No');
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h2><?php echo (!empty($id))?'Edit':'Add'; ?> Radio Button Tool</h2>
		</div>
		<!-- BEGIN FORM-->
		<?php echo $this->Form->create('FormTool', array('url'=>array('controller'=>'FormTables', 'action'=>"admin_addtool/".$formid.'/'.$id), 'id'=>'formtoolOpt', 'class'=>"horizontal-form", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<div class="modal-body">
			<div class="scroller" data-always-visible="1" data-rail-visible1="1">
				<?php 
					echo $this->Form->input('form_id',array("type"=>"hidden", 'id'=>'tmplt_id', "value"=>$formid));
				?>
				<div class="row">		
					<div class="col-md-6">
						<h4>Label <span class="required"> * </span> </h4>
						<?php 
							echo $this->Form->input('label', array(
								'type'=>'text',
								'class'=>"form-control",
								'value'=>(!empty($data))?$data['FormTool']['label']:'',
								'data-required'=>1
							)
						);
						?>
					</div>
					
					<div class="col-md-6">
						<h4>Is Required ? <span class="required"> * </span></h4>
						<?php 
							echo $this->Form->input('is_required',
													array('options'=>$isrequiredArr, 
														  'default'=>'',	
														  'data-required'=>1, 
														  'class'=>"form-control",
														  'selected'=>(!empty($data))?$data['FormTool']['is_required']:''
													));
						?>
					</div>
						
				</div>
				
				<div class="row">
				
					<div class="col-md-6">
						<h4>Tool Tip Text <span class="required"> * </span> </h4>
						<?php 
						echo $this->Form->input('tooltip', array(
								'type'=>'text',
								'class'=>"form-control",
								'value'=>(!empty($data))?$data['FormTool']['tooltip']:'',
								'data-required'=>1
							)
						);
						?>
					</div>
				</div>
				
				<div class="row" style="padding:15px 0 0 0;">
					<div class="col-md-6">
					<?php 
					if(!empty($data)){
						echo $this->Form->button('Add Option', array('type' => 'button', 'id'=>'addrowBtn', 'data-id'=>count($data['FormToolOption']), 'class'=>"btn green")); 
					} else {
						echo $this->Form->button('Add Option', array('type' => 'button', 'id'=>'addrowBtn', 'data-id'=>'0', 'class'=>"btn green")); 
					}
					?>
					</div>
				</div>
				
				<div class="optionsDiv" style="padding:15px 0 0 0;">
				<?php
				if(!empty($data)){
					if(!empty($data['FormToolOption'])){
						foreach($data['FormToolOption'] as $toolOption){
							?>
							<div class="row" id="optDiv<?php echo $toolOption['id']; ?>" style="padding:15px 0 0 0;">
								<div class="col-md-6">
								<?php 
								echo $this->Form->input('option', array(
										'type'=>'text',
										'value'=>$toolOption['option_value'],
										'class'=>"form-control opt",
										'name'=>'data[FormToolOption][option_value]['.$toolOption['id'].']',
										'label'=>false
									)
								);
								echo $this->Form->input('optId', array(
										'type'=>'hidden',
										'value'=>$toolOption['id'],
										'name'=>'data[FormToolOption][id]['.$toolOption['id'].']'
									)
								);
								?>
								</div>
								
								<div class="col-md-6">
								<?php echo $this->Html->link('<i class="fa fa-trash"></i>', 'javascript:void(0);', array('escape' => false, 'data-divid'=>'#optDiv'.$toolOption['id'], 'class'=>"btn red ajaxoptDlt", 'data-dlturl'=>$this->Html->url(array('controller'=>'FormTables', 'action'=>'admin_tooloptdlt', 'full_base'=>true)), 'data-optid'=>$toolOption['id'])); ?>
								</div>

							</div>
							<?php
						}
					}
				}
				?>
				</div>
			</div>
		</div>	
		<div class="modal-footer">
			<?php 
				echo $this->Form->input('tool_type', array('type' => 'hidden', 'value'=>"RB"));
				echo $this->Form->button('Submit', array('type' => 'submit', 'class'=>"btn blue"));
			?>
		</div>
		<?php echo $this->Form->end(); ?>
		<!-- END FORM-->
	</div>
	<!-- END VALIDATION STATES-->
</div>
<script type="text/javascript">
$(document).ready(function() {
	var form3 = $('#formtoolOpt');
	var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
		
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "", // validate all fields including form hidden input
		rules: {
			'data[FormTool][label]': {
				required: true
			},
			'data[FormTool][is_required]': {
				required: true
			},  
			'data[FormTool][tooltip]': {
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
	
	$('#addrowBtn').click(function(e){
		e.preventDefault();
		
		var optid = $(this).attr('data-id');
		optid = parseInt(optid);
		optid = optid + 1;
		$.ajax({
			type:'POST',
			url:'<?php echo $this->Html->url(array('controller'=>'FormTables', 'action'=>'admin_ajaxaddrow', 'full_base'=>true)); ?>',
			data:{optid:optid},
			success:function(result){
				$('.optionsDiv').prepend(result);
				$('#addrowBtn').attr('data-id', optid);
			}
		});
	});
	
	$('.ajaxoptDlt').click(function(e){
		e.preventDefault();
		if(confirm("Do you want to delete?")){
			var divId = $(this).attr('data-divid');
			var optId = $(this).attr('data-optid');
			var dlturl = $(this).attr('data-dlturl');
			$.ajax({
				type:'post',
				url:dlturl,
				data:{optId:optId},
				success:function(result){
					if(result.trim()==1){
						$(divId).remove();		
					}
				}
			});
		}
		
	});
});
</script>