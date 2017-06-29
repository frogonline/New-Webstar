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
				<h5 class="medium">Search results for: <?php// echo $slug; ?></h5>
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
</div>  -->
<?php
}
?>
<div class="content">
<div class="container">
	<div class="row">
		
		<?php if(!empty($posts)){ ?>
		<?php echo $this->Form->input('pageno',array("type"=>"hidden","label"=>false,"id"=>"pageno","value"=> '2')); ?>
		
		<div class="blog-wrapper isotope-container grid main-el">
			<?php 
				$result = count($posts);
				$i=0;
			foreach($posts as $postarr){  
				$commentcount=count($postarr['PostComment']); 
				 $commentcount=count($postarr['PostComment']); 
				if($i!=2)
				{
			?>
			<div class="col-sm-6 element-wrap isotope-element isotope-item">
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
					<div class="body shop-box-background shop-box-text blog_box_backgound">
						<h5 class="medium">
						<?php echo $this->Html->link($postarr['Page']['title'], SITE_URL.$postarr['Page']['slug'],array('class'=>'blog_name_control')); ?></h5>
						<p class="italic post-links">
							<?php
							echo $this->Html->link(($commentcount==0)?$commentcount.' comment':$commentcount.' comments', ($commentcount==0)?'javascript:void(0);':SITE_URL.$postarr['Page']['slug'].'#comment',array('class'=>'blog_comment_control'));
							?>
							
						</p>
						<p class="blog_summery_control"><?php echo $postarr['Page']['summery'];  ?></p>
						<div class="clearfix"></div>
						<div class="bot clearfix shop-box-background shop-box-text">
							<div class="date italic blog_date_control">
								<?php echo date("d F Y", strtotime(date("d-m-Y", strtotime($postarr['Page']['created_date'])))); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php $i++; } } ?>
		</div>
		
		<?php if($result==3){ ?>
		<div class="row" id="postapp">
				<div class="load inside col-md-12">
				<?php
				
				echo $this->Html->link('<div class="over"><span class="loadtext">load more</span><div class="ajax-preloader" id="loadmoreicon">'.$this->Html->image(IMGPATH1.'button-loader.gif', array('alt'=>'loading..')).'</div></div>', 'javascript:void(0);', array('escape'=>false, 'class'=>'button blue solid md', 'id'=>'post-loadmore'));
				?>
				</div>
				
		</div>
		<div class="alert alert-noicon" id="Folks" style="display:none"><center>That's All Folks! </center></div>
		<?php } ?>
		
		
		<?php     } else { ?>
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

<script>
$('#post-loadmore').click(function(){
	var pageno=$('#pageno').val();
	if(pageno<1)
	{
	  
	}
	else
	{
	$('#loadmoreicon').show();
	  $('.loadtext').hide();
	  $.ajax({
			type:'POST',
			url:'<?php echo $this->Html->url(array('controller'=>'Posts','action'=>'ajaxpostlist2c','full_base'=>true)); ?>',
			data:{pageno:pageno},
			success:function(result){
			   $('#loadmoreicon').hide();
			   $('.loadtext').show();
			   var resultarr=result.split("pabitrapagination"); 
			   $('#postapp').prepend(resultarr['0']);
			   var pageno=$('#pageno').val(resultarr['1']);
			   if(resultarr['1']<1)
			   {
				$('#Folks').show();
				$('#post-loadmore').hide();
			  
			   
			     
			   }
			
			
				//$('#pageno').val(result);
				
			}
		});
	}
	
	
	
	
});

</script>