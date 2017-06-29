<label>State <span class="require">*</span></label>
<?php 
echo $this->Form->input('state', array(
	'options'=>$states, 
	'class'=>'form-control',
	'name'=>'data[Member][state]',
	'data-url'=>$this->Html->url(array('controller'=>'Members', 'action'=>'ajaxmycity', 'full_base'=>true)),
	'empty'=>' --- Please Select --- ',
	'selected'=>(!empty($data))?$data['Member']['state']:'',
	'id'=>'mystate',
	'label'=>false,
	'div'=>false
	)); 
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	Register.initmyCity();
});
</script>