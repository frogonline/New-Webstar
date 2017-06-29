<?php if($mode=="edit"): ?>
	<?php echo $this->Form->create('Member', array('url'=>array('controller'=>'Members', 'action'=>'ajaxainfosubmit'), 'id'=>"ainfo_form", 'role'=>"form", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
	<div class="col-md-12">
		<h3>
			Address Info 
			<?php echo $this->Form->button('<i class="fa fa-check"></i>', array('type'=>'submit', 'class'=>'btn green pull-right', 'escape'=>false)); ?>
			<!--<a href="#" class="btn green pull-right"><i class="fa fa-check"></i></a>-->
		</h3>
	</div>
	<div class="form-group col-md-6">
		<label>Address <span class="require">*</span></label>
		<?php echo $this->Form->input('address', array('type'=>'text', 'class'=>'form-control','value'=>(!empty($data))?$data['Member']['address']:'' )); ?>
	</div>
	<div class="form-group col-md-6">
		<label>Address Line 1</label>
		<?php echo $this->Form->input('address1', array('type'=>'text', 'class'=>'form-control','value'=>(!empty($data))?$data['Member']['address1']:'' )); ?>
	</div>
	<div class="form-group col-md-6">
		<label>Country <span class="require">*</span></label>
		<?php echo $this->Form->input('country', array(
			'options'=>$countries, 
			'class'=>'form-control',
			'empty'=>'Select Country',
			'selected'=>(!empty($data))?$data['Member']['country']:'',
			'id'=>'mycountry',
			'data-url'=>$this->Html->url(array('controller'=>'Members','action'=>'ajaxmystate'))
			)); 
		?>
	</div>
	<div class="form-group col-md-6" id="mystate_div">
		<label>State <span class="require">*</span></label>
		<?php echo $this->Form->input('state', array('options'=>$states, 'class'=>'form-control','selected'=>(!empty($data))?$data['Member']['state']:'' )); ?>
	</div>
	<div class="form-group col-md-6" id="mycity_divdd">
		<label>City <span class="require">*</span></label>
	
		<?php echo $this->Form->input('city', array('type'=>'text', 'class'=>'form-control','value'=>(!empty($data))?$data['Member']['city']:'' )); ?>
		
	</div>
	<div class="form-group col-md-6">
		<label>Postcode <span class="require">*</span></label>
		<?php echo $this->Form->input('postcode', array('type'=>'text', 'class'=>'form-control','value'=>(!empty($data))?$data['Member']['postcode']:'' )); ?>
	</div>
	<?php 
		echo $this->Form->input('submiturl', array('type'=>'hidden', 'id'=>'ainfosubmiturl', 'value'=>$this->Html->url(array('controller'=>'Members', 'action'=>'ajaxainfosubmit', 'full_base'=>true)) ));
		echo $this->Form->input('returnurl', array('type'=>'hidden', 'id'=>'ainforeturnurl', 'value'=>$this->Html->url(array('controller'=>'Members', 'action'=>'ajaxaddressinfo', 'full_base'=>true)) ));
		echo $this->Form->end(); 
	?>
<?php elseif($mode=='view'): ?>
<div class="col-md-12">
	<h3>Address Info 
	<?php echo $this->Html->link('<i class="fa fa-edit"></i>', 'javascript:void(0);', array('class'=>'btn default pull-right', 'escape'=>false, 'data-ajaxurl'=>$this->Html->url(array('controller'=>'Members', 'action'=>'ajaxaddressinfo', 'full_base'=>true)), 'id'=>'address_display')); ?>
	</h3>
</div>
<div class="form-group col-md-12">
	<label>Address</label>
	<div class="form-control" style="min-height:100px; overflow:hidden;">
	<?php
		echo (!empty($data))?$data['Member']['address'].','.$data['Member']['address1'].'<br />':'';
		echo (!empty($data))?$data['Country']['Country'].', '.$data['State']['State'].', '.$data['City']['City'].' - '.$data['Member']['postcode']:'';
	?>
	</div>
</div>
<?php endif; ?>
<script type="text/javascript">
jQuery(document).ready(function(){
	Register.init();
	Register.initmyState();
	Register.addressInfoSubmit();
});	
</script>