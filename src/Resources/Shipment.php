<?php

namespace Mvdnbrk\DhlParcel\Resources;

class Shipment extends Parcel
{
    /**
     * @var int
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
}
