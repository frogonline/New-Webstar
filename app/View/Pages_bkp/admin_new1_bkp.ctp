<?php
	//pr($data1);
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$column_size = array('1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'6', '7'=>'7', '8'=>'8', '9'=>'9', '10'=>'10', '11'=>'11', '12'=>'12');
	
	
	/* $shortcodeDrpDwn = array();
	if(!empty($shortcodeArr)){
		foreach($shortcodeArr as $item){
			if($item['Shortcode']['widget_id']!=0){
				$shortcodeDrpDwn["[".$item['Shortcode']['name']."-".$item['Shortcode']['widget_id']."]"] = "[".$item['Shortcode']['name']."-".$item['Shortcode']['widget_id']."]";
			} else {
				$shortcodeDrpDwn["[".$item['Shortcode']['name']."]"] = "[".$item['Shortcode']['name']."]";
			}
		}
	} */
	//pr($shortcodeDrpDwn);

	
	
?>
<div class="modal-dialog" style="height:5000px; width:1200px; z-index: 1050;">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h2>Select ShortCode</h2>
			<!--<h2 class="modal-title"><?php //if($column_id!=''){ ?>Edit<?php //}else{ ?> Add<?php //} ?> Column</h2>-->
		</div>
			<!-- BEGIN FORM-->
		<?php echo $this->Form->create('PageTemplateRowsColumn', array('id'=>"shortcodechooseForm", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>	
		<div class="modal-body">
			
			<div class="form-horizontal scroller" data-always-visible="1" data-rail-visible1="1">
				<div class="row">		
					<div class="col-md-4">
						<h4>Select Group<span class="required"> * </span></h4>
						<?php 
							echo $this->Form->input('shortcode',
													array('options'=>$widgetgroup_dropdown, 
														  'default'=>'',
														  'id'=>'newsel',
														  'empty'=>'Please Select',		
														  'data-required'=>1, 
														  'onchange' => 'change(this.value);',
														  'class'=>"form-control",
														  'selected'=>(!empty($data))?$data['PageTemplateRowsColumn']['shortcode']:''
													));
						?>
					<span for="PageTemplateRowsColumnColumn" class="help-block" style="display:none" id="validatefor">This field is required.</span>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" id="dimage" style="display:none"></div>
				</div>
			</div>
		</div>	
		<div class="modal-footer">
			<?php 
				if(!empty($data)){
					echo $this->Form->input('colSubmitUrl', array('type'=>'hidden', 'id'=>'colSubmitUrl', 'value'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_columnsubmit/'.$data['PageTemplateRowsColumn']['id'], 'full_base'=>true))));
				} else {
					echo $this->Form->input('colSubmitUrl', array('type'=>'hidden', 'id'=>'colSubmitUrl', 'value'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_columnsubmit', 'full_base'=>true))));
				}
				echo $this->Form->input('ajaxTplUrl', array('type'=>'hidden', 'id'=>'ajaxTplUrl', 'value'=>$this->Html->url(array('controller'=>'Pages', 'action'=>'admin_ajaxtplpreview', 'full_base'=>true))));
				echo $this->Form->button('Ok', array('type' => 'button', 'class'=>"btn blue",'id'=>"ok"));
			?>
		</div>
		<?php echo $this->Form->end(); ?>
		<!-- END FORM-->
	</div>
	<!-- END VALIDATION STATES-->
</div>
<script type="text/javascript">
function change(val)
{
    $('#validatefor').hide();
	var val=val;
	$.ajax({
			type:'POST',
			url:'<?php echo $this->Html->url(array('controller'=>'Pages','action'=>'admin_ajaxdynamicimage')); ?>',
			data:{val:val},
			success:function(result){
				//alert(result);
			    $('#dimage').show();
				$('#dimage').html(result);
			}
		});
}

$(function(){
	$('#ok').click(function(e){
		var selval=$('#newsel').val();
		if(selval==''){
			$('#validatefor').show();
			return false;
		}
		if (!$("#shortcodechooseForm input[type='radio']:checked").val() ) 
		{  
			$('#validatefor1').show();
			return false;
		
		}
		e.preventDefault();
		var value1=$("#shortcodechooseForm input[type='radio']:checked").val();	
		$('#ssc').show();
		$('#shortcodeFld').val(value1);
		$('#hid').val('0');
		$('#clone').show();
		$('#responsive1').modal("hide");
		//$('#shotcode').hide();
	});	
});

</script>