<?php

namespace Mvdnbrk\DhlParcel\Exceptions;

class DhlParcelException extends \Exception
{
    /**
     * @param string  $message
     * @param int  $code
     */
    public function __construct($message = '', $code = 0)
    {
        parent::__construct($message, $code);
    }
}
