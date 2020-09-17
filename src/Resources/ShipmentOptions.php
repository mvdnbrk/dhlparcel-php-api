<?php

namespace Mvdnbrk\DhlParcel\Resources;

use Mvdnbrk\DhlParcel\Support\Str;

class ShipmentOptions extends BaseResource
{
    /** @var string */
    protected $delivery_type;

    /** @var string */
    protected $service_point_id;

    /** @var int|float */
    protected $cash_on_delivery;

    /** @var string */
    public $label_description;

    /** @var bool */
    public $only_recipient;

    /** @var bool */
    public $signature;

    public function __construct(array $attributes = [])
    {
        $this->setDefaultOptions();

        parent::__construct($attributes);
    }

    public function setDefaultOptions(): self
    {
        $this->delivery_type = 'DOOR';
        $this->signature = false;
        $this->only_recipient = false;

        return $this;
    }

    public function getDescriptionAttribute(): string
    {
        return $this->label_description;
    }

    public function setLabelDescriptionAttribute(string $value): void
    {
        $this->label_description = Str::limit(trim($value), 15, '');
    }

    public function setDescriptionAttribute(string $value): void
    {
        $this->setLabelDescriptionAttribute($value);
    }

    public function setMailboxPackage(): void
    {
        $this->setDefaultOptions();

        $this->delivery_type = 'BP';
    }

    public function setServicePointIdAttribute(string $value): void
    {
        $this->setDefaultOptions();

        $this->delivery_type = 'PS';

        $this->service_point_id = $value;
    }

    /**
     * Set the amount for "Cash On Delivery" in EUR.
     *
     * @param  int|float  $value
     * @return void
     */
    public function setCashOnDelivery($value): void
    {
        $this->cash_on_delivery = $value;
    }

    public function toArray(): array
    {
        return collect()
            ->when($this->delivery_type !== 'PS', function ($collection) {
                return $collection->push([
                    'key' => $this->delivery_type,
                ]);
            })
            ->when($this->delivery_type === 'PS', function ($collection) {
                return $collection->push([
                    'key' => $this->delivery_type,
                    'input' => $this->service_point_id,
                ]);
            })
            ->when(! empty($this->cash_on_delivery), function ($collection) {
                return $collection->push([
                    'key' => 'COD_CASH',
                    'input' => $this->cash_on_delivery,
                ]);
            })
            ->when(! empty($this->label_description), function ($collection) {
                return $collection->push([
                    'key' => 'REFERENCE',
                    'input' => $this->label_description,
                ]);
            })
            ->when($this->signature, function ($collection) {
                return $collection->push([
                    'key' => 'HANDT',
                ]);
            })
            ->when($this->only_recipient, function ($collection) {
                return $collection->push([
                    'key' => 'NBB',
                ]);
            })
            ->all();
    }
}
