<?php $delivery_flagArr = array('Y'=>'Yes','N'=>'No');?>
<div class="modal-dialog">
	<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h2 class="modal-title">Edit Delivery Status</h2>
			</div>
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('Order', array('url'=>array('controller'=>'Orders', 'action' => 'admin_deliverystatusupdate/'.$id), 'id'=>"form_sample_19", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
			<div class="modal-body">
				<div class="scroller" data-always-visible="1" data-rail-visible1="1">
					<div class="row">
						<div class="col-md-12">
						<div class="col-md-12">
								<h4>Delivery Status<span class="required">  </span></h4>
								<?php
								echo $this->Form->input('delivery_status', array(
										'options'=>$delivery_flagArr,
										'value'=>(!empty($data))?$data['Order']['delivery_status']:'',
										'type'=>'radio',
										'class'=>'cladelivery',
										'data-error-container'=>'#customerror_div',
										'before' => '<label class="col-md-3">',
										'after' => '</label>',
										'separator' => '</label><label class="col-md-3">',
										'legend'=>false,
										'hiddenField'=>false
									)
								);
								?>
						</div>
						<?php 
						if($data['Order']['delivery_status']=='Y')
						{
						?>
						<div class="col-md-6" id="same">
								<h4>Delivery Date<span class="required"> * </span></h4>
								<span for="meta_title" class="help-block" id="errorid" style="display:none">This field is required.</span>
								<?php $date = new DateTime($data['Order']['delivery_date']);	
								echo $this->Form->input('delivery_date',array('type'=>'text', 'class'=>'form-control form-filter input-sm date-picker','value'=>(isset($data['Order']))? $date->format('m/d/Y'):'')); ?>
						</div>
						
						<?php 
						}else{?>
							<div class="col-md-6" style="display:none" id="same">
								<h4>Delivery Date<span class="required"> * </span></h4>
								<span for="meta_title" class="help-block" id="errorid" style="display:none">This field is required.</span>
								<?php echo $this->Form->input('delivery_date',array('type'=>'text', 'class'=>'form-control form-filter input-sm date-picker','value'=>(isset($data['Order']))?$data['Order']['delivery_date']:'')); ?>
						</div>
						
						<?php }?>
						</div>
					</div>
				</div>
			</div>	
			<div class="modal-footer">
				<?php echo $this->Form->button('Submit', array('type' => 'submit', 'class'=>"btn blue",'id'=>'subidd'));?>
			</div>
				<?php echo $this->Form->end(); ?>
				<!-- END FORM-->
	</div>
</div>


<script type="text/javascript">
$(function(){
	$('#OrderDeliveryStatusY').click(function(){
		var val=$('#OrderDeliveryStatusY').val();
		if(val == 'Y')
		{
			$('#same').show();
		}
	});
	
	$('#OrderDeliveryStatusN').click(function(){
		var val=$('#OrderDeliveryStatusN').val();
		if(val == 'N')
		{
			$('#same').hide();
		}
	});
	$('#subidd').click(function(){
		var valdate=$('#OrderDeliveryDate').val();
		val=$("#form_sample_19 input[type='radio']:checked").val();
		if(val == 'Y')
		{
			if(valdate == '')
			{
				$('#errorid').show();
				$('#OrderDeliveryDate').focus();
				return false;
			}
		}
	});
});
</script>
<script>
$(function() {
$('#OrderDeliveryDate').datepicker({
	dateFormat: 'dd/mm/yy',
	yearRange: '1970:+20',
	changeMonth: true,
    changeYear: true 
	});
});
</script>