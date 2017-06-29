<?php
class ManageModulesController extends AppController
{
	public $name = 'ManageModules';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array();
	var $paginate;
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		
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
		$this->layout	=	"adminInner";
		$this->loadModel('Menu');
		
		$this->paginate = array(
								'limit' => PAGINATION_PER_PAGE_LIMIT,
								'order' => array('Menu.menu_id'=>'ASC')
								);
		$data	=	$this->paginate('Menu');
		
		$this->set('data',$data);
	}
	public function admin_status($id=NULL,$is_active='')
	{
		$this->layout		=	'';
		$this->autoRender	=	false;
		$this->loadModel('Menu');
		$data	=	$this->Menu->find('list',array('conditions'=>array('Menu.menu_id'=>$id)));
		if(empty($data))
		{
			$update_menu['is_active']	=	$is_active;
			$this->Menu->id				=	$id;
			$this->Menu->save($update_menu);
		}
		else
		{
			$update_menu['is_active']	=	$is_active;
			$this->Menu->id				=	$id;
			$this->Menu->save($update_menu);
			foreach($data as $key=>$value)
			{
				$update_menu['is_active']	=	$is_active;
				$this->Menu->id				=	$key;
				$this->Menu->save($update_menu);
			}
		}
		$this->Session->setFlash('<p><strong>Success:&nbsp;</strong>The Menu has been successfully updated!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
}
?>