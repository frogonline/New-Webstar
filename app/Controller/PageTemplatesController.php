<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class PageTemplatesController extends AppController {

	public $name = 'PageTemplates';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('PageTemplate');
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
		$this->loadModel('User');
		$this->PageTemplate->bindModel(
			array(
				'belongsTo' => array(
					'User' => array(
							'className'    => 'User',
							'foreignKey'   => 'created_by'
							
						)
				)
			)
		);
		if($this->request->is("post"))
		{ 
			$data = $this->request->data;
			$likekeyArr = array('template_name');
			$conditionArr = array();
			foreach($data['PageTemplate'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['PageTemplate.'.$k.' LIKE'] = '%'.$v.'%';
					} 
				}
			}
			$conditionArr['PageTemplate.template_type']='CUSTOM';
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('PageTemplate.id' => 'DESC')
			);
			$this->set('searchData',$data);

		} else {
			$this->loadModel('User');
			$tplsuperUser = $this->User->findByUserType('super');
			
			$this->paginate=array(
				'conditions' => array('created_by'=>(!empty($tplsuperUser))?$tplsuperUser['User']['user_id']:0),
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('PageTemplate.id'=>'DESC')
			);
		}
		$data = $this->paginate('PageTemplate');
		$this->set('data', $data);	
	}
	
	public function admin_delete($id=NULL)
	{	
		$this->layout = '';
		$this->autoRender = false;
		$this->PageTemplate->id = $id;
		//$deleteFlag = $this->PageTemplate->delete($id);
			if($id!==''){
				$this->loadModel('PageTemplateRow');
				$get_data = $this->PageTemplateRow->findAllByTemplateId($id);
				
				foreach($get_data as $getdata)
				{
					
				$this->loadModel('PageTemplateRowsColumn');
				$get_data1 = $this->PageTemplateRowsColumn->findAllByRowId($getdata['PageTemplateRow']['id']);
				foreach($get_data1 as $getdata1)
				{
					//echo $getdata1['PageTemplateRowsColumn']['row_id'];
					$this->PageTemplateRowsColumn->delete(
					array( 'PageTemplateRowsColumn.id' => $getdata1['PageTemplateRowsColumn']['id'])   //condition
					);
				}
				
					$this->PageTemplateRow->delete(
					array('PageTemplateRow.id' => $getdata['PageTemplateRow']['id'])   //condition
					); 
				}
				$deleteflag = $this->PageTemplate->delete($id);
				
					$this->Session->setFlash('<p>Template has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
					$this->redirect($this->referer());	
			}
	}
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['PageTemplate']['show_flag'] = $stat;
		
		$this->PageTemplate->id = $id;
		$this->PageTemplate->save($data);
		$this->Session->setFlash('<p>PageTemplate updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	public function admin_deleteAll($idAll=NULL)
		{	
			
			$idArr = explode(',',$idAll);
			$this->layout = '';
			$this->autoRender = false;
			
			foreach($idArr as $id){
				$data = $this->PageTemplate->findById($id);
				$this->PageTemplate->id = $id;
				//$deleteFlag = $this->Tabs->save($data);
				if($id!==''){
					$this->loadModel('PageTemplateRow');
					$get_data = $this->PageTemplateRow->findAllByTemplateId($id);
					
					foreach($get_data as $getdata)
					{	
						$this->loadModel('PageTemplateRowsColumn');
						$get_data1 = $this->PageTemplateRowsColumn->findAllByRowId($getdata['PageTemplateRow']['id']);
						
							foreach($get_data1 as $getdata1)
							{
								//echo $getdata1['PageTemplateRowsColumn']['row_id'];
								$this->PageTemplateRowsColumn->delete(
								array( 'PageTemplateRowsColumn.id' => $getdata1['PageTemplateRowsColumn']['id'])   //condition
								);
							}
						
						$this->PageTemplateRow->delete(
						array('PageTemplateRow.id' => $getdata['PageTemplateRow']['id'])   //condition
						); 
					}
					$deleteflag = $this->PageTemplate->delete($id);
					
					
					$this->Session->setFlash('<p>Templates removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
				} else {
					$this->Session->setFlash(
					'<p>Failed to remove Tab!</p>', 'default', array('class' => 'alert alert-danger'));
					break;
				}
			}
			$this->redirect($this->referer());	
		}
}
?>