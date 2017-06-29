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
</div> --->
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
</div> --->
<?php
}
?>
<div class="content">
<div class="container">
	<div class="row">
		
		<?php if(!empty($posts)){ ?>
		<div class="ajax-page-preloader" style="position: relative;">
			<div class="loader spinner">
				<?php echo $this->Html->image(CURRENT_THEME_URL.'img/loader.gif', array('width'=>'24', 'height'=>'24')); ?>	
			</div>
		</div>
		
		<div class="blog-wrapper isotope-container grid main-el">
			<?php 
			foreach($posts as $postarr){  
				$commentcount=count($postarr['PostComment']); 
			?>
			<div class="col-sm-4 element-wrap isotope-element isotope-item">
				<div class="element">
					<div class="head">
					<?php if($postarr['Page']['cms_image']!=''){ ?>
						<div class="image">
							<div class="overlay">
							<?php
							echo $this->Html->link('<i class="fa fa-share md"></i>', SITE_URL.$postarr['Page']['slug'], array('escape'=>false));
							?>
							</div>
							<?php echo $this->Html->image(IMGPATH.'cms_image/resize/'.$postarr['Page']['cms_image'], array('alt'=>$postarr['Page']['title'], 'class'=>'img-responsive')); ?>
						</div>
					<?php } ?>
					</div>
					<div class="body shop-box-background shop-box-text">
						<h5 class="medium">
						<?php echo $this->Html->link($postarr['Page']['title'], SITE_URL.$postarr['Page']['slug']); ?>
						</h5>
						<p class="italic post-links">
							<?php
							echo $this->Html->link(($commentcount==0)?$commentcount.' comment':$commentcount.' comments', ($commentcount==0)?'javascript:void(0);':SITE_URL.$postarr['Page']['slug'].'#comment');
							?>
							
						</p>
						<p><?php echo $postarr['Page']['summery'];  ?></p>
						<div class="clearfix"></div>
						<div class="bot clearfix shop-box-background shop-box-text">
							<div class="date italic">
								<?php echo date("d F Y", strtotime(date("d-m-Y", strtotime($postarr['Page']['created_date'])))); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } ?> 
		</div>
	
		<?php   echo $this->element('blogpaginator');   } else { ?>
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

