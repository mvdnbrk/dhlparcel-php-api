<?php

namespace Mvdnbrk\DhlParcel\Resources\Concerns;

use Mvdnbrk\DhlParcel\Support\Str;

trait HasAttributes
{
    /**
     * Convert the recource's attributes to an array.
     *
     * @return array
     */
    public function attributesToArray()
    {
        return get_object_vars($this);
    }

    /**
     * Get an attribute from the resource.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (! $key) {
            return;
        }

        return $this->getAttributeValue($key);
    }

    /**
     * Get a plain attribute value.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttributeValue($key)
    {
        if ($this->hasGetMutator($key)) {
            return $this->{'get'.Str::studly($key).'Attribute'}();
        }

        if (property_exists($this, $key)) {
            return $this->{$key};
        }

        return;
    }

    /**
     * Determine if a get mutator exists for an attribute.
     *
     * @param  string  $key
     * @return bool
     */
    public function hasGetMutator($key)
    {
        return method_exists($this, 'get'.Str::studly($key).'Attribute');
    }

    /**
     * Determine if a set mutator exists for an attribute.
     *
     * @param  string  $key
     * @return bool
     */
    public function hasSetMutator($key)
    {
        return method_exists($this, 'set'.Str::studly($key).'Attribute');
    }

    /**
     * Set a given attribute on the resource.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        if ($this->hasSetMutator($key)) {
            return $this->setMutatedAttributeValue($key, $value);
        }

        if (property_exists($this, $key)) {
            $this->{$key} = $value;
        }

        return $this;
    }

    /**
     * Set the value of an attribute using its mutator.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function setMutatedAttributeValue($key, $value)
    {
        return $this->{'set'.Str::studly($key).'Attribute'}($value);
    }
}
