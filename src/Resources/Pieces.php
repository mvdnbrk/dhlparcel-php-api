<?php

namespace Mvdnbrk\DhlParcel\Resources;

use Illuminate\Support\Collection;
use Mvdnbrk\DhlParcel\Exceptions\ResourceNotAccepted;

class Pieces extends BaseResourceCollection
{
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
