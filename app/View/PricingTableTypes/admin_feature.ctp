<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
?>
<div class="modal-dialog">
	
	<div class="modal-content">
	<div id="dierte" style="display:none;padding-left:155px;padding-top:19px" >Plan Feature Removed Successfully</div>
				<?php if($style=='style2') { ?>
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('PlanFeature', array('url'=>array('controller'=>'PricingTableTypes','action' => 'admin_boxmanageupdatefeature/'.$box_id.'/'.$id), 'id'=>"form_sample_20", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
				<div class="modal-body">
				<div class="scroller" data-always-visible="1" data-rail-visible1="1">
					<div class="row">
						<div class="col-md-12">
					<?php echo $this->Form->input('plan_id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
					<?php echo $this->Form->input('plan_type_id',array("type"=>"hidden","label"=>false,"value"=> $box_id)); ?>
					<?php echo $this->Form->input('identify',array("type"=>"hidden","label"=>false,"value"=>'')); ?>
							
					<?php
						$i=1;
						$category = explode(",",$data_category['PricePlanType']['category']);
						foreach($category as $cat)
						{
					?>
					<?php echo $this->Form->input('id',array("type"=>"hidden","label"=>false,"value"=>(!empty($data12[$i-1]['PlanFeature']['id']))?$data12[$i-1]['PlanFeature']['id']:'',"name"=>'data[PlanFeature][id][]')); ?>
					<div class="col-md-12">
					<h4><?php echo $cat; ?><span class="required"> * </span></h4>
					<?php echo $this->Form->input('feature_description',array('value'=>(!empty($data12[$i-1]['PlanFeature']['feature_description']))?$data12[$i-1]['PlanFeature']['feature_description']:'','data-required'=>1, 'class'=>"form-control", 'placeholder'=>"Enter Feature Description", 'type'=>"text",'name'=>"data[PlanFeature][feature_description][]",'id'=>'idval'.$i)); ?>
					</div>	
					<span for="idval1" class="help-block" style="display:none" id="error<?php echo $i; ?>">This field is required.</span>
					<?php	
						$i++;
						}
					?>
					<?php echo $this->Form->input('row_num',array('id'=>'row_num',"type"=>"hidden","label"=>false,"value"=> $i-1)); ?>	
					</div>
					</div>
				</div>
			</div>	
			<div class="modal-footer">
				<?php echo $this->Form->button('Submit', array('type' => 'submit', 'class'=>"btn blue",'id'=>'vali'));?>
			</div>
			<?php echo $this->Form->end(); ?>
			<?php } ?>
				<!-- END FORM-->
				
				
				<?php if($style=='style1') { ?>
				<!-- BEGIN FORM-->
				<?php echo $this->Form->create('PlanFeature', array('url'=>array('controller'=>'PricingTableTypes','action' => 'admin_boxmanageupdatefeature/'.$box_id.'/'.$id), 'id'=>"form_sample_20", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
				<?php echo $this->Form->input('plan_id',array("type"=>"hidden","label"=>false,"value"=> $id)); ?>
				<?php echo $this->Form->input('plan_type_id',array("type"=>"hidden","label"=>false,"value"=> $box_id)); ?>
				<?php echo $this->Form->input('identify',array("type"=>"hidden","label"=>false,"value"=> 'identify')); ?>
				<div class="modal-body">
				<div class="scroller" data-always-visible="1" data-rail-visible1="1">
					<div class="row">
					<?php if(empty($data12)){ ?>
					<div class="col-md-12">
					<div class="col-md-12">
					<h4>Plan Feature 1<span class="required"> * </span></h4>
					<?php 
					echo $this->Form->input('feature_description', array(
												'type' => "text",
												'placeholder'=>"Enter Plan's Feature",
												'class' => "form-control item",
												'name'=>"data[PlanFeature][feature_description][]",
												'id'=>"sty1"
											)); 
					?>
					<span for="idval1" class="help-block" style="display:none" id="errorr1">This field is required.</span>
					</div>	
					<div id="new"></div>
					</br></br></br></br></br>
					<a class="btn btn-xs green addmore" style="float:right" id="add1_0" rel="" href="javascript:void(0);">
						Add More <i class="fa fa-plus"></i>
					</a>
					</div>
					<?php } 
					else if(!empty($data12)){
					?>
						<?php 
						$i=1;
						foreach($data12 as $datahds){?>
						
									<div class="col-md-12">
									<?php if($i==1){ ?>
									<h4>Plan Feature <?php echo $i; ?><span class="required"> * </span></h4>
									<?php 
									echo $this->Form->input('feature_description', array(
																'type' => "text",
																'placeholder'=>"Enter Plan's Feature",
																'class' => "form-control item",
																'name'=>"data[PlanFeature][feature_description][]",
																'id'=>"sty".$i,
																'value'=>(!empty($datahds))?$datahds['PlanFeature']['feature_description']:''
															)); 
									?>
									<?php echo $this->Form->input('id',array("type"=>"hidden",'id'=>"idhd".$i,"label"=>false,"value"=> $datahds['PlanFeature']['id'],'name'=>'data[PlanFeature][id][]')); ?>
									<span for="idval<?php echo $i; ?>" class="help-block" style="display:none" id="errorr<?php echo $i; ?>">This field is required.</span>
									<?php }else if($i!=1){ ?>
									<div id="div<?php echo $i; ?>">
										<h4>Plan Feature <?php echo $i; ?><span class="required"> * </span></h4>
										<?php 
										echo $this->Form->input('feature_description', array(
																	'type' => "text",
																	'placeholder'=>"Enter Plan's Feature",
																	'class' => "form-control item",
																	'name'=>"data[PlanFeature][feature_description][]",
																	'id'=>"sty".$i,
																	'value'=>(!empty($datahds))?$datahds['PlanFeature']['feature_description']:''
																)); 
											?>
						<?php echo $this->Form->input('id',array("type"=>"hidden",'id'=>"idhd".$i,"label"=>false,"value"=> $datahds['PlanFeature']['id'],'name'=>'data[PlanFeature][id][]')); ?>
										<a class="btn btn-xs purple remove1"  id="" href="javascript:void(0);" onclick="deletediv(<?php echo $i ?>)"><i class="fa fa-times"></i> Remove </a>
										<span for="idval<?php echo $i; ?>" class="help-block" style="display:none" id="errorr<?php echo $i; ?>">This field is required.</span>
									</div>
									<?php } ?>
									</div>	
						<?php 
						$i++;
						}
						?>
						<div id="new"></div>
						</br></br></br></br></br>
						<a class="btn btn-xs green addmore" style="float:right" id="add1_0" rel="" href="javascript:void(0);">
						Add More <i class="fa fa-plus"></i>
						</a>
					<?php
					}
					 ?>
					</div>
				</div>
				</div>	
			<div class="modal-footer">
				<?php echo $this->Form->button('Submit', array('type' => 'submit', 'class'=>"btn blue",'id'=>'valil'));?>
			</div>
			<?php echo $this->Form->end(); ?>
			<?php } ?>
			</div>
			<!-- END VALIDATION STATES-->
		</div>


<script type="text/javascript">
$(function(){

	
	$('#vali').click(function(e){
		var valrow=$('#row_num').val();
		for(var i=1; i<=valrow; i++)
		{
			var everval=$('#idval'+i).val();
			if(everval=='')
			{
				$('#error'+i).show();
				return false;
			}
		}
	});

	$('#add1_0').click(function(e){
			var numItems = $('.item').length;
			var pernumItems=numItems+1;
			$("#new").append('<div id="div'+pernumItems+'"></br></br></br></br></br><div class="col-md-12"><h4>Plan Feature '+pernumItems+'<span class="required"> * </span></h4><input type="text" name="data[PlanFeature][feature_description][]" placeholder="Enter Plans Feature" id="sty'+pernumItems+'" class="form-control item" data-required="1" /><a class="btn btn-xs purple remove1"  id="" href="javascript:void(0);" onclick="deletediv('+pernumItems+')"><i class="fa fa-times"></i> Remove </a><span for="idval1" class="help-block" style="display:none" id="errorr'+pernumItems+'">This field is required.</span><div></div>');
	
	});
	
	$('#valil').click(function(e){
		var numItems = $('.item').length;
		for(var i=1; i<=numItems; i++)
		{
			var everval=$('#sty'+i).val();
			if(everval=='')
			{
				$('#errorr'+i).show();
				return false;
			}
		}
	});
	
	
	
});
function deletediv(divid)
	{
		var valuu=$('#sty'+divid).val();
		var idvalwe=$('#idhd'+divid).val();
		
		if(valuu=='')
		{
			$('#div'+divid).remove();
		}
		else if(valuu!='')
		{
			 var returnval=confirm("Do you really want to delete this Plan Feature?");
			  var returnval1=returnval;
			 if(returnval1==true)
			 {
				 $.ajax({
				type:'POST',
				url:'<?php echo $this->Html->url(array('controller'=>'PricingTableTypes','action'=>'admin_boxplandelete','full_base'=>true)); ?>',
				data:{valuu:valuu,idvalwe:idvalwe},
				success:function(result){
					if(result=='1')
					{
						$('#dierte').show();
						$('#div'+divid).remove();
					}
				}
				});
				}
			 
		}
	}
</script>