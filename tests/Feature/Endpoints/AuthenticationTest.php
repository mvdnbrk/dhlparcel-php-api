<?php

namespace Mvdnbrk\DhlParcel\Tests\Feature\Endpoints;

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use Mvdnbrk\DhlParcel\Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_an_access_token()
    {
        $accessToken = $this->client->authentication->getAccessToken();

        $this->assertTrue(
            (new Parser)->parse($accessToken->token)->validate(new ValidationData())
        );
        $this->assertFalse($accessToken->isExpired());
        $this->assertEquals(getenv('DHLPARCEL_ACCOUNT_ID'), $accessToken->getAccountId());
    }
}
