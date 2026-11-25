<?php

namespace Mvdnbrk\DhlParcel\Exceptions;

use RuntimeException;

class JsonEncodingException extends RuntimeException
{
    /**
     * Create a new JSON encoding exception for the resource.
     */
    public static function forResource(object $resource, string $message): static
    {
        return new static('Error encoding resource ['.get_class($resource).'] to JSON: '.$message.'.');
    }
}
