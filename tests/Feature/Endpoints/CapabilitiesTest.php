<?php

namespace Mvdnbrk\DhlParcel\Tests\Feature\Endpoints;

use Mvdnbrk\DhlParcel\Exceptions\DhlParcelException;
use Mvdnbrk\DhlParcel\Resources\Capability;
use Mvdnbrk\DhlParcel\Resources\Option;
use Mvdnbrk\DhlParcel\Resources\ParcelType;
use Mvdnbrk\DhlParcel\Resources\Product;
use Mvdnbrk\DhlParcel\Tests\TestCase;

class CapabilitiesTest extends TestCase
{
    /** @test */
    public function get_capabilities()
    {
        $capabilities = $this->client->capabilities->get('business');

        $this->assertGreaterThan(0, $capabilities->count());
        $this->assertInstanceOf(Capability::class, $capabilities->get(0));
        $this->assertInstanceOf(ParcelType::class, $capabilities->get(0)->parcelType);
        $this->assertInstanceOf(Product::class, $capabilities->get(0)->product);
        $this->assertInstanceOf(Option::class, $capabilities->get(0)->options->get(0));

        $this->assertNotNull($capabilities->get(0)->rank);
        $this->assertNotNull($capabilities->get(0)->fromCountryCode);
        $this->assertNotNull($capabilities->get(0)->toCountryCode);
        $this->assertNotNull($capabilities->get(0)->product);
        $this->assertNotNull($capabilities->get(0)->parcelType);
        $this->assertNotNull($capabilities->get(0)->options);

        $this->assertNotNull($capabilities->get(0)->parcelType->key);
        $this->assertNotNull($capabilities->get(0)->parcelType->category);
        $this->assertNotNull($capabilities->get(0)->parcelType->minWeightKg);
        $this->assertNotNull($capabilities->get(0)->parcelType->maxWeightKg);
        $this->assertNotNull($capabilities->get(0)->parcelType->defaultWeightKg);
        $this->assertNotNull($capabilities->get(0)->parcelType->dimensions);
        $this->assertNotNull($capabilities->get(0)->parcelType->minWeightGrams);
        $this->assertNotNull($capabilities->get(0)->parcelType->maxWeightGrams);
        $this->assertNotNull($capabilities->get(0)->parcelType->defaultWeightGrams);

        $this->assertNotNull($capabilities->get(0)->product->key);
        $this->assertNotNull($capabilities->get(0)->product->label);
        $this->assertNotNull($capabilities->get(0)->product->code);
        $this->assertNotNull($capabilities->get(0)->product->menuCode);
        $this->assertNotNull($capabilities->get(0)->product->businessProduct);
        $this->assertNotNull($capabilities->get(0)->product->monoColloProduct);
        $this->assertNotNull($capabilities->get(0)->product->softwareCharacteristic);
        $this->assertNotNull($capabilities->get(0)->product->returnProduct);

        $this->assertNotNull($capabilities->get(0)->options->get(0)->key);
        $this->assertNotNull($capabilities->get(0)->options->get(0)->description);
        $this->assertNotNull($capabilities->get(0)->options->get(0)->rank);
        $this->assertNotNull($capabilities->get(0)->options->get(0)->code);
        $this->assertNotNull($capabilities->get(0)->options->get(0)->optionType);
    }

    public function invalid_sender_type()
    {
        $this->expectException(DhlParcelException::class);

        $this->client->capabilities->get('somethingnonexisting');
    }

    public function test_specific_to_and_from_country()
    {
        $capabilities = $this->client->capabilities->get('business', [
            'fromCountry' => 'NL',
            'toCountry' => 'BE',
        ]);

        /** @var Capability $capability */
        $capability = $capabilities->get(0);

        $this->assertEquals('NL', $capability->fromCountryCode);
        $this->assertEquals('BE', $capability->toCountryCode);
    }
}
