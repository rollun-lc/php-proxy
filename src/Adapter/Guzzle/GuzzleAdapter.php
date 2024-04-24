<?php

namespace Proxy\Adapter\Guzzle;

use GuzzleHttp\Client;
use Proxy\Adapter\AdapterInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GuzzleAdapter implements AdapterInterface
{
    /**
     * The Guzzle client instance.
     */
    protected Client $client;

    /**
     * Construct a Guzzle based HTTP adapter.
     */
    public function __construct(?Client $client = null)
    {
        $this->client = $client ?: new Client;
    }

    /**
     * @inheritdoc
     */
    public function send(RequestInterface $request): ResponseInterface
    {
        return $this->client->send($request);
    }
}
