<?php

namespace Ideo\Utilities;

use Ideo\TestCase;

class DataTablesUtilsTest extends TestCase
{

    public function testGetOrder()
    {
        $this->assertEquals(DataTablesUtils::getOrder([]), []);
    }

}
