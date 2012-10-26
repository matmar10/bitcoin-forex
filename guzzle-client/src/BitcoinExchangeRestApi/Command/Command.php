<?php

namespace BitcoinExchangeRestApi\Command;

use Guzzle\Service\Command\AbstractCommand;

abstract class Command extends AbstractCommand
{
    /**
     * Create the result of the command after the request has been completed.
     *
     * Always returns a Response object for consistency (hence the class name)
     */
    protected function process()
    {
        // Uses the response object by default
        $this->result = $this->getRequest()->getResponse();
    }
}
