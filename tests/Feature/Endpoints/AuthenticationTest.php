<?php

namespace Mvdnbrk\DhlParcel\Tests\Feature\Endpoints;

use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Validation\Constraint\IdentifiedBy;
use Lcobucci\JWT\Validation\Validator;
use Mvdnbrk\DhlParcel\Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;

#[Group('integration')]
class AuthenticationTest extends TestCase
{
    #[Test]
    public function it_can_retrieve_an_access_token(): void
    {
        $accessToken = $this->client->authentication->getAccessToken();
        $parsedToken = (new Parser(new JoseEncoder))->parse($accessToken->token);

        $this->assertTrue(
            (new Validator)->validate(
                $parsedToken,
                new IdentifiedBy($parsedToken->claims()->get('jti'))
            )
        );
        $this->assertFalse($accessToken->isExpired());
        $this->assertEquals(getenv('DHLPARCEL_ACCOUNT_ID'), $accessToken->getAccountId());
    }
}
