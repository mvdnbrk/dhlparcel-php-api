<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Resources;

use Mvdnbrk\DhlParcel\Tests\TestCase;
use Mvdnbrk\DhlParcel\Resources\Parcel;
use Mvdnbrk\DhlParcel\Resources\Recipient;

class ParcelTest extends TestCase
{
    /** @test */
    public function it_has_a_recipient()
    {
        $parcel = new Parcel;

        $this->assertInstanceOf(Recipient::class, $parcel->recipient);
    }

    /** @test */
    public function it_has_a_sender()
    {
        $parcel = new Parcel;

        $this->assertInstanceOf(Recipient::class, $parcel->sender);
    }

    /** @test */
    public function to_array()
    {
        $parcel = new Parcel;

        $array = $parcel->toArray();

        $this->assertInternalType('array', $array);

        $this->assertArrayHasKey('receiver', $array);
        $this->assertArrayHasKey('shipper', $array);
    }
}
