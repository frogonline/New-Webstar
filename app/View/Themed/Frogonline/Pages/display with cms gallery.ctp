<div class="pagecrumbs">
	<div class="container">
		<div class="row">
			<div class="col-xs-4">
				<h5 class="medium"><?php echo $data['Page']['title']; ?></h5>
			</div>
			<div class="col-xs-8">
				<div class="location pull-right">
					<span class="medium">You are here: </span><a href="<?php echo SITE_URL;?>">Home</a> / <a href="#"><?php echo $data['Page']['title']; ?></a>
				</div>
			</div>
		</div>
	</div>
</div>



<?php echo $this->ShortCode->make_content($data['Page']['content']); ?>
	

<?php if(count($cmsGallery)>1): ?>
<div class="container spaced-top">
	<div class="row"></div>
	<div class="row">
		<div class="col-md-12 main-el">
			<div class="fancy-portfolio wrap">
			<?php foreach($cmsGallery['CmsBanner'] as $bannerarr): ?>
			  <div class="item wrap isotope-element identity">
					<div class="item">
						<a class="overlay mgp-img" href="<?php echo $this->webroot.'img/uploads/cms_banner_image/resize/'.$bannerarr['banner_image']; ?>">
							<i class="fa fa-search md alt-text-color"></i>
							<div class="title light alt-text-color"><?php echo $bannerarr['banner_text']; ?></div>
						</a>
						<?php echo $this->Html->image(IMGPATH.'cms_banner_image/resize/'.$bannerarr['banner_image'], array('alt'=>'', 'class'=>'img-responsive')); ?>
						<!--<img src="<?php echo $this->webroot.'img/uploads/cms_banner_image/resize/'.$bannerarr['banner_image']; ?>" alt="" class="img-responsive">-->
					</div>
				</div>
			   <?php endforeach; ?>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>