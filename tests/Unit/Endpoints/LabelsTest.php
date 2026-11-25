<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Endpoints;

use DateInterval;
use DateTimeImmutable;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Builder;
use Mvdnbrk\DhlParcel\Client;
use Mvdnbrk\DhlParcel\Endpoints\Labels;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

class LabelsTest extends TestCase
{
    private array $history = [];

    private function clientReturning(Response $label): Client
    {
        $token = (new Builder(new JoseEncoder, ChainedFormatter::default()))
            ->expiresAt((new DateTimeImmutable)->add(new DateInterval('PT1H')))
            ->withClaim('accounts', ['123456'])
            ->getToken(new Sha256, InMemory::plainText(str_repeat('a', 32)))
            ->toString();

        $stack = HandlerStack::create(new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode(['accessToken' => $token])),
            $label,
        ]));
        $stack->push(Middleware::history($this->history));

        $client = (new Client)->setUserId('user-id')->setApiKey('api-key');
        (new ReflectionProperty(Client::class, 'httpClient'))->setValue($client, new HttpClient(['handler' => $stack]));

        return $client;
    }

    #[Test]
    public function it_retrieves_a_pdf_label_by_default(): void
    {
        $client = $this->clientReturning(new Response(200, ['Content-Type' => 'application/pdf'], '%PDF-label'));

        $this->assertSame('%PDF-label', $client->labels->get('label-id'));
        $this->assertSame('application/pdf', $this->history[1]['request']->getHeaderLine('Accept'));
        $this->assertSame('/labels/label-id', $this->history[1]['request']->getUri()->getPath());
    }

    #[Test]
    public function it_can_retrieve_a_zpl_label(): void
    {
        $client = $this->clientReturning(new Response(200, ['Content-Type' => 'application/zpl'], '^XA^XZ'));

        $this->assertSame('^XA^XZ', $client->labels->get('label-id', Labels::ZPL));
        $this->assertSame('application/zpl', $this->history[1]['request']->getHeaderLine('Accept'));
    }

    #[Test]
    public function the_zpl_method_retrieves_a_zpl_label(): void
    {
        $client = $this->clientReturning(new Response(200, ['Content-Type' => 'application/zpl'], '^XA^XZ'));

        $this->assertSame('^XA^XZ', $client->labels->zpl('label-id'));
        $this->assertSame('application/zpl', $this->history[1]['request']->getHeaderLine('Accept'));
    }

    #[Test]
    public function the_pdf_method_retrieves_a_pdf_label(): void
    {
        $client = $this->clientReturning(new Response(200, ['Content-Type' => 'application/pdf'], '%PDF-label'));

        $this->assertSame('%PDF-label', $client->labels->pdf('label-id'));
        $this->assertSame('application/pdf', $this->history[1]['request']->getHeaderLine('Accept'));
    }
}
