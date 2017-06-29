<?php
	//$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$currentModelPer=$this->Session->read('currentModelPer');
   // pr($currentModelPer);
?>
<div class="row" style="padding:10px 0 10px 0;">
	
</div>
<?php
if($currentModelPer['edit']=='Y')
{
?>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-cogs"></i>List of  Social Widgets Contents
		</div>
	</div>
	<div class="portlet-body form" id="blockui_sample_3_1_element">
		<?php echo $this->Form->input('change_count',array("type"=>"hidden", 'id'=>'change_count', "label"=>false,"value"=> 0)); ?>
		<div class="form-body">
			<div class="dd" id="nestable">
			<?php 
			if(!empty($data)){
				echo '<ol class="dd-list">';
				foreach($data as $item){
					echo '<li class="dd-item" data-id="'.$item['SocialWidget']['id'].'">
						<div class="dd-handle">'.$item['SocialWidget']['title'].'</div>';
						
					echo $this->Html->link('<i class="fa fa-circle"></i>', 
								array(
									'controller'=>'SocialWidgets','action'=>($item['SocialWidget']['status'] == 'Y')?'admin_status/'.$item['SocialWidget']['id'].'/N':'admin_status/'.$item['SocialWidget']['id'].'/Y'
								),
								array(
									'class' =>($item['SocialWidget']['status'] == 'Y')?'green item_status':'red item_status',
									'escape' =>false,
									'confirm' => 'Are you sure you wish to change this status?'
								)
							);
						
					echo $this->Html->link('<i class="fa fa-edit"></i>', 
								'javascript:void(0);',
								array(
									'class' =>'item_update linkedit',
									'escape' =>false,
									'data-id'=>$item['SocialWidget']['id']
								)
							);
						
					echo '</li>';
				}
				echo '</ol>'; 
			}
			?>
			</div>
		</div>
		<div style="clear:both"></div>
		<div class="form-actions fluid">
			<div class="col-md-offset-3 col-md-9">
				<?php echo $this->Form->button('Submit', array('class'=>"btn blue", 'id'=>'social_item_save'));?>
			</div>
		</div>
	</div>
</div>
<?php
}
?>
<div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true"></div>
<script type="text/javascript">
$(function(){
	$('.linkedit').click(function(e){
		e.preventDefault();
		var id = $(this).attr('data-id');
		
		if(id.trim()!=''){
			$.ajax({
				type:'POST',
				url:'<?php echo $this->Html->url(array('controller'=>'SocialWidgets', 'action'=>'admin_iconedit', 'full_base'=>true)); ?>',
				data:{id:id},
				success:function(result){
					if(result.trim() != ''){
						$('#responsive').html(result);
						$('#responsive').modal('show');
					}
				}
			});
		}
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
	
	$("#social_item_save").click(function(e){
		e.preventDefault();
		var change_count=$("#change_count").val();
		var socialString = window.JSON.stringify($('#nestable').nestable('serialize'));//, null, 2));
		if(change_count>0){
			
			Metronic.blockUI({
                target: '#blockui_sample_3_1_element',
                boxed: true
            });
			
			$.ajax({
				type:"post",
				url:"<?php echo $this->Html->url(array(
										"controller" => "SocialWidgets",
										"action" => "admin_sortitem"
									)); ?>",
				data:{sstring:socialString},
				success:function(result){
					//alert(result);
					Metronic.unblockUI('#blockui_sample_3_1_element');
					if(result=="1"){
						$("#change_count").val("0");
						alert("Social Widgets Saved !");
					}
				}
			});
		}
		else{
			alert("There is no change in Social widgets items");
		}
	});
	
});


var myEvent = window.attachEvent || window.addEventListener ;
var chkevent = window.attachEvent ? 'onbeforeunload' : 'beforeunload'; /// make IE7, IE8 compatable


myEvent(chkevent, function(e) { // For >=IE7, Chrome, Firefox
	var change_count=$("#change_count").val();
	var confirmationMessage = ' ';  // a space
	if(change_count>0){
		(e || window.event).returnValue = confirmationMessage;
	}
	return confirmationMessage;
});
</script>