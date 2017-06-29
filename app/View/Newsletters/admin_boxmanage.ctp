<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	if(isset($subs) && !empty($subs))
	{
		foreach($subs as $subs)
		{
			$sublists[$subs['NewsletterGroups']['id']]=$subs['NewsletterGroups']['name'];
		}
	}
	else
	{
		$sublists = array();
	}
?>
<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h2 class="modal-title">Send Newsletter</h2>
			</div>
			<?php echo $this->Form->create('Newsletter', array('action' => 'admin_newslettermail/'.$id, 'id'=>'', 'div' => false)); ?>
			<div class="modal-body">
				<div class="row">
					<div class="scroller" data-always-visible="1" data-rail-visible1="1">
					<div class="col-md-12">
							<div class="form-body">
							<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false, "value"=>$id)); ?>

							<?php 
								$options = array('1'=>'Send to All &nbsp');
								$attributes = array('legend' => false, 'label' => true, 'class'=>'','checked'=>false, 'value'=>'all', 'onclick'=>array('return hide_show1(this.value)'), 'class'=>'form-control', 'hidden'=>false,'div'=>false); 
								echo $this->Form->radio('select', $options, $attributes);?>
						   
							<?php 
								$option = array('0'=>'Select from List &nbsp');
								$attribute = array('legend' => false, 'label' => true, 'class'=>'', 'value'=>'select', 'onclick'=>array('return hide_show(this.value)'), 'class'=>'form-control', 'hidden'=>false,'div'=>false); 
								echo $this->Form->radio('select', $option, $attribute);?>
								
						<div style='display:none;'id='form-group1'>		
								
								<?php echo $this->Form->input('grouplist', array(
										  'type' => 'select',
										  'empty' => 'Select from list',
										  'multiple' => true,
										  'options' => $sublists,
										  'label'=>false
									  ));

								?>
						</div>
					</div>
				</div>
				</div>
			
			<?php echo $this->Form->submit('Send', array('type' => 'submit', 'class'=>"btn blue",'div'=>false));?>
			
			</div>
			<div class="modal-footer">
				<?php echo $this->Form->button('Cancel', array('type' => 'reset', 'div'=>false, 'data-dismiss'=>"modal", 'class'=>"btn"));?>
			</div>
			
		</div>
		<?php echo $this->Form->end();?>
	</div>
</div>
<script type="text/javascript">
$(function(){
	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
	
	form3.on('submit', function() {
		/* for(var instanceName in CKEDITOR.instances) {
			CKEDITOR.instances[instanceName].updateElement();
		} */
		alert();
	});
	
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "", // validate all fields including form hidden input
		rules: {
			'data[Accordion][category]': {
				required: true
			},
			'data[Accordion][title]': {
				required: true
			},
			'data[Accordion][content]': {
				required: true
			},
			'data[Accordion][status]': {
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