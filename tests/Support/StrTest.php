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
    public function lower()
    {
        $this->assertSame('foo bar baz', Str::lower('FOO BAR BAZ'));
        $this->assertSame('foo bar baz', Str::lower('fOo Bar bAz'));
    }

    /** @test */
    public function snake()
    {
        $this->assertSame('lorem_p_h_p_ipsum', Str::snake('LoremPHPIpsum'));
        $this->assertSame('lorem_php_ipsum', Str::snake('LoremPhpIpsum'));
        $this->assertSame('lorem php ipsum', Str::snake('LoremPhpIpsum', ' '));
        $this->assertSame('lorem_php_ipsum', Str::snake('Lorem Php Ipsum'));
        $this->assertSame('lorem_php_ipsum', Str::snake('Lorem    Php      Ipsum   '));
        $this->assertSame('lorem__php__ipsum', Str::snake('LoremPhpIpsum', '__'));
        $this->assertSame('lorem_php_ipsum_', Str::snake('LoremPhpIpsum_', '_'));
        $this->assertSame('lorem_php_ipsum', Str::snake('lorem php Ipsum'));
        $this->assertSame('lorem_php_ipsum_dolet', Str::snake('lorem php IpsumDolet'));

        $this->assertSame('foo-bar', Str::snake('foo-bar'));
        $this->assertSame('foo-_bar', Str::snake('Foo-Bar'));
        $this->assertSame('foo__bar', Str::snake('Foo_Bar'));
        $this->assertSame('żółtałódka', Str::snake('ŻółtaŁódka'));
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
