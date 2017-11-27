<?php

namespace Ideo\Utilities;

use Ideo\TestCase;

class MoneyUtilsTest extends TestCase
{

    public function testFormat()
    {
        $this->assertEquals(MoneyUtils::format(1000), '&yen;1,000');
    }

}
