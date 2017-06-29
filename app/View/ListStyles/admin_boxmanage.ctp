<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$link = array('Y'=>'Yes','N'=>'No');
?>

<div class="modal-dialog">
	<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h2 class="modal-title"><?php if($id!=''){ ?>Edit<?php }else{ ?> Add<?php } ?> List Content</h2>
			</div>
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('ListStyle', array('action' => 'admin_boxmanageupdate/'.$list_id.'/'.$style.'/'.$id, 'id'=>"form_sample_2", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
				<?php
					if(empty($id)){
						echo $this->Form->input('date_created', array('type'=>'hidden','value'=>date('Y-m-d')));
					} else {
						echo $this->Form->input('date_modified', array('type'=>'hidden','value'=>date('Y-m-d')));
					}
				?>
			<div class="modal-body">
				<div class="scroller" data-always-visible="1" data-rail-visible1="1">
					<div class="row">
						<div class="col-md-12">
					<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
					<?php echo $this->Form->input('list_id',array("type"=>"hidden","label"=>false,"value"=> $list_id)); ?>
					

				
						
						<div class="col-md-12">
								<h4>List style Content<span class="required"> * </span></h4>
								<?php echo $this->Form->input('listcontent',array('value'=>(isset($data1['ListContent']))?$data1['ListContent']['listcontent']:'',  'data-required'=>1, 'class'=>"form-control",  'placeholder'=>"Enter  list contents Title",  'type'=>"text")); ?>
						</div>
						
						<div class="col-md-12">
								<h4>Make Link? <span class="required"> * </span></h4>
								<?php
								echo $this->Form->input('make_link', array(
										'options'=>$link,
										'value'=>(!empty($data1))?$data1['ListContent']['make_link']:'',
										'class' => 'link',
										'type'=>'radio',
										'data-error-container'=>'#customerror_div',
										'before' => '<label class="col-md-2">',
										'after' => '</label>',
										'separator' => '</label><label class="col-md-2">',
										'legend'=>false,
										'hiddenField'=>false
									)
								);
								?>
						</div>
						
						<div id="link" class="col-md-12" style=<?php echo (!empty($data1))?($data1['ListContent']['make_link']=='Y')?'"display: block;"':'"display: none;"':'"display: none;"'; ?>>
								<h4>Link <span class="required"> * </span></h4>
								<?php echo $this->Form->input('link',array('value'=>(isset($data1['ListContent']))?$data1['ListContent']['link']:'', 'data-required'=>1, 'class'=>"form-control",  'placeholder'=>"Enter Link",  'type'=>"text")); ?>
						</div>
						
						<?php
							if($style == 'style1' || $style == 'style2')
							{
						?>
						<div class="col-md-6">
								<h4>Select Style<span class="required"> * </span></h4>
									<?php 
										/* $styles = array('fa fa-rocket'=>'Rocket','fa fa-plane'=>'Plane','fa fa-user'=>'User','fa fa-refresh'=>'Refresh'); */
										echo $this->Form->input('listcontentstyle', array(
																'type' => 'text','empty' => 'Select Style','class' => 'form-control','id'=>'itemclsFld','value'=> (isset($data1['ListContent']))?$data1['ListContent']['listcontentstyle']:''
															));
									?>  
						</div>
						<div class="col-md-6">
							<h4>Or Choose Your Icon</h4>
							<?php
							echo $this->Form->button('Choose Icon', array('escape'=>false, 'class'=>'btn btn-primary', 'id'=>'chooseIconBtn', 'type'=>'button'));
							echo $this->Html->image(SITE_URL."img/loader.gif", array('alt'=>'', 'style'=>'display:none;', 'id'=>'waitingDiv', 'class'=>'pull-right'));
							?>
						</div>
						
						<?php
							}
						?>
						
						
						<div class="col-md-12">
								<h4>Select Status<span class="required"> * </span></h4>
									<?php  
										echo $this->Form->input('status', array(
																'options' => $statusArr,
																'empty' => 'Select Status',	
																'class' => 'form-control',
																'selected'=> (isset($data1['ListContent']))?$data1['ListContent']['status']:''
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
<div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true">
		
</div>

<script type="text/javascript">
$(function(){
	$('#chooseIconBtn').click(function(e){
		e.preventDefault();
		$.ajax({
			type:'POST',
			url:'<?php echo $this->Html->url(array('controller'=>'ListStyles','action'=>'admin_icon','full_base'=>true)); ?>',
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

	var form3 = $('#form_sample_2');
	var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
	
	form3.on('submit', function() {
		for(var instanceName in CKEDITOR.instances) {
			CKEDITOR.instances[instanceName].updateElement();
		}
	});
	
	
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "", // validate all fields including form hidden input
		rules: {
			'data[ListStyle][listcontentstyle]': {
				required: true
			},
			'data[ListStyle][listcontent]': {
				required: true
			},
			'data[ListStyle][status]': {
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
	
	$(function(){
    $(".link").click(function(){
      if($(this).val() === "Y")
        $("#link").show("fast");
      else
        $("#link").hide("fast");
    });
  });
	
	/* function link()
	{
		var link = document.getElementByClass('link').value;
		if(link=='Y')
		{
			
		}
	} */
	

</script>