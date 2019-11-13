<?php

namespace Mvdnbrk\DhlParcel\Tests\Feature\Endpoints;

use Mvdnbrk\DhlParcel\Endpoints\ServicePoints;
use Mvdnbrk\DhlParcel\Tests\TestCase;

class ServicePointsTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_service_points()
    {
        $servicepoints = $this->client->servicePoints->setPostalcode('1012AA')->setHousenumber('1')->get();

        $this->assertInstanceOf(\Tightenco\Collect\Support\Collection::class, $servicepoints);
        $this->assertInstanceOf(\Mvdnbrk\DhlParcel\Resources\ServicePoint::class, $servicepoints->first());
    }
}
