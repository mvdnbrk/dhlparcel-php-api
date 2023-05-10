<?php

namespace Mvdnbrk\DhlParcel\Resources;

class Option extends BaseResource
{
    /** @var string */
    public $key;

    /** @var string */
    public $description;

    /** @var int */
    public $rank;

    /** @var int */
    public $code;

    /** @var string */
    public $optionType;
}
