<?php 
//pr($testimonial);exit;
	$this->assign('title', $data['Page']['title']); 
	$this->assign('meta_title', $data['Page']['metatitle']); 
	$this->assign('meta_keywords', $data['Page']['metakeywords']); 
	$this->assign('meta_description', $data['Page']['metadescription']); 
	$this->assign('image_path', IMGPATH.'product_image/original/'.$data['Page']['cms_image']); 
	$this->assign('url_path', SITE_URL.$data['Page']['page_url']); 
	
	echo (!empty($data))?$this->Layout->pagecrumb('page', $data['Page']['title'], $data['Page']['slug'],$Parentpagename):'';
	echo $this->ShortCode->make_content($data['Page']['content']); 
?>