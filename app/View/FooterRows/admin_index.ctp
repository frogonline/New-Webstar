<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i>Manage Footer
				</div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<div class="form-horizontal">
					<div class="form-body">
						<h3 class="form-section">Footer Preview</h3>
						<div class="form-group">
							<div class="col-md-12">
								<div class="note note-warning" id="tplPreview">
									<?php
									if(!empty($footerBlocks['FooterColumn'])){
									$colCount = $this->Template->getTotalCol($footerBlocks['FooterColumn']);
									?>
									<div class="note <?php echo ($colCount > 12)?'note-danger':'note-success'; ?>">
										<div class="container-fluid">
										<?php
										foreach($footerBlocks['FooterColumn'] as $column){
									?>
										<div class="col-md-<?php echo $column['column']; ?>" id="column-<?php echo $column['id']; ?>">
											<div class="panel panel-info">
												<div class="panel-heading">
													<center>
														<?php echo $column['name']; ?>
														<div class="pull-right">
														<?php
														echo $this->Html->link('<i class="fa fa-edit"></i>', 'javascript:void(0);',
															array(
																'escape'=>false,
																'title'=>'Edit Column',
																'class'=>'coleditBtn',
																'data-tplId'=>$footerBlocks['FooterRow']['id'],
																'data-colId'=>$column['id'],
																'data-url'=>$this->Html->url(array('controller'=>'FooterRows', 'action'=>'admin_managecolumn', 'full_base'=>true))
															)
														);
														
														echo "&nbsp;";
														echo $this->Html->link('<i class="fa fa-times"></i>', 'javascript:void(0);',
															array(
																'escape'=>false,
																'title'=>'Delete Column',
																'class'=>'coldeleteBtn',
																'data-tplId'=>$footerBlocks['FooterRow']['id'],
																'data-colId'=>$column['id'],
																'data-url'=>$this->Html->url(array('controller'=>'FooterRows', 'action'=>'admin_deletecolumn', 'full_base'=>true)),
																'data-tplurl'=>$this->Html->url(array('controller'=>'FooterRows', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true))
															)	
														);
														?>
														</div>
													</center>
												</div>
												<div class="panel-body">
													<center>
														<?php
					echo $this->Template->shortcodefot($column['shortcode'], $column['clone_flag'], 1, $column['id']);
					?>
														<!--<a href="<?php echo $link; ?>" target="_blank">
															<i style="font-size: 20px; vertical-align: middle;" class="fa fa-pencil-square"></i>
														</a>-->
													</center>
												</div>
											</div>
										</div>
									<?php } ?>
										</div>
									</div>
									<?php } ?>
									<div class="col-md-12">
									<?php
									
									if(!empty($footerBlocks['FooterRow']['id']))
									{
										$selected=$footerBlocks['FooterRow']['id'];
									}else{
									
									$selected='';
									}
									echo $this->Form->button('<i class="fa fa-plus"></i> Add New Column', array(
											'class'=>'btn btn-primary pull-right',
											'id'=>'footerAddcol',
											'data-tplId'=>$selected,
											'data-url'=>$this->Html->url(array('controller'=>'FooterRows', 'action'=>'admin_managecolumn', 'full_base'=>true))
										)
									);
									?>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
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
	Template.init();
});
</script>