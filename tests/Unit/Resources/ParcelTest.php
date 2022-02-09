<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Resources;

use Mvdnbrk\DhlParcel\Resources\Parcel;
use Mvdnbrk\DhlParcel\Resources\Piece;
use Mvdnbrk\DhlParcel\Resources\PiecesCollection;
use Mvdnbrk\DhlParcel\Resources\Recipient;
use Mvdnbrk\DhlParcel\Tests\TestCase;

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
    public function it_has_a_pieces_collection()
    {
        $parcel = new Parcel;

        $this->assertInstanceOf(PiecesCollection::class, $parcel->pieces);
    }

    /** @test */
    public function create_a_new_parcel()
    {
        $parcel = new Parcel([
            'reference_identifier' => 'test-123',
            'recipient' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
            ],
            'sender' => [
                'company' => 'Test Company B.V.',
            ],
            'options' => [
                'description' => 'Test 123',
                'description_extra' => 'Test extra',
                'only_recipient' => true,
                'signature' => true,
                'extra_assurance' => true,
                'evening_delivery' => true,
                'expresser' => true,
                'track_trace_note' => 'Test note',
                'add_return_label' => true,
                'no_track_trace' => true,
                'delivery_to_construction' => true,
            ],
            'pieces' => [
                [
                    'parcel_type' => Piece::PARCEL_TYPE_SMALL,
                    'quantity' => 1,
                    'weight' => 1,
                ],
            ],
        ]);

        $this->assertEquals('test-123', $parcel->reference_identifier);
        $this->assertEquals('test-123', $parcel->reference);
        $this->assertEquals('John', $parcel->recipient->first_name);
        $this->assertEquals('Doe', $parcel->recipient->last_name);
        $this->assertEquals('Test Company B.V.', $parcel->sender->company_name);
        $this->assertEquals('Test 123', $parcel->options->label_description);
        $this->assertEquals('Test extra', $parcel->options->label_description_extra);
        $this->assertEquals('Test note', $parcel->options->track_trace_note);
        $this->assertEquals(Piece::PARCEL_TYPE_SMALL, $parcel->pieces->first()->parcel_type);
        $this->assertEquals(1, $parcel->pieces->first()->quantity);
        $this->assertEquals(1, $parcel->pieces->first()->weight);
        $this->assertSame(true, $parcel->options->only_recipient);
        $this->assertSame(true, $parcel->options->signature);
        $this->assertSame(true, $parcel->options->extra_assurance);
        $this->assertSame(true, $parcel->options->evening_delivery);
        $this->assertSame(true, $parcel->options->add_return_label);
        $this->assertSame(true, $parcel->options->no_track_trace);
        $this->assertSame(true, $parcel->options->expresser);
        $this->assertSame(true, $parcel->options->delivery_to_construction);
    }

    /** @test */
    public function it_can_set_the_recipient_by_passing_a_recipient_object()
    {
        $recipient = new Recipient;

        $parcel = new Parcel([
            'recipient' => $recipient,
        ]);

        $this->assertSame($recipient, $parcel->recipient);
    }

    /** @test */
    public function it_can_set_the_sender_by_passing_a_recipient_object()
    {
        $sender = new Recipient;

        $parcel = new Parcel([
            'sender' => $sender,
        ]);

        $this->assertSame($sender, $parcel->sender);
    }

    /** @test */
    public function it_can_set_the_pieces_by_passing_a_pieces_object()
    {
        $pieces = new PiecesCollection;

        $parcel = new Parcel([
            'pieces' => $pieces,
        ]);

        $this->assertSame($pieces, $parcel->pieces);
    }

    /** @test */
    public function it_can_set_a_label_description()
    {
        $parcel = new Parcel();
        $this->assertNull($parcel->options->label_description);

        $parcel->labelDescription('Test 123');
        $this->assertEquals('Test 123', $parcel->options->label_description);
        $this->assertEquals('Test 123', $parcel->options->description);
    }

    /** @test */
    public function calling_the_label_description_method_returns_the_same_parcel_instance()
    {
        $parcel = new Parcel();

        $this->assertSame($parcel, $parcel->labelDescription('Test 123'));
    }

    /** @test */
    public function it_can_require_a_signature_from_the_recipient_of_the_parcel()
    {
        $parcel = new Parcel();
        $this->assertFalse($parcel->options->signature);

        $parcel->signature();

        $this->assertTrue($parcel->options->signature);
    }

    /** @test */
    public function calling_the_signature_method_returns_the_same_parcel_instance()
    {
        $parcel = new Parcel();

        $this->assertSame($parcel, $parcel->signature());
    }

    /** @test */
    public function it_can_set_a_parcel_to_be_only_delivered_to_the_recipient()
    {
        $parcel = new Parcel();

        $this->assertFalse($parcel->options->only_recipient);

        $parcel->onlyRecipient();

        $this->assertTrue($parcel->options->only_recipient);
    }

    /** @test */
    public function calling_the_only_recipient_method_returns_the_same_parcel_instance()
    {
        $parcel = new Parcel();

        $this->assertSame($parcel, $parcel->onlyRecipient());
    }

    /** @test */
    public function it_can_set_a_parcel_to_be_extra_assured()
    {
        $parcel = new Parcel();

        $this->assertFalse($parcel->options->extra_assurance);

        $parcel->extraAssurance();

        $this->assertTrue($parcel->options->extra_assurance);
    }

    /** @test */
    public function it_can_set_a_parcel_to_be_evening_delivery()
    {
        $parcel = new Parcel();

        $this->assertFalse($parcel->options->evening_delivery);

        $parcel->eveningDelivery();

        $this->assertTrue($parcel->options->evening_delivery);
    }

    /** @test */
    public function calling_the_extra_assurance_method_returns_the_same_parcel_instance()
    {
        $parcel = new Parcel();

        $this->assertSame($parcel, $parcel->extraAssurance());
    }

    /** @test */
    public function calling_the_evening_delivery_method_returns_the_same_parcel_instance()
    {
        $parcel = new Parcel();

        $this->assertSame($parcel, $parcel->eveningDelivery());
    }

    /** @test */
    public function it_can_set_a_parcel_to_be_a_mailbox_package()
    {
        $parcel = new Parcel();

        $parcel->mailboxpackage();

        $this->assertEquals(['key' => 'BP'], $parcel->options->toArray()[0]);
    }

    /** @test */
    public function calling_the_mailboxpackage_method_returns_the_same_parcel_instance()
    {
        $parcel = new Parcel();

        $this->assertSame($parcel, $parcel->mailboxpackage());
    }

    /** @test */
    public function it_can_set_the_service_point_id()
    {
        $parcel = new Parcel([
            'options' => [
                'service_point_id' => '1234-NL-112233',
            ],
        ]);

        $this->assertEquals([
            'key' => 'PS',
            'input' => '1234-NL-112233',
        ], $parcel->options->toArray()[0]);

        $parcel = new Parcel();
        $parcel->servicePoint('5678-NL-445566');

        $this->assertEquals([
            'key' => 'PS',
            'input' => '5678-NL-445566',
        ], $parcel->options->toArray()[0]);
    }

    /** @test */
    public function calling_the_service_point_method_returns_the_same_parcel_instance()
    {
        $parcel = new Parcel();

        $this->assertSame($parcel, $parcel->servicePoint('8004-NL-272403'));
    }

    /** @test */
    public function it_can_set_an_amount_for_cash_on_delivery()
    {
        $parcel = new Parcel([
            'options' => [
                'cash_on_delivery' => 9.99,
            ],
        ]);

        $this->assertEquals([
            'key' => 'COD_CASH',
            'input' => '9.99',
        ], $parcel->options->toArray()[1]);

        $parcel = new Parcel();
        $parcel->cashOnDelivery(100);

        $this->assertEquals([
            'key' => 'COD_CASH',
            'input' => '100',
        ], $parcel->options->toArray()[1]);
    }

    /** @test */
    public function calling_the_cash_on_delivery_method_returns_the_same_parcel_instance()
    {
        $parcel = new Parcel();

        $this->assertSame($parcel, $parcel->cashOnDelivery(100));
    }

    /** @test */
    public function it_sets_the_pieces_to_a_default_value_when_pieces_is_empty()
    {
        $parcel = new Parcel([
            'pieces' => [],
        ]);

        $array = $parcel->toArray();

        $this->assertArrayHasKey('pieces', $array);
        $this->assertCount(1, $array['pieces']);
        $this->assertEquals('SMALL', $array['pieces'][0]['parcelType']);
        $this->assertSame(1, $array['pieces'][0]['quantity']);
        $this->assertArrayNotHasKey('weight', $array['pieces'][0]);
    }

    /** @test */
    public function to_array()
    {
        $parcel = new Parcel;

        $array = $parcel->toArray();

        $this->assertIsArray($array);

        $this->assertArrayHasKey('receiver', $array);
        $this->assertArrayHasKey('shipper', $array);
        $this->assertArrayHasKey('pieces', $array);
    }
}
