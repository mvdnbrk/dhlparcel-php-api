<?php

namespace Mvdnbrk\DhlParcel\Exceptions;

use Exception;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class DhlParcelException extends Exception
{
    /**
     * @var \GuzzleHttp\Psr7\Response
     */
    protected $response;

    /**
     * Create a new DhlParcelException instance.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  \GuzzleHttp\Psr7\Response|null  $response
     * @param  \Throwable|null  $previous
     * @return void
     */
    public function __construct(string $message = '', int $code = 0, ResponseInterface $response = null, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->response = $response;
    }

    /**
     *  Create a new DhlParcelException instance from the given Guzzle request exception.
     *
     * @param  \GuzzleHttp\Exception\RequestException  $exception
     * @param  \Throwable|null  $previous
     * @return static
     */
    public static function createFromGuzzleRequestException(RequestException $exception, Throwable $previous = null)
    {
        return new static(
            $exception->getMessage(),
            $exception->getCode(),
            $exception->getResponse(),
            $previous
        );
    }

    /**
     * Create a new DhlParcelException instance from the given response.
     *
     * @param  \Psr\Http\Message\ResponseInterface  $response
     * @param  \Throwable|null  $previous
     * @return static
     */
    public static function createFromResponse(ResponseInterface $response, Throwable $previous = null)
    {
        $object = static::parseResponseBody($response);

        return new static(
            'Error executing API call: '.$object->message,
            $response->getStatusCode(),
            $response,
            $previous
        );
    }

    /**
     * Determine if a response was received for this exception.
     *
     * @return bool
     */
    public function hasResponse()
    {
        return $this->response !== null;
    }

    /**
     * Get the response associated with this exception.
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Parse the body of a response.
     *
     * @param  \Psr\Http\Message\ResponseInterface  $response
     * @return object
     * @throws \Mvdnbrk\DhlParcel\Exceptions\DhlParcelException
     */
    protected static function parseResponseBody(ResponseInterface $response)
    {
        $body = (string) $response->getBody();

        $object = @json_decode($body);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new static("Unable to decode DHL Parcel response: '{$body}'.");
        }

        return $object;
    }
}
