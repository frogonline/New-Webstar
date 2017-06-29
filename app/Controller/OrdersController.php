<?php 
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('SimpleImage', 'Utility');
App::uses('EwayPayment', 'Utility');
class OrdersController extends AppController 
{
	public $name = 'Orders';
	public $components = array();
	public $helpers = array();
	public $uses = array('Order', 'OrderDetail', 'OrderDetailOption', 'Cart', 'CartOption', 'Product', 'Member', 'Country', 'State', 'City');
	public $paginate = array();

	public function beforeFilter() 
	{
		parent::beforeFilter();
		
		$this->Auth->allow('checkout', 'ajaxstate', 'ajaxcity', 'ajaxshippingstate', 'ajaxshippingcity', 'ajaxstep2', 'ajaxstep3', 'ajaxstep4', 'ajaxstep5', 'ajaxstep6', 'ajaxordersubmit', 'payment', 'pay', 'cancel','admin_editdeliverystatus','admin_deliverystatusupdate','ajaxbillingstate','ajaxbillingcity','viewallproduct','admin_invoice','emailcheching','Paypalipnerror','success');
		
		if(isset($this->request->params['users'])){
			$this->Security->requireSecure();			
		}
		$this->Security->blackHoleCallback = 'blackhole';
	}
    
	public function blackhole($type) {
	
		// handle errors.
	}
	
	public function admin_index(){
		$this->layout = 'adminInner';
        
        $citymodel = ClassRegistry::init('City');
			$city = $citymodel->find('list',
				array(
					'conditions' => array('City.isdel'=>'0'),
					'fields'=>'City.City'
				)
			); 
        
        $statemodel = ClassRegistry::init('State');
			$state = $statemodel->find('list',
				array(
					'conditions' => array('State.isdel'=>'0'),
					'fields'=>'State.State'
				)
			);  
        
        $countrymodel = ClassRegistry::init('Country');
			$country = $countrymodel->find('list',
				array(
					'conditions' => array('Country.isdel'=>'0'),
					'fields'=>'Country.Country'
				)
			); 
        	if($this->request->is("post"))
			{ 
			$data = $this->request->data;
		
			
			
			$email_idArr = array('email_id');
			$conditionArr = array();
			foreach($data['Order'] as $k => $v){
				if( ($v != NULL) ){
					if( in_array($k,$email_idArr) ){
						$conditionArr['Order.'.$k.' LIKE'] = '%'.$v.'%';
						} 
					}
				}
		
			$conditionArr['Order.isdel'] = 0; 
			
			$this->paginate = array(
				'conditions' => $conditionArr,
				'limit' => PAGINATION_PER_PAGE_LIMIT,
				'order'=>array('Page.id' => 'DESC')
			);
			$this->set('searchData',$data);

		} else {
        $this->paginate = array(
								'conditions' => array('Order.isdel'=>'0'),
								'order' => array('Order.id'=>'DESC'),
								'limit' => PAGINATION_PER_PAGE_LIMIT
							);	
			}
		$data = $this->paginate('Order'); 
		//pr($data);
        $this->set(compact('data', 'city','state','country')); 
		
	   }
    
	
	public function admin_manage($id=NULL)
	{
		$this->layout = 'adminInner';
		 $this->loadModel('OrderDetailOption');
		 $this->loadModel('OptionValue');
		 $this->loadModel('ProductOption');
		 
         $optionvalArr =array();
		 $this->OrderDetail->bindModel(array(
							'hasMany'=>array(
								'OrderDetailOption'=>array(
									'className'=>'OrderDetailOption',
									'foreignKey'=>'order_detail_id'
								)
							)
						));
        $citymodel = ClassRegistry::init('City');
			$city = $citymodel->find('list',
				array(
					'conditions' => array('City.isdel'=>'0'),
					'fields'=>'City.City'
				)
			); 
        
        $statemodel = ClassRegistry::init('State');
			$state = $statemodel->find('list',
				array(
					'conditions' => array('State.isdel'=>'0'),
					'fields'=>'State.State'
				)
			);  
        
        $countrymodel = ClassRegistry::init('Country');
			$country = $countrymodel->find('list',
				array(
					'conditions' => array('Country.isdel'=>'0'),
					'fields'=>'Country.Country'
				)
			); 
        
        $data = $this->Order->find('all',
                                     array('conditions'=>array('Order.isdel'=>0,
                                                              'Order.id' => $id)
                                          ));
        //pr($data); exit;
        $member = ClassRegistry::init('Member');
        $find =  $member->find('all', 
                              array('conditions'=>array(
                              'Member.isdel'=>0,
                                'Member.id' => $data[0]['Order']['user_id']
                              )));
        
        foreach($data as $datas)
        {
        $order = ClassRegistry::init('OrderDetail');
        $order_detail =  $order->find('all', 
                              array('conditions'=>array(
                              'OrderDetail.order_id'=>$datas['Order']['id'] 
                              )
                            ));
        }
        
      
		
		  $i=1;
		
	
         $pro =array();
		
        foreach($order_detail as $order_details)
        {
           
        $product = ClassRegistry::init('Product');
        $pro[$order_details['OrderDetail']['product_id']] =  $product->findByIdAndIsdel($order_details['OrderDetail']['product_id'],0);
		
			foreach($order_details['OrderDetailOption'] as $order_detailoption)
			{
				$this->OptionValue->bindModel(array(
					'belongsTo'=>array(
						'ProductOption'=>array(
							'className'=>'ProductOption',
							'foreignKey'=>'option_id'
						)
					)
				)
			);
			
				$optionvalArr[$order_details['OrderDetail']['product_id']][$i]=$this->OptionValue->findById($order_detailoption['option_value_id']);
				$i++;
			}
		
		
        }
		
        
        foreach($pro as $prodct){
            $pro_op = ClassRegistry::init('ProductAssignOption');
            $prodet = $pro_op->find('all', array('conditions'=>array(
                                'ProductAssignOption.product_id' => $prodct['Product']['id'])));
       // pr($prodet); exit;
        }
        
        $product_op = ClassRegistry::init('ProductOption');
            $productoption = $product_op->find('list', array('conditions'=>array(
                                'ProductOption.is_del' => 0,
                                ),
                                                                'fields' => array('ProductOption.options_name')
                            ));
            
             $op_val = ClassRegistry::init('OptionValue');
            $option_val = $op_val->find('list', array('conditions'=>array(
                                'OptionValue.is_del' => 0,
                                ),
                                                       'fields' => array('OptionValue.option_value_name')
                            ));
  
        $this->set(compact('data', 'city','state','country','find','order_detail','pro','prodet','productoption','option_val','optionvalArr'));
		
	}
	
