<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$layoutArr = array('FULL_WIDTH'=>'Full Width','LEFT_BAR_2_COLS'=>'Left Bar(2 Cols)','RIGHT_BAR_2_COLS'=>'Right Bar(2 Cols)','LEFT_RIGHT_BAR_3_COLS'=>'Left/Right Bar(3 Cols)');
	if(isset($data['Page']) && $data['Page']['slug']=='home')
	{
		$page_style = array('home shop'=>'Home Shop','home blog'=>'Home Blog','home corporate : v1'=>'Home Corporate Version 1','home corporate : v2'=>'Home Corporate Version 2','home corporate : v3'=>'Home Corporate Version 3','home corporate : v5'=>'Home Corporate Version 4','home corporate : v6'=>'Home Corporate Version 5');
	}
	else
	{
		$page_style = array('About Us'=>'About Us','Contact Page 1'=>'Contact Page 1','Contact Page 2'=>'Contact Page 2','Page: Sidebar - L'=>'Page: Sidebar - L','Page: Sidebar - R'=>'Page: Sidebar - R','F.A.Q.'=>'F.A.Q.','Product Launch'=>'Product Launch','Services'=>'Services','404'=>'404 Page','Typography'=>'Typography','Login'=>'Login','Forum'=>'Forum');
	}

	$VerArray = array();	
	if(isset($data['PageVersion']))
	{
		foreach($data['PageVersion'] as $pageVersions)
		{
			array_push($VerArray,$pageVersions['date']);
		}
	}
