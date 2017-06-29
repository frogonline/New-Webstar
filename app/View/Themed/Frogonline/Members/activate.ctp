<?php
echo $this->Layout->pagecrumb('page', 'Success');
?>
<div class="container">
	<div class="row margin-bottom-40">
		<!-- BEGIN CONTENT -->
		<div class="col-md-12 col-sm-12">
			<?php echo $this->Session->flash('activate'); ?>
		</div>
		<!-- END CONTENT -->
	</div>
</div>
