<?php 
//pr($testimonial);exit;
	$siteSetting = $this->Session->read('siteSettings');
	//pr($siteSetting);
	$this->assign('title', $postDetails['Page']['title']); 
	$this->assign('meta_title', $postDetails['Page']['metatitle']); 
	$this->assign('meta_keywords', $postDetails['Page']['metakeywords']); 
	$this->assign('meta_description', $postDetails['Page']['metadescription']); 
	$this->assign('image_path', IMGPATH.'cms_image/resize/'.$postDetails['Page']['cms_image']); 
	$this->assign('url_path', SITE_URL.$postDetails['Page']['slug']); 
?>


<?php
if(!empty($siteSetting)){
	if(!empty($siteSetting['SiteSetting']['blogdetail_template'])){
		$mainClass = ($siteSetting['SiteSetting']['blogdetail_template']!='N')?"col-md-8":"col-md-11";
		
		if($siteSetting['SiteSetting']['blogdetail_template'] == "N"){
			$dateClass = "text-center stats hidden-sm hidden-xs col-md-1";
		} else {
			$dateClass = ($siteSetting['SiteSetting']['blogdetail_template']=="R")?"text-center stats hidden-sm hidden-xs col-md-1 main-el":"text-center to-right md stats hidden-sm hidden-xs col-md-1 main-el";
		}
	} else {
		$mainClass = "col-md-11";
		$dateClass = "text-center stats hidden-sm hidden-xs col-md-1";
	}
} else {
	$mainClass = "col-md-11";
	$dateClass = "text-center stats hidden-sm hidden-xs col-md-1";
}

echo (!empty($postDetails))?$this->Layout->pagecrumb('single-post', $postDetails['Page']['title'], $postDetails['Page']['slug']):'';
?>
<!--<div class="pagecrumbs">
	<div class="container">
		<div class="row">
			<div class="col-xs-4">
				<h5 class="medium"><?php echo $postDetails['Page']['title']?></h5>
			</div>
			<div class="col-xs-8">
				<div class="location pull-right">
					<span class="medium">You are here: </span>
					<?php echo $this->Html->link('Home', SITE_URL);?>
					/<?php echo $this->Html->link('Blog', SITE_URL.'blog/');?>
					/ <?php echo $this->Html->link($postDetails['Page']['title'], 'javascript:void();'); ?>
				</div>
			</div>
		</div>
	</div>
