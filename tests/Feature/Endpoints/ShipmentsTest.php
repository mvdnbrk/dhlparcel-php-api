<?php

namespace Mvdnbrk\DhlParcel\Tests\Feature\Endpoints;

use Mvdnbrk\DhlParcel\Resources\Parcel;
use Mvdnbrk\DhlParcel\Resources\ShipmentPiece;
use Mvdnbrk\DhlParcel\Tests\TestCase;

/** @group integration */
class ShipmentsTest extends TestCase
{
    /** @test */
    public function create_a_new_shipment()
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

        $parcel->labelDescription('Test label description');
        $parcel->onlyRecipient();
        $parcel->signature();

        $shipment = $this->client->shipments->create($parcel);

        $this->assertNotNull($shipment->id);
        $this->assertNotNull($shipment->barcode);
        $this->assertNotNull($shipment->label_id);

        $piece = $shipment->pieces->first();
        $this->assertInstanceOf(ShipmentPiece::class, $piece);
        $this->assertNotNull($piece->label_id);
        $this->assertNotNull($piece->label_type);
        $this->assertNotNull($piece->parcel_type);
        $this->assertNotNull($piece->tracker_code);
        $this->assertSame(1, $piece->piece_number);
    }
}
