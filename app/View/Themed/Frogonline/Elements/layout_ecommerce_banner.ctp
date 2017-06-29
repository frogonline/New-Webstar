<?php
	$category = $this->Layout->categoryDetails($slug);
?>
<div class="title-wrapper" style="background:#72c2ff url(<?php echo (!empty($category))?IMGPATH.'category_image/resize/'.$category['ProductCategory']['category_image']:''; ?>) no-repeat scroll 100% 100%;">
	<div class="container">
		<div class="container-inner">
			<h1><span><?php echo (!empty($category))?$category['ProductCategory']['name']:''; ?></span> CATEGORY</h1>
			<em><?php echo (!empty($category))?$category['ProductCategory']['category_desc']:''; ?></em>
		</div>
	</div>
</div>