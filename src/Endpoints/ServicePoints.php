<?php

namespace Mvdnbrk\DhlParcel\Endpoints;

use Mvdnbrk\DhlParcel\Resources\ServicePoint as ServicePointResource;
use Mvdnbrk\DhlParcel\Support\Str;
use Tightenco\Collect\Support\Collection;

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
     * @var string
     */
    public $country = "NL";


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
            'parcel-shop-locations/'. $this->country . $this->buildQueryString($this->getFilters($filters))
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
    protected function getFilters(array $filters)
    {
        return array_merge([
            'zipCode' => $this->postal_code,
            'houseNumber' => $this->housenumber,
            'showUnavailable' => 'false',
        ], $filters);
    }

    /**
     * Set the house number.
     *
     * @param  string  $value
     * @return $this
     */
    public function setHousenumber(string $value)
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
    public function setPostalCode(string $value)
    {
        $this->postal_code = preg_replace('/\s+/', '', Str::upper($value));

        return $this;
    }
    
     /**
     * Set the country.
     *
     * @param  string  $value
     * @return $this
     */
    public function setCountry(string $value)
    {
        $this->country = $value;

        return $this;
    }
}
