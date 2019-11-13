<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Resources;

use Mvdnbrk\DhlParcel\Resources\ShipmentPiece;
use Mvdnbrk\DhlParcel\Tests\TestCase;

class ShipnmentPieceTest extends TestCase
{
    /** @test */
    public function creating_a_new_shipment_piece_resource()
    {
        $piece = new ShipmentPiece([
            'label_id' => '123456',
            'label_type' => 'B2X_Generic_A4',
            'parcel_type' => 'SMALL',
            'piece_number' => 1,
            'tracker_code' => 'SAMPLE0000001234',
        ]);

        $this->assertEquals('123456', $piece->label_id);
        $this->assertEquals('B2X_Generic_A4', $piece->label_type);
        $this->assertEquals('SMALL', $piece->parcel_type);
        $this->assertSame(1, $piece->piece_number);
        $this->assertEquals('SAMPLE0000001234', $piece->tracker_code);
    }

    /** @test */
    public function piece_number_should_be_converted_to_an_integer()
    {
        $piece = new ShipmentPiece([
            'piece_number' => '1',
        ]);

        $this->assertSame(1, $piece->piece_number);
    }
}
