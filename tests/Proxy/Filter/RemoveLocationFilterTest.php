<?php

namespace Proxy\Filter;

use Laminas\Diactoros\Request;
use Laminas\Diactoros\Response;
use PHPUnit\Framework\TestCase;

class RemoveLocationFilterTest extends TestCase
{
    private RemoveLocationFilter $filter;

    protected function setUp(): void
    {
        $this->filter = new RemoveLocationFilter();
    }

    /**
     * @test
     */
    public function filter_removes_location()
    {
        $request = new Request();
        $response = new Response('php://memory', 200, [RemoveLocationFilter::LOCATION => 'http://www.example.com']);
        $next = function () use ($response) {
            return $response;
        };

        $response = call_user_func($this->filter, $request, $response, $next);

        $this->assertFalse($response->hasHeader(RemoveLocationFilter::LOCATION));
    }

    /**
     * @test
     */
    public function filter_adds_location_as_xheader()
    {
        $request = new Request();
        $response = new Response('php://memory', 200, [RemoveLocationFilter::LOCATION => 'http://www.example.com']);
        $next = function () use ($response) {
            return $response;
        };

        $response = call_user_func($this->filter, $request, $response, $next);

        $this->assertEquals('http://www.example.com', $response->getHeader('X-Proxy-Location')[0]);
    }
}
