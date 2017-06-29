<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');

class CatalogsController extends AppController {
	
	public $name = 'Catalogs';
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
	
	
	
	public function admin_index($id=NULL)
	{
		$this->layout = 'adminInner';
		$data = $this->request->data;
		if(empty($data['Catalog']['searchvalue']))
		 {
			if($this->request->is("post"))
			{
			if($id != ''){
				$this->Catalog->id = $id;
			} else{
				$this->Catalog->create();
				$data = $this->request->data;
				$data['Catalog']['status']='Y';
			}
			$saveFlag = $this->Catalog->save($data);
			if($saveFlag){
					if($id != ''){
						$this->Session->setFlash('<p>Catalog updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
					} else{
						$this->Session->setFlash('<p>Catalog added successfully!</p>', 'default', array('class' => 'alert alert-success'));
					}
				} else {
					$this->Session->setFlash('Failed to save the Catalog', 'default', array('class' => 'alert alert-danger'));
				}
				$this->redirect($this->referer());
			}
		}
		else if(!empty($data['Catalog']['searchvalue'])) {
		if($this->request->is("post"))
		{ 
		$data = $this->request->data;
		$likekeyArr = array('name');
		$statusyArr = array('status');
		$conditionArr = array();
		foreach($data['Catalog'] as $k => $v){
			if( ($v != NULL) ){
				if( in_array($k,$likekeyArr) ){
					$conditionArr['Catalog.'.$k.' LIKE'] = '%'.$v.'%';
				} else if( in_array($k,$statusyArr) ) {
						$conditionArr['Catalog.'.$k.' LIKE'] = '%'.$v.'%';
				}
			}
		}
		$this->paginate = array(
			'conditions' => $conditionArr,
			'limit' => PAGINATION_PER_PAGE_LIMIT,
			'order'=>array('Catalog.id' => 'DESC')
		);
		$this->set('searchData',$data);

		}
		}
		else{
		 
			$this->paginate=array(
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Catalog.id' => 'DESC')
				);
			}
		
		$data=$this->paginate('Catalog');
		$this->set('data', $data);	
	}
	
	public function admin_manage($id=NULL){
		$this->layout = 'adminInner';
		$id=$id;
		$this->loadModel('CatalogUser');
		$this->loadModel('Catalog');
		$this->loadModel('ProductCategory');
		$this->loadModel('Product');
		$this->loadModel('CatalogProduct');
		 
		$this->loadModel('Member');
		$this->CatalogUser->bindModel(
				array(
					'belongsTo' => array(
						'Member' => array(
								'className'    => 'Member',
								'foreignKey'   => 'membar_id',
								'fields'=>'name'
							)
					)
				)
			);
			
			$this->CatalogProduct->bindModel(
				array(
					'belongsTo' => array(
						'Catalog' => array(
								'className'    => 'Catalog',
								'foreignKey'   => 'catalog_id',
								'fields'=>'name'
							)
					)
				)
			);
			
			$data = $this->request->data;
			if(empty($data['Catalog']['searchvalue']))
			{
				if($this->request->is("post"))
				{
				$Memberss1 = $this->Member->find('count',array(
												'conditions'=>array('name'=>$data['Catalog']['muser_id'])
											));		
				
				$presentid= $this->CatalogUser->find('count',array(
												'conditions'=>array('CatalogUser.membar_id'=>$data['Catalog']['membar_id'],'CatalogUser.catalog_id'=>$data['Catalog']['calalogidvalue'])
											));	
			 
				$datasave=array();
				$datasave['CatalogUser']['membar_id']=$data['Catalog']['membar_id'];
				$datasave['CatalogUser']['catalog_id']=$data['Catalog']['calalogidvalue'];
				if($Memberss1!=0)
				{
					if($presentid ==0){
					
					$saveFlag = $this->CatalogUser->save($datasave);
					}
				}
				
				
				if ($Memberss1==0)
				{
						$this->Session->setFlash('User does not exist','default', array('class' => 'alert alert-danger') );
				}else if($presentid!=0)
				{
					$this->Session->setFlash('The user already exists in this catalog named','default', array('class' => 'alert alert-danger') );
				}
				if($Memberss1!=0)
				{
					if($presentid ==0)
					{
					if($saveFlag) {
						$this->Session->setFlash('User added successfully','default', array('class' => 'alert alert-success') );
					}
				  }
				}
				
				$this->redirect(array('controller'=>'Catalogs', 'action'=>'admin_manage/'.$datasave['CatalogUser']['catalog_id']));
			}
		 }
		 else if (!empty($data['Catalog']['searchvalue'])){
			if($this->request->is("post"))
			{
			$product1 = $this->Product->find('count',array(
											'conditions'=>array('Product.product_name'=>$data['Catalog']['productdar_id'],'Product.isdel' => 0)
										));		
			
			
			$datasave=array();
			$datasave['CatalogProduct']['product_id']=$data['Catalog']['product_id'];
			$datasave['CatalogProduct']['product_price']=$data['Catalog']['product_price'];
			$datasave['CatalogProduct']['catalog_id']=$data['Catalog']['catalog_id'];
			$datasave['CatalogProduct']['sequence']=$data['Catalog']['sequence'];
			$presentid= $this->CatalogProduct->find('count',array(
												'conditions'=>array('CatalogProduct.catalog_id'=>$data['Catalog']['catalog_id'],'CatalogProduct.product_id'=>$data['Catalog']['product_id'])
											));	
			
			if($product1!=0)
			{
				if($presentid == 0)
				{
					$saveFlag = $this->CatalogProduct->save($datasave);
				}
			}
			if($product1==0)
			{
				$this->Session->setFlash('Product does not exist','default', array('class' => 'alert alert-danger') );
			}else if($presentid!=0)
			{
				$this->Session->setFlash('The product already exists in this catalog named','default', array('class' => 'alert alert-danger') );
			}
			
			if($product1!=0)
			{
				if($presentid == 0)
				{
				if($saveFlag){
					$this->Session->setFlash('Product added successfully','default', array('class' => 'alert alert-success') );
				}
			  }
			}
			
			$this->redirect(array('controller'=>'Catalogs', 'action'=>'admin_manage/'.$datasave['CatalogProduct']['catalog_id']));
		}
		}
			$data=$this->CatalogUser->find('all',array(
											'conditions'=>array('CatalogUser.catalog_id'=>$id),
											'limit' => PAGINATION_PER_PAGE_LIMIT,
											'order'=>array('CatalogUser.id' => 'DESC')
			
			
			));
			$data1=$this->CatalogProduct->find('all',array(
											'conditions'=>array('CatalogProduct.catalog_id'=>$id),
											'limit' => PAGINATION_PER_PAGE_LIMIT,
											'order'=>array('CatalogProduct.id' => 'DESC')
			
			
			));
			
			
			$model = ClassRegistry::init('Member');
			$Member = $model->find('list',
			array(
				'fields'=>'Member.id, Member.name'
			));	
			
			
			$model1 = ClassRegistry::init('Product');
			$product = $model1->find('list',
			array(
				'fields'=>'Product.id, Product.product_name'
			));	
			
			$catalogname=$this->Catalog->find('list',array(
											'conditions'=>array('Catalog.id'=>$id),
											'fields' =>'Catalog.id,Catalog.name'));
			
			
		
			$categories = $this->ProductCategory->generateTreeList(null, null, null, '&nbsp;&nbsp;&nbsp;&nbsp;');
			$this->set(compact('data', 'Member','id','categories','data1','product','catalogname'));
			
			
		
	}
	
	public function admin_status($id=NULL, $status =NULL)
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Catalog']['status'] = $status;
		
		$this->Catalog->id = $id;
		$updateFlag = $this->Catalog->save($data);
		
		if($updateFlag){
			$this->Session->setFlash('Catalog status changed successfully!', 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('Failed to changed status!', 'default', array('class' => 'alert alert-danger'));
		}
		$this->redirect($this->referer());
	}
	
	public function admin_delete($id=NULL)
	{	
		$this->layout = '';
		$this->autoRender = false;
		$this->Catalog->delete($id);
		$this->Session->setFlash('<p>Catalog details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	public function admin_deleteuser($id=NULL , $calalogid=NULL)
	{	
		$this->layout = '';
		$this->autoRender = false;
		$this->loadModel('CatalogUser');
		$this->CatalogUser->delete($id);
		$this->Session->setFlash('<p>User details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect(array('controller'=>'Catalogs', 'action'=>'admin_manage/'.$calalogid));
	}
	public function admin_deleteproductcat($id=NULL , $calalogid=NULL)
	{	
		$this->layout = '';
		$this->autoRender = false;
		$this->loadModel('CatalogProduct');
		$this->CatalogProduct->delete($id);
		$this->Session->setFlash('<p>Catalog Product has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect(array('controller'=>'Catalogs', 'action'=>'admin_manage/'.$calalogid));
	}
	
	
	public function admin_deleteAll($idAll=NULL)
	{	
		//pr($id); exit();
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$deleteFlag = $this->Catalog->delete($id);
			if($deleteFlag){
				$this->Session->setFlash('Catalogs removed successfully !', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete Catalogs', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	public function admin_userdeleteAll($idAll=NULL , $calalogid=NULL)
	{	
		//pr($idAll); exit();
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		$this->loadModel('CatalogUser');
		foreach($idArr as $id){
			$deleteFlag = $this->CatalogUser->delete($id);
			if($deleteFlag){
				$this->Session->setFlash('User removed successfully !', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete User', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect(array('controller'=>'Catalogs', 'action'=>'admin_manage/'.$calalogid));
	}
	
	public function admin_catalogproductdeleteAll($idAll=NULL , $calalogid=NULL)
	{	
		
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		$this->loadModel('CatalogProduct');
		foreach($idArr as $id){
			$deleteFlag = $this->CatalogProduct->delete($id);
			if($deleteFlag){
				$this->Session->setFlash('Catalog Product removed successfully !', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete Catalog Product', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect(array('controller'=>'Catalogs', 'action'=>'admin_manage/'.$calalogid));
	}
	
	public function admin_editcatalog(){
		$this->layout = 'ajax';
		$this->set('id', $this->request->data['id']);
		$this->loadModel('Catalog');
		if($this->request->data['id'] != ''){			
			$data = $this->Catalog->findById($this->request->data['id']);
			$this->set('data',$data);
		}
	}
	public function admin_editproduct(){
		$this->layout = 'ajax';
		$this->loadModel('CatalogProduct');
		$this->loadModel('ProductCategory');
		$catalog_id=$this->request->data['catalog_id'];
		$productid=$this->request->data['id'];
		$model1 = ClassRegistry::init('Product');
			$product = $model1->find('list',
			array(
				'fields'=>'Product.id, Product.product_name'
			));	
		$categories = $this->ProductCategory->generateTreeList(null, null, null, '&nbsp;&nbsp;&nbsp;&nbsp;');
		if($this->request->data['id'] != ''){			
		$data=$this->CatalogProduct->find('all',array(
											'conditions'=>array('CatalogProduct.catalog_id'=>$catalog_id,'CatalogProduct.id'=>$productid)));
		$this->set('data',$data);
		$this->set('categories',$categories);
		$this->set('product',$product);
		$this->set('productid', $this->request->data['id']);
		$this->set('catalog_id', $this->request->data['catalog_id']);
		//pr($data);
		}
	}
	
	public function admin_editproductsave(){
		$this->autoRender = false;
		$this->loadModel('CatalogProduct');
		if($this->request->is("post"))
		{
			$data=$this->request->data;
			$this->CatalogProduct->id = $data['Catalog']['id'];
			$datasave['CatalogProduct']['product_price']=$data['Catalog']['product_price'];
			$datasave['CatalogProduct']['sequence']=$data['Catalog']['sequence'];
			$updateFlag = $this->CatalogProduct->save($datasave);
			if($updateFlag){
			$this->Session->setFlash('Catalog Product Update successfully!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to Update Catalog Product!', 'default', array('class' => 'alert alert-danger'));
			}
			$this->redirect(array('controller'=>'Catalogs', 'action'=>'admin_manage/'.$data['Catalog']['catalog_id']));
		}
	}
	
}
	?>