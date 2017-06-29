<?php 
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class ProductOptionsController extends AppController 
{
	public $name = 'ProductOptions';
	public $components = array();
	public $helpers = array();
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

	public function admin_index(){
		$this->layout = 'adminInner';
		
		if($this->request->is("post"))
		{ 
			$data = $this->request->data;
			$likekeyArr = array('options_name');
			$conditionArr = array();
			foreach($data['ProductOption'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['ProductOption.'.$k.' LIKE'] = '%'.$v.'%';
					}  else {
							$conditionArr['ProductOption.'.$k] = $v; 
						}
					
				}
			}
			$conditionArr['ProductOption.is_del'] = 0;
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('ProductOption.id' => 'DESC')
			);
			$this->set('searchData',$data);

		} else {
		
		$this->paginate = array(
								'conditions' => array('ProductOption.is_del'=>'0'),
								'order' => array('ProductOption.sort_order'=>'Desc'),
								'limit' => PAGINATION_PER_PAGE_LIMIT
							);
			}
		$data = $this->paginate('ProductOption'); 
		$this->set('data', $data); 
	}
	
	public function admin_delete($id=NULL,$stat = '1')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['ProductOption']['is_del'] = $stat;
		$this->ProductOption->id = $id;
		$this->ProductOption->save($data);
		$this->Session->setFlash('<p>The Product Option has been successfully removed!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());
		exit();
	}
	
	public function admin_manage($id=NULL)
	{
		
		$this->layout = 'adminInner';
		
		if ($this->request->is('post')) 
		{	
			
			$this->ProductOption->set($this->request->data);
			
			
			if($this->ProductOption->validates()) 
			{
				$this->loadModel('OptionValue');
				
				$data=$this->request->data;
				if($data['ProductOption']['id'] !== ''){
					$this->ProductOption->id = $id;
				} else{
					$this->ProductOption->create();
				}
		
				$this->ProductOption->save($data);
				
				$ProductOptionId=$this->ProductOption->id;
				
				if(!empty($data['OptionValue']))
				{
					$this->loadModel('OptionValue');
					if(!array_key_exists('id',$data['OptionValue'])){
						$data['OptionValue']['id'] = array();
					}
					
					foreach($data['OptionValue']['itemnu'] as $k=>$v){
						if(!empty($data['OptionValue']['id'])){
							$this->OptionValue->id = array_shift($data['OptionValue']['id']);
						} else {
							$this->OptionValue->create();
						}
						
						$saveArr['OptionValue']['option_id'] = $ProductOptionId;
						$saveArr['OptionValue']['option_value_name'] = (!empty($data['OptionValue']['option_value_name'][$k]))?$data['OptionValue']['option_value_name'][$k]:'';
						$saveArr['OptionValue']['option_sort_order'] = (!empty($data['OptionValue']['option_sort_order'][$k]))?$data['OptionValue']['option_sort_order'][$k]:0;
						//pr($saveArr);
						$this->OptionValue->save($saveArr);
					}
					
				}
				//pr($data);exit;
				if($data['ProductOption']['id'] !== ''){
					$this->Session->setFlash('Product Option Updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
					
				} else{
					$this->Session->setFlash('Product Option added successfully!</p>', 'default', array('class' => 'alert alert-success'));
				}
				if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'ProductOptions','action'=>'admin_manage/'.$ProductOptionId));
				} else {
					$this->redirect(array('controller'=>'ProductOptions','action'=>'admin_index'));
				}
				//$this->redirect('/admin/ProductOptions/index');
			} 
		}
		
		$this->set('id', $id);
		if($id !== NULL || $id !== ''){
			$this->ProductOption->bindModel(array(
								'hasMany' => array(
									'OptionValue' => array(
											'className'    => 'OptionValue',
											'foreignKey'   => 'option_id'
										)
								)
							));
			$data = $this->ProductOption->findById($id);
			$this->set('data',$data);
		}
		
	}
	
	public function admin_addrows()
	{
		$this->layout = 'ajax';
		$this->set('divNo',$this->request->data['divNo']);
	}
	
	public function admin_productoption_remove($mid){
		$this->autoRender = false;
		$this->loadModel('OptionValue');
		$this->OptionValue->delete($mid);
		$this->Session->setFlash('<p>Product Option Value deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['ProductOption']['options_status'] = $stat;
		
		$this->ProductOption->id = $id;
		$this->ProductOption->save($data);
		$this->Session->setFlash('<p>Product Option updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		//pr($id); exit();
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->ProductOption->findById($id);
			$data['ProductOption']['is_del'] = $stat;
			$this->ProductOption->id = $id;
			$deleteFlag = $this->ProductOption->save($data);
			//$deleteFlag = $this->ProductOption->delete($id);
			if($deleteFlag){
				$this->Session->setFlash('<p>Product Option removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('<p>Product Option removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
}	
?>