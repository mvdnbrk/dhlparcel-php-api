<?php

namespace Mvdnbrk\DhlParcel\Tests;

use Mvdnbrk\DhlParcel\Client;
use Mvdnbrk\DhlParcel\Endpoints\Authentication;
use Mvdnbrk\DhlParcel\Endpoints\Labels;
use Mvdnbrk\DhlParcel\Endpoints\Shipments;
use Mvdnbrk\DhlParcel\Exceptions\DhlParcelException;
use PHPUnit\Framework\Attributes\Test;

class ClientTest extends TestCase
{
    #[Test]
    public function it_has_an_authentication_endpoint(): void
    {
        $this->assertInstanceOf(Authentication::class, $this->client->authentication);
    }

    #[Test]
    public function it_has_a_shipments_endpoint(): void
    {
        $this->assertInstanceOf(Shipments::class, $this->client->shipments);
    }

    #[Test]
    public function it_has_a_labels(): void
    {
        $this->assertInstanceOf(Labels::class, $this->client->labels);
    }

    #[Test]
    public function it_can_set_the_credentials(): void
    {
        $client = (new Client)->setApiKey('test-key')->setUserId('1234');

        $this->assertIsArray($client->credentials());
        $this->assertEquals(['key' => 'test-key', 'userId' => '1234'], $client->credentials());
    }

    #[Test]
    public function setting_an_empty_api_key_throws_an_exception(): void
    {
        $this->expectException(DhlParcelException::class);
        $this->expectExceptionMessage('You have not set an API key. Please use setApiKey() to set the API key.');

        $this->client->setApiKey('');
        $this->client->setUserId('1234');

        $this->client->credentials();
    }

    #[Test]
    public function setting_an_empty_user_id_throws_an_exception(): void
    {
        $this->expectException(DhlParcelException::class);
        $this->expectExceptionMessage('You have not set a user id. Please use setUserId() to set the user id.');

        $this->client->setApiKey('test-key');
        $this->client->setUserId('');

        $this->client->credentials();
    }
}
