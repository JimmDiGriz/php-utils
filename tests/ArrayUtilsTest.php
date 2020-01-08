<?php
/**
 * Author: JimmDiGriz
 */

use jimmdigriz\utils\ArrayUtils;
use PHPUnit\Framework\TestCase;

class ArrayUtilsTest extends TestCase
{
    protected $source = [
        'test' => 'test',
        'test2' => 1,
    ];

    public function testGetOrDefault(): void
    {
        $this->assertEquals('test', ArrayUtils::getOrDefault($this->source, 'test'));
        $this->assertEquals(null, ArrayUtils::getOrDefault($this->source, 'test3'));
        $this->assertEquals('default', ArrayUtils::getOrDefault($this->source, 'test3', 'default'));
    }

    public function testInArray(): void
    {
        $this->assertTrue(ArrayUtils::inArray($this->source, 'test'));
        $this->assertTrue(ArrayUtils::inArray($this->source, 1));
        $this->assertFalse(ArrayUtils::inArray($this->source, '1'));
    }

    public function testHasKey(): void
    {
        $this->assertTrue(ArrayUtils::hasKey($this->source, 'test'));
        $this->assertFalse(ArrayUtils::hasKey($this->source, 'test3'));
    }
}