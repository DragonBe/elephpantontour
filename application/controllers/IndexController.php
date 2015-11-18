<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $config = new Zend_Config_Ini(
            APPLICATION_PATH . '/configs/api.ini.dist'
        );
        if (file_exists(APPLICATION_PATH . '/configs/api.ini')) {
            $config = new Zend_Config_Ini(
                APPLICATION_PATH . '/configs/api.ini', APPLICATION_ENV
            );
        }
        $config->flickr->key = FLICKR_API_KEY;
        $config->flickr->secret = FLICKR_API_SECRET;


        $frontEndOptions = array (
            'lifetime' => 3600,
            'automatic_serialization' => true,
        );
        $backEndOptions = array (
            'cache_dir' => APPLICATION_PATH . '/../data/cache',
        );
        $cache = Zend_Cache::factory('Core', 'File', $frontEndOptions, $backEndOptions);

        if (false === ($results = $cache->load('flickr_elephpants'))) {
            $flickr = new Application_Service_Flickr($config);
            $results = $flickr->searchForTag('elephpant');
            $cache->save($results, 'flickr_elephpants');
        }

//        if (false === ($data = $cache->load('insta_elephpants'))) {
//            $instagram = new Application_Service_Instagram($config);
//            $data = $instagram->searchForTag('elephpant');
//            $cache->save($data, 'insta_elephpants');
//        }

        $this->view->assign(array (
            'results' => $results,
//            'instagram' => $data,
        ));
    }


}

