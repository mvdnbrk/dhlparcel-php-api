<?php

namespace Mvdnbrk\DhlParcel\Exceptions;

use InvalidArgumentException;
use Mvdnbrk\DhlParcel\Contracts\Resource;

class ResourceNotAccepted extends InvalidArgumentException
{
    /**
     * @param  \Mvdnbrk\DhlParcel\Contracts\Resource  $resource
     * @return ResourceNotAccepted
     */
    public static function fromResource(Resource $resource): self
    {
        return new self('Resoruce of type '.get_class($resource).' not accepted.');
    }
}