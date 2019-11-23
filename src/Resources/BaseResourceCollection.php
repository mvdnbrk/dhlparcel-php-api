<?php

namespace Mvdnbrk\DhlParcel\Resources;

use Mvdnbrk\DhlParcel\Contracts\Arrayable;
use Tightenco\Collect\Support\Collection;

abstract class BaseResourceCollection extends Collection implements Arrayable
{
    /**
     * BaseResourceCollection constructor.
     *
     * @noinspection PhpMissingParentConstructorInspection
     * @param  array  $items
     */
    public function __construct($items = [])
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }
}
