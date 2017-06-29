<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');

class ThemesController extends AppController {

	public $name = "Themes";
	
	public $components = array();
	public $helpers = array();
	public $uses = array('Theme', 'ThemeSetting', 'ThemeBackground', 'HeaderLayout', 'HeaderMenustyle', 'HdrAssignlm', 'GoogleFont','SiteManagement');
	public $paginate = array();
	
	public function beforeFilter() 
	{
	
		parent::beforeFilter();
		
		$this->Auth->allow('');
		
		if(isset($this->request->params['users'])){
			$this->Security->requireSecure();			
		}
		$this->Security->blackHoleCallback = 'blackhole';
	}
    
	public function blackhole($type) {
	
		// handle errors.
	}
		
	public function admin_index($id=NULL)
	{
		$this->layout = 'adminInner';
		$this->loadModel('ThemeSetting');
				
		$this->set('id', $id);
		
		$this->Theme->bindModel(array(
				'hasOne'=>array(
					'ThemeSetting'=>array(
						'className'=>'ThemeSetting',
						'foreignKey'=>'theme_id'
					)
				)
			)
		);
		$data = $this->Theme->find('first');
		$datasiteArr = $this->SiteManagement->query('select * from site_managements where site_management_id=1');
		$datasitecount = $this->SiteManagement->find('count');
		$datasiteArr['SiteManagement']=$datasiteArr['0']['site_managements'];
		//pr($datasiteArr); exit();
		
		$this->loadModel('ThemeBackground');
		$themepatten = $this->ThemeBackground->find('list', array(
							'conditions'=>array(
								'ThemeBackground.bgtype'=>'P'
							),
							'fields'=>array('bgfilename')
						)
					);
					
		$themebg = $this->ThemeBackground->find('list', array(
							'conditions'=>array(
								'ThemeBackground.bgtype'=>'I'
							),
							'fields'=>array('bgfilename')
						)
					);
		$headerLayoutArr = $this->HeaderLayout->find('list', array(
				'fields'=>array(
					'HeaderLayout.template_file', 'HeaderLayout.template_name'
				)
			)
		);
		
		$fontsArr = $this->GoogleFont->find('list',array(
				'fields'=>array(
					'name', 'name'
				)
			)
		);
		
		for($i=10; $i<=30; $i++)
		{
			$fontsizeArr[$i]=$i;
		}
		
		if(!empty($data)){
			if(!empty($data['ThemeSetting']['header_layout'])){
				$layout = $this->HeaderLayout->findByTemplateFile($data['ThemeSetting']['header_layout']);
				$assignArr = $this->HdrAssignlm->find('list', array(
						'conditions'=>array('HdrAssignlm.header_layoutid'=>$layout['HeaderLayout']['id']),
						'fields'=>array('HdrAssignlm.header_menustyleid')
					)
				);
				if(!empty($assignArr)){
					if(count($assignArr) == 1){
						$asgnid = array_pop($assignArr);
						$headermenuArr = $this->HeaderMenustyle->find('list', array(
								'conditions'=>array('HeaderMenustyle.id'=>$asgnid),
								'fields'=>array(
									'HeaderMenustyle.menustyle_file', 'HeaderMenustyle.menustyle_name'
								)
							)
						);
					} else {
						$headermenuArr = $this->HeaderMenustyle->find('list', array(
								'conditions'=>array('HeaderMenustyle.id IN'=>$assignArr),
								'fields'=>array(
									'HeaderMenustyle.menustyle_file', 'HeaderMenustyle.menustyle_name'
								)
							)
						);
					}
				} else {
					$headermenuArr = array();
				}
			} else {
				$headermenuArr = array();
			}
			
		} else {
			$headermenuArr = array();
		}
		
		//pr($headermenuArr); exit();
	$this->set(compact('data','headerLayoutArr', 'headermenuArr', 'themepatten', 'themebg', 'fontsArr','fontsizeArr','datasiteArr','datasitecount'));
	}
	
