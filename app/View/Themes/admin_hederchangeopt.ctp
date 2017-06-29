<?php if(!empty($headermenuArr)){ ?>
<label class="control-label col-md-3">Header Menu Style <span class="required">* </span></label>
<div class="col-md-4">
<?php
echo $this->Form->input('header_menu_style', array(
		'options'=>$headermenuArr,
		'empty'=>'--- Select Layout ---',
		'class'=>'form-control',
		'name'=>'data[ThemeSetting][header_menu_style]',
		'label'=>false,
		'div'=>false
	)
); 
?>
</div>
<?php } ?>