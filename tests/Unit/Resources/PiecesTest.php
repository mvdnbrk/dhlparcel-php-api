<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Resources;

use Mvdnbrk\DhlParcel\Resources\Piece;
use Mvdnbrk\DhlParcel\Resources\Pieces;
use Mvdnbrk\DhlParcel\Tests\TestCase;

class PiecesTest extends TestCase
{
    /** @test */
    public function it_can_add_a_new_piece_with_a_piece_object()
    {
        $pieces = new Pieces;

        $pieces->add(new Piece);

        $this->assertCount(1, $pieces->items);
        $this->assertInstanceOf(Piece::class, $pieces->items[0]);
    }

    /** @test */
    public function it_can_add_a_new_piece_with_an_array()
    {
        $pieces = new Pieces;

        $pieces->add([
            'parcel_type' => Piece::PARCEL_TYPE_SMALL,
            'quantity' => 1,
            'weight' => 1,
        ]);

        $this->assertCount(1, $pieces->items);
        $this->assertEquals(Piece::PARCEL_TYPE_SMALL, $pieces->items[0]->parcel_type);
        $this->assertSame(1, $pieces->items[0]->quantity);
        $this->assertSame(1, $pieces->items[0]->weight);
    }

    /** @test */
    public function creating_a_new_pieces_resource_with_array()
    {
        $pieces = new Pieces([
            [
                'parcel_type' => Piece::PARCEL_TYPE_SMALL,
                'quantity' => 1,
                'weight' => 1,
            ],
            [
                'parcel_type' => Piece::PARCEL_TYPE_MEDIUM,
                'quantity' => 2,
                'weight' => 2,
            ],
        ]);

        $this->assertCount(2, $pieces->items);
        $this->assertInstanceOf(Piece::class, $pieces->items[0]);
        $this->assertInstanceOf(Piece::class, $pieces->items[1]);
        $this->assertEquals(Piece::PARCEL_TYPE_SMALL, $pieces->items[0]->parcel_type);
        $this->assertSame(1, $pieces->items[0]->quantity);
        $this->assertSame(1, $pieces->items[0]->weight);
        $this->assertEquals(Piece::PARCEL_TYPE_MEDIUM, $pieces->items[1]->parcel_type);
        $this->assertSame(2, $pieces->items[1]->quantity);
        $this->assertSame(2, $pieces->items[1]->weight);
    }

    /** @test */
    public function creating_a_new_pieces_resource_with_array_of_piece_objects()
    {
        $pieces = new Pieces([
            new Piece,
        ]);

        $this->assertCount(1, $pieces->items);
        $this->assertInstanceOf(Piece::class, $pieces->items[0]);
    }

    /** @test */
    public function to_array()
    {
        $pieces = new Pieces([
            [
                'parcel_type' => Piece::PARCEL_TYPE_SMALL,
                'quantity' => 1,
                'weight' => 1,
            ],
        ]);

        $array = $pieces->toArray();

        $this->assertIsArray($array);
        $this->assertIsArray($array[0]);
        $this->assertEquals(Piece::PARCEL_TYPE_SMALL, $array[0]['parcelType']);
        $this->assertSame(1, $array[0]['quantity']);
        $this->assertSame(1, $array[0]['weight']);
    }
}
