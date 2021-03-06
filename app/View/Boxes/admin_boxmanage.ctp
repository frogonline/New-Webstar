<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
?>
<style>
.cke_contents.cke_reset {
  height: 200px !important;
}
</style>
<div class="modal-dialog">
	<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h2 class="modal-title"><?php if($id!=''){ ?>Edit<?php }else{ ?> Add<?php } ?> Item</h2>
			</div>
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('Box', array('action' => 'admin_boxmanageupdate/'.$box_id.'/'.$style.'/'.$id, 'id'=>"form_sample_2", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
			<div class="modal-body">
				<div class="scroller" data-always-visible="1" data-rail-visible1="1">
					<div class="row">
						<div class="col-md-12">
							<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
							<?php echo $this->Form->input('box_id',array("type"=>"hidden","label"=>false,"value"=> $box_id)); ?>
							<?php echo $this->Form->input('boxstyle',array("type"=>"hidden","label"=>false,"value"=> $style)); ?>
					
						<?php
						if($style == 'style1')
						{
						?>
					
							<div class="col-md-12">
								<h4>Header Style<span class="required"> * </span></h4>
									<?php 
										$styles = array('head1'=>'Style 1','head2'=>'Style 2','head3'=>'Style 3');
										echo $this->Form->input('boxheaderstyle',
																array('options'=>$styles, 
																	  'empty'=>'Select Style', 
																	  'data-required'=>1, 
																	  'class'=>"form-control",
																	  'id' =>'styler',
																	  'selected'=> (isset($data1['BoxContent']))?$data1['BoxContent']['boxheaderstyle']:'')
																);
									  ?>
							</div>
							
							
							<div class="col-md-12">
								<h4>Header Title<span class="required"> * </span></h4>
									<?php echo $this->Form->input('boxheadertitle',array('value'=>(isset($data1['BoxContent']))?$data1['BoxContent']['boxheadertitle']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Box Header Title", 'type'=>"text")); ?>
							</div>
							
							
					
					<?php
						}
					?>
					
					
					<?php
						if($style == 'style2' || $style == 'style5' || $style == 'style4')
						{
					?>
					
							<div class="col-md-6">
								<h4>Side Style<span class="required"> * </span></h4>
									<?php 
										//$styles12 = array(''=>'Select Style','fa fa-users'=>'Style 1','fa fa-plane'=>'Style 2','fa fa-rocket'=>'Style 3','fa fa-thumbs-up'=>'Style 4');
										echo $this->Form->input('sidestyle',
																array('type'=>'text',
																	  'data-required'=>1, 
																	  'class'=>"form-control",
																	  'id' =>'itemclsFld',
																	  'value'=> (isset($data1['BoxContent']))?$data1['BoxContent']['sidestyle']:'')
																);
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
					
					
					<?php
						if($style == 'style3')
						{
					?>
					
							<div class="col-md-6">
								<h4>Header Style<span class="required"> * </span></h4>
									<?php 
										//$styles_head = array(''=>'Select Style','fa fa-plane'=>'Style 1','fa fa-thumbs-up'=>'Style 2','fa fa-download'=>'Style 3');
										echo $this->Form->input('boxheaderstyle',
																array(//'options'=>$styles_head, 
																	  //'default'=>'',
																	'type'=>'text',			  
																	  'data-required'=>1, 
																	  'class'=>"form-control",
																	  'id' =>'itemclsFld',
																	  'value'=> (isset($data1['BoxContent']))?$data1['BoxContent']['boxheaderstyle']:'')
																);
									  ?>
							</div>
							<div class="col-md-6">
							<h4>Or Choose Your Icon</h4>
							<?php
							echo $this->Form->button('Choose Icon', array('escape'=>false, 'class'=>'btn btn-primary', 'id'=>'chooseIconBtn', 'type'=>'button'));
							echo $this->Html->image(SITE_URL."img/loader.gif", array('alt'=>'', 'style'=>'display:none;', 'id'=>'waitingDiv', 'class'=>'pull-right'));
							?>
						</div>
							
							<div class="col-md-12">
								<h4>Background Style<span class="required"> * </span></h4>
									<?php 
										/* $styles_background = array(''=>'Select Style','bg-1'=>'Style 1','bg-2'=>'Style 2','bg-3'=>'Style 3');
										echo $this->Form->input('backgroundstyle',
																array('options'=>$styles_background, 
																	  'default'=>'', 
																	  'data-required'=>1, 
																	  'class'=>"form-control",
																	  'id' =>'styler',
																	  'selected'=> (isset($data1['BoxContent']))?$data1['BoxContent']['backgroundstyle']:'')
																); */
										if(!empty($data1)){
											if($data1['BoxContent']['backgroundstyle']==""){
												echo $this->Form->input('backgroundstyle', array(
														'class'=>"form-control",
														'type'=>'file'
													)
												);
											} else {
												echo '<div class="col-md-6">';
												echo $this->Html->image(IMGPATH.'backgroundstyle/resize/'.$data1['BoxContent']['backgroundstyle'], array('alt'=>'', 'class'=>'img-responsive'));
												echo '</div>';
											}
										} else {
											echo $this->Form->input('backgroundstyle', array(
													'class'=>"form-control",
													'type'=>'file'
												)
											);
										}
									  ?>
							</div>
							
							
					
					<?php
						}
					?>
					
					<?php
						if($style == 'style7' || $style == 'style6' || $style == 'style8')
						{
					?>
					
							<div class="col-md-6">
								<h4>Header Style<span class="required"> * </span></h4>
									<?php 
										//$styles_head = array(''=>'Select Style','icon-comment'=>'Style 1','icon-inbox'=>'Style 2','icon-camera'=>'Style 3');
										echo $this->Form->input('boxheaderstyle',
																array('type'=>'text',
																//'options'=>$styles_head, 
																	  //'default'=>'', 
																	  'data-required'=>1, 
																	  'class'=>"form-control",
																	 'id' =>'itemclsFld',
																	  'value'=> (isset($data1['BoxContent']))?$data1['BoxContent']['boxheaderstyle']:'')
																);
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
								<h4>Box Title<span class="required"> * </span></h4>
								<?php echo $this->Form->input('boxtitle',array('value'=>(isset($data1['BoxContent']))?$data1['BoxContent']['boxtitle']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Box Title", 'type'=>"text")); ?>
						</div>
						       
						
						<div class="col-md-12">
								<h4>Box Content<span class="required"> * </span></h4>
						<?php echo $this->Form->input('boxcontent',array('value'=>(isset($data1['BoxContent']))?$data1['BoxContent']['boxcontent']:'',  'data-required'=>1, 'class'=>"ckeditor form-control", 'placeholder'=>"Enter Box Content", 'type'=>"textarea")); ?>
								<?php
									if($style == 'style4')
									{
								?>
										<font style="color:red">For multiple content, Provide comma(,) after each content.</font>
								<?php
									}
								?>
						</div>
						
						<div class="col-md-12">
								<h4>Box Link<span class="required">  </span></h4>
					<?php echo $this->Form->input('boxlink',array('value'=>(isset($data1['BoxContent']))?$data1['BoxContent']['boxlink']:'',  'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Box Link", 'type'=>"text",'height'=>'100px')); ?>
						</div>
						
						
						<div class="col-md-12">
								<h4>Select Status<span class="required"> * </span></h4>
									<?php  
										echo $this->Form->input('status', array(
																'options' => $statusArr,
																'empty' => 'Select Status',	
																'class' => 'form-control',
																'selected'=> (isset($data1['BoxContent']))?$data1['BoxContent']['status']:''
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
	$('#chooseIconBtn').click(function(e){
		e.preventDefault();
		$.ajax({
			type:'POST',
			url:'<?php echo $this->Html->url(array('controller'=>'Boxes','action'=>'admin_icon','full_base'=>true)); ?>',
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
		
		
		
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "", // validate all fields including form hidden input
		rules: {
			
			'data[Box][backgroundstyle]': {
				required: true
			},
			'data[Box][boxheadertitle]': {
				required: true
			},
			'data[Box][boxtitle]': {
				required: true
			},
			'data[Box][boxcontent]': {
				required: true
			},
			'data[Box][status]': {
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

</script>
<script>
  CKEDITOR.replace( 'data[Box][boxcontent]' );
 </script>
