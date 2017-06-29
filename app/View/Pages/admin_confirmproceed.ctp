<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h2 class="modal-title">Confirm Box</h2>
		</div>
		<?php echo $this->Form->create('PageTemplate', array('url'=>array('controller'=>'Pages','action' => 'admin_saveastemplate'), 'id'=>"saveasForm", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<div class="modal-body">
			<div class="scroller" data-always-visible="1" data-rail-visible1="1">
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-12">
							<h4>Do you want to proceed?</h4>
							<?php echo $this->Form->input('template_name', array('type'=>'hidden', 'value'=>$data['title']));
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<?php
				echo $this->Form->input('template_id', array('type'=>'hidden', 'id'=>'pre_template_id', 'value'=>$data['tplId']));
				echo $this->Form->input('template_for', array('type'=>'hidden', 'id'=>'template_for', 'value'=>$data['tplFor']));
				echo $this->Form->input('with_sidebar', array('type'=>'hidden', 'value'=>(!empty($tpldata))?$tpldata['PageTemplate']['with_sidebar']:'N'));
				//echo $this->Form->input('row_id', array('type'=>'hidden', 'id'=>'pre_row_id', 'value'=>$data['rowId']));
				//echo $this->Form->input('mode', array('type'=>'hidden', 'id'=>'mode', 'value'=>'addcolumn'));
				
				echo $this->Form->input('savetplurl', array('type'=>'hidden', 'id'=>'savetplurl', 'value'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_saveastplsubmit', 'full_base'=>true)) ));
				echo $this->Form->input('ajaxtplprvwurl', array('type'=>'hidden', 'id'=>'ajaxtplprvwurl', 'value'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_ajaxtplpreview', 'full_base'=>true)) ));
				echo $this->Form->input('ajaxtpldrpdwnurl', array('type'=>'hidden', 'id'=>'ajaxtpldrpdwnurl', 'value'=>$this->Html->url(array('controller'=>'Pages','action' => 'admin_pgtpldrpdown', 'full_base'=>true)) ));
				
				echo $this->Form->button('Yes', array('type' => 'submit', 'class'=>"btn green"));
				echo $this->Form->button('No', array('type' => 'button', 'id'=>'cancel-formbtn', 'class'=>"btn red"));
			?>
			<div class="well well-lg" id="waitingDiv" style="display:none;">
				<center><img src="<?php echo SITE_URL.'img/loader.gif' ?>" alt="" /> Please wait template is generating.</center>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	Template.savetplsubmit();
});
</script>