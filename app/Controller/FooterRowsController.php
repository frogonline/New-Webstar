<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class FooterRowsController extends AppController 
{
	
	public $name = 'FooterRows';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('FooterRow', 'FooterColumn', 'Shortcode');
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
	
	public function admin_index() {
		$this->layout = 'adminInner';
		
		$this->FooterRow->bindModel(
			array(
				'hasMany'=>array(
					'FooterColumn'=>array(
						'className'=>'FooterColumn',
						'foreignKey'=>'row_id',
						'order'=>array('FooterColumn.sort_order ASC')
					)
				)
			)
		);
			
		$footerBlocks = $this->FooterRow->find('first'); //pr($footerBlocks); exit();
		$this->set(compact('footerBlocks'));
	}
	
	public function admin_managecolumn(){
		$this->layout = "ajax";
		
		if($this->request->is("post")){
			$reqdata = $this->request->data;
			
			$data = $this->FooterColumn->findById($reqdata['colId']);
			$this->set(compact('data', 'reqdata'));
			
		}
	}
	
	public function admin_columnsubmit($id = NULL){
		$this->layout = "ajax";
		
		if($this->request->is("post")){
			$data = $this->request->data;
			
			if(!empty($id)){
				$this->FooterColumn->id = $id;
			} else {
				$this->FooterColumn->create();
			}
			
			$flag = $this->FooterColumn->save($data);
			
			echo ($flag)?1:0; exit();
		}
	}
	
	public function admin_ajaxtplpreview(){
		$this->layout = "ajax";
		
		if($this->request->is("post")){
			$reqdata = $this->request->data;
			
			if(!empty($reqdata)){
				$this->FooterRow->bindModel(
					array(
						'hasMany'=>array(
							'FooterColumn'=>array(
								'className'=>'FooterColumn',
								'foreignKey'=>'row_id',
								'order'=>array('FooterColumn.sort_order ASC')
							)
						)
					)
				);
					
				$footerBlocks = $this->FooterRow->findById(1); //pr($footerBlocks); exit();
				$this->set(compact('footerBlocks'));
			}
		}
	}
	
	public function admin_deletecolumn(){
		$this->layout = "ajax";
		
		if($this->request->is("post")){
			$reqdata = $this->request->data;
			
			if(!empty($reqdata['colId'])){
				$flag = $this->FooterColumn->delete($reqdata['colId']);
				echo ($flag)?1:0; exit();
			}
		}
	}
}
?>
