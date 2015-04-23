<?php

/**
 * Class Application_Service_Flickr
 *
 * This class connects to the Flickr.com web services and fetches
 * photo details.
 *
 * @package Service
 * @category Service_Flickr
 */
class Application_Service_Flickr implements Application_Service_Interface
{
    /**
     * @var Zend_Config
     */
    protected $_config;

    /**
     * @param \Zend_Config $config
     * @return Application_Service_Flickr
     */
    public function setConfig(Zend_Config $config)
    {
        $this->_config = $config;
        return $this;
    }

    /**
     * @return \Zend_Config
     */
    public function getConfig()
    {
        return $this->_config;
    }

    /**
     * Constructs this service and provides optional configuration
     * settings
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
     * Searches for a particular tag and returns an array of images
     * matching the given tag.
     *
     * @param string $tag
     * @return array
     */
    public function searchForTag($tag)
    {
        $flickr = new Zend_Service_Flickr($this->getConfig()->flickr->key);
        $options = array (
            'per_page' => 15,
            'sort' => 'date-posted-desc',
            'safe_search' => 3,
            'is_commons' => true,
        );
        $resultSet = array ();
        try {
            $resultSet = $flickr->tagSearch($tag);
        } catch (Zend_Exception $e) {
            // TODO Wrap exception handling here
        }
        $results = array ();
        foreach ($resultSet as $result) {
            $results[] = $result;
        }
        return $results;
    }
}