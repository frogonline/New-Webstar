<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$currentModelPer=$this->Session->read('currentModelPer');
	
	$VerArray = array();	
	if(isset($data['PageVersion']))
	{
		foreach($data['PageVersion'] as $pageVersions)
		{
			array_push($VerArray,$pageVersions['date']);
		}
	}

$userArr = AuthComponent::user();
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i><?php echo (isset($id))?'Edit':'Add' ?> Page
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('Page', array('action' => 'admin_frontpage', 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
						<?php echo $this->Form->input('id',array("id"=>"id","type"=>"hidden","label"=>false,"value"=> $data['Page']['id'])); ?>
						
						<h3 class="form-section">Meta Data</h3>
						
						<div class="form-group">
							<label class="control-label col-md-3">Meta Title <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
									echo $this->Form->input('metatitle', array(
															'type' => "text",
															'placeholder'=>"Enter Page Meta Title",
															'value' => (isset($data['Page']))?$data['Page']['metatitle']:'', 
															'class' => "form-control"
														)); 
								?>
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="control-label col-md-3">Meta Keywords <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php 
									echo $this->Form->input('metakeywords', array(
															'type' => "text",
															'placeholder'=>"Enter Page Meta Keywords",
															'value' => (isset($data['Page']))?$data['Page']['metakeywords']:'', 
															'class' => "form-control"
														)); 
								?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Meta Description <span class="required">
							* </span>
							</label>
							<div class="col-md-6">
								<?php 
									echo $this->Form->input('metadescription', array(
															'type' => "textarea",
															'placeholder'=>"Enter Page Meta Description",
															'value' => (isset($data['Page']))?$data['Page']['metadescription']:'', 
															'class' => "form-control"
														)); 
								?>
							</div>
						</div>
						
						<h3 class="form-section">Page Details </h3>
						
						
						<div class="form-group">
							<label class="control-label col-md-3"> Title <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('title',array('value'=>(isset($data['Page']))?$data['Page']['title']:'', 'id'=>"title", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Page Title", 'type'=>"text")); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Summary </label>
							<div class="col-md-6">
								<?php 
									echo $this->Form->input('summery', array(
										'type' => "textarea",
										'id' => 'summery',
										'value' => (isset($data['Page']))?$data['Page']['summery']:'', 
										'class' => "form-control"
									)); 
								?>
								<div id="editor2_error"></div>
							</div>
						</div>
						
						<?php
						if($userArr['user_type']=='super'){
						?>
						<div class="form-group" id="pgtplDrpDown">
							<label class="col-md-3 control-label">Page Template </label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('template_id', array(
																'options' => $tplList,
																'onchange'=>'ChangeTemplate(this);',
																'empty' => 'Select Template',	
																'class' => 'form-control',
																'id'=>'templatedrpdwn',
																'data-templateFor'=>"H",
																'data-changeUrl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true)),
																'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)),
																'selected'=> (isset($data['Page']))?$data['Page']['template_id']:''
															));
									?>  
								</div>
							</div>
						</div>
						<?php
						} else {
						?>
							<div id="pgtplDrpDown">
							<?php echo $this->Form->input('template_id', array('type'=>'hidden', 'value'=>(!empty($data))?$data['Page']['template_id']:'')); ?>
							</div>
						<?php
						} 
						?>
						
						<h3 class="form-section">Page Preview </h3>
						<div class="form-group">
							
							<div class="col-md-12">
								<div class="well well-lg" id="waitingDiv" style="display:none;">
									<center><img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" /> Please wait template is generating.</center>
								</div>
								<div class="note note-warning" id="tplPreview">
									<?php
									if(!empty($tplrwclArr)){
										//echo $tplpreviewData['PageTemplate']['admin_preview'];
										foreach($tplrwclArr as $item){
											$colCount = $this->Template->getTotalCol($item['PageTemplateRowsColumn']);
											
									?>
										<div class="note <?php echo ($colCount > 12)?'note-danger':'note-success'; ?>" id="row-<?php echo $item['PageTemplateRow']['id']; ?>">
											
											<div class="col-md-12" style="padding:0 0 5px 0;">
												<div class="pull-right">
													<?php
													if($currentModelPer['add']=='Y'){
													echo $this->Html->link('<i class="fa fa-plus"></i>', 'javascript:void(0);', array(
															'escape'=>false, 
															'class'=>'btn btn-xs blue addCustomCol', 
															'data-rowid'=>$item['PageTemplateRow']['id'], 
															'data-templateid'=>$item['PageTemplateRow']['template_id'],
															'data-templateFor'=>"H",
															'data-parentcolid'=>0,
															'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_fpaddcol', 'full_base'=>true)), 
															'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)), 
															'title'=>'Add Another Column'
														)
													);
													}
													
													
													echo "&nbsp;&nbsp;&nbsp;";
													if($currentModelPer['edit']=='Y'){
													echo $this->Html->link('<i class="fa fa-pencil"></i>', 'javascript:void(0);', array(
															'escape'=>false, 
															'class'=>'btn btn-xs blue editCustomRow', 
															'data-rowid'=>$item['PageTemplateRow']['id'], 
															'data-templateid'=>$item['PageTemplateRow']['template_id'],
															'data-templateFor'=>"I",
															'data-parentcolid'=>0,
															'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_fpaddrow', 'full_base'=>true)), 
															'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)), 
															'title'=>'Edit Row'
														)
													);
													}
																						
													echo "&nbsp;&nbsp;&nbsp;";
													if($currentModelPer['delete']=='Y'){
													echo $this->Html->link('<i class="fa fa-times"></i>', 'javascript:void(0);'
													, array(
															'escape'=>false, 
															'class'=>'btn btn-xs red delCustomRow', 
															'data-rowid'=>$item['PageTemplateRow']['id'],
															'data-templateid'=>$item['PageTemplateRow']['template_id'],
															'data-templateFor'=>"H",
															'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_fpdelrow', 'full_base'=>true)), 
															'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)), 
															'data-ajaxtplpreview'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true)), 
															'title'=>'Delete Entire Row'
														)
													);
													}
													?>
												</div>
											</div>
											
											<div class="container-fluid">
											<?php foreach($item['PageTemplateRowsColumn'] as $column){ ?>
												<div class="col-md-<?php echo $column['column']; ?>" id="column-<?php echo $column['id']; ?>">
													<div class="panel panel-info">
														<div class="panel-heading">
															<center>
																
																<div class="pull-left">
																	col-size-<?php echo $column['column']; ?>
																</div>
																<?php echo $column['name']; ?>
																<div class="pull-right">
																	<?php
																	if($currentModelPer['edit']=='Y'){
																	echo $this->Html->link('<i class="fa fa-edit"></i>', 'javascript:void(0);',
																		array(
																			'escape'=>false,
																			'title'=>'Edit Column',
																			'class'=>'editCustomCol',
																			'data-rowid'=>$item['PageTemplateRow']['id'],
																			'data-colid'=>$column['id'],
																			'data-parentcolid'=>$column['parent_colid'],
																			'data-templateid'=>$item['PageTemplateRow']['template_id'],
																			'data-templateFor'=>"H",
																			'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_fpaddcol', 'full_base'=>true)),
																			'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)), 
																			'data-ajaxtplpreview'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true))
																		)
																	);
																	}
																	echo "&nbsp;";
																	if($currentModelPer['delete']=='Y'){
																	echo $this->Html->link('<i class="fa fa-times"></i>', 'javascript:void(0);',
																		array(
																			'escape'=>false,
																			'title'=>'Delete Column',
																			'class'=>'dltCustomCol',
																			'data-colid'=>$column['id'],
																			'data-templateid'=>$item['PageTemplateRow']['template_id'],
																			'data-templateFor'=>"H",
																			'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_fpcoldelete', 'full_base'=>true)),
																			'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)), 
																			'data-ajaxtplpreview'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true))
																		)	
																	);
																	}
																	?>
																</div>
																
															</center>
														</div>
														<div class="panel-body">
															<!--<center>
																<div class="col-md-8">
																<?php 
																	echo $column['shortcode']; 
																	$link = $this->Template->shortcodelink($column['shortcode']);
																?>
																</div><div class="col-md-2">
																<a href="<?php echo $link; ?>" target="_blank">
																	<i style="font-size: 20px; vertical-align: middle;" class="fa fa-pencil-square"></i>
																</a>
																</div><div class="col-md-2">
																<?php
																if($column['clone_flag']=='N'){
																	echo $cloneLink = $this->Template->cloneLink($column['shortcode'], $item['PageTemplateRow']['template_id'], $column['id']);
																}
																//pr($widg);
																?>
																</div>
															</center>-->
															<?php
															echo $this->Template->shortcode($column['shortcode'], $column['clone_flag'], $item['PageTemplateRow']['template_id'], $column['id']);
															?>
														</div>
													</div>
												</div>
											<?php } ?>
											</div>
											
										</div>
									<?php } ?>
										<div class="col-md-12">
										<?php
										if($currentModelPer['add']=='Y'){
											echo $this->Form->button('<i class="fa fa-plus"></i> Add New Row', 
												array(
													'escape'=>false,
													'type' => 'button', 
													'id'=>"addnewRow",
													'class'=>"pull-right btn green",
													'data-templateid'=>$data['Page']['template_id'],
													'data-templateFor'=>"H",
													'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_fpaddrow', 'full_base'=>true)),
													'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)), 
													'data-ajaxtplpreview'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true))
												)
											);
										}
										?>
										</div>
										<div class="clearfix"></div>
									<?php } else { ?>
									<div class="note note-info">
										<h4 class="block">Create your own template</h4>
										<div class="col-md-12">
										<?php
										if($currentModelPer['add']=='Y'){
											echo $this->Form->button('<i class="fa fa-plus"></i> Add New Row', 
												array(
													'escape'=>false,
													'type' => 'button', 
													'id'=>"addnewRow",
													'class'=>"pull-right btn green",
													'data-templateid'=>$data['Page']['template_id'],
													'data-templateFor'=>"H",
													'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_fpaddrow', 'full_base'=>true)),
													'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)), 
													'data-ajaxtplpreview'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true))
												)
											);
										}
										?>
										</div>
										<div class="clearfix"></div>
									</div>
									<?php } ?>
								</div>
							</div>
						</div>
												                        
                        <div class="form-group">
							<label class="col-md-3 control-label">Select Status <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<div class="input-group">
									<?php  
										echo $this->Form->input('is_active', array(
																'options' => $statusArr,
																'empty' => 'Select Status',	
																'class' => 'form-control',
																'selected'=> (isset($data['Page']))?$data['Page']['is_active']:''
															));
									?>  
								</div>
							</div>
						</div>
						
						<?php //echo $this->Form->input('admin_preview',array('id'=>"admin_preview", 'type'=>"hidden")); ?>
						
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
							<?php echo $this->Form->button('Save', array('type' => 'submit', 'name'=>'continue', 'value'=>'s', 'class'=>"btn blue submit"));?>
							<?php echo $this->Form->button('Cancel', array('type' => 'reset', 'class'=>"btn default",'onclick'=>'window.history.back()'));?>
						</div>
					</div>
				<?php echo $this->Form->end(); ?>
				<!-- END FORM-->
			</div>
			<!-- END VALIDATION STATES-->
		</div>
	</div>
</div>
<div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true"></div>
<div id="responsive1" class="modal fade" tabindex="-1" aria-hidden="true" ></div>
<script type="text/javascript">
$(function(){
	var form3 = $('#form_sample_3');
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
			'data[Page][title]': {
				required: true
			},
			'data[Page][content]': {
				required: true
			},
			'data[Page][metatitle]': {
				required: true
			}, 
			'data[Page][metakeywords]': {
				required: true
			},
			'data[Page][metadescription]': {
				required: true
			},
			'data[Page][template_id]': {
				required: true
			},
			'data[Page][is_active]': {
				required: true
			},
			'data[Page][page_layout]': {
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


$(document).ready(function() {
	Template.init();
});
</script>
<div id="content"></div>