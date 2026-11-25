<?php

namespace Mvdnbrk\DhlParcel\Resources;

use Illuminate\Support\Collection;

class PiecesCollection extends Collection
{
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
    public function add($value): self
    {
        if ($value instanceof Piece) {
            return parent::add($value);
        }

        if (is_array($value)) {
            return parent::add(new Piece($value));
        }

        return $this;
    }

    public function toArray(): array
    {
        return array_map(function ($item) {
            return $item->toArray();
        }, empty($this->items) ? [new Piece] : $this->items);
    }
}
