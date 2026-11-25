<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Resources;

use DateInterval;
use DateTimeImmutable;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Builder;
use Mvdnbrk\DhlParcel\Resources\AccessToken;
use Mvdnbrk\DhlParcel\Tests\TestCase;

class AccessTokenTest extends TestCase
{
    private function createToken(DateTimeImmutable $expires, array $accounts = []): string
    {
        return (new Builder(new JoseEncoder, ChainedFormatter::default()))
            ->expiresAt($expires)
            ->withClaim('accounts', $accounts)
            ->withClaim('roles', [])
            ->getToken(new Sha256, InMemory::plainText(str_repeat('a', 32)))
            ->toString();
    }

    /** @test */
    public function create_a_new_access_token()
    {
        $expires = (new DateTimeImmutable('1970-01-01 00:00:00'))->add(new DateInterval('PT9S'));
        $token = $this->createToken($expires);
        $accessToken = new AccessToken($token);

        $this->assertSame($token, $accessToken->token);
        $this->assertEquals('1970-01-01 00:00:09', $accessToken->expiresAt->format('Y-m-d H:i:s'));
    }

    /** @test */
    public function it_can_determine_if_the_access_token_has_expired()
    {
        $expires = (new DateTimeImmutable())->sub(new DateInterval('PT1S'));
        $accessToken = new AccessToken($this->createToken($expires));

        $this->assertTrue($accessToken->isExpired());

        $expires = (new DateTimeImmutable())->add(new DateInterval('PT9S'));
        $accessToken = new AccessToken($this->createToken($expires));

        $this->assertFalse($accessToken->isExpired());
    }

    /** @test */
    public function it_can_retrieve_the_account_id_from_the_token()
    {
        $expires = new DateTimeImmutable();
        $accessToken = new AccessToken($this->createToken($expires, ['123456']));

        $this->assertEquals('123456', $accessToken->getAccountId());
    }

    /** @test */
    public function it_can_set_the_account_id()
    {
        $expires = new DateTimeImmutable();
        $accessToken = new AccessToken($this->createToken($expires, ['1111', '2222']));

        $accessToken->setAccountId('does-not-exist');

        $this->assertEquals('1111', $accessToken->getAccountId());

        $accessToken->setAccountId('2222');

        $this->assertEquals('2222', $accessToken->getAccountId());
    }
}
