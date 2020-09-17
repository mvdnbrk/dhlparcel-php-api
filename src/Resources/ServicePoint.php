<?php

namespace Mvdnbrk\DhlParcel\Resources;

class ServicePoint extends Address
{
    /** @var string */
    public $id;

    /** @var string */
    public $name;

    /** @var int */
    public $distance;

    /** @var float */
    public $latitude;

    /** @var float */
    public $longitude;

    public function distanceForHumans(): string
    {
        if (! $this->distance) {
            return '';
        }

        if ($this->distance >= 10000) {
            return round($this->distance / 1000, 0).' km';
        }

        if ($this->distance >= 1000) {
            return round($this->distance / 1000, 1).' km';
        }

        return "{$this->distance} meter";
    }

    /**
     * Set the address details.
     *
     * @param  \Mvdnbrk\DhlParcel\Resources\Address|array  $value
     * @return void
     */
    public function setAddressAttribute($value): void
    {
        $this->fill($value);
    }

    /**
     * Set latitude and longitude based on a geolocation object.
     *
     * @param  object|array  $value
     * @return void
     */
    public function setGeoLocationAttribute($value): void
    {
        collect($value)->tap(function ($collection) {
            $this->latitude = $collection->get('latitude');
            $this->longitude = $collection->get('longitude');
        });
    }

    public function toArray(): array
    {
        return collect($this->attributesToArray())
            ->merge([
                'distance' => $this->distanceForHumans(),
            ])
            ->filter()
            ->all();
    }
}