	 public function admin_invoice($id=NULL)
		{
$this->layout = 'adminInner_invoice';		
		  $this->loadModel('OrderDetailOption');
		 $this->loadModel('OptionValue');
		 $this->loadModel('ProductOption');
		 
		
		$this->OrderDetail->bindModel(array(
							'hasMany'=>array(
								'OrderDetailOption'=>array(
									'className'=>'OrderDetailOption',
									'foreignKey'=>'order_detail_id'
								)
							)
						));
		
		
        $citymodel = ClassRegistry::init('City');
			$city = $citymodel->find('list',
				array(
					'conditions' => array('City.isdel'=>'0'),
					'fields'=>'City.City'
				)
			); 
        
        $statemodel = ClassRegistry::init('State');
			$state = $statemodel->find('list',
				array(
					'conditions' => array('State.isdel'=>'0'),
					'fields'=>'State.State'
				)
			);  
        
        $countrymodel = ClassRegistry::init('Country');
			$country = $countrymodel->find('list',
				array(
					'conditions' => array('Country.isdel'=>'0'),
					'fields'=>'Country.Country'
				)
			); 
        
        $data = $this->Order->find('all',
                                     array('conditions'=>array('Order.isdel'=>0,
                                                              'Order.id' => $id)
                                          ));
        //pr($data); exit;
        $member = ClassRegistry::init('Member');
       
        $optionvalArr =array();
        foreach($data as $datas)
        {
        $order = ClassRegistry::init('OrderDetail');
        $order_detail =  $order->find('all', 
                              array('conditions'=>array(
                              'OrderDetail.order_id'=>$datas['Order']['id'] 
                              )
                            ));
		
        }
		
		$i=1;
		
	
         $pro =array();
		
        foreach($order_detail as $order_details)
        {
           
        $product = ClassRegistry::init('Product');
        $pro[$order_details['OrderDetail']['product_id']] =  $product->findByIdAndIsdel($order_details['OrderDetail']['product_id'],0);
		
			foreach($order_details['OrderDetailOption'] as $order_detailoption)
			{
				$this->OptionValue->bindModel(array(
					'belongsTo'=>array(
						'ProductOption'=>array(
							'className'=>'ProductOption',
							'foreignKey'=>'option_id'
						)
					)
				)
			);
			
				$optionvalArr[$order_details['OrderDetail']['product_id']][$i]=$this->OptionValue->findById($order_detailoption['option_value_id']);
				$i++;
			}
		
		
        }
		//pr($optionvalArr);
		
        
        
      
        
        $product_op = ClassRegistry::init('ProductOption');
            $productoption = $product_op->find('list', array('conditions'=>array(
                                'ProductOption.is_del' => 0,
                                ),
                                                                'fields' => array('ProductOption.options_name')
                            ));
            
             $op_val = ClassRegistry::init('OptionValue');
          
  
        $this->set(compact('data', 'city','state','country','order_detail','pro','productoption','optionvalArr'));
		
		}
    
    public function admin_status($id=NULL,$stat = 'P')
	{	
		$this->layout = '';
		$this->autoRender = false;
		$data['Order']['order_status'] = $stat;
		
		$this->Order->id = $id;
		$this->Order->save($data);
		$this->Session->setFlash('<p>Order updated successfully!</p>', 'default', array('class' => 'alert alert-success'));

		$this->redirect($this->referer());
		exit();
	}
    
	 public function admin_deliver_status($id=NULL)
	 {	
		$this->layout = 'ajax';
		$this->Order->id = $id;
		$data=array();
		$result = $this->Order->find('list', 
                              array(
							  'conditions'=>array('Order.id'=>$id),
							  'fields'=>'Order.delivery_status'
							  ));
		
		 if($result[$id]=='Y')
		{
				$data['Order']['delivery_status']='N';
				$this->Order->id = $id;
		        $saveFlag = $this->Order->save($data);
				echo "N";
				exit();
		}
		else
		{
				$data['Order']['delivery_status']='Y';
				$this->Order->id = $id;
		        $saveFlag = $this->Order->save($data);
				echo "Y";
				exit();
		}
		
		
	}
	
    public function admin_payment_status($id=NULL)
	{	
		$this->layout = 'ajax';
		$this->Order->id=$id;
		$result=$this->Order->find('list',array(
									'conditions'=>array('Order.id'=>$id),
									'fields'=>'Order.payment_status'
									));
		$data=array();
		if($result[$id]=='Y')
		{
		$data['Order']['payment_status']='N';
		$this->Order->id=$id;
		$saveflag=$this->Order->save($data);
		echo "N";
		exit;
		}
		else
		{
		$data['Order']['payment_status']='Y';
		$this->Order->id=$id;
		$saveflag=$this->Order->save($data);
		echo "Y";
		exit;
		}
	}
	
	public function admin_order_status($id=NULL)
	{	
		$this->layout = 'ajax';
		$this->Order->id=$id;
		$result=$this->Order->find('list',array(
									'conditions'=>array('Order.id'=>$id),
									'fields'=>'Order.order_status'
									));
		$data=array();
		if($result[$id]=='P')
		{
		$data['Order']['order_status']='S';
		$this->Order->id=$id;
		$saveflag=$this->Order->save($data);
		echo "S";
		exit;
		}
		else
		{
		$data['Order']['order_status']='P';
		$this->Order->id=$id;
		$saveflag=$this->Order->save($data);
		echo "P";
		exit;
		}
	}
	
