<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Resources;

use Mvdnbrk\DhlParcel\Resources\Piece;
use Mvdnbrk\DhlParcel\Resources\Shipment;
use Mvdnbrk\DhlParcel\Tests\TestCase;

class ShipmentTest extends TestCase
{
    /** @test */
    public function creating_a_new_shipment_resource_with_array()
    {
        $shipment = new Shipment([
            'id' => '1234',
            'pieces' => [
                [
                    'parcel_type' => Piece::PARCEL_TYPE_MEDIUM,
                    'quantity' => 1,
                    'weight' => 1,
                    'label_id' => '123456',
                    'tracker_code' => 'SAMPLE',
                ],
            ],
        ]);

        $this->assertEquals('1234', $shipment->id);
        $this->assertEquals(Piece::PARCEL_TYPE_MEDIUM, $shipment->pieces->pieces[0]->parcel_type);
        $this->assertEquals(1, $shipment->pieces->pieces[0]->quantity);
        $this->assertEquals(1, $shipment->pieces->pieces[0]->weight);
        $this->assertEquals('123456', $shipment->pieces->pieces[0]->label_id);
        $this->assertEquals('SAMPLE', $shipment->pieces->pieces[0]->tracker_code);
    }

    /** @test */
    public function creating_a_new_shipment_resource_with_array_of_piece_objects()
    {
        $shipment = new Shipment([
            'id' => '1234',
            'pieces' => [
                new Piece(),
            ],
        ]);

        $this->assertEquals('1234', $shipment->id);
        $this->assertEquals(Piece::PARCEL_TYPE_SMALL, $shipment->pieces->pieces[0]->parcel_type);
        $this->assertEquals(1, $shipment->pieces->pieces[0]->quantity);
    }

    /** @test */
    public function it_can_add_a_new_piece_object()
    {
        $shipment = new Shipment([
            'id' => '1234',
        ]);

        $shipment->pieces->addPiece(new Piece);

        $this->assertEquals('1234', $shipment->id);
        $this->assertEquals(Piece::PARCEL_TYPE_SMALL, $shipment->pieces->pieces[0]->parcel_type);
        $this->assertEquals(1, $shipment->pieces->pieces[0]->quantity);
    }

    /** @test */
    public function it_can_add_a_new_piece_with_an_array()
    {
        $shipment = new Shipment([
            'id' => '1234',
        ]);

        $shipment->pieces->addPiece([
            'parcel_type' => Piece::PARCEL_TYPE_SMALL,
            'quantity' => 1,
            'weight' => 1,
        ]);

        $this->assertEquals('1234', $shipment->id);
        $this->assertEquals(Piece::PARCEL_TYPE_SMALL, $shipment->pieces->pieces[0]->parcel_type);
        $this->assertEquals(1, $shipment->pieces->pieces[0]->quantity);
        $this->assertEquals(1, $shipment->pieces->pieces[0]->weight);
    }

    /** @test */
    public function to_array()
    {
        $shipment = new Shipment([
            'id' => '1234',
            'pieces' => [
                [
                    'parcel_type' => Piece::PARCEL_TYPE_SMALL,
                    'quantity' => 1,
                    'weight' => 1,
                    'label_id' => '123456',
                    'tracker_code' => 'SAMPLE',
                ],
            ],
        ]);

        $array = $shipment->toArray();

        $this->assertIsArray($array);
        $this->assertEquals('1234', $array['id']);
        $this->assertArrayHasKey('pieces', $array);
        $this->assertIsArray($array['pieces'][0]);
        $this->assertEquals(Piece::PARCEL_TYPE_SMALL, $array['pieces'][0]['parcelType']);
        $this->assertEquals(1, $array['pieces'][0]['quantity']);
        $this->assertEquals(1, $array['pieces'][0]['weight']);
    }
}
