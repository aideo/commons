<?php

namespace Ideo\Utilities;

/**
 * 文字列に関するコンビニエンスメソッドを提供します。
 *
 * @package Ideo\Utilities
 */
class StringUtils
{

    /**
     * 使用するエンコーディングを表します。
     *
     * @var string
     */
    const DEFAULT_ENCODING = 'utf-8';

    /**
     * 文字列に対象の文字列が含まれているか取得します。
     *
     * @param string $s 対象の文字列。
     * @param string|array $needles 確認する文字列、もしくはその配列。
     *
     * @return bool $needles の文字列を含む場合 true, それ以外は false 。
     */
    public static function contains($s, $needles)
    {
        foreach ((array)$needles as $needle) {
            if ($needle != '' && strpos($s, $needle) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * 文字列の最後が対象の文字列かどうかを取得します。
     *
     * @param string $s 対象の文字列。
     * @param string|array $needles 確認する文字列、もしくはその配列。
     *
     * @return bool $needles の文字列を最後に含む場合 true, それ以外は false 。
     */
    public static function endsWith($s, $needles)
    {
        foreach ((array)$needles as $needle) {
            if ((string)$needle === substr($s, -strlen($needle))) {
                return true;
            }
        }

        return false;
    }

    /**
     * 指定した文字が空文字列であるかどうかを確認します。
     *
     * null, '', のほか、空白のみを含む場合も対象となります。
     *
     * @param string $s 対象の文字列。
     * @param string $encoding エンコーディング名。
     *
     * @return bool 空文字列である場合 true, それ以外は false 。
     */
    public static function isBlank($s, $encoding = self::DEFAULT_ENCODING)
    {
        return self::length(self::trim($s, $encoding), $encoding) === 0;
    }

    /**
     * 指定した文字が空文字列であるかどうかを確認します。
     *
     * null, '', のほか、空白のみを含む場合も対象となります。
     *
     * @param string $s 対象の文字列。
     * @param string $encoding エンコーディング名。
     *
     * @return bool 空文字列である場合 false, それ以外は true 。
     */
    public static function isNotBlank($s, $encoding = self::DEFAULT_ENCODING)
    {
        return !self::isBlank($s, $encoding);
    }

    /**
     * 文字列の長さを取得します。
     *
     * @param string $s 対象の文字列。
     * @param string $encoding エンコーディング名。
     *
     * @return int 文字列の長さ。
     */
    public static function length($s, $encoding = self::DEFAULT_ENCODING)
    {
        return mb_strlen($s, $encoding);
    }

    /**
     * テキストにフィルターをかけます。
     *
     * ・全角英数字を半角にします。
     * ・全角スペースを半角スペースにします。
     * ・半角カタカナを全角カタカナにします。
     * ・半角の濁点記号付きの文字を１文字に統合します。
     * ・前後の余白を除きます。
     *
     * @param $text
     * @param string $encoding エンコーディング名。
     *
     * @return string
     */
    public static function normalizeJapanese($text, $encoding = self::DEFAULT_ENCODING)
    {
        $text = mb_convert_kana($text, 'asKV', $encoding);
        $text = self::trim($text);

        return $text;
    }

    /**
     * 正規表現パターンに該当する文字を置換します。
     *
     * @param string $s 対象の文字列。
     * @param string $pattern 正規表現パターン。
     * @param string $replacement 置換する文字列。
     * @param string $encoding エンコーディング名。
     *
     * @return string 置換した文字列。
     */
    public static function regexReplace($s, $pattern, $replacement, $encoding = self::DEFAULT_ENCODING)
    {
        $oldEncoding = mb_regex_encoding();
        mb_regex_encoding($encoding);

        $r = mb_ereg_replace($pattern, $replacement, $s);
        mb_regex_encoding($oldEncoding);

        return $r;
    }

    /**
     * 対象の文字列から比較対象の文字列を置換します。
     *
     * @param string $s 対象の文字列。
     * @param string $search 置換する文字列。
     * @param string $replacement 置き換える文字列。
     * @param string $encoding エンコーディング名。
     *
     * @return string 置換した文字列。
     */
    public static function replace($s, $search, $replacement, $encoding = self::DEFAULT_ENCODING)
    {
        return self::regexReplace($s, preg_quote($search), $replacement, $encoding);
    }

    /**
     * 文字列を指定した文字列で区切った配列を取得します。
     *
     * @param string $s 対象の文字列。
     * @param string $separator 区切り文字列。
     *
     * @return array $separator で区切った配列。
     */
    public static function split($s, $separator)
    {
        return explode($separator, $s);
    }

    /**
     * 文字列を指定した文字列で区切った配列を取得します。
     *
     * @param string $s 対象の文字列。
     * @param string|array $separators 区切り文字列もしくはその配列。
     * @param string $encoding エンコーディング名。
     *
     * @return array $separators で区切った配列。
     */
    public static function splitAny($s, $separators, $encoding = self::DEFAULT_ENCODING)
    {
        $pattern = implode('|', array_map('preg_quote', (array)$separators));

        $oldEncoding = mb_regex_encoding();
        mb_regex_encoding($encoding);

        $matches = mb_split($pattern, $s);
        mb_regex_encoding($oldEncoding);

        return $matches;
    }

    /**
     * 対象の文字列が指定した文字列で開始されているか取得します。
     *
     * @param string $s 対象の文字列。
     * @param string|array $needles 比較する文字列、またはその配列。
     *
     * @return bool 対象の文字列が $needles で開始されている場合 true, それ以外は false 。
     */
    public static function startsWith($s, $needles)
    {
        foreach ((array)$needles as $needle) {
            if ($needle != '' && strpos($s, $needle) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * 対象の文字列の一部を取得します。
     *
     * @param string $s 対象の文字列。
     * @param int $start 取得する開始位置。
     * @param int|null $length 取得する文字数。
     * @param string $encoding エンコーディング名。
     *
     * @return string 取得された文字列。
     */
    public static function substr($s, $start, $length = null, $encoding = self::DEFAULT_ENCODING)
    {
        $length = $length === null ? self::length($s, $encoding) : $length;

        return mb_substr($s, $start, $length, $encoding);
    }

    /**
     * 対象の文字列の前後から空白を除きます。
     *
     * @param string $s 対象の文字列。
     * @param string $encoding エンコーディング名。
     *
     * @return string 前後の空白を除いた文字列。
     */
    public static function trim($s, $encoding = self::DEFAULT_ENCODING)
    {
        return self::regexReplace($s, "^[[:space:]]+|[[:space:]]+\$", '', $encoding);
    }

}
