<?php

namespace Mvdnbrk\DhlParcel\Resources;

class Parcel extends BaseResource
{
    /**
     * Arbitrary reference indentifier to identify this shipment.
     *
     * @var string
     */
    public $reference_identifier;

    /**
     * @var \Mvdnbrk\DhlParcel\Resources\ShipmentOptions
     */
    public $options;

    /**
     * @var \Mvdnbrk\DhlParcel\Resources\Recipient
     */
    public $recipient;

    /**
     * @var \Mvdnbrk\DhlParcel\Resources\Recipient
     */
    public $sender;

    /**
     * @var \Mvdnbrk\DhlParcel\Resources\Pieces
     */
    public $pieces;

    /**
     * Create a new shipment instance.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->options = new ShipmentOptions;
        $this->recipient = new Recipient;
        $this->sender = new Recipient;
        $this->pieces = new Pieces;

        parent::__construct($attributes);
    }

    /**
     * Get a reference for this parcel. Alias for reference_identifier.
     *
     * @return string
     */
    public function getReferenceAttribute()
    {
        return $this->reference_identifier;
    }

    /**
     * Set a label description for the parcel.
     *
     * @param  string  $value
     * @return $this
     */
    public function labelDescription(string $value)
    {
        $this->options->setDescriptionAttribute($value);

        return $this;
    }

    /**
     * Set the parcel type to mailbox delivery.
     *
     * @return $this
     */
    public function mailboxpackage()
    {
        $this->options->setMailboxPackage();

        return $this;
    }

    /**
     * Deliver the parcel to the recipient only.
     *
     * @return $this
     */
    public function onlyRecipient()
    {
        $this->options->only_recipient = true;

        return $this;
    }

    /**
     * Require a signature from the recipient.
     *
     * @return $this
     */
    public function signature()
    {
        $this->options->signature = true;

        return $this;
    }

    /**
     * Set the shipment options for this parcel.
     *
     * @param  \Mvdnbrk\DhlParcel\Resources\ShipmentOptions|array  $value
     * @return  void
     */
    public function setOptionsAttribute($value)
    {
        $this->options->fill($value);
    }

    /**
     * Set the recipient for this parcel.
     *
     * @param  \Mvdnbrk\DhlParcel\Resources|array  $value
     * @return void
     */
    public function setRecipientAttribute($value)
    {
        if ($value instanceof Recipient) {
            $this->recipient = $value;

            return;
        }

        $this->recipient->fill($value);
    }

    /**
     * Set the service point id where this parcel should be delivered to.
     *
     * @param  string  $value
     * @return  $this
     */
    public function servicePoint(string $value)
    {
        $this->options->setServicePointIdAttribute($value);

        return $this;
    }

    /**
     * Set the sender for this parcel.
     *
     * @param  \Mvdnbrk\DhlParcel\Resources\Recipient|array  $value
     * @return void
     */
    public function setSenderAttribute($value)
    {
        if ($value instanceof Recipient) {
            $this->sender = $value;

            return;
        }

        $this->sender->fill($value);
    }

    /**
     * Set the pieces for this parcel.
     *
     * @param  \Mvdnbrk\DhlParcel\Resources|Pieces|array $value
     * @return void
     */
    public function setPiecesAttribute($value)
    {
        if ($value instanceof Pieces) {
            $this->pieces = $value;

            return;
        }

        $this->pieces = new Pieces($value);
    }

    /**
     * Set a reference for this parcel. Alias for reference_identifier.
     *
     * @param  string  $value
     * @return void
     */
    public function setReferenceAttribute(string $value)
    {
        $this->reference_identifier = $value;
    }

    /**
     * Convert the Parcel resource to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return collect([
                'receiver' => $this->recipient->toArray(),
                'shipper' => $this->sender->toArray(),
                'options' => $this->options->toArray(),
                'pieces' => $this->pieces->toArray(),
            ])
            ->when(! is_null($this->reference_identifier), function ($collection) {
                return $collection->put('orderReference', (string) $this->reference_identifier);
            })
            ->all();
    }
}
