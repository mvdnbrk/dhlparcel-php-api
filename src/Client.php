<?php

namespace Mvdnbrk\DhlParcel;

use Composer\CaBundle\CaBundle;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Mvdnbrk\DhlParcel\Endpoints\Authentication;
use Mvdnbrk\DhlParcel\Endpoints\Labels;
use Mvdnbrk\DhlParcel\Endpoints\ServicePoints;
use Mvdnbrk\DhlParcel\Endpoints\Shipments;
use Mvdnbrk\DhlParcel\Endpoints\TrackTrace;
use Mvdnbrk\DhlParcel\Exceptions\DhlParcelException;

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
    protected $accountId;

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
     * @var \Mvdnbrk\DhlParcel\Endpoints\Authentication
     */
    public $authentication;

    /**
     * @var \Mvdnbrk\DhlParcel\Endpoints\Labels
     */
    public $labels;

    /**
     * @var \Mvdnbrk\DhlParcel\Endpoints\ServicePoints
     */
    public $servicePoints;

    /**
     * @var \Mvdnbrk\DhlParcel\Endpoints\Shipments
     */
    public $shipments;

    /**
     * @var \Mvdnbrk\DhlParcel\Endpoints\TrackTrace
     */
    public $tracktrace;

    /**
     * Create a new Client instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->httpClient = new HttpClient([
            RequestOptions::VERIFY => CaBundle::getBundledCaBundlePath(),
        ]);

        $this->initializeEndpoints();
    }

    /**
     * Initialize the API endpoints used by this client.
     *
     * @return void
     */
    public function initializeEndpoints()
    {
        $this->authentication = new Authentication($this);
        $this->labels = new Labels($this);
        $this->servicePoints = new ServicePoints($this);
        $this->shipments = new Shipments($this);
        $this->tracktrace = new TrackTrace($this);
    }

    /**
     * Performs a HTTP call to the API endpoint.
     *
     * @param  string  $httpMethod          The method to make the API call. GET/POST etc,
     * @param  string  $apiMethod           The API method to call at the endpoint.
     * @param  string|null  $httpBody       The body to be send with te request.
     * @param  array  $requestHeaders       Request headers to be send with the request.
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Mvdnbrk\DhlParcel\Exceptions\DhlParcelException
     */
    public function performHttpCall($httpMethod, $apiMethod, $httpBody = null, $requestHeaders = [])
    {
        $url = $this->apiEndpoint.'/'.$apiMethod;

        $headers = collect([
                'Accept' => 'application/json',
            ])
            ->merge($requestHeaders)
            ->when($httpBody !== null, function ($headers) {
                return $headers->put('Content-Type', 'application/json');
            })
            ->all();

        $request = new Request($httpMethod, $url, $headers, $httpBody);

        try {
            $response = $this->httpClient->send($request, ['http_errors' => false]);
        } catch (GuzzleException $e) {
            throw new DhlParcelException($e->getMessage(), $e->getCode());
        }

        if (! $response) {
            throw new DhlParcelException('No API response received.');
        }

        return $response;
    }

    /**
     * Get the account id.
     *
     * @return string
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Sets the account id.
     *
     * @param  string  $value
     * @return \Mvdnbrk\DhlParcel\Client
     */
    public function setAccountId($value)
    {
        $this->accountId = trim($value);

        return $this;
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

    /**
     * Retrieve the credentials.
     *
     * @return array
     * @throws \Mvdnbrk\DhlParcel\Exceptions\DhlParcelException
     */
    public function credentials()
    {
        if (empty($this->userId)) {
            throw new DhlParcelException('You have not set a user id. Please use setUserId() to set the user id.');
        }

        if (empty($this->apiKey)) {
            throw new DhlParcelException('You have not set an API key. Please use setApiKey() to set the API key.');
        }

        return [
            'userId' => $this->userId,
            'key' => $this->apiKey,
        ];
    }
}
