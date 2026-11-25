<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Resources;

use Illuminate\Support\Collection;
use Mvdnbrk\DhlParcel\Resources\Shipment;
use Mvdnbrk\DhlParcel\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ShipmentTest extends TestCase
{
    #[Test]
    public function it_has_a_pieces_collection(): void
    {
        $shipment = new Shipment;

        $this->assertInstanceOf(Collection::class, $shipment->pieces);
    }

    #[Test]
    public function creating_a_new_shipment_resource(): void
    {
        $shipment = new Shipment([
            'id' => '123456',
            'barcode' => 'JVGL11112222333344445555',
            'label_id' => '12345678-aaaa-bbbb-cccc-123456789123',
        ]);

        $this->assertEquals('123456', $shipment->id);
        $this->assertEquals('JVGL11112222333344445555', $shipment->barcode);
        $this->assertEquals('12345678-aaaa-bbbb-cccc-123456789123', $shipment->label_id);
    }
}
