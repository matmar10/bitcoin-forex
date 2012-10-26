<?php

namespace Blockchain\Command;

use BitcoinExchangeRestApi\Command\DynamicCommand;

class BlockchainCommand extends DynamicCommand
{

    protected function build()
    {
        parent::build();

        $password = $this->client->getPassword();

        $url = $this->request->getUrl(true);
        $query = $url->getQuery();

        $query->add('password', $password);
        $url->setQuery($query);

        $this->request->setUrl($url);

    }
}
