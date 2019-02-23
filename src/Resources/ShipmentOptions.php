<?php

namespace Mvdnbrk\DhlParcel\Resources;

use Mvdnbrk\DhlParcel\Support\Str;
use Mvdnbrk\DhlParcel\Resources\BaseResource;

class ShipmentOptions extends BaseResource
{
    /**
     * The delivery type.
     * e.g. to door, mailbox, parcelshop etc.
     *
     * @var string
     */
    protected $delivery_type;

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
     * Sets default options for a shipment.
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
    public function setLabelDescriptionAttribute($value)
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
     * Sets the options for a mailbox package
     *
     * @return void
     */
    public function setMailboxPackage()
    {
        $this->setDefaultOptions();

        $this->delivery_type = 'BP';
    }

    /**
      * Convert the options to an array.
      *
      * @return array
      */
    public function toArray()
    {
        return collect()
            ->push(['key' => $this->delivery_type])
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
