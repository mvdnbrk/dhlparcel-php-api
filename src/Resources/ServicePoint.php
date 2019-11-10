<?php

namespace Mvdnbrk\DhlParcel\Resources;

class ServicePoint extends Address
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $distance;

    /**
     * @var float
     */
    public $latitude;

    /**
     * @var float
     */
    public $longitude;

    /**
     * Get the distance for a service point in a human readable format.
     *
     * @return string
     */
    public function distanceForHumans()
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
     * Sets address details.
     *
     * @param  object|array  $value
     * @return void
     */
    public function setAddressAttribute($value)
    {
        $this->fill($value);
    }

    /**
     * Sets latitude and longitude based on a geolocation object.
     *
     * @param  object|array  $value
     * @return void
     */
    public function setGeoLocationAttribute($value)
    {
        collect($value)->tap(function ($collection) {
            $this->latitude = $collection->get('latitude');
            $this->longitude = $collection->get('longitude');
        });
    }

    /**
     * Convert the ServicePoint resource to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return collect($this->attributesToArray())
            ->merge([
                'distance' => $this->distanceForHumans(),
            ])
            ->reject(function ($value) {
                return empty($value);
            })
            ->all();
    }
}
