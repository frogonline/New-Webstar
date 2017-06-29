<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
class PostCommentsController extends AppController 
{
	public $name = 'PostComments';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	//public $uses = array('Post','PostCategory');
	public $paginate = array();

	public function beforeFilter() 
	{
	
		parent::beforeFilter();
		
		$this->Auth->allow('commentgiven', 'ajaxPostcomment');
		
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
		
		$this->PostComment->bindModel(
			array(
				'belongsTo' => array(
					'Post' => array(
						'className'    => 'Post',
						'foreignKey'   => 'post_id',
						'fields'	   => 'id,post_title'
					),
					'Member' => array(
						'className'    => 'Member',
						'foreignKey'   => 'user_id',
						'fields'	   => 'id,username,name'
					),
				)
			)
		);
		
		$this->paginate=array(
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order' => array('PostComment.id'=>'DESC')
				);
		$data=$this->paginate('PostComment'); //pr($data); exit();
		$this->set('data', $data);
		/* pr($data);
		exit; */
	} 
	
	public function admin_delete($id=NULL)
	{	
		$this->layout = '';
		$this->autoRender = false;
		
		$deleteFlag = $this->PostComment->delete($id);
		if($deleteFlag){
			$this->Session->setFlash('Comment deleted successfully!', 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('Failed to delete the comment', 'default', array('class' => 'alert alert-danger'));
		}
		$this->redirect($this->referer());	
	}
	
	public function admin_status($id,$stat='Y')
	{	
		$this->layout = 'adminInner';
		
		if(!empty($id) && !empty($stat)){
			$this->PostComment->id = $id;
			$data['PostComment']['status'] = $stat;
			$data['PostComment']['first_time'] = 0;
			
			$saveFlag = $this->PostComment->save($data);
			
			if($saveFlag){
				$this->Session->setFlash('Status changed successfully!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to changed status', 'default', array('class' => 'alert alert-success'));
			}
		} else {
			$this->Session->setFlash('Failed to get correct request', 'default', array('class' => 'alert alert-success'));
		}
		$this->redirect($this->referer());
	}
	
	public function admin_deleteAll($idAll=NULL)
	{	
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			
			$deleteFlag = $this->PostComment->delete($id);
			
			if($deleteFlag){
				$this->Session->setFlash('The post comment has been successfully removed!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete the post comment!', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	
	
	public function ajaxPostcomment($slug=NULL)
	{
		$this->layout = 'ajax';
		
		if($this->request->is("post")){
			$data = $this->request->data;
			
			$recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.SECRET_KEY.'&response='.$data['g-recaptcha-response']);
			$response = json_decode($recaptcha);
			
			if($response->success){
				if(!empty($data['PostComment'])){
					$data['PostComment']['first_time'] = '1';
					$data['PostComment']['status'] = 'N';
					date_default_timezone_set('Asia/Calcutta');
					$data['PostComment']['comment_date'] = date('Y-m-d H:i:s');
					$this->PostComment->create();
					$flag = $this->PostComment->save($data);
					if($flag){
						echo 5; exit();
					} else {
						echo 4; exit();
					}
				} else {
					echo 3;
					exit();
				}
			} else {
				echo 2;
				exit();
			}
		} else {
			echo 1;
			exit();
		}	
	}
	
}
?>