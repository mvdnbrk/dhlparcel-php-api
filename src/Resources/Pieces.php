<?php

namespace Mvdnbrk\DhlParcel\Resources;

class Pieces extends BaseResource
{
    /**
     * @var \Mvdnbrk\DhlParcel\Resources\Piece[]
     */
    public $pieces;

    /**
     * Create a new Pieces resource.
     *
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        $this->pieces = [];

        parent::__construct($attributes);
    }

    /**
     * Set the pieces.
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
     * Add a piece.
     *
     * @param  \Mvdnbrk\DhlParcel\Resources\Piece|array  $value
     */
    public function addPiece($value)
    {
        if ($value instanceof Piece) {
            $this->pieces[] = $value;

            return;
        }

        $this->pieces[] = new Piece($value);
    }

    /**
     * Convert the Pieces resource to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return collect($this->pieces)
            ->whenEmpty(function ($collection) {
                return $collection->push(new Piece);
            })
            ->map(function ($piece) {
                return $piece->toArray();
            })
            ->all();
    }
}
