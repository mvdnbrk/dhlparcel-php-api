<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Resources;

use Mvdnbrk\DhlParcel\Resources\Piece;
use Mvdnbrk\DhlParcel\Resources\PiecesCollection;
use Mvdnbrk\DhlParcel\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PiecesCollectionTest extends TestCase
{
    #[Test]
    public function it_can_add_a_new_piece_with_a_piece_object(): void
    {
        $pieces = new PiecesCollection;

        $pieces->add(new Piece);

        $this->assertCount(1, $pieces);
        $this->assertInstanceOf(Piece::class, $pieces->first());
    }

    #[Test]
    public function it_can_add_a_new_piece_with_an_array(): void
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

    #[Test]
    public function it_does_not_add_invalid_values_to_the_collection(): void
    {
        $pieces = new PiecesCollection;

        $pieces->add('invalid');

        $this->assertCount(0, $pieces);
    }

    #[Test]
    public function creating_a_new_pieces_resource_with_array(): void
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

    #[Test]
    public function creating_a_new_pieces_resource_with_array_of_piece_objects(): void
    {
        $pieces = new PiecesCollection([
            new Piece,
        ]);

        $this->assertCount(1, $pieces);
        $this->assertInstanceOf(Piece::class, $pieces->first());
    }

    #[Test]
    public function to_array(): void
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
