<?php

namespace Mvdnbrk\DhlParcel\Resources;

use Illuminate\Support\Collection;

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

    /** @var Collection<int, Option> */
    public $options;

    /** @var DeliveryArea|null */
    public $deliveryArea;

    public function __construct(array $attributes = [])
    {
        $this->options = new Collection;

        parent::__construct($attributes);
    }
}
