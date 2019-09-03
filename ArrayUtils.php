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
}