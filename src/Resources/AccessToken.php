<?php

namespace Mvdnbrk\DhlParcel\Resources;

use DateTimeImmutable;
use Lcobucci\JWT\Parser;

class AccessToken
{
    /** @var array */
    public $accounts;

    /** @var \DateTimeImmutable */
    public $expiresAt;

    /** @var array */
    public $roles;

    /** @var string */
    public $token;

    public function __construct(string $token)
    {
        $this->token = $token;

        $this->parseToken();
    }

    private function parseToken(): void
    {
        $token = (new Parser)->parse($this->token);

        $this->expiresAt = (new DateTimeImmutable)->setTimestamp($token->getClaim('exp')) ?: new DateTimeImmutable;
        $this->accounts = $token->getClaim('accounts');
        $this->roles = $token->getClaim('roles');
    }

    public function isExpired(): bool
    {
        return $this->expiresAt <= new DateTimeImmutable;
    }

    public function getAccountId(): string
    {
        return collect($this->accounts)->first();
    }

    public function setAccountId(?string $value): void
    {
        if (collect($this->accounts)->contains($value)) {
            $this->accounts = [$value];
        }
    }
}
