<?php

namespace Ideo\Utilities\jQuery;

/**
 * DataTables のリクエストを扱う際に便利なコンビニエンスメソッドを提供します。
 *
 * @package Ideo\Utilities
 */
class DataTablesUtils
{

    /**
     * DataTables のリクエストから並び順の情報を取得します。
     *
     * @param array $params リクエストパラメーター。
     *
     * @return array 並び順を表す連想配列の配列。
     *      [column]: カラム名。
     *      [dir]: 並び順。
     */
    public static function getOrder(array $params)
    {
        $columns = isset($params['columns']) ? $params['columns'] : [];
        $order = isset($params['order']) ? $params['order'] : [];

        $orderByArray = [];

        // $columns と $order が有効な値を保持しているか確認します。
        if (!empty($columns) && !empty($order)) {
            // 項目の並び順を設定します。
            foreach ($order as $o) {
                // 無効なパラメーターかどうかを確認します。
                if (!isset($o['column']) || !isset($o['dir'])) {
                    continue;
                }

                $column = $o['column'];
                $dir = $o['dir'];

                // 並び順を補正します。
                if ($dir != 'asc' && $dir != 'desc') {
                    $dir = 'asc';
                }

                if (is_numeric($column)) {
                    // 有効なカラム名かどうかを確認します。
                    if (!isset($columns[$column])) {
                        continue;
                    }

                    // data 項目を保持しているか確認します。
                    if (!isset($columns[$column]['data'])) {
                        continue;
                    }

                    $column = $columns[$column]['data'];
                }

                $orderByArray[] = [
                    'column' => $column,
                    'dir' => $dir
                ];
            }
        }

        return $orderByArray;
    }

}
