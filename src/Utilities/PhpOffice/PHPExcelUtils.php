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
     * ワークシートの列・行を指定してセルの値を取得します。
     *
     * @param PHPExcel_Worksheet $sheet ワークシート。
     * @param int|string $columnIndex 列番号。
     * @param int|string $rowIndex 行番号。
     * @param string|null $defaultValue セルが有効ではない場合のデフォルト値。
     *
     * @return null|string セルの値。
     */
    public static function getCellValue(PHPExcel_Worksheet $sheet, $columnIndex = 0, $rowIndex = 1, $defaultValue = null)
    {
        if ($sheet->cellExistsByColumnAndRow($columnIndex, $rowIndex)) {
            $cell = $sheet->getCellByColumnAndRow($columnIndex, $rowIndex);

            return StringUtils::trim($cell->getFormattedValue());
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
     *
     * @return null|string セルの値。
     * @throws PHPExcel_Exception セルの取得時に例外が発生した場合。
     */
    public static function getCellValueByName(PHPExcel_Worksheet $sheet, $name, $defaultValue = null)
    {
        $namedRange = PHPExcel_NamedRange::resolveRange($name, $sheet);

        if ($namedRange !== null && $sheet->cellExists(($range = $namedRange->getRange()))) {
            $cell = $sheet->getCell($range);

            return StringUtils::trim($cell->getFormattedValue());
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
