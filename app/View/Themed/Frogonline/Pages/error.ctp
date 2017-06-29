<div class="main">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="<?php echo SITE_URL; ?>">Home</a></li>
			<li class="active">Error</li>
		</ul>
		<div class="row margin-bottom-40">
			<!-- BEGIN CONTENT -->
			<div class="col-md-12 col-sm-12">
				<?php echo $this->Session->flash('register'); ?>
				<?php echo $this->Session->flash('order'); ?>
			</div>
			<!-- END CONTENT -->
		</div>
	</div>
</div>
