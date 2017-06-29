<?php
class ShortCodeHelper extends AppHelper {
	var $helpers = array('Cache','Html','Session','Form','Paginator','MenuitemMasters');
	
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
				
				$content[$k] = '<div class="input-group"><input type="text" class="form-control" placeholder="Start typing here..."><span class="input-group-btn">
                                <button class="btn btn-default fa fa-search" type="button"></button>
                            </span>
                        </div>';
			}
			else if($short_code_type[0] == 'Contact')
			{
				
				$content[$k] = '<div class="contact-form-widget">
                            <div class="form form-1">
                                <div class="input-group">
                                    <input type="text" placeholder="Name *" class="form-control">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                </div>
                                <div class="input-group c-border-top">
                                    <input type="text" placeholder="Email *" class="form-control">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                </div>
                                <div class="textarea textarea-icon">
                                    <i class="fa fa-pencil"></i><textarea placeholder="Message *" class="form-control" rows="4"></textarea>
                                </div>
                                <div class="btns">
                                    <a class="button solid blue sm"><div class="over">submit</div></a>
                                    <a class="clear pull-right">
                                   Clear All <i class="fa fa-times-circle-o"></i>
                                    </a>
                                </div>
                            </div>
                        </div>';
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
			else if($short_code_type[0] == 'latestpost')
			{
			
			App::import('Model', 'Page');
			$post = new Page();
			$allpost = $post->find('all', array('conditions' => array('Page.controllername'=>'Posts','Page.is_del'=>0),
												'order' => array('Page.id' => 'DESC'),
												'limit' => '5'));
			
			/* pr($allpost);
			exit; */
			
			App::import('Model','LatestPost');
				$LatestPost = new LatestPost();
	   
				$post_array = $LatestPost->findById(1);
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
			}
			else if($short_code_type[0] == 'contactinfo')
			{
				App::import('Model','SiteSetting');
				$site = new SiteSetting();
				$settings = $site->findById(1);
				
				$content[$k] = '<div class="sep-heading-container shc4 clearfix">
                            <h4>Contact Info</h4>
                            <div class="sep-container">
                                <div class="the-sep"></div>
                            </div>
                        </div>
						<div class="contact-widget">
                            <div class="line">
                                <i class="fa fa-map-marker main-text-color"></i> <div class="text">'.$settings['SiteSetting']['address'].'
                          </div>
                            </div>
                            <div class="line">
                                <i class="fa fa-phone main-text-color"></i>
                                <div class="text"> +'.$settings['SiteSetting']['phone'].'</div>
                            </div>
                            <div class="line">
                                <i class="fa fa-envelope main-text-color"></i>
                                <div class="text">'.$settings['SiteSetting']['cc_email'].'</div>
                            </div>
                            <div class="line">
                                <i class="fa fa-globe main-text-color"></i>
                                <div class="text">'.$settings['SiteSetting']['website'].'</div>
                            </div>
                        </div>';
			}
			else if($short_code_type[0] == 'subscribe')
			{
				
				$content[$k] = '<div class="sep-heading-container shc4 clearfix">
                            <h4>Subscribe</h4>
                            <div class="sep-container">
                                <div class="the-sep"></div>
                            </div>
                        </div>
                        <div class="input-group">
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