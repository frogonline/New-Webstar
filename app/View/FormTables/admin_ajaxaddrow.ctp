<div class="row" id="optDiv<?php echo ($data)?$data['optid']:''; ?>" style="padding:15px 0 0 0;">
	<div class="col-md-6">
	<?php 
	echo $this->Form->input('option', array(
			'type'=>'text',
			'class'=>"form-control opt",
			'name'=>'data[FormToolOption][option_value]['.$data['optid'].']',
			'label'=>false
		)
	);
	?>
	</div>
	
	<div class="col-md-6">
	<?php echo $this->Html->link('<i class="fa fa-trash"></i>', 'javascript:void(0);', array('escape' => false, 'data-divid'=>'#optDiv'.$data['optid'], 'class'=>"btn red", 'onclick'=>'return optDlt(this);')); ?>
	</div>

</div>

<script type="text/javascript">
function optDlt(ele){
	if(confirm("Do you want to delete?")){
		var divId = $(ele).attr('data-divid');
		$(divId).remove();
	}
	return false;
}
</script>