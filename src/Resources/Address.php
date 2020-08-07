<?php

namespace Mvdnbrk\DhlParcel\Resources;

use Mvdnbrk\DhlParcel\Support\Str;

class Address extends BaseResource
{
    /**
     * @var string
     */
    public $street;

    /**
     * @var string
     */
    public $additional_address_line;

    /**
     * @var int|string
     */
    public $number;

    /**
     * @var string
     */
    public $number_suffix;

    /**
     * @var string
     */
    public $postal_code;

    /**
     * @var string
     */
    public $city;

    /**
     * @var string
     */
    public $region;

    /**
     * ISO3166-1 country code.
     * https://en.wikipedia.org/wiki/ISO_3166-1.
     *
     * @var string
     */
    public $cc;

    /**
     * Set the number suffix. Alias for number_suffix.
     *
     * @param  string  $value
     * @return void
     */
    public function setAdditionAttribute($value)
    {
        $this->number_suffix = $value;
    }

    /**
     * Set the country code.
     *
     * @param  string  $value
     * @return void
     */
    public function setCcAttribute($value)
    {
        $this->cc = Str::upper($value);
    }

    /**
     * Set the country code. Alias for cc.
     *
     * @param  string  $value
     * @return void
     */
    public function setCountryCodeAttribute($value)
    {
        $this->setCcAttribute($value);
    }

    /**
     * Set the postal code.
     *
     * @param  string  $value
     * @return void
     */
    public function setPostalCodeAttribute($value)
    {
        $this->postal_code = Str::upper($value);
    }

    /**
     * Set the zipcode. Alias for postal_code.
     *
     * @param  string  $value
     * @return void
     */
    public function setZipcodeAttribute($value)
    {
        $this->setPostalCodeAttribute($value);
    }

    /**
     * Convert the Address resource to an array.
     *
     * @return array
     */
    public function toArray()
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
