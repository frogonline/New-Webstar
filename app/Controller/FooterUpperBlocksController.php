<?php 
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class FooterUpperBlocksController extends AppController 
{
	
	public $name = 'FooterUpperBlocks';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('FooterUpperBlock');
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
		
		$this->paginate=array(
					'conditions' => array('FooterUpperBlock.is_del'=>'0'),
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'order'=>array('FooterUpperBlock.id' => 'DESC')
					);
		$data=$this->paginate('FooterUpperBlock');
		
		$this->set('data', $data);			
		
	}

	public function admin_delete($id=NULL,$stat = '1')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['FooterUpperBlock']['is_del'] = $stat;
		$this->FooterUpperBlock->id = $id;
		$this->FooterUpperBlock->save($data);
		$this->Session->setFlash('<p>The footer block has been successfully removed!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}

	public function admin_manage($id=NULL)
	{
		
		$this->layout = 'adminInner';
		
		if ($this->request->is('post')) 
		{	
			
			$this->FooterUpperBlock->set($this->request->data);
			
			
			if($this->FooterUpperBlock->validates()) 
			{
				if($this->request->data['FooterUpperBlock']['id'] !== ''){
					$this->FooterUpperBlock->id = $id;
					$this->request->data['FooterUpperBlock']['updated_date']	=	Date('Y-m-d');
				} else{
					//$this->HomepageWidget->create();
					
					$this->request->data['FooterUpperBlock']['created_date']	=	Date('Y-m-d');
					
					$this->FooterUpperBlock->create();
				}
		//	pr($this->request->data);exit();
				$this->FooterUpperBlock->save($this->request->data);
				$saveId = $this->FooterUpperBlock->id;

				if($this->request->data['FooterUpperBlock']['id'] !== ''){
					$this->Session->setFlash('<p>Footer block Updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
					
				} else{
					$this->Session->setFlash('<p>Footer block added successfully!</p>', 'default', array('class' => 'alert alert-success'));
					
				}
				if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'FooterUpperBlocks','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'FooterUpperBlocks','action'=>'admin_index'));
				}
				//$this->redirect('/admin/FooterUpperBlocks/index');
			} 
		}
		
		$this->set('id', $id);
		if($id !== NULL || $id !== ''){
			$data = $this->FooterUpperBlock->findById($id);
			$this->set('data',$data);
		}
		if(!$id)
		{
			$data	=	$this->request->data;
			$this->set('data',$data);
		}
	}

	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		//pr($id); exit();
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->FooterUpperBlock->findById($id);
			$data['FooterUpperBlock']['is_del'] = $stat;
			$this->FooterUpperBlock->id = $id;
			$deleteFlag = $this->FooterUpperBlock->save($data);
			
			if($deleteFlag){
				$this->Session->setFlash('<p>Block removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Block removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	} 
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		
		$this->layout = '';
		$this->autoRender = false;
		$data['FooterUpperBlock']['is_active'] = $stat;
		
		$this->FooterUpperBlock->id = $id;
		$this->FooterUpperBlock->save($data);
		$this->Session->setFlash('<p>Block updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	} 	
}
?>
