<?php

namespace Mvdnbrk\DhlParcel\Exceptions;

use InvalidArgumentException;
use Mvdnbrk\DhlParcel\Contracts\Resource;

class ResourceNotAccepted extends InvalidArgumentException
{
    /**
     * @param  Resource  $dto
     * @return ResourceNotAccepted
     */
    public static function fromResource(Resource $dto): ResourceNotAccepted
    {
        return new self('Resoruce of type ' . get_class($dto) . ' not accepted.');
    }
}