$userArr = AuthComponent::user();
$currentModelPer = $this->Session->read('currentModelPer');
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
				<?php echo $this->Form->create('Page', array('action' => 'admin_manage/'.$id, 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
					<div class="form-body">
						<?php echo $this->Form->input('id',array("id"=>"id","type"=>"hidden","label"=>false,"value"=> $id)); ?>
						<?php echo $this->Form->input('def',array("id"=>"def","type"=>"hidden","label"=>false,"value"=>'')); ?>
						<?php
						if(!empty($id) && $data['Page']['save']==1){
						
						echo "<div class='alert alert-danger' align='center' id='flashMessage'>Please first save the page to see the effect of the cloned/edit widgets in the front end.</div>";
						
						
						}
						?>
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
						
						<h3 class="form-section">Page Details</h3>
						
						<?php if(isset($id)){ ?>
						<div class="form-group">
							<label class="control-label col-md-3">Page Slug <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('slug',array('value'=>(isset($data['Page']))?$data['Page']['slug']:'', 'id'=>"slug", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Page Slug", 'type'=>"text",'readonly'=>'readonly')); ?>
								<?php echo $this->Form->input('set_slug',array('value'=>(isset($data['Page']))?$data['Page']['slug']:'', 'type'=>"hidden")); ?>
							</div>
						</div>
						<?php } ?>
						
						<?php if(!empty($id)){ ?>
						<div class="form-group">
							<label class="control-label col-md-3">Page URL <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('page_url',array('value'=>(isset($data['Page']))?$data['Page']['page_url']:'', 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Page URL", 'type'=>"text",'readonly'=>'readonly')); ?>
							</div>
						</div>
						<?php } ?>
						
						<div class="form-group">
							<label class="control-label col-md-3"> Title <span class="required">
							* </span>
							</label>
							<div class="col-md-4">
								<?php echo $this->Form->input('title',array('value'=>(isset($data['Page']))?$data['Page']['title']:'', 'id'=>"title", 'data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Page Title", 'type'=>"text")); ?>
								<span id="title-err"></span>
							</div>
						</div>
						<?php if(isset($data['Page']['type']) && $data['Page']['type']=='Page'){ ?>
						<div class="form-group">
							<label class="control-label col-md-3">Summary 
							</label>
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
						<?php } ?>

						<?php 
							if($pagecount==1 && isset($id)){?>
							<input id="new_template_id" type="hidden" value="1" />
						<?php 
							}else{?>
							<input id="new_template_id" type="hidden" value="0" />
						<?php
							} 
						?>
						
							

						<div class="form-group" id="pgtplDrpDown">
						
							<?php
							if($userArr['user_type']=='super'){
							?>
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
																'data-templateFor'=>"I",
																'data-changeUrl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true)),
																'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)),
																'selected'=> (isset($data['Page']))?$data['Page']['template_id']:''
															));
									?>  
								</div>
							</div>
							<?php 
							} else { 
								if(!empty($id)){
									echo $this->Form->input('template_id', array('type'=>'hidden', 'value'=>(!empty($data))?$data['Page']['template_id']:''));
								} else {
							?>
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
																	'data-templateFor'=>"I",
																	'data-changeUrl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true)),
																	'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)),
																	'selected'=> (isset($data['Page']))?$data['Page']['template_id']:''
																));
										?>  
									</div>
								</div>
							<?php 
								}
							} 
							?>
						</div>
						
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
													if($pageTemplate['PageTemplate']['with_sidebar']=='N'){
														if($currentModelPer['edit']=='Y'){
															echo $this->Html->link('<i class="fa fa-plus"></i>', 'javascript:void(0);', array(
																	'escape'=>false, 
																	'class'=>'btn btn-xs blue addCustomCol', 
																	'data-rowid'=>$item['PageTemplateRow']['id'], 
																	'data-templateid'=>$item['PageTemplateRow']['template_id'],
																	'data-templateFor'=>"I",
																	'data-parentcolid'=>0,
																	'data-pageid'=>$data['Page']['id'],
																	'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_fpaddcol', 'full_base'=>true)), 
																	'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)), 
																	'title'=>'Add Another Column',
																	'data-ajaxtplpreview'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true)),
																	'data-ajaxtpldrpdwnurl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_pgtpldrpdown', 'full_base'=>true)),
																	'data-tmpsubmiturl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_saveastplsubmit', 'full_base'=>true)),
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
																	'title'=>'Edit Row',
																	'data-ajaxtplpreview'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true)),
																	'data-ajaxtpldrpdwnurl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_pgtpldrpdown', 'full_base'=>true)),
																	'data-tmpsubmiturl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_saveastplsubmit', 'full_base'=>true)),
																)
															);
														}
														echo "&nbsp;&nbsp;&nbsp;";
														if($currentModelPer['edit']=='Y'){
															echo $this->Html->link('<i class="fa fa-times"></i>', 'javascript:void(0);'
															, array(
																	'escape'=>false, 
																	'class'=>'btn btn-xs red delCustomRow', 
																	'data-rowid'=>$item['PageTemplateRow']['id'],
																	'data-templateid'=>$item['PageTemplateRow']['template_id'],
																	'data-templateFor'=>"I",
																	'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_fpdelrow', 'full_base'=>true)), 
																	'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)), 
																	'data-ajaxtplpreview'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true)), 
																	'title'=>'Delete Entire Row',
																	'data-ajaxtpldrpdwnurl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_pgtpldrpdown', 'full_base'=>true)),
																	'data-tmpsubmiturl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_saveastplsubmit', 'full_base'=>true)),
																)
															);
														}
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
																	if($pageTemplate['PageTemplate']['with_sidebar']=='N'){
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
																			'data-templateFor'=>"I",
																			'data-pageid'=>$data['Page']['id'],
																			'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_fpaddcol', 'full_base'=>true)),
																			'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)), 
																			'data-ajaxtplpreview'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true)),
																			'data-ajaxtpldrpdwnurl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_pgtpldrpdown', 'full_base'=>true)),
																			'data-tmpsubmiturl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_saveastplsubmit', 'full_base'=>true)),
																			'data-tmpsidebar'=>$pageTemplate['PageTemplate']['with_sidebar']
																		)
																	);
																	}
																	echo "&nbsp;";
																	if($currentModelPer['edit']=='Y'){
																	echo $this->Html->link('<i class="fa fa-times"></i>', 'javascript:void(0);',
																		array(
																			'escape'=>false,
																			'title'=>'Delete Column',
																			'class'=>'dltCustomCol',
																			'data-colid'=>$column['id'],
																			'data-templateid'=>$item['PageTemplateRow']['template_id'],
																			'data-templateFor'=>"I",
																			'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_fpcoldelete', 'full_base'=>true)),
																			'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)), 
																			'data-ajaxtplpreview'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true)),
																			'data-ajaxtpldrpdwnurl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_pgtpldrpdown', 'full_base'=>true)),
																			'data-tmpsubmiturl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_saveastplsubmit', 'full_base'=>true)),
																			'data-tmpsidebar'=>$pageTemplate['PageTemplate']['with_sidebar']
																		)	
																	);
																	}
																	} else {
																		if($column['column']==3){
																			if($currentModelPer['edit']=='Y'){
																			echo $this->Html->link(
																				'<i class="fa fa-edit"></i>',
																				'javascript:void(0);',
																				array(
																					'escape'=>false,
																					'title'=>'Edit Column',
																					'class'=>'editSidebarCustomCol',
																					'data-rowid'=>$item['PageTemplateRow']['id'],
																					'data-colid'=>$column['id'],
																					'data-parentcolid'=>$column['parent_colid'],
																					'data-templateid'=>$item['PageTemplateRow']['template_id'],
																					'data-templateFor'=>"I",
																					'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_fpsidebaraddcol', 'full_base'=>true)),
																					'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)), 
																					'data-ajaxtplpreview'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true)),
																					'data-ajaxtpldrpdwnurl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_pgtpldrpdown', 'full_base'=>true)),
																					'data-tmpsubmiturl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_saveastplsubmit', 'full_base'=>true)),
																					'data-tmpsidebar'=>$pageTemplate['PageTemplate']['with_sidebar']
																				)
																			);
																			}
																		}
																	}
																	?>
																</div>
																
															</center>
														</div>
														<div class="panel-body">
															<?php
															if($column['multiple_col']=='F'){
															?>
															<!--<center>
																<div class="col-md-8">
																<?php 
																	echo $this->Template->shortcode($column['shortcode']); 
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
															<?php } else {
																$childColArr = $this->Template->generateChildColArr($column['id']);
																if(!empty($childColArr)){
																	?>
																	<div class="row">
																	<?php
																	foreach($childColArr as $childCol){
																		?>
																		
																		<div class="col-md-<?php echo $childCol['PageTemplateRowsColumn']['column'] ?>">
																			<div class="panel panel-info">
																				<div class="panel-heading">
																					<center>
																					<div class="pull-left">
																					col-size-<?php echo $childCol['PageTemplateRowsColumn']['column']; ?>
																					</div>
																					<?php echo $childCol['PageTemplateRowsColumn']['name']; ?>
																					<div class="pull-right">
																					<?php
																					if($currentModelPer['edit']=='Y'){
																					echo $this->Html->link('<i class="fa fa-edit"></i>', 'javascript:void(0);',
																						array(
																							'escape'=>false,
																							'title'=>'Edit Column',
																							'class'=>'editCustomCol',
																							'data-rowid'=>$item['PageTemplateRow']['id'],
																							'data-colid'=>$childCol['PageTemplateRowsColumn']['id'],
																							'data-parentcolid'=>$childCol['PageTemplateRowsColumn']['parent_colid'],
																							'data-pageid'=>$data['Page']['id'],
																							'data-templateid'=>$item['PageTemplateRow']['template_id'],
																							'data-templateFor'=>"I",
																							'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_fpaddcol', 'full_base'=>true)),
																							'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)), 
																							'data-ajaxtplpreview'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true)),
																							'data-ajaxtpldrpdwnurl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_pgtpldrpdown', 'full_base'=>true)),
																							'data-tmpsubmiturl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_saveastplsubmit', 'full_base'=>true)),
																							'data-tmpsidebar'=>$pageTemplate['PageTemplate']['with_sidebar']
																						)
																					);
																					}
																					echo "&nbsp;";
																					if($currentModelPer['edit']=='Y'){
																					echo $this->Html->link('<i class="fa fa-times"></i>', 'javascript:void(0);',
																						array(
																							'escape'=>false,
																							'title'=>'Delete Column',
																							'class'=>'dltCustomCol',
																							'data-colid'=>$childCol['PageTemplateRowsColumn']['id'],
																							'data-templateid'=>$item['PageTemplateRow']['template_id'],
																							'data-templateFor'=>"I",
																							'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_fpcoldelete', 'full_base'=>true)),
																							'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)), 
																							'data-ajaxtplpreview'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true)),
																							'data-ajaxtpldrpdwnurl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_pgtpldrpdown', 'full_base'=>true)),
																							'data-tmpsubmiturl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_saveastplsubmit', 'full_base'=>true)),
																							'data-tmpsidebar'=>$pageTemplate['PageTemplate']['with_sidebar']
																						)	
																					);
																					}
																					?>
																					</div>
																					</center>
																				</div>
																				<div class="panel-body">
																					<?php
																					echo $this->Template->shortcode($childCol['PageTemplateRowsColumn']['shortcode'], $childCol['PageTemplateRowsColumn']['clone_flag'], $item['PageTemplateRow']['template_id'], $childCol['PageTemplateRowsColumn']['id']);
																					?>
																				<!--<center>
																					<div class="col-md-8">
																					<?php 
																						echo $this->Template->shortcode($childCol['PageTemplateRowsColumn']['shortcode']); ; 
																						$link = $this->Template->shortcodelink($childCol['PageTemplateRowsColumn']['shortcode']);
																					?>
																					</div>
																					<div class="col-md-2">
																					<a href="<?php echo $link; ?>" target="_blank">
																						<i style="font-size: 20px; vertical-align: middle;" class="fa fa-pencil-square"></i>
																					</a>
																					</div>
																					<div class="col-md-2">
																					<?php
																					if($childCol['PageTemplateRowsColumn']['clone_flag']=='N'){
																						echo $cloneLink = $this->Template->cloneLink($childCol['PageTemplateRowsColumn']['shortcode'], $item['PageTemplateRow']['template_id'], $childCol['PageTemplateRowsColumn']['id']);
																					}
																					//pr($widg);
																					?>
																					</div>
																				</center>-->
																				</div>
																			</div>
																		</div>
																	<?php } ?>
																	</div>
																	<?php
																}
							if($currentModelPer['edit']=='Y' && $currentModelPer['add']=='Y'){
																echo $this->Form->button('<i class="fa fa-plus"></i> Add New Child Column', 
																	array(
																		'escape'=>false,
																		'type' => 'button', 
																		'id'=>"addnewChildCol",
																		'class'=>"pull-right btn green",
																		'data-templateid'=>$item['PageTemplateRow']['template_id'],
																		'data-rowid'=>$item['PageTemplateRow']['id'], 
																		'data-colid'=>$column['id'],
																		'data-parentcolid'=>$column['id'],
																		'data-templateFor'=>"I",
																		'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_fpaddcol', 'full_base'=>true)), 
																		'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)), 
																		'title'=>'Add Another Column',
																		'data-ajaxtplpreview'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true)),
																		'data-ajaxtpldrpdwnurl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_pgtpldrpdown', 'full_base'=>true)),
																		'data-tmpsubmiturl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_saveastplsubmit', 'full_base'=>true)),
																		'data-tmpsidebar'=>$pageTemplate['PageTemplate']['with_sidebar'],
																		'data-temptype'=>$pageTemplate['PageTemplate']['template_type']
																	)
																);
																}
																} 
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
										if($pageTemplate['PageTemplate']['with_sidebar']=='N'){
										if($currentModelPer['edit']=='Y' && $currentModelPer['add']=='Y'){
											echo $this->Form->button('<i class="fa fa-plus"></i> Add New Row', 
												array(
													'escape'=>false,
													'type' => 'button', 
													'id'=>"addnewRow",
													'class'=>"pull-right btn green",
													'data-templateid'=>$data['Page']['template_id'],
													'data-templateFor'=>"I",
													'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_fpaddrow', 'full_base'=>true)),
													'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)), 
													'data-ajaxtplpreview'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true)),
													'data-ajaxtpldrpdwnurl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_pgtpldrpdown', 'full_base'=>true)),
													'data-tmpsubmiturl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_saveastplsubmit', 'full_base'=>true)),
													'data-temptype'=>$pageTemplate['PageTemplate']['template_type']
												)
											);
											}
										}
										?>
										</div>
										<div class="clearfix"></div>
									<?php } else if(!empty($data)) { ?>
									<div class="note note-info">
										<h4 class="block">Create your own template</h4>
										<div class="col-md-12">
										<?php
										if($currentModelPer['edit']=='Y' && $currentModelPer['add']=='Y'){
											echo $this->Form->button('<i class="fa fa-plus"></i> Add New Row', 
												array(
													'escape'=>false,
													'type' => 'button', 
													'id'=>"addnewRow",
													'class'=>"pull-right btn green",
													'data-templateid'=>$data['Page']['template_id'],
													'data-templateFor'=>"I",
													'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_fpaddrow', 'full_base'=>true)),
													'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)), 
													'data-ajaxtplpreview'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true)),
													'data-ajaxtpldrpdwnurl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_pgtpldrpdown', 'full_base'=>true)),
													'data-tmpsubmiturl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_saveastplsubmit', 'full_base'=>true)),
													'data-temptype'=>$pageTemplate['PageTemplate']['template_type']
												)
											);
										}
										?>
										</div>
										<div class="clearfix"></div>
									</div>
									<?php } else { ?>
									<div class="note note-info">
										<h4 class="block">Please select a template to generate a view</h4>
									</div>
									<?php  } ?>
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
																'selected'=>(isset($data['Page']))?$data['Page']['is_active']:''
															));
									?>  
								</div>
							</div>
						</div>
						
						
					</div>
					<?php if($currentModelPer['add']=='Y'  || $currentModelPer['edit']=='Y'){ ?>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9" id="saveBtnBox">
							<?php echo $this->Form->button('Save', array('type' => 'submit', 'name'=>'continue', 'value'=>'s', 'class'=>"btn blue"));?>
							<?php echo $this->Form->button('Save & Close', array('type' => 'submit', 'class'=>"btn blue"));?>
							<?php echo $this->Form->button('Cancel', array('type' => 'reset', 'class'=>"btn default",'onclick'=>'window.history.back()'));?>
						</div>
					</div>
					<?php } ?>
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
						//$("#change_count").val("0");
						toastr.success('Sidebar saved!', 'Success :',{closeButton:true});
					}
				}
			});
		}
		else{
			alert("There is no change in sidebar items");
		}
	});
	
	
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
			'data[Page][is_active]': {
				required: true
			},
			'data[Page][page_layout]': {
				required: true
			},
			'data[Page][show_to_client]': {
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

	Template.init();
});
</script>