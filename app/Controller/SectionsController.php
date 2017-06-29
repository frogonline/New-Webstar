<?php
App::uses('CakeEmail','Network/Email');
App::uses('File','Utility');
App::uses('SimpleImage','Utility');
class SectionsController extends AppController
{
	public $name  = 'Sections';
	public $components = array();
	public $helpers = array('Html','Form','Js'=>'Jquery');
	public $uses = array();
	public $paginate = array();
	
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow();
		
		if(isset($this->request->params['users']))
		{
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
			$likekeyArr = array('title');
			$equalArr   = array('status');
			$datekeyArr = array('created_time', 'updated_time');
			$conditionArr = array();
			foreach($data['Section'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['Section.'.$k.' LIKE'] = '%'.$v.'%';
					}
					elseif(in_array($k,$equalArr)) {
						$conditionArr['Section.'.$k.''] = ''.$v.'';
					}
					 else {
						if(in_array($k,$datekeyArr)){
							$conditionArr['Section.'.$k] = date('Y-m-d',strtotime($v)); 
						} else {
							$conditionArr['Section.'.$k] = $v; 
						}
					}
				}
			}
			$conditionArr['Section.is_del'] = 0; 
			$data = $this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Section.sort_order' => 'DESC')
			);
			$this->set('data',$data);

		}
		else
		{
		$this->paginate = array(
								'limit' => PAGINATION_PER_PAGE_LIMIT,
								'conditions' => array('Section.isdel'=>'0'),
								'order' => array('Section.sort_order'=>'DESC')
								);
		$data	=	$this->paginate('Section');
		$this->set('data',$data);
		
		}
		
		
	}
	public function admin_manage($id=NULL)
	{
		$this->layout = "adminInner";
		$this->loadModel('Pages');
		if ($this->request->is('post')) 
		{	
			
			$this->Section->set($this->request->data);
			
			
			if($this->Section->validates()) 
			{
				
				
				
				if($this->request->data['Section']['id'] !== ''){
					$this->Section->id = $id;
					$update_section['title']			=	$this->request->data['Section']['title'];
					$update_section['description']		=	$this->request->data['Section']['description'];
					$update_section['section_css']		=	$this->request->data['Section']['section_css'];
					$update_section['section_js']		=	$this->request->data['Section']['section_js'];
					$update_section['sort_order']		=	$this->request->data['Section']['sort_order'];
					$update_section['status']			=	$this->request->data['Section']['status'];
					$update_section['updated_time']		=	Date('Y-m-d');
					$this->Section->save($update_section);
					
				} else{
					
					$insert_section['title']			=	$this->request->data['Section']['title'];
					$insert_section['description']		=	$this->request->data['Section']['description'];
					$insert_section['section_css']		=	$this->request->data['Section']['section_css'];
					$insert_section['section_js']		=	$this->request->data['Section']['section_js'];
					$insert_section['sort_order']		=	$this->request->data['Section']['sort_order'];
					$insert_section['status']			=	$this->request->data['Section']['status'];
					$insert_section['created_time']		=	Date('Y-m-d');
					
					$this->Section->create();
					$this->Section->save($insert_section);
					
				}
		
				
				
				if($this->request->data['Section']['id'] !== ''){
					$this->Session->setFlash('<p>Section Updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
					
				} else{
					$this->Session->setFlash('<p>Section added successfully!</p>', 'default', array('class' => 'alert alert-success'));
					
				}
				$this->redirect('/admin/Sections/index');
			} 
		}
		
		$this->set('id', $id);
		if($id !== NULL || $id !== ''){
			$data = $this->Section->findById($id);
			
			$pagelist = $this->Pages->find('list',array(
											'fields' => array('Pages.id','Pages.title'),
											'conditions' => array('Pages.is_active'=>'Y','Pages.is_del'=>'0'),
											'order' => array('Pages.title' => 'ASC')
										));
			$this->set(compact('data','pagelist'));
		}
		if(!$id)
		{
			$data	=	$this->request->data;
			$pagelist = $this->Pages->find('list',array(
											'fields' => array('Pages.id','Pages.title'),
											'conditions' => array('Pages.is_active'=>'Y','Pages.is_del'=>'0'),
											'order' => array('Pages.title' => 'ASC')
										));
			$this->set(compact('data','pagelist'));
		}
	}
	
	public function add_section()
	{
		$this->layout = 'ajax';
		
		$this->loadModel('Pages');
		
		$pagelist = $this->Pages->find('list',array(
											'fields' => array('Pages.id','Pages.title'),
											'conditions' => array('Pages.is_active'=>'Y','Pages.is_del'=>'0'),
											'order' => array('Pages.title' => 'ASC')
										));
		$statusArr = array('CONFIRM'=>'Confirm','REJECT'=>'Reject');
		$position = array('TOP'=>'Top','BOTTOM'=>'Bottom','LEFT'=>'Left','RIGHT'=>'Right');
		$column   = array('SINGLE'=>'Single','DOUBLE'=>'Double');
		$this->set(compact('pagelist','statusArr','position','column'));
		$this->render();
		
	}
	public function admin_delete($id=NULL,$stat = '1')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Section']['is_del'] = $stat;
		$this->Section->id = $id;
		$this->Section->save($data);
		
		$this->loadModel('SectionPages');
		$this->SectionPages->deleteAll(array('SectionPages.section_id'=>$section_id),false);
		
		$this->Session->setFlash('<p>The Section has been successfully removed!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
}
?>