<?php

namespace Mvdnbrk\DhlParcel\Resources;

use Tightenco\Collect\Support\Collection;

class PiecesCollection extends Collection
{
    /**
     * Create a new Pieces Collection instance.
     *
     * @param  array  $items
     * @return void
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    /**
     * Add a piece item to this collection.
     *
     * @param  \Mvdnbrk\DhlParcel\Resources\Piece|array  $value
     * @return $this
     */
    public function add($value)
    {
        if ($value instanceof Piece) {
            return parent::add($value);
        }

        if (is_array($value)) {
            return parent::add(new Piece($value));
        }

        return $this;
    }

    /**
     * Convert the Pieces collection to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return collect($this->items)
            ->whenEmpty(function (Collection $collection) {
                return $collection->push(new Piece);
            })
            ->map(function (Piece $piece) {
                return $piece->toArray();
            })
            ->all();
    }
}
