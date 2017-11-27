<?php

namespace Ideo\Utilities;

/**
 * 金額に関するコンビニエンスメソッドを提供します。
 *
 * @package Ideo\Utilities
 */
class MoneyUtils
{

    /**
     * 通貨記号を付与します。
     *
     * @param float|null $value 金額を表す値。
     * @param string $default デフォルト値。
     *
     * @return string フォーマットされた通貨。
     */
    public static function format($value, $default = '')
    {
        if (is_numeric($value)) {
            return '&yen;' . number_format($value);
        } else {
            return $default;
        }
    }

}
