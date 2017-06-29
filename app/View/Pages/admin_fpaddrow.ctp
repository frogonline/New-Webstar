<?php
	$rowstyleArr = array('FULLWIDTH'=>'Full Width','INSIDECONTAINER'=>'Inside Container');
	$foregroundArr = array('Y'=>'Yes','N'=>'No');
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h2>Add New Row</h2>
		</div>
		<!-- BEGIN FORM-->
		<?php echo $this->Form->create('PageTemplateRow', array('id'=>"addRowsForm", 'class'=>"horizontal-form", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<div class="modal-body">
			<div class="scroller" data-always-visible="1" data-rail-visible1="1">
				<?php 
					echo $this->Form->input('template_id',array("type"=>"hidden", 'id'=>'tmplt_id', "value"=>$reqdata['tplId']));
				?>
				<div class="row">		
					<div class="col-md-6">
						<h4>Row Style <span class="required"> * </span> </h4>
						<?php 
							echo $this->Form->input('rowstyle',
													array('options'=>$rowstyleArr, 
														  'default'=>'',
														  'empty'=>'Please Select',
														  'data-required'=>1, 
														  'id'=>"rowstyleDrpdwn",
														  'class'=>"form-control",
														  'selected'=>(!empty($data))?$data['PageTemplateRow']['rowstyle']:''
													));
						?>
					</div>
					
					<div class="col-md-6" id="needFg" style=<?php echo (!empty($data))?($data['PageTemplateRow']['rowstyle']=='FULLWIDTH')?'"display:none;"':'':'"display:none;"'; ?>>
						<h4>Need Foreground ? <span class="required"> * </span></h4>
						<?php 
							echo $this->Form->input('rowwithForeground',
													array('options'=>$foregroundArr, 
														  'default'=>'',	
														  'data-required'=>1, 
														  'class'=>"form-control",
														  'selected'=>(!empty($data))?$data['PageTemplateRow']['rowwithForeground']:''
													));
						?>
					</div>
						
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<h4>Section Class </h4>
						<?php 
						echo $this->Form->input('row_class', array(
								'type'=>'text',
								'class'=>"form-control",
								'value'=>(!empty($data))?$data['PageTemplateRow']['row_class']:'',
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
						<h4>Section Background Image/Color </h4>
						<?php 
						echo $this->Form->input('background_image', array(
								'type'=>'text',
								'class'=>"form-control",
								'value'=>(!empty($data))?$data['PageTemplateRow']['background_image']:'',
								'data-required'=>1
							)
						);
						?>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<h4>Sort Order <span class="required"> * </span> </h4>
						<?php 
						echo $this->Form->input('sort_order', array(
								'type'=>'text',
								'class'=>"form-control",
								'value'=>(!empty($data))?$data['PageTemplateRow']['sort_order']:'',
								'data-required'=>1
							)
						);
						?>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12" style="margin:10px 0 0 0;">
						<div class="alert alert-warning">
						<strong>
						Note : Full Width does not have margins / padding on sides, it goes accross the page.<br />
						* Container : It has 1170px wide container which is placed in the center of the page.<br />
						* White Background : If selected yes container background become white.
						</strong>
						</div>
					</div>
				</div>
			</div>
		</div>	
		<div class="modal-footer">
			<?php 
				if(!empty($data)){
					echo $this->Form->input('rowSubmitUrl', array('type'=>'hidden', 'id'=>'rowSubmitUrl', 'value'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_rowsubmit/'.$data['PageTemplateRow']['id'], 'full_base'=>true))));
				} else {
					echo $this->Form->input('rowSubmitUrl', array('type'=>'hidden', 'id'=>'rowSubmitUrl', 'value'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_rowsubmit', 'full_base'=>true))));
				}
				echo $this->Form->input('ajaxTplUrl', array('type'=>'hidden', 'id'=>'ajaxTplUrl', 'value'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true))));
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