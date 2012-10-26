<?php

namespace Blockchain;

use Guzzle\Service\Client;
use Guzzle\Service\Inspector;
use Guzzle\Service\Description\ServiceDescription;

class BlockchainClient extends Client
{

    public static function factory($config = array())
    {
        $default = array(
            'base_url' => '{scheme}://blockchain.info/merchant/{guid}',
            'scheme' => 'https',
        );
        $required = array(
            'base_url',
            'guid',
            'password',
        );
        $config = Inspector::prepareConfig($config, $default, $required);

        $client = new self(
            $config->get('base_url'),
            $config->get('guid'),
            $config->get('password')
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
     * @param string $guid The merchant guid
     * @param string $apiSecret The merchant password
     */
    public function __construct($baseUrl, $guid, $password)
    {
        parent::__construct($baseUrl, array(
            'curl.CURLOPT_SSL_VERIFYPEER' => false,
        ));
        $this->guid = $guid;
        $this->password = $password;

        $userAgent = 'Mozilla/4.0 (compatible; MtGox PHP client; '.php_uname('s').'; PHP/'.phpversion().')';
        $this->setUserAgent($userAgent);
    }

    public function setGuid($guid)
    {
        $this->guid = $guid;
    }

    public function getApiKey()
    {
        return $this->guid;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }
}
