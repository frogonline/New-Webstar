<h4>Select Image<span class="required"> * </span></h4>
<span for="PageTemplateRowsColumnColumn" class="help-block" style="display:none" id="validatefor1">Please Select any one image</span>
<?php 
if(!empty($shortcodeArr)){
	echo '<div class="row">';
	foreach($shortcodeArr as $item){
		echo '<div class="col-md-4 mrgtop20">';
		if($item['Shortcode']['widget_id']!=0){
			echo $this->Form->input('background_img', array(
					'options'=>array('['.$item['Shortcode']['name'].'-'.$item['Shortcode']['widget_id'].']'=>$item['Shortcode']['widget_title']),
					'type'=>'radio',
					'legend'=>false,
					'label'=>true,
					'hiddenField'=>false,
					'div'=>false,
					'class'=>'radio-btn-cstm'
				)
			); 
			echo $this->Html->link($this->Html->image(IMGPATH.'style_img/'.$item['Style']['style_img'], array('alt'=>'', 'class'=>'img-responsive')), IMGPATH.'style_img/'.$item['Style']['style_img'], array('escape'=>false, 'class'=>'mix-preview fancybox-button') );
		} else {
			echo $this->Form->input('background_img', array(
					'options'=>array('['.$item['Shortcode']['name'].']'=>$item['Shortcode']['widget_title']),
					'type'=>'radio',
					'legend'=>false,
					'label'=>true,
					'hiddenField'=>false,
					'div'=>false,
					'class'=>'radio-btn-cstm'
				)
			); 
			echo $this->Html->link($this->Html->image(IMGPATH.'style_img/'.$item['Style']['style_img'], array('alt'=>'', 'class'=>'img-responsive')), IMGPATH.'style_img/'.$item['Style']['style_img'], array('escape'=>false, 'class'=>'mix-preview fancybox-button') );
		}
		echo '</div>';
	}
	echo '</div>';
}
?>
<script type="text/javascript">
$(function(){
	jQuery(".fancybox-button").fancybox({
		groupAttr: 'data-rel',
		prevEffect: 'none',
		nextEffect: 'none',
		closeBtn: true,
		helpers: {
			title: {
				type: 'inside'
			}
		}
	}); 
	
	/* $("a.inline").fancybox().hover(function() {
		$(this).click();
	}); */
	
});
</script>			