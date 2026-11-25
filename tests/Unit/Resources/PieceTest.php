<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Resources;

use Mvdnbrk\DhlParcel\Resources\Piece;
use Mvdnbrk\DhlParcel\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PieceTest extends TestCase
{
    #[Test]
    public function creating_a_new_default_piece_resource(): void
    {
        $piece = new Piece;

        $this->assertEquals(Piece::PARCEL_TYPE_SMALL, $piece->parcel_type);
        $this->assertSame(1, $piece->quantity);
        $this->assertNull($piece->weight);
    }

    #[Test]
    public function creating_a_new_piece_resource(): void
    {
        $piece = new Piece([
            'parcel_type' => Piece::PARCEL_TYPE_MEDIUM,
            'quantity' => 2,
            'weight' => 3,
        ]);

        $this->assertEquals(Piece::PARCEL_TYPE_MEDIUM, $piece->parcel_type);
        $this->assertSame(2, $piece->quantity);
        $this->assertSame(3, $piece->weight);
    }

    #[Test]
    public function quantity_should_be_converted_to_an_integer(): void
    {
        $piece = new Piece([
            'quantity' => '1',
        ]);

        $this->assertSame(1, $piece->quantity);
        $this->assertSame(1, $piece->toArray()['quantity']);
    }

    #[Test]
    public function weight_should_be_converted_to_an_integer(): void
    {
        $piece = new Piece([
            'weight' => '1',
        ]);

        $this->assertSame(1, $piece->weight);
        $this->assertSame(1, $piece->toArray()['weight']);
    }

    #[Test]
    public function to_array(): void
    {
        $piece = new Piece([
            'parcel_type' => Piece::PARCEL_TYPE_LARGE,
            'quantity' => 10,
            'weight' => 20,
        ]);

        $array = $piece->toArray();

        $this->assertIsArray($array);
        $this->assertEquals('LARGE', $array['parcelType']);
        $this->assertArrayNotHasKey('parcel_type', $array);
        $this->assertSame(10, $array['quantity']);
        $this->assertSame(20, $array['weight']);
    }
}
