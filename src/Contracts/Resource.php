<?php

namespace Mvdnbrk\DhlParcel\Contracts;

use JsonSerializable;
use Tightenco\Collect\Contracts\Support\Arrayable;

interface Resource extends JsonSerializable, Arrayable
{
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray();

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0);
}
