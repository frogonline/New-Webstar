<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i>Manage Sidebar
				</div>
			</div>
			<div class="portlet-body form">
				<div class="form-body">
					<div class="row">
						<div class="col-md-12">
							<?php
								echo $this->Form->button('<i class="fa fa-plus"></i> Add Shortcode', array('type'=>'button', 'id'=>'add_shortcode', 'class'=>'btn green'));
							?>
						</div>
					</div>
				</div>
			</div>
			<!-- END VALIDATION STATES-->
		</div>
	</div>
	
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i>Arrange Shortcodes
				</div>
			</div>
			<div class="portlet-body form" id="blockui_sample_3_1_element">
				<?php echo $this->Form->input('',array("type"=>"hidden", 'id'=>'sidebar_id', "label"=>false,"value"=> $id)); ?>
				<?php echo $this->Form->input('change_count',array("type"=>"hidden", 'id'=>'change_count', "label"=>false,"value"=> 0)); ?>
				<div class="form-body">
				<div class="row">
				<div class="col-md-8">
					<div class="dd" id="nestable">
					<?php 
					if(!empty($optionsArr)){
						echo '<ol class="dd-list">';
						foreach($optionsArr as $option){
							echo '<li class="dd-item" data-id="'.$option['SidebarOption']['id'].'">
								<div class="dd-handle">'.$option['SidebarOption']['widget_shortcode'].'</div>';
							echo $this->Template->shortcodelink($option['SidebarOption']['widget_shortcode'],'item_edit');
							echo $this->Html->link('&times;', 
										array(
											'controller'=>'Sidebars','action'=>'admin_itemdelete/'.$option['SidebarOption']['id'].'/'.$id
										),
										array(
											'class' =>'red item_delete',
											'escape' =>false,
											'confirm' => 'Are you sure you wish to delete this?'
										)
									);
							
							echo '</li>';
						}
						echo '</ol>'; 
					}
					?>
					</div>
				</div>
				</div>
				</div>
				<div style="clear:both"></div>
				<div class="form-actions fluid">
					<div class="col-md-offset-3 col-md-9">
						<?php echo $this->Form->button('Submit', array('class'=>"btn blue", 'id'=>'sidebar_item_save'));?>
					</div>
				</div>
			</div>
			<!-- END VALIDATION STATES-->
		</div>
	</div>
</div>
<div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h2>Add Shortcode</h2>
			</div>
			<!-- BEGIN FORM-->
			<?php echo $this->Form->create('SidebarOption', array('url'=>array('controller'=>'Sidebars', 'action'=>'admin_addoption/'.$id), 'id'=>"form_sample_3", 'class'=>"horizontal-form", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
			<div class="modal-body">
				<div>
					<?php 
						echo $this->Form->input('sidebar_id',array("type"=>"hidden", "value"=>$id));
					?>
					<div class="row">		
						<div class="col-md-6">
							<h4>Shortcode <span class="required"> * </span> </h4>
							<?php 
								echo $this->Form->input('widget_shortcode',
														array(
															'type'=>'text',
															'class'=>"form-control",
															'id'=>'shortcodeFld'
														)
													);
							?>
						</div>
						
						<div class="col-md-6">
							<h4>Or Select Shortcode</h4>
							<?php 
								echo $this->Form->button('Select Shortcode', array(
									'type'=>'button', 
									'class'=>'btn blue addCustomCol2',
									'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_new1', 'full_base'=>true))
									)
								);
							?>
						</div>
						<div class="clearfix"></div>
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
</div>
<div id="responsive1" class="modal fade" tabindex="-1" aria-hidden="true" ></div>
<script type="text/javascript">
$(function(){
	$('#add_shortcode').click(function(e){
		e.preventDefault();
		
		$('#responsive').modal('show');
	});
	
	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
	
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "", // validate all fields including form hidden input
		rules: {
			'data[SidebarOption][widget_shortcode]': {
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
	
	
	$("#sidebar_item_save").click(function(e){
		e.preventDefault();
		var change_count=$("#change_count").val();
		var sid=$("#sidebar_id").val();
		var sidebarString = window.JSON.stringify($('#nestable').nestable('serialize'));//, null, 2));
		if(change_count>0){
			
			Metronic.blockUI({
                target: '#blockui_sample_3_1_element',
                boxed: true
            });
			
			$.ajax({
				type:"post",
				url:"<?php echo $this->Html->url(array(
										"controller" => "Sidebars",
										"action" => "admin_sortitem"
									)); ?>",
				data:{sstring:sidebarString,sidebar_id:sid},
				success:function(result){
					//alert(result);
					Metronic.unblockUI('#blockui_sample_3_1_element');
					if(result=="1"){
						$("#change_count").val("0");
						alert("Sidebar Saved !");
					}
				}
			});
		}
		else{
			alert("There is no change in sidebar items");
		}
	});
	
});

$(document).ready(function() {
	Template.init();
});


var myEvent = window.attachEvent || window.addEventListener ;
var chkevent = window.attachEvent ? 'onbeforeunload' : 'beforeunload'; /// make IE7, IE8 compatable


myEvent(chkevent, function(e) { // For >=IE7, Chrome, Firefox
	var change_count=$("#change_count").val();
	var confirmationMessage = ' ';  // a space
	if(change_count>0){
		(e || window.event).returnValue = confirmationMessage;
	}
	return confirmationMessage;
});
</script>