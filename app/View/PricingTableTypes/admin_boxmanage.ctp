<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
?>
<style>
#cke_1_contents {
  height: 150px !important;
}
</style>
<div class="modal-dialog">
	<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h2 class="modal-title"><?php if($id!=''){ ?>Edit<?php }else{ ?> Add<?php } ?> Pricing Table Content</h2>
			</div>
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('PricePlan', array('url'=>array('controller'=>'PricingTableTypes','action' => 'admin_boxmanageupdate/'.$box_id.'/'.$style.'/'.$id), 'id'=>"form_sample_2", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
			<div class="modal-body">
				<div class="scroller" data-always-visible="1" data-rail-visible1="1">
					<div class="row">
						<div class="col-md-12">
					<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
					<?php echo $this->Form->input('pricing_id',array("type"=>"hidden","label"=>false,"value"=> $box_id)); ?>
					
						<div class="col-md-12">
								<h4>Plan Name<span class="required"> * </span></h4>
								<?php echo $this->Form->input('plan_name',array('value'=>(isset($data1['PricePlan']))?$data1['PricePlan']['plan_name']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Plan Name", 'type'=>"text")); ?>
						</div>
						
						
						<div class="col-md-12">
								<h4>Plan Price<span class="required"> * </span></h4>
								<?php echo $this->Form->input('plan_price',array('value'=>(isset($data1['PricePlan']))?$data1['PricePlan']['plan_price']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Plan Price", 'type'=>"text")); ?>
						</div>
						
						<div class="col-md-12">
								<h4>Plan Description<span class="required"> * </span></h4>
								<?php echo $this->Form->input('plan_description',array('value'=>(isset($data1['PricePlan']))?$data1['PricePlan']['plan_description']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Plan Description", 'type'=>"textarea")); ?>
						</div>
						
						<div class="col-md-12">
								<h4>Link<span class="required"> * </span></h4>
								<?php echo $this->Form->input('buy_link',array('value'=>(isset($data1['PricePlan']))?$data1['PricePlan']['buy_link']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Link", 'type'=>"text")); ?>
						</div>
						
						
						<div class="col-md-12">
								<h4>Select Status<span class="required"> * </span></h4>
									<?php  
										echo $this->Form->input('status', array(
																'options' => $statusArr,
																'empty' => 'Select Status',	
																'class' => 'form-control',
																'selected'=> (isset($data1['PricePlan']))?$data1['PricePlan']['status']:''
															));
									?>  
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
			<!-- END VALIDATION STATES-->
		</div>


<script type="text/javascript">
$(function(){
	var form3 = $('#form_sample_2');
	var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
	
	/* form3.on('submit', function() {
		 for(var instanceName in CKEDITOR.instances) {
			CKEDITOR.instances[instanceName].updateElement();
		} 
		alert();
	}); */
	
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "", // validate all fields including form hidden input
		rules: {
			'data[PricePlan][plan_name]': {
				required: true
			},
			'data[PricePlan][plan_price]': {
				required: true
			},
			'data[PricePlan][plan_description]': {
				required: true
			},
			'data[PricePlan][buy_link]': {
				required: true
			},
			'data[PricePlan][status]': {
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
  CKEDITOR.replace( 'data[PricePlan][plan_description]' );
</script>