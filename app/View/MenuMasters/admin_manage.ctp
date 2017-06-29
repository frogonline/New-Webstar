<div class="row">
	<div class="col-md-4">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i>CMS Pages List
				</div>
			</div>
			<div class="portlet-body form">
				<?php echo $this->Form->create('MenuMaster', array('url'=>array('controller'=>'MenuMasters','action' => 'admin_menu_option/'.$id), 'id'=>"validate", 'class'=>"form", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
				<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
				<div class="form-body">
					<div class="scroller" style="height:150px" data-always-visible="1" data-rail-visible="0">
					<?php 
					foreach($page as $p){
					?>
					<div class="form-group">
					<?php
						echo $this->Form->checkbox('published', array(
							'name' => 'data[MenuitemMaster][page_id][]',
							'value' => $p['Page']['id'],
							'hiddenField' => false,
							'data-error-container' => '#custom_error_div',
							'div'=>false
						));
						echo $p['Page']['title'];
					?>
					</div>
					<?php
					}
					?>
				
					</div>
				</div>
				<div class="form-actions fluid">
					<div class="col-md-offset-3 col-md-9">
						<div id="custom_error_div"></div>
						<?php echo $this->Form->button('Submit', array('type' => 'submit', 'class'=>"btn blue"));?>
					</div>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
		
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i>Product Category List
				</div>
			</div>
			<div class="portlet-body form">
				<?php echo $this->Form->create('MenuMaster', array('url'=>array('controller'=>'MenuMasters','action' => 'admin_menu_productcategory/'.$id), 'id'=>"validate_productcat", 'class'=>"form", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
				<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
				<div class="form-body">
					<div class="scroller" style="height:150px" data-always-visible="1" data-rail-visible="0">
					<?php 
					foreach($productcategory as $prodCat){
					?>
					<div class="form-group">
					<?php
						echo $this->Form->checkbox('published', array(
							'name' => 'data[MenuitemMaster][productcategory_id][]',
							'value' => $prodCat['ProductCategory']['id'],
							'hiddenField' => false,
							'data-error-container' => '#custom_errorprodcat_div',
							'div'=>false
						));
						echo $prodCat['ProductCategory']['name'];
					?>
					</div>
					<?php
					}
					?>
				
					</div>
				</div>
				<div class="form-actions fluid">
					<div class="col-md-offset-3 col-md-9">
						<div id="custom_errorprodcat_div"></div>
						<?php echo $this->Form->button('Submit', array('type' => 'submit', 'class'=>"btn blue"));?>
					</div>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
		
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i>Post Category List
				</div>
			</div>
			<div class="portlet-body form">
				<?php echo $this->Form->create('MenuMaster', array('url'=>array('controller'=>'MenuMasters','action' => 'admin_menu_postcategory/'.$id), 'id'=>"validate_postcat", 'class'=>"form", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
				<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
				<div class="form-body">
					<div class="scroller" style="height:150px" data-always-visible="1" data-rail-visible="0">
					<?php 
					foreach($postcategory as $postCat){
					?>
					<div class="form-group">
					<?php
						echo $this->Form->checkbox('published', array(
							'name' => 'data[MenuitemMaster][postcategory_id][]',
							'value' => $postCat['PostCategory']['id'],
							'hiddenField' => false,
							'data-error-container' => '#custom_errorpostcat_div',
							'div'=>false
						));
						echo $postCat['PostCategory']['category_name'];
					?>
					</div>
					<?php
					}
					?>
				
					</div>
				</div>
				<div class="form-actions fluid">
					<div class="col-md-offset-3 col-md-9">
						<div id="custom_errorpostcat_div"></div>
						<?php echo $this->Form->button('Submit', array('type' => 'submit', 'class'=>"btn blue"));?>
					</div>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i>Add Blog Link
				</div>
			</div>
			<div class="portlet-body form">
				<?php echo $this->Form->create('MenuitemMaster', array('url'=>array('controller'=>'MenuMasters','action' => 'admin_custom_option/'.$id), 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
				<?php echo $this->Form->input('menu_id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
				<div class="form-body">
					<div class="form-group">
						<label class="col-md-12">Item Name <span class="required">
						* </span>
						</label>
						<div class="col-md-12">
							<?php echo $this->Form->input('page_title', array('type'=>'text', 'data-required'=>1,'placeholder'=>"Enter Item Name", 'class'=>'form-control')); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-12">Item URL <span class="required">
						* </span>
						</label>
						<div class="col-md-12">
							<?php echo $this->Form->input('page_url', array('type'=>'text', 'data-required'=>1,'value'=>SITE_URL."blog", 'class'=>'form-control','readonly'=>"readonly")); ?>
						</div>
					</div>
				</div>
				<div class="form-actions fluid">
					<div class="col-md-offset-3 col-md-9">
						<?php echo $this->Form->button('Submit', array('type' => 'submit', 'class'=>"btn blue"));?>
					</div>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
		
		
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i>Add Custom Navigation Item 
				</div>
			</div>
			<div class="portlet-body form">
				<?php echo $this->Form->create('MenuitemMaster', array('url'=>array('controller'=>'MenuMasters','action' => 'admin_custom_option/'.$id), 'id'=>"form_sample_4", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
				<?php echo $this->Form->input('menu_id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
				<div class="form-body">
					<div class="form-group">
						<label class="col-md-12">Item Name <span class="required">
						* </span>
						</label>
						<div class="col-md-12">
							<?php echo $this->Form->input('page_title', array('type'=>'text', 'data-required'=>1,'placeholder'=>"Enter Item Name", 'class'=>'form-control')); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-12">Item URL <span class="required">
						* </span>
						</label>
						<div class="col-md-12">
						
							
							<?php echo $this->Form->input('page_url', array('type'=>'text', 'data-required'=>1,'placeholder'=>"Enter Page Url", 'class'=>'form-control')); ?>
							
							
						</div>
					</div>
				</div>
				<div class="form-actions fluid">
					<div class="col-md-offset-3 col-md-9">
						<?php echo $this->Form->button('Submit', array('type' => 'submit', 'class'=>"btn blue"));?>
					</div>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
		
		
		
		
		
		
		
		
	</div>
	
	<div class="col-md-8">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i>Manage Items
				</div>
			</div>
			<div class="portlet-body form" id="blockui_sample_3_1_element">
				<?php echo $this->Form->input('menu_id',array("type"=>"hidden", 'id'=>'menu_id', "label"=>false,"value"=> $id)); ?>
				<?php echo $this->Form->input('change_count',array("type"=>"hidden", 'id'=>'change_count', "label"=>false,"value"=> 0)); ?>
				<div class="form-body">
					<div class="dd" id="nestable">
					<?php 
						if(!empty($menu)){
							$default = array(
								'menu_slug' => $menu['MenuMaster']['menu_slug'],
								'container_div' => false,
								'container_class' => '',
								'container_id' => '',
								'menu_class' => 'dd-list',
								'menu_id' => ''
							);
							$i = $this->MenuitemMasters->cp_admin_menu($default); 
							echo $i;
						}
					?>
					</div>
				</div>
				<div style="clear:both"></div>
				<div class="form-actions fluid">
					<div class="col-md-offset-3 col-md-9">
						<?php echo $this->Form->button('Submit', array('class'=>"btn blue", 'id'=>'menu_item_save'));?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true">
	
</div>
<div id="responsiveicon" class="modal fade" tabindex="-1" aria-hidden="true">
	
</div>

<script type="text/javascript">
$(function() {
	/**** Item Edit ****/
	$('.item_edit').click(function(e){
		e.preventDefault();
		var itemId = $(this).attr('data-id');
		$.ajax({
			type:'POST',
			url:'<?php echo $this->Html->url(array('controller'=>'MenuMasters','action'=>'admin_itemedit','full_base'=>true)); ?>',
			data:{item_id:itemId},
			success:function(result){
				$('#responsive').html(result);
			}
		});
	});
	
	
	/**** ****/
	var formvalidate = $('#validate');
	var errorvalidate = $('.alert-danger', form3);
    var successvalidate = $('.alert-success', form3);
	
	formvalidate.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "", // validate all fields including form hidden input
		rules: {
			'data[MenuitemMaster][page_id][]': {
				required: true
			}
		},
		errorPlacement: function (error, element) { // render error placement for each input type
			error.appendTo(element.attr("data-error-container")); // for other inputs, just perform default behavior
		},

		invalidHandler: function (event, validator) { //display error alert on form submit   
			successvalidate.hide();
			errorvalidate.show();
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
	
	/**** ****/
	var formvalidate = $('#validate_productcat');
	var errorvalidate = $('.alert-danger', form3);
    var successvalidate = $('.alert-success', form3);
	
	formvalidate.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "", // validate all fields including form hidden input
		rules: {
			'data[MenuitemMaster][productcategory_id][]': {
				required: true
			}
		},
		errorPlacement: function (error, element) { // render error placement for each input type
			error.appendTo(element.attr("data-error-container")); // for other inputs, just perform default behavior
		},

		invalidHandler: function (event, validator) { //display error alert on form submit   
			successvalidate.hide();
			errorvalidate.show();
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
	
	/**** ****/
	var formvalidate = $('#validate_postcat');
	var errorvalidate = $('.alert-danger', form3);
    var successvalidate = $('.alert-success', form3);
	
	formvalidate.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "", // validate all fields including form hidden input
		rules: {
			'data[MenuitemMaster][postcategory_id][]': {
				required: true
			}
		},
		errorPlacement: function (error, element) { // render error placement for each input type
			error.appendTo(element.attr("data-error-container")); // for other inputs, just perform default behavior
		},

		invalidHandler: function (event, validator) { //display error alert on form submit   
			successvalidate.hide();
			errorvalidate.show();
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
	
	//Custom Item Validation
	var form3 = $('#form_sample_3');
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
	
	
	
	
	
	
	
	
	
	
	
	
	
	$('#nestable').nestable({
        group: 1
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
	
	$("#menu_item_save").click(function(e){
		e.preventDefault();
		var change_count=$("#change_count").val();
		var mid=$("#menu_id").val();
		var menuString = window.JSON.stringify($('#nestable').nestable('serialize'));//, null, 2));
		if(change_count>0){
			
			Metronic.blockUI({
                target: '#blockui_sample_3_1_element',
                boxed: true
            });
			
			$.ajax({
				type:"post",
				url:"<?php echo $this->Html->url(array(
										"controller" => "MenuMasters",
										"action" => "admin_update_menu"
									)); ?>",
				data:{mstring:menuString,menu_id:mid},
				success:function(result){
					Metronic.unblockUI('#blockui_sample_3_1_element');
					if(result=="1"){
						$("#change_count").val("0");
						alert("Menu Saved !");
					}
				}
			});
		}
		else{
			alert("There is no change in menu items");
		}
	});
	
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