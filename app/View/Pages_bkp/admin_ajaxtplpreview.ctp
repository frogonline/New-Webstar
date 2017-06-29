<?php
$currentModelPer = $this->Session->read('currentModelPer');
$userArr = AuthComponent::user();
if(!empty($tplrwclArr)){
	foreach($tplrwclArr as $item){
		$colCount = $this->Template->getTotalCol($item['PageTemplateRowsColumn']);
?>
	<div class="note <?php echo ($colCount > 12)?'note-danger':'note-success'; ?>" id="row-<?php echo $item['PageTemplateRow']['id']; ?>">
		
		<div class="col-md-12" style="padding:0 0 5px 0;">
			<div class="pull-right">
				<?php
				if($pageTemplate['PageTemplate']['with_sidebar']=='N'){
					if($currentModelPer['edit']=='Y' && $def==''){
					echo $this->Html->link('<i class="fa fa-plus"></i>', 'javascript:void(0);', array(
							'escape'=>false, 
							'class'=>'btn btn-xs blue addCustomCol', 
							'data-rowid'=>$item['PageTemplateRow']['id'], 
							'data-templateid'=>$item['PageTemplateRow']['template_id'],
							'data-templateFor'=>$tplData['PageTemplate']['template_for'],
							'data-parentcolid'=>0,
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
					if($currentModelPer['edit']=='Y' && $def==''){
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
					if($currentModelPer['edit']=='Y' && $def==''){
					echo $this->Html->link('<i class="fa fa-times"></i>', 'javascript:void(0);'
					, array(
							'escape'=>false, 
							'class'=>'btn btn-xs red delCustomRow', 
							'data-rowid'=>$item['PageTemplateRow']['id'],
							'data-templateid'=>$item['PageTemplateRow']['template_id'],
							'data-templateFor'=>$tplData['PageTemplate']['template_for'],
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
												'data-templateFor'=>$tplData['PageTemplate']['template_for'],
												'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_fpaddcol', 'full_base'=>true)),
												'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)), 
												'data-ajaxtplpreview'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true)),
												'data-ajaxtpldrpdwnurl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_pgtpldrpdown', 'full_base'=>true)),
												'data-tmpsubmiturl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_saveastplsubmit', 'full_base'=>true)),
												'data-tmpsidebar'=>$tplData['PageTemplate']['with_sidebar'] 
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
												'data-templateFor'=>$tplData['PageTemplate']['template_for'],
												'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_fpcoldelete', 'full_base'=>true)),
												'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)), 
												'data-ajaxtplpreview'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true)),
												'data-ajaxtpldrpdwnurl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_pgtpldrpdown', 'full_base'=>true)),
												'data-tmpsubmiturl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_saveastplsubmit', 'full_base'=>true)),
												'data-tmpsidebar'=>$tplData['PageTemplate']['with_sidebar'] 
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
													'data-tmpsidebar'=>$tplData['PageTemplate']['with_sidebar']
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
							echo $this->Template->shortcode($column['shortcode'], $column['clone_flag'], $item['PageTemplateRow']['template_id'], $column['id']);
						?>
						<!--<center>
							<div class="col-md-8">
							<?php 
								echo $column['shortcode']; 
								$link = $this->Template->shortcodelink($column['shortcode']);
							?>
							</div><div class="col-md-2">
							<?php
							if($userArr['user_type']=='super'){
							?>
							<a href="<?php echo $link; ?>" target="_blank">
								<i style="font-size: 20px; vertical-align: middle;" class="fa fa-pencil-square"></i>
							</a>
							<?php } ?>
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
						} else {
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
														'data-templateid'=>$item['PageTemplateRow']['template_id'],
														'data-templateFor'=>"I",
														'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_fpaddcol', 'full_base'=>true)),
														'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)), 
														'data-ajaxtplpreview'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true)),
														'data-ajaxtpldrpdwnurl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_pgtpldrpdown', 'full_base'=>true)),
														'data-tmpsubmiturl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_saveastplsubmit', 'full_base'=>true)),
														'data-tmpsidebar'=>$tplData['PageTemplate']['with_sidebar'] 
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
														'data-tmpsidebar'=>$tplData['PageTemplate']['with_sidebar'] 
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
													echo $childCol['PageTemplateRowsColumn']['shortcode']; 
													$link = $this->Template->shortcodelink($childCol['PageTemplateRowsColumn']['shortcode']);
												?>
												</div><div class="col-md-2">
												<?php
												if($userArr['user_type']=='super'){
												?>
												<a href="<?php echo $link; ?>" target="_blank">
													<i style="font-size: 20px; vertical-align: middle;" class="fa fa-pencil-square"></i>
												</a>
												<?php } ?>
												</div><div class="col-md-2">
												<?php
												if($childCol['PageTemplateRowsColumn']['clone_flag']=='N'){
													echo $cloneLink = $this->Template->cloneLink($childCol['PageTemplateRowsColumn']['shortcode'], $item['PageTemplateRow']['template_id'], $childCol['PageTemplateRowsColumn']['id']);
												}
												//pr($widg);
												?>
												</div>
											</center>-->
											<?php
											echo $this->Template->shortcode($childCol['PageTemplateRowsColumn']['shortcode'], $childCol['PageTemplateRowsColumn']['clone_flag'], $item['PageTemplateRow']['template_id'], $childCol['PageTemplateRowsColumn']['id']);
											?>
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
									'data-tmpsidebar'=>$tplData['PageTemplate']['with_sidebar'],
									'data-temptype'=>$tplData['PageTemplate']['template_type']
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
	if($currentModelPer['edit']=='Y' && $currentModelPer['add']=='Y' && $def==''){
		echo $this->Form->button('<i class="fa fa-plus"></i> Add New Row', 
			array(
				'escape'=>false,
				'type' => 'button', 
				'id'=>"addnewRow",
				'class'=>"pull-right btn green",
				'data-templateid'=>$id,
				'data-templateFor'=>$tplData['PageTemplate']['template_for'],
				'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_fpaddrow', 'full_base'=>true)),
				'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)), 
				'data-ajaxtplpreview'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true)),
				'data-ajaxtpldrpdwnurl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_pgtpldrpdown', 'full_base'=>true)),
				'data-tmpsubmiturl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_saveastplsubmit', 'full_base'=>true)),
				'data-temptype'=>$tplData['PageTemplate']['template_type']
			)
		);
	}
	}
?>
</div>
<div class="col-md-offset-5 col-md-7">
<?php
/* if(($userArr['user_type']=='admin')){
	echo $this->Form->button('Proceed', 
		array(
				'type' => 'button', 
				'class'=>"btn purple", 
				"id"=>"addClientcustomtplbtn", 
				'data-tplid'=>$id,
				'data-templateFor'=>'I',
				'data-changeUrl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true)),
				'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_confirmproceed', 'full_base'=>true)),
			)
		);
} */
?>
</div>
<div class="clearfix"></div>
<?php } else { ?>
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
				'data-templateid'=>$id,
				'data-templateFor'=>$tplData['PageTemplate']['template_for'],
				'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_fpaddrow', 'full_base'=>true)),
				'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true)), 
				'data-ajaxtplpreview'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true)),
				'data-ajaxtpldrpdwnurl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_pgtpldrpdown', 'full_base'=>true)),
				'data-tmpsubmiturl'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_saveastplsubmit', 'full_base'=>true)),
				'data-temptype'=>$tplData['PageTemplate']['template_type']
			)
		);
	}
	?>
	</div>
	<div class="clearfix"></div>
</div>
<?php } ?>
<script type="text/javascript">
$(document).ready(function() {

	Template.init();
	
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
});
</script>