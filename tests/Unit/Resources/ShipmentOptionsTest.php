<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Resources;

use Mvdnbrk\DhlParcel\Resources\ShipmentOptions;
use Mvdnbrk\DhlParcel\Tests\TestCase;

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
        $this->assertFalse($options->extra_assurance);
        $this->assertFalse($options->evening_delivery);
        $this->assertFalse($options->expresser);
        $this->assertFalse($options->add_return_label);
        $this->assertFalse($options->no_track_trace);
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

        $this->assertIsArray($array);

        $this->assertEquals(['key' => 'DOOR'], $array[0]);
    }

    /** @test */
    public function to_array_with_label_description()
    {
        $options = new ShipmentOptions([
            'label_description' => 'Test',
        ]);

        $array = $options->toArray();

        $this->assertIsArray($array);

        $this->assertEquals([
            [
                'key' => 'DOOR',
            ],
            [
                'key' => 'REFERENCE',
                'input' => 'Test',
            ],
        ], $array);
    }

    /** @test */
    public function to_array_parcelshop_with_signature()
    {
        $options = new ShipmentOptions([
            'delivery_type' => 'PS',
            'service_point_id' => '12345',
            'signature' => true,
        ]);

        $array = $options->toArray();

        $this->assertIsArray($array);

        $this->assertEquals([
            [
                'key' => 'PS',
                'input' => '12345',
            ],
            [
                'key' => 'HANDTPS',
            ],
        ], $array);
    }

    /** @test */
    public function to_array_with_signature()
    {
        $options = new ShipmentOptions([
            'signature' => true,
        ]);

        $array = $options->toArray();

        $this->assertIsArray($array);

        $this->assertEquals([
            [
                'key' => 'DOOR',
            ],
            [
                'key' => 'HANDT',
            ],
        ], $array);
    }

    /** @test */
    public function to_array_with_recipient_only()
    {
        $options = new ShipmentOptions([
            'only_recipient' => true,
        ]);

        $array = $options->toArray();

        $this->assertIsArray($array);

        $this->assertEquals([
            [
                'key' => 'DOOR',
            ],
            [
                'key' => 'NBB',
            ],
        ], $array);
    }

    /** @test */
    public function to_array_with_extra_assurance()
    {
        $options = new ShipmentOptions([
            'extra_assurance' => true,
        ]);

        $array = $options->toArray();

        $this->assertIsArray($array);

        $this->assertEquals([
            [
                'key' => 'DOOR',
            ],
            [
                'key' => 'EA',
            ],
        ], $array);
    }

    /** @test */
    public function to_array_with_evening_delivery()
    {
        $options = new ShipmentOptions([
            'evening_delivery' => true,
        ]);

        $array = $options->toArray();

        $this->assertIsArray($array);

        $this->assertEquals([
            [
                'key' => 'DOOR',
            ],
            [
                'key' => 'EVE',
            ],
        ], $array);
    }

    /** @test */
    public function to_array_with_mailbox_package()
    {
        $options = new ShipmentOptions([
            'signature' => true,
            'only_recipient' => true,
        ]);
        $options->setMailboxPackage();

        $array = $options->toArray();

        $this->assertIsArray($array);

        $this->assertEquals(['key' => 'BP'], $array[0]);
    }

    /** @test */
    public function to_array_with_cash_on_delivery()
    {
        $options = new ShipmentOptions([
            'cash_on_delivery' => 9.99,
        ]);

        $array = $options->toArray();

        $this->assertIsArray($array);

        $this->assertEquals([
            [
                'key' => 'DOOR',
            ],
            [
                'key' => 'COD_CASH',
                'input' => '9.99',
            ],
        ], $array);
    }

    /** @test */
    public function to_array_with_no_track_trace()
    {
        $options = new ShipmentOptions([
            'no_track_trace' => true,
        ]);

        $array = $options->toArray();

        $this->assertIsArray($array);

        $this->assertEquals([
            [
                'key' => 'DOOR',
            ],
            [
                'key' => 'NO_TRACK_TRACE',
            ],
        ], $array);
    }

    /** @test */
    public function to_array_with_track_trace_note()
    {
        $options = new ShipmentOptions([
            'track_trace_note' => 'Test',
        ]);

        $array = $options->toArray();

        $this->assertIsArray($array);

        $this->assertEquals([
            [
                'key' => 'DOOR',
            ],
            [
                'key' => 'PERS_NOTE',
                'input' => 'Test',
            ],
        ], $array);
    }

    /** @test */
    public function to_array_with_delivery_to_construction()
    {
        $options = new ShipmentOptions([
            'delivery_to_construction' => true,
        ]);

        $array = $options->toArray();

        $this->assertIsArray($array);

        $this->assertEquals([
            [
                'key' => 'DOOR',
            ],
            [
                'key' => 'BOUW',
            ],
        ], $array);
    }

    /** @test */
    public function to_array_with_expresser()
    {
        $options = new ShipmentOptions([
            'expresser' => true,
        ]);

        $array = $options->toArray();

        $this->assertIsArray($array);

        $this->assertEquals([
            [
                'key' => 'DOOR',
            ],
            [
                'key' => 'EXP',
            ],
        ], $array);
    }

    /** @test */
    public function to_array_with_add_return_label()
    {
        $options = new ShipmentOptions([
            'add_return_label' => true,
        ]);

        $array = $options->toArray();

        $this->assertIsArray($array);

        $this->assertEquals([
            [
                'key' => 'DOOR',
            ],
            [
                'key' => 'ADD_RETURN_LABEL',
            ],
        ], $array);
    }

    /** @test */
    public function to_array_with_label_description_extra()
    {
        $options = new ShipmentOptions([
            'description' => 'Test',
            'description_extra' => 'Test extra',
        ]);

        $array = $options->toArray();

        $this->assertIsArray($array);

        $this->assertEquals([
            [
                'key' => 'DOOR',
            ],
            [
                'key' => 'REFERENCE',
                'input' => 'Test',
            ],
            [
                'key' => 'REFERENCE2',
                'input' => 'Test extra',
            ],
        ], $array);
    }
}
