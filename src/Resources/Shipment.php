<?php

namespace Mvdnbrk\DhlParcel\Resources;

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
     * Convert the Shipment resource to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return collect(parent::toArray())->merge([
            'id' => $this->id,
            'barcode' => $this->barcode,
            'label_id' => $this->label_id,
        ])->all();
    }
}
