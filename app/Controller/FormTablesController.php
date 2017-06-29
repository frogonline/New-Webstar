<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class FormTablesController extends AppController 
{
	public $name = 'FormTables';
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
		
		
		$this->paginate=array(
			'limit' => 10,
			'order'=>array('FormTable.id' => 'DESC')
		);
			
		$data=$this->paginate('FormTable'); //pr($data); exit();
		$this->set('data', $data);
		//pr($data);exit;
	}
	
	public function admin_manage($id=NULL){	
		$this->layout = 'adminInner';
		
		/**** Saving Data ****/
		if($this->request->is('post')){
			if($this->FormTable->validates()){
				$reqdata = $this->request->data;
				
				if(!empty($id)){
					$this->FormTable->id = $id;
				} else {
					$this->FormTable->create();
				}
				
				$saveFlag = $this->FormTable->save($reqdata);
				
				if($saveFlag){
					$saveId = $this->FormTable->id;
					
					$fl = $this->pushToShortcode($saveId, $reqdata['FormTable']['name']);
					if($id != ''){
						$this->Session->setFlash('Form updated successfully.', 'default', array('class' => 'alert alert-success'));
					} else{
						$this->Session->setFlash('Form added successfully', 'default', array('class' => 'alert alert-success'));
					}
				} else {
					$this->Session->setFlash('Failed to save the Form', 'default', array('class' => 'alert alert-danger'));
				}
				if(array_key_exists('continue', $reqdata)){
					$this->redirect(array('controller'=>'FormTables','action'=>'admin_manage/'.$saveId));
				} else {
					$this->redirect(array('controller'=>'FormTables','action'=>'admin_index'));
				}
				
			} else {
				$this->set('errors', $this->Product->invalidFields());
			}
		}
		
		/**** Saving Data ****/
		
		
		/**** Fetching Data ****/					
		if(!empty($id)){
			$data = $this->FormTable->findById($id);
			
			$this->set(compact('data'));
		}
		$this->set(compact('id'));
		/**** Fetching Data ****/
	}
	
	public function admin_showrecord($id=NULL){	
		$this->layout = 'adminInner';
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
		$formalldataArr = $this->FormSaveRecord->find('all', array(
									'conditions'=>array('FormSaveRecord.form_id'=>$id),
									'order'=>array('FormSaveRecord.id DESC')
								)
							);
		$this->set(compact('formalldataArr'));
	}
	
	private function pushToShortcode($widgetId, $widgetTitle){
		if(!empty($widgetId)){
			$checkdata = $this->Shortcode->find('count',array(
					'conditions'=>array(
						'Shortcode.name'=>'Form',
						'Shortcode.widget_id'=>$widgetId
					)
				)
			);
			
			if($checkdata == 0){
				$data['Shortcode']['controller'] = 'FormTables';
				$data['Shortcode']['action'] = 'admin_manage';
				$data['Shortcode']['widget_id'] = $widgetId;
				$data['Shortcode']['name'] = 'Form';
				$data['Shortcode']['widget_title'] = $widgetTitle;
				$data['Shortcode']['group_id'] = 35;
				$data['Shortcode']['style_id'] = 80;
				
				$fl = $this->Shortcode->save($data);
				if($fl){
					return true;
				} else {
					return false;
				}
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	
	public function admin_setting($id){
		$this->layout = 'adminInner';
		
		if(!empty($id)){
			$formToolList = $this->FormTool->find('all', array(
					'conditions'=>array(
						'FormTool.form_id'=>$id
					),
					'order'=>array('FormTool.sort_order'=>'ASC')
				)
			);
			
			$this->set(compact('id', 'formToolList'));
		} else {
			$this->Session->setFlash('There is no form with this id', 'default', array('class' => 'alert alert-danger'));
			$this->redirect(array('controller'=>'FormTables','action'=>'admin_index'));
		}
	}
	
	public function admin_ajaxtb(){
		$this->layout = 'ajax';
		
		$id = '';
		$formid = '';
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			$formid = $reqdata['formId'];
			//pr($reqdata); exit();
			if(!empty($reqdata['toolId'])){
				$id = $reqdata['toolId'];
				$data = $this->FormTool->findById($reqdata['toolId']);
			} else {
				$data = array();
			}
		} else {
			$data = array();
		}
		
		$this->set(compact('id', 'formid', 'data'));
	}
	
	public function admin_ajaxta(){
		$this->layout = 'ajax';
		
		$id = '';
		$formid = '';
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			$formid = $reqdata['formId'];
			//pr($reqdata); exit();
			if(!empty($reqdata['toolId'])){
				$id = $reqdata['toolId'];
				$data = $this->FormTool->findById($reqdata['toolId']);
			} else {
				$data = array();
			}
		} else {
			$data = array();
		}
		
		$this->set(compact('id', 'formid', 'data'));
	}
	
	public function admin_ajaxpw(){
		$this->layout = 'ajax';
		
		$id = '';
		$formid = '';
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			$formid = $reqdata['formId'];
			//pr($reqdata); exit();
			if(!empty($reqdata['toolId'])){
				$id = $reqdata['toolId'];
				$data = $this->FormTool->findById($reqdata['toolId']);
			} else {
				$data = array();
			}
		} else {
			$data = array();
		}
		
		$this->set(compact('id', 'formid', 'data'));
	}
	
	public function admin_ajaxei(){
		$this->layout = 'ajax';
		
		$id = '';
		$formid = '';
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			$formid = $reqdata['formId'];
			//pr($reqdata); exit();
			if(!empty($reqdata['toolId'])){
				$id = $reqdata['toolId'];
				$data = $this->FormTool->findById($reqdata['toolId']);
			} else {
				$data = array();
			}
		} else {
			$data = array();
		}
		
		$this->set(compact('id', 'formid', 'data'));
	}
	
	public function admin_ajaxaddrow(){
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$data = $this->request->data;
			
			$this->set(compact('data'));
		}
	}
	
	public function admin_ajaxsb(){
		$this->layout = 'ajax';
		
		$id = '';
		$formid = '';
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			$formid = $reqdata['formId'];
			//pr($reqdata); exit();
			if(!empty($reqdata['toolId'])){
				$id = $reqdata['toolId'];
				$this->FormTool->bindModel(
					array(
						'hasMany'=>array(
							'FormToolOption'=>array(
								'className'=>'FormToolOption',
								'foreignKey'=>'tool_id'
							)
						)
					)
				);
				$data = $this->FormTool->findById($reqdata['toolId']);
				
				$datamax =$this->FormToolOption->find('first', array('conditions' => array(
												'tool_id' =>$reqdata['toolId']), 
												'order' => array('id' => 'DESC') ));
				//pr($datamax); exit();
			} else {
				$data = array();
			}
		} else {
			$data = array();
		}
		
		$this->set(compact('id', 'formid', 'data','datamax'));
	}
	
	public function admin_ajaxrb(){
		$this->layout = 'ajax';
		
		$id = '';
		$formid = '';
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			$formid = $reqdata['formId'];
			//pr($reqdata); exit();
			if(!empty($reqdata['toolId'])){
				$id = $reqdata['toolId'];
				$this->FormTool->bindModel(
					array(
						'hasMany'=>array(
							'FormToolOption'=>array(
								'className'=>'FormToolOption',
								'foreignKey'=>'tool_id'
							)
						)
					)
				);
				$data = $this->FormTool->findById($reqdata['toolId']);
				
			} else {
				$data = array();
			}
		} else {
			$data = array();
		}
		
		$this->set(compact('id', 'formid', 'data'));
	}
	
	
	public function admin_ajaxfile(){
		$this->layout = 'ajax';
		
		$id = '';
		$formid = '';
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			$formid = $reqdata['formId'];
			//pr($reqdata); exit();
			if(!empty($reqdata['toolId'])){
				$id = $reqdata['toolId'];
				$this->FormTool->bindModel(
					array(
						'hasMany'=>array(
							'FormToolOption'=>array(
								'className'=>'FormToolOption',
								'foreignKey'=>'tool_id'
							)
						)
					)
				);
				$data = $this->FormTool->findById($reqdata['toolId']);
				
			} else {
				$data = array();
			}
		} else {
			$data = array();
		}
		
		$this->set(compact('id', 'formid', 'data'));
	}
	
	
	public function admin_ajaxcb(){
		$this->layout = 'ajax';
		
		$id = '';
		$formid = '';
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			$formid = $reqdata['formId'];
			//pr($reqdata); exit();
			if(!empty($reqdata['toolId'])){
				$id = $reqdata['toolId'];
				$this->FormTool->bindModel(
					array(
						'hasMany'=>array(
							'FormToolOption'=>array(
								'className'=>'FormToolOption',
								'foreignKey'=>'tool_id'
							)
						)
					)
				);
				$data = $this->FormTool->findById($reqdata['toolId']);
				
			} else {
				$data = array();
			}
		} else {
			$data = array();
		}
		
		$this->set(compact('id', 'formid', 'data'));
	}
	
	public function admin_sortitem(){
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$data = $this->request->data;
			$fitems=json_decode($data['fstring']);
			//pr($mitems);
			
			$flag=$this->item_update($fitems);
			if($flag){
				echo 1;
			}
			else{
				echo "Try Later";
			}
			
			exit();
		}
		
	}
	
	private function item_update($fitems){
		$c=1;
		foreach($fitems as $fitem){
			$val['FormTool']['sort_order']=$c;
			$this->FormTool->id=$fitem->id;
			$flag = $this->FormTool->save($val);
			$c++;
		}
		
		return $flag;
	}
	
	public function admin_itemdelete($itemid = NULL, $formId = NULL){
		$this->layout = '';
		$this->autoRender = false;
		
		if(!empty($itemid) && !empty($formId)){
			$dltflg = $this->FormTool->delete($itemid);
			
			if($dltflg){
				$this->FormToolOption->deleteAll(array('tool_id'=>$itemid));
				$this->Session->setFlash('Item deleted successfully.', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete item.', 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$this->Session->setFlash('Failed to delete item.', 'default', array('class' => 'alert alert-danger'));
		}
		$this->redirect(array('controller'=>'FormTables', 'action'=>'admin_setting/'.$formId));
	}
	
	public function admin_addtool($formid = NULL, $id=NULL){
		$this->layout = '';
		$this->autoRender = false;
		
		if($this->request->is('post')){
			$saveData = $this->request->data;
			//pr($saveData); exit();
			if(!empty($id)){
				$this->FormTool->id = $id;
			} else {
				$this->FormTool->create();
			}
			
			$fl = $this->FormTool->save($saveData);
			$toolId = $this->FormTool->id;
			
			if($fl){
				if(array_key_exists('FormToolOption', $saveData)){
					$flg = $this->saveOpt($saveData['FormToolOption'], $toolId); 
				}
				
				$this->Session->setFlash('Tool added to form successfully', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to add tool to form', 'default', array('class' => 'alert alert-danger'));
			}
			$this->redirect(array('controller'=>'FormTables','action'=>'admin_setting/'.$formid));
		}
	}
	
	private function saveOpt($optArr, $toolId){
		
		if(array_key_exists('option_value', $optArr)){
			if(!empty($optArr['option_value'])){
				if(array_key_exists('id',$optArr)){
					foreach($optArr['id'] as $optId){
						$this->FormToolOption->id = $optId;
						$saveData['FormToolOption']['tool_id'] = $toolId;
						$saveData['FormToolOption']['option_value'] = $optArr['option_value'][$optId];
						
						$this->FormToolOption->save($saveData);
						$saveData['FormToolOption'] = array();
						unset($optArr['option_value'][$optId]);
					}
				}
				
				if(!empty($optArr['option_value'])){
					foreach($optArr['option_value'] as $optval){
						$this->FormToolOption->create();
						$saveData['FormToolOption']['tool_id'] = $toolId;
						$saveData['FormToolOption']['option_value'] = $optval;
						
						$this->FormToolOption->save($saveData);
						$saveData['FormToolOption'] = array();
					}
					
				}
				
			}
		}
		
	}

	public function admin_tooloptdlt()
	{	
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$data = $this->request->data;
			$deleteFlag = $this->FormToolOption->delete($data['optId']);
			
			if($deleteFlag){
				echo 1; exit();
			} else {
				echo 0; exit();
			}
		}
	}

	public function admin_delete($id=NULL)
	{	
		$this->layout = '';
		$this->autoRender = false;
		
		$deleteFlag = $this->FormTable->delete($id);
		
		if($deleteFlag){
			$dltShortcodeFlag = $this->Shortcode->deleteAll(array('Shortcode.widget_id'=>$id, 'Shortcode.name'=>'Form'));
			if($dltShortcodeFlag){
				$this->Session->setFlash('The Form has been successfully removed!', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('The Form has been successfully removed! But failed to delete the slug.', 'default', array('class' => 'alert alert-danger'));
			}
			
		} else {
			$this->Session->setFlash('The Form has been successfully removed!', 'default', array('class' => 'alert alert-danger'));
		}
		$this->redirect($this->referer());	
	}
	
	public function admin_deleteAll($idAll=NULL)
	{	
		//pr($id); exit();
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
			$deleteFlag = $this->FormTable->delete($id);
		
			if($deleteFlag){
				$dltShortcodeFlag = $this->Shortcode->deleteAll(array('Shortcode.widget_id'=>$id, 'Shortcode.name'=>'Form'));
				if($dltShortcodeFlag){
					$this->Session->setFlash('The Form has been successfully removed!', 'default', array('class' => 'alert alert-success'));
				} else {
					$this->Session->setFlash('The Form has been successfully removed! But failed to delete the slug.', 'default', array('class' => 'alert alert-danger'));
				}
				
			} else {
				$this->Session->setFlash('The Form has been successfully removed!', 'default', array('class' => 'alert alert-danger'));
			}
		}
		$this->redirect($this->referer());	
	}
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['FormTable']['status'] = $stat;
		
		$this->FormTable->id = $id;
		$updateFlag = $this->FormTable->save($data);
		
		if($updateFlag){
			$this->Session->setFlash('Form status changed successfully!', 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('Failed to change status!', 'default', array('class' => 'alert alert-danger'));
		}
		$this->redirect($this->referer());
	}
	
public function saveform($id=NULL){
		$this->layout = '';
		$this->autoRender = false;
		$Path=array();
		$str = '';
		if(!empty($id)){
			$formData = $this->FormTable->findById($id);
		
			if($this->request->is('post')){
				
			$reqdata = $this->request->data;
				
		if(!empty($reqdata)){
		
			$keyArr = array_keys($reqdata['FormTable']);
			$Path='';	
			$j=1;
		foreach($keyArr as $key){
			$toolArr = explode('-', $key);
			if(!empty($toolArr)){
			$toolDetail = $this->FormTool->findById($toolArr[1], array('label','tool_type','multiple_flag'));
			$val = (is_array($reqdata['FormTable'][$key]))?implode(', ', $reqdata['FormTable'][$key]):$reqdata['FormTable'][$key];
			
			if($toolDetail['FormTool']['tool_type']!='IMG'){
		$str .= $toolDetail['FormTool']['label'].' : '.$val.'<br />';
		}
		
		if($toolDetail['FormTool']['tool_type']=='IMG' && $toolDetail['FormTool']['multiple_flag']=='N')
		{
			$imgdata=$reqdata['FormTable'][$key];
			
			$Path=array(WWW_ROOT."img/uploads/form_image/".$imgdata['name']);
			
			$fileName=$imgdata['name'];
			
			move_uploaded_file($imgdata['tmp_name'], WWW_ROOT . 'img/uploads/form_image/' . $fileName);
	
			
		}
		if($toolDetail['FormTool']['tool_type']=='IMG' && $toolDetail['FormTool']['multiple_flag']=='Y')
		{
		
				$imgdata=$reqdata['FormTable'][$key];
				if($j==1)
				{
				$i=1;
				}else {
				$i=$i;
				}
				$len=sizeof($reqdata['FormTable'][$key]);
				
				foreach($imgdata as $imgdatas)
				{
					move_uploaded_file($imgdatas['tmp_name'], WWW_ROOT . 'img/uploads/form_image/' . $imgdatas['name']);
					
					$Path[$i]=WWW_ROOT."img/uploads/form_image/".$imgdatas['name'];
				
					$i++;
				}
				$i=$i;
		
		}
	}
	$j++;
}
}
//pr($Path);             
		
				
				if(!empty($formData)){
					if($formData['FormTable']['delivery_method']=='E'){
						$setting = $this->Session->read('siteSettings');
						$Email = new CakeEmail();
						if(!empty($Path)){
						$fl = $Email->from(array($setting['SiteSetting']['admin_email'] => $setting['SiteSetting']['meta_title']))
							->attachments($Path)
							->to($formData['FormTable']['delivery_email'])
							//->cc('money@smallbizloans.com.au')
							->emailFormat('html')
							->subject($formData['FormTable']['delivery_email_subject'])
							->send($str);
							}else {
						$fl = $Email->from(array($setting['SiteSetting']['admin_email'] => $setting['SiteSetting']['meta_title']))
							->to($formData['FormTable']['delivery_email'])
							->cc('money@smallbizloans.com.au')
							->emailFormat('html')
							->subject($formData['FormTable']['delivery_email_subject'])
							->send($str);
						
						}
					} else {
						$this->FormSaveRecord->create();
						$saveData['FormSaveRecord']['form_id'] = $id;
						$saveData['FormSaveRecord']['form_content'] = $str;
						$saveData['FormSaveRecord']['submit_date'] = date('Y-m-d');
						$fl = $this->FormSaveRecord->save($saveData);
						$saveId = $this->FormSaveRecord->id;
						
						foreach($Path as $key=>$val)
						{
							
							$imagenamepat=end(explode('/',$val));
							$this->FormImage->create();
							$saveData['FormImage']['form_id'] = $id;
							$saveData['FormImage']['form_save_id'] = $saveId;
							$saveData['FormImage']['image_name'] = $imagenamepat;
							$this->FormImage->save($saveData);
						}
					}
					
					if($fl){
						$this->Session->setFlash($formData['FormTable']['submit_message'], 'default', array('class' => 'alert alert-success'));
					} else {
						$this->Session->setFlash('Failed to submit your information. Please try again later.', 'default', array('class' => 'alert alert-danger'));
					}
					$this->redirect($formData['FormTable']['redirect_url']);
				} else {
					$this->Session->setFlash('Failed to submit your information. Please try again later.', 'default', array('class' => 'alert alert-danger'));
					$this->redirect($this->referer());
				}
			}
		} else {
			$this->Session->setFlash('Failed to submit your information. Please try again later.', 'default', array('class' => 'alert alert-danger'));
			$this->redirect($this->referer());
		}
	}
}
?>