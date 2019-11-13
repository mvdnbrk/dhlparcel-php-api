<?php

namespace Mvdnbrk\DhlParcel\Resources;

use Mvdnbrk\DhlParcel\Support\Str;

class ShipmentOptions extends BaseResource
{
    /**
     * The delivery type key.
     *
     * e.g. DOOR for delivery to recipient,
     * BP for mailbox delivery,
     * PS for parcel shop delivery etc.
     *
     * @var string
     */
    protected $delivery_type;

    /**
     * The ID of the service point where a parcel should be delivered.
     *
     * @var string
     */
    protected $service_point_id;

    /**
     * The description that will appear on the shipment label.
     *
     * @var string
     */
    public $label_description;

    /**
     * Deliver the package to the recipient only.
     *
     * @var bool
     */
    public $only_recipient;

    /**
     * Reciepient must sign for the package.
     *
     * @var bool
     */
    public $signature;

    /**
     * Create a new Shipment Options resource.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setDefaultOptions();

        parent::__construct($attributes);
    }

    /**
     * Set default options for a shipment.
     *
     * @return $this
     */
    public function setDefaultOptions()
    {
        $this->delivery_type = 'DOOR';
        $this->signature = false;
        $this->only_recipient = false;

        return $this;
    }

    /**
     * Get the description for the shipment.
     * Alias for label_description.
     *
     * @return string
     */
    public function getDescriptionAttribute()
    {
        return $this->label_description;
    }

    /**
     * Set the label description.
     *
     * @param  string  $value
     * @return void
     */
    public function setLabelDescriptionAttribute(string $value)
    {
        $this->label_description = Str::limit(trim($value), 15, '');
    }

    /**
     * Alias for label_description.
     *
     * @param  string  $value
     * @return void
     */
    public function setDescriptionAttribute($value)
    {
        $this->setLabelDescriptionAttribute($value);
    }

    /**
     * Set the options for a mailbox package.
     *
     * @return void
     */
    public function setMailboxPackage()
    {
        $this->setDefaultOptions();

        $this->delivery_type = 'BP';
    }

    /**
     * Set the service point id where the
     * parcel should be delievred to.
     *
     * @param  string  $value
     * @return void
     */
    public function setServicePointIdAttribute($value)
    {
        $this->setDefaultOptions();

        $this->delivery_type = 'PS';

        $this->service_point_id = $value;
    }

    /**
     * Convert the ShipmenOptions resource to an array.
     *
     * @return array
     */
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
