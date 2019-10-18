<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Resources;

use Mvdnbrk\DhlParcel\Resources\TrackTrace;
use Mvdnbrk\DhlParcel\Tests\TestCase;

class TrackTraceTest extends TestCase
{
    /** @test */
    public function creating_a_new_track_trace_resource()
    {
        $tracktrace = new TrackTrace([
            'barcode' => 'JVGL11112222333344445555',
        ]);

        $this->assertEquals('JVGL11112222333344445555', $tracktrace->barcode);
        $this->assertFalse($tracktrace->isDelivered);
    }

    /** @test */
    public function it_can_determine_if_the_parcel_is_delivered()
    {
        $tracktrace = new TrackTrace();

        $this->assertFalse($tracktrace->isDelivered);

        $tracktrace = new TrackTrace([
            'barcode' => 'JVGL11112222333344445555',
            'deliveredAt' => '2019-01-01T12:00:00.000+00:00',
        ]);

        $this->assertTrue($tracktrace->isDelivered);
    }
}
