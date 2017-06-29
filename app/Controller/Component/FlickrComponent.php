<?php

/**
 * Flickr Component
 * @author RosSoft
 * @license MIT
 * @version 0.1
 */
App::uses('Component', 'Controller');
define('FLICKR_CACHE_DIR',CACHE . 'flickrs/');

class FlickrComponent extends Object
{
    /**
     * Api Key. Change to your own
     * @var string
     * @link http://www.flickr.com/services/api/misc.api_keys.html
     */
    var $_api_key='51826b4194834e9b530bb4dd1a486c05';

    function startup(&$controller)
    {
        vendor('phpflickr/phpFlickr');
   
        //FlickrComponent instance of controller is replaced by a phpFlickr instance
         $controller->flickrs =& new phpFlickr($this->_api_key);
         if (!is_dir(FLICKR_CACHE_DIR))
        {
            mkdir(FLICKR_CACHE_DIR,0777);
        }                
         $controller->flickr->enableCache('fs', FLICKR_CACHE_DIR);
         $controller->set('flickr',$controller->flickrs);
    }
}
?>
