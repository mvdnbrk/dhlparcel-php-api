<?php

namespace Mvdnbrk\DhlParcel\Resources;

use DateTimeImmutable;
use Lcobucci\JWT\Parser;

class AccessToken
{
    /**
     * @var array
     */
    public $accounts;

    /**
     * @var \DateTimeImmutable
     */
    public $expiresAt;

    /**
     * @var array
     */
    public $roles;

    /**
     * @var string
     */
    public $token;

    /**
     * Create a new AccessToken instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;

        $this->parseToken();
    }

    /**
     * Parse the token claims.
     *
     * @return void
     */
    private function parseToken()
    {
        $token = (new Parser)->parse($this->token);

        $this->expiresAt = (new DateTimeImmutable)->setTimestamp($token->getClaim('exp'));
        $this->accounts = $token->getClaim('accounts');
        $this->roles = $token->getClaim('roles');
    }

    /**
     * Determine if the access token is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->expiresAt < (new DateTimeImmutable)->setTimestamp(time());
    }

    /**
     * Retrieve the account id from the token.
     *
     * @return string
     */
    public function getAccountId()
    {
        return collect($this->accounts)->first();
    }

    /**
     * Set the account id.
     *
     * @param  string  $value
     * @return void
     */
    public function setAccountId($value)
    {
        if (collect($this->accounts)->contains($value)) {
            $this->accounts = [$value];
        }
    }
}
