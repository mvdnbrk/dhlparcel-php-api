<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Resources;

use Mvdnbrk\DhlParcel\Tests\TestCase;
use Mvdnbrk\DhlParcel\Resources\Recipient;

class RecipientTest extends TestCase
{
    private function validParams($overrides = [])
    {
        return array_merge([
            'company' => 'Test Company B.V.',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '0101111111',
        ], $overrides);
    }

    /** @test */
    public function creating_a_valid_recipient_resource()
    {
        $recipient = new Recipient([
            'company' => 'Test Company B.V.',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '0101111111',
        ]);

        $this->assertEquals('Test Company B.V.', $recipient->company);
        $this->assertEquals('John', $recipient->first_name);
        $this->assertEquals('Doe', $recipient->last_name);
        $this->assertEquals('john@example.com', $recipient->email);
        $this->assertEquals('0101111111', $recipient->phone);
    }

    /** @test */
    public function to_array()
    {
        $attributes = [
            'company' => 'Test Company B.V.',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '0101111111',
            'street' => 'Poststraat',
            'number' => '1',
            'postal_code' => '1234AA',
            'city' => 'Amsterdam',
            'region' => 'Noord-Holland',
            'cc' => 'NL',
        ];

        $recipient = new Recipient($attributes);

        $array = $recipient->toArray();

        $this->assertIsArray($array);

        $this->assertArrayHasKey('name', $array);
        $this->assertIsArray($array['name']);
        $this->assertEquals('John', $array['name']['firstName']);
        $this->assertEquals('Doe', $array['name']['lastName']);
        $this->assertEquals('Test Company B.V.', $array['name']['companyName']);

        $this->assertArrayHasKey('address', $array);
        $this->assertIsArray($array['address']);
        $this->assertEquals('Poststraat', $array['address']['street']);
        $this->assertEquals('1', $array['address']['number']);
        $this->assertEquals('1234AA', $array['address']['postalCode']);
        $this->assertEquals('Amsterdam', $array['address']['city']);
        $this->assertEquals('NL', $array['address']['countryCode']);

        $this->assertTrue($array['address']['isBusiness']);

        $this->assertArrayHasKey('email', $array);
        $this->assertEquals('john@example.com', $array['email']);
        $this->assertArrayHasKey('phoneNumber', $array);
        $this->assertEquals('0101111111', $array['phoneNumber']);
        $this->assertArrayNotHasKey('phone', $array);

        $recipient->email = null;
        $recipient->phone = null;
        $recipient->company = null;
        $array = $recipient->toArray();
        $this->assertArrayNotHasKey('email', $array);
        $this->assertArrayNotHasKey('phone', $array);
        $this->assertArrayNotHasKey('phoneNumber', $array);
        $this->assertArrayNotHasKey('companyName', $array['name']);
        $this->assertFalse($array['address']['isBusiness']);
    }
}
