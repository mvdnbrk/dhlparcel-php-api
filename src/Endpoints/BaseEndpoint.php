<?php

namespace Mvdnbrk\DhlParcel\Endpoints;

use Mvdnbrk\DhlParcel\Client;
use Mvdnbrk\DhlParcel\Contracts\ShouldAuthenticate;
use Mvdnbrk\DhlParcel\Exceptions\DhlParcelException;

abstract class BaseEndpoint
{
    /** @var \Mvdnbrk\DhlParcel\Client */
    protected $apiClient;

    public function __construct(Client $client)
    {
        $this->apiClient = $client;
    }

    protected function buildQueryString(array $filters): string
    {
        if (empty($filters)) {
            return '';
        }

        return '?'.http_build_query($filters);
    }

    protected function getRequestHeaders(array $headers): array
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

        if (in_array(collect($response->getHeader('Content-Type'))->first(), ['application/pdf', 'application/zpl'])) {
            return $response->getBody()->getContents();
        }

        $body = $response->getBody()->getContents();

        $object = @json_decode($body);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new DhlParcelException("Unable to decode DHL Parcel response: '{$body}'.");
        }

        if ($response->getStatusCode() >= 400) {
            throw DhlParcelException::createFromResponse($response);
        }

        return $object;
    }
}
