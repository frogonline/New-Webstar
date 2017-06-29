<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');

class ResourcesController extends AppController {
	
	public $name = 'Resources';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array();
	public $paginate = array();

	public function beforeFilter() 
	{
		parent::beforeFilter();
		$this->Auth->allow();
		
		if(isset($this->request->params['users'])){
			$this->Security->requireSecure();			
		}
		$this->Security->blackHoleCallback = 'blackhole';
	}
    
	public function blackhole($type) {
	
		// handle errors.
	}	
	
	private function rmdir_recursive($dir) 
	{
		foreach(scandir($dir) as $file) 
		{
			if ('.' === $file || '..' === $file) continue;
			if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
			else unlink("$dir/$file");
		}
		 
		rmdir($dir);
	}
	
	public function admin_index()
	{
		$this->layout = 'adminInner';
		$savedata = $this->request->data;
		if(empty($savedata['Resource']['searchvalue']))
		 {
			if($this->request->is('POST')){
			if($this->Resource->validates()){
				$savedata = $this->request->data;
				$slugArr = array('Model'=>'Resource','field'=>'folder_name');
				$savedata['Resource']['folder_name'] = AppController::get_slug($savedata['Resource']['resource_name'],$slugArr);
				$savedata['Resource']['status'] = 'Y';
				$path = dirname(__DIR__);
				$path .= '/webroot/resources/';
				$targetdir = $path . $savedata['Resource']['folder_name'];
				
				if(is_dir($targetdir)){
					$this->rmdir_recursive($targetdir);
				}
				$makedirFlag = mkdir($targetdir, 0755);
				
				if($makedirFlag){
					$this->Resource->create();
					$saveFlag = $this->Resource->save($savedata);
					if($saveFlag){
						$this->Session->setFlash('Resource added successfully','default', array('class' => 'alert alert-success') );
					} else {
					$this->Session->setFlash('Alphabets,numbers and two special characters underscore, hyphen are allowed in resource name','default', array('class' => 'alert alert-danger') );
					}
				} else {
					$this->Session->setFlash('Failed make directory','default', array('class' => 'alert alert-danger') );
				}
				
				$this->redirect(array('controller'=>'Resources', 'action'=>'admin_index'));
			}
			
		}
	 }
		 if($this->request->is("post"))
			{ 
			$data = $this->request->data;
			$likekeyArr = array('resource_name');
			$statusyArr = array('status');
			$conditionArr = array();
			foreach($data['Resource'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['Resource.'.$k.' LIKE'] = '%'.$v.'%';
					} else if( in_array($k,$statusyArr) ) {
							$conditionArr['Resource.'.$k.' LIKE'] = '%'.$v.'%';
					}
				}
			}
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Resource.id' => 'DESC')
			);
			$this->set('searchData',$data);

			}else {
				$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'order'=>array('Resource.id' => 'DESC')
					);
			}
		$data=$this->paginate('Resource');
		$this->set('data', $data);
		/* pr($data);
		exit; */
	}
	
	public function admin_manage($id=NULL){	
		$this->layout = 'adminInner';
		$this->loadModel('ResourceDetail');
		if($this->request->is('post'))
		{	
			if($this->ResourceDetail->validates()){
				$data = $this->request->data;
				//pr($data);
				if(!empty($data['ResourceDetail']['file_name'][0]['name'])){
					$saveFlagArr = array();
					foreach($data['ResourceDetail']['file_name'] as $resourcefile){
						list($file1,$error1,$update_field1) = AppController::upload($resourcefile, WWW_ROOT . DS . 'resources'. DS . $data['ResourceDetail']['folder_name']. DS  ,'jpg,csv,jpeg,JPG,JPEG,gif,GIF,png,PNG,PDF,pdf,doc,DOC,docx,DOCX,ppt,pptx,PPTX,xls,xlsx,xlsm,xlsb');
						
						if(!empty($file1)){
							$saveData['ResourceDetail']['file_name'] = $file1;
							$saveData['ResourceDetail']['resource_id'] = $id;
							$saveData['ResourceDetail']['name'] = $data['ResourceDetail']['name'];
							$this->ResourceDetail->create();
							$saveFlag = $this->ResourceDetail->save($saveData);
							($saveFlag)?array_push($saveFlagArr, 'T'):array_push($saveFlagArr, 'F');
						}
					}
					
					/* if($id !== ''){
						$this->ResourceDetail->id = $id;
						$data = $this->request->data;
						pr($data); exit;
						$this->ResourceDetail->id = $id;
						$this->ResourceDetail->save($data);
					} */
					if(!empty($saveFlagArr) && !in_array('F',$saveFlagArr)){
						$this->Session->setFlash('File uploaded successfully', 'default', array('class' => 'alert alert-success'));
					} else {
						$this->Session->setFlash('Failed to upload all files', 'default', array('class' => 'alert alert-success'));
					}
				}
				$this->redirect(array('controller'=>'Resources', 'action'=>'admin_manage/'.$id));
			}
		}
		$this->set('id',$id);
		//Set Data For Edit
		if($id != NULL || $id != '')
		{
			$this->Resource->bindModel(array(
								'hasMany' => array(
									'ResourceDetail' => array(
										'className'    => 'ResourceDetail',
										'foreignKey'   => 'resource_id'
									)
								)
							));
			$data = $this->Resource->findById($id); //pr($data); exit();
			$this->set('data', $data); 
		}
		
	}
	
	public function admin_delete($id=NULL)	{			$this->layout = '';		$this->autoRender = false;				if($id!=NULL){			$data = $this->Resource->findById($id);			$path = dirname(__DIR__);			$path .= '/webroot/resources/';			$targetdir = $path.$data['Resource']['folder_name'];			if(is_dir($targetdir)){				$this->rmdir_recursive($targetdir);			}						$resourcedetails=$this->Resource->findById($id);									$this->loadModel('Slug');								$deleteFlag = $this->Resource->delete($id);			$slugedetails=$this->Slug->findBySlugName($resourcedetails['Resource']['folder_name']);							$deleteslugFlag = $this->Slug->delete($slugedetails['Slug']['id']);										if($deleteFlag){				$this->Session->setFlash('Resource delete successfully', 'default', array('class' => 'alert alert-success'));			} else {				$this->Session->setFlash('Failed to delete resource', 'default', array('class' => 'alert alert-danger'));			}		}				$this->redirect($this->referer());		}
	
	public function admin_resourcedelete($folder='',$fileid=NULL,$id=NULL)
	{	
		$this->layout = '';
		$this->autoRender = false;
		$this->loadModel('ResourceDetail');
		$resource = $this->ResourceDetail->findById($fileid);
		$file = WWW_ROOT.'resources/'.$folder.'/'.$resource['ResourceDetail']['file_name'];
		if(file_exists($file)){
			unlink($file);
		}
		$deleteFlag = $this->ResourceDetail->delete($fileid);
		
		if($deleteFlag){
			$this->Session->setFlash('File delete successfully', 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('Failed to delete file', 'default', array('class' => 'alert alert-danger'));
		}
		
		$this->redirect(array('controller'=>'Resources','action'=>'admin_manage/'.$id));
	}
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Resource']['status'] = $stat;
		
		$this->Resource->id = $id;
		$updateFlag = $this->Resource->save($data);
		
		if($updateFlag){
			$this->Session->setFlash('Resource status changed successfully!', 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('Failed to change status!', 'default', array('class' => 'alert alert-danger'));
		}
		$this->redirect($this->referer());
	}
	
	public function admin_deleteAll($idAll=NULL)
	{	
		//pr($id); exit();
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		$this->loadModel('ResourceDetail');
		
		foreach($idArr as $id){
			
			if($id!=NULL){
				$data = $this->Resource->findById($id);
				$path = dirname(__DIR__);
				$path .= '/webroot/resources/';
				$targetdir = $path.$data['Resource']['folder_name'];
				if(is_dir($targetdir)){
					$this->rmdir_recursive($targetdir);
				}
				$this->ResourceDetail->deleteAll(array('ResourceDetail.resource_id'=>$id));								$resourcedetails=$this->Resource->findById($id);										$this->loadModel('Slug');									$deleteFlag = $this->Resource->delete($id);				$slugedetails=$this->Slug->findBySlugName($resourcedetails['Resource']['folder_name']);								$deleteslugFlag = $this->Slug->delete($slugedetails['Slug']['id']);
				
				if($deleteFlag){
					$this->Session->setFlash('Resource delete successfully', 'default', array('class' => 'alert alert-success'));
				} else {
					$this->Session->setFlash('Failed to delete resource', 'default', array('class' => 'alert alert-danger'));
				}
			}
		}
		$this->redirect($this->referer());	
	}
	
	public function admin_imageupdatename(){
		$this->layout = 'ajax';
		$this->set('id', $this->request->data['id']);
		$this->loadModel('ResourceDetail');
		if($this->request->data['id'] != ''){			
			$data12 = $this->ResourceDetail->findById($this->request->data['id']);
			$this->set('data1',$data12);
		}
		
		
	}
	
	
	public function admin_imageupdate($id=NULL){
		$this->layout = 'adminInner';
		$this->loadModel('ResourceDetail');
		if($this->request->is("post")){
			
			if($id != ''){
				$this->ResourceDetail->id = $id;
				
			} else{
				
				$this->ResourceDetail->create();
			}
			$data = $this->request->data;
		
			$saveData['ResourceDetail']['id'] = $data['ResourceDetail']['id'] ;
			$saveData['ResourceDetail']['name'] = $data['ResourceDetail']['title'];
			$return =  $this->ResourceDetail->save($saveData);
			
			
			if($return['ResourceDetail']['id'] != ''){
				$this->Session->setFlash('<p>Image name updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
			}
			$data1 = $this->ResourceDetail->findById($id);
			/* pr($data1);
			exit; */
			$this->redirect('/admin/Resources/manage/'.$data1['ResourceDetail']['resource_id']);
			
		}
		
	}
}
	?>