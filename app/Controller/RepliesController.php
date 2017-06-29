<?php 
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');

class RepliesController extends AppController 
{
	public $name = 'Replies';
	public $components = array();
	public $helpers = array();
	public $uses = array();
	public $paginate = array();

	public function beforeFilter() 
	{
		parent::beforeFilter();
		
		$this->Auth->allow('ajaxPostreply');
		
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
		
		$this->Reply->bindModel(
			array(
				'belongsTo' => array(
					'PostComment' => array(
						'className'    => 'PostComment',
						'foreignKey'   => 'comment_id',
						'fields'	   => 'id,comment'
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
				'order' => array('Reply.id'=>'DESC')
				);
		$data=$this->paginate('Reply'); //pr($data); exit();
		$this->set('data', $data);
	}
	
	public function admin_delete($id=NULL) {
			
		$this->layout = '';
		$this->autoRender = false;
		
		$deleteFlag = $this->Reply->delete($id);
		if($deleteFlag){
			$this->Session->setFlash('Reply deleted successfully!', 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('Failed to delete the reply', 'default', array('class' => 'alert alert-danger'));
		}
		$this->redirect($this->referer());
		
	}
	
	public function admin_status($id,$stat='Y')
	{	
		$this->layout = 'adminInner';
		$this->Reply->bindModel(
			array(
				'belongsTo' => array(
					'PostComment' => array(
						'className'    => 'PostComment',
						'foreignKey'   => 'comment_id',
						'fields'	   => 'id,comment'
					),
					'Member' => array(
						'className'    => 'Member',
						'foreignKey'   => 'user_id',
						'fields'	   => 'id,username,name,email_id'
					),
				)
			)
		);
		
		if(!empty($id)){
			$comment = $this->Reply->findById($id);
			//$siteSettings = ClassRegistry::init("SiteSetting")->find('first');
			
			if(!empty($comment['Reply']['first_time'])){
				
				$this->Reply->id = $id;
				$data['Reply']['status'] = $stat;
				$data['Reply']['first_time'] = 0;
				$data['Reply']['modified_date'] = date('Y-m-d');
				$statusFlag = $this->Reply->save($data);
				
				/* if($statusFlag){
					$body="Thank you for your valuable comment to this post.";
					$subject="Comment Approved For The Post ".ucwords($comment['Post']['post_title']);
					$Email_BU = new CakeEmail();
					
					$Email_BU->viewVars(array(
						'base_url' => SITE_URL,
						'contact_person' => ($comment['Member']['name']!="")?$comment['Member']['name']:$comment['Member']['username'],
						'body_text' => $body
					));
					$statusFlag = $Email_BU->template('', '')
						->emailFormat('html')
						->from(array($siteSettings['SiteSetting']['contact_email'] => 'CMS '))
						->to($comment['Member']['email_id'])
						->subject($subject)
						->send();
				} */
			} else {
				$this->Reply->id = $id;
				$data['Reply']['status'] = $stat;
				//date_default_timezone_set('Asia/Calcutta');
				$data['Reply']['modified_date'] = date('Y-m-d');
				$statusFlag = $this->Reply->save($data);
			}
			
			if($statusFlag)	{
				$this->Session->setFlash('Reply status changed successful', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to changed the Reply status', 'default', array('class' => 'alert alert-danger'));
			}
			
		} else {
			$this->Session->setFlash('There is something missing in database', 'default', array('class' => 'alert alert-danger'));
		}
		$this->redirect($this->referer());
	}
	
	public function admin_deleteAll($idAll=NULL)
	{	
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			
			$deleteFlag = $this->Reply->delete($id);
			
			if($deleteFlag){
				$this->Session->setFlash('The Reply has been successfully removed!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete the Reply!', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	
	public function ajaxPostreply()
	{
		$this->layout = 'ajax';
		
		if($this->request->is("post")){
			$data = $this->request->data;
			
			$recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.SECRET_KEY.'&response='.$data['g-recaptcha-response']);
			$response = json_decode($recaptcha);
			
			if($response->success){
				if(!empty($data['Reply'])){
					$data['Reply']['first_time'] = '1';
					$data['Reply']['status'] = 'N';
					date_default_timezone_set('Asia/Calcutta');
					$data['Reply']['reply_date'] = date('Y-m-d H:i:s');
					$this->Reply->create();
					$flag = $this->Reply->save($data);
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