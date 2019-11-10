<?php

namespace Mvdnbrk\DhlParcel\Resources;

class Pieces extends BaseResource
{
    /**
     * @var Piece[]
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
     * @param array $pieces
     */
    public function setPiecesAttribute($pieces)
    {
        foreach ($pieces as $piece) {
            $this->addPiece($piece);
        }
    }

    /**
     * @param Piece $piece
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
     * @return bool
     */
    public function hasPieces()
    {
        return $this->pieces !== null && count($this->pieces) > 0;
    }

    /**
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