	public function admin_hederchangeopt(){
		$this->layout = "ajax";
		
		if($this->request->is("post")){
			$data = $this->request->data;
			
			if(!empty($data)){
				if(!empty($data['layout'])){
					$layout = $this->HeaderLayout->findByTemplateFile($data['layout']);
					
					$assignArr = $this->HdrAssignlm->find('list', array(
							'conditions'=>array('HdrAssignlm.header_layoutid'=>$layout['HeaderLayout']['id']),
							'fields'=>array('HdrAssignlm.header_menustyleid')
						)
					);
					
					if(!empty($assignArr)){
						if(count($assignArr) == 1){
							$asgnid = array_pop($assignArr);
							$headermenuArr = $this->HeaderMenustyle->find('list', array(
									'conditions'=>array('HeaderMenustyle.id'=>$asgnid),
									'fields'=>array(
										'HeaderMenustyle.menustyle_file', 'HeaderMenustyle.menustyle_name'
									)
								)
							);
						} else {
							$headermenuArr = $this->HeaderMenustyle->find('list', array(
									'conditions'=>array('HeaderMenustyle.id IN'=>$assignArr),
									'fields'=>array(
										'HeaderMenustyle.menustyle_file', 'HeaderMenustyle.menustyle_name'
									)
								)
							);
						}
					} else {
						$headermenuArr = array();
					}
				} else {
					$headermenuArr = array();
				}
				
			} else {
				$headermenuArr = array();
			}
		} else {
			$headermenuArr = array();
		}
		
		$this->set(compact('headermenuArr'));
	}
	
	public function admin_ajaxgeneralupdate($id=NULL){
		$this->layout = 'ajax';
		if($this->request->is('post')){
			$data = $this->request->data;
			if(empty($data['ThemeSetting']['background_img']))
			{
				 $data['ThemeSetting']['background_img']='';
			}
			if(!empty($id)){
				$this->ThemeSetting->id = $id;
			} else {
				$this->ThemeSetting->create();
			}
			
			$flag = $this->ThemeSetting->save($data);
			echo ($flag)?1:0;
			exit();
		}
	}
	
