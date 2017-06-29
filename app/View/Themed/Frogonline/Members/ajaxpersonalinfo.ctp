<?php if($mode=="edit"): ?>
	<?php echo $this->Form->create('Member', array('url'=>array('controller'=>'Members', 'action'=>'ajaxpinfosubmit'), 'id'=>"pinfo_form", 'role'=>"form", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
	<div class="col-md-12">
		<h3>
			Persional Info 
			<?php echo $this->Form->button('<i class="fa fa-check"></i>', array('type'=>'submit', 'class'=>'btn green pull-right', 'escape'=>false)); ?>
			<!--<a href="#" class="btn green pull-right"><i class="fa fa-check"></i></a>-->
		</h3>
	</div>
	<div class="form-group col-md-6">
		<label>First Name <span class="require">*</span></label>
		<?php echo $this->Form->input('firstname', array('type'=>'text', 'class'=>'form-control','value'=>(!empty($data))?$data['Member']['firstname']:'' )); ?>
	</div>
	<div class="form-group col-md-6">
		<label>Last Name <span class="require">*</span></label>
		<?php echo $this->Form->input('lastname', array('type'=>'text', 'class'=>'form-control','value'=>(!empty($data))?$data['Member']['lastname']:'' )); ?>
	</div>
	<div class="form-group col-md-6">
		<label>Telephone <span class="require">*</span></label>
		<?php echo $this->Form->input('telephone', array('type'=>'text', 'class'=>'form-control','value'=>(!empty($data))?$data['Member']['telephone']:'' )); ?>
	</div>
	<div class="form-group col-md-6">
		<label>Fax</label>
		<?php echo $this->Form->input('fax', array('type'=>'text', 'class'=>'form-control','value'=>(!empty($data))?$data['Member']['fax']:'' )); ?>
	</div>
	<div class="form-group col-md-6">
		<label>Company</label>
		<?php echo $this->Form->input('company', array('type'=>'text', 'class'=>'form-control','value'=>(!empty($data))?$data['Member']['company']:'' )); ?>
	</div>
	<div class="form-group col-md-6">
		<label>Password</label>
			<?php echo $this->Form->input('New.password',array('id'=>"password",'class'=>"form-control",'div'=>false, 'label'=>false, 'type'=>'password','Placeholder'=>'')); ?>
	</div>
	<?php 
		echo $this->Form->input('submiturl', array('type'=>'hidden', 'id'=>'pinfosubmiturl', 'value'=>$this->Html->url(array('controller'=>'Members', 'action'=>'ajaxpinfosubmit', 'full_base'=>true)) ));
		echo $this->Form->input('returnurl', array('type'=>'hidden', 'id'=>'pinforeturnurl', 'value'=>$this->Html->url(array('controller'=>'Members', 'action'=>'ajaxpersonalinfo', 'full_base'=>true)) ));
		echo $this->Form->end(); 
	?>
<?php elseif($mode=='view'): ?>
<div class="col-md-12">
	<h3>Persional Info 
	<?php echo $this->Html->link('<i class="fa fa-edit"></i>', 'javascript:void(0);', array('class'=>'btn default pull-right', 'escape'=>false, 'data-ajaxurl'=>$this->Html->url(array('controller'=>'Members', 'action'=>'ajaxpersonalinfo', 'full_base'=>true)), 'id'=>'info_display')); ?>
	</h3>
</div>
<div class="form-group col-md-6">
	<label>Name</label>
	<div class="form-control"><?php echo (!empty($data))?$data['Member']['firstname'].' '.$data['Member']['lastname']:''; ?></div>
</div>
<div class="form-group col-md-6">
	<label>Email</label>
	<div class="form-control"><?php echo (!empty($data))?$data['Member']['email_id']:''; ?></div>
</div>
<div class="form-group col-md-6">
	<label>Telephone</label>
	<div class="form-control"><?php echo (!empty($data))?$data['Member']['telephone']:''; ?></div>
</div>
<div class="form-group col-md-6">
	<label>Fax</label>
	<div class="form-control"><?php echo (!empty($data))?$data['Member']['fax']:''; ?></div>
</div>
<div class="form-group col-md-6">
	<label>Company</label>
	<div class="form-control"><?php echo (!empty($data))?$data['Member']['company']:''; ?></div>
</div>
<?php endif; ?>
<script type="text/javascript">
jQuery(document).ready(function(){
	Register.init();
	Register.personalInfoSubmit();
});	
</script>