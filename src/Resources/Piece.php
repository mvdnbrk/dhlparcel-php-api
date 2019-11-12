<?php

namespace Mvdnbrk\DhlParcel\Resources;

class Piece extends BaseResource
{
    const PARCEL_TYPE_SMALL = 'SMALL';
    const PARCEL_TYPE_MEDIUM = 'MEDIUM';
    const PARCEL_TYPE_LARGE = 'LARGE';
    const PARCEL_TYPE_BULKY = 'BULKY';
    const PARCEL_TYPE_PALLET = 'PALLET';

    /**
     * The parcel type.
     * e.g. SMALL, MEDIUM, LARGE etc.
     *
     * @var string
     */
    public $parcel_type;

    /**
     * Number of parcels of this parcel type.
     *
     * @var int
     */
    public $quantity;

    /**
     * Actual weight of the parcel in kilograms.
     *
     * @var int
     */
    public $weight;

    /**
     * Label id from api response
     *
     * @var string
     */
    public $label_id;

    /**
     * Tracker code from api response
     *
     * @var string
     */
    public $tracker_code;

    /**
     * Create a new Piece resource.
     *
     * @param  array  $attributes
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
     * Convert the Piece resource to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return collect([
                'parcelType' => $this->parcel_type,
                'quantity' => $this->quantity,
                'weight' => $this->weight,
                'trackerCode' => $this->tracker_code,
                'labelId' => $this->label_id,
            ])
            ->filter()
            ->all();
    }
}
