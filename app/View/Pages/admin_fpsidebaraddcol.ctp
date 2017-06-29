<?php
	//pr($reqdata);
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$column_size = array('1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'6', '7'=>'7', '8'=>'8', '9'=>'9', '10'=>'10', '11'=>'11', '12'=>'12');
	
	
	$shortcodeDrpDwn = array();
	if(!empty($shortcodeArr)){
		foreach($shortcodeArr as $item){
			if($item['Shortcode']['widget_id']!=0){
				$shortcodeDrpDwn["[".$item['Shortcode']['name']."-".$item['Shortcode']['widget_id']."]"] = "[".$item['Shortcode']['name']."-".$item['Shortcode']['widget_id']."]";
			} else {
				$shortcodeDrpDwn["[".$item['Shortcode']['name']."]"] = "[".$item['Shortcode']['name']."]";
			}
		}
	}
	//pr($tpldata);
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h2><?php echo (!empty($data))?"Edit":"Add New"; ?> Column</h2>
		</div>
			<!-- BEGIN FORM-->
			<?php echo $this->Form->create('PageTemplateRowsColumn', array('id'=>"addColumnsForm", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<div class="modal-body">
			<div class="scroller" data-always-visible="1" data-rail-visible1="1">
				<div class="row">
					<?php 
						echo $this->Form->input('row_id',array("type"=>"hidden", "value"=>$reqdata['rowId']));
						echo $this->Form->input('tmplt_id',array("type"=>"hidden", 'id'=>'tmplt_id', "value"=>$reqdata['tplId']));
					?>
					<div class="col-md-12">
						<h4>Column Name<span class="required"> * </span></h4>
						<?php echo $this->Form->input('name',array('data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Column Name", 'type'=>"text", 'value'=>(!empty($data))?$data['PageTemplateRowsColumn']['name']:'')); ?>
					</div>
				</div>
				
				<div class="row">
					
					<div class="col-md-12">
						<h4>Short code<span class="required"> * </span></h4>
						<?php 
							echo $this->Form->input('shortcode', array(
								'options'=>$shortcodeDrpDwn,
								'value'=>(!empty($data))?$data['PageTemplateRowsColumn']['shortcode']:'',
								'before' => '<label class="col-md-4">',
								'after' => '</label>',
								'separator' => '</label><label class="col-md-4"> ',
								'type'=>'radio',
								'legend'=>false,
								'label'=>false,
								'hiddenField'=>false,
								'div'=>false
								)
							);
						
						?>
					</div>
					
						
				</div>
				
			</div>
		</div>
		<div class="modal-footer">
			<?php 
				if(!empty($data)){
					echo $this->Form->input('colSubmitUrl', array('type'=>'hidden', 'id'=>'colSubmitUrl', 'value'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_columnsubmit/'.$data['PageTemplateRowsColumn']['id'], 'full_base'=>true))));
				} else {
					echo $this->Form->input('colSubmitUrl', array('type'=>'hidden', 'id'=>'colSubmitUrl', 'value'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_columnsubmit', 'full_base'=>true))));
				}
				echo $this->Form->input('ajaxTplUrl', array('type'=>'hidden', 'id'=>'ajaxTplUrl', 'value'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true))));
				echo $this->Form->input('parent_colid', array('type'=>'hidden', 'value'=>($tpldata['PageTemplate']['with_sidebar']=='Y')?$reqdata['parentcolId']:0 ));
				echo $this->Form->input('multiple_col', array('type'=>'hidden', 'value'=>"F" ));
				echo $this->Form->button('Submit', array('type' => 'submit', 'class'=>"btn blue"));
			?>
		</div>
		<?php echo $this->Form->end(); ?>
		<!-- END FORM-->
	</div>
	<!-- END VALIDATION STATES-->
</div>
<script type="text/javascript">
$(document).ready(function() {
	Template.init();
});

</script>