<?php

namespace Mvdnbrk\DhlParcel\Tests\Feature\Endpoints;

use Mvdnbrk\DhlParcel\Resources\Parcel;
use Mvdnbrk\DhlParcel\Resources\Shipment;
use Mvdnbrk\DhlParcel\Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;

#[Group('integration')]
class LabelsTest extends TestCase
{
    protected Shipment $shipment;

    protected function setUp(): void
    {
        parent::setUp();

        $parcel = new Parcel([
            'recipient' => $this->validRecipient(),
            'sender' => $this->validRecipient(),
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

    #[Test]
    public function get_a_label_by_id(): void
    {
        $pdf = $this->client->labels->get($this->shipment->label_id);

        $this->assertIsString($pdf);
    }

    #[Test]
    public function get_a_label_by_shipment_object(): void
    {
        $pdf = $this->client->labels->get($this->shipment);

        $this->assertIsString($pdf);
    }

    #[Test]
    public function getting_a_label_with_an_invalid_shipment_id_should_throw_an_error(): void
    {
        $this->expectException(\Mvdnbrk\DhlParcel\Exceptions\DhlParcelException::class);
        $this->expectExceptionMessage("Error executing API call: Could not parse id from '999999'");

        $this->client->labels->get('999999');
    }
}
