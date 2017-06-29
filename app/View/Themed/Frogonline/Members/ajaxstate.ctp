<label for="state" class="col-lg-4 control-label">Region/State <span class="require">*</span></label>
<div class="col-lg-8">
<?php 
echo $this->Form->input('state', array(
	'options'=>$states,
	'name'=>'data[Member][state]',
	'data-url'=>$this->Html->url(array('controller'=>'Members', 'action'=>'ajaxcity', 'full_base'=>true)),
	'empty'=>' --- Please Select --- ',
	'class'=>'form-control',
	'id'=>'register_state12',
	'label'=>false,
	'div'=>false
	)
); 
?>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
	Register.initCity();
});
</script>