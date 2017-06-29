<div class="blog-wrapper isotope-container grid main-el" style="display:block !important">
<?php 

foreach($postdata as $postdataArr){ 
 $commentcount=count($postdataArr['PostComment']);  
?>

<div class="col-sm-4 element-wrap isotope-element isotope-item">
	<div class="element">
		<div class="head">
		<?php if($postdataArr['Page']['cms_image']!=''){ ?>
			<div class="image">
				<div class="overlay">
				<?php
				echo $this->Html->link('<i class="fa fa-share md"></i>', SITE_URL.$postdataArr['Page']['slug'], array('escape'=>false));
				?>
				</div>
				<?php echo $this->Html->image(IMGPATH.'cms_image/resize/'.$postdataArr['Page']['cms_image'], array('alt'=>$postdataArr['Page']['title'], 'class'=>'img-responsive')); ?>
			</div>
		<?php } ?>
		</div>
		<div class="body shop-box-background shop-box-text">
			<h5 class="medium">
			<?php echo $this->Html->link($postdataArr['Page']['title'], SITE_URL.$postdataArr['Page']['slug']); ?>
			</h5>
			<p class="italic post-links">
				<?php
				echo $this->Html->link(($commentcount==0)?$commentcount.' comment':$commentcount.' comments', ($commentcount==0)?'javascript:void(0);':SITE_URL.$postdataArr['Page']['slug'].'#comment');
				?>
				
			</p>
			<p><?php echo $postdataArr['Page']['summery'];  ?></p>
			<div class="clearfix"></div>
			<div class="bot clearfix shop-box-background shop-box-text">
				<div class="date italic">
					<?php echo date("d F Y", strtotime(date("d-m-Y", strtotime($postdataArr['Page']['created_date'])))); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php  } ?> 
</div>
<?php

$currentpageno=$pageno;
$nextpageno=(($currentpageno*1)+1);
 if(count($postdata)<3): 

$nextpageno=0;

 endif; 
 
 echo 'pabitrapagination'.$nextpageno;
