<?php
namespace ElephpantOnTour\General;

use \GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;

interface ClientInterface
{
    /**
     * Elephpant Horder Client Interface
     *
     * @param GuzzleClient $guzzleClient
     * @param string $apiKey
     * @param string $apiSecret
     */
    public function __construct(GuzzleClient $guzzleClient, $apiKey, $apiSecret);

    /**
     * @return ResponseInterface
     */
    public function fetch();
}