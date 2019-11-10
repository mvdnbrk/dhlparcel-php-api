<?php

namespace Mvdnbrk\DhlParcel\Resources;

class Piece extends BaseResource
{
    const PARCEL_TYPE_SMALL = 'SMALL';
    const PARCEL_TYPE_MEDIUM = 'MEDIUM';
    const PARCEL_TYPE_LARGE = 'LARGE';
    const PARCEL_TYPE_BULKY = 'BULKY';

    /**
     * @var string
     */
    public $parcel_type;

    /**
     * @var int
     */
    public $quantity;

    /**
     * @var float
     */
    public $weight;

    /**
     * Create a new Piece resource.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setDefaultOptions();

        parent::__construct($attributes);
    }

    /**
     * Sets default options for a piece.
     *
     * @return $this
     */
    public function setDefaultOptions()
    {
        $this->parcel_type = self::PARCEL_TYPE_SMALL;
        $this->quantity = 1;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_filter([
            'parcelType' => $this->parcel_type,
            'quantity' => $this->quantity,
            'weight' => $this->weight,
        ]);
    }
}