<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h2>Edit Icon Link</h2>
		</div>
		<!-- BEGIN FORM-->
		<?php echo $this->Form->create('SocialWidget', array('id'=>"socialwidgetForm", 'class'=>"horizontal-form", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<h4>Link <span class="required"> * </span> </h4>
					<?php 
					echo $this->Form->input('link', array(
							'type'=>'text',
							'class'=>"form-control",
							'value'=>(!empty($data))?$data['SocialWidget']['link']:'',
							'data-required'=>1
						)
					);
					?>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<?php
				echo $this->Form->button('Submit', array('type' => 'submit', 'class'=>"btn blue"));
			?>
		</div>
		<?php echo $this->Form->end(); ?>
		<!-- END FORM-->
	</div>
	<!-- END VALIDATION STATES-->
</div>

<script type="text/javascript">
$(function(){
	var form3 = $('#socialwidgetForm');
	var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
	
	var validator = form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "", // validate all fields including form hidden input
		rules: {
			'data[SocialWidget][link]': {
				required: true,
				url: true
			}
		},
		errorPlacement: function (error, element) { // render error placement for each input type
			if (element.attr("data-error-container")) { 
				error.appendTo(element.attr("data-error-container"));
			} else {
				error.insertAfter(element); // for other inputs, just perform default behavior
			}
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
	
	$('#socialwidgetForm').submit(function(e){
		e.preventDefault();
		var data = $(this).serialize();
		if(validator.form()){
			$.ajax({
				type:'POST',
				url:'<?php echo $this->Html->url(array('controller'=>'SocialWidgets', 'action'=>'admin_iconeditformsubmit/'.$data['SocialWidget']['id'])); ?>',
				data:data,
				success:function(result){
					if(result.trim() == 1){
						$('#socialwidgetForm')[0].reset();
						$('#responsive').modal('hide');
					} else {
						alert('Failed to update the link!');
					}
				}
			});
		}
	});
});
</script>