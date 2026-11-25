<?php

namespace Mvdnbrk\DhlParcel\Resources;

use DateTimeImmutable;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;

class AccessToken
{
    /** @var array */
    public $accounts;

    public DateTimeImmutable $expiresAt;

    /** @var array */
    public $roles;

    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;

        $this->parseToken();
    }

    private function parseToken(): void
    {
        $token = (new Parser(new JoseEncoder))->parse($this->token);

        $this->expiresAt = $token->claims()->get('exp') ?: new DateTimeImmutable;
        $this->accounts = $token->claims()->get('accounts');
        $this->roles = $token->claims()->get('roles');
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
