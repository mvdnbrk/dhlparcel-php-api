<?php

namespace Mvdnbrk\DhlParcel\Resources;

use Tightenco\Collect\Support\Collection;

class Capability extends BaseResource
{
    /** @var int */
    public $rank;

    /** @var string */
    public $fromCountryCode;

    /** @var string */
    public $toCountryCode;

    /** @var Product */
    public $product;

    /** @var ParcelType */
    public $parcelType;

    /** @var \Tightenco\Collect\Support\Collection */
    public $options;


    public function __construct(array $attributes = [])
    {
        $this->options = new Collection;

        parent::__construct($attributes);
    }
}
