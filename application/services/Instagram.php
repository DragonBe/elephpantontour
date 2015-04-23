<?php

class Application_Service_Instagram implements Application_Service_Interface
{
    /**
     * The constructor should be able to receive optional
     * configuration settings.
     *
     * @param null|Zend_Config $config
     */
    public function __construct($config = null)
    {
        if (null !== $config) {
            $this->setConfig($config);
        }
    }

    /**
     * Sets the configuration using Zend_Config object
     *
     * @param Zend_Config $config
     * @return Application_Service_Interface
     */
    public function setConfig(Zend_Config $config)
    {
        $this->_config = $config;
        return $this;
    }

    /**
     * Retrieves the configuration settings
     *
     * @return Zend_Config
     */
    public function getConfig()
    {
        return $this->_config;
    }

    /**
     * Searches for a particular tag and returns an array of images
     * matching the given tag.
     *
     * @param string $tag
     * @return array
     */
    public function searchForTag($tag)
    {
        $instaUrl = 'https://api.instagram.com/v1/tags/elephpant/media/recent';
        $instaResult = array ();
        try {
            $instaResult = file_get_contents(sprintf('%s?access_token=%s',
                $instaUrl,
                $this->getConfig()->instagram->token
            ));
        } catch (Exception $exception) {
            // TODO Fix error handling
        }

        return json_decode($instaResult);
    }
}