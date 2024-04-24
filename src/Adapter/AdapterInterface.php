<?php

namespace Proxy\Adapter;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface AdapterInterface
{
    /**
     * Send the request and return the response.
     */
    public function send(RequestInterface $request): ResponseInterface;
}
