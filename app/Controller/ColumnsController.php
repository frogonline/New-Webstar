<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class ColumnsController extends AppController {

	public $name = 'Columns';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('Column','Style');
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
			
			$likekeyArr = array('column_name');
			$titlekeyArr = array('column_style');
			$conditionArr = array();
			foreach($data['Column'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$likekeyArr) ){
						$conditionArr['Column.'.$k.' LIKE'] = '%'.$v.'%';
					} else if (in_array($k,$titlekeyArr)) {
							$conditionArr['Column.'.$k.' LIKE'] = '%'.$v.'%';
						} else {
							$conditionArr['Column.'.$k] = $v; 
						}
					}
				}
			
			$conditionArr['Column.isdel'] = 0;
			$this->paginate = array(
				'conditions' =>array($conditionArr,'Column.isdel'=>'0'),
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Column.id' => 'DESC')
			);
			$this->set('searchData',$data);
			
		} else {
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('Column.isdel'=>'0'),
					'order'=>array('Column.id' => 'DESC')
					);
			
		}
		$stylesArr = $this->Style->find('list', array(
				'conditions'=>array(
					'Style.group_id'=>5
				),
				'fields'=>array(
					'widgetstyle_name', 'name'
				)
			)
		);
		$data = $this->paginate('Column');
		
		
		$this->set(compact('data', 'stylesArr'));
		
		
	}
	
	public function admin_manage($id=NULL){
		$this->layout = 'adminInner';
		if($this->request->is("post")){
			
			if($id != ''){
				$this->Column->id = $id;
				$this->request->data['Column']['date_modified'] = date("Y-m-d");
			} else{
				$this->request->data['Column']['date_created'] = date("Y-m-d");
				$this->Column->create();
			}
			
			$data = $this->request->data;
			/* pr($data);
			exit; */
			
			$saveFlag =  $this->Column->save($data);
			$saveId = $this->Column->id;

				if($saveFlag){
					if($id != ''){
						$this->Session->setFlash('<p>Column updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
					} else{
						$this->Session->setFlash('<p>Column added successfully!</p>', 'default', array('class' => 'alert alert-success'));
					}
				} else {
					$this->Session->setFlash('Failed to save the Column', 'default', array('class' => 'alert alert-danger'));
				}
			if($data['Column']['status']=='Y')
			{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Column',$saveId);
			
				if(empty($get_data))
				{
					$styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['Column']['column_style'], 5);
					$data['Shortcode']['controller'] 	= 'Columns';
					$data['Shortcode']['action']		= 'manage';
					$data['Shortcode']['widget_id'] 	= $saveId;
					$data['Shortcode']['widget_title'] 	= $data['Column']['column_name'];
					$data['Shortcode']['name'] 			= 'Column';
					$data['Shortcode']['group_id'] 		= 5;
					$data['Shortcode']['style_id'] 		= $styleData['Style']['id'];
					$this->Shortcode->create();
					
					$this->Shortcode->save($data);
				} else {
					$styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['Column']['column_style'], 5);
					$scdata = $this->Shortcode->findByNameAndWidgetId('Column',$saveId);
					$this->Shortcode->id = $scdata['Shortcode']['id'];
					$savedata['Shortcode']['controller'] 	= 'Columns';
					$savedata['Shortcode']['action']		= 'manage';
					$savedata['Shortcode']['widget_id'] 	= $saveId;
					$savedata['Shortcode']['widget_title'] 	= $data['Column']['column_name'];
					$savedata['Shortcode']['name'] 			= 'Column';
					$savedata['Shortcode']['group_id'] 		= 5;
					$savedata['Shortcode']['style_id'] 		= $styleData['Style']['id'];
				
					$this->Shortcode->save($savedata);
				}	
			}
			
			if(array_key_exists('continue', $data)){
					$this->redirect(array('controller'=>'Columns','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'Columns','action'=>'admin_index'));
				}
			//$this->redirect(array('controller'=>'Columns','action'=>'admin_index'));
			
		}
		
		$stylesArr = $this->Style->find('list', array(
				'conditions'=>array(
					'Style.group_id'=>5
				),
				'fields'=>array(
					'widgetstyle_name', 'name'
				)
			)
		);
		//pr($stylesArr); exit();
		$this->set('stylesArr', $stylesArr);
		
		$this->set('id', $id);
		if($id != NULL || $id != ''){
			$this->loadModel('Column');
			$data = $this->Column->findById($id);
			
			if(!empty($data)){
				$widgetStyle = $this->Style->findByGroupIdAndWidgetstyleName(5,$data['Column']['column_style']);
			} else {
				$widgetStyle = array();
			}
			$this->set(compact('data','widgetStyle'));
		}
		
		$this->loadModel('style');
		$column_styledata=$this->style->find('all', array(
				'order'=>array('style.id ASC'),
				'fields'=>array('style.widgetstyle_name', 'style.style_img','style.name'),
				'conditions'=>array('style.group_id'=>5)
			)
		);
		//pr($column_styledata); exit;
		$this->set('column_styledata',$column_styledata);
		
	}
	
	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Column']['isdel'] = $isdel; 
		$this-> Column->id = $id;
		$deleteFlag = $this->Column->save($data);
		
		if($deleteFlag)
		{
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('Column',$id);
				//pr($get_data); exit;
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
		}
		
		$this->Session->setFlash('<p>Column details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Column']['status'] = $stat;
		
		$this->Column->id = $id;
		$this->Column->save($data);
		$this->Session->setFlash('<p>Column updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$data = $this->Column->findById($id);
			
			$data['Column']['isdel'] = $stat;
			$this->Column->id = $id;
			$deleteFlag = $this->Column->save($data);
			
			if($deleteFlag){
			
			$this->loadModel('Shortcode');
			$get_data = $this->Shortcode->findByNameAndWidgetId('Column',$id);
			//pr($get_data);
			$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
			
				$this->Session->setFlash('<p>Column removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Column removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	

}
?>