<?php

namespace Mvdnbrk\DhlParcel\Contracts;

use Countable;

interface ResourceCollection extends Countable, Resource
{
    /**
     * Add Resource item to collection.
     *
     * @param  \Mvdnbrk\DhlParcel\Contracts\Resource  $resource
     * @return void
     */
    public function addItem(Resource $resource): void;

    /**
     * Get the Resource items
     *
     * @return \Mvdnbrk\DhlParcel\Contracts\Resource[]
     */
    public function getItems(): array;

    /**
     * Return first Resource item from collection
     *
     * @return null|\Mvdnbrk\DhlParcel\Contracts\Resource
     */
    public function first(): ?Resource;

    /**
     * Return last Resource item from collection
     *
     * @return null|\Mvdnbrk\DhlParcel\Contracts\Resource
     */
    public function last():? Resource;
}
