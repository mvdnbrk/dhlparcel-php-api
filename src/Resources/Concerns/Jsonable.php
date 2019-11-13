<?php

namespace Mvdnbrk\DhlParcel\Resources\Concerns;

use Mvdnbrk\DhlParcel\Exceptions\JsonEncodingException;

trait Jsonable
{
    /**
     * Convert the ResourceCollection into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Convert the resource instance to JSON.
     *
     * @param  int  $options
     * @return string
     *
     * @throws \Mvdnbrk\DhlParcel\Exceptions\JsonEncodingException
     */
    public function toJson(int $options = 0): string
    {
        $json = json_encode($this->jsonSerialize(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw JsonEncodingException::forResource($this, json_last_error_msg());
        }

        return $json;
    }
}
