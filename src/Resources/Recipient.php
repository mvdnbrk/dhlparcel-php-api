<?php

namespace Mvdnbrk\DhlParcel\Resources;

class Recipient extends Address
{
    /** @var string */
    public $is_business = null;

    /** @var string */
    public $company_name;

    /** @var string */
    public $first_name;

    /** @var string */
    public $last_name;

    /** @var string */
    public $email;

    /** @var string */
    public $phone;

    public function setCompanyAttribute(string $value): void
    {
        $this->company_name = $value;
    }

    private function addressToArray(): array
    {
        return collect(parent::toArray())
            ->reject(function ($value, $key) {
                return $key === 'is_business';
            })
            ->diffKeys([
                'company_name' => '',
                'first_name' => '',
                'last_name' => '',
                'email' => '',
                'phone' => '',
            ])
            ->when($this->is_business !== null, function ($collection) {
                return $collection->put('isBusiness', $this->is_business);
            })
            ->when(! empty($this->company_name), function ($collection) {
                return $collection->put('isBusiness', $this->is_business === null ? false : $this->is_business);
            })
            ->all();
    }

    private function nameToArray(): array
    {
        return collect([
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'companyName' => $this->company_name,
        ])
            ->filter()
            ->all();
    }

    public function toArray(): array
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
