<?php

namespace Phpproxy\Response\Converter;


use GuzzleHttp\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class DefaultResponseConverter implements ResponseConverterInterface
{

    /**
     * @param ResponseInterface $response
     * @return Response
     */
    public function convert(ResponseInterface $response)
    {
        return new Response($response->getBody(), $response->getStatusCode(), $response->getHeaders());
    }
}
