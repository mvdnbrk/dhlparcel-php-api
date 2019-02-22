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
        $this->assertFalse($options->signature);
        $this->assertFalse($options->only_recipient);
    }

    /** @test */
    public function description_may_be_used_as_an_alias_to_label_description()
    {
        $options = new ShipmentOptions([
            'description' => 'Test',
        ]);

        $this->assertEquals('Test', $options->label_description);
        $this->assertEquals('Test', $options->description);
    }

    /** @test */
    public function description_gets_truncated_to_fifteen_characters()
    {
        $options = new ShipmentOptions([
            'label_description' => 'Long Description Test',
        ]);

        $this->assertEquals('Long Descriptio', $options->description);

        $options->description = 'Another Long Description';

        $this->assertEquals('Another Long De', $options->description);
    }

    /** @test */
    public function to_array()
    {
        $options = new ShipmentOptions;

        $array = $options->toArray();

        $this->assertInternalType('array', $array);

        $this->assertEquals(['key' => 'DOOR'], $array[0]);
    }
}
