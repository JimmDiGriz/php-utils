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

    public static function getAbsoluteMinutesDiff(CarbonInterface $left, CarbonInterface $right): int
    {
        return abs($left->minute - $right->minute);
    }

    public static function addMinutes(CarbonInterface $left, int $minutes, string $timezone = null): CarbonInterface
    {
        $clone = $left->clone();

        return $clone->addMinutes($minutes)->setTimezone($timezone ?? static::DEFAULT_TIMEZONE);
    }

    public static function subMinutes(CarbonInterface $left, int $minutes, string $timezone = null): CarbonInterface
    {
        $clone = $left->clone();

        return $clone->subMinutes($minutes)->setTimezone($timezone ?? static::DEFAULT_TIMEZONE);
    }

    public static function getSecondsDiff(CarbonInterface $left, CarbonInterface $right): int
    {
        return $left->diffInSeconds($right);
    }

    public static function addSeconds(CarbonInterface $left, int $seconds, string $timezone = null): CarbonInterface
    {
        $clone = $left->clone();

        return $clone->addSeconds($seconds)->setTimezone($timezone ?? static::DEFAULT_TIMEZONE);
    }

    public static function subSeconds(CarbonInterface $left, int $seconds, string $timezone = null): CarbonInterface
    {
        $clone = $left->clone();

        return $clone->subSeconds($seconds)->setTimezone($timezone ?? static::DEFAULT_TIMEZONE);
    }

    public static function now(string $timezone = null): CarbonInterface
    {
        return Carbon::now()->setTimezone($timezone ?? static::DEFAULT_TIMEZONE);
    }

    public static function nowFormatted(): string
    {
        return static::now()->format(static::DEFAULT_DATE_TIME_FORMAT);
    }

    public static function getDiffInMinutesAndSeconds(CarbonInterface $left, CarbonInterface $right): array
    {
        $secondsSub = static::getSecondsDiff($left, $right);

        $minutes = floor($secondsSub / 60);
        $seconds = $secondsSub % 60;

        return [
            'minutes' => $minutes,
            'seconds' => $seconds,
        ];
    }
}