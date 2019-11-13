<?php

namespace Mvdnbrk\DhlParcel\Contracts;

use JsonSerializable;

interface Resource extends JsonSerializable
{
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson(int $options = 0): string;
}
