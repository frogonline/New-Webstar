<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h2 class="modal-title">Edit Menu</h2>
		</div>
		<?php echo $this->Form->create('MenuMaster', array('url'=>array('controller'=>'MenuMasters','action' => 'admin_updatemenu/'.$menuData['MenuMaster']['id']), 'id'=>"form_sample_4", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<div class="modal-body">
			<div class="scroller" data-always-visible="1" data-rail-visible1="1">
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-12">
							<h4>Menu Name <span class="required"> * </span></h4>
							<?php echo $this->Form->input('menu_name', array('type'=>'text', 'data-required'=>1,'placeholder'=>"Enter Menu Name", 'value'=>$menuData['MenuMaster']['menu_name'], 'class'=>'col-md-12 form-control'));
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<?php echo $this->Form->button('Save changes', array('type' => 'submit', 'class'=>"btn green"));?>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
<script type="text/javascript">
var form3 = $('#form_sample_4');
	var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
	
form3.validate({
	errorElement: 'span', //default input error message container
	errorClass: 'help-block', // default input error message class
	focusInvalid: false, // do not focus the last invalid input
	ignore: "", // validate all fields including form hidden input
	rules: {
		'data[MenuitemMaster][page_title]': {
			required: true
		},
		'data[MenuitemMaster][page_url]': {
			required: true
		}
	},
	errorPlacement: function (error, element) { // render error placement for each input type
		error.insertAfter(element); // for other inputs, just perform default behavior
	},

	invalidHandler: function (event, validator) { //display error alert on form submit   
		success3.hide();
		error3.show();
		//Metronic.scrollTo(error3, -0);
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
</script>