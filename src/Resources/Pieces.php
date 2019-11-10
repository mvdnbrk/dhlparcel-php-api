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
     * Sets the pieces.
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
     * Add a pieces.
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
     * Determine if it has pieces.
     *
     * @return bool
     */
    public function hasPieces()
    {
        return collect($this->pieces)->isNotEmpty();
    }

    /**
     * Convert the Pieces resource to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $array = [];

        foreach ($this->pieces as $piece) {
            $array[] = $piece->toArray();
        }

        return $array;
    }
}
