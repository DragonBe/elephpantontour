<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

require_once 'Zend/Config/Ini.php';
$config = new Zend_Config_Ini(
    APPLICATION_PATH . '/configs/application.ini',
    APPLICATION_ENV,
    array ('allowModifications' => true)
);

// Load local configurations
if (file_exists(APPLICATION_PATH . '/configs/local.ini')) {
    $localConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/local.ini');
    $config->merge($localConfig);
}

// Load custom routes for the application
if (file_exists(APPLICATION_PATH . '/configs/routes.ini')) {
    $routesConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes.ini');
    $config->merge($routesConfig);
}

// Make the config READ-ONLY
$config->setReadOnly();

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    $config
);
$application->bootstrap()
            ->run();