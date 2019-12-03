<?php

namespace Mvdnbrk\DhlParcel\Resources;

use Tightenco\Collect\Support\Collection;

class Shipment extends BaseResource
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $barcode;

    /**
     * @var string
     */
    public $label_id;

    /**
     * @var \Tightenco\Collect\Support\Collection
     */
    public $pieces;

    /**
     * Create a new Parcel resource.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->pieces = new Collection;

        parent::__construct($attributes);
    }
}
