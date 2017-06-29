<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class ResponsesController extends AppController 
{
	public $name = 'Responses';  
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('FormTable','FormImage', 'FormTool', 'FormToolOption', 'FormSaveRecord', 'Shortcode', 'Style');
	public $paginate = array();

	public function beforeFilter()  
	{
		parent::beforeFilter();
		
		$this->Auth->allow('saveform');
		
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
		$formrecord=array();
		
		$data=$this->FormTable->find('all', array(
								'conditions'=>array('FormTable.status'=>'Y')));
		
		$this->FormSaveRecord->bindModel(
					array(
						'hasMany'=>array(
							'FormImage'=>array(
								'className'    => 'FormImage',
								'foreignKey'   => 'form_save_id',
							)
						)
					)
				);
		
		foreach($data as $datas)
		{
			$this->FormSaveRecord->bindModel(
					array(
						'hasMany'=>array(
							'FormImage'=>array(
								'className'    => 'FormImage',
								'foreignKey'   => 'form_save_id',
							)
						)
					)
				);
			$formrecord[$datas['FormTable']['name']]= $this->FormSaveRecord->find('all', array(
								'conditions'=>array('FormSaveRecord.form_id'=>$datas['FormTable']['id']),
									'order'=>array('FormSaveRecord.id DESC')
								)
							);
							
		
		}
		/* pr($formrecord);
		exit; */
		$this->set(compact('formrecord'));
	}
	
	
	
	public function admin_delete($id=NULL)
	{	
		$this->layout = '';
		$this->autoRender = false;
		
		$deleteFlag = $this->FormSaveRecord->delete($id);
		
		if($deleteFlag){
				
				$dataimage=$this->FormImage->find('all', array(
								'conditions'=>array('FormImage.form_save_id'=>$id)));
				
				$dltShortcodeFlag = $this->FormImage->deleteAll(array('FormImage.form_save_id'=>$id));
				foreach($dataimage as $dataimages){
				$original_path=SITE_URL.'img/uploads/form_image/'.$dataimages['FormImage']['image_name'];
				unlink($original_path);
				}
		} 
		$this->Session->setFlash('The Form Responses has been successfully removed!', 'default', array('class' => 'alert alert-success'));
		
		$this->redirect($this->referer());	
	}
	
	
	
}
?>