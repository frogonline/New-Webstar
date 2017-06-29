<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
class PricingTableTypesController extends AppController {

	public $name = 'PricingTableTypes';
	public $components = array();
	public $helpers = array('Html', 'Form', 'Js'=>'Jquery');
	public $uses = array('PricePlanType','planFeature');
	public $paginate = array();

	public function beforeFilter() 
	{
		parent::beforeFilter();
		
		$this->Auth->allow('','','');
		
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
		$this->loadModel('Style');
			$this->paginate=array(
					'limit' => PAGINATION_PER_PAGE_LIMIT,
					'conditions'=>array('PricePlanType.isdel'=>'0'),
					'order'=>array('PricePlanType.id' => 'DESC')
					);
			
		
		$stylesArr = $this->Style->find('list', array(
				'conditions'=>array(
					'Style.group_id'=>39
				),
				'fields'=>array(
					'widgetstyle_name', 'name'
				)
			)
		);
		$data= $this->paginate('PricePlanType');
		$this->set(compact('data', 'stylesArr'));
		
	}
	
	public function admin_manage($id=NULL){
		$this->layout = 'adminInner';
		$this->loadModel('Style');
		$this->loadModel('PricePlan');
		$this->PricePlan->bindModel(array(
									'hasMany' => array(
										'PlanFeature' => array(
												'className'    => 'PlanFeature',
												'foreignKey'   => 'plan_id',
												
											),
										
									)
								));
		$planfeaturesArr=array();	
		$finalarray=array();
		$planfeaturesArr=array();	
		if($this->request->is("post")){
			$data = $this->request->data;
			if($id != ''){
				$this->PricePlanType->id = $id;
				$data['PricePlanType']['date_modified'] = date("Y-m-d");
			} else{
				$data['PricePlanType']['date_created'] = date("Y-m-d");
				$this->PricePlanType->create();
			}
			if(!empty($data['PricePlanType']['category'])){
            $selectedarray=$data['PricePlanType']['category'];
			
			for($i=0;$i<=(count($selectedarray)-1);$i++)
			{
			  if($selectedarray[$i]!='')
			  {
			    $finalarray[]=$selectedarray[$i];
			  }
			}
			}
			if(!empty($finalarray)){
			$data['PricePlanType']['category'] = implode(",",$finalarray);
			}
			else{
				$data['PricePlanType']['category']='';
			}
			$flag = $this->PricePlanType->save($data);
			$saveId = $this->PricePlanType->id;
			$this->loadModel('PlanFeature');
				$resultplanpriceid=$this->PricePlan->findAllByPricingId($saveId);
				$styleassign=$data['PricePlanType']['style'] ;
				foreach($resultplanpriceid as $planfeval){
				if($styleassign=='style2')
				{
					foreach($planfeval['PlanFeature'] as $planfevalll){
				
					if(!in_array($planfevalll['category_name'],$finalarray)){
						
						$this->PlanFeature->delete($planfevalll['id']);
					}
					} 
				}
				foreach($finalarray as $kkey=>$values){
					$countrowplanfe=$this->PlanFeature->find('count',array(
																'conditions'=>array('PlanFeature.plan_id'=>$planfeval['PricePlan']['id'],'PlanFeature.category_name'=>$values)
																));
					if($countrowplanfe==0){
						$planfeaturesArr['PlanFeature']['plan_id']=$planfeval['PricePlan']['id'];
						$planfeaturesArr['PlanFeature']['plan_type_id']=$saveId;
						$planfeaturesArr['PlanFeature']['feature_description']='';
						$planfeaturesArr['PlanFeature']['category_name']=$values;
						$this->PlanFeature->create();
						$this->PlanFeature->save($planfeaturesArr);
					}
					
				}
			}

			if($flag){
				if(!empty($id)){
					$this->Session->setFlash('<p>Price Plan Type updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
				} else{
					$this->Session->setFlash('<p>Price Plan Type added successfully!</p>', 'default', array('class' => 'alert alert-success'));
				}
			} else {
				$this->Session->setFlash('Failed to add accordion', 'default', array('class' => 'alert alert-danger'));
			}
			
			if($flag)
			{
				$this->loadModel('Shortcode');
				$checkdata = $this->Shortcode->find('count',array(
						'conditions'=>array(
							'Shortcode.name'=>'PricePlanType',
							'Shortcode.widget_id'=>$saveId
						)
					)
				);
				if($checkdata==0)
				{
					$styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['PricePlanType']['style'], 39);
					$savedata['Shortcode']['controller'] 	= 'PricingTableTypes';
					$savedata['Shortcode']['action']		= 'manage';
					$savedata['Shortcode']['widget_id'] 	= $saveId;
					$savedata['Shortcode']['widget_title'] 	= $data['PricePlanType']['name'];
					$savedata['Shortcode']['name'] 			= 'PricePlanType';
					$savedata['Shortcode']['group_id'] 		= 39;
					$savedata['Shortcode']['style_id'] 		= $styleData['Style']['id'];
					$this->Shortcode->create();
					
					$this->Shortcode->save($savedata);
				} else {
					$styleData = $this->Style->findByWidgetstyleNameAndGroupId($data['PricePlanType']['style'], 39);
					$scdata = $this->Shortcode->findByNameAndWidgetId('PricePlanType',$saveId);
					$this->Shortcode->id=$scdata['Shortcode']['id'];
					$savedata['Shortcode']['controller'] 	= 'PricingTableTypes';
					$savedata['Shortcode']['action']		= 'manage';
					$savedata['Shortcode']['widget_id'] 	= $saveId;
					$savedata['Shortcode']['widget_title'] 	= $data['PricePlanType']['name'];
					$savedata['Shortcode']['name'] 			= 'PricePlanType';
					$savedata['Shortcode']['group_id'] 		= 39;
					$savedata['Shortcode']['style_id'] 		= $styleData['Style']['id'];
				
					$this->Shortcode->save($savedata);
				}	
			}
			
			if(array_key_exists('continue', $data)){
				$this->redirect(array('controller'=>'PricingTableTypes','action'=>'admin_manage/'.$saveId));
			} else {
				$this->redirect(array('controller'=>'PricingTableTypes','action'=>'admin_index'));
			}
			
		}
		
		$stylesArr = $this->Style->find('list', array(
				'conditions'=>array(
					'Style.group_id'=>39
				),
				'fields'=>array(
					'widgetstyle_name', 'name'
				)
			)
		);
		$this->set('id', $id);
	 	if($id != NULL || $id != ''){
			$this->loadModel('PricePlanType');
			
			$this->PricePlanType->bindModel(array(
									'hasMany' => array(
										'PricePlan' => array(
												'className'    => 'PricePlan',
												'foreignKey'   => 'pricing_id',
												
											),
										
									)
								));
			
			$data = $this->PricePlanType->findById($id);
			if(!empty($data)){
				$accordionStyle = $this->Style->findByGroupIdAndWidgetstyleName(39,$data['PricePlanType']['style']);
			} else {
				$accordionStyle = array();
			}
			
			$this->loadModel('PricePlan');
			$totalcou = $this->PricePlan->find('count',array(
					'conditions'=>array(
						'PricePlan.pricing_id'=>$id
					)
				)
			);
			$this->set(compact('data','accordionStyle','totalcou'));
			
		} 
		
		$this->set(compact('stylesArr'));
		 
		    $this->loadModel('style');
		    $pricingdata=$this->style->find('all', array(
					'order'=>array('style.id ASC'),
					'fields'=>array('style.widgetstyle_name', 'style.style_img','style.name'),
					'conditions'=>array('style.group_id'=>39)
				)
			);
			
		    $this->set('pricingdata',$pricingdata);
		
	}


	
	public function admin_boxmanage(){
		$this->layout = 'ajax';
		$this->set('id', $this->request->data['id']);
		$this->set('style', $this->request->data['style']);
		$this->set('box_id', $this->request->data['box_id']);
		$data = $this->PricePlanType->findById($this->request->data['box_id']);
		$this->set('data_category',$data);
		$this->loadModel('PricePlan');
		if($this->request->data['id'] != ''){			
			
			$data12 = $this->PricePlan->findById($this->request->data['id']);
			$this->set('data1',$data12);
		}
	}
	
