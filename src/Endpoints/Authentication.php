<?php

namespace Mvdnbrk\DhlParcel\Endpoints;

use Mvdnbrk\DhlParcel\Resources\AccessToken;

class Authentication extends BaseEndpoint
{
    /**
     * @var \Mvdnbrk\DhlParcel\Resources\AccessToken
     */
    protected $accessToken;

    /**
     * Retrieve a new access token.
     *
     * @return \Mvdnbrk\DhlParcel\Resources\AccessToken
     */
    protected function retrieveAccessToken()
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
     *
     * @return \Mvdnbrk\DhlParcel\Resources\AccessToken
     */
    public function getAccessToken()
    {
        if (! $this->accessToken || $this->accessToken->isExpired()) {
            $this->accessToken = $this->retrieveAccessToken();
        }

        return $this->accessToken;
    }

    /**
     * Get the http body for the API request.
     *
     * @return string
     */
    protected function getHttpBody()
    {
        return json_encode($this->apiClient->credentials());
    }
}
