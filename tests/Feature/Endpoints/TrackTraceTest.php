<?php

namespace Mvdnbrk\DhlParcel\Tests\Feature\Endpoints;

use Mvdnbrk\DhlParcel\Resources\Parcel;
use Mvdnbrk\DhlParcel\Tests\TestCase;

class TrackTraceTest extends TestCase
{
    /** @test */

    /** @group integration */
    public function getting_track_and_trace_information()
    {
        $parcel = new Parcel([
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

        $shipment = $this->client->shipments->create($parcel);

        sleep(5);

        $tracktrace = $this->client->tracktrace->get($shipment->barcode);

        $this->assertEquals($shipment->barcode, $tracktrace->barcode);
        $this->assertFalse($tracktrace->isDelivered);
    }

    /** @test */
    public function getting_track_and_trace_information_with_an_invalid_barcode_should_throw_an_error()
    {
        $this->expectException(\Mvdnbrk\DhlParcel\Exceptions\DhlParcelException::class);
        $this->expectExceptionMessage("Unable to decode DHL Parcel response: 'No parcel found for the given key(s)'.");

        $response = $this->client->tracktrace->get('invalid');
    }
}