	public function admin_feature(){
		$this->layout = 'ajax';
		$this->loadModel('PlanFeature');
		$this->set('id', $this->request->data['id']);
		$this->set('style', $this->request->data['style']);
		$this->set('box_id', $this->request->data['box_id']);
		$data = $this->PricePlanType->findById($this->request->data['box_id']);
		
		$this->set('data_category',$data);
		if($this->request->data['id'] != ''){			
			$data122 = $this->PlanFeature->find('all',array('conditions'=>
															array('plan_id'=>$this->request->data['id'])));
			$this->set('data12',$data122);
		}
	}
	public function admin_boxplandelete(){
		$this->layout = 'ajax';
		$this->autoRender = false;
		$this->loadModel('PlanFeature');
		$deleteFlag = $this->PlanFeature->delete($this->request->data['idvalwe']);
		if($deleteFlag){
			echo "1";
			exit;
		}
		else{
			echo "0";
			exit;
		}
		
	}
	
	
	
	public function admin_boxmanageupdatefeature($b_id,$id=NULL){
		$this->layout = '';
		$this->autoRender = false;
		$this->loadModel('PlanFeature');
		$this->loadModel('PricePlanType');
		$datasave=array();	
		$data = $this->request->data;
		if($this->request->is("post")){
		
			if($data['PlanFeature']['identify']=='identify')
			{
				$data = $this->request->data;
				$i=0;
				foreach($data as $dataval)
				{
					
					foreach($dataval['feature_description'] as $datavalr)
					{
						
						if(!empty($dataval['id'][$i]))
						{
							$datasave['PlanFeature']['id']=$dataval['id'][$i];
						}else if(empty($dataval['id'][$i]))
						{
							$datasave['PlanFeature']['id']='';
						}
						$datasave['PlanFeature']['plan_id']=$id;
						$datasave['PlanFeature']['plan_type_id']=$b_id;
						
						$datasave['PlanFeature']['feature_description']=$datavalr;
						 if(!empty($datasave['PlanFeature']['id']))
						{
							$this->PlanFeature->save($datasave);
						}
						else if(empty($datasave['PlanFeature']['id']))
						{
							$this->PlanFeature->create();
							$this->PlanFeature->save($datasave);
						} 
			
						$i++;
					}
					
				}
				
				if(!empty($data['PlanFeature']['id'])){
					$this->Session->setFlash('<p>Plan Feature updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
				} else{
					$this->Session->setFlash('<p>Plan Feature added successfully!</p>', 'default', array('class' => 'alert alert-success'));
				}
			}
			else if(empty($data['PlanFeature']['identify']))
			{
			$data = $this->request->data;
			$datacategory = $this->PricePlanType->findById($b_id);
			$categoryval = explode(",",$datacategory['PricePlanType']['category']);
			$i=0;
			foreach($data as $dataval)
			{
				//pr($dataval);
				if(empty($dataval['id'])){
					foreach($dataval['feature_description'] as $dataval1){
						$datasave['PlanFeature']['feature_description']=$dataval1;
						$datasave['PlanFeature']['plan_id']=$id;
						$datasave['PlanFeature']['plan_type_id']=$b_id;
						$datasave['PlanFeature']['category_name']=$categoryval[$i];
						$this->PlanFeature->create();
						$this->PlanFeature->save($datasave);
					}
				}
				if(!empty($dataval['id']))
				{
					foreach($dataval['feature_description'] as $dataval11){
					$this->PlanFeature->id = $dataval['id'][$i];
					$datasave['PlanFeature']['feature_description']= $dataval11;
					$datasave['PlanFeature']['plan_id']=$id;
					$datasave['PlanFeature']['plan_type_id']=$b_id;
					$datasave['PlanFeature']['category_name']=$categoryval[$i];
					$this->PlanFeature->save($datasave);
					$i++;
					}
				}
			}
			if(!empty($data['PlanFeature']['id'])){
					$this->Session->setFlash('<p>Plan Feature updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
				} else{
					$this->Session->setFlash('<p>Plan Feature added successfully!</p>', 'default', array('class' => 'alert alert-success'));
				}
			}
		}
		$this->redirect('/admin/PricingTableTypes/manage/'.$b_id);
		
	
	}
	
	public function admin_boxmanageupdate($b_id,$style,$id=NULL){
		$this->layout = 'adminInner';
		$this->loadModel('PricePlan');
		if($this->request->is("post")){
			
			if($id != ''){
				$this->PricePlan->id = $id;
				$data1['PricePlan']['date_modified'] = date("Y-m-d");
			} else{
				$data1['PricePlan']['date_created'] = date("Y-m-d");
				$this->PricePlan->create();
			}
			
			$data = $this->request->data;
			$return =  $this->PricePlan->save($data);
			if($return['PricePlan']['id'] != ''){
				$this->Session->setFlash('<p>Price Plan Content updated successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else{
				$this->Session->setFlash('<p>Price Plan Content added successfully!</p>', 'default', array('class' => 'alert alert-success'));
			}
			$this->redirect('/admin/PricingTableTypes/manage/'.$b_id);
			
		}
		
		
		$this->set('id', $id);
		if($id != NULL || $id != ''){
			$this->loadModel('PricePlanType');
			
			$this->PricePlanType->bindModel(array(
									'hasMany' => array(
										'PricePlan' => array(
												'className'    => 'PricePlan',
												'foreignKey'   => 'pricing_id'
											)
									)
								));
			
			$data = $this->PricePlanType->findById($id);
			$this->set('data',$data);
		}
	}
	
	
	
	
	public function admin_delete($id=NULL, $isdel='0')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$this->loadModel('PricePlan');
		$this->loadModel('PlanFeature');
		$deleteFlag = $this->PricePlanType->delete($id);
		$deleteFlag1 = $this->PricePlan->deleteAll(array('PricePlan.pricing_id' => $id), false);
		$deleteFlag1 = $this->PlanFeature->deleteAll(array('PlanFeature.plan_type_id' => $id), false);
		if($deleteFlag)
		{
				
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('PricePlanType',$id);
				//pr($get_data); exit;
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
		}
		
		$this->Session->setFlash('<p>Price Plan details has been deleted successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect($this->referer());	
	}
	
	public function admin_boxcontentdelete($id=NULL, $menu=NULL)
	{
		$this->layout = '';
		$this->autoRender = false;
		$this->loadModel('PricePlan');
		$this->loadModel('PlanFeature');
		$this->PricePlan->delete($id);
		$this->PlanFeature->deleteAll(array('PlanFeature.plan_id' =>$id), false);
		$this->Session->setFlash('<p>Pricing Table Contents removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
		$this->redirect('/admin/PricingTableTypes/manage/'.$menu);
	}
	
	public function admin_deleteAll($idAll=NULL,$stat = '1')
	{	
		
		$idArr = explode(',',$idAll);
		$this->layout = '';
		$this->autoRender = false;
		$this->loadModel('PricePlan');
		$this->loadModel('PlanFeature');
		$this->loadModel('PricePlanType');
		$this->loadModel('Shortcode');
		foreach($idArr as $id){
			$deleteFlag = $this->PricePlanType->delete($id);
			$this->PricePlan->deleteAll(array('PricePlan.pricing_id' => $id), false);
			$this->PlanFeature->deleteAll(array('PlanFeature.plan_type_id' =>$id), false);
			if($deleteFlag){
				$this->loadModel('Shortcode');
				$get_data = $this->Shortcode->findByNameAndWidgetId('PricePlanType',$id);
				$delete = $this->Shortcode->delete($get_data['Shortcode']['id']);
				$this->Session->setFlash('<p>Price Plan removed successfully!</p>', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash(
				'<p>Price Plan removed successfully!</p>', 'default', array('class' => 'alert alert-danger'));
				break;
			}
		}
		$this->redirect($this->referer());	
	}
	
	
	public function admin_status($id=NULL,$stat = 'N')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['PricePlanType']['status'] = $stat;
		
		$this->PricePlanType->id = $id;
		$this->PricePlanType->save($data);
		$this->Session->setFlash('<p>Price Plan updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
	
	public function admin_selectstyle()
	{
	echo "ok";
	
		/* $this->layout = "ajax";
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			
			$this->loadModel('Widgetgroup');
			$widgetgroup_dropdown = $this->Widgetgroup->find('list', array(
					'order'=>array('Widgetgroup.name ASC', 'Widgetgroup.id ASC'),
					'fields'=>array('Widgetgroup.id', 'Widgetgroup.name'),
					'conditions'=>array('Widgetgroup.is_active'=>'Y')
				)
			);
			//pr($shortcodeArr); exit;
			$this->set(compact('reqdata', 'widgetgroup_dropdown'));
		} */
		
	}
	
	public function admin_saveastemplate(){
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$data = $this->request->data;
			if(!empty($data['tplId'])){
				$tpldata = $this->PageTemplate->findById($data['tplId']);
			} else {
				$tpldata = array();
			}
			$this->set(compact('data','tpldata'));
		}
	}
	

}
?>