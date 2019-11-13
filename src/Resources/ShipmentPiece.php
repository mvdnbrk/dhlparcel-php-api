<?php

namespace Mvdnbrk\DhlParcel\Resources;

class ShipmentPiece extends BaseResource
{
    /**
     * @var string
     */
    public $label_id;

    /**
     * @var string
     */
    public $label_type;

    /**
     * @var string
     */
    public $parcel_type;

    /**
     * @var int
     */
    public $piece_number;

    /**
     * @var string
     */
    public $tracker_code;

    /**
     * Set the piece number.
     *
     * @param  int  $value
     * @return void
     */
    public function setPieceNumberAttribute(int $value)
    {
        $this->piece_number = $value;
    }
}
