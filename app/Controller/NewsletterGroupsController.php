<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class NewsletterGroupsController extends AppController 
{
	public $name = 'NewsletterGroups';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('NewsletterGroups');
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
		
		
		if($this->request->is("post"))
		{
			$data = $this->request->data;
			$likekeyArr = array('code');
			$conditionArr = array('NewsletterGroups.isdel'=>'0');
			foreach($data['NewsletterGroups'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr)){
						$conditionArr['NewsletterGroups.'.$k.' LIKE'] = '%'.$v.'%';
					} else {
							$conditionArr['NewsletterGroups.'.$k] = $v; 
						}
					}
				}
		
			
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('NewsletterGroups.id' => 'DESC')
			);
			$this->set('searchData',$data);

		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('NewsletterGroups.isdel'=>'0'),
					'order'=>array('NewsletterGroups.id' => 'DESC')
					);
			
		}
		$data=$this->paginate('NewsletterGroups');
		$this->set('data', $data);
		
	}

	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['NewsletterGroups']['isdel'] = $isdel; 
		$this->NewsletterGroups->id = $id;
		$this->NewsletterGroups->save($data);
		$this->Session->setFlash('<p> Newsletter Groups has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}



public function admin_manage($id=NULL){	
		$this->layout = 'adminInner';
		
		if($this->request->is('post')){	
			
			if($this->NewsletterGroups->validates()){
				$data = $this->request->data;
				if($id != ''){
					
					$this->NewsletterGroups->id = $id;
				} else{
			
					$this->NewsletterGroups->create();
				}
				
				
				
			
				$saveFlag = $this->NewsletterGroups->save($this->request->data);
				$saveId = $this->NewsletterGroups->id;

				if($saveFlag){
					if($id != ''){
						$this->Session->setFlash('Newsletter Group updated successfully.', 'default', array('class' => 'alert alert-success'));
					} else{
						$this->Session->setFlash('Newsletter Group added successfully', 'default', array('class' => 'alert alert-success'));
					}
				} else {
					$this->Session->setFlash('Failed to save the Newsletter Group', 'default', array('class' => 'alert alert-danger'));
				}
				//$this->redirect(array('controller'=>'Coupons','action'=>'admin_index'));
			
			if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'NewsletterGroups','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'NewsletterGroups','action'=>'admin_index'));
				}
			} 
		}
		$this->set('id', $id);
		if(trim($id) !== ''){
			$data = $this->NewsletterGroups->findById($id);
			$this->set('data', $data);
		}
	}
	
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		//pr($id); exit();
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->NewsletterGroups->findById($id);
			
			$data['NewsletterGroups']['isdel'] = $stat;
			$this->NewsletterGroups->id = $id;
			$deleteFlag = $this->NewsletterGroups->save($data);
			//$deleteFlag = $this->News->delete($id);
			if($deleteFlag){
				$this->Session->setFlash('<p>Newsletter Group removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Newsletter Group removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['NewsletterGroups']['status'] = $stat;
		
		$this->NewsletterGroups->id = $id;
		$this->NewsletterGroups->save($data);
		$this->Session->setFlash('<p>Newsletter Group updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
}
?>