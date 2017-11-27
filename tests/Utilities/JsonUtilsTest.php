<?php

namespace Ideo\Utilities;

use Ideo\TestCase;

class JsonUtilsTest extends TestCase
{

    public function testEscape()
    {
        $this->assertEquals(JsonUtils::escape('"Hello !!"'), '\\u0022Hello !!\\u0022');
    }

}
