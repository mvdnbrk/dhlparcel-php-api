<?php

namespace Mvdnbrk\DhlParcel\Endpoints;

use Mvdnbrk\DhlParcel\Client;
use Mvdnbrk\DhlParcel\Contracts\ShouldAuthenticate;
use Mvdnbrk\DhlParcel\Exceptions\DhlParcelException;

abstract class BaseEndpoint
{
    /**
     * @var \Mvdnbrk\DhlParcel\Client
     */
    protected $apiClient;

    /**
     * Create an endpoint instance.
     *
     * @param  \Mvdnbrk\DhlParcel\Client  $client
     * @return  void
     */
    public function __construct(Client $client)
    {
        $this->apiClient = $client;
    }

    /**
     * Build a query string.
     *
     * @param  array  $filters
     * @return string
     */
    protected function buildQueryString(array $filters)
    {
        if (empty($filters)) {
            return '';
        }

        return '?'.http_build_query($filters);
    }

    /**
     * Get request headers.
     *
     * @param  array  $headers
     * @return array
     */
    protected function getRequestHeaders(array $headers)
    {
        if ($this instanceof ShouldAuthenticate) {
            $headers = array_merge($headers, [
                'Authorization' => 'Bearer '.$this->apiClient->authentication->getAccessToken()->token,
            ]);
        }

        return $headers;
    }

    /**
     * Perform a HTTP call to the API endpoint.
     *
     * @param  string  $httpMethod
     * @param  string  $apiMethod
     * @param  string|null  $httpBody
     * @param  array  $requestHeaders
     * @return string|object|null
     *
     * @throws \Mvdnbrk\DhlParcel\Exceptions\DhlParcelException
     */
    protected function performApiCall(string $httpMethod, string $apiMethod, ?string $httpBody = null, array $requestHeaders = [])
    {
        $response = $this->apiClient->performHttpCall(
            $httpMethod,
            $apiMethod,
            $httpBody,
            $this->getRequestHeaders($requestHeaders)
        );

        if (collect($response->getHeader('Content-Type'))->first() == 'application/octet-stream') {
            return $response->getBody()->getContents();
        }

        $body = $response->getBody()->getContents();

        $object = @json_decode($body);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new DhlParcelException("Unable to decode DHL Parcel response: '{$body}'.");
        }

        if ($response->getStatusCode() >= 400) {
            throw new DhlParcelException('Error executing API call: '.$object->message, $response->getStatusCode());
        }

        return $object;
    }
}
