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
							'data-rowId'=>$column['row_id'],
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
echo $this->Form->button('Add New Column', array(
		'class'=>'btn btn-primary pull-right',
		'id'=>'footerAddcol',
		'data-tplId'=>$footerBlocks['FooterRow']['id'],
		'data-url'=>$this->Html->url(array('controller'=>'FooterRows', 'action'=>'admin_managecolumn', 'full_base'=>true))
	)
);
?>
</div>
<div class="clearfix"></div>
<script type="text/javascript">
$(function(){
	Template.init();
});
</script>