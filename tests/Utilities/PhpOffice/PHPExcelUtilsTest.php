<?php

namespace Ideo\Utilities\PhpOffice;

use Ideo\TestCase;
use PHPExcel_Exception;
use PHPExcel_IOFactory;
use PHPExcel_Reader_Exception;

class PHPExcelUtilsTest extends TestCase
{

    /**
     * @throws PHPExcel_Reader_Exception
     * @throws PHPExcel_Exception
     */
    public function testGetCellValue()
    {
        $reader = PHPExcel_IOFactory::createReaderForFile(__DIR__ . '/test.xlsx');

        $wb = $reader->load(__DIR__ . '/test.xlsx');
        $sh = $wb->getSheet(0);

        $this->assertEquals(PHPExcelUtils::getCellValue($sh, 1, 2), "A");
        $this->assertEquals(PHPExcelUtils::getCellValue($sh, 1, 3), "B");
        $this->assertEquals(PHPExcelUtils::getCellValue($sh, 1, 4), "C");
        $this->assertEquals(PHPExcelUtils::getCellValue($sh, 3, 2), "Hello !! World !!");
        $this->assertEquals(PHPExcelUtils::getCellValue($sh, 3, 4), "1/1/17 0:01");
        $this->assertEquals(PHPExcelUtils::getCellValue($sh, 3, 5), 10000);

        $this->assertEquals(PHPExcelUtils::getCellValue($sh, 3, 3), date('m/j/y G:i'));
    }

    /**
     * @throws PHPExcel_Exception
     * @throws PHPExcel_Reader_Exception
     */
    public function testGetCellValueByName()
    {
        $reader = PHPExcel_IOFactory::createReaderForFile(__DIR__ . '/test.xlsx');

        $wb = $reader->load(__DIR__ . '/test.xlsx');
        $sh = $wb->getSheet(0);

        $this->assertEquals(PHPExcelUtils::getCellValueByName($sh, 'Named_Cell'), "Named Cell");
    }

    /**
     * @throws PHPExcel_Exception
     * @throws PHPExcel_Reader_Exception
     */
    public function testGetHighestRowAndColumnIndex()
    {
        $reader = PHPExcel_IOFactory::createReaderForFile(__DIR__ . '/test.xlsx');

        $wb = $reader->load(__DIR__ . '/test.xlsx');
        $sh = $wb->getSheet(0);

        $this->assertEquals(PHPExcelUtils::getHighestRowAndColumnIndex($sh), [3, 12]);
        $this->assertEquals(PHPExcelUtils::getCellValue($sh, 3, 12), 'Last');
    }

    /**
     * @throws PHPExcel_Exception
     * @throws PHPExcel_Reader_Exception
     */
    public function testInMergeRange()
    {
        $reader = PHPExcel_IOFactory::createReaderForFile(__DIR__ . '/test.xlsx');

        $wb = $reader->load(__DIR__ . '/test.xlsx');
        $sh = $wb->getSheet(0);

        $this->assertTrue(PHPExcelUtils::inMergeRange($sh, 1, 8));
        $this->assertTrue(PHPExcelUtils::inMergeRange($sh, 2, 9));
        $this->assertFalse(PHPExcelUtils::inMergeRange($sh, 0, 8));
        $this->assertFalse(PHPExcelUtils::inMergeRange($sh, 0, 9));
    }

}
