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
	<div class="timeline clearfix col-md-12 hidden-xs">
	                    <?php for($i=0; $i<count($posts); $i++) {
                         $commentcount=count($posts[$i]['PostComment']); 
						?>
                        <div class="row">
						    <div class="col-sm-6">
						    <?php if($i<count($posts)) { ?>
                            
                                <div class="main-el clearfix">
                                    <div class="element left">
                                        <div class="head">
                                           
                                        </div>
                                        <div class="body">
                                              <h5 class="medium"><?php echo $this->Html->link($posts[$i]['Page']['title'], SITE_URL.$posts[$i]['Page']['slug'],array('class'=>'blog_name_control')); ?></h5>
                                            <p class="italic post-links">
											<?php
											echo $this->Html->link(($commentcount==0)?$commentcount.' comment':$commentcount.' comments', ($commentcount==0)?'javascript:void(0);':SITE_URL.$posts[$i]['Page']['slug'].'#comment',array('class'=>'blog_comment_control'));
											?>
											
										   </p>
                                            <p class="blog_summery_control"><?php echo $posts[$i]['Page']['summery'];  ?></p>
                                            <div class="clearfix"></div>
                                            <div class="bot clearfix blog_date_control">
												<div class="date italic">
													<?php echo date("d F Y", strtotime(date("d-m-Y", strtotime($posts[$i]['Page']['created_date'])))); ?>
												</div>
											</div>
                                        </div>
                                        <div class="attached">
                                            <div class="arrow"></div>
                                            <div class="dot"><i class="fa fa-circle main-text-color"></i></div>
                                        </div>
                                    </div>
                                </div>
								<?php } ?>
                            </div>
							
		                   <?php $i= $i+1; ?>
						   <div class="col-sm-6">
							<?php if($i<count($posts)) { ?>
                                <div class="main-el clearfix">
                                    <div class="element right">
                                        <div class="head">
                                            
                                        </div>
                                        <div class="body">
                                             <h5 class="medium"><?php echo $this->Html->link($posts[$i]['Page']['title'], SITE_URL.$posts[$i]['Page']['slug'],array('class'=>'blog_name_control')); ?></h5>
                                            <p class="italic post-links">
											<?php
											echo $this->Html->link(($commentcount==0)?$commentcount.' comment':$commentcount.' comments', ($commentcount==0)?'javascript:void(0);':SITE_URL.$posts[$i]['Page']['slug'].'#comment',array('class'=>'blog_comment_control'));
											?>
											
										   </p>
                                            <p class="blog_summery_control"><?php echo $posts[$i]['Page']['summery'];  ?></p>
                                            <div class="clearfix"></div>
                                            <div class="bot clearfix blog_date_control">
												<div class="date italic">
													<?php echo date("d F Y", strtotime(date("d-m-Y", strtotime($posts[$i]['Page']['created_date'])))); ?>
												</div>
											</div>
                                        </div>
                                        <div class="attached">
                                            <div class="arrow"></div>
                                            <div class="dot"><i class="fa fa-circle main-text-color"></i></div>
                                        </div>
                                    </div>
                                </div>
								<?php } ?>
                            </div>
                            <div class="spine">
                            </div>
							
                        </div>
						<?php } ?>
                     </div>
					 
					<?php echo $this->element('blogpaginator');   } else { ?>
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