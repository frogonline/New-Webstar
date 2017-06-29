<div class="container">
	<div class="row">

		<div class="ajax-page-preloader" style="position: relative;">
			<div class="loader spinner">
				<?php echo $this->Html->image(CURRENT_THEME_URL.'img/loader.gif', array('width'=>'24', 'height'=>'24')); ?>	
			</div>
		</div>
		
		<?php if(!empty($blog)){ ?>
		<div class="blog-wrapper isotope-container grid main-el">
			<?php 
			foreach($blog as $postarr){  
				$commentcount=count($postarr['PostComment']); 
			?>
			<div class="col-md-3 col-sm-6 element-wrap isotope-element">
				<div class="element">
					<div class="head">
					<?php if($postarr['Page']['cms_image']!=''){ ?>
						<div class="image">
							<div class="overlay">
							<?php 
							if($postarr['Page']['type'] == 'Post'){
							echo $this->Html->link('<i class="fa fa-share md"></i>', SITE_URL.$postarr['Page']['slug'], array('escape'=>false));
							}
							?>
							</div>
							<?php 
							if($postarr['Page']['type'] == 'Post'){
							echo $this->Html->image(IMGPATH.'cms_image/resize/'.$postarr['Page']['cms_image'], array('alt'=>$postarr['Page']['title'], 'class'=>'img-responsive')); 
							}
							?>
						</div>
					<?php } ?>
					</div>
					<div class="body">
						<h5 class="medium"><?php echo $this->Html->link($postarr['Page']['title'], SITE_URL.$postarr['Page']['slug'], array('escape'=>false)); ?></h5>
						<p class="italic post-links">
							<?php
							if($postarr['Page']['type'] == 'Post'){
							echo $this->Html->link(($commentcount==0)?$commentcount.' comment':$commentcount.' comments', ($commentcount==0)?'javascript:void(0);':SITE_URL.$postarr['Page']['slug'].'#comment');
							}
							?>
							
						</p>
						<?php
							$text1 = String::truncate($postarr['Page']['summery'],150,
																		array('exact' => false)
																		);
						?>
						<p><?php echo $text1 ;  ?></p>
						<div class="clearfix"></div>
						<div class="bot clearfix">
							<div class="date italic">
								<?php echo date("d F Y", strtotime(date("d-m-Y", strtotime($postarr['Page']['created_date'])))); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } ?> 
		</div>
		<?php   //echo $this->element('paginator');   
		} else { ?>
		<div class="alert alert-noicon sc">
			<div class="text col-md-12 col-sm-7">
				<center><strong>No search result found.</strong></center>
			</div>
			<div class="clearfix"></div>
		</div>
		<?php } ?>
	</div>
</div>