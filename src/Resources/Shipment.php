<?php

namespace Mvdnbrk\DhlParcel\Resources;

use Illuminate\Support\Collection;

class Shipment extends BaseResource
{
    /** @var string */
    public $id;

    /** @var string */
    public $barcode;

    /** @var string */
    public $label_id;

    /** @var Collection */
    public $pieces;

    public function __construct(array $attributes = [])
    {
        $this->pieces = new Collection;

        parent::__construct($attributes);
    }
}
