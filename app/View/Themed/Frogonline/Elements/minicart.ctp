<?php 
$ThemeSetting=$this->Session->read('ThemeSetting');
$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];

?><div id="nav-shop" class="panel-collapse collapse <?php echo ($ThemeSettingheadertype=='V')?' verticalheader':'col-xs-12 horizontalheader'; ?>">
	<div class="container">
	   <?php if($ThemeSettingheadertype=='V'):?>
	   <div class="row">
	    <div class="col-xs-3" >
			&nbsp;
		</div>
	   <?php endif;?>
	
	
	
		<div class=" <?php echo ($ThemeSettingheadertype=='V')?'col-md-9 col-sm-12 col-xs-12 verticalcontainerdiv':'col-xs-12'; ?>" id="minicart">
			<?php
				$this->Layout->minicart();
			?>
		</div>
		<?php if($ThemeSettingheadertype=='V'):?>
		</div>
		<?php endif; ?>
	</div>
</div>