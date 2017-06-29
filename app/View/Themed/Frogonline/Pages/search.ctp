<?php 
foreach($data1 as $data)
{
	$this->assign('title', $data['Page']['title']); 
	$this->assign('meta_title', $data['Page']['metatitle']); 
	$this->assign('meta_keywords', $data['Page']['metakeywords']); 
	$this->assign('meta_description', $data['Page']['metadescription']); 
	$this->assign('image_path', IMGPATH.'product_image/original/'.$data['Page']['cms_image']); 
	$this->assign('url_path', SITE_URL.$data['Page']['page_url']); 
}


echo $this->Layout->pagecrumb('post', 'Page Search', $searchvalue, 'search');

?>
<!--<div class="pagecrumbs">
	<div class="container">
		<div class="row">
			<div class="col-xs-4">
				<h5 class="medium">Search results for: <?php echo $searchvalue; ?></h5>
			</div>
			<div class="col-xs-8">
				<div class="location pull-right">
					<span class="medium">You are here: </span><a href="<?php echo SITE_URL;?>">Home</a> / <a href="#">Page Search</a>
				</div>
			</div>
		</div>
	</div>
</div>-->
<div class="content">
	<div class="container">
		<div class="row">
		<?php foreach($data1 as $data){ 
		?>
			<div class="col-sm-12 main-el">
			<p><strong>Page Title:</strong>
			<a href="<?php echo $data['Page']['page_url']; ?>"><?php echo $data['Page']['title']; ?></a>
			</p>
			<p><strong>Summery:</strong><?php echo $data['Page']['summery']; ?></p>
			</div>
		<?php 
		} 
		?>
		<?php
		if(empty($data1))
		{
		?>
		<div class="alert alert-noicon sc">
					<div class="text col-md-12 col-sm-7">
						<center><strong>No pages available here.</strong></center>
					</div>
					<div class="clearfix"></div>
		</div>
		<?php 
		}
		?>
		</div>
	</div>
</div>