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
}
