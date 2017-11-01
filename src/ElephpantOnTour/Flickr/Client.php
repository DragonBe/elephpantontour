<?php
namespace ElephpantOnTour\Flickr;

use \GuzzleHttp\Client as GuzzleClient;

class Client
{
    /**
     * @var GuzzleClient
     */
    protected $guzzleClient;
    /**
     * @var string
     */
    protected $apiKey;
    /**
     * @var string
     */
    protected $apiSecret;

    /**
     * Client constructor.
     *
     * @param GuzzleClient $guzzleClient
     * @param string $apiKey
     * @param string $apiSecret
     */
    public function __construct(GuzzleClient $guzzleClient, $apiKey, $apiSecret)
    {
        $this->guzzleClient = $guzzleClient;
        $this->apiKey = (string) $apiKey;
        $this->apiSecret = (string) $apiSecret;
    }


    public function authenticate()
    {

    }

    public function fetch($count = 0, $offset = 0)
    {
        $url = 'https://api.flickr.com/services/feeds/photos_public.gne';
        $params = [
            'tags' => 'elephpant,elephpants',
            'tagmode' => 'any',
            'format' => 'xml',
        ];

        $feedFile = __DIR__ . '/../../../feed.xml';
        $body = file_get_contents($feedFile);
        if (86.400 < (time() - filemtime($feedFile))) {
            $response = $this->guzzleClient->request(
                'GET',
                $url,
                [
                    'query' => $params,
                ]
            );
            $body = $response->getBody();
            file_put_contents($feedFile, $body);
        }
        $feed = $this->processFeed($body);
        return $feed;
    }

    protected function processFeed($xmlContent)
    {
        $images = [];
        $feed = new \DOMDocument();
        $feed->loadXML($xmlContent);
        $entries = $feed->getElementsByTagName('entry');
        foreach ($entries as $entry) {
            /** @var \DOMElement $entry */
            $titles = $entry->getElementsByTagName('title');
            $links = $entry->getElementsByTagName('link');
            $authors = $entry->getElementsByTagName('author');

            $title = $titles[0]->textContent;

            $authorNames = $authors[0]->getElementsByTagName('name');
            $authorName = $authorNames[0]->textContent;
            $authorLinks = $authors[0]->getElementsByTagName('uri');
            $authorLink = $authorLinks[0]->textContent;

            $imageLink = '';
            $imageRef = '';
            foreach ($links as $link) {
                /** @var \DOMElement $link */
                if ($link->hasAttribute('rel') && 'enclosure' === $link->getAttribute('rel')) {
                    $imageLink = $link->getAttribute('href');
                }
                if ($link->hasAttribute('rel') && 'alternate' === $link->getAttribute('rel')) {
                    $imageRef = $link->getAttribute('href');
                }
            }

            $image = [
                'imageTitle' => $title,
                'imageLink' => $imageLink,
                'imageRef' => $imageRef,
                'authorName' => $authorName,
                'authorLink' => $authorLink,
            ];
            $images[] = $image;
        }
        return $images;
    }

}