<?php

namespace Mvdnbrk\DhlParcel\Tests\Feature\Endpoints;

use Mvdnbrk\DhlParcel\Endpoints\ServicePoints;
use Mvdnbrk\DhlParcel\Tests\TestCase;

class ServicePointsTest extends TestCase
{
    /** @test */
    public function it_can_set_the_postal_code()
    {
        $servicePoints = new ServicePoints($this->client);

        $servicePoints->setPostalCode('1234AA');
        $this->assertEquals('1234AA', $servicePoints->postal_code);

        $servicePoints->setPostalCode('1234xy');
        $this->assertEquals('1234XY', $servicePoints->postal_code);

        $servicePoints->setPostalCode('1234 AA');
        $this->assertEquals('1234AA', $servicePoints->postal_code);
    }

    /** @test */
    public function it_can_set_the_housenumber()
    {
        $servicePoints = new ServicePoints($this->client);

        $servicePoints->setHouseNumber('111');
        $this->assertEquals('111', $servicePoints->housenumber);
    }

    /** @test */
    public function it_can_retrieve_service_points()
    {
        $servicepoints = $this->client->servicePoints->setPostalcode('1012AA')->setHousenumber('1')->get();

        $this->assertInstanceOf(\Tightenco\Collect\Support\Collection::class, $servicepoints);
        $this->assertInstanceOf(\Mvdnbrk\DhlParcel\Resources\ServicePoint::class, $servicepoints->first());
    }
}
