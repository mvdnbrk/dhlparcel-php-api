<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Resources;

use Mvdnbrk\DhlParcel\Resources\Piece;
use Mvdnbrk\DhlParcel\Resources\ShipmentPiece;
use Mvdnbrk\DhlParcel\Tests\TestCase;

class ShipmentPieceTest extends TestCase
{
    /** @test */
    public function creating_a_new_shipment_piece_resource()
    {
        $piece = new ShipmentPiece([
            'parcel_type' => Piece::PARCEL_TYPE_MEDIUM,
            'quantity' => 1,
            'weight' => 1,
            'label_id' => '123456',
            'tracker_code' => 'SAMPLE',
        ]);

        $this->assertEquals(Piece::PARCEL_TYPE_MEDIUM, $piece->parcel_type);
        $this->assertEquals(1, $piece->quantity);
        $this->assertEquals(1, $piece->weight);
        $this->assertEquals('123456', $piece->label_id);
        $this->assertEquals('SAMPLE', $piece->tracker_code);
    }

    /** @test */
    public function to_array()
    {
        $piece = new ShipmentPiece([
            'parcel_type' => Piece::PARCEL_TYPE_MEDIUM,
            'quantity' => 1,
            'weight' => 1,
            'label_id' => '123456',
            'tracker_code' => 'SAMPLE',
        ]);

        $array = $piece->toArray();

        $this->assertIsArray($array);
        $this->assertEquals(Piece::PARCEL_TYPE_MEDIUM, $array['parcelType']);
        $this->assertArrayNotHasKey('parcel_type', $array);
        $this->assertEquals(1, $array['quantity']);
        $this->assertEquals(1, $array['weight']);
        $this->assertEquals('123456', $array['labelId']);
        $this->assertArrayNotHasKey('label_id', $array);
        $this->assertEquals('SAMPLE', $array['trackerCode']);
        $this->assertArrayNotHasKey('tracker_code', $array);
    }
}
