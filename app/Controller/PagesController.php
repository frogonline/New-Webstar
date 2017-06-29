<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');

class PagesController extends AppController {
   
	
	public $components = array('Captcha');
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('PostCategory','Page','PostComment', 'PostTag', 'Shortcode', 'PostAssignTag', 'PageTemplate', 'PageTemplateRow', 'PageTemplateRowsColumn','EditPageTemplateRow','EditPageTemplateRowsColumn');
	public $paginate = array();
	
	public function beforeFilter() 
	{
		parent::beforeFilter();
		
		$this->Auth->allow('index','display','contactus','ajaxContact','form_search','ajaxContactinfo','mycaptcha','get_captcha','home','widget','page_search','add_layout','login_page','register','success','error','faqs','ecommerce', 'admin_new1', 'admin_ajaxdynamicimage','search','admin_restore','admin_restoreAll','sitemap','ajaxContactinfo1');
		
		if(isset($this->request->params['users'])){
			$this->Security->requireSecure();			
		}
		$this->Security->blackHoleCallback = 'blackhole';
	}
    
	public function blackhole($type) {
	
		// handle errors.
	}
	
	public function admin_index()
	{
		$this->layout = 'adminInner';
		$ThemeSetting=$this->Session->read('ThemeSetting');
		$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
		if($this->request->is("post"))
		{ 
			$data = $this->request->data;
			$likekeyArr = array('title');
			$datekeyArr = array('created_date');
			$conditionArr = array();
			foreach($data['Page'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['Page.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
						if(in_array($k,$datekeyArr)){
							$conditionArr['Page.'.$k] = date('Y-m-d',strtotime($v)); 
							} else {
							$conditionArr['Page.'.$k] = $v; 
						}
					}
				}
			}
			//$conditionArr['Page.is_del'] = 0; 
			if($ThemeSettingheadertype=='H')
			{
				$conditionArr['Page.template_use'] = 'HN'; 
			}
			if($ThemeSettingheadertype=='V')
			{
				$conditionArr['Page.template_use'] = 'VN'; 
			}
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Page.id' => 'DESC')
			);
			$this->set('searchData',$data);

		} else {
			
			
			if($ThemeSettingheadertype=='H')
			{
				$this->paginate=array(
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'conditions'=>array('Page.type'=>'Page','Page.template_use'=>'HN'),
				'order'=>array('Page.id' => 'DESC')
				);
			}
			if($ThemeSettingheadertype=='V')
			{
				$this->paginate=array(
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'conditions'=>array('Page.type'=>'Page','Page.template_use'=>'VN'),
				'order'=>array('Page.id' => 'DESC')
				);
			}
			
			}		
		$data=$this->paginate('Page'); //pr($data); exit();		/* $isdelcou=array();		$isdelcou=$this->Page->find('all',array(								'conditions'=>array('Page.is_del'=>1,'Page.type'=>'Page')								));		pr($isdelcou);		exit; */
		$this->set('data', $data);				//$this->set('isdelcou', $isdelcou);
	}
	
	public function admin_manage($id=NULL){	
		$this->layout = 'adminInner';
		
		/***** Add and Edit Data *****/
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			if($this->Page->validates()){
				if(!empty($id)){

					$slugArr = array('controller_name'=>'Pages','action_name'=>'display','mode'=>'edit','pre_slug_name'=>$reqdata['Page']['set_slug']);
					$reqdata['Page']['slug']=($reqdata['Page']['slug'] == $reqdata['Page']['set_slug'])?$reqdata['Page']['slug']:AppController::get_slug($reqdata['Page']['slug'],$slugArr);
					
					
					$reqdata['Page']['updated_date'] = date("Y-m-d"); 
					$this->Page->id = $id;
					$pagecount = $this->Page->find('count',array('conditions'=>array('template_id'=>$reqdata['Page']['template_id'])));
					if($pagecount>1)
					{
					$notclonedataArr=$this->PageTemplate->findByIdAndIsClone($reqdata['Page']['template_id'],0);
					
							$data['PageTemplate']['template_id']=$notclonedataArr['PageTemplate']['id'];
							$data['PageTemplate']['template_name']=$notclonedataArr['PageTemplate']['template_name'];
							//$data['PageTemplate']['template_id']= $notclonedataArr['PageTemplate']['template_id'];
							$data['PageTemplate']['template_for']=$notclonedataArr['PageTemplate']['template_for'];
							$data['PageTemplate']['with_sidebar']= $notclonedataArr['PageTemplate']['with_sidebar'];
							//pr($data);
						
							$fl1 = $this->addcustomtemplate1($data);
							//echo $fl1;
							//die;
							
							
							$reqdata['Page']['content'] = $this->generateTemplate($fl1);
							$reqdata['Page']['template_id'] = $fl1;
							$pageTemplatedata = $this->PageTemplate->findById($fl1);
						
					}else {
					
					
					$this->PageTemplate->id=$reqdata['Page']['template_id'];
					$pagetemplateis_clone['PageTemplate']['is_clone']=0;
					$this->PageTemplate->save($pagetemplateis_clone);
					
					$reqdata['Page']['content'] = $this->generateTemplate($reqdata['Page']['template_id']);
				
					$pageTemplatedata = $this->PageTemplate->findById($reqdata['Page']['template_id']);
					
					
					}
					
					
				} else{
				$slugArr = array('controller_name'=>'Pages','action_name'=>'display');
				$reqdata['Page']['slug']=AppController::get_slug($reqdata['Page']['title'],$slugArr);
					
					
				$reqdata['Page']['created_date'] = date("Y-m-d");
				$this->Page->create();
					
				$notclonedataArr=$this->PageTemplate->findByIdAndIsClone($reqdata['Page']['template_id'],0);
					if(!empty($notclonedataArr))
					{
					$data['PageTemplate']['template_id']=$notclonedataArr['PageTemplate']['id'];
					$data['PageTemplate']['template_name']=$notclonedataArr['PageTemplate']['template_name'];
					//$data['PageTemplate']['template_id']= $notclonedataArr['PageTemplate']['template_id'];
					$data['PageTemplate']['template_for']=$notclonedataArr['PageTemplate']['template_for'];
					$data['PageTemplate']['with_sidebar']= $notclonedataArr['PageTemplate']['with_sidebar'];
					//pr($data);
				
					$fl1 = $this->addcustomtemplate1($data);
					//echo $fl1;
					//die;
					
					
					$reqdata['Page']['content'] = $this->generateTemplate($fl1);
					$reqdata['Page']['template_id'] = $fl1;
					$pageTemplatedata = $this->PageTemplate->findById($fl1);
					
					}else {
					
					$this->PageTemplate->id=$reqdata['Page']['template_id'];
					$pagetemplateis_clone['PageTemplate']['is_clone']=0;
					$this->PageTemplate->save($pagetemplateis_clone);
					
					$reqdata['Page']['content'] = $this->generateTemplate($reqdata['Page']['template_id']);
				
					$pageTemplatedata = $this->PageTemplate->findById($reqdata['Page']['template_id']);
					}
					
					
				}
				$reqdata['Page']['save']=0;
				/* if(!empty($notclonedataArr))
				{
				$reqdata['Page']['content'] = $this->generateTemplate($fl1);
				$reqdata['Page']['template_id'] = $fl1;
				$pageTemplatedata = $this->PageTemplate->findById($fl1);
				
				}else {
				$reqdata['Page']['content'] = $this->generateTemplate($reqdata['Page']['template_id']);
				
				$pageTemplatedata = $this->PageTemplate->findById($reqdata['Page']['template_id']);
				} */
				//$pageTemplatedata = $this->PageTemplate->findById($reqdata['Page']['template_id']);
				$reqdata['Page']['template_use']=$pageTemplatedata['PageTemplate']['template_use'];
				$reqdata['Page']['page_url'] = SITE_URL.$reqdata['Page']['slug'];
				$reqdata['Page']['categoryid'] = 0;
				$reqdata['Page']['type'] = 'Page';
				$reqdata['Page']['is_del'] = 0;
				
				
				
				
				/* if(array_key_exists('page_banner_image',$reqdata['Page']))
				{
					if($reqdata['Page']['page_banner_image']['name']!=""){
						list($file1,$error1,$update_field1) = AppController::upload($reqdata['Page']['page_banner_image'],WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'page_banner_image'. DS . 'original' . DS ,'jpg,jpeg,JPG,JPEG,gif,GIF,png,PNG');
						
						if($error1 == ""){
						$image	=	new SimpleImage();
						
						$image->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'page_banner_image'. DS . 'original' . DS .$file1); 
						$image_size=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'page_banner_image'. DS . 'original' . DS .$file1,1000,300); 
						$image->resize($image_size['0'],$image_size['1']); 
						$image->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'page_banner_image'. DS . 'resize' . DS .$file1); 
						
						$thumb	=	new SimpleImage();
						
						$thumb->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'page_banner_image'. DS . 'original' . DS .$file1); 
						$image_size=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'page_banner_image'. DS . 'original' . DS .$file1,160,145); 
						$thumb->resize($image_size['0'],$image_size['1']); 
						$thumb->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'page_banner_image'. DS . 'thumb' . DS .$file1); 
						
						$reqdata['Page']['page_banner_image'] = $file1;
						}
						else
						{
							$reqdata['Page']['page_banner_image'] = "";
						}
					} else {
						$reqdata['Page']['page_banner_image'] = "";
					}
				} else if ($reqdata['Page']['set_banner_image']!="")
				{
					$reqdata['Page']['page_banner_image'] = $reqdata['Page']['set_banner_image'];
				} else {
					$reqdata['Page']['page_banner_image'] = '';
				} */
				
				
				
				
				
				
				
				//pr($reqdata); exit();
				
				$saveFlag = $this->Page->save($reqdata);
				$saveId = $this->Page->id;

				
				if($saveFlag){
					
					if($id != ''){
						$this->Session->setFlash('Page updated successfully.', 'default', array('class' => 'alert alert-success'));
					} else{
						$this->Session->setFlash('Page added successfully', 'default', array('class' => 'alert alert-success'));
					}
					
				} else { 
					$this->Session->setFlash('Failed to save the page', 'default', array('class' => 'alert alert-danger'));
				}
				
				if(array_key_exists('continue', $reqdata)){
					$this->redirect(array('controller'=>'Pages','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'Pages','action'=>'admin_index'));
				}
				
				//$this->redirect(array('controller'=>'Pages','action'=>'admin_index'));
				
			} else {
				$this->set('errors', $this->Product->invalidFields());
			}
		
		}
		/***** Add and Edit Data *****/
		
		/***** Fetch Data *****/
		if(!empty($id)){
			$this->Page->bindModel(array(
									'hasMany' => array(
										'PageVersion' => array(
												'className'    => 'PageVersion',
												'foreignKey'   => 'Page_id',
												'order'=>array('PageVersion.date DESC'),
												'limit' => 5
											),
										
									)
								));
			$data = $this->Page->findById($id);
			
			if(!empty($data)){
				$pageTemplate = $this->PageTemplate->findById($data['Page']['template_id']);
				
				/**** Template Row Column ****/
				$this->PageTemplateRow->bindModel(
					array(
						'hasMany'=>array(
							'PageTemplateRowsColumn'=>array(
								'className'    => 'PageTemplateRowsColumn',
								'foreignKey'   => 'row_id',
								'conditions'   => array('PageTemplateRowsColumn.parent_colid'=>0),
								'order'			=> array('PageTemplateRowsColumn.sort_order ASC')
							)
						)
					)
				);
				
				$tplrwclArr = $this->PageTemplateRow->find('all', array(
									'conditions'=>array(
										'template_id'=>$data['Page']['template_id']
									),
									'order'=>array('PageTemplateRow.sort_order ASC')
								)
							);

				$pagecount = $this->Page->find('count',array('conditions'=>array('template_id'=>$data['Page']['template_id'])));				

			} else {
				$pageTemplate = array();
				$tplrwclArr = array();
			}
			//pr($tplrwclArr); exit();
			/**** Template Row Column ****/

			

			
			$this->set(compact('data', 'pageTemplate', 'tplrwclArr','pagecount'));
		}
		
		
		/***** Template List *****/
		$userArr = AuthComponent::user();
		
		if($userArr['user_type'] == 'super'){
			$ThemeSetting=$this->Session->read('ThemeSetting');
			$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
			if($ThemeSettingheadertype=='H')
			{
				$tplList = $this->PageTemplate->find('list', array(
					'conditions'=>array('template_for'=>'I','template_use'=>'HN'),
					'fields'=>array('id', 'template_name')
				));
				$tplList['custom'] = 'Add New';
			}
			if($ThemeSettingheadertype=='V')
			{
				$tplList = $this->PageTemplate->find('list', array(
					'conditions'=>array('template_for'=>'I','template_use'=>'VN'),
					'fields'=>array('id', 'template_name')
				));
				$tplList['custom'] = 'Add New';
			}
			
		} else {
			$this->loadModel('User');
			$tplsuperUser = $this->User->findByUserType('super');
			
			if(!empty($tplsuperUser)){
			$tplList = $this->PageTemplate->find('list', array(
					'conditions'=>array(
						'template_for'=>'I',
						'created_by'=>$tplsuperUser['User']['user_id'],
						'show_flag'=>'Y'
					),
					'fields'=>array('id', 'template_name')
				));
			} else {
				$tplList = array();
			}
		}
		
		$this->set(compact('id','cmsGallery','tplList'));
		/***** Fetch Data *****/
	}
	
public function admin_clientmanage($id=NULL){
	$this->layout = 'adminInner';
	
	
	
		
		/***** Add and Edit Data *****/
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			//pr($reqdata);die;
			if($this->Page->validates()){
				if(!empty($id)){
						
					$slugArr = array('controller_name'=>'Pages','action_name'=>'display','mode'=>'edit','pre_slug_name'=>$reqdata['Page']['set_slug']);
					$reqdata['Page']['slug']=($reqdata['Page']['slug'] == $reqdata['Page']['set_slug'])?$reqdata['Page']['slug']:AppController::get_slug($reqdata['Page']['slug'],$slugArr);
					
					
					$reqdata['Page']['updated_date'] = date("Y-m-d"); 
					$this->Page->id = $id;
				} else{
					$slugArr = array('controller_name'=>'Pages','action_name'=>'display');
					$reqdata['Page']['slug']=AppController::get_slug($reqdata['Page']['title'],$slugArr);
					
					
					$reqdata['Page']['created_date'] = date("Y-m-d");
					$this->Page->create();
				}
				$reqdata['Page']['save']=0;
				
				$reqdata['Page']['content'] = $this->generateTemplate1($id);
				
				
				$pageTemplatedata = $this->PageTemplate->findById($reqdata['Page']['template_id']);
				$reqdata['Page']['template_use']=$pageTemplatedata['PageTemplate']['template_use'];
				$reqdata['Page']['page_url'] = SITE_URL.$reqdata['Page']['slug'];
				$reqdata['Page']['categoryid'] = 0;
				$reqdata['Page']['type'] = 'Page';
				$reqdata['Page']['is_del'] = 0;
				
				//pr($reqdata); exit();
				
				$saveFlag = $this->Page->save($reqdata);
				$saveId = $this->Page->id;

				
				if($saveFlag){
					
					if($id != ''){
						$this->Session->setFlash('Page updated successfully.', 'default', array('class' => 'alert alert-success'));
					} else{
						$this->Session->setFlash('Page added successfully', 'default', array('class' => 'alert alert-success'));
					}
					
				} else { 
					$this->Session->setFlash('Failed to save the page', 'default', array('class' => 'alert alert-danger'));
				}
				
				if(array_key_exists('continue', $reqdata)){
					$this->redirect(array('controller'=>'Pages','action'=>'admin_clientmanage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'Pages','action'=>'admin_index'));
				}
				
				//$this->redirect(array('controller'=>'Pages','action'=>'admin_index'));
				
			} else {
				$this->set('errors', $this->Product->invalidFields());
			}
		
		}
		/***** Add and Edit Data *****/
		
		/***** Fetch Data *****/
		if(!empty($id)){
		
		
		
		
		
		
			$this->Page->bindModel(array(
									'hasMany' => array(
										'PageVersion' => array(
												'className'    => 'PageVersion',
												'foreignKey'   => 'Page_id',
												'order'=>array('PageVersion.date DESC'),
												'limit' => 5
											),
										
									)
								));
			$data = $this->Page->findById($id);
			
			if(!empty($data)){
				$pageTemplate = $this->PageTemplate->findById($data['Page']['template_id']);
				
				/**** Template Row Column ****/
				$this->PageTemplateRow->bindModel(
					array(
						'hasMany'=>array(
							'PageTemplateRowsColumn'=>array(
								'className'    => 'PageTemplateRowsColumn',
								'foreignKey'   => 'row_id',
								'conditions'   => array('PageTemplateRowsColumn.parent_colid'=>0),
								'order'			=> array('PageTemplateRowsColumn.sort_order ASC')
							)
						)
					)
				);
				
				$tplrwclArr = $this->PageTemplateRow->find('all', array(
									'conditions'=>array(
										'template_id'=>$data['Page']['template_id']
									),
									'order'=>array('PageTemplateRow.sort_order ASC')
								)
							);
			$pageArrrdetail = $this->Page->findById($data['Page']['id']);
			$pageArrrdetail2 = $this->make_content($pageArrrdetail['Page']['content']);
			} 
			//pr($pageArrrdetail2);
			//pr($tplrwclArr);die;
			// insert into the edit page templates start
			
			$findrowarr=$this->EditPageTemplateRow->findByPageId($id);
			$conditionss = array (
					"EditPageTemplateRow.page_id" => $id
					);
			$conditionsss = array (
					"EditPageTemplateRowsColumn.page_id" => $id
					);
			$deleterowr=$this->EditPageTemplateRow->deleteAll($conditionss);
			$deleterowrr=$this->EditPageTemplateRowsColumn->deleteAll($conditionsss);
			
				$this->PageTemplateRow->bindModel(
					array(
						'hasMany'=>array(
							'PageTemplateRowsColumn'=>array(
								'className'    => 'PageTemplateRowsColumn',
								'foreignKey'   => 'row_id',
								/* 'conditions'   => array('PageTemplateRowsColumn.parent_colid'=>0), */
								'order'			=> array('PageTemplateRowsColumn.sort_order ASC')
							)
						)
					)
				);
			
			
				$tplrwclArr1 = $this->PageTemplateRow->find('all', array(
									'conditions'=>array(
										'template_id'=>$data['Page']['template_id']
									),
									'order'=>array('PageTemplateRow.sort_order ASC')
								)
							);
			
			
				foreach($tplrwclArr1 as $testarr)
				{
				  
				  $editpagesarr['EditPageTemplateRow']['page_id']=$id;
				  $editpagesarr['EditPageTemplateRow']['rowstyle']=$testarr['PageTemplateRow']['rowstyle'];
				  $editpagesarr['EditPageTemplateRow']['rowwithForeground']=$testarr['PageTemplateRow']['rowwithForeground'];
				  $editpagesarr['EditPageTemplateRow']['sort_order']=$testarr['PageTemplateRow']['sort_order'];
				  
				  $this->EditPageTemplateRow->create();
				  $this->EditPageTemplateRow->save($editpagesarr);
				  $idd='';
				  foreach($testarr['PageTemplateRowsColumn'] as $testarrr)
				  {
				  $editpagesrowcolarr['EditPageTemplateRowsColumn']['page_id']=$id;
				  $editpagesrowcolarr['EditPageTemplateRowsColumn']['row_id']=$this->EditPageTemplateRow->id;
				  
				  $editpagesrowcolarr['EditPageTemplateRowsColumn']['column_id']=$testarrr['id'];
				  $editpagesrowcolarr['EditPageTemplateRowsColumn']['name']=$testarrr['name'];
				  $editpagesrowcolarr['EditPageTemplateRowsColumn']['column']=$testarrr['column'];
				  $editpagesrowcolarr['EditPageTemplateRowsColumn']['shortcode']=$testarrr['shortcode'];
				  $editpagesrowcolarr['EditPageTemplateRowsColumn']['clone_flag']=$testarrr['clone_flag'];
				  if($testarrr['parent_colid']==0)
				  {
				  $editpagesrowcolarr['EditPageTemplateRowsColumn']['parent_colid']=$testarrr['parent_colid'];
				  }else {
				   $editpagesrowcolarr['EditPageTemplateRowsColumn']['parent_colid']=$idd;
				  }
				  $editpagesrowcolarr['EditPageTemplateRowsColumn']['multiple_col']=$testarrr['multiple_col'];
				  $editpagesrowcolarr['EditPageTemplateRowsColumn']['sort_order']=$testarrr['sort_order'];
							  
				  $this->EditPageTemplateRowsColumn->create();
				  $this->EditPageTemplateRowsColumn->save($editpagesrowcolarr);
				  if(empty($testarrr['shortcode']))
				  {
				  $idd=$this->EditPageTemplateRowsColumn->id;
				  }
				  
				  }
				
				  
				  
				  
				}
			
			// insert into the edit page templates end
			
			$columname=$this->EditPageTemplateRowsColumn->find('all',array('conditions'=>array('EditPageTemplateRowsColumn.page_id'=>$id)));
			//pr($columname);die;
			//pr($tplrwclArr); exit();
			/**** Template Row Column ****/
			
			$this->set(compact('data', 'pageTemplate', 'tplrwclArr','pageArrrdetail2','columname'));
		}
		
		
		/***** Template List *****/
		$userArr = AuthComponent::user();
		
		if($userArr['user_type'] == 'super'){
			$ThemeSetting=$this->Session->read('ThemeSetting');
			$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
			if($ThemeSettingheadertype=='H')
			{
				$tplList = $this->PageTemplate->find('list', array(
					'conditions'=>array('template_for'=>'I','template_use'=>'HN'),
					'fields'=>array('id', 'template_name')
				));
				$tplList['custom'] = 'Add New';
			}
			if($ThemeSettingheadertype=='V')
			{
				$tplList = $this->PageTemplate->find('list', array(
					'conditions'=>array('template_for'=>'I','template_use'=>'VN'),
					'fields'=>array('id', 'template_name')
				));
				$tplList['custom'] = 'Add New';
			}
			
		} else {
			$this->loadModel('User');
			$tplsuperUser = $this->User->findByUserType('super');
			
			if(!empty($tplsuperUser)){
			$tplList = $this->PageTemplate->find('list', array(
					'conditions'=>array(
						'template_for'=>'I',
						'created_by'=>$tplsuperUser['User']['user_id'],
						'show_flag'=>'Y'
					),
					'fields'=>array('id', 'template_name')
				));
			} else {
				$tplList = array();
			}
		}
		
		$this->set(compact('id','cmsGallery','tplList'));
}



private function generateTemplate1($id){
		$str = '';
		$this->EditPageTemplateRow->bindModel(
			array(
				'hasMany'=>array(
					'EditPageTemplateRowsColumn'=>array( 
						'className'    => 'EditPageTemplateRowsColumn',
						'foreignKey'   => 'row_id',
						  'conditions'   => array('EditPageTemplateRowsColumn.parent_colid'=>0), 
						'order'			=> array('EditPageTemplateRowsColumn.sort_order ASC')
					)
				)
			)
		);
		$tmplRows = $this->EditPageTemplateRow->find('all', array(
				'conditions'=>array('EditPageTemplateRow.page_id'=>$id),
				'order'=>array('EditPageTemplateRow.sort_order ASC')
			)
		);
		//print_r($tmplRows);die();
		if(!empty($tmplRows)){
			foreach($tmplRows as $rowitem){
				if($rowitem['EditPageTemplateRow']['rowstyle']=='FULLWIDTH'){
					foreach($rowitem['EditPageTemplateRowsColumn'] as $col){
						$str .= '<div class="full_width main-el cstm-img-responsive">'.$col['shortcode'].'</div>';
						
					
						
					}
				} else {
					$innerstr = "";
					$innerstr .= '<div class="container">';
					$innerstr .= '<div class="row mob-pdtp-nst0">';
					//print_r($rowitem['EditPageTemplateRowsColumn']);die();
					foreach($rowitem['EditPageTemplateRowsColumn'] as $col){
						$innerstr .= '<div class="col-md-'.$col['column'].' main-el cstm-img-responsive">';
						
					
						
						  
						if($col['multiple_col']=='T'){
						    
							 $innerstr .= $this->childcolgenerateTemplate1($col['id']);
							
							
						} else {
							$innerstr .= $col['shortcode'];
						}
						$innerstr .= '</div>';
					}
					$innerstr .= '</div>';
					$innerstr .= '</div>';
					
					if($rowitem['EditPageTemplateRow']['rowwithForeground']=='Y'){
						$str .= '<div class="content">'.$innerstr.'</div>';
					} else {
						$str .= $innerstr;
					}
				}
			}
		}
		//echo $str;die(); 
		return $str;
	}
	
	private function childcolgenerateTemplate1($parent_id = NULL){
		$str = '';
		//echo $parent_id;die();
		if($parent_id!=NULL){
			$childColArr = $this->EditPageTemplateRowsColumn->find('all', array(
					'conditions'=>array(
						'EditPageTemplateRowsColumn.parent_colid'=>$parent_id
					),
					'order'=>array('EditPageTemplateRowsColumn.sort_order ASC')
				)
			);
			
			if(!empty($childColArr)){
				$str .= '<div class="row">';
				foreach($childColArr as $childCol){
	$str .= '<div class="col-md-'.$childCol['EditPageTemplateRowsColumn']['column'].' cstm-img-responsive">';
					
					
					
					
					
					
					$str .= $childCol['EditPageTemplateRowsColumn']['shortcode'];
					$str .= '</div>';
				}
				$str .= '</div>';
			}
		}
		return $str;
	}
















private function make_content($content){
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
			return $c;
			 
			//exit; 
			
		}
		
	}
	
	private function mb_stripos_all($haystack, $needle) {
 
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
	
	public function admin_frontpage(){
		$this->layout = 'adminInner';
		$ThemeSetting=$this->Session->read('ThemeSetting');
		$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
			
		if($this->request->is('post')){
			if($this->Page->validates()){
				$reqdata = $this->request->data;
				$reqdata['Page']['content'] = $this->generateTemplate($reqdata['Page']['template_id']);
				//pr($reqdata['Page']['content']);
				//pr($reqdata); 
				//exit;
				if($ThemeSettingheadertype=='H')
				{
					$reqdata['Page']['template_use']='HN';
				}
				if($ThemeSettingheadertype=='V')
				{
					$reqdata['Page']['template_use']='VN';
				}
				
				$this->Page->id = $reqdata['Page']['id'];
				
				$flag = $this->Page->save($reqdata);
				
				$this->PageTemplate->save($reqdata);
				if($flag){
					$this->Session->setFlash('Front Page updated successfully.', 'default', array('class' => 'alert alert-success'));
				} else {
					$this->Session->setFlash('Failed to update front page.', 'default', array('class' => 'alert alert-success'));
				}
				$this->redirect($this->referer());
			}
		}
		
		
		$data = $this->Page->findById(1);
		if(!empty($data['Page']['template_id'])){
			
			$ThemeSetting=$this->Session->read('ThemeSetting');
			$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
			if($ThemeSettingheadertype=='H')
			{
			$tplList = $this->PageTemplate->find('list', array(
				'conditions'=>array('template_for'=>'H','template_use'=>'HN'),
				'fields'=>array('id', 'template_name')
			));
			$tplList['custom'] = 'Add New';
			}else if($ThemeSettingheadertype=='V')
			{
				$tplList = $this->PageTemplate->find('list', array(
				'conditions'=>array('template_for'=>'H','template_use'=>'VN'),
				'fields'=>array('id', 'template_name')
				));
			$tplList['custom'] = 'Add New';
			}
			$this->PageTemplateRow->bindModel(
				array(
					'hasMany'=>array(
						'PageTemplateRowsColumn'=>array(
							'className'    => 'PageTemplateRowsColumn',
							'foreignKey'   => 'row_id',
							'conditions'   => array('PageTemplateRowsColumn.parent_colid'=>0),
							'order'			=> array('PageTemplateRowsColumn.sort_order ASC')
						)
					)
				)
			);
			
			$tplrwclArr = $this->PageTemplateRow->find('all', array(
								'conditions'=>array(
									'template_id'=>$data['Page']['template_id']
								),
								'order'=>array('PageTemplateRow.sort_order ASC')
							)
						);
						
			//pr($tplrwclArr); exit();
		} else {
			$tplList = array();
			$tplrwclArr = array();
		}
		//pr($tplpreviewData); exit();
		$id = $data['Page']['id'];
		$this->set(compact('id', 'data', 'tplList', 'tplrwclArr'));
	}
	
	private function generateTemplate($id){
		$str = '';
		$this->PageTemplateRow->bindModel(
			array(
				'hasMany'=>array(
					'PageTemplateRowsColumn'=>array(
						'className'    => 'PageTemplateRowsColumn',
						'foreignKey'   => 'row_id',
						'conditions'   => array('PageTemplateRowsColumn.parent_colid'=>0),
						'order'			=> array('PageTemplateRowsColumn.sort_order ASC')
					)
				)
			)
		);
		$tmplRows = $this->PageTemplateRow->find('all', array(
				'conditions'=>array('PageTemplateRow.template_id'=>$id),
				'order'=>array('PageTemplateRow.sort_order ASC')
			)
		);
		
		if(!empty($tmplRows)){
			$ip = 0;
			$fw = 0;
			foreach($tmplRows as $rowitem){
				if($rowitem['PageTemplateRow']['rowstyle']=='FULLWIDTH'){
					
					
					$extra_css	='';
					$extras1='';
					if(!empty($rowitem['PageTemplateRow']['row_class']))
					{
						$extra_css= $rowitem['PageTemplateRow']['row_class'];
					}else{
                                                $extra_css= "";
                                        }
					if(!empty($rowitem['PageTemplateRow']['background_image']))
					{
						if($rowitem['PageTemplateRow']['background_image'][0]=='#')
						{
							$extra_bimage= ' style="background:'.$rowitem['PageTemplateRow']['background_image'].'"';
						}
						else
						{
							$extra_bimage= ' style="background-image:url('.$rowitem['PageTemplateRow']['background_image'].')"';
						}
						
					}else{
                                                $extra_bimage= ' style=""';
                                        }
					if($ip==0)
					{
						$str .= '<section class="certificate-banner '.$extra_css.'" '.$extra_bimage.'>';
						$str .= '<div class="container-fluid">';
						$str .= '<div class="row">';
						$str .= '<div class="mask"></div>';						
					}						
					else
					{
						$str .= '<section class="'.$extra_css.'" '.$extra_bimage.'>';
						$str .= '<div class="container-fluid">';
						$str .= '<div class="row">';						

					}
					
					
					
					
					foreach($rowitem['PageTemplateRowsColumn'] as $col){
						
						if(!empty($col['class']))
						{
							$str .= '<div class="col-md-'.$col['column'].' '.$col['class'].'">'.$col['shortcode'].'</div>';
						}
						else
						{
							$str .= '<div class="col-md-'.$col['column'].'">'.$col['shortcode'].'</div>';
						}
					}
					
					$str .= '</div>';
					$str .= '</div>';
					$str .= '</section>';
				} else {
					$innerstr = "";
					$innerstr .= '<div class="container">';
					$innerstr .= '<div class="row">';
					foreach($rowitem['PageTemplateRowsColumn'] as $col){
						$innerstr .= '<div class="col-md-'.$col['column'].' main-el cstm-img-responsive">';
						
					
						
						  
						if($col['multiple_col']=='T'){
							$innerstr .= $this->childcolgenerateTemplate($col['id']);
						} else {
							$innerstr .= $col['shortcode'];
						}
						$innerstr .= '</div>';
					}
					$innerstr .= '</div>';
					$innerstr .= '</div>';
					
					if($rowitem['PageTemplateRow']['rowwithForeground']=='Y'){
						$str .= '<div class="content">'.$innerstr.'</div>';
					} else {
						$str .= $innerstr;
					}
				}
				$ip++;
				$fw++;
			}
		}
		
		return $str;
	}
	
	private function childcolgenerateTemplate($parent_id = NULL){
		$str = '';
		if($parent_id!=NULL){
			$childColArr = $this->PageTemplateRowsColumn->find('all', array(
					'conditions'=>array(
						'PageTemplateRowsColumn.parent_colid'=>$parent_id
					),
					'order'=>array('PageTemplateRowsColumn.sort_order ASC')
				)
			);
			
			if(!empty($childColArr)){
				$str .= '<div class="row">';
				foreach($childColArr as $childCol){
					
					if(!empty($childCol['PageTemplateRowsColumn']['class']))
					{
						$str .= '<div class="col-md-'.$childCol['PageTemplateRowsColumn']['column'].' cstm-img-responsive '.$childCol['PageTemplateRowsColumn']['class'].'">';
					}
					else
					{
						$str .= '<div class="col-md-'.$childCol['PageTemplateRowsColumn']['column'].' cstm-img-responsive">';	
					}
					
					$str .= $childCol['PageTemplateRowsColumn']['shortcode'];
					$str .= '</div>';
				}
				$str .= '</div>';
			}
		}
		return $str;
	}
	
	public function admin_fpaddrow(){
		$this->layout = "ajax";
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			//pr($reqdata); exit();
			$tpldata = $this->PageTemplate->findById($reqdata['tplId']);
			if(!empty($tpldata)){
				if($tpldata['PageTemplate']['template_type']=="PRE"){
					echo 1; exit();
				} else {
					if(!empty($reqdata['rowId'])){
						$data = $this->PageTemplateRow->findById($reqdata['rowId']);
					} else {
						$data = array();
					}
					$this->set(compact('reqdata', 'data'));
				}
			}
		}
	}
	
	public function admin_rowsubmit($id = NULL){
		$this->layout = "ajax";
		
		if($this->request->is("post")){
			$saveData = $this->request->data;
			//echo '<pre>',print_r($saveData); 
			if(!empty($id)){
				$this->PageTemplateRow->id = $id;
			} else {
				$this->PageTemplateRow->create();
			}
			$fl = $this->PageTemplateRow->save($saveData);
			echo ($fl)?1:0; exit();
		}
	}
	
	public function admin_fpaddcol(){
		$this->layout = "ajax";
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			//pr($reqdata); exit();
			$tplId=$reqdata['tplId'];
			$shotcode=$reqdata['shotcode'];
			$rowId=$reqdata['rowId'];
			$colId=$reqdata['colId'];
			$pageid=$reqdata['pageid'];
			$parentcolId=$reqdata['parentcolId'];
			
			$tpldata = $this->PageTemplate->findById($reqdata['tplId']);
			if(!empty($tpldata)){
				/* if($tpldata['PageTemplate']['template_type']=="PRE"){
					echo 1; exit();
				} else { */
					if(array_key_exists('colId', $reqdata)){
						$data = $this->PageTemplateRowsColumn->findById($reqdata['colId']);
					} else {
						if($tpldata['PageTemplate']['template_type']=="PRE"){
							echo 1; exit();
						} else {
							$data = array();
						}
					}
					
					$this->set(compact('reqdata', 'data', 'tpldata', 'tplId','rowId','pageid','shotcode','colId','parentcolId'));
				}
			/* } */
		}
	}
	
	public function admin_fpsidebaraddcol(){
		$this->layout = "ajax";
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			//pr($reqdata); exit();
			$tplId=$reqdata['tplId'];
			$rowId=$reqdata['rowId'];
			$tpldata = $this->PageTemplate->findById($reqdata['tplId']);
			if(!empty($tpldata)){
				if($tpldata['PageTemplate']['template_type']=="PRE"){
					echo 1; exit();
				} else {
					if(array_key_exists('colId', $reqdata)){
						$data = $this->PageTemplateRowsColumn->findById($reqdata['colId']);
					} else {
						$data = array();
					}
					
					$shortcodeArr = $this->Shortcode->find('all', array(
							'conditions'=>array(
								'Shortcode.name'=>'Sidebar'
							),
							'order'=>array('Shortcode.widget_id ASC')
						)
					);
					
					$this->set(compact('reqdata', 'data', 'shortcodeArr', 'tpldata', 'tplId','rowId'));
				}
			}
		}
	}
	
	public function admin_columnsubmit($id = NULL){
		$this->layout = "ajax";
		
		if($this->request->is('post')){
			$data = $this->request->data; 
			
			if(empty($data['shortcodeFld']))
			{
					if(!empty($id)){
						$this->PageTemplateRowsColumn->id = $id;
					} else {
						//$this->loadModel();
						$this->PageTemplateRowsColumn->create();
					}
				 $pageid=$data['PageTemplateRowsColumn']['pageid'];
				if(!empty($pageid)){
				$this->Page->id = $pageid;
				$updata['Page']['save']=1;
				$this->Page->save($updata);
				}
					$fl = $this->PageTemplateRowsColumn->save($data);
					echo ($fl)?1:0; exit();
			}
			else {
			
			$this->Page->id = $data['pageid'];
			$updata['Page']['save']=1;
			$this->Page->save($updata);
			$editdatarow['EditPageTemplateRowsColumn']['shortcode']=$data['shortcodeFld'];
			$editdatarow['EditPageTemplateRowsColumn']['name']=$data['collmane'];
			if($data['parentcolId']!=0)
			{
			$datarow=$this->EditPageTemplateRowsColumn->findByColumnIdAndPageId($data['parentcolId'],$data['pageid']);
			}else {
			$datarow=$this->EditPageTemplateRowsColumn->findByColumnIdAndPageId($data['colId'],$data['pageid']);
			}
			
		
			$this->EditPageTemplateRowsColumn->id=$datarow['EditPageTemplateRowsColumn']['id'];
			$fl =$this->EditPageTemplateRowsColumn->save($editdatarow);
			echo $data['shortcodeFld']; exit();
		
		
			}
		}
	}
	
	public function admin_saveastemplate(){
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$data = $this->request->data;
			if(!empty($data['tplId'])){
				$tpldata = $this->PageTemplate->findById($data['tplId']);
			} else {
				$tpldata = array();
			}
			$this->set(compact('data','tpldata'));
		}
	}
	
	public function admin_confirmproceed(){
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$data = $this->request->data;
			if(!empty($data['tplId'])){
				$tpldata = $this->PageTemplate->findById($data['tplId']);
			} else {
				$tpldata = array();
			}
			$this->set(compact('data','tpldata'));
		}
	}
	
	public function admin_saveastplsubmit()
	{
		$this->layout = "ajax";
		
		if($this->request->is("post"))
		{
			$data = $this->request->data;
			
			$fl = $this->addcustomtemplate($data);
			
			echo ($fl!=0)?$fl:0;
			exit();
		}
	}
	
	public function addcustomtemplate($data){
		if(!empty($data)){
			$this->PageTemplate->create();
			$userArr = AuthComponent::user();
			
			$data['PageTemplate']['created_by'] = $userArr['user_id'];
			//$data['PageTemplate']['template_type'] = ($userArr['user_type']=="super")?"PRE":"CUSTOM";
			$data['PageTemplate']['template_type'] = "CUSTOM";
			$data['PageTemplate']['Status'] = "Y";
			/* if(!empty($data['PageTemplate']['template_id'])){
			$data['PageTemplate']['is_clone'] =1; 
			}else {
			$data['PageTemplate']['is_clone'] =0; 
			} */
			$data['PageTemplate']['is_clone'] =1; 
			$ThemeSetting=$this->Session->read('ThemeSetting');
			$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
			if($ThemeSettingheadertype=='H')
			{
				$data['PageTemplate']['template_use'] = "HN";
			}
			if($ThemeSettingheadertype=='V')
			{
				$data['PageTemplate']['template_use'] = "VN";
			}
			//pr($data);
			//die;
			$saveFlag = $this->PageTemplate->save($data);
			$newtplId = $this->PageTemplate->id;
			
			
			if(!empty($data['PageTemplate']['template_id'])){
				$this->PageTemplateRow->bindModel(
					array(
						'hasMany'=>array(
							'PageTemplateRowsColumn'=>array(
								'className'    => 'PageTemplateRowsColumn',
								'foreignKey'   => 'row_id',
								'conditions'	=> array('PageTemplateRowsColumn.parent_colid'=>0)
							)
						)
					)
				);
				
				$tplrwclArr = $this->PageTemplateRow->find('all', array(
									'conditions'=>array(
										'template_id'=>$data['PageTemplate']['template_id']
									)
								)
							);
				
				//return $tplrwclArr;
				if(!empty($tplrwclArr)){
					foreach($tplrwclArr as $row){
						$this->PageTemplateRow->create();
						$saveRow['PageTemplateRow']['template_id'] = $newtplId;
						$saveRow['PageTemplateRow']['rowstyle'] = $row['PageTemplateRow']['rowstyle'];
						$saveRow['PageTemplateRow']['rowwithForeground'] = $row['PageTemplateRow']['rowwithForeground'];
                                                $saveRow['PageTemplateRow']['row_class'] = $row['PageTemplateRow']['row_class'];
						$saveRow['PageTemplateRow']['background_image'] = $row['PageTemplateRow']['background_image'];
						$saveRow['PageTemplateRow']['sort_order'] = $row['PageTemplateRow']['sort_order'];
						$flRow = $this->PageTemplateRow->save($saveRow);
						$rowId = $this->PageTemplateRow->id;
						if($flRow){
							if(!empty($row['PageTemplateRowsColumn'])){
								$saveCol = array();
								foreach($row['PageTemplateRowsColumn'] as $column){
									$saveCol['PageTemplateRowsColumn']= $column;
									if($column['clone_flag']=='Y'){
										$saveCol['PageTemplateRowsColumn']['shortcode'] = $this->cloneWidget($column['shortcode']);
									}
									
									$saveCol['PageTemplateRowsColumn']['row_id'] = $rowId;
									unset($saveCol['PageTemplateRowsColumn']['id']);
									
									$this->PageTemplateRowsColumn->create();
									$this->PageTemplateRowsColumn->save($saveCol);
									$parent_colid = $this->PageTemplateRowsColumn->id;
									
									$childColArr = $this->PageTemplateRowsColumn->find('all', array(
											'conditions'=>array('PageTemplateRowsColumn.parent_colid'=>$column['id'])
										)
									);
									
									if(!empty($childColArr)){
										foreach($childColArr as $childCol){
											//$childsaveCol= $childCol;
											$childCol['PageTemplateRowsColumn']['row_id'] = $rowId;
											if($childCol['PageTemplateRowsColumn']['clone_flag']=='Y'){
												$childCol['PageTemplateRowsColumn']['shortcode'] = $this->cloneWidget($childCol['PageTemplateRowsColumn']['shortcode']);
											}
											$childCol['PageTemplateRowsColumn']['parent_colid'] = $parent_colid;
											unset($childCol['PageTemplateRowsColumn']['id']);
											
											$this->PageTemplateRowsColumn->create();
											$this->PageTemplateRowsColumn->save($childCol);
										}
									}
								}
								
							}
						}
					}
				}
			}
			
			if($saveFlag){				
				return $newtplId;
			} else {
				return 0;
			}
		}
	}
	
		public function addcustomtemplate1($data){
		if(!empty($data)){
			$this->PageTemplate->create();
			$userArr = AuthComponent::user();
			
			$data['PageTemplate']['created_by'] = $userArr['user_id'];
			//$data['PageTemplate']['template_type'] = ($userArr['user_type']=="super")?"PRE":"CUSTOM";
			$data['PageTemplate']['template_type'] = "CUSTOM";
			$data['PageTemplate']['Status'] = "Y";
			$data['PageTemplate']['is_clone'] =0; 
			$ThemeSetting=$this->Session->read('ThemeSetting');
			$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
			if($ThemeSettingheadertype=='H')
			{
				$data['PageTemplate']['template_use'] = "HN";
			}
			if($ThemeSettingheadertype=='V')
			{
				$data['PageTemplate']['template_use'] = "VN";
			}
			//pr($data);
			//die;
			$saveFlag = $this->PageTemplate->save($data);
			$newtplId = $this->PageTemplate->id;
			
			if(!empty($data['PageTemplate']['template_id'])){
				$this->PageTemplateRow->bindModel(
					array(
						'hasMany'=>array(
							'PageTemplateRowsColumn'=>array(
								'className'    => 'PageTemplateRowsColumn',
								'foreignKey'   => 'row_id',
								'conditions'	=> array('PageTemplateRowsColumn.parent_colid'=>0)
							)
						)
					)
				);
				
				$tplrwclArr = $this->PageTemplateRow->find('all', array(
									'conditions'=>array(
										'template_id'=>$data['PageTemplate']['template_id']
									)
								)
							);
				
				//return $tplrwclArr;
				if(!empty($tplrwclArr)){
					foreach($tplrwclArr as $row){
						$this->PageTemplateRow->create();
						$saveRow['PageTemplateRow']['template_id'] = $newtplId;
						$saveRow['PageTemplateRow']['rowstyle'] = $row['PageTemplateRow']['rowstyle'];
						$saveRow['PageTemplateRow']['rowwithForeground'] = $row['PageTemplateRow']['rowwithForeground'];
						$flRow = $this->PageTemplateRow->save($saveRow);
						$rowId = $this->PageTemplateRow->id;
						if($flRow){
							if(!empty($row['PageTemplateRowsColumn'])){
								$saveCol = array();
								foreach($row['PageTemplateRowsColumn'] as $column){
									$saveCol['PageTemplateRowsColumn']= $column;
									if($column['clone_flag']=='Y'){
										$saveCol['PageTemplateRowsColumn']['shortcode'] = $this->cloneWidget($column['shortcode']);
									}
									
									$saveCol['PageTemplateRowsColumn']['row_id'] = $rowId;
									unset($saveCol['PageTemplateRowsColumn']['id']);
									
									$this->PageTemplateRowsColumn->create();
									$this->PageTemplateRowsColumn->save($saveCol);
									$parent_colid = $this->PageTemplateRowsColumn->id;
									
									$childColArr = $this->PageTemplateRowsColumn->find('all', array(
											'conditions'=>array('PageTemplateRowsColumn.parent_colid'=>$column['id'])
										)
									);
									
									if(!empty($childColArr)){
										foreach($childColArr as $childCol){
											//$childsaveCol= $childCol;
											$childCol['PageTemplateRowsColumn']['row_id'] = $rowId;
											if($childCol['PageTemplateRowsColumn']['clone_flag']=='Y'){
												$childCol['PageTemplateRowsColumn']['shortcode'] = $this->cloneWidget($childCol['PageTemplateRowsColumn']['shortcode']);
											}
											$childCol['PageTemplateRowsColumn']['parent_colid'] = $parent_colid;
											unset($childCol['PageTemplateRowsColumn']['id']);
											
											$this->PageTemplateRowsColumn->create();
											$this->PageTemplateRowsColumn->save($childCol);
										}
									}
								}
								
							}
						}
					}
				}
			}
			
			if($saveFlag){
				return $newtplId;
			} else {
				return 0;
			}
		}
	}
	
	public function cloneWidget($shortcode){
		
		if(!empty($shortcode)){
			$code = trim($shortcode, '[');
			$code = trim($code, ']');
			
			$excludeWidgetArr = array('Divider');
			
			$widget = explode('-', $code);
			if(count($widget)==2){
				if(!in_array($widget[0], $excludeWidgetArr)){
					$codeArr = $this->Shortcode->findByNameAndWidgetId($widget[0],$widget[1]);
					
					if(!empty($codeArr)){
						App::import('Controller', $codeArr['Shortcode']['controller']);
						$controller = $codeArr['Shortcode']['controller']."Controller";
						$obj = new $controller;
						$newshortcode = $obj->admin_copyitem($codeArr['Shortcode']['widget_id']);
						return $newshortcode;
					}
				}
			} else {
				return $shortcode;
			}
			
		} else {
			return $shortcode;
		}
		return $shortcode;
	}
	
	
	public function admin_ajaxtplpreview(){
		$this->layout = 'ajax';
		//pr($this->request);die();
		
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			$def=$reqdata['def'];
			$this->PageTemplateRow->bindModel(array(
									'hasMany' => array(
										'PageTemplateRowsColumn' => array(
												'className'    => 'PageTemplateRowsColumn',
												'foreignKey'   => 'row_id',
												'conditions'   => array('PageTemplateRowsColumn.parent_colid'=>0),
												'order'			=> array('PageTemplateRowsColumn.sort_order ASC')
											),
									)
								));
			
			$tplrwclArr = $this->PageTemplateRow->find('all', array(
								'conditions'=>array(
									'template_id'=>$reqdata['id']
								),
								'order'=>array('PageTemplateRow.sort_order ASC')
							)
						);
			$tplData = $this->PageTemplate->findById($reqdata['id']);
			
			$pageTemplate = $this->PageTemplate->findById($reqdata['id']);
			/* $tplrwclArr 	= $this->PageTemplateRow->find($reqdata['id']);
			$data 			= $this->PageTemplate->findById($reqdata['id']);*/
			$id				= $reqdata['id']; 
			$this->set(compact('tplrwclArr', 'pageTemplate', 'id', 'tplData','def'));
			
		}
	}
	
	public function admin_pgtpldrpdown(){
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$data = $this->request->data;
			/* $tplList = $this->PageTemplate->find('list', array(
				'conditions'=>array('template_for'=>$data['tplFor']),
				'fields'=>array('id', 'template_name')
			)); */
			$userArr = AuthComponent::user();
		
			if($userArr['user_type'] == 'super'){
				$ThemeSetting=$this->Session->read('ThemeSetting');
				$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
				if($ThemeSettingheadertype=='H')
				{
						$tplList = $this->PageTemplate->find('list', array(
						'conditions'=>array(
							'template_for'=>$data['tplFor'],
							'template_use'=>'HN'
						),
						'fields'=>array('id', 'template_name')
					));
					$tplList['custom'] = 'Add New';
				}
				if($ThemeSettingheadertype=='V')
				{
						$tplList = $this->PageTemplate->find('list', array(
						'conditions'=>array(
							'template_for'=>$data['tplFor'],
							'template_use'=>'VN'
						),
						'fields'=>array('id', 'template_name')
					));
					$tplList['custom'] = 'Add New';
				}
				
			} else {
				$this->loadModel('User');
				$tplsuperUser = $this->User->findByUserType('super');
				
				if(!empty($tplsuperUser)){
					$tplList = $this->PageTemplate->find('list', array(
							'conditions'=>array(
								'template_for'=>$data['tplFor'],
								'created_by'=>$tplsuperUser['User']['user_id'],
								'show_flag'=>'Y'
							),
							'fields'=>array('id', 'template_name')
						));
				} else {
					$tplList = array();
				}
			}
			$this->set(compact('tplList', 'data'));
		}
	}
	
	public function admin_fpdelrow(){
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			$tpldata = $this->PageTemplate->findById($reqdata['tplId']);
			if(!empty($tpldata)){
				if($tpldata['PageTemplate']['template_type']=="PRE"){
					echo 1; exit();
				} else {
					$fl = $this->PageTemplateRow->delete($reqdata['rowId']);
					$flAll = $this->PageTemplateRowsColumn->deleteAll(array('PageTemplateRowsColumn.row_id'=>$reqdata['rowId']));
					
					echo ($fl && $flAll)?2:0; exit();
				}
			}
			
		}
	}
	
	public function admin_fpcoldelete(){
		$this->layout = "ajax";
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			$tpldata = $this->PageTemplate->findById($reqdata['tplId']);
			if(!empty($tpldata)){
				if($tpldata['PageTemplate']['template_type']=="PRE"){
					echo 1; exit();
				} else {
					$flAll = $this->PageTemplateRowsColumn->delete($reqdata['colId']);
					
					echo ($flAll)?2:0; exit();
				}
			}
			
		}
	}
	
	public function admin_ajaxdynamicimage()
	{
		$this->layout = "ajax";
		//$this->loadModel('Widgetgroup');
		$this->loadModel('style');
		if($this->request->is('post'))
		{
			$reqdata = $this->request->data;
			
			
			$this->Shortcode->bindModel(
				array(
					'belongsTo' => array(
						'Style' => array(
								'className'    => 'Style',
								'foreignKey'   => 'style_id'
								
							)
					)
				)
			);
			
			$shortcodeArr = $this->Shortcode->find('all', array(
					'conditions'=>array('Shortcode.group_id'=>$reqdata['val'])
				)
			);
			//pr($shortcodeArr); exit();
			$this->set('shortcodeArr', $shortcodeArr); 
			
		}
	}
	
	public function admin_delete($id=NULL){	
		$this->layout = '';
		$this->autoRender = false;
		
		$data['Page']['is_del'] = 1;
		$this->Page->id = $id;
		$deleteFlag = $this->Page->save($data);
		if($deleteFlag){
			$this->Session->setFlash('Page deleted successfully.', 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('Failed to deleted the page', 'default', array('class' => 'alert alert-danger'));
		}
		$this->redirect($this->referer());	
	}
	
	public function admin_deleteAll($idAll=NULL)
	{	
		//pr($id); exit();
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data['Page']['is_del'] = 1;
			$this->Page->id = $id;
			$deleteFlag = $this->Page->save($data);
			
			if($deleteFlag){
				$this->Session->setFlash('The page has been successfully removed!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to remove the page!', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}		public function admin_restore ($id=NULL, $isdel='1')	{		$this->layout = '';		$this->autoRender = false;		$data['Page']['is_del'] = $isdel; 		$this->Page->id = $id;		$this->Page->save($data);		$this->Session->setFlash('<p>Page details has been restore successfully!</p>', 'default', array('class' => 'alert alert-success'));		$this->redirect($this->referer());	}	public function admin_restoreAll($idAll=NULL, $isdel='0')	{		$idArr = explode(',',$idAll);		$this->layout = '';		$this->autoRender = false;				foreach($idArr as $id){			$data = $this->Page->findById($id);			$data['Page']['is_del'] = $isdel; 			$this->Page->id = $id;			$restoreFlag = $this->Page->save($data);						if($restoreFlag){				$this->Session->setFlash('Pages Restore Successfully!', 'default', array('class' => 'alert alert-success'));			} else {				$this->Session->setFlash('Failed to Restore Pages!', 'default', array('class' => 'alert alert-danger'));				break;			}		}		$this->redirect($this->referer());		}				
	
	/****** Front End Functions *********/
	
	public function display($slug,$Parentpagename)
	{
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
		$Parentpagename=$Parentpagename;
		
		$data = $this->Page->findBySlugAndIsActiveAndIsDel($slug,'Y',0);
	
		$this->loadModel('Testimonial');
		$testimonial = $this->Testimonial->find('all', array(
			'conditions' => array('Testimonial.status' => 'Y', 'Testimonial.isdel' => '0')
		));
			
		$this->loadModel('CmsGallery');
		$this->CmsGallery->bindModel(array(
			'hasMany' => array(
					'CmsBanner' => array(
						'className'    => 'CmsBanner',
						'foreignKey'   => 'gallery_id'
					)
				)
			)
		); 
		
		if(!empty($data)){
			if(!empty($data['Page']['cms_gallery_id'])){
				$cmsGallery = $this->CmsGallery->findById($data['Page']['cms_gallery_id']);
			} else {
				$cmsGallery = array();
			}
		} else {
			$cmsGallery = array();
		}
		
		$this->set(compact('data','testimonial','cmsGallery','Parentpagename'));
		$this->set('Parentpagename',$Parentpagename);
	}
    
	

	
	
	public function contactus()
	{
	   $errmsg=array();
	    
		//print_r($errmsg);
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
		$this->loadModel('SiteSetting');
		$data1 = $this->SiteSetting->find('first');
		$data = $this->Page->findBySlugAndIsActiveAndIsDel('contact-us','Y',0);
		$data2 = $this->Page->findBySlugAndIsActiveAndIsDel('about-us','Y',0);
		$this->set(compact('data1', 'data','data2','errmsg'));
	}
	
	public function faqs()
	{
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
		
		$this->loadModel('Faq');
		$this->loadModel('FaqCategory');
		
		$this->FaqCategory->bindModel(array(
										'hasMany' => array(
											'Faq' => array(
												'className' => 'Faq',
												'foreignKey' => 'category_id'
												)
											)
										)
									);
		
		$faqCategory = $this->FaqCategory->find('all', array('conditions' => array('FaqCategory.isdel'=>0,
																					'FaqCategory.status'=>'Y'
																					)
																				)
																			);
		//pr($faqCategory);													
													
		$this->set(compact('faqCategory','faq'));
	}
	
	public function login_page()
	{
		$this->theme = 'Metronic';
		$this->layout = 'inner';
		
	
	}
	public function register()
	{
		$this->theme = 'Metronic';
		$this->layout = 'inner';
		
	
	}
	
	public function success()
	{
		$this->theme = THEME_NAME;
		$this->layout = 'ecommerce_inner';
	}
	
	public function error()
	{
		$this->theme = THEME_NAME;
		$this->layout = 'ecommerce_inner';
	}
	
	public function get_captcha()
	{
		$this->autoRender = false;
		App::import('Component','Captcha');
			
		//generate random charcters for captcha
		$random = mt_rand(100, 99999);	
				
		//save characters in session
		$this->Session->write('captcha_code', $random);  
			
		$settings = array(
		  'characters' => $random,   
		  'winHeight' => 35,         // captcha image height 
		  'winWidth' => 220,		   // captcha image width
		  'fontSize' => 25,          // captcha image characters fontsize 
		  'fontPath' => WWW_ROOT. DS .'monofont.ttf',    // captcha image font
		  'noiseColor' => '#ccc',
		  'bgColor' => '#fff',
		  'noiseLevel' => '100',
		  'textColor' => '#000'
		);
			
		$img = $this->Captcha->ShowImage($settings);
		echo $img; 
	}
	
	public function ajaxContact(){
		$this->layout = 'ajax';
		
		$this->loadModel('SiteSetting');
		$siteSetting = $this->SiteSetting->find('first');
		if($this->request->is("post")){
			$data = $this->request->data;
			$recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.SECRET_KEY.'&response='.$data['g-recaptcha-response']);
			$response = json_decode($recaptcha);
			
			if($response->success){ // $response->success
				$this->loadModel('EmailTemplate');
		
				$Email = new CakeEmail();
				$body = $this->EmailTemplate->findByTemplateName('Contact ');
				$var = array('[Name]'=>$data['Page']['name'],'[Email]'=>$data['Page']['email'],'[Message]'=>$data['Page']['comment']);
				
				$Email->viewVars(array(
					'base_url' => SITE_URL,
					'subject' => $body['EmailTemplate']['email_subject'],
					'contact_person' => $data['Page']['name'],
					'body_text' => $body['EmailTemplate']['email_body'],
					'body_varArr'=>$var
				));
				
				$flag = $Email->template('template', 'base_layout')
					->emailFormat('html')
					->from(array($siteSetting['SiteSetting']['admin_email'] => $siteSetting['SiteSetting']['meta_title']))
					
					->to($siteSetting['SiteSetting']['admin_email'])
					->subject($body['EmailTemplate']['email_subject'])
					->send();
				if($flag){
					echo 4; exit();
				} else {
					echo 3; exit();
				}
			} else {	
				echo 2;
				exit();
			}
		} else {
			echo 1;
			exit();
		}
	}
	
	public function ajaxContactinfo(){
		$this->layout = 'ajax';
		//$data = $this->request->data;
		//echo $data['name']; exit;
		
		$this->loadModel('SiteSetting');
		$siteSetting = $this->SiteSetting->find('first');
		if($this->request->is("post")){
			$data = $this->request->data;
			
				$this->loadModel('EmailTemplate');
				$Email = new CakeEmail();
				/* $body = $this->EmailTemplate->findByTemplateName('Contact ');
				$var = array('[Name]'=>$data['name'],'[Email]'=>$data['email'], '[Website]'=>$data['website'], '[Message]'=>$data['message']); */
				
				if(!empty($data['website'])){
				$var = array('[Name]'=>$data['name'],'[Email]'=>$data['email'], '[Website]'=>$data['website'], '[Message]'=>$data['message']);
				 $body = $this->EmailTemplate->findByTemplateName('Contact ');
				}else {
				$var = array('[Name]'=>$data['name'],'[Email]'=>$data['email'], '[Message]'=>$data['message']);
				$body = $this->EmailTemplate->findByTemplateName('Contact no web field ');
				
				}
				
			
				
				$Email->viewVars(array(
					'base_url' => SITE_URL,
					'subject' => $body['EmailTemplate']['email_subject'],
					'contact_person' => $data['name'],
					'body_text' => $body['EmailTemplate']['email_body'],
					'body_varArr'=>$var
				));
				
				$flag = $Email->template('template', 'base_layout')
					->emailFormat('html')
					->from(array($siteSetting['SiteSetting']['admin_email'] => $siteSetting['SiteSetting']['meta_title']))
					
					->to($siteSetting['SiteSetting']['admin_email'])
					
					->subject($body['EmailTemplate']['email_subject'])
					->send();
				if($flag){
					echo 4; exit();
				} else {
					echo 3; exit();
				}
			
		} else {
			echo 1;
			exit();
		} 
	}
	
	
	public function ajaxContactinfo1(){
		$this->layout = 'ajax';
		//$data = $this->request->data;
		//echo $data['name']; exit;
		
		$this->loadModel('SiteSetting');
		$siteSetting = $this->SiteSetting->find('first');
		if($this->request->is("post")){
			$data = $this->request->data;
			
				$this->loadModel('EmailTemplate');
				$Email = new CakeEmail();
				
				if(!empty($data['phone'])){
				$var = array('[Name]'=>$data['name'],'[Email]'=>$data['email'], '[Website]'=>$data['phone'], '[Message]'=>$data['message']);
				 $body = $this->EmailTemplate->findByTemplateName('Contact ');
				}else {
				$var = array('[Name]'=>$data['name'],'[Email]'=>$data['email'], '[Message]'=>$data['message']);
				$body = $this->EmailTemplate->findByTemplateName('Contact no web field ');
				
				}
				
			
				
				$Email->viewVars(array(
					'base_url' => SITE_URL,
					'subject' => $body['EmailTemplate']['email_subject'],
					'contact_person' => $data['name'],
					'body_text' => $body['EmailTemplate']['email_body'],
					'body_varArr'=>$var
				));
				
				$flag = $Email->template('template', 'base_layout')
					->emailFormat('html')
					->from(array($siteSetting['SiteSetting']['admin_email'] => $siteSetting['SiteSetting']['meta_title']))
					
					->to($siteSetting['SiteSetting']['admin_email'])
					//->cc('money@smallbizloans.com.au')
					->subject($body['EmailTemplate']['email_subject'])
					->send();
				if($flag){
					echo 4; exit();
				} else {
					echo 3; exit();
				}
			
		} else {
			echo 1;
			exit();
		} 
	}
	
	public function form_search()
	{
		$this->layout = 'inner';
		$this->theme = THEME_NAME;
		$data = $this->request->data; 
		//pr($data); exit;
		$this->loadModel('PostComment');
			$this->Page->bindModel(array(
				'hasMany'=>array(
					'PostComment' => array(
						'className'    => 'PostComment',
						'foreignKey'   => 'post_id',
						'conditions'   => array(
							'PostComment.status'=> 'Y'
						)
					)
				)	
		));
		if($data !== ''){
		$blog = $this->Page->find('all', array('conditions'=>array(
														'OR' => array(
															array('Page.slug LIKE' => '%'.$data['Page']['input'].'%'),
															array('Page.title LIKE' => '%'.$data['Page']['input'].'%'),
															array('Page.metatitle LIKE' =>'%'.$data['Page']['input'].'%'),
															array('Page.metakeywords LIKE' => '%'.$data['Page']['input'].'%')
														),
														'AND' => array(
															array('Page.is_del'=>0),
															array('Page.is_active'=>'Y')
															//array('Page.title'=>'ASC')
															)
													)
												));
					$this->set('blog', $blog);
				}
				else
				{
					$blog = '';
					$this->set('blog', $blog);
				}
	}
	
	
	public function home(){
		$this->theme = THEME_NAME;
		$this->layout = 'home';
		$this->loadModel('HomepageWidget');
		$this->loadModel('Page');
		$this->loadModel('Banner');
		$this->loadModel('SiteSetting');
		
		$this->loadModel('GalleryManagement');
		
		$data = $this->Page->findBySlugAndIsActiveAndIsDel('home','Y',0);
		
		$homebannerArray = $this->Banner->find('all',array('conditions'=>array('banner_status'=>'Y','is_del'=>'0')));
		
		/* $ourClients = $this->GalleryManagement->findByName('Our Clients');
		
		
			
			
		$test = ClassRegistry::init('Testimonial');
		$testimonial = $test->find('all', array('conditions' => array('Testimonial.status' => 'Y', 'Testimonial.isdel' => '0'),
													//'fields' => 'Testimonial.id','Testimonial.title','Testimonial.heading','Testimonial.testimonial_image','Testimonial.testimonial'
													)); */
		
		
		
	
		$this->set(compact('homebannerArray','data'));
		
	}
	
	public function widget($id=NULL){
		
		$this->theme = 'Nulife';
		$this->layout = 'inner';
		$this->loadModel('HomepageWidget');
		$widgetDetails = $this->HomepageWidget->find('first',array('conditions'=>array('status'=>'Y','is_del'=>'0','id'=>$id)));
		$this->set(compact('widgetDetails'));
		
	}
	
	public function page_search(){
		
		if($this->request->is('post')){
			$this->theme = 'Nulife';
			$this->layout = 'inner';
			if(!empty($this->request->data['search_text'])){
			$searchResult = $this->Page->find('all',array(
											  'fields'=>array('id','title','content','slug','type'),
											  'conditions'=>array('OR'=>array('title LIKE'=>'%'.$this->request->data['search_text'].'%','content LIKE'=>'%'.$this->request->data['search_text'].'%')))); 
											  
			}else{
				$searchResult = '';
				
			}									  
		$this->set(compact('searchResult'));
		}
		
	}
	
	public function add_layout($data_id=NULL,$data_layout=NULL)
	{
		$this->layout		=	'';
		$this->autoRender	=	false;
		$this->loadModel('Section');
		
	}
	
	public function ecommerce()
	{
		$this->theme = 'Metronic';
		$this->layout = 'inner';
		$this->loadModel('Product');
		$this->loadModel('ProductGallery');
		$this->Product->bindModel(
				array(
					'hasMany' => array(
						'ProductGallery' => array(
								'className'    => 'ProductGallery',
								'foreignKey'   => 'product_id'
								
							)
					)
				)
			);
		$image=$this->Product->find('all',array(
			'order' => array('Product.id' => 'desc')
		));	
	   //pr( $image);
       $this->set('image', $image); 
	}
	
	public function admin_template()
	{
		$this->set('template',$this->request->data('template'));
	}
	
	public function admin_version()
	{
		$this->autoRender=false;
		$this->loadModel('PageVersion');
		$data = $this->PageVersion->findByPageIdAndDate($this->request->data('id'),$this->request->data('version'));
		echo $data['PageVersion']['content'];
	}
	
	public function admin_new1()
	{
		$this->layout = "ajax";
		
		$this->loadModel('Widgetgroup');
		$widgetgroup_dropdown = $this->Widgetgroup->find('list', array(
				'order'=>array('Widgetgroup.name ASC', 'Widgetgroup.id ASC'),
				'fields'=>array('Widgetgroup.id', 'Widgetgroup.name'),
				'conditions'=>array('Widgetgroup.is_active'=>'Y')
			)
		);
		//pr($shortcodeArr); exit;
		$this->set(compact('widgetgroup_dropdown'));
		
	}
	public function search($searchvalue)
	{
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
		$data1 = $this->Page->find('all',array(
									'conditions'=>array('Page.title LIKE'=>'%'.$searchvalue.'%','Page.is_del'=>'0','Page.is_active'=>'Y')
		));
		$this->set('data1',$data1);
		$this->set('searchvalue',$searchvalue);
	}

public function sitemap()
	{
	
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
		$sitemap=$this->Page->find('all',array('conditions'=>array('Page.is_del'=>0,
														'Page.is_active'=>'Y'),
									'order'=>array('Page.created_date ASC')					
														));
		$counsitemap=count($sitemap);
		$this->set('counsitemap',$counsitemap);
		$this->set('sitemap',$sitemap);
	}

}