<?php

namespace Mvdnbrk\DhlParcel\Resources;

class TrackTrace extends BaseResource
{
    /** @var string */
    public $barcode;

    /** @var bool */
    public $isDelivered;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->isDelivered = collect($attributes)->has('deliveredAt');
    }
}
