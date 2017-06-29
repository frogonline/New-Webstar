<?php
	//pr($reqdata);
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$column_size = array('1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'6', '7'=>'7', '8'=>'8', '9'=>'9', '10'=>'10', '11'=>'11', '12'=>'12');
	$clone = array('Y'=>'Yes','N'=>'No');
	
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
	//pr($shortcodeDrpDwn);
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h2><?php echo (!empty($data))?"Edit":"Add New"; ?> Column</h2>
		</div>
			<!-- BEGIN FORM-->
			<?php if(!empty($shotcode)) { ?>
			<?php echo $this->Form->create('PageTemplateRowsColumn', array('id'=>"addColumnsForm1", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
			<?php } else { ?>
			<?php echo $this->Form->create('PageTemplateRowsColumn', array('id'=>"addColumnsForm", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
			<?php } ?>
		<div class="modal-body">
			<div class="scroller" data-always-visible="1" data-rail-visible1="1">
				<div class="row">
					<?php 
						//echo $this->Form->input('hid_clone',array("type"=>"hidden", "id"=>'hid_clone',"value"=>'0'));
						if(!isset($reqdata['colId']))
						{
							echo $this->Form->input('hid',array("type"=>"hidden", "id"=>'hid',"value"=>'0'));
						}
						else
						{
							echo $this->Form->input('hid',array("type"=>"hidden", "id"=>'hid', "value"=>'1'));
						}
						echo $this->Form->input('row_id',array("type"=>"hidden", "value"=>$reqdata['rowId']));
						echo $this->Form->input('tmplt_id',array("type"=>"hidden", 'id'=>'tmplt_id', "value"=>$reqdata['tplId']));
						echo $this->Form->input('pageid',array("type"=>"hidden", 'id'=>'pageid', "value"=>$pageid));
						echo $this->Form->input('parentcolId',array("type"=>"hidden", 'id'=>'parentcolId', "value"=>$parentcolId));
					?>
					<div class="col-md-12">
						<h4>Column Name<span class="required"> * </span></h4>
						<?php echo $this->Form->input('name',array('id'=>'colmane','data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Column Name", 'type'=>"text", 'value'=>(!empty($data))?$data['PageTemplateRowsColumn']['name']:'')); ?>
					</div>
				</div>
				
				<div class="row">		
					
					<div class="col-md-6" id="ssc">
						<h4>Short code<span class="required"> * </span></h4>
						<?php if(!empty($shotcode)) { ?>
						<?php echo $this->Form->input('shortcode',array('data-required'=>1, 'id'=>'shortcodeFld', 'class'=>"form-control",  'type'=>"text", 'value'=>$shotcode)); ?>
						
						<?php echo $this->Form->input('shotcode',array("type"=>"hidden", "id"=>'shotcode', "value"=>$shotcode)); ?>
						
						<?php echo $this->Form->input('colId',array("type"=>"hidden", "id"=>'colId', "value"=>$colId)); ?>
						<?php echo $this->Form->input('rowId',array("type"=>"hidden", "id"=>'rowId', "value"=>$rowId)); ?>
						
						<?php } else { ?>
						<?php echo $this->Form->input('shortcode',array('data-required'=>1, 'id'=>'shortcodeFld', 'class'=>"form-control",  'type'=>"text", 'value'=>(!empty($data))?$data['PageTemplateRowsColumn']['shortcode']:'')); ?>
						<?php } ?>
					</div>
					
					<div class="col-md-6" id="shotcode">
						<h4>Or Select Shortcode<span class="required"> * </span></h4>
						<?php
						echo $this->Html->link('Choose your Shortcode', 'javascript:void(0);', array(
								'escape'=>false, 
								'class'=>'btn blue addCustomCol2', 
								'data-rowid'=>$rowId, 
								'data-templateid'=>$tplId,
								'data-templateFor'=>"H",
								'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_new1', 'full_base'=>true))
							)
						);
						?>
					</div>
					
				</div>
				
				<div class="row" id="clone">
					<div class="col-md-6">
						<h4>Clone ShortCode<span class="required"> * </span> </h4>
						<?php 
							echo $this->Form->input('clone_flag',
													array('options'=>$clone, 
														  'default'=>'',
														  'empty'=>'Please Select',
														  'selected'=>(!empty($data))?$data['PageTemplateRowsColumn']['clone_flag']:'',
														  'data-required'=>1, 
														  'class'=>"form-control",
														  'id'=>'clone_flag'
													));
						?>
					</div>
					<div class="col-md-6">
						<h4>Column Class </h4>
						<?php 
						echo $this->Form->input('class', array(
								'type'=>'text',
								'class'=>"form-control",
								'value'=>(!empty($data))?$data['PageTemplateRowsColumn']['class']:'',
								'data-required'=>1
							)
						);
						?>
						<strong style="color:#8a6d3b">
						Note : Please use space between two classes.
						</strong>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<h4>Column Size<span class="required"> * </span> </h4>
						<?php 
							echo $this->Form->input('column',
													array('options'=>$column_size, 
														  'default'=>'',
														  'empty'=>'Please Select',
														  'data-required'=>1, 
														  'class'=>"form-control",
														  'selected'=>(!empty($data))?$data['PageTemplateRowsColumn']['column']:''
													));
						?>
					</div>
					<div class="col-md-6">
						<h4>Sort Order<span class="required"> * </span> </h4>
						<?php 
							echo $this->Form->input('sort_order',
													array('data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Order", 'type'=>"text", 'class'=>"form-control", 'value'=>(!empty($data))?$data['PageTemplateRowsColumn']['sort_order']:''
													));
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" style="margin:10px 0 0 0;">
						<div class="alert alert-warning"><strong>Scroll Background, Carousel, Testimonial Style 3, Box Style 1, Box Style 3, Box Style 4, Box Style 6 - widgets will only work in 12 columns.</strong></div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<?php 
				echo $this->Form->input('clone_flag', array('type'=>'hidden', 'value'=>(!empty($data))?$data['PageTemplateRowsColumn']['clone_flag']:'Y'));
			
				if(!empty($data)){
					echo $this->Form->input('colSubmitUrl', array('type'=>'hidden', 'id'=>'colSubmitUrl', 'value'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_columnsubmit/'.$data['PageTemplateRowsColumn']['id'], 'full_base'=>true))));
				} else {
					echo $this->Form->input('colSubmitUrl', array('type'=>'hidden', 'id'=>'colSubmitUrl', 'value'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_columnsubmit', 'full_base'=>true))));
				}
				
				echo $this->Form->input('ajaxTplUrl', array('type'=>'hidden', 'id'=>'ajaxTplUrl', 'value'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true))));
				echo $this->Form->input('parent_colid', array('type'=>'hidden', 'value'=>($tpldata['PageTemplate']['with_sidebar']=='Y')?$reqdata['parentcolId']:0 ));
				echo $this->Form->input('multiple_col', array('type'=>'hidden', 'value'=>($tpldata['PageTemplate']['with_sidebar']=='Y')?"T":"F" ));
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
	/* $("#clone_flag").change(function(){
		if($(this).val()=='Y')
		{
			$("#hid_clone").val('1');
		}
		else
		{
			$("#hid_clone").val('0');
		}
		
	}) */
});

</script>