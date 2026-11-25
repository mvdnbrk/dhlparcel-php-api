<?php

namespace Mvdnbrk\DhlParcel;

use Composer\CaBundle\CaBundle;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Mvdnbrk\DhlParcel\Endpoints\Authentication;
use Mvdnbrk\DhlParcel\Endpoints\Labels;
use Mvdnbrk\DhlParcel\Endpoints\ServicePoints;
use Mvdnbrk\DhlParcel\Endpoints\Shipments;
use Mvdnbrk\DhlParcel\Endpoints\TrackTrace;
use Mvdnbrk\DhlParcel\Exceptions\DhlParcelException;
use Psr\Http\Message\ResponseInterface;

class Client
{
    const API_ENDPOINT = 'https://api-gw.dhlparcel.nl';

    protected string $apiEndpoint = self::API_ENDPOINT;

    protected ?string $accountId = null;

    protected ?string $apiKey = null;

    protected ?string $userId = null;

    protected HttpClient $httpClient;

    public Authentication $authentication;

    public Labels $labels;

    public ServicePoints $servicePoints;

    public Shipments $shipments;

    public TrackTrace $tracktrace;

    public function __construct()
    {
        $this->httpClient = new HttpClient([
            RequestOptions::VERIFY => CaBundle::getBundledCaBundlePath(),
        ]);

        $this->initializeEndpoints();
    }

    public function initializeEndpoints(): void
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
     * @throws \Mvdnbrk\DhlParcel\Exceptions\DhlParcelException
     */
    public function performHttpCall(string $httpMethod, string $apiMethod, ?string $httpBody = null, array $requestHeaders = []): ResponseInterface
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
        } catch (RequestException $e) {
            throw DhlParcelException::createFromGuzzleRequestException($e);
        }

        return $response;
    }

    public function getAccountId(): ?string
    {
        return $this->accountId;
    }

    public function setAccountId(string $value): self
    {
        $this->accountId = trim($value);

        return $this;
    }

    public function setApiKey(string $value): self
    {
        $this->apiKey = trim($value);

        return $this;
    }

    public function setUserId(string $value): self
    {
        $this->userId = trim($value);

        return $this;
    }

    /**
     * @throws \Mvdnbrk\DhlParcel\Exceptions\DhlParcelException
     */
    public function credentials(): array
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
