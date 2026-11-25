<?php

namespace Mvdnbrk\DhlParcel\Endpoints;

use Illuminate\Support\Collection;
use Mvdnbrk\DhlParcel\Resources\Capability as CapabilityResource;
use Mvdnbrk\DhlParcel\Resources\DeliveryArea;
use Mvdnbrk\DhlParcel\Resources\Dimensions;
use Mvdnbrk\DhlParcel\Resources\Option;
use Mvdnbrk\DhlParcel\Resources\ParcelType;
use Mvdnbrk\DhlParcel\Resources\Price;
use Mvdnbrk\DhlParcel\Resources\Product;

class Capabilities extends BaseEndpoint
{
    /**
     * Get the products and options DHL offers for the given filters.
     *
     * @return Collection<int, CapabilityResource>
     */
    public function get(array $filters = []): Collection
    {
        $response = $this->performApiCall(
            'GET',
            'capabilities/business'.$this->buildQueryString($filters)
        );

        $capabilities = new Collection;

        collect($response)->each(function ($capability) use ($capabilities) {
            $capabilityResource = new CapabilityResource([
                'rank' => $capability->rank,
                'fromCountryCode' => $capability->fromCountryCode,
                'toCountryCode' => $capability->toCountryCode,
            ]);

            $capabilityResource->product = new Product([
                'key' => $capability->product->key,
                'label' => $capability->product->label,
                'code' => $capability->product->code,
                'menuCode' => $capability->product->menuCode,
                'businessProduct' => $capability->product->businessProduct,
                'monoColloProduct' => $capability->product->monoColloProduct,
                'softwareCharacteristic' => $capability->product->softwareCharacteristic,
                'returnProduct' => $capability->product->returnProduct,
            ]);

            $capabilityResource->parcelType = new ParcelType([
                'key' => $capability->parcelType->key,
                'category' => $capability->parcelType->category->value ?? null,
                'minWeightKg' => $capability->parcelType->minWeightKg,
                'maxWeightKg' => $capability->parcelType->maxWeightKg,
                'defaultWeightKg' => $capability->parcelType->defaultWeightKg,
                'minWeightGrams' => $capability->parcelType->minWeightGrams,
                'maxWeightGrams' => $capability->parcelType->maxWeightGrams,
                'defaultWeightGrams' => $capability->parcelType->defaultWeightGrams,
                'price' => $this->price($capability->parcelType->price ?? null),
            ]);

            $capabilityResource->parcelType->dimensions = new Dimensions([
                'maxLengthCm' => $capability->parcelType->dimensions->maxLengthCm,
                'maxWidthCm' => $capability->parcelType->dimensions->maxWidthCm,
                'maxHeightCm' => $capability->parcelType->dimensions->maxHeightCm,
            ]);

            collect($capability->options)->each(function ($option) use ($capabilityResource) {
                $capabilityResource->options->add(new Option([
                    'key' => $option->key,
                    'description' => $option->description,
                    'rank' => $option->rank,
                    'code' => $option->code,
                    'optionType' => $option->optionType,
                    'price' => $this->price($option->price ?? null),
                ]));
            });

            if (isset($capability->deliveryArea)) {
                $capabilityResource->deliveryArea = new DeliveryArea([
                    'remote' => $capability->deliveryArea->remote,
                    'type' => $capability->deliveryArea->type,
                ]);
            }

            $capabilities->add($capabilityResource);
        });

        return $capabilities;
    }

    protected function price(?object $price): ?Price
    {
        if ($price === null) {
            return null;
        }

        return new Price([
            'withTax' => $price->withTax,
            'withoutTax' => $price->withoutTax,
            'vatRate' => $price->vatRate,
            'currency' => $price->currency,
        ]);
    }
}
