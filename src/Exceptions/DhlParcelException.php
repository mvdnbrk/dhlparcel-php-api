<?php

namespace Mvdnbrk\DhlParcel\Exceptions;

use Exception;

class DhlParcelException extends Exception
{
    /**
     * @param string  $message
     * @param int  $code
     */
    public function __construct(string $message = '', int $code = 0)
    {
        parent::__construct($message, $code);
    }
}
