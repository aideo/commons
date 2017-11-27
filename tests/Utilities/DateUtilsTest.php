<?php

namespace Ideo\Utilities;

use Ideo\TestCase;

class DateUtilsTest extends TestCase
{

    public function testFormat()
    {
        $this->assertEquals(DateUtils::format('2017/01/01 12:13'), '2017-01-01 12:13:00');
    }

}
