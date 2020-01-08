<?php
/**
 * Author: JimmDiGriz
 */

use jimmdigriz\utils\BenchUtils;
use PHPUnit\Framework\TestCase;

class BenchTest extends TestCase
{
    public function testTime(): void
    {
        BenchUtils::run('testTime');
        sleep(1);
        $bench = BenchUtils::stop('testTime', false);

        $this->assertTrue($bench->getTime() >= 1);
        $this->assertStringEndsWith(' s.', $bench->getFormattedTime());
    }

    public function testMemory(): void
    {
        BenchUtils::run('testMemory');

        $a = [];

        for ($i = 0; $i < 10000; $i++) {
            $a[] = $i;
        }

        $bench = BenchUtils::stop('testMemory', false);

        $this->assertTrue($bench->getMemory() > 0);
        $this->assertStringEndsWith('Kb', $bench->getFormattedMemory());
    }
}