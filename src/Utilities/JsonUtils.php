<?php

namespace Ideo\Utilities;

/**
 * JSON に関するコンビニエンスメソッドを提供します。
 *
 * @package Ideo\Utilities
 */
class JsonUtils
{

    /**
     * 値をエスケープして出力します。
     *
     * @param string $s 対象の文字列。
     * @param string $encoding エンコーディング。
     *
     * @return string エスケープされた文字列。
     */
    public static function escape($s, $encoding = 'utf-8')
    {
        $s = json_encode((string)$s, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        $s = mb_substr($s, 1, mb_strlen($s, $encoding) - 2, $encoding);

        return $s;
    }

}
