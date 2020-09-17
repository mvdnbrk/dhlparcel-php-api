<?php

namespace Mvdnbrk\DhlParcel\Resources\Concerns;

use Mvdnbrk\DhlParcel\Support\Str;

trait HasAttributes
{
    public function attributesToArray(): array
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
    }

    public function hasGetMutator(string $key): bool
    {
        return method_exists($this, 'get'.Str::studly($key).'Attribute');
    }

    public function hasSetMutator(string $key): bool
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
    public function setAttribute(string $key, $value)
    {
        if ($this->hasSetMutator($key)) {
            return $this->setMutatedAttributeValue($key, $value);
        }

        if (property_exists($this, $key)) {
            $this->{$key} = $value;
        }
    }

    /**
     * Set the value of an attribute using its mutator.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function setMutatedAttributeValue(string $key, $value)
    {
        return $this->{'set'.Str::studly($key).'Attribute'}($value);
    }
}
