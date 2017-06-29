<?php 
//pr($testimonial);exit;
	$siteSetting = $this->Session->read('siteSettings');
	//pr($siteSetting);
	$this->assign('title', 'Blog'); 
	$this->assign('meta_title', $siteSetting['SiteSetting']['meta_title']); 
	$this->assign('meta_keywords', $siteSetting['SiteSetting']['meta_keywords']); 
	$this->assign('meta_description', $siteSetting['SiteSetting']['meta_des']); 
	$this->assign('image_path', ''); 
	$this->assign('url_path', SITE_URL.'blog'); 
?>
<?php 
if($type=='search')
{
	echo $this->Layout->pagecrumb('post', 'Blog Search', $slug, 'search');
?>
<!---<div class="pagecrumbs">
	<div class="container">
		<div class="row">
			<div class="col-xs-4">
				<h5 class="medium">Search results for: <?php //echo $slug; ?></h5>
			</div>
			<div class="col-xs-8">
				<div class="location pull-right">
					<span class="medium">You are here: </span><a href="<?php //echo SITE_URL;?>">Home</a> / <a href="#">Blog Search</a>
				</div>
			</div>
		</div>
	</div>
</div> ---->
<?php
}
else
{
	echo $this->Layout->pagecrumb('post', 'Blog');
?>
<!---<div class="pagecrumbs">
	<div class="container">
		<div class="row">
			<div class="col-xs-4">
				<h5 class="medium">Blog</h5>
			</div>
			<div class="col-xs-8">
				<div class="location pull-right">
					<span class="medium">You are here: </span><a href="<?php //echo SITE_URL;?>">Home</a> / <a href="#">Blog</a>
				</div>
			</div>
		</div>
	</div>
</div> ---->
<?php
}
?>
<div class="content">
<div class="container">
	<div class="row">
		<?php echo $this->element('blogsidebar'); ?>
		<div class="blog-wrapper col-md-9 main-el">
			<?php if(!empty($posts)){ ?>
		
			<?php 
			foreach($posts as $postarr){ 
				$commentcount=count($postarr['PostComment']); 
			?>
				<div class="element row">
					<div class="text-center stats hidden-sm hidden-xs col-md-1">
						<div class="date blog_date_control">
							<div class="day light main-text-color"><?php echo date("d", strtotime($postarr['Page']['created_date'])); ?></div>
							<div class="month"><?php echo date("F", strtotime($postarr['Page']['created_date'])); ?></div>
						</div>
					</div>

					<div class="col-md-11">
						<div class="image">
							<div class="overlay">
								<i class="fa fa-share md"></i>
							</div>
							<?php echo $this->Html->image(IMGPATH."cms_image/resize/".$postarr['Page']['cms_image'], array('alt'=>$postarr['Page']['title'], 'class'=>'img-responsive')); ?>
						</div>
						<div class="body">
						<h3><?php echo $this->Html->link($postarr['Page']['title'], SITE_URL.$postarr['Page']['slug'],array('class'=>'blog_name_control')); ?></h3>
						<p class="italic post-links">Posted By Admin / <a class="blog_comment_control"><?php echo ($commentcount > 1)?$commentcount." comment":$commentcount." comments"; ?></a></p>
						<p class="text blog_summery_control"><?php echo $postarr['Page']['content']; ?>
							<span class="read-link main-text-color">
							<?php echo $this->Html->link("Read More", SITE_URL.$postarr['Page']['slug'],array('class'=>'blog_name_control')); ?><i class="fa fa-play-circle-o"></i>
							</span> 
						</p>

					</div>
					</div>
					<div class="col-md-11 col-md-offset-1">
						<div class="sep-line"></div>
					</div>
				</div>
			<?php 
			}
			echo $this->element('blogpaginator'); 
			} else { 
			?>
			<div class="alert alert-noicon sc">
				<div class="text col-md-12 col-sm-7">
					<center><strong>No posts available here.</strong></center>
				</div>
				<div class="clearfix"></div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
</div>