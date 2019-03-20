<?php

namespace Mvdnbrk\DhlParcel\Endpoints;

use Mvdnbrk\DhlParcel\Support\Str;
use Tightenco\Collect\Support\Collection;
use Mvdnbrk\DhlParcel\Resources\ServicePoint as ServicePointResource;

class ServicePoints extends BaseEndpoint
{
    /**
     * @var string
     */
    public $postal_code;

    /**
     * @var string
     */
    public $housenumber;

    /**
     * Get a collection of service points.
     *
     * @param  array  $filters
     * @return \Tightenco\Collect\Support\Collection
     */
    public function get(array $filters = [])
    {
        $response = $this->performApiCall(
            'GET',
            'parcel-shop-locations/NL'.$this->buildQueryString($this->getFilters($filters))
        );

        $collection = new Collection();

        collect($response)->each(function ($item) use ($collection) {
            $collection->push(new ServicePointResource($item));
        });

        return $collection;
    }

    /**
     * Get query filters.
     *
     * @param  array  $filters
     * @return array
     */
    protected function getFilters($filters)
    {
        return array_merge([
            'zipCode' => $this->postal_code,
            'houseNumber' => $this->housenumber,
            'showUnavailable' => 'false',
        ], $filters);
    }

    /**
     * Sets the house number.
     *
     * @param  string  $value
     * @return $this
     */
    public function setHousenumber($value)
    {
        $this->housenumber = $value;

        return $this;
    }

    /**
     * Set the postal code.
     *
     * @param  string  $value
     * @return $this
     */
    public function setPostalCode($value)
    {
        $this->postal_code = preg_replace('/\s+/', '', Str::upper($value));

        return $this;
    }
}
