<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i><?php echo (isset($id))?'Edit':'Add' ?> Resource
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('ResourceDetail', array('url'=>array('controller'=>'Resources', 'action' => 'admin_manage/'.$id), 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
						<?php 
							echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=> $id)); 
							echo $this->Form->input('folder_name',array("type"=>"hidden","label"=>false,"value"=> $data['Resource']['folder_name'])); 
						?>
						<div class="form-group">
							<label class="col-md-3 control-label">Name <span class="required">
							* </span>
							</label>
							<div class="col-md-6">
								<div class="input-group col-md-6">
									<?php  
										echo $this->Form->input('name',array('class'=>"form-control", 'name'=>'data[ResourceDetail][name]', 'type'=>'text', ));
									?>  
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Select File <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('file_name',array('class'=>"form-control", 'name'=>'data[ResourceDetail][file_name][]', 'type'=>'file'));
									?>  
								</div>
							</div>
						</div>
						
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
							<?php echo $this->Form->submit('Submit', array('type' => 'submit', 'class'=>"btn blue",'div'=>false));?>
							<?php echo $this->Form->button('Cancel', array('type' => 'reset', 'class'=>"btn default",'div'=>false, 'onclick'=>'window.history.back()'));?>
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
					<i class="fa fa-gift"></i>All Resources
				</div>
			</div>
			<div class="portlet-body form">
			<?php if(!empty($data['ResourceDetail'])){ ?>
				<div class="row">
				<?php foreach($data['ResourceDetail'] as $resource){ ?>
					<div class="col-md-2" style="margin:10px 0;">
						<?php 
						$exten=explode('.',$resource['file_name']);
						$extension =end($exten);
						$extensionlow =strtolower($extension);
						
						
					if(file_exists(WWW_ROOT.'resources/'.$data['Resource']['folder_name'].'/'.$resource['file_name'])) {
							if($extensionlow=='pdf'){
								echo $this->Html->link($this->Html->image(SITE_URL.'resources/pdfimage.png', array('alt'=>'Resource', 'class'=>'img-responsive imagesizebug')),SITE_URL.'resources/'.$data['Resource']['folder_name'].'/'.$resource['file_name'], array('escape'=>false, 'target'=>'_blank', 'full_base'=>true,'style'=>'display: block; text-align: center;width: 100%;'));
							}
						 
			 if($extensionlow=='xls' || $extensionlow=='csv' || $extensionlow=='xlsx' || $extensionlow=='xlsm' || $extensionlow=='xlsb'){
						echo $this->Html->link($this->Html->image(SITE_URL.'resources/Excel_File.png', array('alt'=>'Resource', 'class'=>'img-responsive imagesizebug')),SITE_URL.'resources/'.$data['Resource']['folder_name'].'/'.$resource['file_name'], array('escape'=>false, 'target'=>'_blank', 'full_base'=>true,'style'=>'display: block; text-align: center;width: 100%;'));
						}
						 if($extensionlow=='doc' || $extensionlow=='docx'){
						echo $this->Html->link($this->Html->image(SITE_URL.'resources/word_document.png', array('alt'=>'Resource', 'class'=>'img-responsive imagesizebug')),SITE_URL.'resources/'.$data['Resource']['folder_name'].'/'.$resource['file_name'], array('escape'=>false, 'target'=>'_blank', 'full_base'=>true,'style'=>'display: block; text-align: center;width: 100%;'));
						}
						
						
						
					
						if($extensionlow=='png' || $extensionlow=='jpg' || $extensionlow=='jpeg' || $extensionlow=='gif' || $extensionlow=='bmp'){
						echo $this->Html->link($this->Html->image(SITE_URL.'resources/'.$data['Resource']['folder_name'].'/'.$resource['file_name'], array('alt'=>'Resource', 'class'=>'img-responsive imagesizebug')),SITE_URL.'resources/'.$data['Resource']['folder_name'].'/'.$resource['file_name'], array('escape'=>false, 'target'=>'_blank', 'full_base'=>true,'style'=>'display: block; text-align: center;width: 100%;'));
						}
					
					 if($extensionlow=='ppt' || $extensionlow=='pptx' || $extensionlow=='PPTX'){
						echo $this->Html->link($this->Html->image(SITE_URL.'resources/ppt.png', array('alt'=>'Resource', 'class'=>'img-responsive imagesizebug')),SITE_URL.'resources/'.$data['Resource']['folder_name'].'/'.$resource['file_name'], array('escape'=>false, 'target'=>'_blank', 'full_base'=>true,'style'=>'display: block; text-align: center;width: 100%;'));
						}
					}else {
					echo $this->Html->image(SITE_URL.'filenot.png', array('alt'=>'Resource', 'class'=>'img-responsive imagesizebug'));
				
					
					}
						?>
						<div class="col-md-12" style="margin:5px 0;">
							<h4><?php echo $resource['name']; ?></h4>
						</div>
						<?php //echo $this->Form->create('ResourceDetail', array('url'=>array('controller'=>'Resources', 'action' => 'admin_manage/'.$id), 'inputDefaults' => array('required' => false, 'label' => false,'div' => false)));?>
						
						<!--<div class="col-md-6" style="margin:5px 0;">
							<?php //echo $this->Form->input('name',array('value'=>$resource['name'],  'data-required'=>1, 'class'=>"form-control", 'type'=>"text")); ?>	
						</div>
						<div class="col-md-6" style="margin:5px 0;">
							<?php //echo $this->Form->button('<i class="fa fa-edit"></i>', array('type' => 'submit','class'=>'btn blue')); ?>
						</div>-->
						
						<?php //echo $this->Form->end(); ?>
						<div class="col-md-6" style="margin:5px 0;">
							<?php echo $this->Html->link('<i class="fa fa-copy"></i> COPY', 'javascript:void(0);',array('onclick'=>'CopyToClipboard(\''.SITE_URL.'resources/'.$data['Resource']['folder_name'].'/'.$resource['file_name'].'\');', 'escape'=>false, 'class'=>'btn btn-xs blue')); ?>
						</div>
						<div class="col-md-6" style="margin:5px 0;">
							<?php echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', array('controller'=>'Resources', 'action'=>'admin_resourcedelete/'.$data['Resource']['folder_name'].'/'.$resource['id'].'/'.$id),array('confirm'=>'Do you really eant to delete?', 'escape'=>false, 'full_base'=>true, 'class'=>'btn btn-xs red deletebug')); ?>
						</div>
						<div class="col-md-6" style="margin:5px 0;">
								<a data-toggle="modal" href="#responsive" rel="<?php echo $resource['id']; ?>" class="btn default btn-xs purple add"><i class="fa fa-edit"></i>Edit Image Name</a>
						</div>
					</div>
				<?php } ?>
				</div>
			<?php } else { ?>
				<div class="row">
					<div class="col-md-12">
						<div class="note note-info"> <center>No Resource available now</center></div>
					</div>
				</div>
			<?php } ?>
			</div>
		</div>
	</div>
</div>
	
<div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true">
	
</div>					
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
			'data[ResourceDetail][file_name][]': {
				required: true
			},
			'data[ResourceDetail][name]': {
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
	
$('.add').click(function(e){
		e.preventDefault();
		var box_id = $("#box_id").val();
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
			url:'<?php echo $this->Html->url(array('controller'=>'Resources','action'=>'admin_imageupdatename/','full_base'=>true)); ?>',
			data:{id:id,},
			success:function(result){
				//alert()
				$('#responsive').html(result);
			}
		});
	});	
	
});

function CopyToClipboard(text) {
	window.prompt("Copy to clipboard: Ctrl+C, Enter", text);
}


</script>