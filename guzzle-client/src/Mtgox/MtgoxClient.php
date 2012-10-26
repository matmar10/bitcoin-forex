<?php

namespace Mtgox;

use Guzzle\Service\Client;
use Guzzle\Service\Inspector;
use Guzzle\Service\Description\ServiceDescription;

class MtgoxClient extends Client
{

    protected $apiKey;

    protected $apiSecret;

    public static function factory($config = array())
    {
        $default = array(
            'base_url' => '{scheme}://mtgox.com/',
            'scheme' => 'https',
        );
        $required = array(
            'base_url',
            'api_key',
            'api_secret',
        );
        $config = Inspector::prepareConfig($config, $default, $required);

        $client = new self(
            $config->get('base_url'),
            $config->get('api_key'),
            $config->get('api_secret')
        );
        $client->setConfig($config);

        // Uncomment the following two lines to use an XML service description
        $client->setDescription(ServiceDescription::factory(__DIR__ . '/' . 'client.xml'));

        return $client;
    }

    /**
     * Client constructor
     *
     * @param string $baseUrl  Base URL of the web service
     * @param string $apiKey API access key
     * @param string $apiSecret API secret to sign the request
     */
    public function __construct($baseUrl, $apiKey, $apiSecret)
    {
        parent::__construct($baseUrl, array(
            'curl.CURLOPT_SSL_VERIFYPEER' => false,
        ));
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;

        $userAgent = 'Mozilla/4.0 (compatible; MtGox PHP client; '.php_uname('s').'; PHP/'.phpversion().')';
        $this->setUserAgent($userAgent);
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function setApiSecret($apiSecret)
    {
        $this->apiSecret = $apiSecret;
    }

    public function getApiSecret()
    {
        return $this->apiSecret;
    }
}
