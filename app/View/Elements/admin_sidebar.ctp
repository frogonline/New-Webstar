<?php
	$current_controller = strtolower($this->name);
	$current_action = strtolower($this->action); 
	$url = array('controller'=>$current_controller,'action'=>$current_action)
?>
<div class="page-sidebar navbar-collapse collapse">
	<!-- BEGIN SIDEBAR MENU -->
	<?php 
	$menu = $this->AdminMenu->adminMenu($url);
	//print_r($menu);
	echo $menu;
	
	?>
	<!--<ul class="page-sidebar-menu" data-auto-scroll="false" data-auto-speed="200">
	<?php 
		/* $str = '';
		if($this->Session->read('Auth.User.user_type')=="super")
		{
			$str='<li>'.$this->Html->link('<i class="fa fa-windows"></i><span class="title ManageModules">Manage Modules</span>', array('controller'=>'ManageModules', 'action'=>'admin_index'), array('escape'=>false,'full_base'=>true)).'</li>';
		}
		echo $str; */
	?>
	</ul> --->
	<!-- END SIDEBAR MENU -->
</div>