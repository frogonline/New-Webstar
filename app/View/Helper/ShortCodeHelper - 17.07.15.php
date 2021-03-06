<?php
App::uses('String', 'Utility');

class ShortCodeHelper extends AppHelper {
	var $helpers = array('Cache','Html','Session','Form','Paginator','MenuitemMasters','Text','Js'=>'Jquery','Layout');
	
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
				
				if(!empty($gallery_array) && $gallery_array['GalleryManagement']['style']=='style1')
				{
					$content[$k] = '<div class="row recent-work margin-bottom-40">
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
					$content[$k] = '<div class="row margin-bottom-40 our-clients">
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
					$content[$k] = '<div class="brands">
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
					$content[$k] = '<div class="gallery preview">
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
					$content[$k] = '<div class="parteners carousel content">
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
			else if($short_code_type[0] == 'Menu')
			{
				App::import('Model','MenuMaster');
				$menumastermodel = new MenuMaster();
				
				//$menuhelper = new MenuitemMasters();
				
				
				$menu_array = $menumastermodel->findById($short_code_type[1]);
				
				$menu_slug = $menu_array['MenuMaster']['menu_slug'];
				
				if($menu_slug == 'information')
				{
					
					$default = array(
								'menu_slug' => 'information',
								'container_div' => false,
								'container_class' => '',
								'container_id' => '',
								'menu_class' => 'list-unstyled',
								'submenu_class' => '',
								'item_wrap' => '',
								'hasChildli_class' => 'dropdown',
								'menu_id' => ''
							);
					 $content[$k] = $this->MenuitemMasters->cp_menu($default); 
					 
				}
				else if($menu_slug == 'ecommerce-header-menu')
				{
					
					$default = array(
							'menu_slug' => 'ecommerce-header-menu',
							'container_div' => false,
							'container_class' => '',
							'container_id' => '',
							'menu_class' => '',
							'submenu_class' => 'dropdown-menu',
							'item_wrap' => '',
							'hasChildli_class' => 'dropdown',
							'menu_id' => ''
						);
					$content[$k] = $this->MenuitemMasters->cp_menu($default);
				}
				else if($menu_slug == 'top-header-ecommerce-menu')
				{
					
					$default = array(
									'menu_slug' => 'top-header-ecommerce-menu',
									'container_div' => false,
									'container_class' => '',
									'container_id' => '',
									'menu_class' => 'list-unstyled list-inline pull-right',
									'submenu_class' => '',
									'item_wrap' => '',
									'hasChildli_class' => '',
									'menu_id' => ''
								);
					$content[$k] = $this->MenuitemMasters->cp_menu($default);
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
				
				$content[$k] = $this->Form->create('Page', array('url'=>array('controller'=>'Pages','action'=>'form_search')),array('id'=>"form-search", 'class'=>"form-search", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))).'<div class="input-group">'.$this->Form->input('input',array('id'=>"input", 'class'=>"form-control",'label'=>false, 'empty'=>false, 'placeholder'=>"Start typing here...")).'<span class="input-group-btn">'.$this->Form->button('', array('class'=>"btn btn-default fa fa-search",'type'=>"submit")).'
                            </span>
                        </div>'.$this->Form->end();
			}
			else if($short_code_type[0] == 'Contact')
			{
				App::import('Model','ContactWidget');
				$ContactWidget = new ContactWidget();
				
				$ContactWidget_array = $ContactWidget->findByIdAndIsActive($short_code_type[1],'0');
			
				if($ContactWidget_array['ContactWidget']['style'] == 'Style1')
				{
					$content[$k] ='<div class="form form-1"><div class="head main-text-color">
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
									'</div>';
				}
				if($ContactWidget_array['ContactWidget']['style'] == 'Style2')
				{
					$content[$k] ='<div class="form form-2">
                                <div class="head main-text-color">
                                '.$ContactWidget_array['ContactWidget']['text'].'
                                </div>

                                <input type="text" class="form-control" placeholder="Name *">
                                <div class="c-border-top">
                                    <input type="text" class="form-control" placeholder="Email *">
                                </div>
                                <textarea rows="4" class="form-control" placeholder="Message *"></textarea>

                                <div class="btns">
                                    <a class="button solid blue sm"><div class="over">submit</div></a>
                                </div>

                            </div>';
				}
				if($ContactWidget_array['ContactWidget']['style'] == 'Style3')
				{
					$content[$k] ='<div class="form-3">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Name *" class="form-control">
                                    </div>

                                    <div class="col-sm-4">
                                        <input type="text" placeholder="E-mail *" class="form-control">
                                    </div>

                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Website" class="form-control">
                                    </div>

                                    <div class="col-xs-12">
                                        <textarea placeholder="Message *" rows="10" class="form-control"></textarea>
                                        <div class="btns">
                                            <a class="button solid sm blue"><div class="over"><i class="fa fa-plane"></i>submit</div></a>
                                            <a class="clear main-text-color pull-right clear">
                                    Clear All <i class="fa fa-times-circle-o"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
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
						if(!empty($post_array) && $post_array['LatestPost']['style']=='1')
						{
							$content[$k] = '<div class="list-group products">';
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
						else if(!empty($post_array) && $post_array['LatestPost']['style']=='2')
						{
							$content[$k] = '<div class="row">';
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
						else if(!empty($post_array) && $post_array['LatestPost']['style']=='3')
						{
							$content[$k] = '<div class="post">';
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
											$text1 = String::truncate($p['Page']['content'],50,
																		array('exact' => false)
																		);		
                                     $content[$k] .= '<p class="comments italic comments">'.$comment.' Comments'.'</p>
                                    <p>'.$text1.' <span class="main-text-color"><a href="'.SITE_URL.$p['Page']['slug'].'">Read More </a><i class="fa fa-play-circle-o"></i> </span> </p>
                                </div>';
								}
                          $content[$k] .= '</div>';
						}
						else if(!empty($post_array) && $post_array['LatestPost']['style']=='4')
						{
							$content[$k] = '';
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
						}
						else if(!empty($post_array) && $post_array['LatestPost']['style']=='5')
						{
							$content[$k] = '<div class="blog-wrapper col-md-9 main-el">';
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
													$comment = $comm->find('count', array('conditions' => array('PostComment.status'=>'Y','PostComment.post_id'=>$p['Page']['id']),
																						'order' => array('PostComment.id' => 'DESC')));
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
				
				if(isset($accordion_array['Accordion']) && $accordion_array['Accordion']['style']=='style3')
				{
					$content[$k] = '<ol class="breadcrumb accordion-filter" id="accordion-4-filters">
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
                                        <div class="panel-heading alt-bg-color">
                                            <h6 class="panel-title">
                                                <a data-toggle="collapse" class="collapsed" data-parent="#accordion-4" href="#acc-4-'.$i.'">
                                                    <i class="fa "></i>
													'.$accordion_content['title'].'
                                                </a>
                                            </h6>
                                        </div>
                                        <div id="acc-4-'.$i.'" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <p>
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
					$content[$k]='<div class="panel-group accordion" id="accordion-2">';
						$i=1;
						foreach($accordion_array['AccordionContent'] as $accordion_content)
						{
                            $content[$k] .='<div class="panel panel-default">
                                        <div class="panel-heading alt-bg-color">
                                            <h6 class="panel-title">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion-2" href="#acc-2-'.$i.'">
                                                    <i class="fa "></i>
														'.$accordion_content['title'].'
                                                </a>
                                            </h6>
                                        </div>
                                        <div id="acc-2-'.$i.'" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <p>
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
					$content[$k]='<div class="panel-group accordion" id="accordion-3">';
					
						$i=1;
						foreach($accordion_array['AccordionContent'] as $accordion_content)
						{
                            $content[$k] .='<div class="panel panel-default">
                                        <div class="panel-heading alt-bg-color">
                                            <h6 class="panel-title">
                                                <a class="collapsed" data-toggle="collapse" href="#acc-3-'.$i.'">
                                                    <i class="fa "></i>
														'.$accordion_content['title'].'
                                                </a>
                                            </h6>
                                        </div>
                                        <div id="acc-3-'.$i.'" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <p>
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
				
				
				if(isset($column_array['Column']) && $column_array['Column']['column_style']=='style1')
				{
					$content[$k] ='<div class="row">
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
				
					$content[$k] ='<div class="row">
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
					
					
					$content[$k] ='<div class="row">
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
					$content[$k] ='<div class="row">
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
				
				
				$content[$k] = '<div class="tags clearfix">';
					foreach($ptag as $ptag)
					{
                            $content[$k] .= '<a href="'.SITE_URL.$ptag['PostTag']['slug'].'" class="tag alt-text-color main-bg-color">'.$ptag['PostTag']['tag_name'].'</a>';
                    }
                        $content[$k] .='</div>';
			}
			else if($short_code_type[0] == 'flickr_photo')
			{
				$content[$k] = '<div class="flickr-container">
                                    <a href="#">
                                        <div class="overlay">
                                            <i class="fa fa-share"></i>
                                        </div>
                                        <img src="../images/fl-1.png" alt="" class="img-responsive">
                                    </a>
                                    <a href="#">
                                        <div class="overlay">
                                            <i class="fa fa-share"></i>
                                        </div>
                                        <img src="../images/fl-2.png" alt="" class="img-responsive">
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
				$content[$k] = '';
				if(isset($box_array['Box']) && $box_array['Box']['boxstyle']=='style1')
				{
					foreach($box_array['BoxContent'] as $boxcontent)
					{
						$content[$k] .= '<div class="col-sm-4 main-el">
											<div class="feature-box">
												<div class="head '.$boxcontent['boxheaderstyle'].' main-bg-color alt-text-color">
													<span>'.$boxcontent['boxheadertitle'].'</span>
												</div>
												<div class="body text-center">
													<h5><a href="'.$boxcontent['boxlink'].'">'.$boxcontent['boxtitle'].'</a></h5>
													<p> '.$boxcontent['boxcontent'].'</p>
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
								$content[$k].='<div class="item">
									<i class="pull-left fa fa-'.$box_array['BoxContent'][$l-1]['sidestyle'].' circled main-bg-color alt-text-color"></i>
									<div class="text">
										<h4>'.$box_array['BoxContent'][$l-1]['boxtitle'].'</h4>
										<p>'.$box_array['BoxContent'][$l-1]['boxcontent'].'</p>
									</div>
								</div>';
							}
						}
						
						$content[$k].='</div>';
					}
				}
				elseif(isset($box_array['Box']) && $box_array['Box']['boxstyle']=='style3')
				{
					foreach($box_array['BoxContent'] as $boxcontent)
					{
						$content[$k] .= '<div class="col-md-4 main-el">
											<div class="card '.$boxcontent['backgroundstyle'].'">
												<div class="background-overlay">
													<div class="top">
														<i class="fa fa-'.$boxcontent['boxheaderstyle'].' alt-text-color pull-left"></i>
														<h4 class="alt-text-color light"> '.$boxcontent['boxtitle'].' </h4>
													</div>
													<p class="alt-text-color">
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
				
				}
				elseif(isset($box_array['Box']) && $box_array['Box']['boxstyle']=='style5')
				{
					foreach($box_array['BoxContent'] as $boxcontent)
					{
						$content[$k] .= '<div class="row item">
											<div class="col-md-12">
												<div class="badge pull-left">
													<i class="main-text-color fa fa-'.$boxcontent['sidestyle'].'"></i>
												</div>
												<div class="text">
													<h5 class="medium"> '.$boxcontent['boxtitle'].'</h5>
													<p>'.$boxcontent['boxcontent'].'</p>
												</div>
											</div>
										</div>';
					}               
				
				}
				elseif(isset($box_array['Box']) && $box_array['Box']['boxstyle']=='style4')
				{
					foreach($box_array['BoxContent'] as $boxcontent)
					{
						$content[$k] .= '<div class="col-sm-4 main-el">
											<div class="box-6">
												<i class="fa fa-'.$boxcontent['boxheaderstyle'].' alt-text-color main-bg-color"></i>
												<h5 class="medium">'.$boxcontent['boxtitle'].'</h5>
												<p>'.$boxcontent['boxcontent'].'
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
												<i class="fa fa-'.$boxcontent['boxheaderstyle'].'"></i>
												<h5 class="medium">'.$boxcontent['boxtitle'].'</h5>
												<p>'.$boxcontent['boxcontent'].'</p>
												<h6 class="main-text-color"><a href="'.$boxcontent['boxlink'].'">Read More</a> <i class="fa fa-play-circle-o"></i> </h6>
											</div>
										</div>';
					}               
				
				}
				elseif(isset($box_array['Box']) && $box_array['Box']['boxstyle']=='style7')
				{
					
						$content[$k] = '<div class="boxes-4">
											<div class="row">';
												
							foreach($box_array['BoxContent'] as $boxcontent)
							{
								$con_array = explode(",",$boxcontent['boxcontent']);
								$content[$k] .= '<div class="col-sm-4 main-el">
													<i class="fa fa-'.$boxcontent['sidestyle'].' pull-left"></i>
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
				
				
				if(isset($tab_array['Tabs']) && $tab_array['Tabs']['style']=='style1')
				{
					
					$content[$k] = '<div id="d-tabs" class="tab def"><ul>';
								$i=1;
								foreach($tab_array['TabContent'] as $tab)
								{
                                  $content[$k] .=   '<li><a href="#d-tabs-'.$i.'"><h6>'.$tab['title'].'</h6></a>
								  </li>';
								  $i++;
								 }
                                $content[$k] .='</ul>';
								$i=1;
								foreach($tab_array['TabContent'] as $tab)
								{
									$content[$k] .= '<div id="d-tabs-'.$i.'">
										<p>'.$tab['content'].'</p>
									</div>';
									$i++;
								}
								
                    $content[$k] .= '</div>';
                                    
				}
				elseif(isset($tab_array['Tabs']) && $tab_array['Tabs']['style']=='style2')
				{
					$content[$k] = '<div id="b-tabs" class="tab tabs-bottom"><ul>';
									$i=1;
									foreach($tab_array['TabContent'] as $tab)
									{
									   $content[$k] .= '<li><a href="#b-tabs-'.$i.'"><h6>'.$tab['title'].'</h6></a></li>';
										$i++;
									}  
                                $content[$k] .='</ul>';
								$i=1;
								foreach($tab_array['TabContent'] as $tab)
								{
                              $content[$k] .=  '<div class="tabs-spacer"></div>
                                <div id="b-tabs-'.$i.'">
                                    <p>'.$tab['content'].'</p> 
                                </div>';
								$i++;
								}
                            $content[$k] .=  '</div>';               
				}
				elseif(isset($tab_array['Tabs']) && $tab_array['Tabs']['style']=='style3')
				{
					$content[$k]='<div id="l-tabs" class="tab left"><ul>';                           
                                    $i=1;
									foreach($tab_array['TabContent'] as $tab)
									{
										$content[$k] .= '<li><a href="#l-tabs-'.$i.'"><h6>'.$tab['title'].'</h6></a></li>';
										$i++;
									} 
                               $content[$k] .=  '</ul>';
							   $i=1;
								foreach($tab_array['TabContent'] as $tab)
								{
                                $content[$k] .= '<div id="l-tabs-'.$i.'">
                                    <p>'.$tab['content'].'</p>
								</div>';
                              $i++;
								}  
                            $content[$k] .=  '</div>';             
                }                 
				elseif(isset($tab_array['Tabs']) && $tab_array['Tabs']['style']=='style4')
				{
					$content[$k]='<div id="r-tabs" class="tab right"><ul>';
									$i=1;
									foreach($tab_array['TabContent'] as $tab)
									{
										$content[$k] .= '<li><a href="#r-tabs-'.$i.'"><h6>'.$tab['title'].'</h6></a></li>';
										$i++;
									} 
                                $content[$k] .= '</ul>';
                                $i=1;
								foreach($tab_array['TabContent'] as $tab)
								{
									$content[$k] .= '<div id="r-tabs-'.$i.'">
                                    <p>'.$tab['content'].'</p>
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
							$content[$k] = '<div class="divider divider-1"></div>';
						}
						else if($short_code_type[1]=='3')
						{
							$content[$k] = '<div class="divider divider-2"></div>';
						}
						else if($short_code_type[1]=='4')
						{
							$content[$k] = '<div class="text-center">
												<div class="divider divider-3"></div>
											</div>';
						}
						else if($short_code_type[1]=='5')
						{
							$content[$k] = '<div class="divider divider-4"></div>';
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
				
				
				if(isset($list_array['ListStyle']) && $list_array['ListStyle']['style']=='style1')
				{
					
					$content[$k] = '<div class="icon list">';
                                  foreach($list_array['ListContent'] as $list)
									{  
										$content[$k] .= '<div class="element">
													<i class="main-bg-color alt-text-color '.$list['listcontentstyle'].' pull-left"></i>
													<p>'.$list['listcontent'].'</p>
												</div>';
									}   
                                 $content[$k] .= '</div>';
                 }                   
				elseif(isset($list_array['ListStyle']) && $list_array['ListStyle']['style']=='style2')
				{
					$content[$k] = '<div class="icon list icon-list-2">';
								foreach($list_array['ListContent'] as $list)
									{  
										$content[$k] .= '<div class="element">
															<i class="main-text-color '.$list['listcontentstyle'].' pull-left"></i>
															<p>'.$list['listcontent'].'</p>
														 </div>';
									}                                   
                               $content[$k] .= '</div>';               
				}
				 elseif(isset($list_array['ListStyle']) && $list_array['ListStyle']['style']=='style3')
				{
					$content[$k]='<div class="icon-list-3">';
								$i=1;
								foreach($list_array['ListContent'] as $list)
								{
										$content[$k].='<div class="element">
											<i class="main-bg-color alt-text-color pull-left">'.$i.'</i>
											<p>'.$list['listcontent'].'</p>
										</div>';
									$i++;
								}	
					$content[$k].='</div>';             
                }                 
				elseif(isset($list_array['ListStyle']) && $list_array['ListStyle']['style']=='style4')
				{
					$content[$k]='<div class="icon-list-4">';
								$i=1;
								foreach($list_array['ListContent'] as $list)
								{
										$content[$k].='<div class="element">
											<i class="main-text-color pull-left">'.$i.'.</i>
											<p>'.$list['listcontent'].'</p>
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
				$img_text = String::truncate($imagebox_array['ImageBoxContent'][0]['content'],50,
																		array('exact' => false)
																		);	
				$content[$k] = '<div class="img-box">
									<div class="thumb">
										<a class="overlay mgp-img" href="'.IMGPATH.'box_image/thumb/'.$imagebox_array['ImageBoxContent'][0]['image'].'">
											<i class="fa fa-search md alt-text-color"></i>
										</a>
										<img src="'.IMGPATH.'box_image/resize/'.$imagebox_array['ImageBoxContent'][0]['image'].'" class="img-responsive" alt="">
									</div>
									<h5 class="medium">'.$imagebox_array['ImageBoxContent'][0]['title'].'</h5>
									<p>'.$img_text.'
										<span class="read-link main-text-color"><a href="'.$imagebox_array['ImageBoxContent'][0]['link'].'">Read More </a><i class="fa fa-play-circle-o"></i></span>
									</p>
								</div>';
			}
			else if($short_code_type[0] == 'Testimonial')
			{
				App::import('Model','Testimonial');
				$testimonial_model = new Testimonial();
	   
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
				
				
				if(isset($testimonial_array['Testimonial']) && $testimonial_array['Testimonial']['style']=='style1')
				{
					$content[$k] = '<div id="testimonials-1-1" class="carousel slide carousel-fade testimonials-1" data-ride="carousel">
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
                                            <div class="head alt-text-color">
                                            '.$testimonial_array['Testimonial']['text'].'
                                            </div>
                                            <p class="italic alt-text-color">
                                            '.$testimonial['testimonial'].' </p>
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
				elseif(isset($testimonial_array['Testimonial']) && $testimonial_array['Testimonial']['style']=='style3')
				{
					$content[$k]='<div class="testimonials-3 text-center no-spacing">
									<div class="container">
										<div class="row">
											<div class="col-md-12">
												<h2 class="alt-text-color">'.$testimonial_array['Testimonial']['text'].'</h2>
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
								</div>';             
                }                 
				elseif(isset($testimonial_array['Testimonial']) && $testimonial_array['Testimonial']['style']=='style2')
				{
					$content[$k]='<div class="testimonials-2">';
					
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
					$content[$k]='';
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
									   $content[$k] .= $video['youtube_url'];
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
				
				$news_arr = $news->find('all', array('conditions'=>array('News.is_del'=>0,													'News.news_status'=>'Y'),
														'limit'=>'5'));
				
				/* pr($news_arr);
				exit;
				  */
				
				if(isset($news_array['NewsWidget']) && $news_array['NewsWidget']['style']=='Style1')
				{
					
					$content[$k] = '<div class="list-group">';
					
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
				
					$content[$k] = '<div class="list-group">';
					
					foreach($category_array as $category_array){
                             $content[$k] .= '<a href="'.SITE_URL .$category_array['PostCategory']['slug'].'" class="list-group-item">'.$category_array['PostCategory']['category_name'].'</a>';
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
				
				if($cmsgallery_arr['CmsGallery']['style'] == '1')
				{
					$content[$k] = '<div class="bannercontainer">
										<div class="banner">
											<ul>';
								$i=1;
								foreach($cmsgallery_arr['CmsBanner'] as $cmsbanner)			
								{
									$content[$k] .='<li id="slide3" data-transition="fade" data-slotamount="1">
													<img src="'.IMGPATH.'cms_banner_image/background/resize/'.$cmsbanner['banner_back_image'].'" alt="">
													<div class="tp-caption skewfromleft" data-x="center" data-voffset="-30" data-y="center" data-speed="500" data-start="1200">
														<img class="img-responsive" src="'.IMGPATH.'cms_banner_image/resize/'.$cmsbanner['banner_image'].'" alt="">
													</div>
													<div class="tp-caption lfb title" data-x="center" data-voffset="170" data-y="center" data-speed="500" data-start="1200">
														<div class="light alt-text-color">
														<a href="'.$cmsbanner['banner_link'].'">'.$cmsbanner['actiontext'].'</a>
														</div>
													</div>
												</li>';
									$i++;			
								}
					$content[$k] .= '</ul>
								</div>
							</div>';
				}
				if($cmsgallery_arr['CmsGallery']['style'] == '2')
				{
					$content[$k]='<div class="bannercontainer">
									<div class="banner">
										<ul>';
								$i=1;
								foreach($cmsgallery_arr['CmsBanner'] as $cmsbanner)			
								{
											$content[$k] .='<li id="slide1" data-transition="fade" data-slotamount="1">
												<img src="'.IMGPATH.'cms_banner_image/resize/'.$cmsbanner['banner_image'].'" alt="">

												<div class="tp-caption caption1 title skewfromleft" data-x="center" data-voffset="-100" data-y="center" data-speed="500" data-start="1200">
													<div class="container text-center">
														<div class="light">'.$cmsbanner['detailheading'].'</div>

													</div>
												</div>

												<div class="tp-caption caption1 text skewfromleft" data-x="center" data-y="center" data-speed="500" data-start="1200">
													<div class="container text-center">
														<div class="light faded">'.$cmsbanner['taxt'].'
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
									$i++;		
								}
							$content[$k] .= '</ul>
									</div>
								</div>';
				}
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
                        <div class="col-md-12">

                            <div class="ajax-page-preloader" style="position: relative;">
                                <div class="loader spinner">
                                    <img src="../../img/loader.gif" width="24" height="24">
                                    <div class="dot1"></div><div class="dot2"></div><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div>
                                </div>
                            </div>

                            <div class="row isotope-container">';
							
							$conditions = array();
							$conditions['Product'] = array('featured_flag'=>'TRUE');
							$order = array('created_date'=>'DESC');
							$limit = 10;
							$featured = $this->Layout->productlist($conditions, $order, $limit);
							//pr($featured);
							if(!empty($featured))
							{
								foreach($featured as $ftr)
								{ 
									$options = $this->Layout->mouldOptions($ftr['Product']['id']);	
									$content[$k] .= '<div class="col-md-3 col-sm-6 main-el isotope-element">
														<div class="shop-col-item">
															<div class="photo">
																<img src="'.IMGPATH.'product_image/resize/'.$ftr['Product']['product_image'].'" class="img-responsive" alt="'.$ftr['Product']['product_name'].'">
															</div>
															<div class="info">
																<div>
																	<div class="price">
																		<h5>'.$ftr['Product']['product_name'].'</h5>
																		<h5 class="main-text-color">'.CURRENCY.$this->Layout->actualprice($ftr['Product']['id']).'</h5>
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
                        $content[$k] .= '</div>
                        </div>
					</div>';
			}
			else if($short_code_type[0] == 'newarrivals')
			{
				$content[$k] = '<div class="shop-wrapper main-el clearfix">
                        <div class="col-md-12">
                            <div class="sep-heading-container shc4 clearfix">
                                <h4>New Arrivals</h4>
                                <div class="sep-container">
                                    <div class="the-sep"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">

                            <div class="ajax-page-preloader" style="position: relative;">
                                <div class="loader spinner">
                                    <img src="../../img/loader.gif" width="24" height="24">
                                    <div class="dot1"></div><div class="dot2"></div><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div>
                                </div>
                            </div>

                            <div class="row isotope-container">';
							
							$conditions = array();
							$conditions['Product'] = array('newcollection_flag'=>'TRUE');
							$order = array('created_date'=>'DESC');
							$limit = 10;
							$featured = $this->Layout->productlist($conditions, $order, $limit);
							//pr($featured);
							if(!empty($featured))
							{
								foreach($featured as $ftr)
								{ 
									$options = $this->Layout->mouldOptions($ftr['Product']['id']);	
									$content[$k] .= '<div class="col-md-3 col-sm-6 main-el isotope-element">
														<div class="shop-col-item">
															<div class="photo">
																<img src="'.IMGPATH.'product_image/resize/'.$ftr['Product']['product_image'].'" class="img-responsive" alt="'.$ftr['Product']['product_name'].'">
															</div>
															<div class="info">
																<div>
																	<div class="price">
																		<h5>'.$ftr['Product']['product_name'].'</h5>
																		<h5 class="main-text-color">'.CURRENCY.$this->Layout->actualprice($ftr['Product']['id']).'</h5>
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
                        $content[$k] .= '</div>
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
								'conditions'=>array('Faq.isdel'=>'0','Faq.status'=>'Y'),
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
								$content[$k] .='<li class="filter" data-filter="'.$faq_content['FaqCategory']['category'].'">'.$faq_content['FaqCategory']['category'].'</li>';
							}
							$check_prev = $faq_content['FaqCategory']['category'];
						}
                    $content[$k] .='</ol>';
					
                    $content[$k] .='<div class="panel-group accordion filter-panel" id="accordion-4">';
							$i=1;
							foreach($faq_array as $faq_content)
							{
								if(!empty($faq_content['Faq'][0]))
								{
								
                                    $content[$k] .='<div class="panel panel-default '.$faq_content['FaqCategory']['category'].'">
                                        <div class="panel-heading alt-bg-color">
                                            <h6 class="panel-title">
                                                <a data-toggle="collapse" class="collapsed" data-parent="#accordion-4" href="#acc-4-'.$i.'">
                                                    <i class="fa "></i>
													'.$faq_content['Faq'][0]['faq_questions'].'
                                                </a>
                                            </h6>
                                        </div>
                                        <div id="acc-4-'.$i.'" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <p>
													'.$faq_content['Faq'][0]['faq_answers'].'
                                                </p>
                                            </div>
                                        </div>
                                    </div>';
									$i++;
								}
							}
					$content[$k] .='</div>';			
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
		
			$content = $this->short_code($c);
			$show_content = str_replace(array_values($e),array_values($content), $haystack);
		}
		else
		{
			$show_content = $haystack;
		}
		echo $show_content;
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