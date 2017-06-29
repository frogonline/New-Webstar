<?php
	$revsliderTypeArr = array('1'=>'Background Image','2'=>'Video','3'=>'Call To Action');
	
?>
<div class="col-md-4" style="border:1px solid #4B8DF8; min-height:275px;" id="div_<?php echo $data['id']; ?>">
	<?php echo $this->Form->input('banner_div_id', array('type'=>'hidden', 'name'=>'data[CmsBanner][banner_div_id][]', 'value'=>$data['id'])); ?>
	<div class="form-group" style="margin:10px 0 0 0;">
		<label>Banner Image <span class="required"> * </span></label>
		<?php echo $this->Form->input('banner_image',array('data-required'=>1, 'name'=>'data[CmsBanner][banner_image][]', 'class'=>"form-control", 'id'=>"banner_image_".$data['id'], 'type'=>"file", 'label'=>false, 'div'=>false)); ?>
	</div>
	
	
	<?php
	if($data['gallery_id']==1){
	?>
	<div class="form-group" style="margin:10px 0 0 0;">
		<label>Revolution Slider Type </label>
		<?php 
			echo $this->Form->input('rev_slider_type',array(
						'name'=>'data[CmsBanner][rev_slider_type][]',
						'id'=>"rev_slider_type_".$data['id'], 
						'class'=>"form-control slider_type", 
						'empty'=>"- Select Revolution Slider Type -", 
						'options'=>$revsliderTypeArr, 
						'data-id'=>$data['id'],
						'label'=>false, 
						'div'=>false
					)
				); 
		?>
	</div>
	
	<div style="display:none" id="rev_1_<?php echo $data['id']; ?>" class="rev_type">
		<div class="form-group" style="margin:10px 0 0 0;">
			<label>Banner BackGround Image <span class="required"> * </span></label>
			<?php echo $this->Form->input('banner_back_image',array('data-required'=>1, 'name'=>'data[CmsBanner][banner_back_image][]', 'class'=>"form-control", 'id'=>"banner_back_image_".$data['id'], 'type'=>"file", 'label'=>false, 'div'=>false)); ?>
		</div>
	</div>
	
	<div style="display:none" id="rev_2_<?php echo $data['id']; ?>" class="rev_type">
		<div class="form-group" style="margin:10px 0 0 0;">
			<label>Video Link <span class="required"> * </span></label>
			<?php echo $this->Form->input('rev_video_link',array('data-required'=>1, 'name'=>'data[CmsBanner][rev_video_link][]', 'class'=>"form-control", 'id'=>"rev_video_link_".$data['id'], 'type'=>"textarea", 'label'=>false, 'div'=>false)); ?>
		</div>
	</div>
	
	<div style="display:none" id="rev_3_<?php echo $data['id']; ?>" class="rev_type">
		<div class="form-group" style="margin:10px 0 0 0;">
			<label>Text Heading <span class="required"> * </span></label>
			<?php echo $this->Form->input('detailheading',array('data-required'=>1, 'name'=>'data[CmsBanner][detailheading][]', 'class'=>"form-control", 'id'=>"detailheading_".$data['id'], 'type'=>"text", 'label'=>false, 'div'=>false)); ?>
		</div>
		<div class="form-group" style="margin:10px 0 0 0;">
			<label>Text Description <span class="required"> * </span></label>
			<?php echo $this->Form->input('banner_text',array('data-required'=>1, 'name'=>'data[CmsBanner][banner_text][]', 'class'=>"form-control", 'id'=>"banner_text_".$data['id'], 'type'=>"text", 'label'=>false, 'div'=>false)); ?>
		</div>
		<div class="form-group" style="margin:10px 0 0 0;">
			<label>Call To Action Text <span class="required"> * </span></label>
			<?php echo $this->Form->input('button_text',array('data-required'=>1, 'name'=>'data[CmsBanner][button_text][]', 'class'=>"form-control", 'id'=>"button_text_".$data['id'], 'type'=>"text", 'label'=>false, 'div'=>false)); ?>
		</div>
		<div class="form-group" style="margin:10px 0 0 0;">
			<label>Call To Action Link <span class="required"> * </span></label>
			<?php echo $this->Form->input('button_link',array('data-required'=>1, 'name'=>'data[CmsBanner][button_link][]', 'class'=>"form-control", 'id'=>"button_link_".$data['id'], 'type'=>"text", 'label'=>false, 'div'=>false)); ?>
		</div>
	</div>
	
	<?php } else if($data['gallery_id']==2) { ?>
	<div class="form-group" style="margin:10px 0 0 0;">
		<label>Banner Link <span class="required"> * </span></label>
		<?php echo $this->Form->input('banner_link',array('data-required'=>1, 'name'=>'data[CmsBanner][banner_link][]', 'class'=>"form-control", 'id'=>"banner_image_".$data['id'], 'type'=>"text", 'label'=>false, 'div'=>false)); ?>
	</div>
	<?php
		echo $this->Form->input('rev_slider_type',array('name'=>'data[CmsBanner][rev_slider_type][]', 'value'=>0, 'type'=>'hidden'));
	?>
	<?php } ?>
	
	<div class="input-group" style="margin:10px 0;">
		<?php echo $this->Html->link('Remove Row','javascript:void(0);', array('class'=>"btn red remove", 'data-id'=>'#div_'.$data['id'], 'onclick'=>'return remove_div(this);')); ?>
	</div>
</div>
<script type="text/javascript">
function remove_div(p){
	var div = $(p).attr('data-id');
	$(div).remove();
	return false;
}

$(function(){
	$('.slider_type').change(function(){
		var id = $(this).attr('data-id');
		var val = $(this).val();
		$('#div_'+id+' .rev_type').hide();
		$('#rev_'+val+'_'+id).show();
	});
});
</script>
