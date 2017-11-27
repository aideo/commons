<?php

namespace Ideo\Utilities;

use Ideo\TestCase;

class FileUtilsTest extends TestCase
{

    public function testFormatFileSize()
    {
        $this->assertEquals(FileUtils::formatFileSize(8000), '8KB');
        $this->assertEquals(FileUtils::formatFileSize(80000), '78KB');
        $this->assertEquals(FileUtils::formatFileSize(800000), '781KB');
        $this->assertEquals(FileUtils::formatFileSize(8000000), '8MB');
    }

}
