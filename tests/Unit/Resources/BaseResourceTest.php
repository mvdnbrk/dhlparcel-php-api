<?php

namespace Mvdnbrk\DhlParcel\Tests\Unit\Resources;

use Mvdnbrk\DhlParcel\Exceptions\JsonEncodingException;
use Mvdnbrk\DhlParcel\Resources\BaseResource;
use Mvdnbrk\DhlParcel\Tests\TestCase;

class BaseResourceTest extends TestCase
{
    /** @test */
    public function create_a_new_resource_with_array()
    {
        $resource = new ResourceStub([
            'foo' => 'bar',
        ]);

        $this->assertEquals('bar', $resource->foo);
    }

    /** @test */
    public function set_attribute()
    {
        $resource = new ResourceStub();
        $resource->setAttribute('foo', 'bar');

        $this->assertEquals('bar', $resource->foo);
    }

    /** @test */
    public function set_mutator()
    {
        $resource = new ResourceStub();

        $this->assertTrue($resource->hasSetMutator('testMutator'));

        $resource->setAttribute('test_mutator', 'bar');

        $this->assertEquals('bar', $resource->foo);

        $resource->setAttribute('testMutator', 'qux');

        $this->assertEquals('qux', $resource->foo);
    }

    /** @test */
    public function get_mutator()
    {
        $resource = new ResourceStub();

        $this->assertNull($resource->getAttribute(null));
        $this->assertNull($resource->getAttribute('not-existent'));
        $this->assertNull($resource->getAttributeValue('non-existent-key'));

        $this->assertEquals('test-get-mutator-value', $resource->testGetter);
    }

    /** @test */
    public function get_attribute_value()
    {
        $resource = new ResourceStub();
        $resource->foo = 'test';

        $this->assertEquals('test', $resource->getAttributeValue('foo'));
    }

    /** @test */
    public function to_array_test()
    {
        $resource = new ResourceStub([
            'foo' => 'bar',
        ]);

        $array = $resource->toArray();

        $this->assertIsArray($array);
        $this->assertEquals('bar', $array['foo']);
    }

    /** @test */
    public function to_array_removes_attributes_with_null_values()
    {
        $resource = new ResourceStub([
            'foo' => null,
        ]);

        $array = $resource->toArray();

        $this->assertSame([], $array);
    }

    /** @test */
    public function to_json_test()
    {
        $resource = new ResourceStub([
            'foo' => 'bar',
        ]);

        $this->assertJsonStringEqualsJsonString(json_encode(['foo' => 'bar']), $resource->toJson());
    }

    /** @test */
    public function encoding_malformed_json_throws_an_exception()
    {
        $this->expectException(JsonEncodingException::class);
        $this->expectExceptionMessage('Error encoding resource [Mvdnbrk\DhlParcel\Tests\Unit\Resources\ResourceStub] to JSON: Malformed UTF-8 characters, possibly incorrectly encoded.');

        $obj = new \stdClass;
        $obj->foo = "b\xF8r";

        $resource = new ResourceStub([
            'foo' => $obj,
        ]);

        $resource->toJson();
    }
}

class ResourceStub extends BaseResource
{
    public $foo;

    public function setTestMutatorAttribute($value)
    {
        $this->foo = $value;
    }

    public function getTestGetterAttribute()
    {
        return 'test-get-mutator-value';
    }
}
