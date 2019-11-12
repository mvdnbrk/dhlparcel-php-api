<?php

namespace Mvdnbrk\DhlParcel\Tests;

use Mvdnbrk\DhlParcel\Client;
use Mvdnbrk\DhlParcel\Endpoints\Authentication;
use Mvdnbrk\DhlParcel\Endpoints\Labels;
use Mvdnbrk\DhlParcel\Endpoints\Shipments;
use Mvdnbrk\DhlParcel\Exceptions\DhlParcelException;

class ClientTest extends TestCase
{
    /** @test */
    public function it_has_an_authentication_endpoint()
    {
        $this->assertInstanceOf(Authentication::class, $this->client->authentication);
    }

    /** @test */
    public function it_has_a_shipments_endpoint()
    {
        $this->assertInstanceOf(Shipments::class, $this->client->shipments);
    }

    /** @test */
    public function it_has_a_labels()
    {
        $this->assertInstanceOf(Labels::class, $this->client->labels);
    }

    /** @test */
    public function it_can_set_the_credentials()
    {
        $client = (new Client)->setApiKey('test-key')->setUserId('1234');

        $this->assertIsArray($client->credentials());
        $this->assertEquals(['key' => 'test-key', 'userId' => '1234'], $client->credentials());
    }

    /** @test */
    public function setting_an_empty_api_key_throws_an_exception()
    {
        $this->expectException(DhlParcelException::class);
        $this->expectExceptionMessage('You have not set an API key. Please use setApiKey() to set the API key.');

        $this->client->setApiKey('');
        $this->client->setUserId('1234');

        $this->client->credentials();
    }

    /** @test */
    public function setting_an_empty_user_id_throws_an_exception()
    {
        $this->expectException(DhlParcelException::class);
        $this->expectExceptionMessage('You have not set a user id. Please use setUserId() to set the user id.');

        $this->client->setApiKey('test-key');
        $this->client->setUserId(null);

        $this->client->credentials();
    }
}
