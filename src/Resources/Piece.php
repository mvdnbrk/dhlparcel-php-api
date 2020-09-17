<?php

namespace Mvdnbrk\DhlParcel\Resources;

class Piece extends BaseResource
{
    const PARCEL_TYPE_SMALL = 'SMALL';
    const PARCEL_TYPE_MEDIUM = 'MEDIUM';
    const PARCEL_TYPE_LARGE = 'LARGE';
    const PARCEL_TYPE_BULKY = 'BULKY';
    const PARCEL_TYPE_PALLET = 'PALLET';

    /** @var string */
    public $parcel_type;

    /** @var int */
    public $quantity;

    /** @var int */
    public $weight;

    public function __construct(array $attributes = [])
    {
        $this->setDefaultOptions();

        parent::__construct($attributes);
    }

    public function setDefaultOptions(): self
    {
        $this->parcel_type = self::PARCEL_TYPE_SMALL;
        $this->quantity = 1;

        return $this;
    }

    public function setQuantityAttribute(int $value): void
    {
        $this->quantity = $value;
    }

    public function setWeightAttribute(int $value): void
    {
        $this->weight = $value;
    }

    public function toArray(): array
    {
        return array_filter([
            'parcelType' => $this->parcel_type,
            'quantity' => $this->quantity,
            'weight' => $this->weight,
        ]);
    }
}
