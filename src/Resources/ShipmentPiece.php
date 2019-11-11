<?php

namespace Mvdnbrk\DhlParcel\Resources;

class ShipmentPiece extends Piece
{
    /**
     * @var string
     */
    public $label_id;

    /**
     * @var string
     */
    public $tracker_code;

    /**
     * Convert the ShipmentPiece resource to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge([
            'labelId' => $this->label_id,
            'trackerCode' => $this->tracker_code,
        ], parent::toArray());
    }
}
