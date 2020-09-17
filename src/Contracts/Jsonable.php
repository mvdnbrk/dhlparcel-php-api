<?php

namespace Mvdnbrk\DhlParcel\Contracts;

interface Jsonable
{
    public function toJson(int $options = 0): string;
}
