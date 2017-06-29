<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
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
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
//include('site_config.php');
// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models/', '/next/path/to/models/'),
 *     'Model/Behavior'            => array('/path/to/behaviors/', '/next/path/to/behaviors/'),
 *     'Model/Datasource'          => array('/path/to/datasources/', '/next/path/to/datasources/'),
 *     'Model/Datasource/Database' => array('/path/to/databases/', '/next/path/to/database/'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions/', '/next/path/to/sessions/'),
 *     'Controller'                => array('/path/to/controllers/', '/next/path/to/controllers/'),
 *     'Controller/Component'      => array('/path/to/components/', '/next/path/to/components/'),
 *     'Controller/Component/Auth' => array('/path/to/auths/', '/next/path/to/auths/'),
 *     'Controller/Component/Acl'  => array('/path/to/acls/', '/next/path/to/acls/'),
 *     'View'                      => array('/path/to/views/', '/next/path/to/views/'),
 *     'View/Helper'               => array('/path/to/helpers/', '/next/path/to/helpers/'),
 *     'Console'                   => array('/path/to/consoles/', '/next/path/to/consoles/'),
 *     'Console/Command'           => array('/path/to/commands/', '/next/path/to/commands/'),
 *     'Console/Command/Task'      => array('/path/to/tasks/', '/next/path/to/tasks/'),
 *     'Lib'                       => array('/path/to/libs/', '/next/path/to/libs/'),
 *     'Locale'                    => array('/path/to/locales/', '/next/path/to/locales/'),
 *     'Vendor'                    => array('/path/to/vendors/', '/next/path/to/vendors/'),
 *     'Plugin'                    => array('/path/to/plugins/', '/next/path/to/plugins/'),
 * ));
 *
 */

/**
 * Custom Inflector rules can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. Make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */
	//CakePlugin::load('Combinator');
/**
 * To prefer app translation over plugin translation, you can set
 *
 * Configure::write('I18n.preferApp', true);
 */

/**
 * You can attach event listeners to the request lifecycle as Dispatcher Filter. By default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 *		'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 *		'MyCacheFilter' => array('prefix' => 'my_cache_'), //  will use MyCacheFilter class from the Routing/Filter package in your app with settings array.
 *		'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 *		array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 *		array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
	'engine' => 'File',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'File',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));

App::import('Model','Theme');
$theme		=	new Theme();
$data		=	$theme->findByStatus('Y');

App::import('Model', 'SiteSetting');
$sitesetting = new SiteSetting();
$setting = $sitesetting->find('first');
//pr($setting);
$currencyArr = array('INR'=>'&#x20B9;', 'AUD'=>'&#36;', 'USD'=>'&#36;', 'EUR'=>'&#163;');
if(!empty($setting)){
	if($setting['SiteSetting']['currency']!=""){
		$cur = array_key_exists($setting['SiteSetting']['currency'], $currencyArr)?$currencyArr[$setting['SiteSetting']['currency']]:'';
		define("CURRENCY", $cur);
	} else {
		define("CURRENCY", "");
	}
}

//Define Static Variables


if($_SERVER['SERVER_NAME'] != "phpserver"){
	define("PREFVAR", "/webster/");
	define("SITE_URL", "http://".$_SERVER['SERVER_NAME'].PREFVAR);
} else{
	define("PREFVAR", "/cakecms_new/"); // default '/'
	define("DNS", "http://phpserver"); // "http://vnsinfo.com"
	define("SITE_URL", DNS.PREFVAR);
}

define("SITE_NAME", "Cake CMS");
define("PAGINATION_PER_PAGE_LIMIT", 50);
define("BLOG_PAGINATION_PER_PAGE_LIMIT", 6);
define("FRONTEND_PAGINATION_PER_PAGE_LIMIT", 10);
define('IMGPATH', SITE_URL."app/webroot/img/uploads/");
define('IMGPATH1', SITE_URL."app/webroot/img/");
define('UPLOADS_FOLDER', WWW_ROOT.'img'.DS.'uploads');
define('UPLOADS_ZIP', SITE_URL.'app/View/Themed/');

if($_SERVER['SERVER_NAME'] == 'phpserver'){
	define('SITE_KEY','6Len5vwSAAAAAISlhm9gkon7iV6vusJNhhA0Lo3t');
	define('SECRET_KEY','6Len5vwSAAAAAMpo4aRfvrsHpmVG-ByZDXJLGPQ_');
} else {
	define('SITE_KEY','6LdpgwwUAAAAANxv0Fer9LGinbRCzaFKjRMz4DU-');
	define('SECRET_KEY','6LdpgwwUAAAAANjlBKkOHFoey2zWHuZGaRoNu0Nt');
}

define('THEME_URL', !empty($data)?SITE_URL.'theme/':'');
define('CURRENT_THEME_URL', !empty($data)?SITE_URL.'theme/'.$data['Theme']['zip_file'].'/':'');
define('THEME_NAME', (!empty($data))?$data['Theme']['zip_file']:'');

function hashPassword($password){
	$security_salt = Configure::read('Security.salt');
	return md5($password . $security_salt);
}
function encryptStr($str){
	return base64_encode(base64_encode($str));
} 
function decryptStr($str){
	return base64_decode(base64_decode($str)); 
} 
function getRandomPassword($passLength=8) {
    $alphabet = str_shuffle("abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789");
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $passLength; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
define('NOW', date('Y-m-d H:i:s'));
define('METRICS_TABLE', 'sessions,percentNewSessions,newUsers,bounceRate,pageviewsPerSession,avgSessionDuration,goalConversionRateAll,goalCompletionsAll,goalValueAll');