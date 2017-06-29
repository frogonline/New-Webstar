<?php
$userArr = AuthComponent::user();
if($userArr['user_type']=="super"){
?>
<label class="col-md-3 control-label">Page Template </label>
<div class="col-md-4">
	<div class="input-group">
		<?php  
			echo $this->Form->input('template_id', array(
									'options' => $tplList,
									'onchange'=>'ChangeTemplate(this);',
									'empty' => 'Select Template',	
									'class' => 'form-control',
									'name' => 'data[Page][template_id]',
									'data-templateFor'=>$data['tplFor'],
									'id'=>'templatedrpdwn',
									'data-changeUrl'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true)),
									'selected'=> (isset($data))?$data['tplId']:'',
									'label'=>false,
									'div'=>false
								));
		?>  
	</div>
</div>
<?php
} else {
	echo $this->Form->input('template_id', array('type'=>'hidden', 'name' =>'data[Page][template_id]', 'value'=>(isset($data))?$data['tplId']:''));
}
?>