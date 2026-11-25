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
     */
    public function getAttribute(?string $key): mixed
    {
        if (! $key) {
            return null;
        }

        return $this->getAttributeValue($key);
    }

    /**
     * Get a plain attribute value.
     */
    public function getAttributeValue(string $key): mixed
    {
        if ($this->hasGetMutator($key)) {
            return $this->{'get'.Str::studly($key).'Attribute'}();
        }

        if (property_exists($this, $key)) {
            return $this->{$key};
        }

        return null;
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
     */
    public function setAttribute(string $key, mixed $value): mixed
    {
        if ($this->hasSetMutator($key)) {
            return $this->setMutatedAttributeValue($key, $value);
        }

        if (property_exists($this, $key)) {
            $this->{$key} = $value;
        }

        return null;
    }

    /**
     * Set the value of an attribute using its mutator.
     */
    protected function setMutatedAttributeValue(string $key, mixed $value): mixed
    {
        return $this->{'set'.Str::studly($key).'Attribute'}($value);
    }
}
