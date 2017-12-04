<?php

namespace Ideo\Utilities\jQuery;

use Ideo\TestCase;

class DataTablesUtilsTest extends TestCase
{

    public function testGetOrder()
    {
        $params = [];

        $this->assertEquals(DataTablesUtils::getOrder($params), []);
    }

}
