<?php
namespace ElephpantOnTour;

use \GuzzleHttp\Client as GuzzleClient;
use \ElephpantOnTour\Flickr\Client as FlickrClient;

// Flickr API Keys: https://www.flickr.com/services/apps/by/dragonbe
define('FLICKR_API_KEY', '5b1f2614e24835b336d422967e09783e');
define('FLICKR_API_SEC', 'a84b552cdbdb7c27');

/**
 * Class Horder
 *
 * Named this class after Cal Evans posted a picture of his elePHPant
 * collection on Twitter referring to himself as horder.
 *
 * @link https://twitter.com/CalEvans/status/708021581335928834
 * @package ElephpantOnTour
 */
class Horder
{
    protected $guzzleClient;
    /**
     * @var FlickrClient
     */
    protected $flickr;

    public function __construct()
    {
        $guzzleClient = new GuzzleClient;
        $this->flickr = new FlickrClient($guzzleClient, FLICKR_API_KEY, FLICKR_API_SEC);
    }

    /**
     * @return FlickrClient
     */
    public function getFlickr()
    {
        return $this->flickr;
    }

    /**
     * @param FlickrClient $flickr
     * @return Horder
     */
    public function setFlickr($flickr)
    {
        $this->flickr = $flickr;
        return $this;
    }

}