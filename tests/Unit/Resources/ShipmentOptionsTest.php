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
}
