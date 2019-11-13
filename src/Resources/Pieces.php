<?php

namespace Mvdnbrk\DhlParcel\Resources;

class Pieces extends BaseResource
{
    /**
     * The piece items in this collection.
     *
     * @var \Mvdnbrk\DhlParcel\Resources\Piece[]
     */
    protected $items = [];

    /**
     * Create a new Pieces resource.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $piece) {
            $this->add($piece);
        }
    }

    /**
     * Add a piece item to this collection.
     *
     * @param  \Mvdnbrk\DhlParcel\Resources\Piece|array  $value
     * @return void
     */
    public function add($value)
    {
        if ($value instanceof Piece) {
            $this->items[] = $value;

            return;
        }

        $this->items[] = new Piece($value);
    }

    /**
     * Convert the Pieces resource to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return collect($this->items)
            ->whenEmpty(function ($collection) {
                return $collection->push(new Piece);
            })
            ->map(function ($piece) {
                return $piece->toArray();
            })
            ->all();
    }
}
