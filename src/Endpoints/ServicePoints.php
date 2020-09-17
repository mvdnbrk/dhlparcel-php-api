<?php

namespace Mvdnbrk\DhlParcel\Endpoints;

use Mvdnbrk\DhlParcel\Resources\ServicePoint as ServicePointResource;
use Mvdnbrk\DhlParcel\Support\Str;
use Tightenco\Collect\Support\Collection;

class ServicePoints extends BaseEndpoint
{
    /** @var string */
    public $postal_code;

    /** @var string */
    public $housenumber;

    /** @var string */
    public $country = 'NL';

    public function get(array $filters = []): Collection
    {
        $response = $this->performApiCall(
            'GET',
            'parcel-shop-locations/'.$this->country.$this->buildQueryString($this->getFilters($filters))
        );

        $collection = new Collection();

        collect($response)->each(function ($item) use ($collection) {
            $collection->push(new ServicePointResource($item));
        });

        return $collection;
    }

    protected function getFilters(array $filters): array
    {
        return array_merge([
            'zipCode' => $this->postal_code,
            'houseNumber' => $this->housenumber,
            'showUnavailable' => 'false',
        ], $filters);
    }

    public function setHousenumber(string $value): self
    {
        $this->housenumber = $value;

        return $this;
    }

    public function setPostalCode(string $value): self
    {
        $this->postal_code = preg_replace('/\s+/', '', Str::upper($value));

        return $this;
    }

    public function setCountry(string $value): self
    {
        $this->country = $value;

        return $this;
    }
}
