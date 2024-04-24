<?php

namespace Proxy\Proxy\Adapter\Guzzle;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Laminas\Diactoros\Request;
use PHPUnit\Framework\TestCase;
use Proxy\Adapter\Guzzle\GuzzleAdapter;
use Psr\Http\Message\ResponseInterface;

class GuzzleAdapterTest extends TestCase
{
    private GuzzleAdapter $adapter;

    private array $headers = ['Server' => 'Mock'];

    private int $status = 200;

    private string $body = 'Totally awesome response body';

    protected function setUp(): void
    {
        $mock = new MockHandler([
            $this->createResponse(),
        ]);

        $client = new Client(['handler' => $mock]);

        $this->adapter = new GuzzleAdapter($client);
    }

    /**
     * @test
     */
    public function adapter_returns_psr_response()
    {
        $response = $this->sendRequest();

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    /**
     * @test
     */
    public function response_contains_body()
    {
        $response = $this->sendRequest();

        $this->assertEquals($this->body, $response->getBody());
    }

    /**
     * @test
     */
    public function response_contains_statuscode()
    {
        $response = $this->sendRequest();

        $this->assertEquals($this->status, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function response_contains_header()
    {
        $response = $this->sendRequest();

        $this->assertEquals('Mock', $response->getHeader('Server')[0]);
    }

    /**
     * @test
     */
    public function adapter_sends_request()
    {
        $request = new Request('http://localhost', 'GET');

        $clientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock->expects($this->once())
            ->method('send')
            ->with($request)
            ->willReturn($this->createResponse());

        $adapter = new GuzzleAdapter($clientMock);

        $adapter->send($request);
    }

    private function sendRequest(): ResponseInterface
    {
        $request = new Request('http://localhost', 'GET');

        return $this->adapter->send($request);
    }

    private function createResponse(): ResponseInterface
    {
        return new GuzzleResponse($this->status, $this->headers, $this->body);
    }
}
