<?php

namespace Mvdnbrk\DhlParcel\Exceptions;

use Exception;

class DhlParcelException extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @param  string  $message
     * @param  int  $code
     * @return void
     */
    public function __construct(string $message = '', int $code = 0)
    {
        parent::__construct($message, $code);
    }
}
