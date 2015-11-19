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
                APPLICATION_PATH . '/configs/api.ini', APPLICATION_ENV, array ('allowModifications' => true)
            );
        }
        $config->flickr->key    = FLICKR_API_KEY;
        $config->flickr->secret = FLICKR_API_SECRET;

        $logger = new Zend_Log();
        $writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../data/logs/application.log');
        $logger->addWriter($writer);
        $logger->addFilter(new Zend_Log_Filter_Priority(Zend_Log::DEBUG));


        $frontEndOptions = array (
            'lifetime' => 3600,
            'automatic_serialization' => true,
        );
        $backEndOptions = array (
            'cache_dir' => APPLICATION_PATH . '/../data/cache',
        );
        $cache = Zend_Cache::factory('Core', 'File', $frontEndOptions, $backEndOptions);

        $cache->remove('flickr_elephpants');
        if (false === ($results = $cache->load('flickr_elephpants'))) {
            $logger->log('Retrieving elePHPants from the net', Zend_Log::INFO);
            $flickr = new Application_Service_Flickr($config);
            $results = $flickr->searchForTag('elephpant');
            $logger->log('Found ' . count($results) . ' elephpants to be displayed', Zend_Log::INFO);
            //var_dump($results);
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

