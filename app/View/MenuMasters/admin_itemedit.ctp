<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h2 class="modal-title">Edit Item</h2>
		</div>
		<?php echo $this->Form->create('MenuitemMaster', array('url'=>array('controller'=>'MenuMasters','action' => 'admin_updateitem/'.$itemData['MenuitemMaster']['id'].'/'.$itemData['MenuitemMaster']['menu_id']), 'id'=>"form_sample_4", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<div class="modal-body">
			<div class="scroller" data-always-visible="1" data-rail-visible1="1">
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-12">
							<h4>Item Name <span class="required"> * </span></h4>
							<?php echo $this->Form->input('page_title', array('type'=>'text', 'data-required'=>1,'placeholder'=>"Enter Item Name", 'value'=>$itemData['MenuitemMaster']['page_title'], 'class'=>'col-md-12 form-control')); ?>
						</div>
						<div class="col-md-6">
							<h4>Item Class</h4>
							<?php echo $this->Form->input('class', array('type'=>'text', 'data-required'=>1,'placeholder'=>"Enter Item CSS Class", 'value'=>$itemData['MenuitemMaster']['class'], 'id'=>'itemclsFld', 'class'=>'col-md-12 form-control ')); ?>
						</div>
						<div class="col-md-6">
							<h4>Or Choose Your Icon</h4>
							<?php
							echo $this->Form->button('Choose Icon', array('escape'=>false, 'class'=>'btn btn-primary', 'id'=>'chooseIconBtn', 'type'=>'button'));
							echo $this->Html->image(SITE_URL."img/loader.gif", array('alt'=>'', 'style'=>'display:none;', 'id'=>'waitingDiv', 'class'=>'pull-right'));
							?>
						</div>
						<div class="col-md-12">
							<h4>Item URL <span class="required">* </span></h4>
							<?php echo $this->Form->input('page_url', array('type'=>'text', 'data-required'=>1,'placeholder'=>"Enter URL", 'value'=>$itemData['MenuitemMaster']['page_url'], 'class'=>'form-control')); ?>
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
<div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true">
		
</div>


<script type="text/javascript">
$(function() {
	/**** Item Edit ****/
	$('#chooseIconBtn').click(function(e){
		e.preventDefault();
		$.ajax({
			type:'POST',
			url:'<?php echo $this->Html->url(array('controller'=>'MenuMasters','action'=>'admin_icon','full_base'=>true)); ?>',
			data:{box_id:1},
			beforeSend:function(element){
				$("#waitingDiv").show();
			},
			complete:function(element){
				$("#waitingDiv").hide();
			},
			success:function(result){
				$('#responsiveicon').html(result);
				$('#responsiveicon').modal("show");
			}
		});
	});
});

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
/* $(function() {
	/**** Item Edit ****/
	/*$('.font').click(function(e){
		e.preventDefault();
		var itemId = $(this).attr('data-id');
		$.ajax({
			type:'POST',
			url:'<?php echo $this->Html->url(array('controller'=>'MenuMasters','action'=>'admin_icon','full_base'=>true)); ?>',
			data:{item_id:itemId},
			success:function(result){
				$('#responsive').html(result);
			}
		});
	});
	
}); */
</script>