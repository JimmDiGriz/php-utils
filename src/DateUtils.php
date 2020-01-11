<?php
/**
 * Author: JimmDiGriz
 */

namespace jimmdigriz\utils;

use Carbon\Carbon;
use Carbon\CarbonInterface;

class DateUtils
{
    public const DEFAULT_DATE_TIME_FORMAT = 'Y-m-d H:i:s';
    public const DEFAULT_TIMEZONE = 'Europe/Moscow';

    public static function defaultFormat(CarbonInterface $target, string $timezone = null): string
    {
        return $target
            ->setTimezone($timezone)
            ->format(static::DEFAULT_DATE_TIME_FORMAT);
    }

    public static function parse($input, string $timezone = null): CarbonInterface
    {
        if (null === $timezone) {
            return Carbon::parse(new \DateTime($input));
        }

        return Carbon::parse(new \DateTime($input))->setTimezone($timezone);
    }

    public static function getMinutesDiff(CarbonInterface $left, CarbonInterface $right): int
    {
        return $left->diffInMinutes($right);
    }

    public static function addMinutes(CarbonInterface $left, int $minutes): CarbonInterface
    {
        return $left->addMinutes($minutes);
    }

    public static function subMinutes(CarbonInterface $left, int $minutes): CarbonInterface
    {
        return static::addMinutes($left, -$minutes);
    }

    public static function now(string $timezone = null): CarbonInterface
    {
        return Carbon::now()->setTimezone($timezone ?? static::DEFAULT_TIMEZONE);
    }

    public static function nowFormatted(): string
    {
        return static::now()->format(static::DEFAULT_DATE_TIME_FORMAT);
    }
}