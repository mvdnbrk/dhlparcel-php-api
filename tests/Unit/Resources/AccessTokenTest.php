<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Resources;

use Lcobucci\JWT\Builder;
use Mvdnbrk\DhlParcel\Tests\TestCase;
use Mvdnbrk\DhlParcel\Resources\AccessToken;

class AccessTokenTest extends TestCase
{
    /** @test */
    public function create_a_new_access_token()
    {
        $accessToken = new AccessToken(
            (new Builder)->setExpiration(9)->set('accounts', [])->set('roles', [])->getToken()->__toString()
        );

        $this->assertSame('eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIn0.eyJleHAiOjksImFjY291bnRzIjpbXSwicm9sZXMiOltdfQ.', $accessToken->token);
        $this->assertEquals('1970-01-01 00:00:09', $accessToken->expiresAt->format('Y-m-d H:i:s'));
    }

    /** @test */
    public function it_can_determine_if_the_access_token_has_expired()
    {
        $accessToken = new AccessToken(
            (new Builder)->setExpiration(0)->set('accounts', [])->set('roles', [])->getToken()->__toString()
        );

        $this->assertTrue($accessToken->isExpired());

        $accessToken = new AccessToken(
            (new Builder)->setExpiration(time() + 999)->set('accounts', [])->set('roles', [])->getToken()->__toString()
        );

        $this->assertFalse($accessToken->isExpired());
    }

    /** @test */
    public function it_can_retrieve_the_account_id_from_the_token()
    {
        $accessToken = new AccessToken(
            (new Builder)->setExpiration(0)->set('accounts', ['123456'])->set('roles', [])->getToken()->__toString()
        );

        $this->assertEquals('123456', $accessToken->getAccountId());
    }
}
