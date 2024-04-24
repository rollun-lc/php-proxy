<?php
namespace Proxy\Filter;

use Laminas\Diactoros\Request;
use Laminas\Diactoros\Response;
use PHPUnit\Framework\TestCase;

class RewriteLocationFilterTest extends TestCase
{
    private RewriteLocationFilter $filter;

    protected function setUp(): void
    {
        $this->filter = new RewriteLocationFilter();
    }

    /**
     * @test
     */
    public function filter_rewrites_location()
    {
        $_SERVER['SCRIPT_NAME'] = "";
        $redirect_url = 'http://www.example.com/path?arg1=123&arg2=456';

        $request = new Request();
        $response = new Response('php://memory', 200, [RewriteLocationFilter::LOCATION => $redirect_url]);
        $next = function () use ($response) {
            return $response;
        };

        $response = call_user_func($this->filter, $request, $response, $next);

        $this->assertTrue($response->hasHeader('X-Proxy-Location'));
        $this->assertTrue($response->hasHeader(RewriteLocationFilter::LOCATION));
        $this->assertEquals('/path?arg1=123&arg2=456', $response->getHeaderLine(RewriteLocationFilter::LOCATION));
    }
}
