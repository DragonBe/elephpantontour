<?php

interface Application_Service_Interface
{
    /**
     * The constructor should be able to receive optional
     * configuration settings.
     *
     * @param null|Zend_Config $config
     */
    public function __construct($config = null);

    /**
     * Sets the configuration using Zend_Config object
     *
     * @param Zend_Config $config
     * @return Application_Service_Interface
     */
    public function setConfig(Zend_Config $config);

    /**
     * Retrieves the configuration settings
     *
     * @return Zend_Config
     */
    public function getConfig();
    /**
     * Searches for a particular tag and returns an array of images
     * matching the given tag.
     *
     * @param string $tag
     * @return array
     */
    public function searchForTag($tag);
}