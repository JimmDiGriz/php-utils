<?php

use jimmdigriz\utils\StringUtils;
use PHPUnit\Framework\TestCase;

class StringUtilsTest extends TestCase
{
    public function testStartsWith(): void
    {
        $this->assertTrue(StringUtils::isStartsWith('a', 'asd'));
        $this->assertTrue(StringUtils::isStartsWith('as', 'asd'));
    }

    public function testEndsWith(): void
    {
        $this->assertTrue(StringUtils::isEndsWith('d', 'asd'));
        $this->assertTrue(StringUtils::isEndsWith('sd', 'asd'));
    }

    public function testStringContains(): void
    {
        $this->assertTrue(StringUtils::stringContains('a', 'weasd'));
        $this->assertTrue(StringUtils::stringContains('as', 'weasd'));
    }

    public function testStringEmpty(): void
    {
        $this->assertTrue(StringUtils::isStringEmpty(''));
        $this->assertTrue(StringUtils::isStringEmpty("\t"));
        $this->assertTrue(StringUtils::isStringEmpty("\n"));
        $this->assertTrue(StringUtils::isStringEmpty("\r"));
        $this->assertTrue(StringUtils::isStringEmpty("\0"));
        $this->assertTrue(StringUtils::isStringEmpty("\x0B"));
    }

    public function testStartsFromOneOfTheList(): void
    {
        $this->assertTrue(StringUtils::isStartsFromOneOfTheList(['a', 'b'], 'asd'));
        $this->assertTrue(StringUtils::isStartsFromOneOfTheList(['a'], 'asd'));
        $this->assertFalse(StringUtils::isStartsFromOneOfTheList(['s'], 'asd'));
    }

    public function testWrapWithBraces(): void
    {
        $this->assertTrue(StringUtils::isWrapWithBraces('{}', '{', '}'));
        $this->assertTrue(StringUtils::isWrapWithBraces('{asd}', '{', '}'));
        $this->assertTrue(StringUtils::isWrapWithBraces('{asd]', '{', ']'));
        $this->assertTrue(StringUtils::isWrapWithBraces('[asd}', '[', '}'));
        $this->assertFalse(StringUtils::isWrapWithBraces('[asd}', '{', '}'));
    }

    public function testValidateBraces(): void
    {
        $this->assertTrue(StringUtils::validateBraces('{}', '{', '}'));
        $this->assertTrue(StringUtils::validateBraces('{{}}', '{', '}'));
        $this->assertTrue(StringUtils::validateBraces('{{{}}}', '{', '}'));
        $this->assertTrue(StringUtils::validateBraces('{{{]]]', '{', ']'));
        $this->assertTrue(StringUtils::validateBraces('{asd{asd{asd}asd}asd}', '{', '}'));
        $this->assertTrue(StringUtils::validateBraces('{asd{asd{asd]asd]asd]', '{', ']'));

        $this->assertFalse(StringUtils::validateBraces('{]', '{', '}'));
        $this->assertFalse(StringUtils::validateBraces('{{]}', '{', '}'));
        $this->assertFalse(StringUtils::validateBraces('{{{]}}', '{', '}'));
        $this->assertFalse(StringUtils::validateBraces('{{{}]]', '{', ']'));
        $this->assertFalse(StringUtils::validateBraces('{asd{asd{asd}asd]asd}', '{', '}'));
        $this->assertFalse(StringUtils::validateBraces('{asd{asd{asd}asd]asd]', '{', ']'));
    }

    /** @noinspection PhpUnitMisorderedAssertEqualsArgumentsInspection */
    public function testRemoveBracesWrap(): void
    {
        $this->assertEquals(StringUtils::removeBracesWrap('{}', '{', '}'), '');
        $this->assertEquals(StringUtils::removeBracesWrap('{a}', '{', '}'), 'a');
        $this->assertEquals(StringUtils::removeBracesWrap('{a{b}}', '{', '}'), 'a{b}');
    }

    /** @noinspection PhpUnitMisorderedAssertEqualsArgumentsInspection */
    public function testSplitByCamelCase(): void
    {
        $this->assertEquals(StringUtils::splitByCamelCase('CamelCase'), ['Camel', 'Case']);
        $this->assertEquals(StringUtils::splitByCamelCase('Camel'), ['Camel']);
    }
}