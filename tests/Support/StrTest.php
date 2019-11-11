<?php

namespace Mvdnbrk\DhlParcel\Tests\Support;

use Mvdnbrk\DhlParcel\Support\Str;
use Mvdnbrk\DhlParcel\Tests\TestCase;

class StrTest extends TestCase
{
    /** @test */
    public function camel()
    {
        $this->assertSame('loremPHPIpsum', Str::camel('Lorem_p_h_p_ipsum'));
        $this->assertSame('loremPhpIpsum', Str::camel('Lorem_php_ipsum'));
        $this->assertSame('loremPhPIpsum', Str::camel('Lorem-phP-ipsum'));
        $this->assertSame('loremPhpIpsum', Str::camel('Lorem  -_-  php   -_-   ipsum   '));
        $this->assertSame('fooBar', Str::camel('FooBar'));
        $this->assertSame('fooBar', Str::camel('foo_bar'));
        // test cache
        $this->assertSame('fooBar', Str::camel('foo_bar'));
        $this->assertSame('fooBarBaz', Str::camel('Foo-barBaz'));
        $this->assertSame('fooBarBaz', Str::camel('foo-bar_baz'));
    }

    /** @test */
    public function limit()
    {
        $this->assertEquals('Lorem', Str::limit('Lorem', 5));
        $this->assertEquals('Lorem ipsu', Str::limit('Lorem ipsu', 10));
        $this->assertEquals('Lorem ipsu...', Str::limit('Lorem ipsum dolor sit amet', 10));
    }

    /** @test */
    public function studly()
    {
        $this->assertSame('LoremPHPIpsum', Str::studly('lorem_p_h_p_ipsum'));
        $this->assertSame('LoremPhpIpsum', Str::studly('lorem_php_ipsum'));
        $this->assertSame('LoremPhPIpsum', Str::studly('lorem-phP-ipsum'));
        $this->assertSame('LoremPhpIpsum', Str::studly('lorem  -_-  php   -_-   ipsum   '));

        $this->assertSame('FooBar', Str::studly('fooBar'));
        $this->assertSame('FooBar', Str::studly('foo_bar'));
        // test cache
        $this->assertSame('FooBar', Str::studly('foo_bar'));
        $this->assertSame('FooBarBaz', Str::studly('foo-barBaz'));
        $this->assertSame('FooBarBaz', Str::studly('foo-bar_baz'));
    }

    /** @test */
    public function upper()
    {
        $this->assertSame('FOO BAR BAZ', Str::upper('foo bar baz'));
        $this->assertSame('FOO BAR BAZ', Str::upper('foO bAr BaZ'));
    }
}
