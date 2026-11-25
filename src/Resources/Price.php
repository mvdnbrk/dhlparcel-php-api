<?php

namespace Mvdnbrk\DhlParcel\Resources;

class Price extends BaseResource
{
    /** @var float */
    public $withTax;

    /** @var float */
    public $withoutTax;

    /** @var float */
    public $vatRate;

    /** @var string */
    public $currency;
}
