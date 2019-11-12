<?php

namespace Mvdnbrk\DhlParcel\Tests\Feature\Endpoints;

use Mvdnbrk\DhlParcel\Resources\Parcel;
use Mvdnbrk\DhlParcel\Resources\Piece;
use Mvdnbrk\DhlParcel\Tests\TestCase;

/** @group integration */
class LabelsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $parcel = new Parcel([
            'recipient' => $this->validRecipient(),
            'sender' => $this->validRecipient(),
            'pieces' => [
                new Piece(),
            ],
        ]);

        $this->shipment = $this->client->shipments->create($parcel);
    }

    private function validRecipient($overrides = [])
    {
        return array_merge([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'street' => 'Poststraat',
            'number' => '1',
            'postal_code' => '1234AA',
            'city' => 'Amsterdam',
            'cc' => 'NL',
        ], $overrides);
    }

    /** @test */
    public function get_a_label_by_id()
    {
        $pdf = $this->client->labels->getByLabelId($this->shipment->pieces->pieces[0]->label_id);

        $this->assertIsString('string', $pdf);
    }

    /** @test */
    public function get_a_label_by_shipment_object()
    {
        $pdf = $this->client->labels->get($this->shipment);

        $this->assertIsString('string', $pdf);
    }

    /** @test */
    public function getting_a_label_with_an_invalid_shipment_id_should_throw_an_error()
    {
        $this->expectException(\Mvdnbrk\DhlParcel\Exceptions\DhlParcelException::class);
        $this->expectExceptionMessage('Error executing API call: Could not parse LabelId from 999999');

        $this->client->labels->get('999999');
    }
}
