<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Resources;

use Mvdnbrk\DhlParcel\Tests\TestCase;
use Mvdnbrk\DhlParcel\Resources\ShipmentOptions;

class ShipmentOptionsTest extends TestCase
{
    /** @test */
    public function creating_a_shipments_options_resource()
    {
        $options = new ShipmentOptions([
            'label_description' => 'Test',
        ]);

        $this->assertEquals('Test', $options->label_description);
    }

    /** @test */
    public function description_may_be_used_as_an_alias_to_label_description()
    {
        $recipient = new ShipmentOptions([
            'description' => 'Test',
        ]);

        $this->assertEquals('Test', $recipient->label_description);
        $this->assertEquals('Test', $recipient->description);
    }

    /** @test */
    public function description_gets_truncated_to_fifteen_characters()
    {
        $recipient = new ShipmentOptions([
            'label_description' => 'Long Description Test',
        ]);

        $this->assertEquals('Long Descriptio', $recipient->description);

        $recipient->description = 'Another Long Description';

        $this->assertEquals('Another Long De', $recipient->description);
    }
}