	public function admin_resetheader($id=NULL){
		$this->layout = '';
		$this->autoRender = false;
		if($this->request->is('post')){
			$data['ThemeSetting']['header_type'] = 'H';
			$data['ThemeSetting']['header_layout'] = 'header_layout_1';
			$data['ThemeSetting']['header_menu_style'] = 'menu-2';
			$data['ThemeSetting']['shadow_style'] = 'v1';
			$data['ThemeSetting']['box_layout'] = 'no';
			
			if(!empty($id)){
				$this->ThemeSetting->id = $id;
			} else {
				$this->ThemeSetting->create();
			}
			
			$flag = $this->ThemeSetting->save($data);
			
			if($flag){
				$this->Session->setFlash('<p>Header Section reset successfully.</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('<p>Failed to reset Header Section.</p>', 'default', array('class' => 'alert alert-danger'));
			}
			$this->redirect($this->referer());
		}
	}
	
	public function admin_resetbackground($id=NULL){
		$this->layout = '';
		$this->autoRender = false;
		if($this->request->is('post')){
			$bgArr = $this->ThemeBackground->find('first', array(
				'conditions'=>array('ThemeBackground.bgtype'=>'I')
				)
			);
			
			$data['ThemeSetting']['background_type'] = 'image';
			$data['ThemeSetting']['background_img'] = (!empty($bgArr))?$bgArr['ThemeBackground']['bgfilename']:'';
			
			if(!empty($id)){
				$this->ThemeSetting->id = $id;
			} else {
				$this->ThemeSetting->create();
			}
			
			$flag = $this->ThemeSetting->save($data);
			
			if($flag){
				$this->Session->setFlash('<p>Background Section reset successfully.</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('<p>Failed to reset Background Section.</p>', 'default', array('class' => 'alert alert-danger'));
			}
			$this->redirect($this->referer());
		}
	}
	
	public function admin_uploadbg($id=NULL){
		$this->layout = '';
		$this->autoRender = false;
		
		if($this->request->is('post')){
			$data = $this->request->data;
			
			if(!empty($data['ThemeBackground']['bgfilename']['name']))
			{
				list($file,$error1,$update_field1) = AppController::upload($data['ThemeBackground']['bgfilename'],WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'bgfilename'. DS ,'jpg,jpeg,JPG,JPEG,gif,GIF,png,PNG');
				
				if($file!=""){
					$data['ThemeBackground']['bgfilename'] = $file;
				} else {
					$data['ThemeBackground']['bgfilename'] = "";
				}
			} else {
				$data['ThemeBackground']['bgfilename'] = "";
			}
			
			$this->ThemeBackground->create();
			
			$fl = $this->ThemeBackground->save($data);
			if($fl){
				if(!empty($id)){
					$this->ThemeSetting->id = $id;
				} else {
					$this->ThemeSetting->create();
				}
				
				$settingData['ThemeSetting']['background_type'] = ($data['ThemeBackground']['bgtype']=='I')?'image':'pattern';
				$settingData['ThemeSetting']['background_img'] = $data['ThemeBackground']['bgfilename'];
				
				$this->ThemeSetting->save($settingData);
				
				$this->Session->setFlash('<p>Theme Background added successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('<p>Failed to upload background!</p>', 'default', array('class' => 'alert alert-danger'));
			}
			$this->redirect($this->referer());
		}
		
	}
	
	public function admin_ajaxcolorupdate($id=NULL){
		$this->layout = 'ajax';
		$this->layout = '';
		$this->autoRender = false;
		if($this->request->is('post')){
			$data = $this->request->data;
			$dir = new Folder(ROOT.DS.APP_DIR .'/View/Themed/'.THEME_NAME.'/webroot/css', true, 0755);
			$fieldname=$data['ThemeSetting']['field_name'];
	
		    $data['ThemeSetting'][$fieldname];
			$query="Update `site_managements` Set `".$fieldname."`='".$data['ThemeSetting'][$fieldname]."' where `site_management_id`=1"; 
			$this->SiteManagement->query($query);
			// creation of the site settings css file
			file_put_contents($dir->pwd().DS.'color_settings.css', ''); // empty color settings css
			$strcolor_settingsfile = new File($dir->pwd().DS.'color_settings.css'); // read color setting css
			$strcolor_settings = $strcolor_settingsfile->read();
			
			
			$filemain = new File($dir->pwd().DS.'font_family.css');
			$strmain = $filemain->read();
			
			
			
			
			
			
			
			$searchquery="Select * from site_managements where site_management_id=1"; //get record to create css file
			$sitearr=$this->SiteManagement->query($searchquery);
			$csscreation='';
			
			$requiredsccarray=$sitearr[0]['site_managements'];
			
			foreach($requiredsccarray as $key=>$value)
			{
			  if($value!='')
			  {  
			 
				  if($key!='site_management_id')
				  {
					$needle = "_size";
					$needle1 = "_backgound";
					$needle2="_background-color";
					$needle3="_hoverbackgound";
					$needle4="submenu";
					$haystack = $key;
					
					
					
					if (strpos($haystack, $needle4) !== false)
					{
					
					 if($key=='submenu_order_cart')
					 {
$csscreation .= '.head.main-bg-color.alt-text-color.bold.clearfix{background:'.$requiredsccarray[$haystack].'!important;}';
$csscreation .= '.head.main-bg-color.alt-text-color{background:'.$requiredsccarray[$haystack].'!important;}';
$csscreation .= '.btn.btn-primary.brown-bg{background:'.$requiredsccarray[$haystack].'!important;}';

					 }
					 
					  if($key=='submenu_order_cart_text')
					 {
$csscreation .= '.head.main-bg-color.alt-text-color.bold.clearfix{color:'.$requiredsccarray[$haystack].'!important;}';

$csscreation .= '.head.main-bg-color.alt-text-color{color:'.$requiredsccarray[$haystack].'!important;}';
$csscreation .= '.btn.btn-primary.brown-bg{color:'.$requiredsccarray[$haystack].'!important;}';

					 }
					
					 if($key=='submenu_weight')
								{
	//$csscreation .= '.menu_control{font-weight:'.$requiredsccarray[$haystack].'!important;}';
	$csscreation .= '.boldc{font-weight:'.$requiredsccarray[$haystack].'!important;}';
	$csscreation .= '.boldc span{font-weight:'.$requiredsccarray[$haystack].'!important;}';
	
									
								} 
								if($haystack=='submenu_reweight')
								{
		$csscreation .= '.revolutionhead{font-weight:'.$requiredsccarray[$haystack].'!important;}';
	
								}
								
								if($haystack=='submenu_allbhtco')
								{
		$csscreation .= '.contactbutton_backgound .contact_button:hover{color:'.$requiredsccarray[$haystack].'!important;}';
		$csscreation .= '.over.ecombox_addtocart:hover{color:'.$requiredsccarray[$haystack].'!important;}';
		$csscreation .= '.over:hover{color:'.$requiredsccarray[$haystack].'!important;}';
		$csscreation .= '.send_btn_backgound_clr:hover{color:'.$requiredsccarray[$haystack].'!important;}';
		$csscreation .= '.addwishlist_btn_txt_clr:hover{color:'.$requiredsccarray[$haystack].'!important;}';
		$csscreation .= '.addcart_btn_backgound:hover{color:'.$requiredsccarray[$haystack].'!important;}';
		$csscreation .= '.addwishlist_btn_backgound:hover{color:'.$requiredsccarray[$haystack].'!important;}';
		
		$csscreation .= '.button.striped.md:hover{color:'.$requiredsccarray[$haystack].'!important;}';
		$csscreation .= '.btn.btn-primary.brown-bg:hover{color:'.$requiredsccarray[$haystack].'!important;}';
								} 
								
								if($haystack=='submenu_albuthbc')
								{
			$csscreation .= '.button.solid .over:hover{background:'.$requiredsccarray[$haystack].'!important;}';
			$csscreation .= '.addcart_btn_backgound:hover{background:'.$requiredsccarray[$haystack].'!important;}';
			$csscreation .= '.addwishlist_btn_backgound:hover{background:'.$requiredsccarray[$haystack].'!important;}';
			$csscreation .= '.send_btn_backgound_clr:hover{background:'.$requiredsccarray[$haystack].'!important;}';
			$csscreation .= '.button.striped.md:hover{background:'.$requiredsccarray[$haystack].'!important;}';
			$csscreation .= '.btn.btn-primary.brown-bg:hover{background:'.$requiredsccarray[$haystack].'!important;}';
		
			
	
								}  
					
					
								 if($key=='submenu_control')
								{
									$csscreation .= 'header .dropdown-menu li a{color:'.$requiredsccarray[$haystack].';}';
									
								} 
								
								 if($key=='submenu_rightsearch_backgound')
								{
$csscreation .= '.submenu_rightsearch_backgound{background:'.$requiredsccarray[$haystack].'!important;}';
									
								} 
								
								 if($key=='submenu_leftsearch_backgound')
								{
$csscreation .= '.submenu_leftsearch_backgound{background:'.$requiredsccarray[$haystack].'!important;}';
									
								} 
								
								
								
								if($haystack =='submenu_backgound')
								{
									$csscreation .= 'header .dropdown-menu li a{background:'.$requiredsccarray[$haystack].';}';
									//$csscreation .= '#navbar-collapse-1{background:'.$requiredsccarray[$haystack].';}';
									
								}
								
									if($haystack =='submenu_mobbackgound')
								{
									
								$csscreation .= '#navbar-collapse-1{background:'.$requiredsccarray[$haystack].';}';
									
								}
								
								if($haystack=='submenu_hoverbackgound')
								{
									$csscreation .= 'header .dropdown-menu li a:hover{background:'.$requiredsccarray[$haystack].';}';
									
									$csscreation .= '#navbar-collapse-1 li a:hover{background:'.$requiredsccarray[$haystack].';}';
									
									$csscreation .= 'header .menu_control li.active a:hover{background:'.$requiredsccarray[$haystack].'!important;}';
									
									
								}
								
								if($haystack=='submenu_active_hvr_bc')
								{
$csscreation .= 'header .menu_control li.active a:hover{background:'.$requiredsccarray[$haystack].'!important;}';

								}
			if($haystack=='submenu_active_hvr_txt')
								{
$csscreation .= 'header .menu_control li.active a:hover{color:'.$requiredsccarray[$haystack].'!important;}';
								}
								if($haystack=='submenu_hover')
								{
	$csscreation .= 'header .dropdown-menu li a:hover{color:'.$requiredsccarray[$haystack].';}';
	
	$csscreation .= '#navbar-collapse-1 li a:hover{color:'.$requiredsccarray[$haystack].';}';
	
	$csscreation .= 'header .menu_control li.active a:hover{color:'.$requiredsccarray[$haystack].'!important;}';
								}
								
								if($haystack=='submenu_menu_ac_backg')
								{
								$csscreation .= 'header .menu_control li.active a{background:'.$requiredsccarray[$haystack].';}';
								}
								if($haystack=='submenu_menu_ac_color')
								{
	
		
		
		 $csscreation .= 'dropdown closed active menu_control{color:'.$requiredsccarray[$haystack].';}'; 
		$csscreation .= 'header .menu_control li.active .boldc{color:'.$requiredsccarray[$haystack].';}';
		$csscreation .= '.dropdown-menu > .active > a{color:'.$requiredsccarray[$haystack].';}';
		$csscreation .= 'header .menu_control li.active a{color:'.$requiredsccarray[$haystack].';}';
		//$csscreation .= 'a:focus{color:'.$requiredsccarray[$haystack].'!important;}';
		
		
		
		
		
		
								}
								if($haystack=='submenu_socialicon')
								{
			 $csscreation .= '.socials a:hover{background:'.$requiredsccarray[$haystack].'!important;}';
								} 
								if($haystack=='submenu_theme_font')
								{
			 
					
					$linkFontnow = trim($requiredsccarray[$haystack]);
					$linkFontnow = str_replace(" ", "+", $linkFontnow);
					
				
					
					$csscreation1 = '@import url(http://fonts.googleapis.com/css?family='.$linkFontnow.':400,300,400italic,500,700|Open+Sans:400italic,400,300,600);';
					
					$csscreation1 .= '.nav {font-family:"'.$requiredsccarray[$haystack].'", sans-serif;}';
					$csscreation1 .= '.vtl-navigation {font-family:"'.$requiredsccarray[$haystack].'", sans-serif;}';
					
					 
					
								} 
								
								if($haystack=='submenu_scbone_overtext_color')
								{
	$csscreation .= '.button.striped.alt-color.md.scb_button.scbone_backgound.submenu_scbone_overtext_color:hover{color:'.$requiredsccarray[$haystack].'!important;}';
								}

if($haystack=='submenu_searchcon')
								{
	$csscreation .= '.submenu_searchcon{background:'.$requiredsccarray[$haystack].'!important;}';
								}	

if($haystack=='submenu_ecombox_hover')
								{
	$csscreation .= 'a.list-group-item:hover, a.list-group-item:focus{background-color:'.$requiredsccarray[$haystack].'!important;}';
								}	

if($haystack=='submenu_active_txt_clr')
								{
	$csscreation .= '.tab ul li.ui-state-active h6{color:'.$requiredsccarray[$haystack].'!important;}';
								}

if($haystack=='submenu_navigt_bkgrnd_clr')
								{
	$csscreation .= '.vtl-navigation ul li{background:'.$requiredsccarray[$haystack].'}';
								}	

if($haystack=='submenu_navigt_txt_clr')
								{
	$csscreation .= '.vtl-navigation a{color:'.$requiredsccarray[$haystack].';}';
								}	

if($haystack=='submenu_navigt_hover_bkgrnd')
								{
	/*$csscreation .= '.vtl-navigation ul li:hover{background:'.$requiredsccarray[$haystack].';}';*/
	$csscreation .= '.vtl-navigation a:hover{background:'.$requiredsccarray[$haystack].';}';
								}

if($haystack=='submenu_navigt_hover_txt')
								{
	$csscreation .= '.vtl-navigation a:hover{color:'.$requiredsccarray[$haystack].';}';
	
								}	




if($haystack=='submenu_latest_bkgrnd_clr')
								{
	$csscreation .= '.newclslatest a{background:'.$requiredsccarray[$haystack].'}';
								}	

if($haystack=='submenu_latest_txt_clr')
								{
	$csscreation .= '.newclslatest a{color:'.$requiredsccarray[$haystack].';}';
								}	

if($haystack=='submenu_latest_hover_bkgrnd')
								{
	$csscreation .= '.newclslatest a:hover{background:'.$requiredsccarray[$haystack].';}';
								}

if($haystack=='submenu_latest_hover_txt')
								{
	$csscreation .= '.newclslatest a:hover{color:'.$requiredsccarray[$haystack].';}';
								}
								if($haystack=='submenu_box_backgound_hover_co')
								{
	$csscreation .= '.box_backgound:hover{background-color:'.$requiredsccarray[$haystack].';}';
	$csscreation .= '.boxicon_text:hover{background-color:'.$requiredsccarray[$haystack].'; transform: rotate3d(0, 1, 0, 180deg);}';
								}
								if($haystack=='submenu_blrhbc')
								{
		$csscreation .= '.carousel .controls a:hover{background:'.$requiredsccarray[$haystack].'!important;}'; 
		$csscreation .= '.portfolio.full .controls a:hover{background:'.$requiredsccarray[$haystack].'!important;}'; 
		
	
								}
								if($haystack=='submenu_ohallbhtco')
								{
									$csscreation .= '.overlay:hover{background:'.$requiredsccarray[$haystack].';}';
									$csscreation .= '.overlay:hover{opacity:0.75;}';
								}


						if($haystack=='submenu_pricetable_bg'){
							$csscreation .= '.table.pricing,.table .field{border: 1px solid '.$requiredsccarray[$haystack].';}';
							$csscreation .= '.table.pricing .head {border-bottom: 1px solid '.$requiredsccarray[$haystack].';background:'.$requiredsccarray[$haystack].';}';
							$csscreation .= '.table.pricing div:nth-child(2n+0){background:'.$requiredsccarray[$haystack].';}';
						}
				
							 
							 
								  
					}else {

					if($key=='listicon_backgound')
					{
					  $csscreation .= '.listicon_color{color:'.$value.';}';
					}
					
					if($key=='ecombox_pname')
					{
					  $csscreation .= '.shop-col-item .rating{color:'.$value.';}';
					}


					if($key=='testimonial_background-color')
					{
					  $csscreation .= '.testimonials-2 .item .text:before {border-color:'.$value.' transparent transparent;}';
					}
					if($key=='addcart_btn_backgound')
					{
					$csscreation .= '.product-wrap .controls .button.ctrl {background:'.$value.';}';
					$csscreation .= '.button.grey.solid.ctrl {background:'.$value.';}';
					$csscreation .= '.button.striped.blue {background:'.$value.';}';

 
					}
					if($key=='addwishlist_btn_txt_clr')
					{
						 $csscreation .= '.button.striped.blue{color:'.$value.';}';
					}
					
					
					if($key=='send_btn_backgound_clr')
					{
					 $csscreation .= '.btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active{background-color:'.$value.';}';
		
					}

					if($key=='tabcontent_backgound')
					{
					  $csscreation .= '.tab.left ul li.ui-state-active{background:'.$value.';}';
					  $csscreation .= '.tab.right ul li.ui-state-active{background:'.$value.';}';
					  $csscreation .= '.tab.def ul li.ui-state-active h6{color:'.$value.';}';
					  $csscreation .= '.tab.tabs-bottom ul li.ui-state-active h6{color:'.$value.';}';
					  
					}


					
					if (strpos($haystack, $needle2) !== false)
					{
					 	$csscreation .= '.'.$key.'{background-color:'.$value.';}';
					}
					elseif (strpos($haystack, $needle1) !== false)
					{						
					  	$csscreation .= '.'.$key.'{background:'.$value.';}';
					}
					elseif (strpos($haystack, $needle) !== false)
					{
						$key=str_replace('_size','{',$key);
						$csscreation .= '.'.$key.'font-size:'.$value.'px;}';
					}
                			
					elseif($key=='a')
					{
					  $csscreation .= $key.'{color:'.$value.';}';
					}elseif($key=='a_hover')
					{
					  $csscreation .= 'a:hover{color:'.$value.';}';
					}
					
					else {
					
					 $csscreation .= '.'.$key.'{color:'.$value.';}';
					}
				}
					
				  }
				  
			  }
			  
			} 
			
			
			$strcolor_settingsfile->write($csscreation);
			$strcolor_settingsfile->close();
			$filemain->write($csscreation1);
			$filemain->close();
			
			
		
			
			
		}
		echo 1;
	}
	
	public function admin_ajaxbackupcss($id=NULL){
		$this->layout = 'ajax';
		$this->layout = '';
		$this->autoRender = false;
		if($this->request->is('post'))
		{
		
		    $clonerecordsql4="Select Max(site_management_id) as lastid from site_managements";
		    $testarr=$this->SiteManagement->query($clonerecordsql4);
			$lastid=$testarr['0']['0']['lastid'];
			$updateid=$lastid+1;
		
			$clonerecordsql="CREATE TEMPORARY TABLE temp_tbl SELECT * FROM site_managements WHERE site_management_id=1";
			$this->SiteManagement->query($clonerecordsql);
			
			$clonerecordsql1="UPDATE temp_tbl SET site_management_id = '".$updateid."'";
			$this->SiteManagement->query($clonerecordsql1);
			$clonerecordsql2="INSERT INTO site_managements SELECT * FROM temp_tbl";
			$this->SiteManagement->query($clonerecordsql2);
			$clonerecordsql3="DROP TABLE temp_tbl";
			$this->SiteManagement->query($clonerecordsql3);
		}
		echo 1;
	}
	
	public function admin_ajaxrestorecss($id=NULL){
		$this->layout = 'ajax';
		$this->layout = '';
		$this->autoRender = false;
		if($this->request->is('post'))
		{
		    $dir = new Folder(ROOT.DS.APP_DIR .'/View/Themed/'.THEME_NAME.'/webroot/css', true, 0755);
		    $clonerecordsql4="Select Max(site_management_id) as lastid from site_managements";
		    $testarr=$this->SiteManagement->query($clonerecordsql4);
			$lastid=$testarr['0']['0']['lastid'];
		
		    $clonerecordsql="CREATE TEMPORARY TABLE temp_tbl SELECT * FROM site_managements WHERE site_management_id='".$lastid."'";
			$this->SiteManagement->query($clonerecordsql);
			
			$deleterecordsql="Delete FROM site_managements WHERE site_management_id=1";
			$this->SiteManagement->query($deleterecordsql);
			
			$clonerecordsql1="UPDATE temp_tbl SET site_management_id = '1'";
			$this->SiteManagement->query($clonerecordsql1);
			$clonerecordsql2="INSERT INTO site_managements SELECT * FROM temp_tbl";
			$this->SiteManagement->query($clonerecordsql2);
			$clonerecordsql3="DROP TABLE temp_tbl";
			$this->SiteManagement->query($clonerecordsql3);
			// creation of the site settings css file
			file_put_contents($dir->pwd().DS.'color_settings.css', ''); // empty color settings css
			$strcolor_settingsfile = new File($dir->pwd().DS.'color_settings.css'); // read color setting css
			$strcolor_settings = $strcolor_settingsfile->read();
			
			
			$searchquery="Select * from site_managements where site_management_id=1"; //get record to create css file
			$sitearr=$this->SiteManagement->query($searchquery);
			$csscreation='';
			$requiredsccarray=$sitearr[0]['site_managements'];
			//pr($requiredsccarray);
			foreach($requiredsccarray as $key=>$value)
			{
			  if($value!='')
			  {
				  if($key!='site_management_id')
				  {
					$needle = "_size";
					$needle1 = "_backgound";
					$needle2="_background-color";
					$needle3="_hoverbackgound";
					$haystack = $key;
					
					if (strpos($haystack, $needle2) !== false)
					{
					 	$csscreation .= '.'.$key.'{background-color:'.$value.';}';
					}
					elseif (strpos($haystack, $needle1) !== false)
					{
					  	$csscreation .= '.'.$key.'{background:'.$value.';}';
					}
					elseif (strpos($haystack, $needle) !== false)
					{
						$key=str_replace('_size','{',$key);
						$csscreation .= '.'.$key.'font-size:'.$value.'px;}';
					}
                    elseif (strpos($haystack, $needle3) !== false)
					{
						$csscreation .= 'header .dropdown li:hover{background:'.$value.';}';
					}					
					else
					{
					  $csscreation .= '.'.$key.'{color:'.$value.';}';
					}
					
				  }
				  
			  }
			  
			} 
			
			
			$strcolor_settingsfile->write($csscreation);
			$strcolor_settingsfile->close();
		}
		echo 1;
	}
	
	
	
	public function admin_resetcolorupdate($id=NULL){
		$this->layout = '';
		$this->autoRender = false;
		if($this->request->is('post')){
			$data = $this->request->data;
			pr($data);
			
			
			
				
				if($flag){
					$this->Session->setFlash('<p>Option reset successfully!</p>', 'default', array('class' => 'alert alert-success'));
				} else {
					$this->Session->setFlash('<p>Failed to reset the style option</p>', 'default', array('class' => 'alert alert-danger'));
				}
				
			} else {
				$this->Session->setFlash('<p>Failed to reset the style option</p>', 'default', array('class' => 'alert alert-danger'));
			}
			$this->redirect($this->referer());
		}
	
	
	public function zipper($files)
	{
		function rmdir_recursive($dir) 
		{
			foreach(scandir($dir) as $file) 
			{
				if ('.' === $file || '..' === $file) continue;
				if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
				else unlink("$dir/$file");
			}
			 
			rmdir($dir);
		}
		$filenoext = "";
		$message = "";
		if($files["name"]) 
		{
			$filename = $files["name"];
			$source = $files["tmp_name"];
			$type = $files["type"];
			 
			$name = explode(".", $filename);
			$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed','application/octet-stream');
			
			if(in_array($type, $accepted_types)){
				
				/* PHP current path */
				$path = dirname(__DIR__); // absolute path to the directory where zipper.php is in
				$path .= '/View/Themed/';
				
				$filenoext = basename ($filename, '.zip'); // absolute path to the directory where zipper.php is in (lowercase)
				$filenoext = basename ($filenoext, '.ZIP'); // absolute path to the directory where zipper.php is in (when uppercase)
				 
				$targetdir = $path . $filenoext; // target directory
				$targetzip = $path . $filename; // target zip file
				 
				/* create directory if not exists', otherwise overwrite */
				/* target directory is same as filename without extension */
				 
				if (is_dir($targetdir)) 
				rmdir_recursive ($targetdir);
				 
				 
				mkdir($targetdir, 0777);
				 
				 
				/* here it is really happening */
				 
				if(move_uploaded_file($source, $targetzip)) 
				{
					$zip = new ZipArchive();
					$x = $zip->open($targetzip); // open the zip file to extract
					if ($x === true) 
					{ 
						$zip->extractTo($targetdir); // place in the directory with same name
						$zip->close();
						 
						unlink($targetzip);
					}
					$message = "";
				} 
				else 
				{	
					$message = "There was a problem with the upload. Please try again.";
				}
			} else {
				$message = "Invalid file type.";
			}
		}
		
		return array($filenoext,$message);
	}
	
	public function admin_deactivate($id=NUll){
		if($id != NULL){
			$data = array();
			$this->Theme->id = $id;
			$data['Theme']['status'] = 'N';
			$saveFlag = $this->Theme->save($data);
			if($saveFlag){
				$this->loadModel('SiteSetting');
				$site_setting = $this->SiteSetting->find('first', array('fields'=>'SiteSetting.id'));
				$this->SiteSetting->id = $site_setting['SiteSetting']['id'];
				$siteData['SiteSetting']['current_theme'] = '';
				$flag = $this->SiteSetting->save($siteData);
				
				if($flag){
					$this->Session->setFlash('Theme Deactivated.', 'default', array('class' => 'alert alert-success'));
					$this->redirect(array('controller'=>'Themes','action'=>'admin_index'));
				} else {
					$this->Session->setFlash('Failed to deactivate the theme.', 'default', array('class' => 'alert alert-danger'));
				$this->redirect(array('controller'=>'Themes','action'=>'admin_index'));
				}
				
			} else {
				$this->Session->setFlash('Failed to deactivate the theme.', 'default', array('class' => 'alert alert-danger'));
				$this->redirect(array('controller'=>'Themes','action'=>'admin_index'));
			}
		} else {
			$this->Session->setFlash('Please provide id for the theme.', 'default', array('class' => 'alert alert-danger'));
			$this->redirect(array('controller'=>'Themes','action'=>'admin_index'));
		}
	}
	
	public function admin_activate($id=NUll){
		if($id != NULL){
			$updallFlag = $this->Theme->updateAll(
				array('Theme.status' => "'N'"),
				array('Theme.status' => 'Y')
			);
			
			if($updallFlag){
				$data = array();
				$this->Theme->id = $id;
				$data['Theme']['status'] = 'Y';
				$saveFlag = $this->Theme->save($data);
				if($saveFlag){
					$themeName = $this->Theme->findById($id);
					$this->loadModel('SiteSetting');
					$site_setting = $this->SiteSetting->find('first', array('fields'=>'SiteSetting.id'));
					//pr($themeName); exit();
					$this->SiteSetting->id = $site_setting['SiteSetting']['id'];
					$siteData['SiteSetting']['current_theme'] = $themeName['Theme']['zip_file'];
					$flag = $this->SiteSetting->save($siteData);
					
					if($flag){
						$this->Session->setFlash('Theme Deactivated.', 'default', array('class' => 'alert alert-success'));
						$this->redirect(array('controller'=>'Themes','action'=>'admin_index'));
					} else {
						$this->Session->setFlash('Failed to deactivate the theme.', 'default', array('class' => 'alert alert-danger'));
					$this->redirect(array('controller'=>'Themes','action'=>'admin_index'));
					}
					
				} else {
					$this->Session->setFlash('Failed to deactivate the theme.', 'default', array('class' => 'alert alert-danger'));
					$this->redirect(array('controller'=>'Themes','action'=>'admin_index'));
				}
			}
		} else {
			$this->Session->setFlash('Please provide id for the theme.', 'default', array('class' => 'alert alert-danger'));
			$this->redirect(array('controller'=>'Themes','action'=>'admin_index'));
		}
	}
	
	public function admin_delete($id=NUll){
		
		function rmdir_recursive($dir) 
		{
			foreach(scandir($dir) as $file) 
			{
				if ('.' === $file || '..' === $file) continue;
				if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
				else unlink("$dir/$file");
			}
			 
			rmdir($dir);
		}
		
		if($id != NULL){
			$data = $this->Theme->findById($id);
			$path = dirname(__DIR__); // absolute path to the directory where zipper.php is in
			$path .= '/View/Themed/';
			$targetPath = $path.$data['Theme']['zip_file'];
			if (is_dir($targetPath)) 
			rmdir_recursive ($targetPath);
			
			$deleteFlag = $this->Theme->delete($id);
			if($deleteFlag){
				$this->Session->setFlash('Theme deleted successfully', 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('controller'=>'Themes','action'=>'admin_index'));
			} else {
				$this->Session->setFlash('Failed to delete theme', 'default', array('class' => 'alert alert-danger'));
				$this->redirect(array('controller'=>'Themes','action'=>'admin_index'));
			}
		} else {
			$this->Session->setFlash('Please provide id for the theme.', 'default', array('class' => 'alert alert-danger'));
			$this->redirect(array('controller'=>'Themes','action'=>'admin_index'));
		}
	}
	
	
	public function admin_back_ground($id=null)
	{
		$this->autoRender = false;
		$model=ClassRegistry::init('ThemeBackground');
		if($this->request->is('post'))
		{
			$data = $this->request->data; //pr($data); exit();
			if(!empty($data['ThemeBackground']['bgfilename']['name']))
			{
				list($file,$error1,$update_field1) = AppController::upload($data['ThemeBackground']['bgfilename'],WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'bgfilename'. DS ,'jpg,jpeg,JPG,JPEG,gif,GIF,png,PNG');
				
				if($file!=""){
					$data['ThemeBackground']['bgfilename'] = $file;
				} else {
					$data['ThemeBackground']['bgfilename'] = "";
				}
			}
			$model->create();
			$fl = $model->save($data);
			if($fl){
				$this->Session->setFlash('<p>Theme Background added successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('<p>Failed to upload background!</p>', 'default', array('class' => 'alert alert-danger'));
			}
			$this->redirect(array('controller'=>'Themes','action'=>'admin_manage/'.$id));
						
		}
			
	}
	
}
