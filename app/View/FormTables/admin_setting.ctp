<?php
	$deliveryMethodArr = array('E'=>'Send By Email','D'=>'Store To Database');
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$toolType = array('TB'=>'Text Box', 'TA'=>'Text Area', 'PW'=>'Password', 'EI'=>'Email ID', 'SB'=>'Select Box', 'CB'=>'Check Box', 'RB'=>'Radio Button','IMG'=>'File Box');
	
	$toolOptBoxArr = array(
		'TB'=>$this->Html->url(array('controller'=>'FormTables', 'action'=>'admin_ajaxtb', 'full_base'=>true)), 
		'TA'=>$this->Html->url(array('controller'=>'FormTables', 'action'=>'admin_ajaxta', 'full_base'=>true)), 
		'PW'=>$this->Html->url(array('controller'=>'FormTables', 'action'=>'admin_ajaxpw', 'full_base'=>true)), 
		'EI'=>$this->Html->url(array('controller'=>'FormTables', 'action'=>'admin_ajaxei', 'full_base'=>true)),
		'SB'=>$this->Html->url(array('controller'=>'FormTables', 'action'=>'admin_ajaxsb', 'full_base'=>true)),
		'CB'=>$this->Html->url(array('controller'=>'FormTables', 'action'=>'admin_ajaxcb', 'full_base'=>true)),
		'RB'=>$this->Html->url(array('controller'=>'FormTables', 'action'=>'admin_ajaxrb', 'full_base'=>true)),
		'IMG'=>$this->Html->url(array('controller'=>'FormTables', 'action'=>'admin_ajaxfile', 'full_base'=>true))
	);
