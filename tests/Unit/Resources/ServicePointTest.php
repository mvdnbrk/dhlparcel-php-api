<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Resources;

use Mvdnbrk\DhlParcel\Tests\TestCase;
use Mvdnbrk\DhlParcel\Resources\ServicePoint;

class ServicePointTest extends TestCase
{
    /** @test */
    public function creating_a_valid_service_point()
    {
        $servicepoint = new ServicePoint([
            'id' => '1234-NL-123456',
            'name' => 'Test Service Point',
            'distance' => 1234,
        ]);

        $this->assertEquals('1234-NL-123456', $servicepoint->id);
        $this->assertEquals('Test Service Point', $servicepoint->name);
        $this->assertEquals(1234, $servicepoint->distance);
    }

    /** @test */
    public function address_may_used_to_fill_address_details()
    {
        $servicepoint = new ServicePoint([
            'address' => [
                'postalCode' => '1234AA',
                'countryCode' => 'NL',
            ]
        ]);

        $this->assertEquals('1234AA', $servicepoint->postal_code);
        $this->assertEquals('NL', $servicepoint->cc);
    }

    /** @test */
    public function gelocation_may_be_used_to_set_latitude_and_longitude()
    {
        $servicepoint = new ServicePoint([
            'geoLocation' => [
                'latitude' => 1.234,
                'longitude' => 5.678,
            ]
        ]);

        $this->assertEquals(1.234, $servicepoint->latitude);
        $this->assertEquals(5.678, $servicepoint->longitude);
    }

    /** @test */
    public function it_can_get_distance_in_a_human_readable_format()
    {
        $servicepoint = new ServicePoint;
        $this->assertEquals('', $servicepoint->distanceForHumans());

        $servicepoint->distance = 999;
        $this->assertEquals('999 meter', $servicepoint->distanceForHumans());

        $servicepoint->distance = 1000;
        $this->assertEquals('1 km', $servicepoint->distanceForHumans());

        $servicepoint->distance = 1500;
        $this->assertEquals('1.5 km', $servicepoint->distanceForHumans());

        $servicepoint->distance = 2211;
        $this->assertEquals('2.2 km', $servicepoint->distanceForHumans());

        $servicepoint->distance = 2255;
        $this->assertEquals('2.3 km', $servicepoint->distanceForHumans());

        $servicepoint->distance = 11500;
        $this->assertEquals('12 km', $servicepoint->distanceForHumans());
    }

    /** @test */
    public function to_array()
    {
        $servicepoint = new ServicePoint([
            'id' => 'testcode1234',
            'name' => 'Test name',
            'street' => 'Poststraat',
            'postal_code' => '1234AA',
            'number' => '123',
            'city' => 'Amsterdam',
            'latitude' => 1.11,
            'longitude' => 2.22,
            'distance' => 100,
        ]);

        $array = $servicepoint->toArray();

        $this->assertIsArray($array);
        $this->assertEquals('testcode1234', $array['id']);
        $this->assertEquals('Test name', $array['name']);
        $this->assertEquals('Poststraat', $array['street']);
        $this->assertEquals('123', $array['number']);
        $this->assertEquals('1234AA', $array['postal_code']);
        $this->assertEquals('Amsterdam', $array['city']);
        $this->assertEquals(1.11, $array['latitude']);
        $this->assertEquals(2.22, $array['longitude']);
        $this->assertEquals('100 meter', $array['distance']);
    }

    /** @test */
    public function to_array_removes_empty_attributes()
    {
        $servicepoint = new ServicePoint([
            'id' => null,
            'name' => 'Test name',
            'latitude' => null,
            'longitude' => null,
            'distance' => null,
        ]);

        $array = $servicepoint->toArray();

        $this->assertIsArray($array);
        $this->assertArrayNotHasKey('id', $array);
        $this->assertEquals('Test name', $array['name']);
        $this->assertArrayNotHasKey('latitude', $array);
        $this->assertArrayNotHasKey('longitude', $array);
        $this->assertArrayNotHasKey('distance', $array);
    }
}
