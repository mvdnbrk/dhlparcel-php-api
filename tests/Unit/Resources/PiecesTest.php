<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Resources;

use Mvdnbrk\DhlParcel\Resources\Piece;
use Mvdnbrk\DhlParcel\Resources\PiecesCollection;
use Mvdnbrk\DhlParcel\Tests\TestCase;

class PiecesTest extends TestCase
{
    /** @test */
    public function it_can_add_a_new_piece_with_a_piece_object()
    {
        $pieces = new PiecesCollection;

        $pieces->add(new Piece);

        $this->assertCount(1, $pieces);
        $this->assertInstanceOf(Piece::class, $pieces->first());
    }

    /** @test */
    public function it_can_add_a_new_piece_with_an_array()
    {
        $pieces = new PiecesCollection;

        $pieces->add([
            'parcel_type' => Piece::PARCEL_TYPE_SMALL,
            'quantity' => 1,
            'weight' => 1,
        ]);

        $this->assertCount(1, $pieces);
        $this->assertEquals(Piece::PARCEL_TYPE_SMALL, $pieces->first()->parcel_type);
        $this->assertSame(1, $pieces->first()->quantity);
        $this->assertSame(1, $pieces->first()->weight);
    }

    /** @test */
    public function it_does_not_add_invalid_values_to_the_collection()
    {
        $pieces = new PiecesCollection;

        $pieces->add('invalid');

        $this->assertCount(0, $pieces);
    }

    /** @test */
    public function creating_a_new_pieces_resource_with_array()
    {
        $pieces = new PiecesCollection([
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

        $this->assertCount(2, $pieces);
        $this->assertInstanceOf(Piece::class, $pieces->first());
        $this->assertInstanceOf(Piece::class, $pieces->last());
        $this->assertEquals(Piece::PARCEL_TYPE_SMALL, $pieces->first()->parcel_type);
        $this->assertSame(1, $pieces->first()->quantity);
        $this->assertSame(1, $pieces->first()->weight);
        $this->assertEquals(Piece::PARCEL_TYPE_MEDIUM, $pieces->last()->parcel_type);
        $this->assertSame(2, $pieces->last()->quantity);
        $this->assertSame(2, $pieces->last()->weight);
    }

    /** @test */
    public function creating_a_new_pieces_resource_with_array_of_piece_objects()
    {
        $pieces = new PiecesCollection([
            new Piece,
        ]);

        $this->assertCount(1, $pieces);
        $this->assertInstanceOf(Piece::class, $pieces->first());
    }

    /** @test */
    public function to_array()
    {
        $pieces = new PiecesCollection([
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
