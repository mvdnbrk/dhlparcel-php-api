<?php

namespace Mvdnbrk\DhlParcel\Tests;

use Mvdnbrk\DhlParcel\Client;

class MyParcelServiceProviderTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_a_client_instance()
    {
        $this->assertInstanceOf(Client::class, resolve('dhlparcel'));
    }
}
