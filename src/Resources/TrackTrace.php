<?php

namespace Mvdnbrk\DhlParcel\Resources;

class TrackTrace extends BaseResource
{
    /**
     * @var string
     */
    public $barcode;

    /**
     * @var bool
     */
    public $isDelivered;

    /**
     * Create a new Track Trace Collection instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->isDelivered = collect($attributes)->has('deliveredAt');
    }
}
