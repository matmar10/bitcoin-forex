<?php

namespace Mtgox\Command;

use BitcoinExchangeRestApi\Command\DynamicCommand as DynamicCommand;

class PrivateCommand extends DynamicCommand
{

    protected $nonce;

    /**
     * @see https://en.bitcoin.it/wiki/MtGox/API/HTTP#PHP
     */
    protected function build()
    {
        parent::build();

        // sign the request
        // see
        $apiKey = $this->client->getApiKey();
        $apiSecret = $this->client->getApiSecret();

        $this->request->addPostFields(array(
            'nonce' => $this->getNonce(),
        ));

        $this->request->addHeader('Rest-Key', $apiKey);
        $postData = $this->request->getPostFields();
        $this->request->addHeader('Rest-Sign', base64_encode( hash_hmac('sha512', $postData, base64_decode($apiSecret), true)));
    }

    public function setNonce($nonce)
    {
        $this->nonce = $nonce;
    }

    public function getNonce()
    {
        if(is_null($this->nonce)) {
            $this->setNonce(self::generateNonce());
        }
        return $this->nonce;
    }

    public static function generateNonce() {
        $mt = explode(' ', microtime());
        return $mt[1] . substr($mt[0], 2, 6);
    }
}
