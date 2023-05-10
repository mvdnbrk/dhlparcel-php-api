<?php

namespace Mvdnbrk\DhlParcel\Resources;

class ParcelType extends BaseResource
{
    /** @var string */
    public $key;

    /** @var string */
    public $category;

    /** @var int */
    public $minWeightKg;

    /** @var int */
    public $maxWeightKg;

    /** @var int */
    public $defaultWeightKg;

    /** @var Dimensions */
    public $dimensions;

    /** @var int */
    public $minWeightGrams;

    /** @var int */
    public $maxWeightGrams;

    /** @var int */
    public $defaultWeightGrams;
}