?>
<style class="text/css">
.border{border: 1px solid #4B8DF8; }
</style>
<div class="row">
	<div class="col-md-3">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-table"></i>Tool Box
				</div>
			</div>
			<div class="portlet-body form">
				<div class="row form-body">
					<div class="col-md-6 ">
						<?php echo $this->Html->link($this->Html->image(SITE_URL.'img/tb.png', array('class'=>'img-responsive border')), 'javascript:void(0);', array('escape'=>false, 'title'=>'Text Box', 'class'=>'toolOpt', 'data-url'=>$this->Html->url(array('controller'=>'FormTables', 'action'=>'admin_ajaxtb', 'full_base'=>true)), 'data-id'=>'', 'data-formid'=>$id)); ?>
					</div>
					<div class="col-md-6">
						<?php echo $this->Html->link($this->Html->image(SITE_URL.'img/ta.png', array('class'=>'img-responsive border')), 'javascript:void(0);', array('escape'=>false, 'title'=>'Text Area', 'class'=>'toolOpt', 'data-url'=>$this->Html->url(array('controller'=>'FormTables', 'action'=>'admin_ajaxta', 'full_base'=>true)), 'data-id'=>'', 'data-formid'=>$id)); ?>
					</div>
				</div>
				<div class="row form-body">
					<div class="col-md-6 ">
						<?php echo $this->Html->link($this->Html->image(SITE_URL.'img/pw.png', array('class'=>'img-responsive border')), 'javascript:void(0);', array('escape'=>false, 'title'=>'Password', 'class'=>'toolOpt', 'data-url'=>$this->Html->url(array('controller'=>'FormTables', 'action'=>'admin_ajaxpw', 'full_base'=>true)), 'data-id'=>'', 'data-formid'=>$id)); ?>
					</div>
					<div class="col-md-6">
						<?php echo $this->Html->link($this->Html->image(SITE_URL.'img/ei.png', array('class'=>'img-responsive border')), 'javascript:void(0);', array('escape'=>false, 'title'=>'Email Id', 'class'=>'toolOpt', 'data-url'=>$this->Html->url(array('controller'=>'FormTables', 'action'=>'admin_ajaxei', 'full_base'=>true)), 'data-id'=>'', 'data-formid'=>$id)); ?>
					</div>
				</div>
				<div class="row form-body">
					<div class="col-md-6">
						<?php echo $this->Html->link($this->Html->image(SITE_URL.'img/sb.png', array('class'=>'img-responsive border')), 'javascript:void(0);', array('escape'=>false, 'title'=>'Select Box', 'class'=>'toolOpt', 'data-url'=>$this->Html->url(array('controller'=>'FormTables', 'action'=>'admin_ajaxsb', 'full_base'=>true)), 'data-id'=>'', 'data-formid'=>$id)); ?>
					</div>
					<div class="col-md-6">
						<?php echo $this->Html->link($this->Html->image(SITE_URL.'img/rb.png', array('class'=>'img-responsive border')), 'javascript:void(0);', array('escape'=>false, 'title'=>'Radio Button', 'class'=>'toolOpt', 'data-url'=>$this->Html->url(array('controller'=>'FormTables', 'action'=>'admin_ajaxrb', 'full_base'=>true)), 'data-id'=>'', 'data-formid'=>$id)); ?>
					</div>
				</div>
				<div class="row form-body">
					<div class="col-md-6">
						<?php echo $this->Html->link($this->Html->image(SITE_URL.'img/cb.png', array('class'=>'img-responsive border')), 'javascript:void(0);', array('escape'=>false, 'title'=>'Check Box', 'class'=>'toolOpt', 'data-url'=>$this->Html->url(array('controller'=>'FormTables', 'action'=>'admin_ajaxcb', 'full_base'=>true)), 'data-id'=>'', 'data-formid'=>$id)); ?>
					</div>
					
					<div class="col-md-6">
						<?php echo $this->Html->link($this->Html->image(SITE_URL.'img/file.png', array('class'=>'img-responsive border')), 'javascript:void(0);', array('escape'=>false, 'title'=>'File', 'class'=>'toolOpt', 'data-url'=>$this->Html->url(array('controller'=>'FormTables', 'action'=>'admin_ajaxfile', 'full_base'=>true)), 'data-id'=>'', 'data-formid'=>$id)); ?>
					</div>
					
					
					
				</div>
			</div>
			<!-- END VALIDATION STATES-->
		</div>
	</div>
	<div class="col-md-9">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i><?php echo (isset($id))?'Edit':'Add' ?> Form Options
				</div>
			</div>
			<div class="portlet-body form">
				<div class="form-body">
					<div class="row">
						<div class="col-md-8">
							<div class="dd" id="nestable">
							<?php 
							echo $this->Form->input('',array("type"=>"hidden", 'id'=>'form_id', "label"=>false,"value"=> $id));
							echo $this->Form->input('change_count',array("type"=>"hidden", 'id'=>'change_count', "label"=>false,"value"=> 0));
							
							if(!empty($formToolList)){
								echo '<ol class="dd-list">';
								foreach($formToolList as $formTool){
									echo '<li class="dd-item" data-id="'.$formTool['FormTool']['id'].'">
										<div class="dd-handle">'.$toolType[$formTool['FormTool']['tool_type']].' Label : '.$formTool['FormTool']['label'].'</div>';
									echo $this->Html->link('&times;', 
												array(
													'controller'=>'FormTables','action'=>'admin_itemdelete/'.$formTool['FormTool']['id'].'/'.$id
												),
												array(
													'class' =>'red item_delete',
													'escape' =>false,
													'confirm' => 'Are you sure you wish to delete this?'
												)
											);
									echo $this->Html->link('<i class="fa fa-gear"></i>', 
												'javascript:void(0);',
												array(
													'class' =>'blue item_edit toolOpt',
													'escape' =>false,
													'data-url'=>$toolOptBoxArr[$formTool['FormTool']['tool_type']],
													'data-id'=>$formTool['FormTool']['id'],
													'data-formid'=>$id,
												)
											);
									
									echo '</li>';
								}
								echo '</ol>'; 
							}
							?>
							</div>
						</div>
					</div>
				</div>
				<div style="clear:both"></div>
				<div class="form-actions fluid">
					<div class="col-md-offset-3 col-md-9">
						<?php echo $this->Form->button('Submit', array('class'=>"btn blue", 'id'=>'form_item_save'));?>
					</div>
				</div>
			</div>
			<!-- END VALIDATION STATES-->
		</div>
	</div>
	
</div>
<div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true"></div>
<script type="text/javascript">
$(function(){
	$('.toolOpt').click(function(e){
		e.preventDefault();
		var clickURL = $(this).attr('data-url');
		var toolId = $(this).attr('data-id');
		var formId = $(this).attr('data-formid');
		
		$.ajax({
			type:'POST',
			url:clickURL,
			data:{toolId:toolId, formId:formId},
			success:function(result){
				$('#responsive').html(result);
				$('#responsive').modal('show');
			}
		});
	});
	
	$('#nestable').nestable({
        group: 1,
		maxDepth: 1
    })
    .on('change', function(e){
		var menuString="";
		var change_count=$("#change_count").val();
		change_count++;
		
		if (window.JSON) {
            menuString = window.JSON.stringify($('#nestable').nestable('serialize'));//, null, 2));
        } else {
            alert('JSON browser support required for this demo.');
        }
		menuString=window.JSON.stringify($('#nestable').nestable('serialize'));
		$("#change_count").val(change_count);
		
	});
	
	$("#form_item_save").click(function(e){
		e.preventDefault();
		var change_count=$("#change_count").val();
		var fid=$("#form_id").val();
		var formString = window.JSON.stringify($('#nestable').nestable('serialize'));//, null, 2));
		if(change_count>0){
			
			Metronic.blockUI({
                target: '#blockui_sample_3_1_element',
                boxed: true
            });
			
			$.ajax({
				type:"post",
				url:"<?php echo $this->Html->url(array(
										"controller" => "FormTables",
										"action" => "admin_sortitem"
									)); ?>",
				data:{fstring:formString,form_id:fid},
				success:function(result){
					//alert(result);
					Metronic.unblockUI('#blockui_sample_3_1_element');
					if(result=="1"){
						$("#change_count").val("0");
						alert("Form Saved !");
					}
				}
			});
		}
		else{
			alert("There is no change in sidebar items");
		}
	});
	
});
</script>