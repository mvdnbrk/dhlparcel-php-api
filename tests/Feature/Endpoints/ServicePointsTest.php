<?php

namespace Mvdnbrk\DhlParcel\Tests\Feature\Endpoints;

use Illuminate\Support\Collection;
use Mvdnbrk\DhlParcel\Endpoints\ServicePoints;
use Mvdnbrk\DhlParcel\Resources\ServicePoint as ServicePointResource;
use Mvdnbrk\DhlParcel\Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;

#[Group('integration')]
class ServicePointsTest extends TestCase
{
    #[Test]
    public function it_can_set_the_postal_code(): void
    {
        $servicePoints = new ServicePoints($this->client);

        $servicePoints->setPostalCode('1234AA');
        $this->assertEquals('1234AA', $servicePoints->postal_code);

        $servicePoints->setPostalCode('1234xy');
        $this->assertEquals('1234XY', $servicePoints->postal_code);

        $servicePoints->setPostalCode('1234 AA');
        $this->assertEquals('1234AA', $servicePoints->postal_code);
    }

    #[Test]
    public function it_can_set_the_housenumber(): void
    {
        $servicePoints = new ServicePoints($this->client);

        $servicePoints->setHouseNumber('111');
        $this->assertEquals('111', $servicePoints->housenumber);
    }

    #[Test]
    public function it_can_retrieve_service_points(): void
    {
        $servicepoints = $this->client->servicePoints->setPostalcode('1012AA')->setHousenumber('1')->get();

        $this->assertInstanceOf(Collection::class, $servicepoints);
        $this->assertInstanceOf(ServicePointResource::class, $servicepoints->first());
    }

    #[Test]
    public function it_can_retrieve_service_points_with_country(): void
    {
        $servicepoints = $this->client->servicePoints->setPostalcode('10115')->setHousenumber('1')->setCountry('DE')->get();

        $this->assertInstanceOf(Collection::class, $servicepoints);
        $this->assertInstanceOf(ServicePointResource::class, $servicepoints->first());
    }
}
