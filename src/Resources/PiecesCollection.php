<?php

namespace Mvdnbrk\DhlParcel\Resources;

use Tightenco\Collect\Support\Collection;

class PiecesCollection extends Collection
{
    /**
     * Create a new Pieces Collection instance.
     *
     * @param  array  $items
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
     * @return void
     */
    public function add($value)
    {
        if ($value instanceof Piece) {
            $this->items[] = $value;

            return;
        }

        if (is_array($value)) {
            $this->items[] = new Piece($value);

            return;
        }
    }

    /**
     * Convert the Pieces resource to an array.
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
