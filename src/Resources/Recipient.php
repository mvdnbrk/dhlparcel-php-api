<?php

namespace Mvdnbrk\DhlParcel\Resources;

class Recipient extends Address
{
    /**
     * @var string
     */
    public $company;

    /**
     * @var string
     */
    public $first_name;

    /**
     * @var string
     */
    public $last_name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $phone;

    /**
     * Convert the resource instance to an array.
     * Removes all attributes with null values.
     *
     * @return array
     */
    public function toArray()
    {
        return collect([
                'name' => $this->nameToArray(),
                'address' => $this->addressToArray(),
            ])
            ->when(! empty($this->email), function ($collection) {
                return $collection->put('email', $this->email);
            })
            ->when(! empty($this->phone), function ($collection) {
                return $collection->put('phoneNumber', $this->phone);
            })
            ->all();
    }

    /**
     * Convert the "address" part of the recipient to an array.
     *
     * @return array
     */
    private function addressToArray()
    {
        return collect(parent::toArray())
            ->diffKeys([
                'company' => '',
                'first_name' => '',
                'last_name' => '',
                'email' => '',
                'phone' => '',
            ])
            ->when(! empty($this->company), function ($collection) {
                return $collection->put('isBusiness', true);
            })
            ->all();
    }

    /**
     * Convert the "name" part of the recipient to an array.
     *
     * @return array
     */
    private function nameToArray()
    {
        return collect([
                'firstName' => $this->first_name,
                'lastName' => $this->last_name,
                'companyName' => $this->company,
            ])
            ->reject(function ($value) {
                return $value === null;
            })
            ->all();
    }
}
