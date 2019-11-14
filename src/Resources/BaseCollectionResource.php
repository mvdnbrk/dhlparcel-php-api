<?php

namespace Mvdnbrk\DhlParcel\Resources;

use Mvdnbrk\DhlParcel\Contracts\Resource;
use Tightenco\Collect\Support\Collection;

abstract class BaseCollectionResource extends Collection implements Resource
{
    /* @noinspection PhpMissingParentConstructorInspection */

    /**
     * BaseCollectionResource constructor.
     *
     * @param array $items
     */
    public function __construct($items = [])
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }
}
