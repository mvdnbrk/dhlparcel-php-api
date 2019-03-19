<?php

namespace Mvdnbrk\DhlParcel\Endpoints;

use Mvdnbrk\DhlParcel\Client;
use Mvdnbrk\DhlParcel\Exceptions\DhlParcelException;

abstract class BaseEndpoint
{
    /**
     * @var \Mvdnbrk\DhlParcel\Client
     */
    protected $apiClient;

    /**
     * Indicates if this endpoint needs authentication.
     *
     * @var bool
     */
    protected $mustAuthenticate = false;

    /**
     * Create an endpoint instance.
     *
     * @param  \Mvdnbrk\DhlParcel\Client  $client
     * @return  void
     */
    public function __construct(Client $client)
    {
        $this->apiClient = $client;

        $this->boot();
    }


    /**
     * Boot the endpoint instance.
     *
     * @return void
     */
    protected function boot()
    {
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

    protected function requestHeaders($headers)
    {
        return collect($headers)
            ->when($this->mustAuthenticate, function ($collection) {
                return $collection->merge([
                    'Authorization' => 'Bearer '.$this->apiClient->authentication->getAccessToken()->token,
                ]);
            })
            ->all();
    }

    /**
     * Performs a HTTP call to the API endpoint
     *
     * @param  string  $httpMethod          The method to make the API call. GET/POST etc,
     * @param  string  $apiMethod           The API method to call at the endpoint.
     * @param  string|null  $httpBody       The body to be send with te request.
     * @param  array  $requestHeaders       Request headers to be send with the request.
     * @return string|object|null           The body of the response.
     * @throws \Mvdnbrk\DhlParcel\Exceptions\DhlParcelException
     */
    protected function performApiCall($httpMethod, $apiMethod, $httpBody = null, $requestHeaders = [])
    {
        $response = $this->apiClient->performHttpCall($httpMethod, $apiMethod, $httpBody, $this->requestHeaders($requestHeaders));

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
