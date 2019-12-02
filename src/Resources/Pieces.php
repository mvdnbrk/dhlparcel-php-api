<?php

namespace Mvdnbrk\DhlParcel\Resources;

use Mvdnbrk\DhlParcel\Contracts\Arrayable;
use Mvdnbrk\DhlParcel\Exceptions\ResourceNotAccepted;
use Tightenco\Collect\Support\Collection;

class Pieces extends Collection implements Arrayable
{
    /**
     * BaseResourceCollection constructor.
     *
     * @noinspection PhpMissingParentConstructorInspection
     * @param  array  $items
     */
    public function __construct($items = [])
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
    public function add($value): void
    {
        if ($value instanceof Piece) {
            $this->items[] = $value;

            return;
        }

        if (is_array($value)) {
            $this->items[] = new Piece($value);

            return;
        }

        throw ResourceNotAccepted::forResource($value);
    }

    /**
     * Convert the Pieces resource to an array.
     *
     * @return array
     */
    public function toArray(): array
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
