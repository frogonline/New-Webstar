<?php
App::uses('String', 'Utility');

class ShortCodeHelper extends AppHelper {
	var $helpers = array('Cache','Html','Session','Form','Paginator','MenuitemMasters','Text','Js'=>'Jquery','Layout','Sidebars');
	
	public function short_code($all_short_code) {
	  
	   
       foreach($all_short_code as $k=>$short_code)
	   {
			$short_code_type = explode("-",$short_code);
			if($short_code_type[0] == 'gallery')
			{
				App::import('Model','GalleryManagement');
				$gallerymodel = new GalleryManagement();
	   
				$gallerymodel->bindModel(
					array('hasMany' => array(
							'GalleryImage' => array(
								'className' => 'GalleryImage',
								'foreignKey'=>'gallery_management_id'
							)
						)
					)
				);
				$gallery_array = $gallerymodel->findById($short_code_type[1]);
				//pr($gallery_array);
				if(!empty($gallery_array)){
					$content[$k] = ($gallery_array['GalleryManagement']['headingfrontend_flag']=='Y')?
									'<div class="sep-heading-container shc4 clearfix">
										<h4>'.$gallery_array['GalleryManagement']['name'].'</h4>
										<div class="sep-container">
											<div class="the-sep"></div>
										</div>
									</div>':'';
				} else {
					$content[$k] = '';
				}
				
				if(!empty($gallery_array) && $gallery_array['GalleryManagement']['style']=='style1')
				{
					$content[$k] .= '<div class="row recent-work margin-bottom-40">
									  <div class="col-md-3">
										<h2><a href="portfolio.html">'.$gallery_array['GalleryManagement']['name'].'</a></h2>
										<p>'.$gallery_array['GalleryManagement']['title'].'</p>
									  </div>
									  <div class="col-md-9">
										<div class="owl-carousel owl-carousel3">';
										foreach($gallery_array['GalleryImage'] as $gimage)
										{
										  $content[$k] .= '<div class="recent-work-item">
											<em>
											  <img src="'.IMGPATH.'gallery_image/resize/'.$gimage['gallery_image_name'].'" alt="Amazing Project" class="img-responsive">
											  <a href="portfolio-item.html"><i class="fa fa-link"></i></a>
											  <a href="'.IMGPATH.'gallery_image/resize/'.$gimage['gallery_image_name'].'" class="fancybox-button" title="Project Name #1" data-rel="fancybox-button"><i class="fa fa-search"></i></a>
											</em>
											<a class="recent-work-description" href="#">
											  <strong>Amazing Project</strong>
											  <b>Agenda corp.</b>
											</a>
										  </div>';
										}
										  
										$content[$k] .= '</div>       
									  </div>
									</div>';
				}
				else if(!empty($gallery_array) && $gallery_array['GalleryManagement']['style']=='style2')
				{
					$content[$k] .= '<div class="row margin-bottom-40 our-clients">
										<div class="col-md-3">
											<h2><a href="#">'.$gallery_array['GalleryManagement']['name'].'</a></h2>
											<p>'.$gallery_array['GalleryManagement']['title'].'</p>
										</div>
										<div class="col-md-9">
											<div class="owl-carousel owl-carousel6-brands">';
											if(!empty($gallery_array['GalleryImage'])){
												foreach($gallery_array['GalleryImage'] as $gimage){

												$content[$k] .= '<div class="client-item">

													<img src="'.IMGPATH.'gallery_image/resize/'.$gimage['gallery_image_name'].'" alt="Client" class="img-responsive">
													<img src="'.IMGPATH.'gallery_image/resize/'.$gimage['gallery_image_name'].'" alt="Client" class="color-img img-responsive">
												</div>';
											
												}
											}

											$content[$k] .= '</div>
										</div>          
									</div>';
				}
				else if(!empty($gallery_array) && $gallery_array['GalleryManagement']['style']=='style3')
				{
					$content[$k] .= '<div class="brands">
									  <div class="container">
											<div class="owl-carousel owl-carousel6-brands">';
											if(!empty($gallery_array['GalleryImage'])){
												foreach($gallery_array['GalleryImage'] as $gimage){

												$content[$k] .= '<a href="#"><img src="'.IMGPATH.'gallery_image/resize/'.$gimage['gallery_image_name'].'" alt="canon" title="canon"></a>';
											
												}
											}
											  
											  
											$content[$k] .= '</div>
										</div>
									</div>';
				}
				else if(!empty($gallery_array) && $gallery_array['GalleryManagement']['style']=='style4')
				{
					$content[$k] .= '<div class="gallery preview">
										<div class="navigation">
											<div class="thumb mgp-gal">
												<div class="img-container">
													<div class="images clearfix">';
											if(!empty($gallery_array['GalleryImage'])){
												foreach($gallery_array['GalleryImage'] as $gimage){

												$content[$k] .= '
													<div class="frame" data-toggle="tooltip" data-preview="'.IMGPATH.'gallery_image/resize/'.$gimage['gallery_image_name'].'" title="">
														<div class="image">
															<a class="overlay" href="'.IMGPATH.'gallery_image/resize/'.$gimage['gallery_image_name'].'">
																<i class="fa fa-search sm"></i>
															</a>
															<img src="'.IMGPATH.'gallery_image/resize/'.$gimage['gallery_image_name'].'" class="img-responsive" alt="">
														</div>
													</div>';
											
												}
											}
											  
											  
											$content[$k] .= '</div>
														</div>
													</div>
												</div>
											<div class="clearfix"></div></div>';
				}
				else if(!empty($gallery_array) && $gallery_array['GalleryManagement']['style']=='style5')
				{
					$content[$k] .= '<div class="parteners carousel content">
										<div class="container">
											<div class="feed cycle-slideshow" data-cycle-carousel-fluid="true" data-cycle-fx="carousel" data-cycle-timeout="2000">';
											if(!empty($gallery_array['GalleryImage'])){
												foreach($gallery_array['GalleryImage'] as $gimage){

												$content[$k] .= '
													<img src="'.IMGPATH.'gallery_image/resize/'.$gimage['gallery_image_name'].'" class="img-responsive" alt="" data-toggle="tooltip" title="">';
											
												}
											}
											  
											  
											$content[$k] .= '</div>
														</div>
													</div>';
				}
				else
				{
					$content[$k] ='';
				}
				
			}
			else if($short_code_type[0] == 'twitter')
			{
				App::import('Model','Twitter');
				$twittermodel = new Twitter();
				
				$twitter_array = $twittermodel->find('first');
				
				$content[$k] = '<a class="twitter-timeline" data-chrome="noheader nofooter noscrollbar noborders transparent" data-link-color="#57C8EB" data-theme="dark" data-tweet-limit="'.$twitter_array['Twitter']['limit'].'" data-widget-id="'.$twitter_array['Twitter']['twiiter_appid'].'" href="https://twitter.com/twitterapi">Loading tweets...</a>';
			}
			else if($short_code_type[0] == 'Search')
			{
				
				$content[$k] = '<div class="sep-heading-container shc4 clearfix"><h4>Search Widget</h4><div class="sep-container"><div class="the-sep"></div></div></div>'.$this->Form->create('Page', array('url'=>array('controller'=>'Pages','action'=>'form_search')),array('id'=>"form-search", 'class'=>"form-search", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))).'<div class="input-group">'.$this->Form->input('input',array('id'=>"input", 'class'=>"form-control",'label'=>false, 'empty'=>false, 'placeholder'=>"Start typing here...")).'<span class="input-group-btn">'.$this->Form->button('<i class="fa fa-search"></i>', array('class'=>"btn btn-default", 'escape'=>false, 'type'=>"submit")).'</span></div>'.$this->Form->end();
			}
			else if($short_code_type[0] == 'Contact')
			{
				App::import('Model','ContactWidget');
				$ContactWidget = new ContactWidget();
				
				$ContactWidget_array = $ContactWidget->findByIdAndIsActive($short_code_type[1],'0');
				
				if(!empty($ContactWidget_array)){
				$content[$k] = ($ContactWidget_array['ContactWidget']['headingfrontend_flag']=='Y')?
								'<div class="sep-heading-container shc4 clearfix">
                                    <h4>'.$ContactWidget_array['ContactWidget']['name'].'</h4>
                                    <div class="sep-container">
                                        <div class="the-sep"></div>
                                    </div>
                                </div>':'';
				} else {
					$content[$k] = '';
				}

				if($ContactWidget_array['ContactWidget']['style'] == 'Style1')
				{
					$content[$k] .='<div class="main-el">
					<div class="form form-1 contact-class"><div class="head main-text-color">
									'.$ContactWidget_array['ContactWidget']['text'].'
									</div>'.$this->Form->create('Page', array('id'=>"contact_usform", 'class'=>"contact_usform", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))).
										'<div class="input-group">'.
												$this->Form->input('name',array('id'=>"name",'class'=>"form-control",'div'=>false, 'label'=>false, 'type'=>'text','placeholder'=>"Name *")).
											'<span class="input-group-addon"><i class="fa fa-user"></i></span>
										</div>
										<div class="input-group c-border-top">'.
												$this->Form->input('email',array('id'=>"contacts-email",'class'=>"form-control",'div'=>false, 'label'=>false, 'type'=>'text','placeholder'=>"Email *")).
											'<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
										</div>
										<div class="textarea textarea-icon">
											<i class="fa fa-pencil"></i>'.$this->Form->textarea('message',array('id'=>"contacts-message", 'class'=>"form-control",'div'=>false, 'label'=>false, 'placeholder'=>"Message *")).
										'</div>
										<div class="btns">
											<a class="button solid blue sm">
											<div class="over">'.$this->Form->input('hidden', array('type' => 'hidden','id'=>'hidden','value' => $this->Html->url(array('controller'=>'Pages','action'=>'ajaxContactinfo'), array('full_base'=>true)))).$this->Form->submit('Submit', array('id'=>'button','value'=>'Submit')).'</div></a>
												<a class="clear pull-right">
												Clear All <i class="fa fa-times-circle-o"></i>
												</a><div class="ajaxLayout" align="center" style="display: none;">
												<img src="'.$this->webroot .'img/fb_ajax_loader.gif" />
											</div>
										</div>'.$this->Form->end().
									'<div id="contact_msg"></div></div></div>';
				}
				if($ContactWidget_array['ContactWidget']['style'] == 'Style2')
				{
					$content[$k] .='<div class="form contact-class form-2">'.$this->Form->create('Page', 					array('id'=>"contact_usform", 'class'=>"contact_usform",'inputDefaults' => array('required' => false, 'label' => false,
									'div' =>false))).'
                                <div class="head main-text-color">
                                '.$ContactWidget_array['ContactWidget']['text'].'
                                </div>'.$this->Form->input('name',array('id'=>"name",'class'=>"form-control",'div'=>false, 'label'=>false, 'type'=>'text','placeholder'=>"Name *")).'
                                <div class="c-border-top">'.
									$this->Form->input('email',array('id'=>"contacts-email",'class'=>"form-control",'div'=>false, 'label'=>false, 'type'=>'text','placeholder'=>"Email *")).'
                                </div>'.$this->Form->textarea('message',array('id'=>"contacts-message", 'class'=>"form-control",'div'=>false, 'label'=>false, 'rows'=>"4", 'placeholder'=>"Message *")).$this->Form->input('hidden', array('type' => 'hidden','id'=>'hidden','value' => $this->Html->url(array('controller'=>'Pages','action'=>'ajaxContactinfo'), array('full_base'=>true)))).'
                                <div class="btns">
                                    <a class="button solid blue sm">
										<div class="over">'.$this->Form->submit('Submit', array('id'=>'button','value'=>'Submit','div'=>false)).'</div>
									</a> 
                                </div>
								<div id="contact_msg"></div>
								<div class="ajaxLayout" align="center" style="display: none;">
									<img src="'.$this->webroot .'img/fb_ajax_loader.gif" />
								</div>'
								.$this->Form->end().
                            '</div>';
				}
				if($ContactWidget_array['ContactWidget']['style'] == 'Style3')
				{
					$content[$k] .='<div class="form-3 main-el">
                                <div class="row">'.$this->Form->create('Page', array('id'=>"contact_usform", 'class'=>"contact_usform", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))).'
                                    <div class="col-sm-4">'.$this->Form->input('name',array('id'=>"name",'class'=>"form-control",'div'=>false, 'label'=>false, 'type'=>'text','placeholder'=>"Name *")).'
                                        <!--<input type="text" placeholder="Name *" class="form-control">-->
                                    </div>

                                    <div class="col-sm-4">'.
												$this->Form->input('email',array('id'=>"contacts-email",'class'=>"form-control",'div'=>false, 'label'=>false, 'type'=>'text','placeholder'=>"Email *")).'
                                        <!--<input type="text" placeholder="E-mail *" class="form-control">-->
                                    </div>

                                    <div class="col-sm-4">
                                        <input type="text" id="website" placeholder="Website" class="form-control">
                                    </div>

                                    <div class="col-xs-12">'.$this->Form->textarea('message',array('id'=>"contacts-message", 'class'=>"form-control",'div'=>false, 'label'=>false, 'rows'=>"10", 'placeholder'=>"Message *")).$this->Form->input('hidden', array('type' => 'hidden','id'=>'hidden','value' => $this->Html->url(array('controller'=>'Pages','action'=>'ajaxContactinfo'), array('full_base'=>true)))).'
                                        <!--<textarea placeholder="Message *" rows="10" class="form-control"></textarea>-->
                                        <div class="btns">
                                            <a class="button solid sm blue"><div class="over"><i class="fa fa-plane"></i>'.$this->Form->submit('Submit', array('id'=>'button','value'=>'Submit', 'div'=>false)).'</div></a>
                                            <a class="clear main-text-color pull-right clear">
                                    Clear All <i class="fa fa-times-circle-o"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
								<div class="ajaxLayout" align="center" style="display: none;">
								<img src="'.$this->webroot .'img/fb_ajax_loader.gif" />
								</div>'.$this->Form->end(). '&nbsp;
                           <div id="contact_msg"></div>
						   </div>';
				}			
						
			}
			else if($short_code_type[0] == 'Login')
			{
				
				$content[$k] = '<div class="login-widget">
                            <div class="form form-1">
                                <a class="button solid grey sm login">
                                    <div class="over">login</div>
                                </a>
                                <a class="button solid blue sm register">
                                    <div class="over">register</div>
                                </a>
                                <div class="text-fields">
                                    <div class="input-group">
                                        <input type="text" placeholder="Name *" class="form-control">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    </div>
                                    <div class="input-group c-border-top">
                                        <input type="text" placeholder="Email *" class="form-control">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    </div>
                                </div>
                                <a class="button solid blue full sm">
                                    <div class="over">
										submit
                                    </div>
                                </a>
                            </div>
                        </div>';
			}
			else if($short_code_type[0] == 'LatestPost')
			{
			
			App::import('Model', 'Page');
			$post = new Page();
			$allpost = $post->find('all', array('conditions' => array('Page.controllername'=>'Posts','Page.is_del'=>0),
												'order' => array('Page.id' => 'DESC'),
												'limit' => '3'));
			
			/* pr($allpost);
			exit; */
			
			App::import('Model','LatestPost');
				$LatestPost = new LatestPost();
	   
				$post_array = $LatestPost->findByIdAndIsActive($short_code_type[1],'0');
				//pr($post_array);
				//exit;
				if(!empty($post_array)){
				$content[$k] = ($post_array['LatestPost']['headingfrontend_flag']=='Y')?
								'<div class="sep-heading-container shc4 clearfix">
                                    <h4>'.$post_array['LatestPost']['name'].'</h4>
                                    <div class="sep-container">
                                        <div class="the-sep"></div>
                                    </div>
                                </div>':'';
				} else {
					$content[$k] = '';
				}
						if(!empty($post_array) && $post_array['LatestPost']['style']=='style1')
						{
							$content[$k] .= '<div class="list-group products">';
								foreach($allpost as $posts)
								{
									$content[$k] .= '<a href="'.SITE_URL .$posts['Page']['slug'].'" class="list-group-item">
										<img src="'.IMGPATH .'cms_image/thumb/'.$posts['Page']['cms_image'].'" width="90px" height="40px" class="img-responsive">
										<p class="name">'.$posts['Page']['title'].'</p>
										<p class="price main-text-color">'.date('F d, Y',strtotime($posts['Page']['created_date'])).'</p>
									</a>';
								}
								$content[$k] .='</div>';
						}
						else if(!empty($post_array) && $post_array['LatestPost']['style']=='style2')
						{
							$content[$k] .= '<div class="row">';
							foreach($allpost as $p)
								{
								$content[$k] .= '<div class="col-md-12 event small">
                                <div class="details">
                                    <div class="date bold pull-left">
                                        <div class="day main-text-color">'.date('d',strtotime($p['Page']['created_date'])).'</div>
                                        <div class="month main-bg-color alt-text-color">'.date('M',strtotime($p['Page']['created_date'])).'</div>
                                    </div>
                                    <div class="text">
                                        <h5 class="title medium"><a href="'.SITE_URL.$p['Page']['slug'].'">'.$p['Page']['title'].'</a></h5>';
                                     		App::import('Model', 'PostComment');
											$comm = new PostComment();
											$comment = $comm->find('count', array('conditions' => array('PostComment.status'=>'Y','PostComment.post_id'=>$p['Page']['id']),
																				'order' => array('PostComment.id' => 'DESC')));											
										$content[$k] .= '<p class="italic">'.$comment.' comments</p>
										<div class="time main-text-color">'.date('F d, Y',strtotime($p['Page']['created_date'])).'</div>
                                    </div>
                                </div>
								</div>';
								}
                          $content[$k] .= '</div>';
						}
						else if(!empty($post_array) && $post_array['LatestPost']['style']=='style3')
						{
							$content[$k] .= '<div class="post">';
                                foreach($allpost as $p)
								{								
								   $content[$k] .= '<div class="date pull-left">
								   <div class="day bold main-text-color">'.date('d',strtotime($p['Page']['created_date'])).'</div>
									<div class="bold month alt-text-color main-bg-color">'.date('M',strtotime($p['Page']['created_date'])).'</div>
								</div>
                                <div class="text">
                                    <h5 class="medium"><a href="'.SITE_URL.$p['Page']['slug'].'">'.$p['Page']['title'].'</a></h5>';
										App::import('Model', 'PostComment');
											$comm = new PostComment();
											$comment = $comm->find('count', array('conditions' => array('PostComment.status'=>'Y','PostComment.post_id'=>$p['Page']['id']),
																				'order' => array('PostComment.id' => 'DESC')));
											$text1 = String::truncate($p['Page']['content'],150,
																		array('exact' => false)
																		);		
                                     $content[$k] .= '<p class="comments italic comments">'.$comment.' Comments'.'</p>
                                    <p>'.$text1.' <span class="main-text-color"><a href="'.SITE_URL.$p['Page']['slug'].'">Read More </a><i class="fa fa-play-circle-o"></i> </span> </p>
                                </div>';
								}
                          $content[$k] .= '</div>';
						}
						else if(!empty($post_array) && $post_array['LatestPost']['style']=='style4')
						{
							$content[$k] .= '<div class="row">';
									foreach($allpost as $p)
										{	
										$content[$k] .= '<div class="col-md-4 col-sm-6 main-el">
												<div class="post-thumb"><div class="photo">
											<div class="overlay">
												<i class="fa fa-share md"></i>
											</div>
											<img class="img-responsive" src="'.IMGPATH .'cms_image/thumb/'.$p['Page']['cms_image'].'" alt="">
										</div>';
										$text = String::truncate(
															$p['Page']['content'],
															75,
															array(
																'ellipsis' => '...',
																'exact' => false
															)
														);

										$content[$k] .='<div class="text">
											<h5>'.$p['Page']['title'].'</h5>
											<p class="italic info"><a>'.date('d F',strtotime($p['Page']['created_date'])).'</a></p>
											<p>'.$text.'</p>
											<p class="main-text-color"><a href="'.SITE_URL.$p['Page']['slug'].'">Read More </a><i class="fa fa-play-circle-o"></i> </p>
											</div></div>
											
										</div>';
										}
										$content[$k] .='</div>';
						}
						else if(!empty($post_array) && $post_array['LatestPost']['style']=='style5')
						{
							$content[$k] .= '<div class="blog-wrapper col-md-9 main-el">';
										foreach($allpost as $p)
										{	
												$content[$k] .= '<div class="element row">
													<div class="text-center stats hidden-sm hidden-xs col-md-1">
														<div class="date">
															<div class="day light main-text-color">'.date('d',strtotime($p['Page']['created_date'])).'</div>
															<div class="month">'.date('F',strtotime($p['Page']['created_date'])).'</div>
														</div>
														<!--<div class="likes">
															<a> <i class="fa fa-heart"></i> </a>
															<div class="amount">735</div>
														</div>
														<div class="share">
															<i class="fa fa-share">
																<span class="socials">
																	<a class="pinterest" href="../#"> <i class="fa fa-pinterest"></i> </a>
																	<a class="gplus" href="../#"> <i class="fa fa-google-plus"></i> </a>
																	<a class="twitter" href="../#"> <i class="fa fa-twitter"></i> </a>
																	<a class="facebook" href="../#"> <i class="fa fa-facebook"></i> </a>
																</span>
															</i>

															<div>Share</div>
														</div>-->
													</div>';
													
													App::import('Model', 'PostComment');
													$comm = new PostComment();
													$comment = $comm->find('count', array('conditions' => array('PostComment.status'=>'Y','PostComment.post_id'=>$p['Page']['id']),								'order' => array('PostComment.id' => 'DESC')));
													$text1 = String::truncate($p['Page']['content'],350,
													array('exact' => false)
													);
										
													$content[$k] .= '<div class="col-md-11">
														<div class="image">
															<a href="'.SITE_URL.$p['Page']['slug'].'"><div class="overlay">
																<i class="fa fa-share md"></i>
															</div></a>
															<img src="'.IMGPATH .'cms_image/resize/'.$p['Page']['cms_image'].'" class="img-responsive" alt="">
														</div>
														<div class="body">
															<h3><a>'.$p['Page']['title'].'</a></h3>
															<p class="italic post-links"><a>'.$comment.' Comments</a></p>
															<p class="text">'.$text1.'
																<span class="read-link main-text-color"><a href="'.SITE_URL.$p['Page']['slug'].'">Read More </a><i class="fa fa-play-circle-o"></i></span> </p>

														</div>
													</div>
													<div class="col-md-11 col-md-offset-1">
														<div class="sep-line"></div>
													</div>
												</div>';

										}		
												
												$content[$k] .= '
											</div>';
						}
						else if(!empty($post_array) && $post_array['LatestPost']['style']=='style6')
						{
							$content[$k] .= '<div class="post-acc" id="#post-accordion-1">
                        <div class="elements row hidden-sm hidden-xs">';
						
						foreach($allpost as $p){
						App::import('Model', 'PostComment');
													$comm = new PostComment();
													$comment = $comm->find('count', array('conditions' => array('PostComment.status'=>'Y','PostComment.post_id'=>$p['Page']['id']),
																											'order' => array('PostComment.id' => 'DESC')));
													$text2 = String::truncate($p['Page']['content'],100,
													array('exact' => false)
													);
										
                            $content[$k] .='<div class="col-md-6 element">
                                <div class="row">
                                    <a class="col-xs-6">
                                        <div class="post-thumb">
                                            <div class="photo">
                                                <div class="overlay">
                                                    <i class="fa fa-share md"></i>
                                                </div>
                                                <img class="img-responsive" src="'.IMGPATH .'cms_image/resize/'.$p['Page']['cms_image'].'" width="175" height="575" alt="">
                                            </div>
                                        </div>
                                    </a>

                                    <div class="col-xs-6">
                                        <div class="post-thumb">
                                            <div class="text box-text">
                                                <h5>'.$p['Page']['title'].'</h5>
                                                <p class="italic info"><a>'.date('d F',strtotime($p['Page']['created_date'])).'</a></p>
                                                <p>'.$text2.'</p>
                                                <p class="main-text-color"><a href="'.SITE_URL.$p['Page']['slug'].'">Read More </a><i class="fa fa-play-circle-o"></i> </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
							}
							$content[$k] .= '</div>
						  
							</div>';
						} 
						else if(!empty($post_array) && $post_array['LatestPost']['style']=='style7')
						{ 
							$content[$k] .= '<div class="list-group">';
							$allPosts = $this->Sidebars->latestPosts();
                            foreach($allPosts as $p)
							{								
								$content[$k] .= $this->Html->link($p['Page']['title'], SITE_URL.$p['Page']['slug'], array('class'=>'list-group-item'));
							}
							$content[$k] .= '</div>';
						} else {
							$content[$k] = '';
						}
			}
			else if($short_code_type[0] == 'contactinfo')
			{
				App::import('Model','SiteSetting');
				$site = new SiteSetting();
				$settings = $site->findById(1);
				
				$content[$k] = '<p>'.$settings['SiteSetting']['address'].'</p>

                            <div class="phone">
                                <span class="bold field">Call: </span><a class="main-text-color">+'.$settings['SiteSetting']['phone'].'</a>
                            </div>

                            <div class="mail">
                                <span class="bold field">Email: </span><a class="main-text-color">'.$settings['SiteSetting']['cc_email'].'</a>
                            </div>';
			}
			else if($short_code_type[0] == 'subscribe')
			{
				
				$content[$k] = '<div class="input-group">
                            <input type="text" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-default fa fa-plane" type="button"></button>
                            </span>
                        </div>';
			}
			else if($short_code_type[0] == 'facebook_widget')
			{
				App::import('Model','SiteSetting');
				$site = new SiteSetting();
				$settings = $site->findById(1);
				
				$content[$k] = '<div class="facebook-frame">
									<div data-show-border="false" data-stream="false" data-header="false" data-show-faces="true" data-colorscheme="light" data-href="'.$settings['SiteSetting']['facebook'].'" class="fb-like-box fb_iframe_widget" fb-xfbml-state="rendered" fb-iframe-plugin-query="app_id=&amp;color_scheme=light&amp;container_width=241&amp;header=false&amp;href=https%3A%2F%2Fwww.facebook.com%2Fzebracateringcluj&amp;locale=en_GB&amp;sdk=joey&amp;show_border=false&amp;show_faces=true&amp;stream=false">
										<span style="vertical-align: bottom; width: 300px; height: 241px;">
											'.$settings['SiteSetting']['likebox_url'].'
										</span>
									</div>
								</div>';
			}
			else if($short_code_type[0] == 'Accordion')
			{
				App::import('Model','Accordion');
				$accordion_model = new Accordion();
	   
				$accordion_model->bindModel(
					array('hasMany' => array(
							'AccordionContent' => array(
								'className' => 'AccordionContent',
								'foreignKey'=>'accordion_id',
								'conditions'=>array('AccordionContent.isdel'=>'0','AccordionContent.status'=>'Y'),
							)
						)
					)
				);
				$accordion_array = $accordion_model->findByIdAndIsdelAndStatus($short_code_type[1],'0','Y');
				
				/* pr($accordion_array);
				exit; */
				if(!empty($accordion_array)){
					$content[$k] = ($accordion_array['Accordion']['headingfrontend_flag']=='Y')?
									'<div class="sep-heading-container shc4 clearfix">
										<h4>'.$accordion_array['Accordion']['name'].'</h4>
										<div class="sep-container">
											<div class="the-sep"></div>
										</div>
									</div>':'';
				} else {
					$content[$k] = '';
				}
				
				if(isset($accordion_array['Accordion']) && $accordion_array['Accordion']['style']=='style3')
				{
					$content[$k] .= '<ol class="breadcrumb accordion-filter" id="accordion-4-filters">
									<li class="active filter" data-filter="all">All</li>';
						$check_prev='';
						foreach($accordion_array['AccordionContent'] as $accordion_content)
						{
							if($accordion_content['category']!=$check_prev)
							{
								$content[$k] .='<li class="filter" data-filter="'.$accordion_content['category'].'">'.$accordion_content['category'].'</li>';
							}
							$check_prev = $accordion_content['category'];
						}
                    $content[$k] .='</ol>';
					
                    $content[$k] .='<div class="panel-group accordion filter-panel" id="accordion-4">';
							$i=1;
							foreach($accordion_array['AccordionContent'] as $accordion_content)
							{
                                    $content[$k] .='<div class="panel panel-default '.$accordion_content['category'].'">
                                        <div class="panel-heading alt-bg-color box-background">
                                            <h6 class="panel-title">
                                                <a data-toggle="collapse" class="collapsed box-text" data-parent="#accordion-4" href="#acc-4-'.$i.'">
                                                    <i class="fa box-text"></i>
													'.$accordion_content['title'].'
                                                </a>
                                            </h6>
                                        </div>
                                        <div id="acc-4-'.$i.'" class="panel-collapse collapse">
                                            <div class="panel-body box-background">
                                                <p class="box-text">
													'.$accordion_content['content'].'
                                                </p>
                                            </div>
                                        </div>
                                    </div>';
								$i++;
							}
					$content[$k] .='</div>';
                                    
				
				}
				elseif(isset($accordion_array['Accordion']) && $accordion_array['Accordion']['style']=='style1')
				{
					$content[$k].='<div class="panel-group accordion" id="accordion-'.$accordion_array['Accordion']['id'].'">';
						$i=1;
						foreach($accordion_array['AccordionContent'] as $accordion_content)
						{
                            $content[$k] .='<div class="panel panel-default">
                                        <div class="panel-heading box-background alt-bg-color">
                                            <h6 class="panel-title">
                                                <a class="collapsed box-text" data-toggle="collapse" data-parent="#accordion-'.$accordion_array['Accordion']['id'].'" href="#acc-'.$accordion_array['Accordion']['id'].'-'.$i.'">
                                                    <i class="fa box-text"></i>
														'.$accordion_content['title'].'
                                                </a>
                                            </h6>
                                        </div>
                                        <div id="acc-'.$accordion_array['Accordion']['id'].'-'.$i.'" class="panel-collapse collapse box-text">
                                            <div class="panel-body box-background">
                                                <p class="box-text">
													'.$accordion_content['content'].'
                                                </p>
                                            </div>
                                        </div>
                                    </div>';
							$i++;
						}
					$content[$k].='</div>';
                                    
				}
				elseif(isset($accordion_array['Accordion']) && $accordion_array['Accordion']['style']=='style2')
				{
					$content[$k].='<div class="panel-group accordion" id="accordion-3">';
					
						$i=1;
						foreach($accordion_array['AccordionContent'] as $accordion_content)
						{
                            $content[$k] .='<div class="panel panel-default">
                                        <div class="panel-heading box-background alt-bg-color">
                                            <h6 class="panel-title">
                                                <a class="collapsed box-text" data-toggle="collapse" href="#acc-'.$accordion_array['Accordion']['id'].'-'.$i.'">
                                                    <i class="fa box-text"></i>
														'.$accordion_content['title'].'
                                                </a>
                                            </h6>
                                        </div>
                                        <div id="acc-'.$accordion_array['Accordion']['id'].'-'.$i.'" class="panel-collapse collapse">
                                            <div class="panel-body box-background">
                                                <p class="box-text">
													'.$accordion_content['content'].'
                                                </p>
                                            </div>
                                        </div>
                                    </div>';
							$i++;
						}
                    $content[$k].='</div>';                
                                    
				}
				else
				{
					$content[$k]='';
				}
				
			}
			else if($short_code_type[0] == 'Column')
			{
				App::import('Model','Column');
				$column_model = new Column();
				
				$column_array = $column_model->findByIdAndIsdelAndStatus($short_code_type[1],'0','Y');
				
				if(!empty($column_array)){
					$content[$k] = ($column_array['Column']['headingfrontend_flag']=='Y')?
									'<div class="sep-heading-container shc4 clearfix">
										<h4>'.$column_array['Column']['column_name'].'</h4>
										<div class="sep-container">
											<div class="the-sep"></div>
										</div>
									</div>':'';
				} else {
					$content[$k] = '';
				}
				if(isset($column_array['Column']) && $column_array['Column']['column_style']=='style1')
				{
					$content[$k] .='<div class="row">
                        <div class="col-sm-6 col-item main-el">
                            <p>'.$column_array['Column']['column1'].'</p>
                        </div>

                        <div class="col-sm-6 col-item main-el">
                            <p>'.$column_array['Column']['column2'].'</p>
                        </div>
                    </div>';
				}
				else if(isset($column_array['Column']) && $column_array['Column']['column_style']=='style2')
				{
				
					$content[$k] .='<div class="row">
                        <div class="col-sm-4 col-item main-el">
                            <p>'.$column_array['Column']['column1'].'</p>
                        </div>

                        <div class="col-sm-4 col-item main-el">
                            <p>'.$column_array['Column']['column2'].'</p>
                        </div>
						
						<div class="col-sm-4 col-item main-el">
                            <p>'.$column_array['Column']['column3'].'</p>
                        </div>
                    </div>';
				}
				else if(isset($column_array['Column']) && $column_array['Column']['column_style']=='style3')
				{
					
					
					$content[$k] .='<div class="row">
                        <div class="col-sm-3 col-item main-el">
                            <p>'.$column_array['Column']['column1'].'</p>
                        </div>

                        <div class="col-sm-3 col-item main-el">
                            <p>'.$column_array['Column']['column2'].'</p>
                        </div>
						
						<div class="col-sm-3 col-item main-el">
                            <p>'.$column_array['Column']['column3'].'</p>
                        </div>
						
						<div class="col-sm-3 col-item main-el">
                            <p>'.$column_array['Column']['column4'].'</p>
                        </div>
                    </div>';
				}
				else if(isset($column_array['Column']) && $column_array['Column']['column_style']=='style4')
				{
					$content[$k] .='<div class="row">
                        <div class="col-sm-8 col-item main-el">
                            <p>'.$column_array['Column']['column1'].'</p>
                        </div>

                        <div class="col-sm-4 col-item main-el">
                            <p>'.$column_array['Column']['column2'].'</p>
                        </div>
                    </div>';
				}
				else
				{
					$content[$k]='';
				}
			}
			else if($short_code_type[0] == 'tag')
			{
				App::import('Model','PostTag');
				$tag = new PostTag();
				$ptag = $tag->find('all',array('conditions'=>array('PostTag.status'=>'Y','PostTag.isdel'=>0)));
				//pr($ptag);exit;
				
				
				$content[$k] = '<div class="sep-heading-container shc4 clearfix"><h4>Latest Tag</h4><div class="sep-container"><div class="the-sep"></div></div></div><div class="tags clearfix">';
					foreach($ptag as $ptag)
					{
                            $content[$k] .= '<a href="'.SITE_URL."blog/tag/".$ptag['PostTag']['slug'].'" class="tag alt-text-color main-bg-color">'.$ptag['PostTag']['tag_name'].'</a>';
                    }
                        $content[$k] .='</div>';
			}
			else if($short_code_type[0] == 'flickrphoto')
			{
				$content[$k] = '<div class="flickr-container">
                                    <a href="#">
                                        <div class="overlay">
                                            <i class="fa fa-share"></i>
                                        </div>
                                        <img src="../images/fl-1.png" alt="" class="img-responsive">
                                    </a>
                                    <a data-flickr-embed="true" href="https://www.flickr.com/photos/133332276@N06/19887376658/in/dateposted-public/" title="12620">
									<div class="overlay">
                                            <i class="fa fa-share"></i>
                                        </div>
									<img src="https://farm1.staticflickr.com/475/19887376658_4df6ac1bb6_b.jpg" width="51" height="51" alt="12620"></a><script async src="//embedr.flickr.com/assets/client-code.js" charset="utf-8"></script>" alt="" class="img-responsive">
                                    </a>
                                    <a href="#">
                                        <div class="overlay">
                                            <i class="fa fa-share"></i>
                                        </div>
                                        <img src="../images/fl-3.png" alt="" class="img-responsive">
                                    </a>
                                    <a href="#">
                                        <div class="overlay">
                                            <i class="fa fa-share"></i>
                                        </div>
                                        <img src="../images/fl-4.png" alt="" class="img-responsive"></a>
                                    <a href="#">
                                        <div class="overlay">
                                            <i class="fa fa-share"></i>
                                        </div>
                                        <img src="../images/fl-5.png" alt="" class="img-responsive">
                                    </a>
                                    <a href="#">
                                        <div class="overlay">
                                            <i class="fa fa-share"></i>
                                        </div>
                                        <img src="../images/fl-6.png" alt="" class="img-responsive">
                                    </a>
                                    <a href="#">
                                        <div class="overlay">
                                            <i class="fa fa-share"></i>
                                        </div>
                                        <img src="../images/fl-7.png" alt="" class="img-responsive">
                                    </a>
                                    <a href="#">
                                        <div class="overlay">
                                            <i class="fa fa-share"></i>
                                        </div>
                                        <img src="../images/fl-8.png" alt="" class="img-responsive">
                                    </a>
                                    <a href="#">
                                        <div class="overlay">
                                            <i class="fa fa-share"></i>
                                        </div>
                                        <img src="../images/fl-9.png" alt="" class="img-responsive">
                                    </a>
                                    <a href="#">
                                        <div class="overlay">
                                            <i class="fa fa-share"></i>
                                        </div>
                                        <img src="../images/fl-10.png" alt="" class="img-responsive">
                                    </a>
                                    <a href="#">
                                        <div class="overlay">
                                            <i class="fa fa-share"></i>
                                        </div>
                                        <img src="../images/fl-11.png" alt="" class="img-responsive">
                                    </a>
                                    <a href="#">
                                        <div class="overlay">
                                            <i class="fa fa-share"></i>
                                        </div>
                                        <img src="../images/fl-12.png" alt="" class="img-responsive">
                                    </a>
                                </div>';
			}
			else if($short_code_type[0] == 'Box')
			{
				App::import('Model','Box');
				$box_model = new Box();
	   
				$box_model->bindModel(
					array('hasMany' => array(
							'BoxContent' => array(
								'className' => 'BoxContent',
								'foreignKey'=>'box_id',
								'conditions'=>array('BoxContent.isdel'=>'0','BoxContent.status'=>'Y'),
							)
						)
					)
				);
				$box_array = $box_model->findByIdAndIsdelAndStatus($short_code_type[1],'0','Y');
				//pr($short_code_type);exit;
				if(!empty($box_array)){
					$content[$k] = ($box_array['Box']['headingfrontend_flag']=='Y')?
									'<div class="sep-heading-container shc4 clearfix">
										<h4>'.$box_array['Box']['boxname'].'</h4>
										<div class="sep-container">
											<div class="the-sep"></div>
										</div>
									</div>':'';
				} else {
					$content[$k] = '';
				}
				if(isset($box_array['Box']) && $box_array['Box']['boxstyle']=='style1')
				{
					
					foreach($box_array['BoxContent'] as $boxcontent)
					{
						$content[$k] .= '<div class="col-sm-4 main-el">
											<div class="feature-box">
												<div class="head '.$boxcontent['boxheaderstyle'].' main-bg-color alt-text-color">
													<span>'.$boxcontent['boxheadertitle'].'</span>
												</div>
												<div class="body text-center box-background">
													<h5 class="box-text"><a href="'.$boxcontent['boxlink'].'" class="box-text">'.$boxcontent['boxtitle'].'</a></h5>
													<p class="box-text"> '.$boxcontent['boxcontent'].'</p>
												</div>
											</div>
										</div>';
					}
				}
				elseif(isset($box_array['Box']) && $box_array['Box']['boxstyle']=='style2')
				{
					
					$count = count($box_array['BoxContent']);
					$d = ceil($count/4);
					for($i=1; $i<=$d; $i++)
					{
						$content[$k].='<div class="col-sm-4 box-2 main-el">';
						$j = $i*4;
						if($i>1)
						{
							$h= (($i-1)*4)+1;
						}
						else
						{
							$h = 1;
						}
						for($l=$h; $l<=$j; $l++)		
						{
							if(isset($box_array['BoxContent'][$l-1]))
							{
								$content[$k] .='<div class="item">
									<i class="pull-left '.$box_array['BoxContent'][$l-1]['sidestyle'].' circled main-bg-color alt-text-color"></i>
									<div class="text">
										<h4>'.$box_array['BoxContent'][$l-1]['boxtitle'].'</h4>
										<p>'.$box_array['BoxContent'][$l-1]['boxcontent'].'</p>
									</div>
								</div>';
							}
						}
						
						$content[$k] .='</div>';
					}
				}
				elseif(isset($box_array['Box']) && $box_array['Box']['boxstyle']=='style3')
				{
					$content[$k] .='<div id="feature-cards">
										<div class="container">
											<div class="row">';
					foreach($box_array['BoxContent'] as $boxcontent)
					{
						$content[$k] .= '<div class="col-md-4 main-el">
											<div class="card" style="background:url('.IMGPATH.'backgroundstyle/resize/'.$boxcontent['backgroundstyle'].') no-repeat;">
												<div class="background-overlay">
													<div class="top">
														<i class="'.$boxcontent['boxheaderstyle'].' alt-text-color pull-left"></i>
														<h4 class="box-text light"> '.$boxcontent['boxtitle'].' </h4>
													</div>
													<p class="alt-text-color box-text">
														'.$boxcontent['boxcontent'].'
													</p>
													<a href="'.$boxcontent['boxlink'].'">
														<div class="button light">
															<div class="over"></div>
												   +
														</div>
													</a>
												</div>
											</div>
										</div>';
					}               
					$content[$k] .= '</div>
								</div>
							</div>';
				
				}
				elseif(isset($box_array['Box']) && $box_array['Box']['boxstyle']=='style5')
				{
					$content[$k] .='<div class="boxes-5">';
					foreach($box_array['BoxContent'] as $boxcontent)
					{
						$content[$k] .= '<div class="row item">
											<div class="col-md-12">
												<div class="badge main-bg-color pull-left">
													<i class="'.$boxcontent['sidestyle'].'"></i>
												</div>
												<div class="text">
													<h5 class="medium"> '.$boxcontent['boxtitle'].'</h5>
													<p>'.$boxcontent['boxcontent'].'</p>
												</div>
											</div>
										</div>';
					}               
					$content[$k] .='</div>';
				}
				elseif(isset($box_array['Box']) && $box_array['Box']['boxstyle']=='style4')
				{
					foreach($box_array['BoxContent'] as $boxcontent)
					{
						$content[$k] .= '<div class="col-sm-4 main-el">
											<div class="box-6 box-background">
												<i class="'.$boxcontent['boxheaderstyle'].' alt-text-color main-bg-color"></i>
												<h5 class="medium box-text">'.$boxcontent['boxtitle'].'</h5>
												<p class="box-text">'.$boxcontent['boxcontent'].'
												</p>
												<h6 class="main-text-color"><a href="'.$boxcontent['boxlink'].'">Read More</a> <i class="fa fa-play-circle-o"></i> </h6>
											</div>
										</div>';
					}               
				
				}
				elseif(isset($box_array['Box']) && $box_array['Box']['boxstyle']=='style6')
				{
					foreach($box_array['BoxContent'] as $boxcontent)
					{
						$content[$k] .= '<div class="col-sm-4 main-el">
											<div class="box-7">
												<i class="'.$boxcontent['boxheaderstyle'].'"></i>
												<h5 class="medium">'.$boxcontent['boxtitle'].'</h5>
												<p>'.$boxcontent['boxcontent'].'</p>
												<h6 class="main-text-color"><a href="'.$boxcontent['boxlink'].'">Read More</a> <i class="fa fa-play-circle-o"></i> </h6>
											</div>
										</div>';
					}               
				
				}
				elseif(isset($box_array['Box']) && $box_array['Box']['boxstyle']=='style7')
				{
					
						$content[$k] .= '<div class="boxes-4">
											<div class="row">';
												
							foreach($box_array['BoxContent'] as $boxcontent)
							{
								$con_array = explode(",",$boxcontent['boxcontent']);
								$content[$k] .= '<div class="col-sm-4 main-el">
													<i class="'.$boxcontent['sidestyle'].' box-background pull-left"></i>
													<div class="text">
														<h5 class="medium">
																'.$boxcontent['boxtitle'].'
														</h5>
														<ul>';
								foreach($con_array as $con_array)
								{	
									$content[$k] .= '<li>'.$con_array.'</li>';
								}
								$content[$k] .= '</ul>
													</div>
												</div>';
							}
						$content[$k] .= '</div>
										</div>';
					               
				
				}
				else
				{
					$content[$k]='';
				}
				
			}
			else if($short_code_type[0] == 'Tab')
			{
				App::import('Model','Tabs');
				$tab_model = new Tabs();
	   
				$tab_model->bindModel(
					array('hasMany' => array(
							'TabContent' => array(
								'className' => 'TabContent',
								'foreignKey'=>'tab_id',
								'conditions'=>array('TabContent.isdel'=>'0','TabContent.status'=>'Y'),
							)
						)
					)
				);
				$tab_array = $tab_model->findByIdAndIsdelAndStatus($short_code_type[1],'0','Y');
				
				/* pr($tab_array);
				exit; */ 
				if(!empty($tab_array)){
					$content[$k] = ($tab_array['Tabs']['headingfrontend_flag']=='Y')?
									'<div class="sep-heading-container shc4 clearfix">
										<h4>'.$tab_array['Tabs']['name'].'</h4>
										<div class="sep-container">
											<div class="the-sep"></div>
										</div>
									</div>':'';
				} else {
					$content[$k] = '';
				}
				
				if(isset($tab_array['Tabs']) && $tab_array['Tabs']['style']=='style1')
				{
					
					$content[$k] .= '<div id="d-tabs" class="tab def"><ul class="box-background">';
								$i=1;
								foreach($tab_array['TabContent'] as $tab)
								{
                                  $content[$k] .=   '<li ui-tabs-active ui-state-active  class="box-background"><a href="#d-tabs-'.$i.'"><h6  class="box-text">'.$tab['title'].'</h6></a>
								  </li>';
								  $i++;
								 }
                                $content[$k] .='</ul>';
								$i=1;
								foreach($tab_array['TabContent'] as $tab)
								{
									$content[$k] .= '<div class="box-background" id="d-tabs-'.$i.'">
										<p class="box-text">'.$tab['content'].'</p>
									</div>';
									$i++;
								}
								
                    $content[$k] .= '</div>';
                                    
				}
				elseif(isset($tab_array['Tabs']) && $tab_array['Tabs']['style']=='style2')
				{
					$content[$k] .= '<div id="b-tabs" class="tab tabs-bottom"><ul class="box-background">';
									$i=1;
									foreach($tab_array['TabContent'] as $tab)
									{
									   $content[$k] .= '<li class="box-background"><a href="#b-tabs-'.$i.'"><h6 class="box-text">'.$tab['title'].'</h6></a></li>';
										$i++;
									}  
                                $content[$k] .='</ul>';
								$i=1;
								foreach($tab_array['TabContent'] as $tab)
								{
                              $content[$k] .=  '<div class="tabs-spacer"></div>
                                <div class="box-background" id="b-tabs-'.$i.'">
                                    <p class="box-text">'.$tab['content'].'</p> 
                                </div>';
								$i++;
								}
                            $content[$k] .=  '</div>';               
				}
				elseif(isset($tab_array['Tabs']) && $tab_array['Tabs']['style']=='style3')
				{
					$content[$k] .='<div id="l-tabs" class="tab left"><ul class="box-background">';                           
                                    $i=1;
									foreach($tab_array['TabContent'] as $tab)
									{
										$content[$k] .= '<li class="box-background"><a href="#l-tabs-'.$i.'"><h6 class="box-text">'.$tab['title'].'</h6></a></li>';
										$i++;
									} 
                               $content[$k] .=  '</ul>';
							   $i=1;
								foreach($tab_array['TabContent'] as $tab)
								{
                                $content[$k] .= '<div class="box-background" id="l-tabs-'.$i.'">
                                    <p class="box-text">'.$tab['content'].'</p>
								</div>';
                              $i++;
								}  
                            $content[$k] .=  '</div>';             
                }                 
				elseif(isset($tab_array['Tabs']) && $tab_array['Tabs']['style']=='style4')
				{
					$content[$k] .='<div id="r-tabs" class="tab right"><ul class="box-background">';
									$i=1;
									foreach($tab_array['TabContent'] as $tab)
									{
										$content[$k] .= '<li class="box-background"><a href="#r-tabs-'.$i.'"><h6 class="box-text">'.$tab['title'].'</h6></a></li>';
										$i++;
									} 
                                $content[$k] .= '</ul>';
                                $i=1;
								foreach($tab_array['TabContent'] as $tab)
								{
									$content[$k] .= '<div class="box-background" id="r-tabs-'.$i.'">
                                    <p class="box-text">'.$tab['content'].'</p>
								</div>';
                                 $i++;
								}  
                             $content[$k] .=  '</div>';                                   
				}
				else
				{
					$content[$k]='';
				}
				
			}
			
			else if($short_code_type[0] == 'Divider')
			{
			
				
						if($short_code_type[1]=='1')
						{
							$content[$k] = '<div class="sep-heading-container shc4 clearfix">
												<div class="sep-container">
													<div class="the-sep"></div>
												</div>
											</div>';
						}
						else if($short_code_type[1]=='2')
						{
							$content[$k] = '<div class="sep-heading-container shc4 clearfix">
												<div class="divider divider-1"></div>
											</div>';
						}
						else if($short_code_type[1]=='3')
						{
							$content[$k] = '<div class="sep-heading-container shc4 clearfix">
												<div class="divider divider-2"></div>
											</div>';
						}
						else if($short_code_type[1]=='4')
						{
							$content[$k] = '<div class="sep-heading-container shc4 clearfix">
												<div class="text-center">
													<div class="divider divider-3"></div>
												</div>
											</div>';
						}
						else if($short_code_type[1]=='5')
						{
							$content[$k] = '<div class="sep-heading-container shc4 clearfix">
												<div class="divider divider-4"></div>
											</div>';
						}
			}
			else if($short_code_type[0] == 'ListStyle')
			{
				App::import('Model','ListStyle');
				$list_model = new ListStyle();
	   
				$list_model->bindModel(
					array('hasMany' => array(
							'ListContent' => array(
								'className' => 'ListContent',
								'foreignKey'=>'list_id',
								'conditions'=>array('ListContent.isdel'=>'0','ListContent.status'=>'Y'),
							)
						)
					)
				);
				$list_array = $list_model->findByIdAndIsdelAndStatus($short_code_type[1],'0','Y');
				
				/* pr($list_array);
				exit;  */
				if(!empty($list_array)){
					$content[$k] = ($list_array['ListStyle']['headingfrontend_flag']=='Y')?
									'<div class="sep-heading-container shc4 clearfix">
										<h4>'.$list_array['ListStyle']['name'].'</h4>
										<div class="sep-container">
											<div class="the-sep"></div>
										</div>
									</div>':'';
				} else {
					$content[$k] = '';
				}
				
				if(isset($list_array['ListStyle']) && $list_array['ListStyle']['style']=='style1')
				{
					
					$content[$k] .= '<div class="icon list">';
                                  foreach($list_array['ListContent'] as $list)
									{  
										if($list['make_link']=='Y'){
											$content[$k] .= '<div class="element">
														<i class="main-bg-color alt-text-color '.$list['listcontentstyle'].' pull-left"></i>
														<p><a href="'.$list['link'].'" target="_blank">'.$list['listcontent'].'</a></p>
													</div>';
												} else {
													$content[$k] .= '<div class="element">
														<i class="main-bg-color alt-text-color '.$list['listcontentstyle'].' pull-left"></i>
														<p>'.$list['listcontent'].'</p>
													</div>';
												}
									}   
                                 $content[$k] .= '</div>';
                 }                   
				elseif(isset($list_array['ListStyle']) && $list_array['ListStyle']['style']=='style2')
				{
					$content[$k] .= '<div class="icon list icon-list-2">';
								foreach($list_array['ListContent'] as $list)
									{  
									if($list['make_link']=='Y'){
										$content[$k] .= '<div class="element">
															<i class="main-text-color '.$list['listcontentstyle'].' pull-left"></i>
															<p><a href=
															"'.$list['link'].'" target="_blank">'.$list['listcontent'].'</a></p>
														 </div>';
											} else {
												$content[$k] .= '<div class="element">
															<i class="main-text-color '.$list['listcontentstyle'].' pull-left"></i>
															<p>'.$list['listcontent'].'</p>
														 </div>';
											}
									}                                   
                               $content[$k] .= '</div>';               
				}
				 elseif(isset($list_array['ListStyle']) && $list_array['ListStyle']['style']=='style3')
				{
					$content[$k] .='<div class="icon-list-3">';
								$i=1;
								foreach($list_array['ListContent'] as $list)
								{
									if($list['make_link']=='Y'){
										$content[$k].='<div class="element">
											<i class="main-bg-color alt-text-color pull-left">'.$i.'</i>
											<p><a href="'.$list['link'].'" target="_blank">'.$list['listcontent'].'</a></p>
										</div>';
										} else {
											$content[$k].='<div class="element">
											<i class="main-bg-color alt-text-color pull-left">'.$i.'</i>
											<p>'.$list['listcontent'].'</p>
										</div>';
										}
									$i++;
								}	
					$content[$k].='</div>';             
                }                 
				elseif(isset($list_array['ListStyle']) && $list_array['ListStyle']['style']=='style4')
				{
					$content[$k] .='<div class="icon-list-4">';
								$i=1;
								foreach($list_array['ListContent'] as $list)
								{
									if($list['make_link']=='Y'){
										$content[$k].='<div class="element">
											<i class="main-text-color pull-left">'.$i.'.</i>
											<p><a href = "'.$list['link'].'" target="_blank">'.$list['listcontent'].'</a></p>
										</div>';
									} else {
										$content[$k].='<div class="element">
											<i class="main-text-color pull-left">'.$i.'.</i>
											<p>'.$list['listcontent'].'</p>
										</div>';
									}
									$i++;
								}
										
					$content[$k].='</div>';                                   
				}
				elseif(isset($list_array['ListStyle']) && $list_array['ListStyle']['style']=='style5')
				{
					$content[$k] .='';
						foreach($list_array['ListContent'] as $list)
						{
							if($list['make_link']=='Y'){
							$content[$k].='<div class="element">
								<i class="main-text-color pull-left"></i>
								<li><a href="'.$list['link'].'" target="_blank">'.$list['listcontent'].'</a></li>
							</div>';
							} else {
								$content[$k].='<div class="element">
								<i class="main-text-color pull-left"></i>
								<li>'.$list['listcontent'].'</li>
							</div>';
							}
						}                                  
				}
				else
				{
					$content[$k]='';
				}
				
			}
			else if($short_code_type[0] == 'Imagebox')
			{
				App::import('Model','ImageBox');
				$imagebox_model = new ImageBox();
	   
				$imagebox_model->bindModel(
					array('hasMany' => array(
							'ImageBoxContent' => array(
								'className' => 'ImageBoxContent',
								'foreignKey'=>'image_box_id',
								'conditions'=>array('ImageBoxContent.isdel'=>'0','ImageBoxContent.status'=>'Y'),
							)
						)
					)
				);
				$imagebox_array = $imagebox_model->findByIdAndIsdelAndStatus($short_code_type[1],'0','Y');
				
				if(!empty($imagebox_array)){
				$content[$k] = ($imagebox_array['ImageBox']['headingfrontend_flag']=='Y')?
								'<div class="sep-heading-container shc4 clearfix">
                                    <h4>'.$imagebox_array['ImageBox']['name'].'</h4>
                                    <div class="sep-container">
                                        <div class="the-sep"></div>
                                    </div>
                                </div>':'';
				} else {
					$content[$k] = '';
				}
				if(isset($imagebox_array['ImageBoxContent'][0]['content']) || isset($imagebox_array['ImageBoxContent'][0]['image']) || isset($imagebox_array['ImageBoxContent'][0]['title']) || isset($imagebox_array['ImageBoxContent'][0]['link'])){
				
				$img_text = String::truncate(
							$imagebox_array['ImageBoxContent'][0]['content'],50,
								array('exact' => false));
					if(!empty($imagebox_array['ImageBoxContent'][0]['link']))
									{
										$includehtml=' <span class="read-link main-text-color"><a href="'.$imagebox_array['ImageBoxContent'][0]['link'].'">Read More </a><i class="fa fa-play-circle-o"></i></span>';
									}
									else
									{
										$includehtml ='';
									}
				$content[$k] .= '<div class="main-el">
									<div class="img-box">
										<div class="thumb">
											<a class="overlay mgp-img" href="'.IMGPATH.'box_image/thumb/'.$imagebox_array['ImageBoxContent'][0]['image'].'">
												<i class="fa fa-search md alt-text-color"></i>
											</a>
											<img src="'.IMGPATH.'box_image/resize/'.$imagebox_array['ImageBoxContent'][0]['image'].'" class="img-responsive" alt="">
										</div>
									<h5 class="medium">'.$imagebox_array['ImageBoxContent'][0]['title'].'</h5>
									<p>'.$img_text.''.$includehtml.'
									</p>
								</div>
							</div>';
							}
							else {
							$content[$k] = '';
							}
			}
			else if($short_code_type[0] == 'Testimonial')
			{
				App::import('Model','Testimonials');
				$testimonial_model = new Testimonials();
	   
				$testimonial_model->bindModel(
					array('hasMany' => array(
							'TestimonialContent' => array(
								'className' => 'TestimonialContent',
								'foreignKey'=>'testimonial_id',
								'conditions'=>array('TestimonialContent.isdel'=>'0','TestimonialContent.status'=>'Y'),
							)
						)
					)
				);
				$testimonial_array = $testimonial_model->findByIdAndIsdelAndStatus($short_code_type[1],'0','Y');
				
				/* pr($testimonial_array);
				exit;  */
				if(!empty($testimonial_array)){
				$content[$k] = ($testimonial_array['Testimonials']['headingfrontend_flag']=='Y')?
								'<div class="sep-heading-container shc4 clearfix">
                                    <h4>'.$testimonial_array['Testimonials']['name'].'</h4>
                                    <div class="sep-container">
                                        <div class="the-sep"></div>
                                    </div>
                                </div>':'<div class="sep-heading-container shc4 clearfix"></div>';
				} else {
					$content[$k] =  '<div class="sep-heading-container shc4 clearfix"></div>';
				}
				if(isset($testimonial_array['Testimonials']) && $testimonial_array['Testimonials']['style']=='style1')
				{
					$content[$k] .= '<div id="testimonials-1-1" class="carousel slide carousel-fade testimonials-1" data-ride="carousel">
                                <div class="carousel-inner">';
					$i=0;
					foreach($testimonial_array['TestimonialContent'] as $testimonial)
					{	
						if($i==0)
						{
							$a = 'active';
						}
						else
						{
							$a = '';
						}		
						$content[$k] .= '<div class="item '.$a.'">
                                        <div class="top">
											<div class="background-overlay">
												<div class="head alt-text-color">
												'.$testimonial_array['Testimonials']['text'].'
												</div>
												<p class="italic alt-text-color">
												'.$testimonial['testimonial'].' </p>
											</div>
                                        </div>
                                        <div class="bot">
                                            <h5 class="main-text-color medium">'.$testimonial['title'].'</h5>
                                            <p>'.$testimonial['heading'].'</p>
                                            <div class="avatar">
                                                <img src="'.IMGPATH.'testimonial_image/thumb/'.$testimonial['testimonial_image'].'" alt="">
                                            </div>
                                        </div>
                                    </div>';
						$i++;
                    }              
                    $content[$k] .= '</div>
                            </div>
                            <ol class="testimonials-1 carousel-indicators indicators">';
							$i=0;
							foreach($testimonial_array['TestimonialContent'] as $testimonial)
							{	
								if($i==0)
								{
									$a = 'active';
								}
								else
								{
									$a = '';
								}	
                                $content[$k] .= '<li data-target="#testimonials-1-1" data-slide-to="'.$i.'" class="'.$a.' item"></li>';
								$i++;
							}
                    $content[$k] .= '</ol>';
                }                   
				elseif(isset($testimonial_array['Testimonials']) && $testimonial_array['Testimonials']['style']=='style3')
				{
					$content[$k] .='<div class="testimonials-3 text-center no-spacing">
								<div class="test-overlay">
									<div class="container">
										<div class="row">
											<div class="col-md-12">
												<h2 class="alt-text-color">'.$testimonial_array['Testimonials']['text'].'</h2>
												<div class="divider divider-3 alt-bg-color faded"></div>
												<div id="testimonials-3-crsl" class="carousel slide carousel-fade" data-ride="carousel">
													<div class="carousel-inner">';
					$i=0;
					foreach($testimonial_array['TestimonialContent'] as $testimonial)
					{	
						if($i==0)
						{
							$a = 'active';
						}
						else
						{
							$a = '';
						}		
								
							$content[$k] .= '<div class="item '.$a.'">
												<p class="alt-text-color italic">'.$testimonial['testimonial'].'</p>
												<h5 class="alt-text-color medium">- '.$testimonial['title'].'</h5>
											</div>';
						$i++;
					}	
											
							$content[$k] .= '</div>
													<ol class="carousel-indicators">';
									$i=0;
									foreach($testimonial_array['TestimonialContent'] as $testimonial)
									{	
										if($i==0)
										{
											$a = 'active';
										}
										else
										{
											$a = '';
										}				
										
										$content[$k] .= '<li data-target="#testimonials-3-crsl" data-slide-to="'.$i.'" class="'.$a.'"></li>';
										$i++;
									}
														
							$content[$k] .= '</ol>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>';             
                }                 
				elseif(isset($testimonial_array['Testimonials']) && $testimonial_array['Testimonials']['style']=='style2')
				{
					$content[$k] .='<div class="testimonials-2">';
					
					foreach($testimonial_array['TestimonialContent'] as $testimonial)
					{
						$content[$k] .= '<div class="item">
											<div class="text">
												<p class="italic">
												'.$testimonial['testimonial'].'</p>
											<div class="avatar">
												<img src="'.IMGPATH.'testimonial_image/thumb/'.$testimonial['testimonial_image'].'" alt="">
											</div>
										</div>
										<div class="client">
											<h5 class="main-text-color medium">'.$testimonial['title'].'</h5>
											<p>'.$testimonial['heading'].'</p>

										</div>
										</div>';

					}					
					$content[$k] .= '</div>';                                   
				}
				else
				{
					$content[$k] ='';
				}
				
			}
			else if($short_code_type[0] == 'Video')
			{
				App::import('Model','Video');
				$video_model = new Video();
				$video_array = $video_model->findByIdAndIsdelAndStatus($short_code_type[1],'0','Y');
				
				$content[$k] = '<div class="video-frame box">';
									foreach($video_array as $video)
									{
									   $content[$k] .= '<iframe width="420" height="345" src="'.$video['youtube_url'].'">
										</iframe>';
									}
									   $content[$k] .=  '</div>';
			}
			else if($short_code_type[0] == 'name' || $short_code_type[0] == 'email' || $short_code_type[0] == 'message')
			{
				$content[$k] = '';
			}
			else if($short_code_type[0] == 'News')
			{
				App::import('Model','NewsWidget');
				$news_model = new NewsWidget();
	   
				$news_array = $news_model->findByIdAndIsActive($short_code_type[1],'0');
				
				App::import('Model','News');
				$news = new News();
				
				$news_arr = $news->find('all', array('conditions'=>array('News.is_del'=>0),
														'limit'=>'3'));
				
				/* pr($news_arr);
				exit;
				  */
				if(!empty($news_array)){
				$content[$k] = ($news_array['NewsWidget']['headingfrontend_flag']=='Y')?
								'<div class="sep-heading-container shc4 clearfix">
                                    <h4>'.$news_array['NewsWidget']['name'].'</h4>
                                    <div class="sep-container">
                                        <div class="the-sep"></div>
                                    </div>
                                </div>':'';
				} else {
					$content[$k] =  '';
				}
				if(isset($news_array['NewsWidget']) && $news_array['NewsWidget']['style']=='Style1')
				{
					
					$content[$k] .= '<div class="list-group">';
					
					foreach($news_arr as $news_list){
                             $content[$k] .= '<a href="#" class="list-group-item">'.$news_list['News']['news_title'].'</a>';
							 }
                         $content[$k] .=   '</div>';
                 }                   
				else
				{
					$content[$k]='';
				}
			}
			else if($short_code_type[0] == 'Category')
			{
				App::import('Model','PostCategory');
				$category_model = new PostCategory();
	   
				$category_array = $category_model->find('all', 
															array('conditions'=>
																		array(			'PostCategory.status'=>'Y'),
																	'limit'=>'5',
																	'order' => array('PostCategory.category_name ASC')));
				
					$content[$k] = '<div class="sep-heading-container shc4 clearfix"><h4>Categories</h4><div class="sep-container"><div class="the-sep"></div></div></div><div class="list-group">';
					
					foreach($category_array as $category_array){
                             $content[$k] .= '<a href="'.SITE_URL ."blog/category/".$category_array['PostCategory']['slug'].'" class="list-group-item">'.$category_array['PostCategory']['category_name'].'</a>';
							 }
                         $content[$k] .=   '</div>';
                               
				
			}
			else if($short_code_type[0] == 'Banner')
			{
				App::import('Model','CmsGallery');
				$cmsgallery_model = new CmsGallery();
				
				$cmsgallery_model->bindModel(
					array('hasMany' => array(
							'CmsBanner' => array(
								'className' => 'CmsBanner',
								'foreignKey'=>'gallery_id'
							)
						)
					)
				);
				
				$cmsgallery_arr = $cmsgallery_model->findById($short_code_type[1]);
				//pr($cmsgallery_arr); exit;
				
				if(isset($cmsgallery_arr['CmsGallery']) && $cmsgallery_arr['CmsGallery']['style'] == 'style1')
				{
					$content[$k] = '<div class="bannercontainer">
										<div class="banner">
											<ul>';
								//$i=1;
								foreach($cmsgallery_arr['CmsBanner'] as $cmsbanner)		
								{
								if($cmsbanner['rev_slider_type'] == 1){
									$content[$k] .='<li id="slide3" data-transition="fade" data-slotamount="1">
													<img src="'.IMGPATH.'banner_image/resize/'.$cmsbanner['banner_image'].'" alt="">
													<div class="tp-caption skewfromleft" data-x="center" data-voffset="-30" data-y="center" data-speed="500" data-start="1200">
														<img class="img-responsive" src="'.IMGPATH.'banner_back_image/resize/'.$cmsbanner['banner_back_image'].'" alt="">
													</div>
													<!--<div class="tp-caption lfb title" data-x="center" data-voffset="170" data-y="center" data-speed="500" data-start="1200">
														<div class="light alt-text-color">
														Built on Bootstrap 3 Framework
														</div>
													</div>-->
												</li>';
									//$i++;
									} 
								}
								foreach($cmsgallery_arr['CmsBanner'] as $cmsbanner)		
								{
									if($cmsbanner['rev_slider_type'] == 2) {
									
									$content[$k] .='<li data-transition="fade" data-slotamount="1" class="fullvid">
										<img src="'.IMGPATH.'banner_image/resize/'.$cmsbanner['banner_image'].'" alt="">
											<div class="caption fade fullscreenvideo" data-forcecover="true" data-nextslideatend="true" data-x="0" data-y="0" data-speed="300" data-start="10" data-easing="easeOutBack">
												<a class="video-popup-link v-al-container" style="width: 100%; height: 100%; display: block;" href="#youtube-video">
													<div class="v-al">
														<img src="'.IMGPATH .'play-icon.png" class="img-responsive center-block" alt="">
													</div>
												</a>
											<div id="youtube-video" class="white-popup mfp-hide">
												<div class="main-slider-video-wrapper">
													<iframe class="center-block" width="800px" height="600px" src="'.$cmsbanner['rev_video_link'].'">
													</iframe>
												</div>
											</div>
										</div>
									</li>';
									} 
								}
								foreach($cmsgallery_arr['CmsBanner'] as $cmsbanner)		
								{
									if($cmsbanner['rev_slider_type'] == 3) {
									
									$content[$k] .='<li id="slide1" data-transition="fade" data-slotamount="1">
										<img src="'.IMGPATH.'banner_image/resize/'.$cmsbanner['banner_image'].'" alt="">
											<div class="tp-caption caption1 title skewfromleft" data-x="center" data-voffset="-100" data-y="center" data-speed="500" data-start="1200">
												<div class="container text-center">
													<div class="light">'.$cmsbanner['detailheading'].'
													</div>
												</div>
											</div>
										<div class="tp-caption caption1 text skewfromleft" data-x="center" data-y="center" data-speed="500" data-start="1200">
											<div class="container text-center">
												<div class="light faded">'.$cmsbanner['banner_text'].'
												</div>
											</div>
										</div>
										<div class="tp-caption caption1 lfb" data-x="center" data-voffset="90" data-y="center" data-speed="500" data-start="1200">
											<div class="btns">
												
												<a target="_blank" href="'.$cmsbanner['button_link'].'" class="button solid md blue">
												<div class="over">'.$cmsbanner['button_text'].'</div>
												</a>
												
											</div>
										</div>
									</li>';
									}	
								}
					$content[$k] .= '</ul>
								</div>
							</div>';
				}
				else if(isset($cmsgallery_arr['CmsGallery']) && $cmsgallery_arr['CmsGallery']['style'] == 'style2')
				{
					$content[$k] = '<div class="full portfolio">
										<div id="full-1" class="carousel slide carousel-fade" data-ride="carousel">
										<ol class="carousel-indicators">';
                
				$j=0;
				foreach($cmsgallery_arr['CmsBanner'] as $cmsbanner)		
				{ 
					if($j==0)
						{
							$a = 'active';
						}
						else
						{
							$a = '';
						}		
                    $content[$k] .= '<li data-target="#full-1" data-slide-to="'.$j.'" class="'.$a.'"></li>';
					$j++;	
                    }    
                    $content[$k] .= '</ol>
									<div class="carousel-inner">';
					
				$i=0;
				foreach($cmsgallery_arr['CmsBanner'] as $cmsbanner)		
				{
				if($i==0)
						{
							$a = 'active';
						}
						else
						{
							$a = '';
						}	
                   $content[$k] .= '<div class="item '.$a.'">
                            <div class="image">
                                <img src="'.IMGPATH.'banner_image/resize/'.$cmsbanner['banner_image'].'" alt="" class="img-responsive">
                            </div>
                        </div>';
					$i++;
					}
                $content[$k] .= '</div> 
								<div class="controls">
                        <a class="left fa fa-chevron-left" href="#full-1" data-slide="prev"> </a>
                        <a class="right fa fa-chevron-right" href="#full-1" data-slide="next"> </a>
                    </div>
				</div>
            </div>';
				} else {
					$content[$k] = '';
				}
				
			}
			else if($short_code_type[0] == 'latestproduct_list')
			{
				$conditions = array();
				$order = array('created_date'=>'DESC');
				$limit = 5;
				$latestProducts = $this->Layout->productlist($conditions, $order, $limit);
				
				$content[$k] = '<div class="sep-heading-container shc4 clearfix">
									<h4>Recent Products</h4>
									<div class="sep-container">
										<div class="the-sep"></div>
									</div>
								</div>
								<div class="list-group products">';
				if(!empty($latestProducts)){
					foreach($latestProducts as $latestProduct){
						$content[$k] .= $this->Html->link($this->Html->image(IMGPATH.'product_image/thumb/'.$latestProduct['Product']['product_image'], array('alt'=>$latestProduct['Product']['product_name'], 'class'=>'img-responsive')).'<p class="name">'.$latestProduct['Product']['product_name'].'</p><p class="price main-text-color">'.CURRENCY.number_format($this->Layout->actualprice($latestProduct['Product']['id']),2).'</p>', SITE_URL.'/'.$latestProduct['Product']['product_slug'], array('escape'=>false, 'class'=>'list-group-item'));
					}
				} else {
					$content[$k] .= '<div class=""></div>';
				}
				
				$content[$k] .= '</div>';
			}
			else if($short_code_type[0] == 'bestseller_list')
			{
				
				$products = $this->Layout->bestseller();
				
				$content[$k] = '<div class="sep-heading-container shc4 clearfix">
									<h4>Best Seller</h4>
									<div class="sep-container">
										<div class="the-sep"></div>
									</div>
								</div>
								<div class="list-group products">';
				if(!empty($products)){
					foreach($products as $product){
						$content[$k] .= $this->Html->link($this->Html->image(IMGPATH.'product_image/thumb/'.$product['Product']['product_image'], array('alt'=>$product['Product']['product_name'], 'class'=>'img-responsive')).'<p class="name">'.$product['Product']['product_name'].'</p><p class="price main-text-color">'.CURRENCY.number_format($this->Layout->actualprice($product['Product']['id']),2).'</p>', SITE_URL.'/'.$product['Product']['product_slug'], array('escape'=>false, 'class'=>'list-group-item'));
					}
				} else {
					$content[$k] .= '<div class=""></div>';
				}
				
				$content[$k] .= '</div>';
			}
			else if($short_code_type[0] == 'featureditem')
			{
				$content[$k] = '<div class="shop-wrapper main-el clearfix">
                        <div class="col-md-12">
                            <div class="sep-heading-container shc4 clearfix">
                                <h4>Featured Items</h4>
                                <div class="sep-container">
                                    <div class="the-sep"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 product-list">

                            <div class="ajax-page-preloader" style="position: relative;">
                                <div class="loader spinner">
                                    <img src="'.IMGPATH1.'loader.gif" width="24" height="24">
                                    <div class="dot1"></div><div class="dot2"></div><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div>
                                </div>
                            </div>

                            <div class="row">';
							
							$conditions = array();
							$conditions['Product'] = array('featured_flag'=>'TRUE');
							$order = array('product_name'=>'ASC');
							$limit = 4;
							$featured = $this->Layout->productlist($conditions, $order, $limit);
							//pr($featured);
							if(!empty($featured))
							{
								foreach($featured as $ftr)
								{ 
									$options = $this->Layout->mouldOptions($ftr['Product']['id']);	
									$content[$k] .= '<div class="col-md-3 col-sm-6 main-el">
														<div class="shop-col-item">
															<div class="photo">'.
																$this->Html->link($this->Html->image(IMGPATH.'product_image/resize/'.$ftr['Product']['product_image'], array('alt'=>$ftr['Product']['product_name'], 'class'=>'img-responsive')), SITE_URL.$ftr['Product']['product_slug'], array('escape'=>false))
															.'</div>
															<div class="info">
																<div>
																	<div class="price">
																		<h5>'.$this->Html->link($ftr['Product']['product_name'], SITE_URL.$ftr['Product']['product_slug']).'</h5>
																		<h5 class="main-text-color">'.CURRENCY.number_format($this->Layout->actualprice($ftr['Product']['id']),2).'</h5>
																	</div>
																	<div class="rating">
																		<i class="main-text-color fa fa-star"></i>
																		<i class="main-text-color fa fa-star"></i>
																		<i class="main-text-color fa fa-star"></i>
																		<i class="main-text-color fa fa-star"></i>
																		<i class="fa fa-star"></i>
																	</div>
																</div>
																<div class="btns clear-left">';
																if(!empty($options))
																{
																	$content[$k] .= '<p class="btn-add"><i class="fa fa-shopping-cart"></i><a href="'.SITE_URL.$ftr['Product']['product_slug'].'">Add to cart</a></p>';
																}
																else
																{
																	$content[$k] .= '<p class="btn-add"><i class="fa fa-shopping-cart"></i><a href="javascript:void(0)" onclick="submitcart('.$ftr['Product']['id'].')">Add to cart</a></p>'
															
																	 .$this->Form->create('Cart', array('id'=>'singlecart'.$ftr['Product']['id'], 'onsubmit'=>'return add_to_cart(this);', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))).
																	 $this->Form->input('session_id', array('type'=>'hidden', 'value'=>$this->Session->read('session_id'))).
																	 $this->Form->input('product_id', array('type'=>'hidden', 'value'=>$ftr['Product']['id'])).
																	 $this->Form->input('quantity', array('type'=>'hidden', 'value'=>1)).
																	 $this->Form->input('unit_price', array('type'=>'hidden', 'value'=>$this->Layout->actualprice($ftr['Product']['id']))).
																	 $this->Form->input('CartOption', array('type'=>'hidden', 'name'=>'data[CartOption]', 'value'=>'')).
																	 $this->Form->input('add_to_cart_url', array('type'=>'hidden', 'class'=>'addtocarturl', 'value'=>$this->Html->url(array('controller'=>'Products', 'action'=>'ajaxminicart', 'full_base'=>true)))).
																	 $this->Form->input('showminicart', array('type'=>'hidden', 'class'=>'showminicart', 'value'=>$this->Html->url(array('controller'=>'Products', 'action'=>'showminicart', 'full_base'=>true)))).
																	 $this->Form->end();
																
																}
																$content[$k] .= '<p class="btn-details"><i class="fa fa-list"></i><a href="'.SITE_URL.$ftr['Product']['product_slug'].'">More details</a></p>
																</div>
																<div class="clearfix"></div>
															</div>
														</div>
													</div>';
								}
                            }
							else
							{
								$content[$k] .= '<div class="alert alert-noicon sc">
									<div class="text col-md-12 col-sm-7">
										<center><strong>No featured product available here.</strong></center>
									</div>
									<div class="clearfix"></div>
								</div>';
							}
						$conditionStr = urlencode(json_encode(array('Product'=>array('featured_flag'=>'TRUE'))) );
                        $content[$k] .= '</div>
                        </div>
						<div class="load inside col-md-12">'.
						$this->Html->link('<div class="over"><span>load more</span><div class="ajax-preloader">'.$this->Html->image(IMGPATH1.'button-loader.gif', array('alt'=>'loading..')).'</div></div>', 'javascript:void(0);', array('escape'=>false, 'class'=>'button blue solid md', 'id'=>'product-loadmore', "data-conditions"=>$conditionStr, 'data-limit'=>4, 'data-offset'=>4, 'data-url'=>$this->Html->url(array('controller'=>'Products', 'action'=>'ajaxproductlist', 'full_base'=>true)), 
						'data-productcounturl'=>$this->Html->url(array('controller'=>'Products', 'action'=>'productcount', 'full_base'=>true))
						)).
						'</div>
					</div>';
			}
			else if($short_code_type[0] == 'newarrival_carousel')
			{
				$conditions = array();
				$conditions['Product'] = array('newcollection_flag'=>'TRUE');
				$order = array('created_date'=>'DESC');
				$limit = 10;
				$products = $this->Layout->productlist($conditions, $order, $limit);
				
				$content[$k] = '<div class="crsl-wrap spaced-top">
									<div id="shop-crsl-2" class="carousel slide carousel-fade shop-crsl" data-ride="carousel">
										<div class="carousel-inner">';
				if(!empty($products)){
					$count = 0;
					$r = 0;
					foreach($products as $product){
						$options = $this->Layout->mouldOptions($product['Product']['id']);	
						$count++;
						if($count%4==1){
							$r++;
							$content[$k] .=	($r==1)?'<div class="item active">':'<div class="item">';
							$content[$k] .=	'<div class="row">';
						}
						$content[$k] .=	'<div class="col-sm-3">
											<div class="shop-col-item">
												<div class="photo">'
													.$this->Html->link($this->Html->image(IMGPATH.'product_image/resize/'.$product['Product']['product_image'], array('alt'=>$product['Product']['product_name'], 'class'=>'img-responsive')), SITE_URL.$product['Product']['product_slug'], array('escape'=>false)).
												'</div>
												<div class="info">
													<div>
														<div class="price">
															<h5>'.$this->Html->link($product['Product']['product_name'], SITE_URL.$product['Product']['product_slug']).'</h5>
															<h5 class="main-text-color">'.CURRENCY.number_format($this->Layout->actualprice($product['Product']['id']),2).'</h5>
														</div>
														<div class="rating">
															<i class="main-text-color fa fa-star"></i>
															<i class="main-text-color fa fa-star"></i>
															<i class="main-text-color fa fa-star"></i>
															<i class="main-text-color fa fa-star"></i>
															<i class="fa fa-star"></i>
														</div>
													</div>
													<div class="btns clear-left">';
														if(!empty($options))
														{
															$content[$k] .= '<p class="btn-add"><i class="fa fa-shopping-cart"></i><a href="'.SITE_URL.$product['Product']['product_slug'].'">Add to cart</a></p>';
														}
														else
														{
															$content[$k] .= '<p class="btn-add"><i class="fa fa-shopping-cart"></i><a href="javascript:void(0)" onclick="submitcart('.$product['Product']['id'].')">Add to cart</a></p>'
													
															 .$this->Form->create('Cart', array('id'=>'singlecart'.$product['Product']['id'], 'onsubmit'=>'return add_to_cart(this);', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))).
															 $this->Form->input('session_id', array('type'=>'hidden', 'value'=>$this->Session->read('session_id'))).
															 $this->Form->input('product_id', array('type'=>'hidden', 'value'=>$product['Product']['id'])).
															 $this->Form->input('quantity', array('type'=>'hidden', 'value'=>1)).
															 $this->Form->input('unit_price', array('type'=>'hidden', 'value'=>$this->Layout->actualprice($product['Product']['id']))).
															 $this->Form->input('CartOption', array('type'=>'hidden', 'name'=>'data[CartOption]', 'value'=>'')).
															 $this->Form->input('add_to_cart_url', array('type'=>'hidden', 'class'=>'addtocarturl', 'value'=>$this->Html->url(array('controller'=>'Products', 'action'=>'ajaxminicart', 'full_base'=>true)))).
															 $this->Form->input('showminicart', array('type'=>'hidden', 'class'=>'showminicart', 'value'=>$this->Html->url(array('controller'=>'Products', 'action'=>'showminicart', 'full_base'=>true)))).
															 $this->Form->end();
														
														}
														$content[$k] .= '<p class="btn-details"><i class="fa fa-list"></i><a href="'.SITE_URL.$product['Product']['product_slug'].'">More details</a></p>
													</div>
													<div class="clearfix"></div>
												</div>
											</div>
										</div>';
						if( ($count == count($products)) || ($count%4 == 0)){
							$content[$k] .=	'</div></div>';
						}
					}
				}
				$content[$k] .= '</div>
								<div class="controls">
									<a class="left fa fa-chevron-left" href="../#shop-crsl-2" data-slide="prev"> </a>
									<a class="right fa fa-chevron-right" href="../#shop-crsl-2" data-slide="next"> </a>
								</div>
							</div>
						</div>';
			}
			else if($short_code_type[0] == 'bestseller_carousel')
			{
				$products = $this->Layout->bestseller();
				$content[$k] = '<div class="crsl-wrap spaced-top">
									<div id="shop-crsl-1" class="carousel slide carousel-fade shop-crsl" data-ride="carousel">
										<div class="carousel-inner">';
				if(!empty($products)){
					$count = 0;
					$r = 0;
					foreach($products as $product){
						$options = $this->Layout->mouldOptions($product['Product']['id']);	
						$count++;
						if($count%4==1){
							$r++;
							$content[$k] .=	($r==1)?'<div class="item active">':'<div class="item">';
							$content[$k] .=	'<div class="row">';
						}
						$content[$k] .=	'<div class="col-sm-3">
											<div class="shop-col-item">
												<div class="photo">'
													.$this->Html->link($this->Html->image(IMGPATH.'product_image/resize/'.$product['Product']['product_image'], array('alt'=>$product['Product']['product_name'], 'class'=>'img-responsive')), SITE_URL.$product['Product']['product_slug'], array('escape'=>false)).
												'</div>
												<div class="info">
													<div> 
														<div class="price">
															<h5>'.$this->Html->link($product['Product']['product_name'], SITE_URL.$product['Product']['product_slug']).'</h5>
															<h5 class="main-text-color">'.CURRENCY.number_format($this->Layout->actualprice($product['Product']['id']),2).'</h5>
														</div>
														<div class="rating">
															<i class="main-text-color fa fa-star"></i>
															<i class="main-text-color fa fa-star"></i>
															<i class="main-text-color fa fa-star"></i>
															<i class="main-text-color fa fa-star"></i>
															<i class="fa fa-star"></i>
														</div>
													</div>
													<div class="btns clear-left">';
														if(!empty($options))
														{
															$content[$k] .= '<p class="btn-add"><i class="fa fa-shopping-cart"></i><a href="'.SITE_URL.$product['Product']['product_slug'].'">Add to cart</a></p>';
														}
														else
														{
															$content[$k] .= '<p class="btn-add"><i class="fa fa-shopping-cart"></i><a href="javascript:void(0)" onclick="submitcart('.$product['Product']['id'].')">Add to cart</a></p>'
													
															 .$this->Form->create('Cart', array('id'=>'singlecart'.$product['Product']['id'], 'onsubmit'=>'return add_to_cart(this);', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))).
															 $this->Form->input('session_id', array('type'=>'hidden', 'value'=>$this->Session->read('session_id'))).
															 $this->Form->input('product_id', array('type'=>'hidden', 'value'=>$product['Product']['id'])).
															 $this->Form->input('quantity', array('type'=>'hidden', 'value'=>1)).
															 $this->Form->input('unit_price', array('type'=>'hidden', 'value'=>$this->Layout->actualprice($product['Product']['id']))).
															 $this->Form->input('CartOption', array('type'=>'hidden', 'name'=>'data[CartOption]', 'value'=>'')).
															 $this->Form->input('add_to_cart_url', array('type'=>'hidden', 'class'=>'addtocarturl', 'value'=>$this->Html->url(array('controller'=>'Products', 'action'=>'ajaxminicart', 'full_base'=>true)))).
															 $this->Form->input('showminicart', array('type'=>'hidden', 'class'=>'showminicart', 'value'=>$this->Html->url(array('controller'=>'Products', 'action'=>'showminicart', 'full_base'=>true)))).
															 $this->Form->end();
														
														}
														$content[$k] .= '<p class="btn-details"><i class="fa fa-list"></i><a href="'.SITE_URL.$product['Product']['product_slug'].'">More details</a></p>
													</div>
													<div class="clearfix"></div>
												</div>
											</div>
										</div>';
						if( ($count == count($products)) || ($count%4 == 0)){
							$content[$k] .=	'</div></div>';
						}
					}
				}
				$content[$k] .= '</div>
								<div class="controls">
									<a class="left fa fa-chevron-left" href="../#shop-crsl-1" data-slide="prev"> </a>
									<a class="right fa fa-chevron-right" href="../#shop-crsl-1" data-slide="next"> </a>
								</div>
							</div>
						</div>';
			}
			else if($short_code_type[0] == 'faq')
			{
				App::import('Model','FaqCategory');
				App::import('Model','Faq');
				$faq_model = new FaqCategory();
	   
				$faq_model->bindModel(
					array('hasMany' => array(
							'Faq' => array(
								'className' => 'Faq',
								'foreignKey'=>'category_id',
								'conditions'=>array('Faq.status'=>'Y','Faq.isdel'=>'0'),
							)
						)
					)
				);
				
				$faq_array = $faq_model->find('all', array('conditions'=>array(													'FaqCategory.isdel'=>'0',
															 'FaqCategory.status'=>'Y')));
															 
				//pr($faq_array);
				
				
					$content[$k] = '<ol class="breadcrumb accordion-filter" id="accordion-4-filters">
									<li class="active filter" data-filter="all">All</li>';
						$check_prev='';
						foreach($faq_array as $faq_content)
						{
							if($faq_content['FaqCategory']['category']!=$check_prev)
							{
								$content[$k] .='<li class="filter" data-filter="category-'.$faq_content['FaqCategory']['id'].'">'.$faq_content['FaqCategory']['category'].'</li>';
							}
							$check_prev = $faq_content['FaqCategory']['category'];
						}
                    $content[$k] .='</ol>';
					
                    $content[$k] .='<div class="panel-group accordion filter-panel" id="accordion-4">';
							$i=1;
							
						foreach($faq_array as $cat)
						{	
							foreach($cat['Faq'] as $faq_content)
							{
								
                                    $content[$k] .='<div class="panel panel-default category-'.$cat['FaqCategory']['id'].'">
                                        <div class="panel-heading  box-background alt-bg-color">
                                            <h6 class="panel-title">
                                                <a data-toggle="collapse" class="collapsed box-text" data-parent="#accordion-4" href="#acc-4-'.$i.'">
                                                    <i class="fa "></i>
													'.$faq_content['faq_questions'].'
                                                </a>
                                            </h6>
                                        </div>
                                        <div id="acc-4-'.$i.'" class="panel-collapse collapse">
                                            <div class="panel-body box-background">
                                                <p class="box-text">
													'.$faq_content['faq_answers'].'
                                                </p>
                                            </div>
                                        </div>
                                    </div>';
								$i++;
							}
							
						}
					$content[$k] .='</div>';		
			}
			else if($short_code_type[0] == 'social')
			{
				App::import('Model','SocialWidget');
				
					$social_model = new SocialWidget();
				   
				  
					$social_array = $social_model->findByIdAndIsdelAndStatus(									$short_code_type[1],'0','Y');
					if(!empty($social_array)){
						$content[$k] = ($social_array['SocialWidget']['headingfrontend_flag']=='Y')?
										'<div class="sep-heading-container shc4 clearfix">
											<h4>'.$social_array['SocialWidget']['title'].'</h4>
											<div class="sep-container">
												<div class="the-sep"></div>
											</div>
										</div>':'';
					} else {
						$content[$k] = '';
					}
					
					foreach($social_array as $socialWidget)
					{
						$content[$k] .=	'<a class="'.$socialWidget['link_class'].'" href="'.$socialWidget['link'].'" target="_blank" title="" data-toggle="tooltip" data-original-title="'.$socialWidget['title'].'"><i class="fa fa-'.$socialWidget['class'].'"></i></a>';
					}
					
					//$content = array_reverse($content);
			}
			
			else if($short_code_type[0] == 'Text')
			{
				App::import('Model','Text');
			
				$text_model = new Text();
			   
			  
				$text_array = $text_model->findByIdAndIsdelAndStatus($short_code_type[1],'0','Y');
				
				if(!empty($text_array)){
					$content[$k] = ($text_array['Text']['headingfrontend_flag']=='Y')?
									'<div class="sep-heading-container shc4 clearfix">
										<h4>'.$text_array['Text']['name'].'</h4>
										<div class="sep-container">
											<div class="the-sep"></div>
										</div>
									</div>':'';
				} else {
					$content[$k] = '';
				}
					
				if(isset($text_array['Text']) ){
				//pr($text_array); exit;
					foreach($text_array as $textWidget)
					{
						$content[$k] .=	$textWidget['text'];
					}
				} else {
					$content[$k] = '';
				
				}
			}
			else if($short_code_type[0] == 'Scrollbg')
			{
				App::import('Model','ScrollBanner');
				$scroll_model = new ScrollBanner();
				$scroll_array = $scroll_model->findByIdAndIsdelAndStatus($short_code_type[1],'0','Y');
				
				if(!empty($scroll_array))
				{
					$content[$k] = ($scroll_array['ScrollBanner']['headingfrontend_flag']=='Y')?
									'<div class="sep-heading-container shc4 clearfix">
										<h4>'.$scroll_array['ScrollBanner']['name'].'</h4>
										<div class="sep-container">
											<div class="the-sep"></div>
										</div>
									</div>':'';
									
					$content[$k] .= '<div class="alt-banner parallax" data-stellar-background-ratio="0.15" style="background: url('.IMGPATH .'scroll_image/original/'.$scroll_array['ScrollBanner']['scroll_image'].') repeat center center;">
					<div class="container v-al-container">
						<div class="text-center v-al">
							<div class="title">
								<span class="alt-text-color">'.$scroll_array['ScrollBanner']['title'].'</span>
							</div>
							<div class="text alt-text-color">'.$scroll_array['ScrollBanner']['content'].'
							</div>
							<div class="btns padiing-btm">
					            <a class="button striped alt-color md" href="'.$scroll_array['ScrollBanner']['button_one_link'].'">'.$scroll_array['ScrollBanner']['button_one_text'].'</a>
								
								<a class="button solid alt-color md" href="'.$scroll_array['ScrollBanner']['button_two_link'].'"><div class="over">'.$scroll_array['ScrollBanner']['button_two_text'].'</div></a>
							</div>
							
						</div>
					</div>
					<div class="banner-over"></div>
				</div>';
				}
				else{
					$content[$k] = '';
				}
			}
			else if($short_code_type[0] == 'Sidebar')
			{
				App::import('Model','Sidebar');
			
				$Sidebar_model = new Sidebar();
				
				$Sidebar_model->bindModel(array(
						'hasMany'=>array(
							'SidebarOption'=>array(
								'className'=>'SidebarOption',
								'foreignKey'=>'sidebar_id',
								'order'=>array('SidebarOption.sort_order ASC')
							)
						)
					)
				);
			   
				$Sidebar_array = $Sidebar_model->findById($short_code_type[1]);
				
				$str = '<div class="sidebar main-el">';
				
				if(!empty($Sidebar_array['SidebarOption'])){
					foreach($Sidebar_array['SidebarOption'] as $widget){
						$str .= $this->makeHtml($widget['widget_shortcode']);
					}
				}
				$str .= '</div>';
				
				$content[$k] = $str;
				
			}
			else if($short_code_type[0] == 'Portfolio')
			{
				App::import('Model','Portfolio');
				App::import('Model','PortfolioContent');
				$portfolio_model = new Portfolio();
	   
				$portfolio_model->bindModel(
					array('hasMany' => array(
							'PortfolioContent' => array(
								'className' => 'PortfolioContent',
								'foreignKey'=>'portfolio_id',
								'conditions'=>array('PortfolioContent.status'=>'Y','PortfolioContent.isdel'=>'0'),
							)
						)
					)
				);
				
				$portfolio_array = $portfolio_model->findById($short_code_type[1]);
				
				//pr($portfolio_array);
				
				if($portfolio_array['Portfolio']['category_type']=='Y')
				{
					$catgories = explode(",",$portfolio_array['Portfolio']['category']);
					
					if($portfolio_array['Portfolio']['style']=='style6')
					{
						$str='<div class="container"><div class="row"><ol class="breadcrumb portfolio-isotope-filters main-el">
								<li class="filter active" data-filter="*"><a>All</a></li>';
								foreach($catgories as $category)
								{
									$str.='<li class="filter" data-filter=".'.str_replace(" ", "-",$category).'"><a>'.ucfirst($category).'</a></li>';
								}
								$str.='</ol></div></div>

									<div class="ajax-page-preloader" style="position: relative;">
										<div class="loader spinner">
											<img src="'.IMGPATH1.'loader.gif" width="24" height="24">
											<div class="dot1"></div><div class="dot2"></div><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div>
										</div>
									</div>
								
								<div class="full-portfolio">
									<div class="portfolio-isotope isotope-container clearfix">';
										foreach($portfolio_array['PortfolioContent'] as $portcontent)
										{
											$str.='<div class="item-wrap isotope-element '.str_replace(" ", "-",$portcontent['category']).'">
												<div class="item">
													<a class="overlay mgp-img" href="'.IMGPATH .'portfolio_image/resize/'.$portcontent['image'].'">
														<i class="fa fa-search md alt-text-color"></i>
														<div class="title light alt-text-color">'.$portcontent['title'].'</div>
													</a>
													<img src="'.IMGPATH .'portfolio_image/thumb/'.$portcontent['image'].'" alt="" class="img-responsive">
												</div>
											</div>';
										}
								$str.='</div>
									</div>';
					}
					else if($portfolio_array['Portfolio']['style']=='style7')
					{
						$str='<div class="list portfolio">
								<div class="container">
									<div class="row">
										<ol class="breadcrumb portfolio-isotope-filters main-el">
											<li class="filter active" data-filter="*"><a>All</a></li>';
											foreach($catgories as $category)
											{
												$str.='<li class="filter" data-filter=".'.$category.'"><a>'.ucfirst($category).'</a></li>';
											}
										$str.='</ol>

										<div class="ajax-page-preloader" style="position: relative;">
											<div class="loader spinner">
												<img src="'.IMGPATH1.'loader.gif" width="24" height="24">
												<div class="dot1"></div><div class="dot2"></div><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div>
											</div>
										</div>

										<div class="portfolio-isotope isotope-container">';
										foreach($portfolio_array['PortfolioContent'] as $portcontent)
										{	
											$str.='<div class="item col-md-12 isotope-element '.$portcontent['category'].'">
												<div class="row">
													<div class="col-sm-6 main-el">
														<div class="photo">
															<a class="overlay mgp-img" href="'.IMGPATH .'portfolio_image/resize/'.$portcontent['image'].'">
																<i class="fa fa-search md alt-text-color"></i>
															</a>
															<img src="'.IMGPATH .'portfolio_image/resize/'.$portcontent['image'].'" class="img-responsive" alt="">
														</div>
													</div>
													<div class="col-sm-6 main-el details">
														<h3><a>'.$portcontent['title'].'</a></h3>
														<p>'.$portcontent['content'].'</p>
														<span class="main-text-color visit"><a href="'.$portcontent['link'].'">Visit Website </a><i class="fa fa-play-circle-o"></i></span>
													</div>
												</div>

												<div class="sep"></div>

											</div>';
										}
											
										
								$str.='</div>

							</div>';
					}
					else
					{
						if($portfolio_array['Portfolio']['position']=='1')
						{
								if($portfolio_array['Portfolio']['style']=='style1')
								{
									$divstruc = 'col-md-3 col-sm-6';
								}
								else if($portfolio_array['Portfolio']['style']=='style2')
								{
									$divstruc = 'col-md-4';
								}
								else if($portfolio_array['Portfolio']['style']=='style3')
								{
									$divstruc = 'col-md-6';
								}
								else if($portfolio_array['Portfolio']['style']=='style4')
								{
									$divstruc = 'col-lg-4 col-sm-6';
								}
								else
								{
									$divstruc = '';
								}
								$str='<ol class="breadcrumb portfolio-isotope-filters main-el">
										<li class="filter active" data-filter=".all-'.$short_code_type[1].'"><a>All</a></li>';
										foreach($catgories as $category)
										{
											$str.='<li class="filter" data-filter=".'.str_replace(" ", "-",$category).'"><a>'.ucfirst($category).'</a></li>';
										}
								$str.='</ol>

									<div class="ajax-page-preloader" style="position: relative;">
										<div class="loader spinner">
											<img src="'.IMGPATH1.'loader.gif" width="24" height="24">
											<div class="dot1"></div><div class="dot2"></div><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div>
										</div>
									</div>

									<div class="portfolio-isotope isotope-container">';
									
									foreach($portfolio_array['PortfolioContent'] as $portcontent)
									{
									   $str.='<div class="'.$divstruc.' main-el isotope-element all-'.$short_code_type[1].' '.str_replace(" ", "-",$portcontent['category']).'">
											<div class="portfolio item">
												<div class="top">
													<a class="overlay mgp-img" href="'.IMGPATH .'portfolio_image/resize/'.$portcontent['image'].'">
														<i class="fa fa-search md alt-text-color"></i>
													</a>
													<a href="#"><img class="img-responsive" src="'.IMGPATH .'portfolio_image/thumb/'.$portcontent['image'].'" alt=""></a>

												</div>

												<div class="bot">
													<h5><a target="_blank" href="'.(($portcontent['link']!='')?$portcontent['link']:'#').'">'.$portcontent['title'].'</a>
														</h5>
												</div>
											</div>
										</div>';
										
									}
									$str.='</div>';
							
						}
						if($portfolio_array['Portfolio']['position']=='2')
						{
							if($portfolio_array['Portfolio']['style']=='style1')
							{
								$divstruc = 'col-4';
							}
							else if($portfolio_array['Portfolio']['style']=='style2')
							{
								$divstruc = '';
							}
							else if($portfolio_array['Portfolio']['style']=='style3')
							{
								$divstruc = 'col-2';
							}
							else
							{
								$divstruc = '';
							}
							
							$str = '<div class="fancy-portfolio wrap '.$divstruc.'">';
							$str .='<ol class="breadcrumb portfolio-isotope-filters">
										<li class="filter active" data-filter=".all-'.$short_code_type[1].'"><a>All</a></li>';
										foreach($catgories as $category)
										{
											$cat_arr = explode(" ",$category);
											$str.='<li class="filter" data-filter=".'.$cat_arr[0].'"><a>'.ucfirst($category).'</a></li>';
										}
							$str.='</ol>

								<div class="ajax-page-preloader" style="position: relative;">
									<div class="loader spinner">
										<img src="'.IMGPATH1.'loader.gif" width="24" height="24">
										<div class="dot1"></div><div class="dot2"></div><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div>
									</div>
								</div>

								<div class="portfolio-isotope isotope-container">';
									
									foreach($portfolio_array['PortfolioContent'] as $portcontent)
									{
										$cat_arr1 = explode(" ",$portcontent['category']);
										$str.='<div class="item wrap isotope-element all-'.$short_code_type[1].' '.$cat_arr1[0].'">
											<div class="item">
												<a class="overlay mgp-img" href="'.IMGPATH .'portfolio_image/resize/'.$portcontent['image'].'">
													<i class="fa fa-search md alt-text-color"></i>
													<div class="title light alt-text-color">'.$portcontent['title'].'</div>
												</a>
												<img src="'.IMGPATH .'portfolio_image/thumb/'.$portcontent['image'].'" alt="" class="img-responsive">
											</div>
										</div>';
									}

									
								$str.='</div>
								
							</div>';
						}
					}
				}
				if($portfolio_array['Portfolio']['category_type']=='N')
				{
					if($portfolio_array['Portfolio']['style']=='style6')
					{
						$str='<div class="ajax-page-preloader" style="position: relative;">
										<div class="loader spinner">
											<img src="'.IMGPATH1.'loader.gif" width="24" height="24">
											<div class="dot1"></div><div class="dot2"></div><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div>
										</div>
									</div>
								
								<div class="full-portfolio">
									<div class="portfolio-isotope isotope-container clearfix">';
										foreach($portfolio_array['PortfolioContent'] as $portcontent)
										{
											$str.='<div class="item-wrap isotope-element '.$portcontent['category'].'">
												<div class="item">
													<a class="overlay mgp-img" href="'.IMGPATH .'portfolio_image/resize/'.$portcontent['image'].'">
														<i class="fa fa-search md alt-text-color"></i>
														<div class="title light alt-text-color">'.$portcontent['title'].'</div>
													</a>
													<img src="'.IMGPATH .'portfolio_image/thumb/'.$portcontent['image'].'" alt="" class="img-responsive">
												</div>
											</div>';
										}
								$str.='</div>
									</div>';
					}
					else if($portfolio_array['Portfolio']['style']=='style5')
					{
						$str='<div class="content">
								<div id="portfolio-single-1" class="portfolio single carousel slide" data-ride="carousel">
									<div class="container">
										<div class="carousel-inner">';
									$i=0;	
									$max = count($portfolio_array['PortfolioContent']);
									foreach($portfolio_array['PortfolioContent'] as $portcontent)
									{
										$str.='<div class="item '.($i==0?'active':'').'">
													<div class="row">
														<div class="col-md-8 col-sm-6">
															<div class="photo">
																<a class="overlay mgp-img" href="'.IMGPATH .'portfolio_image/resize/'.$portcontent['image'].'">
																	<i class="fa fa-search md alt-text-color"></i>
																</a>
																<img class="img-responsive" src="'.IMGPATH .'portfolio_image/resize/'.$portcontent['image'].'" alt="">
															</div>
														</div>

														<div class="col-md-4 col-sm-6">
															<div class="info">
																<h3>'.$portcontent['title'].'</h3>
																
																<p>'.$portcontent['content'].'</p>

																<a traget="_blank" href="'.$portcontent['link'].'" class="button solid blue md"><div class="over">'.$portcontent['linktext'].'</div></a>
															</div>
														</div>
													</div>
												</div>';
										$i++;		
									}
											
								$str.='</div>
									</div>

									<div class="sg-controls">
										<a class="left" href="#portfolio-single-1" data-slide="prev">
											<i class="fa fa-chevron-left"></i>
											
										</a>

										<a class="right" href="#portfolio-single-1" data-slide="next">
											<i class="fa fa-chevron-right"></i>
											
										</a>


									</div>

								</div>
								<div class="clearfix"></div>
							</div>';
					}
					else if($portfolio_array['Portfolio']['style']=='style7')
					{
						$str='<div class="list portfolio">
								<div class="container">
									<div class="row">

										<div class="ajax-page-preloader" style="position: relative;">
											<div class="loader spinner">
												<img src="'.IMGPATH1.'loader.gif" width="24" height="24">
												<div class="dot1"></div><div class="dot2"></div><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div>
											</div>
										</div>

										<div class="portfolio-isotope isotope-container">';
										foreach($portfolio_array['PortfolioContent'] as $portcontent)
										{	
											$str.='<div class="item col-md-12 isotope-element '.$portcontent['category'].'">
												<div class="row">
													<div class="col-sm-6 main-el">
														<div class="photo">
															<a class="overlay mgp-img" href="'.IMGPATH .'portfolio_image/resize/'.$portcontent['image'].'">
																<i class="fa fa-search md alt-text-color"></i>
															</a>
															<img src="'.IMGPATH .'portfolio_image/resize/'.$portcontent['image'].'" class="img-responsive" alt="">
														</div>
													</div>
													<div class="col-sm-6 main-el details">
														<h3><a>'.$portcontent['title'].'</a></h3>
														<p>'.$portcontent['content'].'</p>
														<span class="main-text-color visit"><a href="'.$portcontent['link'].'">Visit Website </a><i class="fa fa-play-circle-o"></i></span>
													</div>
												</div>

												<div class="sep"></div>

											</div>';
										}
											
										
								$str.='</div>

							</div>';
					}
					else
					{
						if($portfolio_array['Portfolio']['position']=='1')
						{
								if($portfolio_array['Portfolio']['style']=='style1')
								{
									$divstruc = 'col-md-3 col-sm-6';
								}
								else if($portfolio_array['Portfolio']['style']=='style2')
								{
									$divstruc = 'col-md-4';
								}
								else if($portfolio_array['Portfolio']['style']=='style3')
								{
									$divstruc = 'col-md-6';
								}
								else
								{
									$divstruc = '';
								}

								$str='<div class="ajax-page-preloader" style="position: relative;">
										<div class="loader spinner">
											<img src="'.IMGPATH1.'loader.gif" width="24" height="24">
											<div class="dot1"></div><div class="dot2"></div><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div>
										</div>
									</div>

									<div class="portfolio-isotope isotope-container">';
									
									foreach($portfolio_array['PortfolioContent'] as $portcontent)
									{
									   $str.='<div class="'.$divstruc.' main-el isotope-element">
											<div class="portfolio item">
												<div class="top">
													<a class="overlay mgp-img" href="'.IMGPATH .'portfolio_image/resize/'.$portcontent['image'].'">
														<i class="fa fa-search md alt-text-color"></i>
													</a>
													<a href="#"><img class="img-responsive" src="'.IMGPATH .'portfolio_image/thumb/'.$portcontent['image'].'" alt=""></a>

												</div>

												<div class="bot">
													<h5><a target="_blank" href="'.(($portcontent['link']!='')?$portcontent['link']:'#').'">'.$portcontent['title'].'</a></h5>
												</div>
											</div>
										</div>';
										
									}
									$str.='</div>';
							
						}
						if($portfolio_array['Portfolio']['position']=='2')
						{
							if($portfolio_array['Portfolio']['style']=='style1')
							{
								$divstruc = 'col-4';
							}
							else if($portfolio_array['Portfolio']['style']=='style2')
							{
								$divstruc = '';
							}
							else if($portfolio_array['Portfolio']['style']=='style3')
							{
								$divstruc = 'col-2';
							}
							else
							{
								$divstruc = '';
							}
							$str='
							<div class="fancy-portfolio wrap '.$divstruc.'">

								<div class="ajax-page-preloader" style="position: relative;">
									<div class="loader spinner">
										<img src="'.IMGPATH1.'loader.gif" width="24" height="24">
										<div class="dot1"></div><div class="dot2"></div><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div>
									</div>
								</div>

								<div class="portfolio-isotope isotope-container">';
									
									foreach($portfolio_array['PortfolioContent'] as $portcontent)
									{
										
										$str.='<div class="item wrap isotope-element">
											<div class="item">
												<a class="overlay mgp-img" href="'.IMGPATH .'portfolio_image/resize/'.$portcontent['image'].'">
													<i class="fa fa-search md alt-text-color"></i>
													<div class="title light alt-text-color">'.$portcontent['title'].'</div>
												</a>
												<img src="'.IMGPATH .'portfolio_image/thumb/'.$portcontent['image'].'" alt="" class="img-responsive">
											</div>
										</div>';
									}

									
								$str.='</div>
								
							</div>';
						}
					}
				}
				
				
				$content[$k] = $str;
			}
			else if($short_code_type[0] == 'Menu')
			{
				App::import('Model','MenuMaster');
				$menumaster_model = new MenuMaster();
				
				$menumaster_model->bindModel(
					array(
						'hasMany'=>array(
							'MenuitemMasters'=>array(
								'className'=>'MenuitemMasters',
								'foreignKey'=>'menu_id'
							)
						)
					)
				);
				
				$menuArr = $menumaster_model->findById($short_code_type[1]);
				if(!empty($menuArr['MenuitemMasters'])){
					
					$str = '<div class="list-group">';
					foreach($menuArr['MenuitemMasters'] as $item){
						$str.= '<a class="list-group-item" href="'.$item['page_url'].'">'.$item['page_title'].'</a>';
					}
					
					$str .= "</div>";
					$content[$k] = $str;
				}
			}
			else if($short_code_type[0] == 'Subscriber')
			{
				$str = $this->Form->create('Subscriber', array('id'=>'subscriberForm', "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))).
						'<div class="input-group">'.
						$this->Form->input('subscriber_email', array('type'=>'text', 'class'=>'form-control', 'data-error-container'=>"#errSubscriber", 'id'=>'subscriberEmailFld', 'placeholder'=>"Enter Subscriber Email",)).
						'<span class="input-group-btn">'.
							$this->Form->button('<span class="over"><i class="fa fa-plane"></i></span>', array('type'=>'submit', 'id'=>'subcriberbuttomid', 'escape'=>false, 'class'=>'btn btn-default button solid blue')).
							$this->Form->input('url', array('type'=>'hidden', 'id'=>'submitUrl', 'value'=>$this->Html->url(array('controller'=>'Subscribers', 'action'=>'ajaxsubcriberaction', 'full_base'=>true)))).
						'</span>'.
						'</div><div id="errSubscriber"></div>'.
						$this->Form->end();
			
				$content[$k] = $str;
			}
			

		}
		return $content;
	
	}
	
	public function make_content($content){
		$haystack = $content;
		$needle1 = '[';
		$needle2 = ']';
		$a = array(); 
		$b = array(); 
		$a = $this->mb_stripos_all($haystack, $needle1);
		$b = $this->mb_stripos_all($haystack, $needle2);
		
		
		if(!empty($a) && !empty($b))
		{
			$c = array();
			$e = array();
			foreach($a as $k=>$d)
			{
				$c[$k] = substr($haystack,($a[$k]+1),($b[$k]-($a[$k]+1)));
				$e[$k] = substr($haystack,($a[$k]),($b[$k]-($a[$k]-1)));
			}
			/* pr($c);
			exit; */
			$content = $this->short_code($c);
			/* pr($content);
			exit; */
			$show_content = str_replace(array_values($e),array_values($content), $haystack);
		}
		else
		{
			$show_content = $haystack;
		}
		echo $show_content;
	}
	
	public function makeHtml($content){
		$content = str_replace("|", "", $content);
		$haystack = $content;
		$needle1 = '[';
		$needle2 = ']';
		$a = array(); 
		$b = array(); 
		$a = $this->mb_stripos_all($haystack, $needle1);
		$b = $this->mb_stripos_all($haystack, $needle2);
		
		
		if(!empty($a) && !empty($b))
		{
			$c = array();
			$e = array();
			foreach($a as $k=>$d)
			{
				$c[$k] = substr($haystack,($a[$k]+1),($b[$k]-($a[$k]+1)));
				$e[$k] = substr($haystack,($a[$k]),($b[$k]-($a[$k]-1)));
			}
		
			$content = $this->short_code($c);
			$show_content = str_replace(array_values($e),array_values($content), $haystack);
		}
		else
		{
			$show_content = $haystack;
		}
		return $show_content;
	}
	
	public function mb_stripos_all($haystack, $needle) {
 
	  $s = 0;
	  $i = 0;
	 
	  while(is_integer($i)) {
	 
		$i = mb_stripos($haystack, $needle, $s);
	 
		if(is_integer($i)) {
		  $aStrPos[] = $i;
		  $s = $i + mb_strlen($needle);
		}
	  }
	 
	  if(isset($aStrPos)) {
		return $aStrPos;
	  } else {
		return false;
	  }
	}
}
?>