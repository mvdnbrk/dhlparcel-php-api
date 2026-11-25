<?php

namespace Mvdnbrk\DhlParcel\Resources;

use DateTimeImmutable;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;
use Mvdnbrk\DhlParcel\Exceptions\DhlParcelException;

class AccessToken
{
    /** @var array */
    public $accounts;

    public DateTimeImmutable $expiresAt;

    /** @var array */
    public $roles;

    public string $token;

    /**
     * Create a new access token.
     *
     * DHL returns the account numbers in the authentication response.
     * Older tokens also carry them in the "accounts" claim.
     */
    public function __construct(string $token, array $accountNumbers = [])
    {
        $this->token = $token;

        $this->parseToken($accountNumbers);
    }

    private function parseToken(array $accountNumbers): void
    {
        $token = (new Parser(new JoseEncoder))->parse($this->token);

        $this->expiresAt = $token->claims()->get('exp') ?: new DateTimeImmutable;
        $this->accounts = $token->claims()->get('accounts') ?: $accountNumbers;
        $this->roles = $token->claims()->get('roles');
    }

    public function isExpired(): bool
    {
        return $this->expiresAt <= new DateTimeImmutable;
    }

    public function getAccountId(): string
    {
        $accountId = collect($this->accounts)->first();

        if (empty($accountId)) {
            throw new DhlParcelException('No DHL account number found for this API key.');
        }

        return $accountId;
    }

    public function setAccountId(?string $value): void
    {
        if (collect($this->accounts)->contains($value)) {
            $this->accounts = [$value];
        }
    }
}
