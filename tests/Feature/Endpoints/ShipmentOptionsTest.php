<?php

namespace Mvdnbrk\DhlParcel\Tests\Feature\Endpoints;

use Mvdnbrk\DhlParcel\Resources\Parcel;
use Mvdnbrk\DhlParcel\Tests\TestCase;

/** @group integration */
class ShipmentOptionsTest extends TestCase
{
    /** @test */
    public function cod_cash_options_array()
    {
        $parcel = new Parcel([
            'reference' => 'test-123',
            'recipient' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'street' => 'Poststraat',
                'number' => 1,
                'postal_code' => '1234AA',
                'city' => 'Amsterdam',
                'cc' => 'NL',
                'email' => 'john@example.com',
                'phone' => '0612345678',
            ],
            'sender' => [
                'company' => 'Test Company B.V.',
                'street' => 'Pakketstraat',
                'number' => 99,
                'postal_code' => '1234BB',
                'city' => 'Groningen',
                'cc' => 'NL',
                'email' => 'test-company@example.com',
                'phone' => '01012345678',
            ],
            'options' => [
                'cod_cash' => 5,
            ],
        ]);

        $this->assertEquals(5, $parcel->options->cod_cash);
    }

    /** @test */
    public function cod_cash_options_call()
    {
        $parcel = new Parcel([
            'reference' => 'test-123',
            'recipient' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'street' => 'Poststraat',
                'number' => 1,
                'postal_code' => '1234AA',
                'city' => 'Amsterdam',
                'cc' => 'NL',
                'email' => 'john@example.com',
                'phone' => '0612345678',
            ],
            'sender' => [
                'company' => 'Test Company B.V.',
                'street' => 'Pakketstraat',
                'number' => 99,
                'postal_code' => '1234BB',
                'city' => 'Groningen',
                'cc' => 'NL',
                'email' => 'test-company@example.com',
                'phone' => '01012345678',
            ],
        ]);

        $parcel->setCODCash(5);

        $this->assertEquals(5, $parcel->options->cod_cash);
    }
}
