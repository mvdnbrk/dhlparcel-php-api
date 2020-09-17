<?php

namespace Mvdnbrk\DhlParcel\Resources;

use Mvdnbrk\DhlParcel\Support\Str;

class Address extends BaseResource
{
    /** @var string */
    public $street;

    /** @var string */
    public $additional_address_line;

    /** @var string|int */
    public $number;

    /** @var string */
    public $number_suffix;

    /** @var string */
    public $postal_code;

    /** @var string */
    public $city;

    /** @var string */
    public $region;

    /**
     * ISO3166-1 country code.
     * https://en.wikipedia.org/wiki/ISO_3166-1.
     *
     * @var string
     */
    public $cc;

    public function setAdditionAttribute(string $value): void
    {
        $this->number_suffix = $value;
    }

    public function setCcAttribute(string $value): void
    {
        $this->cc = Str::upper($value);
    }

    public function setCountryCodeAttribute(string $value): void
    {
        $this->setCcAttribute($value);
    }

    public function setPostalCodeAttribute(string $value): void
    {
        $this->postal_code = Str::upper($value);
    }

    public function setZipcodeAttribute(string $value): void
    {
        $this->setPostalCodeAttribute($value);
    }

    public function toArray(): array
    {
        return collect(parent::toArray())
            ->transform(function ($value, $key) {
                if ($key == 'number') {
                    return (string) $value;
                }

                return $value;
            })
            ->put('isBusiness', false)
            ->when(! empty($this->number_suffix), function ($collection) {
                return $collection
                    ->put('addition', $this->number_suffix)
                    ->forget('number_suffix');
            })
            ->when(! empty($this->additional_address_line), function ($collection) {
                return $collection
                    ->put('additionalAddressLine', $this->additional_address_line)
                    ->forget('additional_address_line');
            })
            ->put('postalCode', $this->postal_code)
            ->put('countryCode', $this->cc)
            ->forget('postal_code')
            ->forget('cc')
            ->all();
    }
}
