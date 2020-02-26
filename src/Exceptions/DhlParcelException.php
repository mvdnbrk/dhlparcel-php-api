<?php

namespace Mvdnbrk\DhlParcel\Exceptions;

use Exception;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
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
    public function __construct(string $message = '', int $code = 0, Response $response = null, Throwable $previous = null)
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
}
