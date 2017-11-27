<?php

namespace Ideo\Utilities;

use Ideo\TestCase;

class StringUtilsTest extends TestCase
{

    public function testContains()
    {
        $this->assertTrue(StringUtils::contains('Hello !! World !!', 'H'));
        $this->assertTrue(StringUtils::contains('Hello !! World !!', ['a', 'o']));
        $this->assertFalse(StringUtils::contains('Hello !! World !!', 'A'));
        $this->assertFalse(StringUtils::contains('Hello !! World !!', ['a', 'b']));
    }

    public function testEndsWith()
    {
        $this->assertTrue(StringUtils::endsWith('Hello !! World !!', '!!'));
        $this->assertFalse(StringUtils::endsWith('Hello !! World !!', 'World'));
    }

    public function testIsBlank()
    {
        $this->assertTrue(StringUtils::isBlank(' '));
        $this->assertFalse(StringUtils::isBlank('A'));
    }

    public function testIsNotBlank()
    {
        $this->assertTrue(StringUtils::isNotBlank('A'));
        $this->assertFalse(StringUtils::isNotBlank(' '));
    }

    public function testLength()
    {
        $this->assertEquals(StringUtils::length('Hello !!'), 8);
        $this->assertEquals(StringUtils::length('A'), 1);
        $this->assertEquals(StringUtils::length('あ'), 1);
        $this->assertEquals(StringUtils::length(''), 0);
    }

}
