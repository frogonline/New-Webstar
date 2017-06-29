<?php
$options = $this->SideBars->sidebarOptions(3);

if(!empty($options)){
	foreach($options as $option){
		echo $this->ShortCode->make_content($option['SidebarOption']['widget_shortcode']);
	}
}

?>