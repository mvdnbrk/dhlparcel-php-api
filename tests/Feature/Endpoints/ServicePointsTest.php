<?php

namespace Mvdnbrk\DhlParcel\Tests\Feature\Endpoints;

use Mvdnbrk\DhlParcel\Resources\ServicePoint;
use Mvdnbrk\DhlParcel\Tests\TestCase;
use Tightenco\Collect\Support\Collection;

/** @group integration */
class ServicePointsTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_service_points()
    {
        $servicepoints = $this->client->servicePoints->setPostalcode('1012AA')->setHousenumber('1')->get();

        $this->assertInstanceOf(Collection::class, $servicepoints);
        $this->assertInstanceOf(ServicePoint::class, $servicepoints->first());
    }
}
