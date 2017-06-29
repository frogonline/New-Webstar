<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	//pr($find);
	/* foreach($find as $fnd){
	echo $ptag[$fnd['PostAssignTag']['tag_id']];
	
	} */
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i>Manage Plan Feature
				</div>
			</div>
			<div class="portlet-body flip-scroll">
				<!-- BEGIN FORM-->
				<?php 
				echo $this->Form->create('PlanFeature', array('url'=>array('controller'=>'PricingTables','action'=>'admin_manage/'.$id), 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); 
				echo $this->Form->input('plan_id',array("type"=>"hidden",'id'=>'plan_id',"label"=>false,"value"=> $id));
				?>
				<div class="row">
					<div class="col-md-6">
					<?php 
						echo $this->Form->input('feature_description', array(
												'type' => "text",
												'placeholder'=>"Enter Plan's Feature",
												'class' => "form-control"
											)); 
					?>
					</div>
					<div class="col-md-6">
						<?php echo $this->Form->submit('submit', array('type'=>'submit','class'=>"btn blue"));?>
					</div>
					
				</div>
				<?php echo $this->Form->end(); ?>
				<!-- END FORM-->
			</div>
			<!-- END VALIDATION STATES-->
		</div>
	</div>
	
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i>Arrange Plan's Feature
				</div>
			</div>
			<div class="portlet-body form" id="blockui_sample_3_1_element">
				<?php echo $this->Form->input('',array("type"=>"hidden", 'id'=>'plan_id', "label"=>false,"value"=> $id)); ?>
				<?php echo $this->Form->input('change_count',array("type"=>"hidden", 'id'=>'change_count', "label"=>false,"value"=> 0)); ?>
				<div class="form-body">
				<div class="row">
				<div class="col-md-8">
					<div class="dd" id="nestable">
					<?php 
					if(!empty($data)){
						echo '<ol class="dd-list">';
						foreach($data as $option){
							echo '<li class="dd-item" data-id="'.$option['PlanFeature']['id'].'">
								<div class="dd-handle">'.$option['PlanFeature']['feature_description'].'</div>';
							?>
							<a data-toggle="modal" href="#responsive1" rel="<?php echo $option['PlanFeature']['id']; ?>" class="blue item_edit"><i class="fa fa-edit"></i></a>
							<?php 
							echo $this->Html->link('&times;', 
									array(
										'controller'=>'PricingTables','action'=>'admin_itemdelete/'.$option['PlanFeature']['id'].'/'.$id
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
<div id="responsive1" class="modal fade" tabindex="-1" aria-hidden="true"></div>

<script type="text/javascript">
$(function(){
	var form3 = $('#form_sample_3');
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
										"controller" => "PricingTables",
										"action" => "admin_sortitem"
									)); ?>",
				data:{sstring:sidebarString,sidebar_id:sid},
				success:function(result){
					//alert(result);
					Metronic.unblockUI('#blockui_sample_3_1_element');
					if(result=="1"){
						$("#change_count").val("0");
						alert("Featured Arranged !");
					}
				}
			});
		}
		else{
			alert("There is no change in feature items");
		}
	});
	
	$('.item_edit').click(function(e){
		e.preventDefault();
		var plan_id =$("#plan_id").val();
		//alert(plan_id);
		if($(this).attr('rel'))
		{
			var id = $(this).attr('rel');
		}
		else
		{
			var id = '';
		}
		$.ajax({
			type:'POST',
			url:'<?php echo $this->Html->url(array('controller'=>'PricingTables','action'=>'admin_editfeature/','full_base'=>true)); ?>',
			data:{id:id,plan_id:plan_id},
			success:function(result){
				$('#responsive1').html(result);
			}
		});
	});	
	
});
</script>