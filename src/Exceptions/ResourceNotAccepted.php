<?php

namespace Mvdnbrk\DhlParcel\Exceptions;

use RuntimeException;

class ResourceNotAccepted extends RuntimeException
{
    /**
     * Create a new Resource not accepted exception.
     *
     * @param  mixed  $resource
     * @return static
     */
    public static function forResource($resource)
    {
        return new static('Resource for class ['.get_class($resource).'] not accepted.');
    }
}