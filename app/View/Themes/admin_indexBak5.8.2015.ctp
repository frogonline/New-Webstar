<div class="row">
	<div class="col-md-12">
		<!-- BEGIN VALIDATION STATES-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i>Upload Theme
				</div>
			</div>
			<div class="portlet-body form">
				<?php echo $this->Form->create('Theme', array('action' => 'admin_index', 'id'=>"form_sample_3", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
				<div class="form-body">
					<div class="form-group">
						<label class="control-label col-md-4">Upload Theme (Zip File) :</label>
						<div class="col-md-4">
							<div class="input-group input-large">		
								<?php echo $this->Form->input('zip_file',array('type'=>'file', 'class'=>'form-control','style'=>'float:left'))?>
							</div>
						</div>
						<div class="col-md-4">
							<?php echo $this->Form->submit('Upload',array('type'=>'submit', 'class'=>'btn blue' ,'style'=>'float:left'))?>
						</div>
					</div>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
		
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-edit"></i>All Themes
				</div>
			</div>
			<div class="portlet-body form">
				<div class="row">
					<?php foreach($allThemes as $allTheme){?>	
					<div class="col-sm-12 col-md-4">
						<div class="thumbnail <?php echo ($allTheme['Theme']['status']=='Y')?'list-group-item-info':''; ?>">
							<img class="img-responsive" src="<?php echo THEME_URL.$allTheme['Theme']['zip_file']; ?>/img/ThemeImage.JPG"  alt="">
							<!--<img src="holder.js/100%x200" alt="" style="width: 100%; height: 200px;">-->
							<div class="caption">
								<h3><?php echo $allTheme['Theme']['zip_file'];?></h3>
								<p>
									<?php
									if($allTheme['Theme']['status'] == 'Y'){
									   
										echo $this->Html->link('Deactivate', array('controller'=>'Themes', 'action'=>'admin_deactivate/'.$allTheme['Theme']['id']), array('class'=>'btn red','confirm'=>'Do you really want to deactivate ?','full_base'=>true));
										echo "&nbsp &nbsp &nbsp &nbsp &nbsp ";
										echo $this->Html->link('Edit', array('controller'=>'Themes', 'action'=>'admin_manage/'.$allTheme['Theme']['id']), array('class'=>'btn purple'));
										
										
									} else if($allTheme['Theme']['status'] == 'N') {
										echo '<div class="row">';
											echo '<div class="col-md-4">';
											echo $this->Html->link('Activate', array('controller'=>'Themes', 'action'=>'admin_activate/'.$allTheme['Theme']['id']), array('class'=>'btn blue'));
											echo '</div>';
											echo '<div class="col-md-4">';
											echo $this->Html->link('Delete', array('controller'=>'Themes', 'action'=>'admin_delete/'.$allTheme['Theme']['id']), array('class'=>'btn red'));
											echo '</div>';
										echo '</div>';
									}
									?>
								</p>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>