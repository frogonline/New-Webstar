<?php 
if(!empty($shortcodeArr)){
	$shortcodelist = array();
	foreach($shortcodeArr as $item){
		if($item['Shortcode']['widget_id']!=0){
			$shortcodelist["[".$item['Shortcode']['name']."-".$item['Shortcode']['widget_id']."]"] =  $this->Html->link($this->Html->image(IMGPATH.'style_img/'.$item['Style']['style_img'], array('alt'=>'', 'class'=>'img-responsive')), IMGPATH.'style_img/'.$item['Style']['style_img'], array('escape'=>false, 'class'=>'mix-preview fancybox-button') );
		} else {
			$shortcodelist["[".$item['Shortcode']['name']."]"] = $this->Html->image(IMGPATH.'style_img/'.$item['Style']['style_img'], array('alt'=>'', 'class'=>'img-responsive'));
		}
	}
} else {
	$shortcodelist = array();
}
?>
<h4>Select Image<span class="required"> * </span></h4>
<span for="PageTemplateRowsColumnColumn" class="help-block" style="display:none" id="validatefor1">Please Select any one image</span>
<?php 
echo $this->Form->input('background_img', array(
'options'=>$shortcodelist,
'before' => '<label class="col-md-4">',
'after' => '</label>',
'separator' => '</label><label class="col-md-4">',
'type'=>'radio',
'legend'=>false,
'label'=>false,
'hiddenField'=>false,
'div'=>false
)
); 
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
	
});
</script>			