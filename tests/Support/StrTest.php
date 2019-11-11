<?php

namespace Mvdnbrk\DhlParcel\Tests\Support;

use Mvdnbrk\DhlParcel\Support\Str;
use Mvdnbrk\DhlParcel\Tests\TestCase;

class StrTest extends TestCase
{
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
        $this->assertEquals('FOO BAR', Str::upper('foo bar'));
        $this->assertEquals('FOO BAR', Str::upper('foO bAr'));
    }
}
