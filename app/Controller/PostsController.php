<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class PostsController extends AppController 
{
	public $name = 'Posts';
	public $components = array('Captcha');
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('PostCategory','Page','PostComment','PostTag','PostAssignTag','Slug', 'ThemeSetting');
	public $paginate = array();

	public function beforeFilter() 
	{
		parent::beforeFilter();
		
		$this->Auth->allow('single','blogclassicfw','blogclassicsr','blogclassicsl','blogthumbfw','blogthumbsr','blogthumbsl','bloggrid4c', 'bloggrid3c','bloggrid2c','bloggridsr','bloggridsl','timeline', 'timelinesr', 'timelinesl','ajaxpostlist','ajaxpostlist4c','ajaxpostlist2c','ajaxbloggidsr','ajaxbloggidsl');
		
		if(isset($this->request->params['users'])){
			$this->Security->requireSecure();			
		}
		$this->Security->blackHoleCallback = 'blackhole';
	}
    
	public function blackhole($type) {
	
		// handle errors.
	}	
	
	public function index()
	{
		$this->theme = 'Nulife';
		$this->layout = 'inner';
	}
	
	public function admin_index()
	{
		$this->layout = 'adminInner';
		
		if($this->request->is("post"))
		{
			$this->loadModel('Page');
			$data = $this->request->data;
			
			$likekeyArr = array('title');
			$datekeyArr = array('created_date', 'updated_date');
			$conditionArr = array('Page.type'=>'Post');
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
			
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Page.id' => 'DESC')
			);
			$this->set('searchData',$data); 
			
		} else {
		$this->loadModel('Page');
		$this->paginate=array(
					
					'conditions'=>array('Page.is_del'=>0,'Page.type'=>'Post'),
					'order'=>array('Page.id' => 'DESC')
					);
			
		}
		
		$this->Page->bindModel(array(
				'belongsTo'=>array(
					'PostCategory'=>array(
						'className'    => 'PostCategory',
						'foreignKey'   => 'categoryid',
						'fields'		=> array('category_name')
					)
				)
			)
		);
		$data=$this->paginate('Page'); //pr($data); exit();
		$this->set('data', $data);
		//pr($data);exit;
	}
	
	public function admin_manage($id=NULL){	
		$this->layout = 'adminInner';
		
		/**** Saving Data ****/
		if($this->request->is('post')){	
			if($this->Page->validates()){
				$reqdata = $this->request->data;
				//pr($reqdata); exit();
				if(array_key_exists('cms_image',$reqdata['Page']))
				{
					if($reqdata['Page']['cms_image']['name']!=""){
						list($file1,$error1,$update_field1) = AppController::upload($reqdata['Page']['cms_image'],WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'cms_image'. DS . 'original' . DS ,'jpg,jpeg,JPG,JPEG,gif,GIF,png,PNG');
						
						if($error1 == ""){
						$image	=	new SimpleImage();
						
						$image->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'cms_image'. DS . 'original' . DS .$file1); 
						$image_size=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'cms_image'. DS . 'original' . DS .$file1,1000,300); 
						$image->resize($image_size['0'],$image_size['1']); 
						$image->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'cms_image'. DS . 'resize' . DS .$file1); 
						
						$thumb	=	new SimpleImage();
						
						$thumb->load(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'cms_image'. DS . 'original' . DS .$file1); 
						$image_size=AppController::resize_to_save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'cms_image'. DS . 'original' . DS .$file1,160,145); 
						$thumb->resize($image_size['0'],$image_size['1']); 
						$thumb->save(WWW_ROOT . DS . 'img'. DS .'uploads'. DS . 'cms_image'. DS . 'thumb' . DS .$file1); 
						
						$reqdata['Page']['cms_image'] = $file1;
						}
						else
						{
							$reqdata['Page']['cms_image'] = "";
						}
					} else {
						$reqdata['Page']['cms_image'] = "";
					}
				} else if ($reqdata['Page']['set_cms_image']!="")
				{
					$reqdata['Page']['cms_image'] = $reqdata['Page']['set_cms_image'];
				} else {
					$reqdata['Page']['cms_image'] = '';
				}
				
				if($id != ''){					
					$slugArr = array('controller_name'=>'Posts','action_name'=>'single','mode'=>'edit','pre_slug_name'=>$reqdata['Page']['set_slug']);
					$reqdata['Page']['slug']=($reqdata['Page']['slug'] == $reqdata['Page']['set_slug'])?$reqdata['Page']['slug']:AppController::get_slug($reqdata['Page']['slug'],$slugArr);
					$reqdata['Page']['page_url']=SITE_URL.$reqdata['Page']['slug'];
					$reqdata['Page']['updated_date'] = date("Y-m-d"); 
					$this->Page->id = $id;
				} else {
					$slugArr = array('controller_name'=>'Posts','action_name'=>'single');
					$reqdata['Page']['slug']=AppController::get_slug($reqdata['Page']['title'],$slugArr);
					$reqdata['Page']['page_url']=SITE_URL.'posts/'.$reqdata['Page']['slug'];
					$reqdata['Page']['created_date'] = date("Y-m-d");
					
					$reqdata['Page']['controllername']= 'Posts';
					$reqdata['Page']['actionname']= 'single';
					
					$this->Page->create();
				}
				
				$reqdata['Page']['type'] = 'Post';
				$reqdata['Page']['is_del'] = 0;
				
				$saveFlag = $this->Page->save($reqdata);
				$saveid = $this->Page->id;
				
				if($reqdata['Page']['tagid'] != $reqdata['Page']['set_tagid']){
					$str = $reqdata['Page']['tagid'];
					$tagsArr = explode(",",$str);
					
					$delFlag = $this->PostAssignTag->deleteAll(array('PostAssignTag.post_id'=>$saveid));
					
					if($delFlag){
						
						$saveAssignTag['PostAssignTag']['post_id'] = $saveid;
						foreach($tagsArr as $tag){
							if(is_numeric($tag)){
								$saveAssignTag['PostAssignTag']['tag_id'] = $tag;
							} else {
								$this->PostTag->create();
								$saveTag['PostTag']['tag_name'] = $tag;
								$saveTag['PostTag']['status'] = 'Y';
								$saveTag['PostTag']['isdel'] = '0';
								
								$newslugArr = array('controller_name'=>'Pages','action_name'=>'post_tags');
								$saveTag['PostTag']['slug'] = AppController::get_slug($tag,$newslugArr);
								
								$saveTagFl = $this->PostTag->save($saveTag);
								$saveAssignTag['PostAssignTag']['tag_id'] = $this->PostTag->id;
							}
							$this->PostAssignTag->create();
							$saveAssignFl = $this->PostAssignTag->save($saveAssignTag);
						}
					}
					
				}
				
				if($saveFlag){
					if($id != ''){
						$this->Session->setFlash('Post updated successfully.', 'default', array('class' => 'alert alert-success'));
					} else{
						$this->Session->setFlash('Post added successfully', 'default', array('class' => 'alert alert-success'));
					}
				} else {
					$this->Session->setFlash('Failed to save the Post', 'default', array('class' => 'alert alert-danger'));
				}
				if(array_key_exists('continue', $reqdata)){
					$this->redirect(array('controller'=>'Posts','action'=>'admin_manage/'.$saveid));
				} else {
					$this->redirect(array('controller'=>'Posts','action'=>'admin_index'));
				}
				
				
				//$this->redirect(array('controller'=>'Posts','action'=>'admin_index'));
			} else {
				$this->set('errors', $this->Product->invalidFields());
			}
		}
		
		/**** Saving Data ****/
		
		
		/**** Fetching Data ****/					
		$this->loadModel('PostCategory');
		$pcategory=$this->PostCategory->find('list', array(
										'fields'=>array('PostCategory.id', 'PostCategory.category_name'),
										'conditions'=>array('PostCategory.status'=>'Y') ) );
		
		$this->loadModel('PostTag');
		
		$ptag=$this->PostTag->find('list', array(
										'conditions'=>array('PostTag.isdel'=>'0'),
										'fields'=>array('id','tag_name'),
										) 
									);
		$tagArr = array();
		if(!empty($ptag)){
			$i=0;
			foreach($ptag as $k=>$v){
				$tagArr[$i]['id'] = $k;
				$tagArr[$i]['text'] = $v;
				$i++;
			}
		}
		$tagString = json_encode($tagArr);
		if(trim($id) !== '')
		{
			$this->loadModel('PostAssignTag');
			$tagassignidArr = $this->PostAssignTag->find('list', array(
								'conditions'=>array('PostAssignTag.post_id'=>$id),
								'fields'=>array('PostAssignTag.id','PostAssignTag.tag_id')
								)
							);
							
			$tagAssignIDString = implode(",",$tagassignidArr);
			
			$data = $this->Page->findById($id);
			$this->set(compact('data'));
			
		} else {
			$tagAssignIDString = "";
		}
		$this->set(compact('id','cmsbanner','tagString','pcategory', 'tagAssignIDString'));
		/**** Fetching Data ****/
	}
	

	public function admin_delete($id=NULL)
	{	
		$this->layout = '';
		$this->autoRender = false;
		
		$data = $this->Page->findById($id);
		
		if($data['Page']['cms_image']!=""){
			$original_path=UPLOADS_FOLDER . DS .'cms_image'. DS.'original'. DS .$data['Page']['cms_image'];
			$resize_path=UPLOADS_FOLDER . DS .'cms_image'. DS.'resize'. DS .$data['Page']['cms_image'];
			$thumb_path=UPLOADS_FOLDER . DS .'cms_image'. DS.'thumb'. DS .$data['Page']['cms_image'];
			
			$file_original = new File($original_path, false, 0777);
			$file_original->delete();
			$file_resize = new File($resize_path, false, 0777);
			$file_resize->delete();
			$file_thumb = new File($thumb_path, false, 0777);
			$file_thumb->delete();
		}
		
		$deleteFlag = $this->Page->delete($id);
		
		if($deleteFlag){
			$dltSlugFlag = $this->Slug->deleteAll(array('Slug.slug_name'=>$data['Page']['slug']));
			if($dltSlugFlag){
				$this->Session->setFlash('The post has been successfully removed!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('The post has been successfully removed! But failed to delete the slug.', 'default', array('class' => 'alert alert-danger'));
			}
			
		} else {
			$this->Session->setFlash('The post has been successfully removed!', 'default', array('class' => 'alert alert-danger'));
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
			$data = $this->Page->findById($id);
			
			if($data['Page']['cms_image']!=""){
				$original_path=UPLOADS_FOLDER . DS .'cms_image'. DS.'original'. DS .$data['Page']['cms_image'];
				$resize_path=UPLOADS_FOLDER . DS .'cms_image'. DS.'resize'. DS .$data['Page']['cms_image'];
				$thumb_path=UPLOADS_FOLDER . DS .'cms_image'. DS.'thumb'. DS .$data['Page']['cms_image'];
				$file_original = new File($original_path, false, 0777);
				$file_original->delete();
				$file_resize = new File($resize_path, false, 0777);
				$file_resize->delete();
				$file_thumb = new File($thumb_path, false, 0777);
				$file_thumb->delete();
			}
			
			$deleteFlag = $this->Page->delete($id);
			
			if($deleteFlag){
				$dltSlugFlag = $this->Slug->deleteAll(array('Slug.slug_name'=>$data['Page']['slug']));
				if($dltSlugFlag) {
					$this->Session->setFlash('The post has been successfully removed!', 'default', array('class' => 'alert alert-success'));
				} else {
					$this->Session->setFlash('The post has been successfully removed! But failed to delete the slug.', 'default', array('class' => 'alert alert-danger'));
				}
			} else {
				$this->Session->setFlash('Failed to delete the post!', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	public function admin_imgdelete( ){
		$data=$this->request->params['named'];
		
		if($data['id']){
			$original_path=UPLOADS_FOLDER . DS .'cms_image'. DS.'original'. DS .$data['image_name'];
			$resize_path=UPLOADS_FOLDER . DS .'cms_image'. DS.'resize'. DS .$data['image_name'];
			$thumb_path=UPLOADS_FOLDER . DS .'cms_image'. DS.'thumb'. DS .$data['image_name'];
			
			if(file_exists($original_path)){
				unlink($original_path);
			}
			if(file_exists($resize_path)){
				unlink($resize_path);
			}
			if(file_exists($thumb_path)){
				unlink($thumb_path);
			}
			
			$mydata['Page']['cms_image']="";
			
			$this->Page->id = $data['id'];
			$updateFlag = $this->Page->save($mydata);
			
			if($updateFlag){
				$this->Session->setFlash('<p>Image delete successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('<p>Failed to delete image!</p>', 'default', array('class' => 'alert alert-danger'));
			}
			$this->redirect('/admin/posts/manage/'.$data['id']);
		}
	}
	
	
	
	public function admin_comments($post_id=NULL)
	{
		$this->layout = 'adminInner';
		
		if($post_id == NULL || trim($post_id) == ''){
			$this->Session->setFlash('<p><strong>Error:&nbsp;</strong>An error occurred during the process. Please try again!</p>', 'default', array('class' => 'nNote nFailure hideit'));
			$this->redirect('/admin/posts/index');	
		}
		$this->loadModel('Comment');
		
		$this->paginate = array(
								'conditions' => array('Comment.post_id' => $post_id),
								'order' => array('Comment.created' => 'DESC'),
								'limit' => PAGINATION_PER_PAGE_LIMIT
							);
								
		$data = $this->paginate('Comment'); 
		$this->set(compact('post_id','data'));
	} 
	
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Page']['is_active'] = $stat;
		
		$this->Page->id = $id;
		$updateFlag = $this->Page->save($data);
		
		if($updateFlag){
			$this->Session->setFlash('Page status changed successfully!', 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('Failed to change status!', 'default', array('class' => 'alert alert-danger'));
		}
		$this->redirect($this->referer());
	}
		
	public function delete_comment($post_id=NULL, $id=NULL)
	{	
		$this->layout = '';
		$this->autoRender = false;
		
		ClassRegistry::init('Comment')->delete($id);
		
		$this->Session->setFlash('<p><strong>Success:&nbsp;</strong>The comment has been successfully removed!</p>', 'default', array('class' => 'alert-box success'));
		//$this->redirect($this->referer());
		$this->redirect('/Posts/comments/'.$post_id);
	}
	
	public function single($slug=NULL)
	{
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
		
		$postDetails = $this->Page->findBySlugAndTypeAndIsActive($slug,'Post','Y'); 
		
		$this->loadModel('PostComment');
		$this->PostComment->bindModel(array(
			'hasMany' => array(
					'Reply' => array(
						'className'    => 'Reply',
						'foreignKey'   => 'comment_id',
						'conditions'   => array(
							'Reply.status'=>'Y'
						)
					)
				)
			)
		);
		
		$comments = $this->PostComment->find('all', array(
				'conditions'=>array(
					'PostComment.post_id'=>$postDetails['Page']['id'],
					'PostComment.status'=>'Y'
				)
			)
		);
		
		$siteSetting = $this->Session->read('siteSettings');
		//pr($comments);
		//pr($postDetails); exit();
		$this->set(compact('postDetails','comments', 'siteSetting'));
	}
	
	/*** Blog Template ***/
	
	public function blogclassicfw($type=NULL, $slug=NULL) 
	{
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
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
		// 
		
		if(!empty($type) && !empty($slug)){
			if($type == "category"){
				$category = $this->PostCategory->findBySlug($slug);
				//pr($category); exit();
				if(!empty($category)){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>$category['PostCategory']['id']),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				}
			} else if($type == "tag"){
				$tag = $this->PostTag->findBySlug($slug);
				
				if(!empty($tag)){
					$assignId = $this->PostAssignTag->find('list', array(
						'conditions'=>array(
							'PostAssignTag.tag_id'=>$tag['PostTag']['id']
						),
						'fields'=>array('id','post_id')
					));
					if(!empty($assignId)){
						if(count($assignId)==1){
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>current($assignId)),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
									);
						} else {
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id IN'=>$assignId),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
									);
						}
					} else {
						$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
					}
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				}
				
			} else if($type=='search') {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post','Page.title LIKE'=>'%'.$slug.'%'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
			}
		} else {
			$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
		}
		$posts = $this->paginate('Page');
		
		
		//pr($posts); exit();
		$this->set(compact('posts'));
		$this->set('type',$type);
		$this->set('slug',$slug);
	}
	
	public function blogclassicsr($type=NULL,$slug=NULL) 
	{
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
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
		// 
		
		if(!empty($type) && !empty($slug)){
			if($type == "category"){
				$category = $this->PostCategory->findBySlug($slug);
				//pr($category); exit();
				if(!empty($category)){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>$category['PostCategory']['id']),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				}
			} else if($type == "tag"){
				$tag = $this->PostTag->findBySlug($slug);
				
				if(!empty($tag)){
					$assignId = $this->PostAssignTag->find('list', array(
						'conditions'=>array(
							'PostAssignTag.tag_id'=>$tag['PostTag']['id']
						),
						'fields'=>array('id','post_id')
					));
					if(!empty($assignId)){
						if(count($assignId)==1){
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>current($assignId)),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
									);
						} else {
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id IN'=>$assignId),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
									);
						}
					} else {
						$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
					}
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				}
				
			} else if($type=='search') {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post','Page.title LIKE'=>'%'.$slug.'%'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
			}
		} else {
			$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
		}
		$posts = $this->paginate('Page');
		
		
		//pr($posts); exit();
		$this->set(compact('posts'));
		$this->set('type',$type);
		$this->set('slug',$slug);
	}
	
	public function blogclassicsl($type=NULL,$slug=NULL) 
	{
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
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
		// 
		
		if(!empty($type) && !empty($slug)){
			if($type == "category"){
				$category = $this->PostCategory->findBySlug($slug);
				//pr($category); exit();
				if(!empty($category)){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>$category['PostCategory']['id']),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				}
			} else if($type == "tag"){
				$tag = $this->PostTag->findBySlug($slug);
				
				if(!empty($tag)){
					$assignId = $this->PostAssignTag->find('list', array(
						'conditions'=>array(
							'PostAssignTag.tag_id'=>$tag['PostTag']['id']
						),
						'fields'=>array('id','post_id')
					));
					if(!empty($assignId)){
						if(count($assignId)==1){
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>current($assignId)),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
									);
						} else {
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id IN'=>$assignId),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
									);
						}
					} else {
						$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
					}
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				}
				
			}else if($type=='search'){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post','Page.title LIKE'=>'%'.$slug.'%'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
			}
		} else {
			$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
		}
		$posts = $this->paginate('Page');
		
		
		//pr($posts); exit();
		$this->set(compact('posts'));
		$this->set('type',$type);
		$this->set('slug',$slug);
	}
	
	public function blogthumbfw($type=NULL,$slug=NULL) 
	{
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
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
		// 
		
		if(!empty($type) && !empty($slug)){
			if($type == "category"){
				$category = $this->PostCategory->findBySlug($slug);
				//pr($category); exit();
				if(!empty($category)){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>$category['PostCategory']['id']),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				}
			} else if($type == "tag"){
				$tag = $this->PostTag->findBySlug($slug);
				
				if(!empty($tag)){
					$assignId = $this->PostAssignTag->find('list', array(
						'conditions'=>array(
							'PostAssignTag.tag_id'=>$tag['PostTag']['id']
						),
						'fields'=>array('id','post_id')
					));
					if(!empty($assignId)){
						if(count($assignId)==1){
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>current($assignId)),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
									);
						} else {
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id IN'=>$assignId),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
									);
						}
					} else {
						$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
					}
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				}
				
			}else if($type=='search'){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post','Page.title LIKE'=>'%'.$slug.'%'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
			}
		} else {
			$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
		}
		$posts = $this->paginate('Page');
		
		
		
		$this->set(compact('posts'));
		$this->set('type',$type);
		$this->set('slug',$slug);
	}
	
	public function blogthumbsr($type=NULL,$slug=NULL) 
	{
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
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
		// 
		
		if(!empty($type) && !empty($slug)){
			if($type == "category"){
				$category = $this->PostCategory->findBySlug($slug);
				//pr($category); exit();
				if(!empty($category)){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>$category['PostCategory']['id']),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				}
			} else if($type == "tag"){
				$tag = $this->PostTag->findBySlug($slug);
				
				if(!empty($tag)){
					$assignId = $this->PostAssignTag->find('list', array(
						'conditions'=>array(
							'PostAssignTag.tag_id'=>$tag['PostTag']['id']
						),
						'fields'=>array('id','post_id')
					));
					if(!empty($assignId)){
						if(count($assignId)==1){
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>current($assignId)),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
									);
						} else {
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id IN'=>$assignId),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
									);
						}
					} else {
						$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
					}
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				}
				
			}else if($type=='search'){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post','Page.title LIKE'=>'%'.$slug.'%'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
			}
		} else {
			$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
		}
		$posts = $this->paginate('Page');
		
		
		//pr($posts); exit();
		$this->set(compact('posts'));
		$this->set('type',$type);
		$this->set('slug',$slug);
	}
	
	public function blogthumbsl($type=NULL,$slug=NULL) 
	{
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
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
		// 
		
		if(!empty($type) && !empty($slug)){
			if($type == "category"){
				$category = $this->PostCategory->findBySlug($slug);
				//pr($category); exit();
				if(!empty($category)){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>$category['PostCategory']['id']),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				}
			} else if($type == "tag"){
				$tag = $this->PostTag->findBySlug($slug);
				
				if(!empty($tag)){
					$assignId = $this->PostAssignTag->find('list', array(
						'conditions'=>array(
							'PostAssignTag.tag_id'=>$tag['PostTag']['id']
						),
						'fields'=>array('id','post_id')
					));
					if(!empty($assignId)){
						if(count($assignId)==1){
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>current($assignId)),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
									);
						} else {
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id IN'=>$assignId),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
									);
						}
					} else {
						$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
					}
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				}
				
			}else if($type=='search'){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post','Page.title LIKE'=>'%'.$slug.'%'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
			}
		} else {
			$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
		}
		$posts = $this->paginate('Page');
		
		
		//pr($posts); exit();
		$this->set(compact('posts'));
		$this->set('type',$type);
		$this->set('slug',$slug);
	}
	
	public function bloggrid4c($type=NULL,$slug=NULL) 
	{
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
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
		// 
		if($type=='search'){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post','Page.title LIKE'=>'%'.$slug.'%'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => 5
								);
			}
		else{
		$this->paginate = array(
							'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post'),
							'order'=>array('Page.id' => 'DESC'),
							'limit' => 5
							);
			}
		$posts = $this->paginate('Page');
		$this->set('type',$type);
		$this->set('slug',$slug);
		
		//pr($posts); exit();
		$this->set(compact('posts'));
	}
	
	public function bloggrid3c($type=NULL, $slug=NULL) 
	{
		
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
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
		// 
		$limit=4;
		if(!empty($type) && !empty($slug)){
			if($type == "category"){
				$category = $this->PostCategory->findBySlug($slug);
				//pr($category); exit();
				if(!empty($category)){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>$category['PostCategory']['id']),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
				}
			} else if($type == "tag"){
				$tag = $this->PostTag->findBySlug($slug);
				
				if(!empty($tag)){
					$assignId = $this->PostAssignTag->find('list', array(
						'conditions'=>array(
							'PostAssignTag.tag_id'=>$tag['PostTag']['id']
						),
						'fields'=>array('id','post_id')
					));
					if(!empty($assignId)){
						if(count($assignId)==1){
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>current($assignId)),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => $limit
									);
						} else {
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id IN'=>$assignId),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => $limit
									);
						}
					} else {
						$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
					}
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
				}
				
			}else if($type=='search'){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post','Page.title LIKE'=>'%'.$slug.'%'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
			}
		} else {
			$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
		}
		$posts = $this->paginate('Page');
		$this->set('type',$type);
		$this->set('slug',$slug);
		
		//pr($posts); exit();
		$this->set(compact('posts'));
	}
	
	
	
	
	public function bloggrid2c($type=NULL, $slug=NULL) 
	{
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
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
		// 
		$limit=3;
		if(!empty($type) && !empty($slug)){
			if($type == "category"){
				$category = $this->PostCategory->findBySlug($slug);
				//pr($category); exit();
				if(!empty($category)){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>$category['PostCategory']['id']),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
				}
			} else if($type == "tag"){
				$tag = $this->PostTag->findBySlug($slug);
				
				if(!empty($tag)){
					$assignId = $this->PostAssignTag->find('list', array(
						'conditions'=>array(
							'PostAssignTag.tag_id'=>$tag['PostTag']['id']
						),
						'fields'=>array('id','post_id')
					));
					if(!empty($assignId)){
						if(count($assignId)==1){
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>current($assignId)),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => $limit
									);
						} else {
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id IN'=>$assignId),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => $limit
									);
						}
					} else {
						$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
					}
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
				}
				
			}else if($type=='search'){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post','Page.title LIKE'=>'%'.$slug.'%'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
			}
		} else {
			$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
		}
		$posts = $this->paginate('Page');
		
		$this->set('type',$type);
		$this->set('slug',$slug);
		//pr($posts); exit();
		$this->set(compact('posts'));
	}
	
	
	
	public function bloggridsr($type=NULL, $slug=NULL) 
	{
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
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
		// 
		$limit=4;
		if(!empty($type) && !empty($slug)){
			if($type == "category"){
				$category = $this->PostCategory->findBySlug($slug);
				//pr($category); exit();
				if(!empty($category)){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>$category['PostCategory']['id']),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
				}
			} else if($type == "tag"){
				$tag = $this->PostTag->findBySlug($slug);
				
				if(!empty($tag)){
					$assignId = $this->PostAssignTag->find('list', array(
						'conditions'=>array(
							'PostAssignTag.tag_id'=>$tag['PostTag']['id']
						),
						'fields'=>array('id','post_id')
					));
					if(!empty($assignId)){
						if(count($assignId)==1){
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>current($assignId)),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => $limit
									);
						} else {
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id IN'=>$assignId),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => $limit
									);
						}
					} else {
						$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
					}
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
				}
				
			}else if($type=='search'){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post','Page.title LIKE'=>'%'.$slug.'%'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
			}
		} else {
			$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
		}
		$posts = $this->paginate('Page');
		
		$this->set('type',$type);
		$this->set('slug',$slug);
		//pr($posts); exit();
		$this->set(compact('posts'));
	}
	
	
	public function bloggridsl($type=NULL, $slug=NULL) 
	{
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
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
		// 
		$limit=4;
		if(!empty($type) && !empty($slug)){
			if($type == "category"){
				$category = $this->PostCategory->findBySlug($slug);
				//pr($category); exit();
				if(!empty($category)){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>$category['PostCategory']['id']),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
				}
			} else if($type == "tag"){
				$tag = $this->PostTag->findBySlug($slug);
				
				if(!empty($tag)){
					$assignId = $this->PostAssignTag->find('list', array(
						'conditions'=>array(
							'PostAssignTag.tag_id'=>$tag['PostTag']['id']
						),
						'fields'=>array('id','post_id')
					));
					if(!empty($assignId)){
						if(count($assignId)==1){
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>current($assignId)),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => $limit
									);
						} else {
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id IN'=>$assignId),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => $limit
									);
						}
					} else {
						$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
					}
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
				}
				
			} else if($type=='search'){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post','Page.title LIKE'=>'%'.$slug.'%'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
			}
		} else {
			$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => $limit
								);
		}
		$posts = $this->paginate('Page');
		
		//pr($posts); exit();
		$this->set(compact('posts'));
		$this->set('type',$type);
		$this->set('slug',$slug);
	}
	
	
	public function timeline($type=NULL, $slug=NULL) 
	{
		
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
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
		// 
		
		if(!empty($type) && !empty($slug)){
			if($type == "category"){
				$category = $this->PostCategory->findBySlug($slug);
				//pr($category); exit();
				if(!empty($category)){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>$category['PostCategory']['id']),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				}
			} else if($type == "tag"){
				$tag = $this->PostTag->findBySlug($slug);
				
				if(!empty($tag)){
					$assignId = $this->PostAssignTag->find('list', array(
						'conditions'=>array(
							'PostAssignTag.tag_id'=>$tag['PostTag']['id']
						),
						'fields'=>array('id','post_id')
					));
					if(!empty($assignId)){
						if(count($assignId)==1){
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>current($assignId)),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
									);
						} else {
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id IN'=>$assignId),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
									);
						}
					} else {
						$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
					}
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				}
				
			}else if($type=='search'){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post','Page.title LIKE'=>'%'.$slug.'%'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
			}
		} else {
			$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
		}
		$posts = $this->paginate('Page');
		
		$this->set('type',$type);
		$this->set('slug',$slug);
		//pr($posts); exit();
		$this->set(compact('posts'));
	}
	
	
	
	public function timelinesl($type=NULL, $slug=NULL) 
	{
		
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
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
		// 
		
		if(!empty($type) && !empty($slug)){
			if($type == "category"){
				$category = $this->PostCategory->findBySlug($slug);
				//pr($category); exit();
				if(!empty($category)){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>$category['PostCategory']['id']),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				}
			} else if($type == "tag"){
				$tag = $this->PostTag->findBySlug($slug);
				
				if(!empty($tag)){
					$assignId = $this->PostAssignTag->find('list', array(
						'conditions'=>array(
							'PostAssignTag.tag_id'=>$tag['PostTag']['id']
						),
						'fields'=>array('id','post_id')
					));
					if(!empty($assignId)){
						if(count($assignId)==1){
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>current($assignId)),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
									);
						} else {
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id IN'=>$assignId),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
									);
						}
					} else {
						$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
					}
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				}
				
			}else if($type=='search'){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post','Page.title LIKE'=>'%'.$slug.'%'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
			}
		} else {
			$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
		}
		$posts = $this->paginate('Page');
		
		$this->set('type',$type);
		$this->set('slug',$slug);
		//pr($posts); exit();
		$this->set(compact('posts'));
	}
	
	
	
	public function timelinesr($type=NULL, $slug=NULL) 
	{
		
		$this->theme = THEME_NAME;
		$this->layout = 'inner';
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
		// 
		
		if(!empty($type) && !empty($slug)){
			if($type == "category"){
				$category = $this->PostCategory->findBySlug($slug);
				//pr($category); exit();
				if(!empty($category)){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>$category['PostCategory']['id']),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.categoryid'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				}
			} else if($type == "tag"){
				$tag = $this->PostTag->findBySlug($slug);
				
				if(!empty($tag)){
					$assignId = $this->PostAssignTag->find('list', array(
						'conditions'=>array(
							'PostAssignTag.tag_id'=>$tag['PostTag']['id']
						),
						'fields'=>array('id','post_id')
					));
					if(!empty($assignId)){
						if(count($assignId)==1){
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>current($assignId)),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
									);
						} else {
							$this->paginate = array(
									'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id IN'=>$assignId),
									'order'=>array('Page.id' => 'DESC'),
									'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
									);
						}
					} else {
						$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
					}
				} else {
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post', 'Page.id'=>0),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
				}
				
			}else if($type=='search'){
					$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post','Page.title LIKE'=>'%'.$slug.'%'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
			}
		} else {
			$this->paginate = array(
								'conditions' => array('Page.is_del'=>'0', 'Page.type'=>'Post'),
								'order'=>array('Page.id' => 'DESC'),
								'limit' => BLOG_PAGINATION_PER_PAGE_LIMIT
								);
		}
		$posts = $this->paginate('Page');
		
		$this->set('type',$type);
		$this->set('slug',$slug);
		//pr($posts); exit();
		$this->set(compact('posts'));
	}
	
	/*** Blog Template ***/
	
	public function archive($archive_string=NULL)
	{
		$this->theme = 'Nulife';
		$this->layout = 'inner';
		$this->loadModel('Page');
		
			$this->paginate = array(
						'limit' => 2,
						'conditions' => array('Page.is_del' => '0', 
												'Page.type' => 'Post',
												'Page.is_active' => 'Y',
												'Page.created_date LIKE' =>"%".$archive_string."%"),
						'order'=>array('Page.id' => 'DESC')
						);
			$archivedetails = $this->paginate('Page');
			
			
			
			$this->set(compact('archivedetails','archive_string'));
	}			
	public function ajaxpostlist(){		
	$this->theme = THEME_NAME;		
	$this->layout = "ajax";		
	$this->Page->bindModel(array
							('hasMany'=>array('PostComment' => array(
										'className'    => 'PostComment',
										'foreignKey'   => 'post_id',	
										'conditions'   => array('PostComment.status'=> 'Y'))
										)));
	if($this->request->is('post')){		
	$this->loadModel('Page');			
	$data = $this->request->data;		
	$pageno=$data['pageno'];			
	$offset=(($pageno-1)*3);		
	$postdata = $this->Page->find('all',array('conditions' =>array('is_del' => '0','type' => 'Post'),																'limit' => 3,	
																	'offset' => $offset,
																	'order'=>array('id' => 'DESC')));					
	$this->set('postdata',$postdata);	
	$this->set('pageno',$pageno);		
	}			
	}
	
	
	public function ajaxpostlist4c(){		
	$this->theme = THEME_NAME;		
	$this->layout = "ajax";		
	$this->Page->bindModel(array
							('hasMany'=>array('PostComment' => array(
										'className'    => 'PostComment',
										'foreignKey'   => 'post_id',	
										'conditions'   => array('PostComment.status'=> 'Y'))
										)));
	if($this->request->is('post')){		
	$this->loadModel('Page');			
	$data = $this->request->data;		
	$pageno=$data['pageno'];			
	$offset=(($pageno-1)*4);		
	$postdata = $this->Page->find('all',array('conditions' =>array('is_del' => '0','type' => 'Post'),																'limit' => 4,	
																	'offset' => $offset,
																	'order'=>array('id' => 'DESC')));
	/* pr($postdata);
	exit; */
	$this->set('postdata',$postdata);	
	$this->set('pageno',$pageno);		
	}			
	}
	
	
	public function ajaxpostlist2c(){		
	$this->theme = THEME_NAME;		
	$this->layout = "ajax";		
	$this->Page->bindModel(array
							('hasMany'=>array('PostComment' => array(
										'className'    => 'PostComment',
										'foreignKey'   => 'post_id',	
										'conditions'   => array('PostComment.status'=> 'Y'))
										)));
	if($this->request->is('post')){		
	$this->loadModel('Page');			
	$data = $this->request->data;		
	$pageno=$data['pageno'];			
	$offset=(($pageno-1)*2);		
	$postdata = $this->Page->find('all',array('conditions' =>array('is_del' => '0','type' => 'Post'),																'limit' => 2,	
																	'offset' => $offset,
																	'order'=>array('id' => 'DESC')));
	/* pr($postdata);
	exit; */
	$this->set('postdata',$postdata);	
	$this->set('pageno',$pageno);		
	}			
	}
	
	public function ajaxbloggidsr(){		
	$this->theme = THEME_NAME;		
	$this->layout = "ajax";		
	$this->Page->bindModel(array
							('hasMany'=>array('PostComment' => array(
										'className'    => 'PostComment',
										'foreignKey'   => 'post_id',	
										'conditions'   => array('PostComment.status'=> 'Y'))
										)));
	if($this->request->is('post')){		
	$this->loadModel('Page');			
	$data = $this->request->data;		
	$pageno=$data['pageno'];			
	$offset=(($pageno-1)*3);		
	$postdata = $this->Page->find('all',array('conditions' =>array('is_del' => '0','type' => 'Post'),																'limit' => 3,	
																	'offset' => $offset,
																	'order'=>array('id' => 'DESC')));
	/* pr($postdata);
	exit; */
	$this->set('postdata',$postdata);	
	$this->set('pageno',$pageno);		
	}			
	}
	
	public function ajaxbloggidsl(){		
	$this->theme = THEME_NAME;		
	$this->layout = "ajax";		
	$this->Page->bindModel(array
							('hasMany'=>array('PostComment' => array(
										'className'    => 'PostComment',
										'foreignKey'   => 'post_id',	
										'conditions'   => array('PostComment.status'=> 'Y'))
										)));
	if($this->request->is('post')){		
	$this->loadModel('Page');			
	$data = $this->request->data;		
	$pageno=$data['pageno'];			
	$offset=(($pageno-1)*3);		
	$postdata = $this->Page->find('all',array('conditions' =>array('is_del' => '0','type' => 'Post'),																'limit' => 3,	
																	'offset' => $offset,
																	'order'=>array('id' => 'DESC')));
	/* pr($postdata);
	exit; */
	$this->set('postdata',$postdata);	
	$this->set('pageno',$pageno);		
	}			
	}
	

}
?>