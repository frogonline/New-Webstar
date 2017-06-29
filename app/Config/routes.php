<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'Pages', 'action' => 'home'));
	
	//Router::connect('/Widget1', array('controller' => 'Pages', 'action' => 'widget', 1));
	
	
	
	
	App::import('Model','Slug');
	$slugobject	=	new Slug();
	$data_slugobject	=	$slugobject->find('all',array('id','slug_name','controller_name','action_name'));
	
	App::import('Model','SiteSetting');
	$theme	=	new SiteSetting();
	$settings = $theme->find('first');
		$current_url=$_SERVER['REQUEST_URI'];	$substringc=explode('/',$current_url);	$extralink=$substringc[1];	$Parentpagename=$substringc[2];	$slug12=end($substringc);	if($extralink!='more'){	
	if(!empty($data_slugobject))
	{
		foreach($data_slugobject as $dprc)
		{
			if($dprc["Slug"]["action_name"]=='products'){				
				Router::connect('/'.$dprc["Slug"]["slug_name"],array('controller'=>$dprc["Slug"]["controller_name"],'action'=>$settings['SiteSetting']['ecommerce_template'],$dprc["Slug"]["slug_name"]));
			} else if($dprc["Slug"]["action_name"]=='productdetails'){
				Router::connect('/'.$dprc["Slug"]["slug_name"].'/*',array('controller'=>$dprc["Slug"]["controller_name"],'action'=>$dprc["Slug"]["action_name"],$dprc["Slug"]["slug_name"]));
			} else {				//if($extralink!='More'){
				Router::connect('/'.$dprc["Slug"]["slug_name"],array('controller'=>$dprc["Slug"]["controller_name"],'action'=>$dprc["Slug"]["action_name"],$dprc["Slug"]["slug_name"]));				//}
			}
		} 	
	}    }else{		Router::connect('/more/*', array('controller' => 'Pages', 'action' =>'display',$slug12,$Parentpagename));		}
	   
	
	Router::connect('/blog', array('controller' => 'Posts', 'action' =>$settings['SiteSetting']['blog_template']));
	Router::connect('/blog/*', array('controller' => 'Posts', 'action' =>$settings['SiteSetting']['blog_template']));
	
	Router::connect('/ecommerce', array('controller' => 'Products', 'action' => 'home'));
	Router::connect('/sitemap', array('controller' => 'Pages', 'action' => 'sitemap'));
	Router::connect('/shop/search/*', array('controller' => 'Products', 'action' => 'search'));
	Router::connect('/page/search/*', array('controller' => 'Pages', 'action' => 'search'));
	Router::connect('/catalogdetail/*', array('controller' => 'Products', 'action' => 'catalogdetail'));
	Router::connect('/login', array('controller' => 'Members', 'action' => 'login'));
	Router::connect('/forgotpassword', array('controller' => 'Members', 'action' => 'forgotpassword'));
	Router::connect('/logout', array('controller' => 'Members', 'action' => 'logout'));
	Router::connect('/register', array('controller' => 'Members', 'action' => 'register'));
	Router::connect('/myaccount', array('controller' => 'Members', 'action' => 'myaccount'));
	Router::connect('/mycatalog', array('controller' => 'Products', 'action' => 'mycatalog'));
	Router::connect('/myorders', array('controller' => 'Members', 'action' => 'myorders'));
	Router::connect('/wishlist', array('controller' => 'Members', 'action' => 'wishlist'));
	//Router::connect('/success', array('controller' => 'Pages', 'action' => 'success'));
	Router::connect('/success', array('controller' => 'Orders', 'action' => 'success'));
	Router::connect('/error', array('controller' => 'Pages', 'action' => 'error'));
	Router::connect('/activate/*', array('controller' => 'Members', 'action' => 'activate'));
	Router::connect('/cart', array('controller' => 'Carts', 'action' => 'cart'));
	Router::connect('/checkout', array('controller' => 'Orders', 'action' => 'checkout'));
	
	Router::connect('/faqs', array('controller' => 'Pages', 'action' => 'faqs'));
	Router::connect('/contactus', array('controller' => 'Pages', 'action' => 'contactus'));
	Router::connect('/admin', array('controller' => 'Generals', 'action' => 'login', 'admin' => true));
	Router::connect('/payment/*', array('controller' => 'Orders', 'action'=>'payment'));
	Router::connect('/pay/*', array('controller' => 'Orders', 'action' => 'pay'));
	Router::connect('/cancel', array('controller' => 'Orders', 'action' => 'cancel'));
	Router::connect('/viewallproduct/*', array('controller' => 'Orders', 'action' => 'viewallproduct'));
	//Router::connect('/posts/category/*', array('controller' => 'Posts', 'action' => 'category'));
	//Router::connect('/posts/*', array('controller' => 'Posts', 'action' => 'single'));
	
	//Router::connect('/products/*', array('controller' => 'Products', 'action' => 'products'));
	//Router::connect('/productdetails/*', array('controller' => 'Products', 'action' => 'productdetails'));
	
	
	
	
	
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	//Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
