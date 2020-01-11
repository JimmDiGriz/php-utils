<?php
/**
 * Author: JimmDiGriz
 */

use Carbon\CarbonInterface;
use jimmdigriz\utils\DateUtils;
use PHPUnit\Framework\TestCase;

class DateUtilsTest extends TestCase
{
    public function testParsing()
    {
        $parsed = DateUtils::parse('2020-01-09 21:39:30');

        $this->assertEquals('2020-01-09 21:39:30', DateUtils::defaultFormat($parsed));

        return $parsed;
    }

    /**
     * @depends testParsing
     * @param CarbonInterface $parsed
     */
    public function testMinutesManipulation(CarbonInterface $parsed): void
    {
        $this->assertEquals($parsed, DateUtils::subMinutes(DateUtils::addMinutes($parsed, 5), 5));
    }
}