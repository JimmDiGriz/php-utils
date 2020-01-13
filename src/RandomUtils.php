<?php
/**
 * Author: JimmDiGriz
 */

namespace jimmdigriz\utils;

class RandomUtils
{
    public const INT_HIT = 'int';
    public const FLOAT_HIT = 'float';

    /**
     * @param array $source -> array of objects with $keyString and $valueString defined as public properties or via __get.
     * @param string $keyString
     * @param string $valueString
     * @return array
     */
    public static function toDistancePairs(array $source, string $keyString, string $valueString): array
    {
        $result = [];

        foreach ($source as $item) {
            try {
                $result[$item->{$keyString}] = $item->{$valueString};
            } catch (\Exception $e) {
                break;
            }
        }

        return $result;
    }

    /**
     * @param array $items [$key => $value]
     *
     * @return mixed|bool
     */
    public static function getDistanceHit(array $items)
    {
        $type = static::INT_HIT;

        $orderedKeys = [];

        foreach ($items as $key => $value) {
            $orderedKeys[] = $key;
        }

        $onlyValues = [];

        foreach ($items as $key => $value) {
            $onlyValues[] = $value;
        }

        foreach ($items as $value) {
            if (\is_float($value)) {
                $type = static::FLOAT_HIT;
                break;
            }
        }

        $hit = static::getDistanceHitByType($onlyValues, $type);

        if ($hit < 0) {
            return false;
        }

        return $orderedKeys[$hit];
    }

    public static function getDistanceHitByType(array $items, string $type = self::INT_HIT): int
    {
        $itemsLength = \count($items);

        /** @noinspection ForeachInvariantsInspection */
        for ($i = 0; $i < $itemsLength; $i++) {
            $item = $items[$i];

            if (!\is_numeric($item)) {
                return -1;
            }

            if ($type === static::INT_HIT) {
                $items[$i] = (int)$item;
            } else if ($type === static::FLOAT_HIT) {
                $items[$i] = (float)$item;
            } else {
                return -1;
            }
        }

        $distance = \array_reduce($items, function ($carry, $item) {
            return $carry + $item;
        }, 0);

        $hit = static::randomInt(0, $distance);
        $border = 0;

        foreach ($items as $index => $item) {
            $border += $item;

            if ($hit <= $border) {
                return $index;
            }
        }

        return -1;
    }

    public static function chanceDiceFloat(float $targetChance): bool
    {
        if ($targetChance < 0.0) {
            $targetChance = 0.0;
        }

        if ($targetChance > 100.0) {
            $targetChance = 100.0;
        }

        $hit = static::getPercentHitFloat();
        return $hit <= $targetChance;
    }

    public static function chanceDiceInt(int $targetChance): bool
    {
        if ($targetChance < 0) {
            $targetChance = 0;
        }

        if ($targetChance > 100) {
            $targetChance = 100;
        }

        $hit = static::getPercentHitInt();
        return $hit <= $targetChance;
    }

    public static function getPercentHitFloat(): float
    {
        $hit = static::randomInt(0, 10000);
        return (float)($hit / 100);
    }

    public static function getPercentHitInt(): int
    {
        return static::randomInt(0, 100);
    }

    public static function randomInt(int $min, int $max): int
    {
        return \random_int($min, $max);
    }
}