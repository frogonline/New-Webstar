<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class ProductReviewsController extends AppController 
{
	public $name = 'ProductReviews';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('ProductReviews');
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
	
	public function admin_index()
	{
		$this->layout = 'adminInner';
		$this->ProductReviews->bindModel(
				array(
					'belongsTo' => array(
						'Product' => array(
								'className'    => 'Product',
								'foreignKey'   => 'product_id'
							)
					)
				)
			);
		$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('ProductReviews.isdel'=>'0'),
					'order'=>array('ProductReviews.id' => 'DESC')
					);
		$data=$this->paginate('ProductReviews');
		$this->set('data', $data);
	}
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		
		$data['ProductReviews']['status'] = $stat;
		date_default_timezone_set('Asia/Calcutta');
		$data['ProductReviews']['modified_date'] = date('Y-m-d H:i:s');
		$this->ProductReviews->id = $id;
		$this->ProductReviews->save($data);
		$this->Session->setFlash('<p><strong>Success:&nbsp;</strong>ProductReviews updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());
		exit();
	}
	
	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['ProductReviews']['isdel'] = $isdel; 
		$this-> ProductReviews->id = $id;
		$this-> ProductReviews->save($data);
		$this->Session->setFlash('<p><strong>Success:&nbsp;</strong> ProductReviews details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		//pr($id); exit();
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->ProductReviews->findById($id);
			
			$data['ProductReviews']['isdel'] = $stat;
			$this->ProductReviews->id = $id;
			$deleteFlag = $this->ProductReviews->save($data);
			if($deleteFlag){
				$this->Session->setFlash('<p><strong>Success:&nbsp;</strong>ProductReviews removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p><strong>Success:&nbsp;</strong>ProductReviews removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
}
?>