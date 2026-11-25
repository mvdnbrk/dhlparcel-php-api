<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Resources;

use DateInterval;
use DateTimeImmutable;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Builder;
use Mvdnbrk\DhlParcel\Exceptions\DhlParcelException;
use Mvdnbrk\DhlParcel\Resources\AccessToken;
use Mvdnbrk\DhlParcel\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

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

    #[Test]
    public function create_a_new_access_token(): void
    {
        $expires = (new DateTimeImmutable('1970-01-01 00:00:00'))->add(new DateInterval('PT9S'));
        $token = $this->createToken($expires);
        $accessToken = new AccessToken($token);

        $this->assertSame($token, $accessToken->token);
        $this->assertEquals('1970-01-01 00:00:09', $accessToken->expiresAt->format('Y-m-d H:i:s'));
    }

    #[Test]
    public function it_can_determine_if_the_access_token_has_expired(): void
    {
        $expires = (new DateTimeImmutable())->sub(new DateInterval('PT1S'));
        $accessToken = new AccessToken($this->createToken($expires));

        $this->assertTrue($accessToken->isExpired());

        $expires = (new DateTimeImmutable())->add(new DateInterval('PT9S'));
        $accessToken = new AccessToken($this->createToken($expires));

        $this->assertFalse($accessToken->isExpired());
    }

    #[Test]
    public function it_can_retrieve_the_account_id_from_the_token(): void
    {
        $expires = new DateTimeImmutable();
        $accessToken = new AccessToken($this->createToken($expires, ['123456']));

        $this->assertEquals('123456', $accessToken->getAccountId());
    }

    #[Test]
    public function it_can_set_the_account_id(): void
    {
        $expires = new DateTimeImmutable();
        $accessToken = new AccessToken($this->createToken($expires, ['1111', '2222']));

        $accessToken->setAccountId('does-not-exist');

        $this->assertEquals('1111', $accessToken->getAccountId());

        $accessToken->setAccountId('2222');

        $this->assertEquals('2222', $accessToken->getAccountId());
    }

    #[Test]
    public function it_uses_the_account_numbers_from_the_response_when_the_token_has_none(): void
    {
        $expires = new DateTimeImmutable();
        $accessToken = new AccessToken($this->createToken($expires), ['654321']);

        $this->assertEquals('654321', $accessToken->getAccountId());
    }

    #[Test]
    public function the_account_numbers_in_the_token_take_precedence(): void
    {
        $expires = new DateTimeImmutable();
        $accessToken = new AccessToken($this->createToken($expires, ['123456']), ['654321']);

        $this->assertEquals('123456', $accessToken->getAccountId());
    }

    #[Test]
    public function it_throws_an_exception_when_there_is_no_account_number(): void
    {
        $this->expectException(DhlParcelException::class);
        $this->expectExceptionMessage('No DHL account number found for this API key.');

        (new AccessToken($this->createToken(new DateTimeImmutable())))->getAccountId();
    }
}
