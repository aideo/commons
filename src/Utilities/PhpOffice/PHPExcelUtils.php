<?php

namespace Ideo\Utilities\PhpOffice;

use Ideo\Utilities\StringUtils;
use PHPExcel;
use PHPExcel_Cell;
use PHPExcel_Exception;
use PHPExcel_NamedRange;
use PHPExcel_Worksheet;

/**
 * PHPExcel 使用時にあると便利な処理を提供します。
 *
 * @package Ideo\Utilities\PHPOffice
 */
class PHPExcelUtils
{

    /**
     * 返却値を trim する事を表します。
     */
    const OPT_TRIM = 1;

    /**
     * Escaped String を戻す事を表します。
     */
    const OPT_UNESCAPED = 2;

    private static $escapedStringFrom = [];

    private static $escapedStringTo = [];

    private static $initializedEscapedString = false;

    private static function filterOpt($value, $options)
    {
        if (in_array(self::OPT_UNESCAPED, $options, true)) {
            $value = self::unescapedString($value);
        }

        if (in_array(self::OPT_TRIM, $options, true)) {
            $value = StringUtils::trim($value);
        }

        return $value;
    }

    /**
     * ワークシートの列・行を指定してセルの値を取得します。
     *
     * @param PHPExcel_Worksheet $sheet ワークシート。
     * @param int|string $columnIndex 列番号。
     * @param int|string $rowIndex 行番号。
     * @param string|null $defaultValue セルが有効ではない場合のデフォルト値。
     * @param array $options オプション。
     *
     * @return null|string セルの値。
     */
    public static function getCellValue(PHPExcel_Worksheet $sheet, $columnIndex = 0, $rowIndex = 1, $defaultValue = null, $options = [self::OPT_TRIM, self::OPT_UNESCAPED])
    {
        if ($sheet->cellExistsByColumnAndRow($columnIndex, $rowIndex)) {
            $cell = $sheet->getCellByColumnAndRow($columnIndex, $rowIndex);

            return self::filterOpt($cell->getFormattedValue(), $options);
        } else {
            return $defaultValue;
        }
    }

    /**
     * ワークシートから、名前付きセル名を指定して値を取得します。
     *
     * @param PHPExcel_Worksheet $sheet ワークシート。
     * @param string $name 名前付きセルの名前。
     * @param string|null $defaultValue 名前付きセルが有効ではない場合のデフォルト値。
     * @param array $options オプション。
     *
     * @return null|string セルの値。
     * @throws PHPExcel_Exception セルの取得時に例外が発生した場合。
     */
    public static function getCellValueByName(PHPExcel_Worksheet $sheet, $name, $defaultValue = null, $options = [self::OPT_TRIM, self::OPT_UNESCAPED])
    {
        $namedRange = PHPExcel_NamedRange::resolveRange($name, $sheet);

        if ($namedRange !== null && $sheet->cellExists(($range = $namedRange->getRange()))) {
            $cell = $sheet->getCell($range);

            return self::filterOpt($cell->getFormattedValue(), $options);
        } else {
            return $defaultValue;
        }
    }

    /**
     * ワークシートの最大列と最大行をインデックスで取得します。
     *
     * @param PHPExcel_Worksheet $sheet 対象のワークシート。
     *
     * @return array 0 要素目に最大列のインデックス、1 要素目に最大行のインデックスが格納された配列。
     * @throws PHPExcel_Exception 列インデックスを取得する際に例外が発生した場合。
     */
    public static function getHighestRowAndColumnIndex(PHPExcel_Worksheet $sheet)
    {
        $highestRowAndColumn = $sheet->getHighestRowAndColumn();

        $columnIndex = PHPExcel_Cell::columnIndexFromString($highestRowAndColumn['column']) - 1;
        $rowIndex = $highestRowAndColumn['row'];

        return [$columnIndex, $rowIndex];
    }

    /**
     * 指定したセルがマージセルかどうかを取得します。
     *
     * @param PHPExcel_Worksheet $sheet ワークシート。
     * @param int|string $columnIndex 列インデックス。
     * @param int|string $rowIndex 行インデックス。
     *
     * @return bool マージセルの場合 true, それ以外は false 。
     */
    public static function inMergeRange(PHPExcel_Worksheet $sheet, $columnIndex, $rowIndex)
    {
        $cell = $sheet->getCellByColumnAndRow($columnIndex, $rowIndex);

        return $cell->isInMergeRange();
    }

    /**
     * Escaped String の変換マップを初期化します。
     *
     * https://msdn.microsoft.com/en-us/library/ff534667(v=office.12).aspx
     */
    private static function initializeEscapedString()
    {
        if (self::$initializedEscapedString === false) {
            for ($i = 0; $i <= 31; ++$i) {
                if ($i != 9 && $i != 10 && $i != 13) {
                    $key = sprintf('_x%04s_', strtoupper(dechex($i)));
                    $value = chr($i);

                    self::$escapedStringFrom[] = $key;
                    self::$escapedStringTo[] = $value;
                }
            }
        }
    }

    /**
     * 対象シートの名前付きセルの定義をクリアします。
     *
     * @param PHPExcel $workbook 対象のワークブック。
     * @param PHPExcel_Worksheet $sheet 対象のシート。
     */
    public static function removeNamedRangesBySheet(PHPExcel $workbook, PHPExcel_Worksheet $sheet)
    {
        $namedRanges = $workbook->getNamedRanges();

        foreach ($namedRanges as $key => $namedRange) {
            if ($namedRange->getWorksheet() !== $sheet) {
                continue;
            }

            $workbook->removeNamedRange($namedRange->getName(), $sheet);
        }
    }

    /**
     * ワークシートの列・行を指定してセルの値を設定します。
     *
     * @param PHPExcel_Worksheet $sheet ワークシート。
     * @param int|string $columnIndex 列番号。
     * @param int|string $rowIndex 行番号。
     * @param int|string $value 設定するセルの値。
     *
     * @throws PHPExcel_Exception 指定されたセルが有効ではない場合。
     */
    public static function setCellValue(PHPExcel_Worksheet $sheet, $columnIndex = 0, $rowIndex = 1, $value)
    {
        if (!$sheet->cellExistsByColumnAndRow($columnIndex, $rowIndex)) {
            throw new PHPExcel_Exception('The specified cell is not found.');
        }

        $cell = $sheet->getCellByColumnAndRow($columnIndex, $rowIndex);
        $cell->setValue($value);
    }

    /**
     * Escaped String を戻します。
     *
     * @param string $s 対象の文字列。
     * @return string 返還後の文字列。
     */
    public static function unescapedString($s)
    {
        self::initializeEscapedString();

        return str_replace(self::$escapedStringTo, self::$escapedStringFrom, $s);
    }

    /**
     * 対象のセルがマージセルに含まれる場合、そのマージセル全体をキャンセルします。
     *
     * @param PHPExcel_Worksheet $sheet ワークシート。
     * @param int|string $columnIndex 列インデックス。
     * @param int|string $rowIndex 行インデックス。
     *
     * @throws PHPExcel_Exception マージセルのキャンセルに失敗した場合。
     */
    public static function unmergeContainedCells(PHPExcel_Worksheet $sheet, $columnIndex, $rowIndex)
    {
        $cell = $sheet->getCellByColumnAndRow($columnIndex, $rowIndex);

        if ($cell->isInMergeRange()) {
            $sheet->unmergeCells($cell->getMergeRange());
        }
    }

}
