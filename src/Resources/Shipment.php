<?php

namespace Mvdnbrk\DhlParcel\Resources;

class Shipment extends BaseResource
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var \Mvdnbrk\DhlParcel\Resources\ShipmentPiece[]
     */
    public $pieces;

    /**
     * Create a new Shipment resource.
     *
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        $this->pieces = [];

        parent::__construct($attributes);
    }

    /**
     * Set the items.
     *
     * @param  array  $pieces
     */
    public function setPiecesAttribute($pieces)
    {
        foreach ($pieces as $piece) {
            $this->addPiece($piece);
        }
    }

    /**
     * Add a item.
     *
     * @param  \Mvdnbrk\DhlParcel\Resources\ShipmentPiece|array  $value
     */
    public function addPiece($value)
    {
        if ($value instanceof ShipmentPiece) {
            $this->pieces[] = $value;

            return;
        }

        $this->pieces[] = new ShipmentPiece($value);
    }

    /**
     * Convert the Shipment resource to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return collect([
            'id' => $this->id,
            'pieces' => collect($this->pieces)
                ->map(static function (ShipmentPiece $item): array {
                    return $item->toArray();
                })
                ->all()
        ])->all();
    }
}
