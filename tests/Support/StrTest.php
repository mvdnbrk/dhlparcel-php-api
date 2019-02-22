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
        $this->assertEquals('MvdnbrkTestStringPhp', Str::studly('mvdnbrk_test_string_php'));
        $this->assertEquals('MvdnbrkStringPhp', Str::studly('mvdnbrk_string_php'));
        $this->assertEquals('MvdnbrkTestStringPhp', Str::studly('mvdnbrk-testString-php'));
        $this->assertEquals('MvdnbrkStringPhp', Str::studly('mvdnbrk  -_-  string   -_-   php   '));
    }

    /** @test */
    public function upper()
    {
        $this->assertEquals('FOO BAR', Str::upper('foo bar'));
        $this->assertEquals('FOO BAR', Str::upper('foO bAr'));
    }
}
