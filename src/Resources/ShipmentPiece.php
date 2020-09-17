<?php

namespace Mvdnbrk\DhlParcel\Resources;

class ShipmentPiece extends BaseResource
{
    /** @var string */
    public $label_id;

    /** @var string */
    public $label_type;

    /** @var string */
    public $parcel_type;

    /** @var int */
    public $piece_number;

    /** @var string */
    public $tracker_code;

    public function setPieceNumberAttribute(int $value): void
    {
        $this->piece_number = $value;
    }

    public function getBarcodeAttribute(): string
    {
        return $this->tracker_code;
    }
}
