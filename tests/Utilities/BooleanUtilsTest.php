<?php

namespace Ideo\Utilities;

use Ideo\TestCase;

class BooleanUtilsTest extends TestCase
{

    public function testToJavaScriptString()
    {
        $this->assertEquals(BooleanUtils::toJavaScriptString(true), 'true');
        $this->assertEquals(BooleanUtils::toJavaScriptString(false), 'false');
    }

}
