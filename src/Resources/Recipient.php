<?php

namespace Mvdnbrk\DhlParcel\Resources;

class Recipient extends Address
{
    /**
     * @var string
     */
    public $company_name;

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
     * Set the company. Alias for company_name.
     *
     * @param  string  $value
     * @return void
     */
    public function setCompanyAttribute(string $value)
    {
        $this->company_name = $value;
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
                'company_name' => '',
                'first_name' => '',
                'last_name' => '',
                'email' => '',
                'phone' => '',
            ])
            ->when(! empty($this->company_name), function ($collection) {
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
            'companyName' => $this->company_name,
        ])
            ->filter()
            ->all();
    }

    /**
     * Convert the Recipient resource to an array.
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
}
