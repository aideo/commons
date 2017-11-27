<?php

namespace Ideo\Utilities;

/**
 * 真偽値に関するコンビニエンスメソッドを提供します。
 *
 * @package Ideo\Utilities
 */
class BooleanUtils
{

    /**
     * 値を javascript の真偽値文字列で取得します。
     *
     * @param * $value 対象の文字列。
     *
     * @return string javascript の真偽値を表す文字列。
     */
    public static function toJavaScriptString($value)
    {
        if ($value) {
            return 'true';
        } else {
            return 'false';
        }
    }

}
