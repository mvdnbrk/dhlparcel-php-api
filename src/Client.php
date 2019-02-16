<?php

namespace Mvdnbrk\DhlParcel;

use GuzzleHttp\RequestOptions;
use Composer\CaBundle\CaBundle;
use GuzzleHttp\Client as HttpClient;

class Client
{
    /**
     * Endpoint of the remote API.
     */
    const API_ENDPOINT = 'https://api-gw.dhlparcel.nl';

    /**
     * @var string
     */
    protected $apiEndpoint = self::API_ENDPOINT;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $userId;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * Create a new Client instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->httpClient = new HttpClient([
            RequestOptions::VERIFY => CaBundle::getBundledCaBundlePath()
        ]);
    }

    /**
     * Sets the API key.
     *
     * @param  string  $value
     * @return \Mvdnbrk\DhlParcel\Client
     */
    public function setApiKey($value)
    {
        $this->apiKey = trim($value);

        return $this;
    }

    /**
     * Sets the user Id.
     *
     * @param  string  $value
     * @return \Mvdnbrk\DhlParcel\Client
     */
    public function setUserId($value)
    {
        $this->userId = trim($value);

        return $this;
    }
}
