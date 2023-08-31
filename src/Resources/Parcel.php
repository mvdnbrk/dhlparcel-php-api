<?php

namespace Mvdnbrk\DhlParcel\Resources;

class Parcel extends BaseResource
{
    /** @var string */
    public $reference_identifier;

    /** @var \Mvdnbrk\DhlParcel\Resources\ShipmentOptions */
    public $options;

    /** @var \Mvdnbrk\DhlParcel\Resources\Recipient */
    public $recipient;

    /** @var \Mvdnbrk\DhlParcel\Resources\Recipient */
    public $sender;

    /** @var \Mvdnbrk\DhlParcel\Resources\PiecesCollection */
    public $pieces;

    public function __construct(array $attributes = [])
    {
        $this->options = new ShipmentOptions;
        $this->recipient = new Recipient;
        $this->sender = new Recipient;
        $this->pieces = new PiecesCollection;

        parent::__construct($attributes);
    }

    public function getReferenceAttribute(): string
    {
        return $this->reference_identifier;
    }

    public function labelDescription(string $value): self
    {
        $this->options->setDescriptionAttribute($value);

        return $this;
    }

    public function mailboxpackage(): self
    {
        $this->options->setMailboxPackage();

        return $this;
    }

    public function onlyRecipient(): self
    {
        $this->options->only_recipient = true;

        return $this;
    }

    public function extraAssurance(): self
    {
        $this->options->extra_assurance = true;

        return $this;
    }

    public function insured(int $insuredValue = null): self
    {
        $this->options->insured = true;

        if ($insuredValue) {
            $this->options->insured_value = $insuredValue;
        }

        return $this;
    }

    public function sameDayDelivery(): self
    {
        $this->options->same_day_delivery = true;

        return $this;
    }

    public function addReturnLabel(): self
    {
        $this->options->add_return_label = true;

        return $this;
    }

    public function notifyRecipient(string $notifyInput): self
    {
        $this->options->notify_recipient       = true;
        $this->options->notify_recipient_input = $notifyInput;

        return $this;
    }

    public function eveningDelivery(): self
    {
        $this->options->evening_delivery = true;

        return $this;
    }

    public function saturdayDelivery(): self
    {
        $this->options->saturday_delivery = true;

        return $this;
    }

    public function signature(): self
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
    public function setOptionsAttribute($value): void
    {
        $this->options->fill($value);
    }

    /**
     * Set the recipient for this parcel.
     *
     * @param  \Mvdnbrk\DhlParcel\Resources\Recipient|array  $value
     * @return void
     */
    public function setRecipientAttribute($value): void
    {
        if ($value instanceof Recipient) {
            $this->recipient = $value;

            return;
        }

        $this->recipient->fill($value);
    }

    public function servicePoint(string $value): self
    {
        $this->options->setServicePointIdAttribute($value);

        return $this;
    }

    /**
     * Set the amount for "Cash On Delivery" in EUR.
     *
     * @param  int|float  $value
     * @return  $this
     */
    public function cashOnDelivery($value): self
    {
        $this->options->setCashOnDelivery($value);

        return $this;
    }

    /**
     * Set the sender for this parcel.
     *
     * @param  \Mvdnbrk\DhlParcel\Resources\Recipient|array  $value
     * @return void
     */
    public function setSenderAttribute($value): void
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
     * @param  \Mvdnbrk\DhlParcel\Resources\PiecesCollection|array  $value
     * @return void
     */
    public function setPiecesAttribute($value): void
    {
        if ($value instanceof PiecesCollection) {
            $this->pieces = $value;

            return;
        }

        $this->pieces = new PiecesCollection($value);
    }

    public function setReferenceAttribute(string $value): void
    {
        $this->reference_identifier = $value;
    }

    public function toArray(): array
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