</div>-->
<div class="blog-wrapper single">
	<div class="container">
		<div class="row">
			<div class="main-el clearfix">
				<?php
				if(!empty($siteSetting)){
					if(!empty($siteSetting['SiteSetting']['blogdetail_template'])){
						if($siteSetting['SiteSetting']['blogdetail_template']=='L'){
							echo $this->element('blogsidebar');
						}
					}
				}
				?>
				<div class="<?php echo $dateClass; ?>">
					<div class="date blog_date_control">
						<div class="day light main-text-color"><?php echo date("d", strtotime(date("d-m-Y", strtotime($postDetails['Page']['created_date'])))); ?></div>
						<div class="month"><?php echo date("F", strtotime(date("d-m-Y", strtotime($postDetails['Page']['created_date'])))); ?></div>
					</div>
				</div>
				<div class="<?php echo $mainClass; ?>">
					<div class="item active">
						<div class="image">
							<?php echo $this->Html->image(IMGPATH.'cms_image/resize/'.$postDetails['Page']['cms_image'], array('alt'=>$postDetails['Page']['title'], 'class'=>'img-responsive','style'=>'width:inherit;')); ?>
						</div>
						
						<!-- Go to www.addthis.com/dashboard to customize your tools -->
						<div class="addthis_sharing_toolbox"></div>
					</div>
					<h3 class="blog_name_control"><?php echo $postDetails['Page']['title']?></h3>

					<p class="blog_comment_control"> <?php echo $postDetails['Page']['content']?>  </p>

					<div id="comment" class="sep-line"></div>


					<div class="row post-accordion">
						<div class="col-md-12">
							<h4 class="blog_name_control">Latest Blog</h4>
						</div>
						<?php 
						$latestPosts = $this->SideBars->latestPosts(); 
						//pr($latestPosts); //exit(); 
						
						foreach($latestPosts as $latpost){
						?>
						<div class="col-md-3 col-sm-6 main-el">
							<div class="post-thumb" data-toggle="tooltip" data-placement="bottom" title="<?php echo $latpost['Page']['title']; ?>">
								<div class="photo">
									<div class="overlay">
									
									<?php echo $this->Html->link('<i class="fa fa-share md"></i>', SITE_URL.$latpost['Page']['slug'],array('escape'=>false)); ?>
									</div>
									<?php echo $this->Html->image(IMGPATH.'cms_image/resize/'.$latpost['Page']['cms_image'], array('alt'=>$latpost['Page']['title'], 'class'=>'img-responsive')); ?>
								</div>
							</div>
						</div>

						<?php }  ?>
					
					</div>

					<div class="sep-line"></div> 
					
					<?php if(count($comments)>0){ ?>
					<div class="comment-section">
						<h4 ><?php echo count($comments); ?> comments</h4>
						<?php foreach($comments as $commentarr){ ?>									
						<div class="comment-wrap">
							<div class="comment">
							<?php echo $this->Html->image(SITE_URL.'img/commenter-1.png', array('alt'=>'commentuser', 'class'=>'img-responsive avatar')); ?>
								
								<div class="textblock">
								<?php echo $this->Html->link('Reply <i class="fa fa-play-circle-o"></i>','javascript:void(0)',array('escape'=>false,'class'=>'main-text-color reply reply_link', 'data-comment-id'=>$commentarr['PostComment']['id'])); ?>
									<div class="author">
										<?php echo $commentarr['PostComment']['name']; ?> says:
									</div>
									<div class="time"><?php echo $commentarr['PostComment']['comment_date']; ?><!--March 23, 2013 at 7:58 pm --></div>
									<div class="text">
								   <?php echo $commentarr['PostComment']['comment']; ?>
									</div>
								</div>
							</div>
							
							<?php if(count($commentarr['Reply'])>0){ ?> 
							<?php foreach($commentarr['Reply'] as $replyarr){ ?>
							<div class="comment-wrap">
								<div class="comment">
									<?php echo $this->Html->image(SITE_URL.'img/commenter-default.png', array('alt'=>'commentreply', 'class'=>'img-responsive avatar')); ?>
									<div class="textblock">
									<?php echo $this->Html->link('Reply <i class="fa fa-play-circle-o"></i>','javascript:void(0)',array('escape'=>false,'class'=>'main-text-color reply reply_link', 'data-comment-id'=>$replyarr['comment_id'])); ?>
										 
										<div class="author">
										   <?php echo $replyarr['name']; ?> says:
										</div>
										<div class="time"><?php echo $replyarr['reply_date']; ?>   <!--March 23, 2013 at 7:58 pm --></div>
										<div class="text">
										<?php echo $replyarr['reply']; ?>
										</div>
									</div>
								</div>
						   </div>
							<?php } ?>
							<?php } ?>
							
						</div>
						<?php } ?>
						
					</div>
					<?php } ?>
					<div class="sep-line"></div>
				
					<div class="form-3" id="comment_form">

						<h4 class="blog_heading_control">Leave a Comment</h4>
						<p class="blog_heading_control">Your email address will not be published</p>

						<div class="form-3 main-el">
							<div id="coment-msg"></div>
							<?php echo $this->Form->create('PostComment', array('id'=>'commentForm','inputDefaults' => array('type'=>'post','required' => false, 'label' => false,'div' => false))); ?>
							<div class="row">
								<div class="col-sm-6">
								<?php echo $this->Form->input('name',array('id'=>"name",'class'=>"form-control",'div'=>false,'placeholder'=>'Name', 'label'=>false, 'type'=>'text')); ?>
								</div>

								<div class="col-sm-6">
								<?php  echo $this->Form->input('email',array('id'=>"contacts-email",'class'=>"form-control",'div'=>false,'placeholder'=>'Email', 'label'=>false, 'type'=>'text')); ?>
								</div>

								<div class="col-xs-6">
								<?php echo $this->Form->textarea('comment',array('id'=>"contacts-message", 'class'=>"form-control",'div'=>false, 'placeholder'=>'Comment', 'label'=>false)); ?>

									<div class="btns">
									<?php 
									echo $this->Form->input('post_id', array('type'=>'hidden', 'value'=>$postDetails['Page']['id']));
									echo $this->Form->button('<div class="over"><i class="fa fa-plane"></i> Post a Comment</div>', array('escape'=>false, 'type' => 'submit', 'class'=>"button solid blue sm blog_button_control blog_button_backgound")); 
									?>
									 
									<div class="to-right ajaxLayout" style="display:none;">
									<?php echo $this->Html->image(SITE_URL.'img/loader.gif', array('alt'=>'Loadgif')); ?>
									</div>
									</div>
								</div>

								<div class="col-sm-6">
									<div id="RecaptchaField1"></div>
									<span class="captcha-required"></span>
								</div>

							</div>
							<?php  echo $this->Form->end(); ?>
						</div>
					</div>
		
					<!-- Comment Reply -->
					<div style="display:none;" id="reply_form" class="form-3">
						<h3 class="blog_heading_control">Leave a Reply 
							<div class="pull-right">
							<?php echo $this->Html->link('&times','javascript:void(0);', array('escape'=>false, 'class'=>'btn red reply_form_close')); ?>
							</div>
						</h3>
						
						<div class="form-3 main-el">
							<div id="reply-msg"></div>
						
						
						<?php echo $this->Form->create('Reply', array('id'=>'replyForm','inputDefaults' => array('type'=>'post','required' => false, 'label' => false,'div' => false))); ?>
						<div class="row">
						
							<div class="col-md-6">
							<?php echo $this->Form->input('name',array('type'=>'text','placeholder'=>'Name', 'class'=>"form-control",'div'=>false, 'label'=>false)); ?>
							</div>

							<div class="col-md-6">
							<?php echo $this->Form->input('email', array('type' => "text",'placeholder'=>'Email', 'class'=>"form-control")); ?>
							</div>

							<div class="col-md-6">
							<?php echo $this->Form->input('reply', array('type' => "textarea",'placeholder'=>'Reply', 'class'=>"form-control",'rows'=>'8')); ?>
								<div class="btns">
								<?php 
								echo $this->Form->input('post_id', array('type'=>'hidden', 'value'=>$postDetails['Page']['id']));
								echo $this->Form->input('comment_id', array('type'=>'hidden','id'=>'comment_id'));
								echo $this->Form->button('Post a Reply', array('type' => 'submit', 'class'=>"btn btn-primary blog_button_control blog_button_backgound")); 
								?>
								
								<div class="to-right" id="rplyWaitingDiv" style="display:none;">
								<?php echo $this->Html->image(SITE_URL.'img/loader.gif', array('alt'=>'Loadgif')); ?>
								</div>
								</div>
							</div>
						
							<div class="col-md-6">
								<div id="RecaptchaField2"></div>
								<span class="captcha-required"></span>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
						</div>
					</div>
					<!-- Comment Reply -->
		
		
				</div>
				<?php
				if(!empty($siteSetting)){
					if(!empty($siteSetting['SiteSetting']['blogdetail_template'])){
						if($siteSetting['SiteSetting']['blogdetail_template']=='R'){
							echo $this->element('blogsidebar');
						}
					}
				}
				?>
			</div>

		</div>
	</div>
