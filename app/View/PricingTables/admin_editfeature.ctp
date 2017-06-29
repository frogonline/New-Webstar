<div class="modal-dialog">
	<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h2 class="modal-title">Edit Plan Feature</h2>
			</div>
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('PlanFeature', array('url'=>array('controller'=>'PricingTables', 'action' => 'admin_manage/'.$id), 'id'=>"form_sample_1", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
			<div class="modal-body">
				<div class="scroller" data-always-visible="1" data-rail-visible1="1">
					<div class="row">
						<div class="col-md-12">
					   <?php echo $this->Form->input('plan_id',array("type"=>"hidden","label"=>false,"value"=> $plan_id)); ?>
						<div class="col-md-12">
								<h4>Feature Description<span class="required"> * </span></h4>
								<?php echo $this->Form->input('feature_description',array('value'=>(isset($data['PlanFeature']))?$data['PlanFeature']['feature_description']:'',  'data-required'=>1, 'class'=>"form-control", 'type'=>"text")); ?>
						</div>
						</div>
					</div>
				</div>
			</div>	
			<div class="modal-footer">
				<?php echo $this->Form->button('Submit', array('type' => 'submit', 'class'=>"btn blue"));?>
			</div>
				<?php echo $this->Form->end(); ?>
				<!-- END FORM-->
	</div>
</div>
<script type="text/javascript">
$(function(){
	var form3 = $('#form_sample_1');
	var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
		
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "", // validate all fields including form hidden input
		rules: {
			'data[PlanFeature][feature_description]': {
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
	
	//Sorting
	$('#nestable').nestable({
        group: 1,
		maxDepth: 1
    })
    .on('change', function(e){
		var menuString="";
		var change_count=$("#change_count").val();
		change_count++;
		
		if (window.JSON) {
            menuString = window.JSON.stringify($('#nestable').nestable('serialize'));//, null, 2));
        } else {
            alert('JSON browser support required for this demo.');
        }
		menuString=window.JSON.stringify($('#nestable').nestable('serialize'));
		$("#change_count").val(change_count);
		
		
	});
	});
</script>
	
