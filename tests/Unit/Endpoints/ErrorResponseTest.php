<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Endpoints;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Mvdnbrk\DhlParcel\Client;
use Mvdnbrk\DhlParcel\Exceptions\DhlParcelException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

class ErrorResponseTest extends TestCase
{
    private function clientReturning(Response $response): Client
    {
        $client = (new Client)->setUserId('user-id')->setApiKey('api-key');

        $property = new ReflectionProperty(Client::class, 'httpClient');
        $property->setValue($client, new HttpClient([
            'handler' => HandlerStack::create(new MockHandler([$response])),
        ]));

        return $client;
    }

    #[Test]
    public function an_unauthorized_response_throws_an_authentication_exception(): void
    {
        $client = $this->clientReturning(new Response(401));

        try {
            $client->authentication->getAccessToken();
            $this->fail('Expected a DhlParcelException.');
        } catch (DhlParcelException $e) {
            $this->assertSame('Authentication failed', $e->getMessage());
            $this->assertSame(401, $e->getCode());
            $this->assertSame(401, $e->getResponse()->getStatusCode());
        }
    }

    #[Test]
    public function an_error_response_without_json_throws_an_exception_with_the_status_code(): void
    {
        $client = $this->clientReturning(new Response(502, ['Content-Type' => 'text/html'], '<html>Bad Gateway</html>'));

        try {
            $client->authentication->getAccessToken();
            $this->fail('Expected a DhlParcelException.');
        } catch (DhlParcelException $e) {
            $this->assertSame('Error executing API call: HTTP 502 Bad Gateway.', $e->getMessage());
            $this->assertSame(502, $e->getCode());
            $this->assertTrue($e->hasResponse());
        }
    }

    #[Test]
    public function an_error_response_with_json_uses_the_message_from_dhl(): void
    {
        $client = $this->clientReturning(new Response(400, ['Content-Type' => 'application/json'], '{"message":"Invalid request"}'));

        try {
            $client->authentication->getAccessToken();
            $this->fail('Expected a DhlParcelException.');
        } catch (DhlParcelException $e) {
            $this->assertSame('Error executing API call: Invalid request', $e->getMessage());
            $this->assertSame(400, $e->getCode());
        }
    }
}
