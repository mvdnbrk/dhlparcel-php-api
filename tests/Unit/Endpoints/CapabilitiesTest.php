<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Endpoints;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Mvdnbrk\DhlParcel\Client;
use Mvdnbrk\DhlParcel\Resources\Capability;
use Mvdnbrk\DhlParcel\Resources\Dimensions;
use Mvdnbrk\DhlParcel\Resources\Option;
use Mvdnbrk\DhlParcel\Resources\ParcelType;
use Mvdnbrk\DhlParcel\Resources\Product;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

class CapabilitiesTest extends TestCase
{
    #[Test]
    public function it_maps_the_capabilities_response_to_resources(): void
    {
        $history = [];
        $stack = HandlerStack::create(new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode([[
                'rank' => 1,
                'fromCountryCode' => 'NL',
                'toCountryCode' => 'NL',
                'product' => [
                    'key' => 'DFY-B2C',
                    'label' => 'DHL For You',
                    'code' => '2',
                    'menuCode' => '2',
                    'businessProduct' => false,
                    'monoColloProduct' => false,
                    'softwareCharacteristic' => 'PARCELCONNECT',
                    'returnProduct' => false,
                ],
                'parcelType' => [
                    'key' => 'SMALL',
                    'category' => ['value' => 'PARCEL'],
                    'minWeightKg' => 0,
                    'maxWeightKg' => 2,
                    'defaultWeightKg' => 1,
                    'dimensions' => ['maxLengthCm' => 80, 'maxWidthCm' => 50, 'maxHeightCm' => 35],
                    'minWeightGrams' => 0,
                    'maxWeightGrams' => 2000,
                    'defaultWeightGrams' => 1000,
                ],
                'options' => [[
                    'key' => 'DOOR',
                    'description' => 'Delivery to the address of the recipient',
                    'rank' => 1,
                    'code' => 0,
                    'optionType' => 'DELIVERY_OPTION',
                ]],
                'deliveryArea' => ['remote' => false, 'type' => 'DEFAULT'],
            ]])),
        ]));
        $stack->push(Middleware::history($history));

        $client = new Client;
        (new ReflectionProperty(Client::class, 'httpClient'))->setValue($client, new HttpClient(['handler' => $stack]));

        $capabilities = $client->capabilities->get(['fromCountry' => 'NL', 'toCountry' => 'NL']);

        $this->assertSame('/capabilities/business', $history[0]['request']->getUri()->getPath());
        $this->assertSame('fromCountry=NL&toCountry=NL', $history[0]['request']->getUri()->getQuery());

        $this->assertCount(1, $capabilities);
        $capability = $capabilities->first();
        $this->assertInstanceOf(Capability::class, $capability);
        $this->assertSame(1, $capability->rank);
        $this->assertSame('NL', $capability->toCountryCode);
        $this->assertInstanceOf(Product::class, $capability->product);
        $this->assertSame('DFY-B2C', $capability->product->key);
        $this->assertInstanceOf(ParcelType::class, $capability->parcelType);
        $this->assertSame('SMALL', $capability->parcelType->key);
        $this->assertInstanceOf(Dimensions::class, $capability->parcelType->dimensions);
        $this->assertSame(80, $capability->parcelType->dimensions->maxLengthCm);
        $this->assertInstanceOf(Option::class, $capability->options->first());
        $this->assertSame('DOOR', $capability->options->first()->key);
    }
}
