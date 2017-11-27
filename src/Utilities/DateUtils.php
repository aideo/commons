<?php

namespace Ideo\Utilities;

use Carbon\Carbon;
use DateTime;

/**
 * 日時に関するコンビニエンスメソッドを提供します。
 *
 * @package Ideo\Utilities
 */
class DateUtils
{

    /**
     * 日付をフォーマットします。
     *
     * @param mixed $value 日付を表す値。
     * @param null $default デフォルト値。
     * @param string $format 書式文字列。
     *
     * @return null|string フォーマットされた文字列。
     */
    public static function format($value, $default = null, $format = 'Y-m-d H:i:s')
    {
        if ($value === null) {
            return $default;
        } elseif ($value instanceof Carbon) {
            return $value->format($format);
        } elseif ($value instanceof DateTime) {
            return Carbon::instance($value)->format($format);
        } else {
            return Carbon::parse($value)->format($format);
        }
    }

    /**
     * 日付をフォーマットします。
     *
     * @param mixed $value 日付を表す値。
     * @param null $default デフォルト値。
     *
     * @return null|string フォーマットされた文字列。
     */
    public static function toDateString($value, $default = null)
    {
        if ($value === null) {
            return $default;
        } elseif ($value instanceof Carbon) {
            return $value->toDateString();
        } elseif ($value instanceof DateTime) {
            return Carbon::instance($value)->toDateString();
        } else {
            return Carbon::parse($value)->toDateString();
        }
    }

    /**
     * 日付をフォーマットします。
     *
     * @param mixed $value 日付を表す値。
     * @param null $default デフォルト値。
     *
     * @return null|string フォーマットされた文字列。
     */
    public static function toDateTimeString($value, $default = null)
    {
        if ($value === null) {
            return $default;
        } elseif ($value instanceof Carbon) {
            return $value->toDateTimeString();
        } elseif ($value instanceof DateTime) {
            return Carbon::instance($value)->toDateTimeString();
        } else {
            return Carbon::parse($value)->toDateTimeString();
        }
    }

}
