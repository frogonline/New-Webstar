<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
class SocialWidgetsController extends AppController {

	public $name = 'SocialWidgets';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('SocialWidget','Style');
	public $paginate = array();
	
	public function beforeFilter() 
	{
		parent::beforeFilter();
		
		$this->Auth->allow('admin_forget','admin_recovery','admin_reset');
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
		
		$data = $this->SocialWidget->find('all', array(
				'conditions'=>array(
					'SocialWidget.isdel'=>'0'
				),
				'order' => array('SocialWidget.sort_order'=>'ASC')
			)
		);
		//pr($data); exit();
		$this->set('data', $data);
	}
	
	public function admin_iconedit(){
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			
			$data = $this->SocialWidget->findById($reqdata['id']);
			$this->set(compact('data'));
		}
	}
	
	public function admin_iconeditformsubmit($id=NULL){
		if($this->request->is('post')){
			if(!empty($id)){
				$data = $this->request->data;
				
				$this->SocialWidget->id = $id;
				$saveFlag = $this->SocialWidget->save($data);
				
				echo ($saveFlag)?1:0; exit();
			} else {
				echo 2; exit();
			}
		}
		exit();
	}
	
	public function admin_sortitem(){
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$data = $this->request->data;
			$sitems=json_decode($data['sstring']);
			//pr($mitems);
			
			$flag=$this->item_update($sitems);
			if($flag){
				echo 1;
			}
			else{
				echo "Try Later";
			}
			
			exit();
		}
		
	}
	
	private function item_update($sitems){
		$c=1;
		foreach($sitems as $sitem){
			$val['SocialWidget']['sort_order']=$c;
			$this->SocialWidget->id=$sitem->id;
			$flag = $this->SocialWidget->save($val);
			$c++;
		}
		return $flag;
	}
		
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['SocialWidget']['status'] = $stat;
		
		$this->SocialWidget->id = $id;
		$this->SocialWidget->save($data);
		$this->Session->setFlash('<p>Social Widget updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
}