	public function admin_delete($id){
		$this->layout = '';
		$this->autoRender = false;
		
		if(!empty($id)){
			$orderDetailId = $this->OrderDetail->find('list', array(
					'conditions'=>array('OrderDetail.order_id'=>$id),
					'fields'=>array('id')
				)
			);
			
			if(!empty($orderDetailId)){
				if(count($orderDetailId)==1){
					$this->OrderDetailOption->deleteAll(array('OrderDetailOption.order_detail_id'=>current($orderDetailId)));
				} else {
					$this->OrderDetailOption->deleteAll(array('OrderDetailOption.order_detail_id IN'=>$orderDetailId));
				}
			}
			$this->OrderDetail->deleteAll(array('OrderDetail.order_id'=>$id));
			$this->Order->delete($id);
			$this->Session->setFlash('Order deleted successfully', 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash('Failed to delete order', 'default', array('class' => 'alert alert-danger'));
		}
		$this->redirect(array('controller'=>'Orders', 'action'=>'admin_index'));
	}
	
	public function admin_deleteAll($idAll = NULL){
		$idArr = explode(',',$idAll); //pr($idArr); exit();
		$this->layout = '';
		$this->autoRender = false;
		
		foreach($idArr as $id){
		
			if(!empty($id)){
				$orderDetailId = $this->OrderDetail->find('list', array(
						'conditions'=>array('OrderDetail.order_id'=>$id),
						'fields'=>array('id')
					)
				);
				
				if(!empty($orderDetailId)){
					if(count($orderDetailId)==1){
						$this->OrderDetailOption->deleteAll(array('OrderDetailOption.order_detail_id'=>current($orderDetailId)));
					} else {
						$this->OrderDetailOption->deleteAll(array('OrderDetailOption.order_detail_id IN'=>$orderDetailId));
					}
				}
				
				$this->OrderDetail->deleteAll(array('OrderDetail.order_id'=>$id));
				$this->Order->delete($id);
				$this->Session->setFlash('Order deleted successfully', 'default', array('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('Failed to delete order', 'default', array('class' => 'alert alert-danger'));
			}
		}
		$this->redirect(array('controller'=>'Orders', 'action'=>'admin_index'));
	}
	
	public function checkout(){
		$this->theme = THEME_NAME;
		$this->layout = 'ecommerce_inner';
		$session_id = $this->Session->read('session_id');
		$cartArr = $this->Cart->findBySessionId($session_id);
		
		if(empty($cartArr))
		{
		   $this->redirect(array('controller'=>'Carts','action'=>'cart'));
		} 
		if($this->Session->read('loggedin_status')){
			$user_id = $this->Session->read('id');
			$user = $this->Member->findById($user_id);
			
			$countries = $this->Country->find('list', array(
					'conditions'=>array('Country.isdel'=>0),
					'fields'=>array('Country.id','Country.Country'),
					'order'=>array('Country.Country ASC')
				)
			);
			
			if(!empty($user['Member']['country'])){
				$states = $this->State->find('list', array(
						'conditions'=>array('State.CountryID'=>$user['Member']['country'], 'State.isdel'=>0),
						'fields'=>array('State.id','State.State'),
						'order'=>array('State.State ASC')
					)
				);
			}
			
			if(!empty($user['Member']['state'])){
				$cities = $this->City->find('list', array(
						'conditions'=>array('City.StateID'=>$user['Member']['state'], 'City.isdel'=>0),
						'fields'=>array('City.id','City.City'),
						'order'=>array('City.City ASC')
					)
				);
			}
			
			$this->set(compact('user', 'countries', 'states', 'cities'));
		}
	}
	
	public function ajaxstate(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			if(!empty($reqdata)){
				$states = $this->State->find('list', array(
						'conditions'=>array('State.CountryID'=>$reqdata['id'], 'State.isdel'=>0),
						'fields'=>array('State.id','State.State'),
						'order'=>array('State.State ASC')
					)
				);
				//pr($states); exit();
			}
			$this->set(compact('states'));
		}
	}
	
	public function ajaxcity(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			if(!empty($reqdata)){
				$cities = $this->City->find('list', array(
						'conditions'=>array('City.StateID'=>$reqdata['id'], 'City.isdel'=>0),
						'fields'=>array('City.id','City.City'),
						'order'=>array('City.City ASC')
					)
				);
			}
			$this->set(compact('cities'));
		}
	}
	
	
	
	public function ajaxbillingstate(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			if(!empty($reqdata)){
				$states = $this->State->find('list', array(
						'conditions'=>array('State.CountryID'=>$reqdata['id'], 'State.isdel'=>0),
						'fields'=>array('State.id','State.State'),
						'order'=>array('State.State ASC')
					)
				);
				//pr($states); exit();
			}
			$this->set(compact('states'));
		}
	}
	
	
	public function ajaxbillingcity(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			if(!empty($reqdata)){
				$cities = $this->City->find('list', array(
						'conditions'=>array('City.StateID'=>$reqdata['id'], 'City.isdel'=>0),
						'fields'=>array('City.id','City.City'),
						'order'=>array('City.City ASC')
					)
				);
			}
			$this->set(compact('cities'));
		}
	}
	
	public function ajaxshippingstate(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			if(!empty($reqdata)){
				$states = $this->State->find('list', array(
						'conditions'=>array('State.CountryID'=>$reqdata['id'], 'State.isdel'=>0),
						'fields'=>array('State.id','State.State'),
						'order'=>array('State.State ASC')
					)
				);
				//pr($states); exit();
			}
			$this->set(compact('states'));
		}
	}
	
	
	public function ajaxshippingcity(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$reqdata = $this->request->data;
			if(!empty($reqdata)){
				$cities = $this->City->find('list', array(
						'conditions'=>array('City.StateID'=>$reqdata['id'], 'City.isdel'=>0),
						'fields'=>array('City.id','City.City'),
						'order'=>array('City.City ASC')
					)
				);
			}
			$this->set(compact('cities'));
		}
	}
	
	public function ajaxstep2(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		$countries = $this->Country->find('list', array(
				'conditions'=>array('Country.isdel'=>0),
				'fields'=>array('Country.id','Country.Country'),
				'order'=>array('Country.Country ASC')
			)
		);
		
		if($this->request->is('post')){
			$data = $this->request->data;
			$this->set(compact('data', 'countries'));
		}
	}
	
	public function ajaxstep3(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		$countries = $this->Country->find('list', array(
				'conditions'=>array('Country.isdel'=>0),
				'fields'=>array('Country.id','Country.Country'),
				'order'=>array('Country.Country ASC')
			)
		);
		if($this->request->is('post')){
			$data = $this->request->data;
			$states = array();
			$cities = array();
			if(array_key_exists('sameas', $data['Order'])){
				$states = $this->State->find('list', array(
						'conditions'=>array(
							'State.CountryID'=>$data['Order']['country'],
							'State.isdel'=>0
						),
						'fields'=>array('State.id','State.State'),
					)
				);
				
				$cities = $this->City->find('list', array(
						'conditions'=>array(
							'City.StateID'=>$data['Order']['state'],
							'City.isdel'=>0
						),
						'fields'=>array('City.id','City.City')
					)
				);
			} else {
				$data = array();
			}
			$this->set(compact('data', 'countries', 'states', 'cities'));
		}
	}
	
	public function ajaxstep4(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$data = $this->request->data;
			$stateitem=$data['Order']['ship_state'];
			$shippingmodel = ClassRegistry::init('Shipping');
			$shipping = $shippingmodel->find('list',
				array(
					'conditions' => array('Shipping.isdel'=>'0','Shipping.status'=>'Y'),
					'fields' => array('Shipping.shipping_rate','Shipping.shipping_type')
				)
			);
			//echo $stateitem;
			$this->set(compact('shipping','stateitem'));
		}
		
	}
	
	public function ajaxstep5(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		$monthArr = array();
		$monthArr = array('1'=>'Jan', '2'=>'Feb', '3'=>'Mar', '4'=>'Apr', '5'=>'May', '6'=>'Jun', '7'=>'Jul', '8'=>'Aug', '9'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dec');
		
		$yearArr = array();
		$i = 0;
		while($i < 9){
			$year = date('Y', strtotime('+'.$i.' year'));
			$yearArr[$year]=$year;
			
			$i++;
		}
		$this->set(compact('monthArr', 'yearArr'));
	}
	
	public function ajaxstep6(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			$data = $this->request->data;
			$this->set(compact('data'));
			/* //$eway = new EwayPayment( '14959031', 'https://www.eway.com.au/gateway_cvn/xmlpayment.asp' ); // live
			$eway = new EwayPayment( '87654321', 'https://www.eway.com.au/gateway/xmltest/testpage.asp' ); // sandbox
			//Substitute 'FirstName', 'Lastname' etc for $_REQUEST["FieldName"] where FieldName is the name of your INPUT field on your webpage
			$eway->setCustomerFirstname( 'Suvojit' );
			$eway->setCustomerLastname( 'Seal' );
			$eway->setCustomerEmail( 'sseal@sdsoftware.in' );
			$eway->setCustomerAddress( '123 Someplace Street, Somewhere ACT' );
			$eway->setCustomerPostcode( '2609' );
			$eway->setCustomerInvoiceDescription( 'Purchase of Cake CMS Products' );
			$eway->setCustomerInvoiceRef( 'INV120394' );
			$eway->setCardHoldersName( 'Suvojit Seal' );
			$eway->setCardNumber( '4444333322221111' );
			$eway->setCardExpiryMonth( '08' );
			$eway->setCardExpiryYear( '2015' );
			$eway->setTrxnNumber( 'INV120394' );
			$eway->setTotalAmount( 1.00 );
		    $eway->setCVN( '123' ); 
			
			echo $eway->doPayment();
			echo '<br />';
			echo $eway->getAuthCode().'asd';
			echo '<br />';
			echo $eway->getError().'asd';
			echo '<br />';
			echo $eway->getErrorMessage().'asd';
			
			exit(); */
		}
	}
	
	public function ajaxordersubmit(){
		$this->theme = THEME_NAME;
		$this->layout = 'ajax';
		$flagArr = array();
		$dataproduct = array();
		
		if($this->request->is('post')){
			$data = $this->request->data;
			//pr($data); exit();
			if(!empty($data)){
				
				if($data['Order']['mode']=='register'){
					list($reguserid, $error) = $this->memberRegister($data);
					//echo $reguserid; exit();
					if($reguserid > 0){
						$data['Order']['user_id'] = $reguserid;
						
					} else {
						switch($error){
							case "insufficient_data":
								echo '6'.'-0'; break;
							case "already_exist":
								echo '7'.'-0'; break;
							case "database_error":
								echo '8'.'-0'; break;
							case "mail_error":
								echo '9'.'-0'; break;
						}
						exit();
					}
				}
				
				
				$data['Order']['order_date'] = date('Y-m-d H:i:s');
				$data['Order']['delivery_status'] = 'N';
				
				$data['Order']['order_status'] = 'S';
				$data['Order']['isdel'] = 0;
				$this->Order->create();
				$flag = $this->Order->save($data);
				
				if($flag){
					$order_id = $this->Order->id;
					$session_id = $this->Session->read('session_id');
					$this->Session->write('order_id', $order_id);
					
					$this->Cart->bindModel(array(
							'hasMany'=>array(
								'CartOption'=>array(
									'className'=>'CartOption',
									'foreignKey'=>'cart_id'
								)
							)
						)
					);
					
					if($this->Session->read('loggedin_status')){
						$user_id = $this->Session->read('id');
						$carts = $this->Cart->find('all', array(
								'conditions'=>array(
									'OR'=>array(
										'Cart.session_id'=>$session_id,
										'Cart.user_id'=>$user_id
									)
								)
							)
						);
					} else {
						$carts = $this->Cart->find('all', array(
								'conditions'=>array('Cart.session_id'=>$session_id)
							)
						);
					}
					
					$this->Session->write('carts', $carts);
					$this->Session->write('data', $data);
						
					foreach($carts as $item){
						$cols = $this->OrderDetail->schema();
						$columns = array_keys($cols);
						$saveData = array();
						$excludeKey = array('id');
						
						foreach($columns as $key){
							if($key == 'order_id'){
								$saveData['OrderDetail'][$key] = $order_id;
							} else {
								if(!in_array($key,$excludeKey)){
									$saveData['OrderDetail'][$key] = $item['Cart'][$key];
								}
							}
						}
						
						$this->OrderDetail->create();
						$f = $this->OrderDetail->save($saveData);
						
			$stockproduct= $this->Product->find('all', array(
								'conditions'=>array('Product.id'=>$item['Cart']['product_id'])
							)
						);
		
			$remainingstock=$stockproduct[0]['Product']['product_quantity']-$item['Cart']['quantity'];
			
			$dataproduct['Product']['product_quantity'] = $remainingstock; 
			$this->Product->id = $item['Cart']['product_id'];
			$this->Product->save($dataproduct);
						
						
						
						
						
						
						$this->Cart->delete($item['Cart']['id']);
						
						if($f){
							$orderdetail_id = $this->OrderDetail->id;
							
							if(!empty($item['CartOption'])){
								foreach($item['CartOption'] as $option){
									$optcols = $this->OrderDetailOption->schema();
									$optcolumns = array_keys($optcols);
									$saveData = array();
									$excludeKey = array('id');
									
									foreach($optcolumns as $k){
										if($k == 'order_detail_id'){
											$saveData['OrderDetailOption'][$k] = $orderdetail_id;
										} else {
											if(!in_array($k,$excludeKey)){
												$saveData['OrderDetailOption'][$k] = $option[$k];
											}
										}
									}
									
									$this->OrderDetailOption->create();
									$optf = $this->OrderDetailOption->save($saveData);
									$this->CartOption->delete($option['id']);
									
									if($optf){
										array_push($flagArr, 'T');
									} else {
										array_push($flagArr, 'F');
									}
								}
							} else {
								array_push($flagArr, 'T');
							}
							
						} else {
							array_push($flagArr, 'F');
						}
						
					}
					
					if(in_array('F', $flagArr)){
						$this->Session->setFlash('<p>Failed to submit your orders.</p>', 'default', array('class' => 'note note-danger'),'order');
						echo '3'.'-0';
					} else {
						//$mailFlag = $this->ordermail($data, $carts,$order_id);
						$mailFlag = true;
						if($mailFlag){
							$this->Session->setFlash('<p>Your order has been submitted. You will get another email notifying once the product has been delivered.</p>', 'default', array('class' => 'note note-success'),'order');
							echo '1'.'-'.$order_id;
						} else {
							$this->Session->setFlash('<p>Failed To send mail.</p>', 'default', array('class' => 'note note-success'),'order');
							echo '2'.'-0';
						}
						
					}
				} else {
					$this->Session->setFlash('<p>Failed to submit your orders.</p>', 'default', array('class' => 'note note-danger'),'order');
					echo '4'.'-0';
				}
				exit();
			} else {
				$this->Session->setFlash('<p>There is no information to submit your order.</p>', 'default', array('class' => 'note note-danger'),'order');
				echo '5'.'-0'; exit();
			}
			
		}
		exit();
	}
	
	private function ordermail($orderArr, $itemArr, $order_id){
		$this->loadModel('EmailTemplate');
		$Email = new CakeEmail();
		$body = $this->EmailTemplate->findByTemplateName('Order Confirmation');
		$subtotal = $orderArr['Order']['order_amount'];
		$grandtotal = $orderArr['Order']['order_amount'] + $orderArr['Order']['shipping_cost'];
		
		$itemChunk = $this->itemChunk($itemArr);
		$itemChunk .=	'<table width="100%" style="text-align:right">'.
						'<tr>'.
						'<td width="50%"></td>'.
						'<td width="50%">'.
						'<strong>Sub Total : </strong>'.CURRENCY.$subtotal.
						'</td>'.
						'</tr>'.
						'<tr>'.
						'<td width="50%"></td>'.
						'<td width="50%">'.
						'<strong>Shipping Cost : </strong>'.CURRENCY.$orderArr['Order']['shipping_cost'].
						'</td>'.
						'</tr>'.
						'<tr>'.
						'<td width="50%"></td>'.
						'<td width="50%">'.
						'<strong>Grand Total : </strong>'.CURRENCY.$grandtotal.
						'</td>'.
						'</tr>'.
						'</table>';
						
		$billinglocArr = $this->billingAddress($orderArr);
		$billingaddress =	$orderArr['Order']['firstname'].' '.$orderArr['Order']['lastname'].'<br />'.
							$orderArr['Order']['address'].'<br />'.$orderArr['Order']['address1'].'<br />'.
							$orderArr['Order']['city'].'<br /> '.$billinglocArr['State']['State'].'<br />'.
							$billinglocArr['Country']['Country'].'<br />  '.$orderArr['Order']['postcode'].'<br />';
		$shippinglocArr = $this->shippingAddress($orderArr);
		$shippingaddress =	$orderArr['Order']['ship_firstname'].' '.$orderArr['Order']['ship_lastname'].'<br />'.
							$orderArr['Order']['ship_address'].'<br />'.$orderArr['Order']['ship_address1'].'<br />'.
							$orderArr['Order']['ship_city'].'<br /> '.$shippinglocArr['State']['State'].'<br />'.
							$shippinglocArr['Country']['Country'].' <br /> '.$orderArr['Order']['ship_postcode'].'<br />'.
		
		//$url = '<a href="'.SITE_URL.'myorders">Track Order</a>';
		//$view = '<a href="'.SITE_URL.'viewallproduct/'.$order_id.'">Rate Order Products</a>';
		 $url = '<a href="'.SITE_URL.'myorders"></a>';
		//$view = '<a href="'.SITE_URL.'viewallproduct/'.$order_id.'">Rate Order Products</a>';
		
		$var = array('[Firstname]'=>$orderArr['Order']['firstname'],'[Lastname]'=>$orderArr['Order']['lastname'],'[TrackOrder]'=>$url, '[OrderSummary]'=>$itemChunk, '[billingaddress]'=>$billingaddress, '[shippingaddress]'=>$shippingaddress);
		
		$Email->viewVars(array(
			'base_url' => SITE_URL,
			'subject' => 'Order Confirmation',
			'contact_person' => 'Sir',
			'body_text' => $body['EmailTemplate']['email_body'],
			'body_varArr'=>$var
		));
		
		$fl = $Email->template('template', 'base_layout')
			->emailFormat('html')
			->from(array('sseal@sdsoftware.in' => 'Cakecms'))
			->to($orderArr['Order']['email_id'])
			->subject('Order Confirmation')
			->send();
		return $fl;
	}
	
	private function ordermailinvoice($orderArr, $itemArr, $order_id){
	
	$this->loadModel('EmailTemplate');
		$this->loadModel('SiteSetting');
		$Email = new CakeEmail();
		$sitesettingArr = $this->SiteSetting->findById(1);
		$subtotal = number_format($orderArr['Order']['order_amount'],2);
		$grandtotal = number_format(($orderArr['Order']['order_amount'] + $orderArr['Order']['shipping_cost']),2);
	
		$itemChunk1 = $this->itemChunk1($itemArr);
		$itemChunk1 .=	'<table width="100%" style="text-align:right">'.
						'<tr>'.
						'<td width="50%"></td>'.
						'<td width="50%">'.
						'<strong>Sub Total : </strong>'.CURRENCY.$subtotal.
						'</td>'.
						'</tr>'.
						'<tr>'.
						'<td width="50%"></td>'.
						'<td width="50%">'.
						'<strong>Shipping Cost : </strong>'.CURRENCY.$orderArr['Order']['shipping_cost'].
						'</td>'.
						'</tr>'.
						'<tr>'.
						'<td width="50%"></td>'.
						'<td width="50%">'.
						'<strong>Grand Total : </strong>'.CURRENCY.$grandtotal.
						'</td>'.
						'</tr>'.
						'</table>';
		
	$invoice='<div  style="border:0px solid"><table width="100%" cellspacing="0" cellpadding="0">
  <tbody><tr>
	<td  valign="top" style="font-size:24px;font-weight:bold;border-bottom:1px solid #dddddd;padding-top:36px">TAX INVOICE</td>
	<td  style="border-bottom:1px solid #dddddd;padding:8px"><img style="float:right; width:200px; max-width:100%;" alt="Logo_invoice" src="http://site25.vnsinfo.com/app/webroot/img/uploads/site_settings_logo/original/1460112891_871773.png" class="CToWUd"></td>		
  </tr>
  <tr>
<td valign="top" style="padding-top:23px">
	  <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody><tr>
			<td valign="top" style="padding-right:20px;padding-left:8px">To</td>
			<td valign="top" style="padding-left:8px">
			  '.$orderArr['Order']['firstname'].' '.$orderArr['Order']['lastname'].' <br>
			
			  '.$orderArr['Order']['address'].' <br>
			  '.$orderArr['Order']['address1'].'<br>
			  <a target="_blank" href="mailto:'.$orderArr['Order']['email_id'].'">'.$orderArr['Order']['email_id'].'</a><br>
			
			 </td>
		  </tr>
		  

		 
		  
		  <tr>
			<td style="padding:8px">Date</td>
			<td style="padding:8px"><span data-term="goog_239836219" class="aBn" tabindex="0"><span class="aQJ">'.date("d-m-Y").'</span></span></td>
		  </tr>
		   <tr>
			<td style="padding:8px">Invoice No</td>
			<td style="padding:8px"><span data-term="goog_239836219" class="aBn" tabindex="0"><span class="aQJ">'.$order_id.'</span></span></td>
		  </tr>
		  

	  </tbody></table> 
 </td>
<td valign="top" style="padding-top:23px;padding-left:105px">
	  <table width="100%" cellspacing="0" cellpadding="0" border="0">

		  <tbody><tr>
			<td style="padding-right:9px;vertical-align:top">From</td>
			<td>
			'.$sitesettingArr['SiteSetting']['address'].'
			  </td>
		  </tr>
		 	<tr>
			<td style="padding:8px"></td>
			<td style="padding:8px"></td>
		</tr>
		<tr>
			<td style="padding:8px">ABN</td>
			<td style="padding:8px">'.$sitesettingArr['SiteSetting']['abn'].'</td>
		</tr>
	  </tbody></table>
   </td>
  </tr>
</tbody></table></br>'.$itemChunk1.'
									</div>'	;			
		$Email->viewVars(array(
			'base_url' => SITE_URL,
			'subject' => 'Tax Invoice',
			'contact_person' => 'Sir',
			'body_text' => $invoice,
			'body_varArr'=>$var
		));
		
		$fl = $Email->template('template', 'base_layout')
			->emailFormat('html')
			->from(array('sseal@sdsoftware.in' => 'Cakecms'))
			->to($orderArr['Order']['email_id'])
			->subject('Order Confirmation')
			->send();
		return $fl;
	
	}
	private function ordermailadmin($orderArr, $itemArr, $order_id){
		$this->loadModel('EmailTemplate');
		$this->loadModel('SiteSetting');
		$Email = new CakeEmail();
		$sitesettingArr = $this->SiteSetting->findById(1);
		$subtotal = number_format($orderArr['Order']['order_amount'],2);
		$grandtotal = number_format(($orderArr['Order']['order_amount'] + $orderArr['Order']['shipping_cost']),2);
		
		$billinglocArr = $this->billingAddress($orderArr);
		$billingaddress =	$orderArr['Order']['firstname'].' '.$orderArr['Order']['lastname'].'<br />'.
							$orderArr['Order']['address'].'<br />'.$orderArr['Order']['address1'].'<br />'.
							$orderArr['Order']['city'].'<br />'.$billinglocArr['State']['State'].'<br />'.
							$billinglocArr['Country']['Country'].'<br /> '.$orderArr['Order']['postcode'].'<br />';
		$shippinglocArr = $this->shippingAddress($orderArr);
		$shippingaddress =	$orderArr['Order']['ship_firstname'].' '.$orderArr['Order']['ship_lastname'].'<br />'.
							$orderArr['Order']['ship_address'].'<br />'.$orderArr['Order']['ship_address1'].'<br />'.
							$orderArr['Order']['ship_city'].'<br /> '.$shippinglocArr['State']['State'].'<br />'.
							$shippinglocArr['Country']['Country'].'<br /> '.$orderArr['Order']['ship_postcode'].'<br />';
		$itemChunk = $this->itemChunk1($itemArr);
		$itemChunk .=	'<table width="100%" style="text-align:right">'.
						'<tr>'.
						'<td width="50%"></td>'.
						'<td width="50%">'.
						'<strong>Sub Total : </strong>'.CURRENCY.$subtotal.
						'</td>'.
						'</tr>'.
						'<tr>'.
						'<td width="50%"></td>'.
						'<td width="50%">'.
						'<strong>Shipping Cost : </strong>'.CURRENCY.$orderArr['Order']['shipping_cost'].
						'</td>'.
						'</tr>'.
						'<tr>'.
						'<td width="50%"></td>'.
						'<td width="50%">'.
						'<strong>Grand Total : </strong>'.CURRENCY.$grandtotal.
						'</td>'.
						'</tr>'.
						'</table>';
		
		 $mail_style_css='<head>
							<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
							<title>worklocker</title>
							<style type="text/css">
							body {
								background-color: #C7C8CF;
							}
							body,td,th {
								font-family: Arial, Helvetica, sans-serif;
								font-size: 14px;
								color: #424242;
							}
							a{ color:#8da33d; text-decoration:none;}
							a:hover{ text-decoration:underline;}
							p{ margin:0; padding:0;}
							h1{ color: #b52c30; padding:0 0 10px 0; margin:0; font-size:18px; font-weight:bold; }

							hr{ border:none; border:0; line-height:1px; height:1px; color:#A8A8A8; background-color:#A8A8A8; outline:none; padding:0; margin-bottom:10px;}
							img{ border:none;}

							</style>
							</head>';
				
			$mailtextAdmin = "Dear Admin,<br/>An order was successfully placed. Please find details below.";	

				$payment_method_details = '<b>Payment Method : </b> PAYPAL <br />';
		
		
		$adminhtml='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml">'.$mail_style_css.'
						<body>
						<table border="0" cellspacing="0" cellpadding="0"  bgcolor="#FFFFFF; width:100%">
						  <tr>
<td align="center" valign="top" bgcolor="#FFFFFF"  ><img src="http://site25.vnsinfo.com/app/webroot/img/uploads/site_settings_logo/original/1460112891_871773.png"  alt="images" style="width: 600px; height: 180px;" /> <hr /></td>
						  </tr>
						  <tr>
							<td bgcolor="#FFFFFF">
							<div style="width:646px;">
							<table style="border-collapse: collapse; width: 646px; border-top: 0px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">

								 <tr>
									<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; font-weight: bold; text-align: left; padding: 7px; color: #222222;" colspan="2">
									'.$mailtextAdmin.'
									</td>
								  </tr>
								 <tr>
									<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;" colspan="2">Order Details</td>
								  </tr>

								  <tr>
									<td style="font-size: 12px; line-height:17px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 10px;"><b>Order ID : </b>'.$order_id.'<br />
									  <b>Date : </b>'.date("d-m-Y").'<br />
									  '.$payment_method_details.'</td>
												
									<td style="font-size: 12px; line-height:17px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 10px;">
									<b>Name : </b>'.$orderArr['Order']['ship_firstname'].' '.$orderArr['Order']['ship_lastname'].'<br />
									<b>Email : </b>'.$orderArr['Order']['email_id'].'<br />

									  <b>IP Address : </b>'.$_SERVER['REMOTE_ADDR'].'<br /></td>
								  </tr>

								  <tr>
									<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">Payment Address</td>
											<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">Shipping Address</td>
										  </tr>


										   <tr>
									<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">'. $shippingaddress.'</td>
									
											<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">'. $billingaddress.'</td>
										  </tr>

							  </table>

							 '.$itemChunk.'
									</div>
									</td>
								  </tr>
								  
							</table>
						</body>
						</html>';
		
		
		
		
		$Email->viewVars(array(
			'base_url' => SITE_URL,
			'subject' => 'Order Confirmation',
			'contact_person' => 'Sir',
			'body_text' => $adminhtml,
			'body_varArr'=>$var
		));
		
		$fl = $Email->template('template', 'base_layout')
			->emailFormat('html')
			->from(array('sseal@sdsoftware.in' => 'Cakecms'))
			->to($sitesettingArr['SiteSetting']['admin_email'])
			->subject('Order Confirmation')
			->send();
		return $fl;
	}
	
	private function itemChunk1($itemArr) {
		
		$str = '<br/><table style="width:100%;">';
		$str.= '<tr style="background:#242424; color:#FFF; text-align:center;">';
		$str.= '<th style="width:15%;">IMAGE</th>';
		$str.= '<th style="width:15%;">DESCRIPTION</th>';
		$str.= '<th style="width:15%;">MODEL</th>';
		$str.= '<th style="width:15%;">QUANTITY</th>';
		$str.= '<th style="width:15%;">PRICE</th>';
		$str.= '<th style="width:15%;">TOTAL</th>';
		$str.= '</tr>';
		
		foreach($itemArr as $item){
			$str.='<tr>';
			$this->loadModel('Product');
			$product = $this->Product->findById($item['Cart']['product_id']);
			$options = array();
			if(!empty($item['CartOption'])){
				$options = $this->buildOption($item['CartOption']);
			}
			$str.=	'<td>'.
					'<img src="'.IMGPATH.'product_image/thumb/'.$product['Product']['product_image'].'" alt="'.$product['Product']['product_name'].'">'.
					'</td>'.
					'<td>'.
					'<p>'.$product['Product']['product_name'].'</p><br />';
					if(!empty($options)){
						$str.=	'<p>';
						foreach($options as $option){
							$str.=	'<strong>'.$option['ProductOption']['options_name'].'</strong> '.$option['OptionValue']['option_value_name'].'<br />';
						}
						$str.='</p>';
					}
			$str.=	'</td>'.
					'<td align="left">'.
					'<p>'.$product['Product']['product_sku'].'</p>'.
					'</td>'. 
					'<td align="left">'.
					'<p>'.$item['Cart']['quantity'].'</p>'.
					'</td>'.
					'<td align="left">'.
					'<p>'.CURRENCY.$item['Cart']['unit_price'].'</p>'.
					'</td>'.
					'<td align="left">'.
					'<p>'.CURRENCY.$item['Cart']['gross_price'].'</p>'.
					'</td>'.
					'</tr>';
		}
		$str.='</table>';
		return $str;
	}
	
	
	public function viewallproduct($order_id){
		$this->theme = THEME_NAME;
		$this->layout = "inner";
		$this->loadModel('OrderDetail');
		$this->loadModel('Product');
		$this->OrderDetail->bindModel(
				array(
					'belongsTo' => array(
						'Product' => array(
								'className'    => 'Product',
								'foreignKey'   => 'product_id'
								
							)
					)
				)
			);
			
			$productviewArr = $this->OrderDetail->find('all', array(
					'conditions'=>array('OrderDetail.order_id'=>$order_id)
				)
			);
		
		$this->set(compact('productviewArr'));
	}
	
	private function itemChunk($itemArr) {
		$str = '<br/><table style="width:100%;">';
		$str.= '<tr style="background:#242424; color:#FFF; text-align:center;">';
		$str.= '<th style="width:15%;">IMAGE</th>';
		$str.= '<th style="width:30%;">DESCRIPTION</th>';
		$str.= '<th style="width:15%;">MODEL</th>';
		$str.= '<th style="width:10%;">QUANTITY</th>';
		$str.= '<th style="width:15%;">PRICE</th>';
		$str.= '<th style="width:15%;">TOTAL</th>';
		$str.= '</tr>';
		
		foreach($itemArr as $item){
			$str.='<tr>';
			$this->loadModel('Product');
			$product = $this->Product->findById($item['Cart']['product_id']);
			$options = array();
			if(!empty($item['CartOption'])){
				$options = $this->buildOption($item['CartOption']);
			}
			$str.=	'<td>'.
					'<img src="'.IMGPATH.'product_image/thumb/'.$product['Product']['product_image'].'" alt="'.$product['Product']['product_name'].'">'.
					'</td>'.
					'<td>'.
					'<p>'.$product['Product']['product_name'].'</p><br />';
					if(!empty($options)){
						$str.=	'<p>';
						foreach($options as $option){
							$str.=	'<strong>'.$option['ProductOption']['options_name'].'</strong> '.$option['OptionValue']['option_value_name'].'<br />';
						}
						$str.='</p>';
					}
			$str.=	'</td>'.
					'<td align="left">'.
					'<p>'.$product['Product']['product_sku'].'</p>'.
					'</td>'. 
					'<td align="left">'.
					'<p>'.$item['Cart']['quantity'].'</p>'.
					'</td>'.
					'<td align="left">'.
					'<p>'.CURRENCY.$item['Cart']['unit_price'].'</p>'.
					'</td>'.
					'<td align="left">'.
					'<p>'.CURRENCY.$item['Cart']['gross_price'].'</p>'.
					'</td>'.
					'</tr>';
		}
		$str.='</table>';
		return $str;
	}
	
	private function buildOption($options){
		$arr = array();
		$i = 0;
		foreach($options as $opt){
			$this->loadModel('OptionValue');
			$this->OptionValue->bindModel(array(
					'belongsTo'=>array(
						'ProductOption'=>array(
							'className'=>'ProductOption',
							'foreignKey'=>'option_id'
						)
					)
				)
			);
			$arr[$i]=$this->OptionValue->findById($opt['option_value_id']);
			$i++;
		}
		return $arr;
	}
	
	private function billingAddress($orderArr){
		if(!empty($orderArr)){
			$this->State->bindModel(array(
					'belongsTo'=>array(
						
						'Country'=>array(
							'className'=>'Country',
							'foreignKey'=>'CountryID'
						)
					)
				)
			);
			
			$loc = $this->State->findById($orderArr['Order']['state']);
			return $loc;
		}
	}
	
	private function shippingAddress($orderArr){
		if(!empty($orderArr)){
			$this->State->bindModel(array(
					'belongsTo'=>array(
						
						'Country'=>array(
							'className'=>'Country',
							'foreignKey'=>'CountryID'
						)
					)
				)
			);
			
			$loc = $this->State->findById($orderArr['Order']['ship_state']);
			return $loc;
		}
	}
	  
	private function memberRegister($reqdata)
	{
		if(!empty($reqdata)){
			$data = array();
			$data['Member'] = $reqdata['Order'];
			
			$count = $this->Member->find('count', array(
						'conditions'=>array('Member.email_id'=>$data['Member']['email_id'])
						)
					);
			if($count == 0){
			
			
				if(($data['Member']['password'] !== '') && ($data['Member']['password_confirm'] !== '') && ($data['Member']['password'] == $data['Member']['password_confirm'])){
					$data['Member']['password'] = AuthComponent::password($data['Member']['password']);
				}
				$data['Member']['activate_code'] = time().uniqid();
				$data['Member']['status'] = 'N';
				$data['Member']['date_created'] = date('Y-m-d');
				$this->Member->create();
				$flag = $this->Member->save($data);
				$userid = $this->Member->id;
				if($flag){
					$this->loadModel('EmailTemplate');
					$Email = new CakeEmail();
					$body = $this->EmailTemplate->findByTemplateName('Registration');
					
					$url = '<a href="'.SITE_URL.'activate/'.$data['Member']['activate_code'].'">'.SITE_URL.'activate/'.$data['Member']['activate_code'].'</a>';
					$var = array('[firstname]'=>$data['Member']['firstname'],'[lastname]'=>$data['Member']['lastname'],'[urlpath]'=>$url);
					
					$Email->viewVars(array(
						'base_url' => SITE_URL,
						'subject' => 'Registration Successful',
						'contact_person' => 'Sir',
						'body_text' => $body['EmailTemplate']['email_body'],
						'body_varArr'=>$var
					));
					
					$fl = $Email->template('template', 'base_layout')
						->emailFormat('html')
						->from(array('sseal@sdsoftware.in' => 'Cakecms'))
						->to($data['Member']['email_id'])
						->subject('Account Register')
						->send();
					if($fl){
						$this->Session->setFlash('<p>Registration successful and a confirmation email has been sent to your email id!</p>', 'default', array('class' => 'note note-success'),'register');
						return array($userid, "");
					} else {
						$this->Session->setFlash('<p>Failed to sent registration mail!</p>', 'default', array('class' => 'note note-danger'),'register');
						return array(false, "mail_error");
					}
				} else {
					$this->Session->setFlash('<p>Failed to register your account!</p>', 'default', array('class' => 'note note-danger'),'register');
					return array(false, "database_error");
				}
			} else {
				return array(false, "already_exist");
			}
		} else {
			return array(false, "insufficient_data");
		}
	}
	
	public function payment($id = NULL){
		$this->theme = THEME_NAME;
		$this->layout = "inner";
		
		if(!empty($id)){
			$orderData = $this->Order->findById($id);
			//pr($orderData); exit();
			$this->set(compact('orderData'));
		} else {
			$this->autoRender = false;
			$this->Session->setFlash('You are trying wrong url', 'default', array('class' => 'alert alert-danger'));
			$this->redirect(array('controller'=>'Pages', 'action'=>'error'));
		}
		
	}
	
	/* public function pay(){
		$this->autoRender = false;
		
		$payment = $_REQUEST;
		
		
		if(!empty($payment['txn_id'])){
			$data['Order']['payment_date'] = date('Y-m-d H:i:s');
			$data['Order']['payment_status'] = 'Y';
			$data['Order']['transaction_id'] = $payment['txn_id'];
			
			$this->Order->id = $payment['custom'];
			$flag = $this->Order->save($data);
			
			if($flag){
				$this->loadModel('Transaction');
				
				$trnData['Transaction']['order_id'] = $payment['custom'];
				$trnData['Transaction']['transaction_id'] = $payment['txn_id'];
				$trnData['Transaction']['amount'] = $payment['mc_gross'];
				$trnData['Transaction']['status'] = 'Y';
				
				$this->Transaction->create();
				$fl = $this->Transaction->save($trnData);
				$order_id = $this->Session->read('order_id');
				$data1 = $this->Session->read('data');
				$carts = $this->Session->read('carts');
				$this->ordermail($data1, $carts,$order_id);
				
				if($fl){
					$this->Session->setFlash('Your payment has been completed', 'default', array('class' => 'alert alert-success'), 'order');
					$this->redirect(array('controller'=>'Pages', 'action'=>'success', 'full_base'=>true));
				} else {
					$this->Session->setFlash('Fail to complete your payment.', 'default', array('class' => 'alert alert-danger'), 'order');
					$this->redirect(array('controller'=>'Pages', 'action'=>'error', 'full_base'=>true));
				}
			}
			
		} else {
			$this->Session->setFlash('Fail to complete your payment.', 'default', array('class' => 'alert alert-danger'), 'order');
			$this->redirect(array('controller'=>'Pages', 'action'=>'error', 'full_base'=>true));
		}
	}
	 */
	
		public function pay($transaction_id=null){
		        $this->autoRender = false;
		        $transaction_id=$transaction_id;
				$order_id = $this->Session->read('order_id');
				$data1 = $this->Session->read('data');
				$carts = $this->Session->read('carts');
			
				
				if($transaction_id>0){
					$this->Session->setFlash('Your payment has been completed', 'default', array('class' => 'alert alert-success'), 'order');
					$this->redirect(array('controller'=>'Pages', 'action'=>'success', 'full_base'=>true));
				} else {
					$this->Session->setFlash('Fail to complete your payment.', 'default', array('class' => 'alert alert-danger'), 'order');
					$this->redirect(array('controller'=>'Pages', 'action'=>'error', 'full_base'=>true));
				}
			
			
		} 
	
	
	public function Paypalipnerror(){
		      $this->Session->setFlash('Fail to complete your payment.', 'default', array('class' => 'alert alert-danger'), 'order');
			$this->redirect(array('controller'=>'Pages', 'action'=>'error', 'full_base'=>true));
			
			
		} 
	
	
	
	public function cancel($id = NULL){
		$this->theme = THEME_NAME;
		$this->layout = "inner";
		
	}
	
	public function admin_editdeliverystatus(){
		$this->layout = 'ajax';
		$this->set('id', $this->request->data['id']);
		$this->loadModel('Order');
		if($this->request->data['id'] != ''){			
			$data = $this->Order->findById($this->request->data['id']);
			$this->set('data',$data);
		}
	}
	public function admin_deliverystatusupdate($id=null){
		if($this->request->is('post'))
		{
			$this->loadModel('Order');
			$data=$this->request->data;
			if($data['Order']['delivery_status']=='N')
			{
				$data['Order']['delivery_date']='';
			}
			else{
			$date = new DateTime($this->request->data['Order']['delivery_date']);
			$data['Order']['delivery_date'] = $date->format('Y-m-d H:i:s');
			}
			
			$this->Order->id=$id;
			$result=$this->Order->save($data);
			if($result){
			$this->Session->setFlash('Delivery Status Update Successfully', 'default', array('class' => 'alert alert-success'));
			}
			$this->redirect(array('controller'=>'Orders','action'=>'admin_manage/'.$id));
		}
		
	}
	
	public function emailcheching(){
		$this->layout = 'ajax';
		if($this->request->is('post')){
			$data = $this->request->data;
			$email=$data['email'];
			$resultemail=$this->Order->find('count',array('conditions'=>array('Order.email_id'=>$email)));
			if($resultemail=='0')
				{
					echo "0";
					exit;
				}else {
				echo "1";
				exit;
				
				}
			}
		}
		
		public function success()
		{
				$this->theme = THEME_NAME;
				$this->layout = 'ecommerce_inner';
			    $order_id = $this->Session->read('order_id');
				$data1 = $this->Session->read('data');
				$carts = $this->Session->read('carts');
				if(!empty($order_id)){
				
				$this->ordermail($data1, $carts,$order_id);
				
				$this->ordermailadmin($data1, $carts,$order_id);
			    $this->ordermailinvoice($data1, $carts,$order_id); 
				$this->Session->setFlash('Your payment has been completed', 'default', array('class' => 'alert alert-success'), 'order');
				$this->Session->delete('order_id');
				
				}else {
				
				$this->Session->setFlash('Fail to complete your payment.', 'default', array('class' => 'alert alert-danger'), 'order');
				
				}
				
		}
	
}
?>