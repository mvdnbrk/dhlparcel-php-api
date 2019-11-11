<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Resources;

use Mvdnbrk\DhlParcel\Resources\Piece;
use Mvdnbrk\DhlParcel\Resources\Pieces;
use Mvdnbrk\DhlParcel\Tests\TestCase;

class PiecesTest extends TestCase
{
    /** @test */
    public function creating_a_new_pieces_resource_with_array()
    {
        $pieces = new Pieces([
            'pieces' => [
                [
                    'parcel_type' => Piece::PARCEL_TYPE_SMALL,
                    'quantity' => 1,
                    'weight' => 1,
                ],
            ],
        ]);

        $this->assertEquals(Piece::PARCEL_TYPE_SMALL, $pieces->pieces[0]->parcel_type);
        $this->assertEquals(1, $pieces->pieces[0]->quantity);
        $this->assertEquals(1, $pieces->pieces[0]->weight);
    }

    /** @test */
    public function creating_a_new_pieces_resource_with_array_of_piece_objects()
    {
        $pieces = new Pieces([
            'pieces' => [
                new Piece,
            ],
        ]);

        $this->assertEquals(Piece::PARCEL_TYPE_SMALL, $pieces->pieces[0]->parcel_type);
        $this->assertEquals(1, $pieces->pieces[0]->quantity);
    }

    /** @test */
    public function it_can_add_a_new_piece_object()
    {
        $pieces = new Pieces;

        $pieces->addPiece(new Piece);

        $this->assertEquals(Piece::PARCEL_TYPE_SMALL, $pieces->pieces[0]->parcel_type);
        $this->assertEquals(1, $pieces->pieces[0]->quantity);
    }

    /** @test */
    public function it_can_add_a_new_piece_array()
    {
        $pieces = new Pieces;

        $pieces->addPiece([
            'parcel_type' => Piece::PARCEL_TYPE_SMALL,
            'quantity' => 1,
            'weight' => 1,
        ]);

        $this->assertEquals(Piece::PARCEL_TYPE_SMALL, $pieces->pieces[0]->parcel_type);
        $this->assertEquals(1, $pieces->pieces[0]->quantity);
        $this->assertEquals(1, $pieces->pieces[0]->weight);
    }

    /** @test */
    public function to_array()
    {
        $pieces = new Pieces([
            'pieces' => [
                [
                    'parcel_type' => Piece::PARCEL_TYPE_SMALL,
                    'quantity' => 1,
                    'weight' => 1,
                ]
            ],
        ]);

        $array = $pieces->toArray();

        $this->assertIsArray($array);
        $this->assertIsArray($array[0]);
        $this->assertEquals(Piece::PARCEL_TYPE_SMALL, $array[0]['parcelType']);
        $this->assertEquals(1, $array[0]['quantity']);
        $this->assertEquals(1, $array[0]['weight']);
    }
}
