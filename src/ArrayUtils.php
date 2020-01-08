<?php
/**
 * Author: JimmDiGriz
 */

namespace jimmdigriz\utils;

class ArrayUtils
{
    /**
     * @param array $source
     * @param $key
     * @param null $default
     *
     * @return mixed|null
     */
    public static function getOrDefault(array $source, $key, $default = null)
    {
        if (array_key_exists($key, $source)) {
            return $source[$key];
        }

        return $default;
    }

    /**
     * @param array $source
     * @param mixed $toSearch
     * @return bool
     */
    public static function inArray(array $source, $toSearch): bool
    {
        return \in_array($toSearch, $source, true);
    }

    /**
     * @param array $source
     * @param mixed $toSearch
     * @return bool
     */
    public static function hasKey(array $source, $toSearch): bool
    {
        return \array_key_exists($toSearch, $source);
    }
}