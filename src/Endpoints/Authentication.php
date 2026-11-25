<?php

namespace Mvdnbrk\DhlParcel\Endpoints;

use Mvdnbrk\DhlParcel\Resources\AccessToken;

class Authentication extends BaseEndpoint
{
    protected ?AccessToken $accessToken = null;

    /**
     * Retrieve a new access token.
     */
    protected function retrieveAccessToken(): AccessToken
    {
        $response = $this->performApiCall(
            'POST',
            'authenticate/api-key',
            $this->getHttpBody()
        );

        return new AccessToken($response->accessToken);
    }

    /**
     * Get the access token.
     */
    public function getAccessToken(): AccessToken
    {
        if (! $this->accessToken || $this->accessToken->isExpired()) {
            $this->accessToken = $this->retrieveAccessToken();

            $this->accessToken->setAccountId($this->apiClient->getAccountId());
        }

        return $this->accessToken;
    }

    /**
     * Get the http body for the API request.
     */
    protected function getHttpBody(): string
    {
        return json_encode($this->apiClient->credentials());
    }
}
