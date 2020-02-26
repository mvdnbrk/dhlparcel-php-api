<?php

namespace Mvdnbrk\DhlParcel\Exceptions;

use Exception;
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
}
