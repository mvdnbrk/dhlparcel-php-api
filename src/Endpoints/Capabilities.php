<?php

namespace Mvdnbrk\DhlParcel\Endpoints;

use Mvdnbrk\DhlParcel\Resources\Capability as CapabilityResource;
use Mvdnbrk\DhlParcel\Resources\Dimensions;
use Mvdnbrk\DhlParcel\Resources\Option;
use Mvdnbrk\DhlParcel\Resources\ParcelType;
use Mvdnbrk\DhlParcel\Resources\Product;
use Tightenco\Collect\Support\Collection;

class Capabilities extends BaseEndpoint
{
    public function get(string $senderType, array $filters = []): Collection
    {
        $queryString = $this->buildQueryString($filters);

        $response = $this->performApiCall(
            'GET',
            'capabilities/'.$senderType.$queryString
        );

        $capabilities = new Collection();

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
                'category' => $capability->parcelType->category,
                'minWeightKg' => $capability->parcelType->minWeightKg,
                'maxWeightKg' => $capability->parcelType->maxWeightKg,
                'defaultWeightKg' => $capability->parcelType->defaultWeightKg,
                'minWeightGrams' => $capability->parcelType->minWeightGrams,
                'maxWeightGrams' => $capability->parcelType->maxWeightGrams,
                'defaultWeightGrams' => $capability->parcelType->defaultWeightGrams,
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
                ]));
            });

            $capabilities->add($capabilityResource);
        });

        return $capabilities;
    }
}