</div>
<script type="text/javascript">
$(function(){
	
	$('.reply_link').click(function(e){
	
		e.preventDefault();
		$('#comment_id').val($(this).attr('data-comment-id'));
		$('#comment_form').hide();
		$('#reply_form').show();
		
		$('html, body').animate({
			scrollTop: $('#reply_form').offset().top
		}, 20);
	});
	$('.reply_form_close').click(function(e){
		e.preventDefault();
		$('#comment_id').val('');
		$('#reply_form').hide();
		$('#comment_form').show();
		
		$('html, body').animate({
			scrollTop: $('#comment_form').offset().top
		}, 20);
	});
	
	var form3 = $('#commentForm');
	form3.validate({
		rules: {
			'data[PostComment][name]': {
				required: true
			},
			'data[PostComment][email]': {
				required: true,email: true
			},
			'data[PostComment][comment]': {
				required: true
			}
		}
	});
	form3.submit(function(e){
		e.preventDefault();
		if(form3.valid()){
			var captcha = $('#commentForm [name="g-recaptcha-response"]').val();
			var formData = $(this).serialize();
			if(captcha!=""){
			
				$.ajax({
					type:'POST',
					url:'<?php echo $this->Html->url(array('controller'=>'PostComments','action'=>'ajaxPostcomment')); ?>',
					data:formData,
					beforeSend : function(res){
						$(".ajaxLayout").show(); 
					},
					complete: function() {
						$(".ajaxLayout").hide(); 
					},
					success:function(result)
					{
						if(result == 5)
						{
							$('#coment-msg').html('<div class="alert alert-success border">Comment submitted, awaiting for moderation.</div>');
							$('#commentForm')[0].reset();
							grecaptcha.reset();
						} else if(result == 4) {
							$('#coment-msg').html('<p class="error_msg">Failed to submit your reply.</p>');
							grecaptcha.reset();
						} else if(result == 3) {
							$('#coment-msg').html('<p class="error_msg">Please fill all required fields.</p>');
						} else if(result == 2) {
							$('#coment-msg').html('<p class="error_msg">Please enter correct captcha.</p>');
							grecaptcha.reset();
						} else if(result == 1){
							$('#coment-msg').html('<p class="error_msg">Please submit the reply form</p>');
							grecaptcha.reset();
						}
					}
				});
			} else {
				$('.captcha-required').text('This field is required');
			}
		}
	});
	
	$('#coment-msg').click(function(e){
		e.preventDefault();
		$(this).find('div').remove();
	});
	
	//Reply Form-
	var form4 = $('#replyForm');
	form4.validate({
		rules: {
			'data[Reply][name]': {
				required: true
			},
			'data[Reply][email]': {
				required: true,email: true
			},
			'data[Reply][reply]': {
				required: true
			}
		}
	});
	form4.submit(function(e){
		e.preventDefault();
		if(form4.valid()){
			var captcha = $('#replyForm [name="g-recaptcha-response"]').val();
			var formData = $(this).serialize();
			if(captcha!=""){
			
				$.ajax({
					type:'POST',
					url:'<?php echo $this->Html->url(array('controller'=>'Replies','action'=>'ajaxPostreply')); ?>',
					data:formData,
					beforeSend : function(res){
						$("#rplyWaitingDiv").show(); 
					},
					complete: function() {
						$("#rplyWaitingDiv").hide(); 
					},
					success:function(result)
					{
						if(result == 5)
						{
							$('#reply-msg').html('<div class="alert alert-success border">Reply submitted, awaiting for moderation..</div>');
							$('#replyForm')[0].reset();
							grecaptcha.reset();
						} else if(result == 4) {
							$('#reply-msg').html('<p class="error_msg">Failed to submit your comment.</p>');
							grecaptcha.reset();
						} else if(result == 3) {
							$('#reply-msg').html('<p class="error_msg">Please fill all required fields.</p>');
						} else if(result == 2) {
							$('#reply-msg').html('<p class="error_msg">Please enter correct captcha.</p>');
							grecaptcha.reset();
						} else if(result == 1){
							$('#reply-msg').html('<p class="error_msg">Please submit the comment form</p>');
							grecaptcha.reset();
						}
					}
				});
			} else {
				$('.captcha-required').text('This field is required');
			}
		}
	});
	
	$('#reply-msg').click(function(e){
		e.preventDefault();
		$(this).find('div').remove();
	});
});
</script>