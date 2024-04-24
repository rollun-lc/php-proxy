<?php

namespace Proxy\Adapter\Dummy;

use Proxy\Adapter\AdapterInterface;
use Psr\Http\Message\RequestInterface;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;

class DummyAdapter implements AdapterInterface
{
    /**
     * @inheritdoc
     */
    public function send(RequestInterface $request): ResponseInterface
    {
        return new Response($request->getBody(), 200);
    }
}
