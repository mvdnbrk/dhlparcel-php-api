<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Resources;

use Mvdnbrk\DhlParcel\Resources\Address;
use Mvdnbrk\DhlParcel\Tests\TestCase;

class AddressTest extends TestCase
{
    private function validParams($overrides = [])
    {
        return array_merge([
            'street' => 'Poststraat',
            'additional_address_line' => 'Industrie 9999',
            'number' => '1',
            'number_suffix' => 'A',
            'postal_code' => '1234AA',
            'city' => 'Amsterdam',
            'region' => 'Noord-Holland',
            'cc' => 'NL',
        ], $overrides);
    }

    /** @test */
    public function creating_a_valid_address_resource()
    {
        $address = new Address([
            'street' => 'Poststraat',
            'additional_address_line' => 'Industrie 9999',
            'number' => '1',
            'number_suffix' => 'A',
            'postal_code' => '1234AA',
            'city' => 'Amsterdam',
            'region' => 'Noord-Holland',
            'cc' => 'NL',
        ]);

        $this->assertEquals('Poststraat', $address->street);
        $this->assertEquals('Industrie 9999', $address->additional_address_line);
        $this->assertEquals('1', $address->number);
        $this->assertEquals('A', $address->number_suffix);
        $this->assertEquals('1234AA', $address->postal_code);
        $this->assertEquals('Amsterdam', $address->city);
        $this->assertEquals('Noord-Holland', $address->region);
        $this->assertEquals('NL', $address->cc);
    }

    /** @test */
    public function addition_may_be_used_as_an_alias_to_number_suffix()
    {
        $address = new Address([
            'addition' => 'A',
        ]);

        $this->assertEquals('A', $address->number_suffix);
    }

    /** @test */
    public function country_code_may_be_used_as_an_alias_to_cc()
    {
        $address = new Address([
            'country_code' => 'NL',
        ]);

        $this->assertEquals('NL', $address->cc);
    }

    /** @test */
    public function zipcode_may_be_used_as_an_alias_to_postal_code()
    {
        $address = new Address([
            'zipcode' => '9999ZZ',
        ]);

        $this->assertEquals('9999ZZ', $address->postal_code);
    }

    /** @test */
    public function lower_case_country_code_is_converted_to_uppercase()
    {
        $address = new Address($this->validParams([
            'cc' => 'nl',
        ]));

        $this->assertEquals('NL', $address->cc);
    }

    /** @test */
    public function lower_case_postal_code_is_converted_to_uppercase()
    {
        $address = new Address($this->validParams([
            'postal_code' => '1234aa',
        ]));

        $this->assertEquals('1234AA', $address->postal_code);
    }

    /** @test */
    public function number_should_be_casted_to_a_string()
    {
        $address = new Address($this->validParams([
            'number' => 999,
        ]));

        $array = $address->toArray();

        $this->assertIsString($array['number']);
        $this->assertEquals('999', $array['number']);
    }

    /** @test */
    public function to_array()
    {
        $attributes = [
            'street' => 'Poststraat',
            'additional_address_line' => 'Industrie 9999',
            'number' => '1',
            'number_suffix' => 'A',
            'postal_code' => '1234AA',
            'city' => 'Amsterdam',
            'region' => 'Noord-Holland',
            'cc' => 'NL',
        ];

        $address = new Address($attributes);

        $array = $address->toArray();

        $this->assertIsArray($array);
        $this->assertFalse($array['isBusiness']);
        $this->assertEquals('Poststraat', $array['street']);
        $this->assertEquals('Industrie 9999', $array['additionalAddressLine']);
        $this->assertEquals('1', $array['number']);
        $this->assertEquals('A', $array['addition']);
        $this->assertEquals('1234AA', $array['postalCode']);
        $this->assertEquals('NL', $array['countryCode']);
        $this->assertArrayNotHasKey('additional_address_line', $array);
        $this->assertArrayNotHasKey('number_suffix', $array);
        $this->assertArrayNotHasKey('postal_code', $array);
        $this->assertArrayNotHasKey('cc', $array);

        $address->number_suffix = null;
        $array = $address->toArray();
        $this->assertArrayNotHasKey('addition', $array);
        $this->assertArrayNotHasKey('number_suffix', $array);

        $address->additional_address_line = null;
        $array = $address->toArray();
        $this->assertArrayNotHasKey('additionalAddressLine', $array);
        $this->assertArrayNotHasKey('additional_address_line', $array);
    }
}
