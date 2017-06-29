<?php
	//pr($reqdata);
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$column_size = array('1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'6', '7'=>'7', '8'=>'8', '9'=>'9', '10'=>'10', '11'=>'11', '12'=>'12');
	
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h2><?php echo (!empty($data))?"Edit":"Add New"; ?> Column</h2>
		</div>
			<!-- BEGIN FORM-->
			<?php echo $this->Form->create('FooterColumn', array('id'=>"mngeColForm", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<div class="modal-body">
			<div class="scroller" data-always-visible="1" data-rail-visible1="1">
				<div class="row">
					<?php 
						echo $this->Form->input('row_id',array("type"=>"hidden", "value"=>$reqdata['tplId']));
						echo $this->Form->input('tmplt_id',array("type"=>"hidden", 'id'=>'tmplt_id', "value"=>$reqdata['tplId']));
					?>
					<div class="col-md-12">
						<h4>Column Name<span class="required">  </span></h4>
						<?php echo $this->Form->input('name',array('data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Column Name", 'type'=>"text", 'value'=>(!empty($data))?$data['FooterColumn']['name']:'')); ?>
					</div>
				</div>
				
				<div class="row">		
					
					<div class="col-md-6" id="ssc">
						<h4>Short code<span class="required"> * </span></h4>
						<?php echo $this->Form->input('shortcode',array('data-required'=>1, 'id'=>'shortcodeFld', 'class'=>"form-control",  'type'=>"text", 'value'=>(!empty($data))?$data['FooterColumn']['shortcode']:'')); ?>
					</div>
					
					<div class="col-md-6" id="shotcode">
						<h4>Or Select Shortcode<span class="required"> * </span></h4>
						<?php
						echo $this->Html->link('Choose your Shortcode', 'javascript:void(0);', array(
								'escape'=>false, 
								'class'=>'btn blue addCustomCol2', 
								'data-rowid'=>$reqdata['tplId'], 
								'data-templateid'=>$reqdata['tplId'],
								'data-templateFor'=>"H",
								'data-url'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_new1', 'full_base'=>true)), 
								'data-saveastplurl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_saveastemplate', 'full_base'=>true))
							)
						);
						?>
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
														  'selected'=>(!empty($data))?$data['FooterColumn']['column']:''
													));
						?>
					</div>
					<div class="col-md-6">
						<h4>Sort Order<span class="required"> * </span> </h4>
						<?php 
							echo $this->Form->input('sort_order',
													array('data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Order", 'type'=>"text", 'class'=>"form-control", 'value'=>(!empty($data))?$data['FooterColumn']['sort_order']:''
													));
						?>
					</div>
				</div>
			</div>
		</div>	
		<div class="modal-footer">
			<?php 
				if(!empty($data)){
					echo $this->Form->input('colSubmitUrl', array('type'=>'hidden', 'id'=>'colSubmitUrl', 'value'=>$this->Html->url(array('controller'=>'FooterRows', 'action'=>'admin_columnsubmit/'.$data['FooterColumn']['id'], 'full_base'=>true))));
				} else {
					echo $this->Form->input('colSubmitUrl', array('type'=>'hidden', 'id'=>'colSubmitUrl', 'value'=>$this->Html->url(array('controller'=>'FooterRows', 'action'=>'admin_columnsubmit', 'full_base'=>true))));
				}
				echo $this->Form->input('ajaxTplUrl', array('type'=>'hidden', 'id'=>'ajaxTplUrl', 'value'=>$this->Html->url(array('controller'=>'FooterRows', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true))));
				
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