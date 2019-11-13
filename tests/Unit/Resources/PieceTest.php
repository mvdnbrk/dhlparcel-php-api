<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Resources;

use Mvdnbrk\DhlParcel\Resources\Piece;
use Mvdnbrk\DhlParcel\Tests\TestCase;

class PieceTest extends TestCase
{
    /** @test */
    public function creating_a_new_default_piece_resource()
    {
        $piece = new Piece;

        $this->assertEquals(Piece::PARCEL_TYPE_SMALL, $piece->parcel_type);
        $this->assertEquals(1, $piece->quantity);
        $this->assertNull($piece->weight);
    }

    /** @test */
    public function creating_a_new_piece_resource()
    {
        $piece = new Piece([
            'parcel_type' => Piece::PARCEL_TYPE_MEDIUM,
            'quantity' => 2,
            'weight' => 3,
        ]);

        $this->assertEquals(Piece::PARCEL_TYPE_MEDIUM, $piece->parcel_type);
        $this->assertEquals(2, $piece->quantity);
        $this->assertEquals(3, $piece->weight);
    }

    /** @test */
    public function to_array()
    {
        $piece = new Piece([
            'parcel_type' => Piece::PARCEL_TYPE_LARGE,
            'quantity' => 10,
            'weight' => 20,
        ]);

        $array = $piece->toArray();

        $this->assertIsArray($array);
        $this->assertEquals(Piece::PARCEL_TYPE_LARGE, $array['parcelType']);
        $this->assertArrayNotHasKey('parcel_type', $array);
        $this->assertEquals(10, $array['quantity']);
        $this->assertEquals(20, $array['weight']);
    }
}
