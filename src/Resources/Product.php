<?php

namespace Mvdnbrk\DhlParcel\Resources;

class Product extends BaseResource
{
    /** @var string */
    public $key;

    /** @var string */
    public $label;

    /** @var string */
    public $code;

    /** @var string */
    public $menuCode;

    /** @var boolean */
    public $businessProduct;

    /** @var boolean */
    public $monoColloProduct;

    /** @var string */
    public $softwareCharacteristic;

    /** @var boolean */
    public $returnProduct;
}
