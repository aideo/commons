<?php

namespace Ideo\Utilities;

/**
 * ファイルに関するコンビニエンスメソッドを提供します。
 *
 * @package Ideo\Utilities
 */
class FileUtils
{

    /**
     * GB のバイト数を表します。
     *
     * @var int
     */
    const GB_SIZE = 1024 * 1024 * 1024;

    /**
     * KB のバイト数を表します。
     *
     * @var int
     */
    const KB_SIZE = 1024;

    /**
     * MB のバイト数を表します。
     *
     * @var int
     */
    const MB_SIZE = 1024 * 1024;

    /**
     * ファイル名の拡張子を変更して取得します。
     *
     * @param string $path ファイルのパス。
     * @param string $extension 新しい拡張子。
     *
     * @return string 拡張子を変更したファイル名。
     */
    public static function changeFileExtension($path, $extension)
    {
        $dirName = pathinfo($path, PATHINFO_DIRNAME);
        $fileName = pathinfo($path, PATHINFO_FILENAME);

        return "{$dirName}/{$fileName}.{$extension}";
    }

    /**
     * ファイルサイズをフォーマットします。
     *
     * @param int $value ファイルサイズ。
     * @param string $default デフォルト値。
     *
     * @return string フォーマットされたファイルサイズ。
     */
    public static function formatFileSize($value, $default = '-')
    {
        if ($value !== null) {
            if (self::GB_SIZE < $value) {
                return number_format(round($value / self::GB_SIZE, 2)) . 'GB';
            } else if (self::MB_SIZE < $value) {
                return number_format(round($value / self::MB_SIZE, 2)) . 'MB';
            } else if (self::KB_SIZE < $value) {
                return number_format(round($value / self::KB_SIZE, 2)) . 'KB';
            } else {
                return number_format($value) . 'B';
            }
        } else {
            return $default;
        }
    }

    /**
     * ファイルの拡張子を取得します。
     *
     * @param string $path 対象のパス。
     *
     * @return string ファイルの拡張子。
     */
    public static function getExtension($path)
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        if ($extension) {
            return strtolower($extension);
        } else {
            return '';
        }
    }

}
