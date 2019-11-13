<?php

namespace Mvdnbrk\DhlParcel\Resources;

use Mvdnbrk\DhlParcel\Contracts\Resource;
use Mvdnbrk\DhlParcel\Contracts\ResourceCollection;
use Mvdnbrk\DhlParcel\Resources\Concerns\Jsonable;

abstract class BaseResourceCollection implements ResourceCollection
{
    use Jsonable;

    /**
     * @var \Mvdnbrk\DhlParcel\Contracts\Resource[]
     */
    protected $items;

    /**
     * Create a new resource collection.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $piece) {
            $this->addItem($piece);
        }
    }

    /**
     * {@inheritdoc}
     */
    abstract public function addItem($item): void;

    /**
     * @return \Mvdnbrk\DhlParcel\Contracts\Resource[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }
    /**
     * @return \Mvdnbrk\DhlParcel\Contracts\Resource|null
     */
    public function first():? Resource
    {
        return $this->items[0] ?? null;
    }

    /**
     * @return \Mvdnbrk\DhlParcel\Contracts\Resource|null
     */
    public function last():? Resource
    {
        return $this->items[count($this) - 1] ?? null;
    }

    /**
     * Convert the Pieces resource to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return collect($this->items)
            ->map(function (Resource $item) {
                return $item->toArray();
            })
            ->all();
    }
}