<?php

namespace Mvdnbrk\DhlParcel\Resources;

class Shipment extends Parcel
{
    /**
     * @var int
     */
    public $id;

    /**
     * Convert the Shipment resource to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return collect(parent::toArray())->merge([
            'id' => $this->id,
        ])->all();
    }
}
