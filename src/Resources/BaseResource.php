<?php

namespace Mvdnbrk\DhlParcel\Resources;

use JsonSerializable;
use Mvdnbrk\DhlParcel\Contracts\Arrayable;
use Mvdnbrk\DhlParcel\Contracts\Jsonable;
use Mvdnbrk\DhlParcel\Exceptions\JsonEncodingException;

abstract class BaseResource implements Arrayable, Jsonable, JsonSerializable
{
    use Concerns\HasAttributes;

    /**
     * Create a new resource instance.
     *
     * @param  array|object  $attributes
     */
    public function __construct($attributes = [])
    {
        $this->fill($attributes);
    }

    /**
     * Fill the resource with an array of attributes.
     *
     * @param  array|object  $attributes
     * @return $this
     */
    public function fill($attributes)
    {
        collect($attributes)->each(function ($value, $key) {
            $this->setAttribute($key, $value);
        });

        return $this;
    }

    /**
     * Convert the recource into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Convert the resource instance to an array.
     * Removes all attributes with null values.
     *
     * @return array
     */
    public function toArray()
    {
        return collect($this->attributesToArray())
            ->reject(function ($value) {
                return $value === null;
            })
            ->all();
    }

    /**
     * Convert the resource instance to JSON.
     *
     * @param  int  $options
     * @return string
     *
     * @throws \Mvdnbrk\MyParcel\Exceptions\JsonEncodingException
     */
    public function toJson($options = 0)
    {
        $json = json_encode($this->jsonSerialize(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw JsonEncodingException::forResource($this, json_last_error_msg());
        }

        return $json;
    }

    /**
     * Dynamically retrieve attributes on the resource.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes on the resource.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }
}
