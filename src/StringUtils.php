<?php
/**
 * Author: JimmDiGriz
 */

namespace jimmdigriz\utils;

class StringUtils
{
    public static function isStartsWith(string $soughtFor, string $source): bool
    {
        return 0 === mb_strpos($source, $soughtFor);
    }

    public static function startsWith(string $soughtFor, string $source): bool
    {
        return static::isStartsWith($soughtFor, $source);
    }

    public static function isEndsWith(string $soughtFor, string $source): bool
    {
        $soughtLength = mb_strlen($soughtFor);
        if ($soughtLength === 0) {
            return true;
        }

        return mb_substr($source, -$soughtLength) === $soughtFor;
    }

    public static function endsWith(string $soughtFor, string $source): bool
    {
        return static::isEndsWith($soughtFor, $source);
    }

    public static function stringContains(string $soughtFor, string $source): bool
    {
        return mb_strpos($source, $soughtFor) !== false;
    }

    public static function isStringEmpty(string $input): bool
    {
        return trim(str_replace(["\n", "\t", "\r", "\0", "\x0B"], '', $input)) === '';
    }

    public static function isStartsFromOneOfTheList(array $soughtFor, string $source): bool
    {
        foreach ($soughtFor as $one) {
            if (static::isStartsWith($one, $source)) {
                return true;
            }
        }

        return false;
    }

    public static function isWrapWithBraces(string $input, string $openBrace, string $closeBrace): bool
    {
        return $openBrace === $input[0]
            && $closeBrace === $input[mb_strlen($input) - 1];
    }

    public static function validateBraces(string $input, string $openBrace, string $closeBrace): bool
    {
        $bracesCount = 0;
        $inputLength = mb_strlen($input);

        for ($i = 0; $i < $inputLength; $i++) {
            $character = $input[$i];

            if ($character === $openBrace) {
                $bracesCount++;
                continue;
            }

            if ($character === $closeBrace) {
                $bracesCount--;

                if ($bracesCount < 0) {
                    return false;
                }
            }
        }

        return $bracesCount === 0;
    }

    public static function removeBracesWrap(string $input, string $openBrace, string $closeBrace): string
    {
        $input = static::removeFromRightFirstMatch($input, [$closeBrace]);
        $input = static::removeFromLeftFirstMatch($input, [$openBrace]);

        return $input;
    }

    public static function removeFromRightFirstMatch(string $source, array $possibleRemovables): string
    {
        $source = trim($source);
        $sourceLength = mb_strlen($source);

        foreach ($possibleRemovables as $item) {
            $position = mb_strrpos($source, $item);

            if ($position === false) {
                continue;
            }

            $removableLength = mb_strlen($item);

            if ($position + $removableLength === $sourceLength) {
                return mb_substr($source, 0, $sourceLength - $removableLength);
            }
        }

        return $source;
    }

    public static function removeFromLeftFirstMatch(string $source, array $possibleRemovables): string
    {
        $source = trim($source);

        foreach ($possibleRemovables as $item) {
            $position = mb_strpos($source, $item);

            if ($position === false) {
                continue;
            }

            $removableLength = mb_strlen($item);

            if ($position === 0) {
                return mb_substr($source, $removableLength);
            }
        }

        return $source;
    }

    public static function trim(string $source, array $possibleRemovables = [], bool $runDefault = true): string
    {
        if ($runDefault) {
            $source = trim($source);
        }

        foreach ($possibleRemovables as $item) {
            $source = static::removeFromRightFirstMatch($source, [$item]);
            $source = static::removeFromLeftFirstMatch($source, [$item]);
        }

        return $source;
    }

    public static function splitByCamelCase(string $input): array
    {
        $result = [];
        $current = '';
        $inputLength = mb_strlen($input);

        for ($i = 0; $i < $inputLength; $i++) {
            $character = $input[$i];

            if (mb_strtoupper($character) === $character) {
                if ($current !== '') {
                    $result[] = $current;
                }

                $current = $character;
                continue;
            }

            $current .= $character;
        }

        $result[] = $current;

        return $result;
    }

    /**
     * Split string by delimiter, but ignore this delimiter in nested strings.
     *
     * @param string $input
     * @param string $delimiter
     * @param string $quote
     * @return array
     */
    public static function splitWithStringIgnoring(string $input, string $delimiter, string $quote): array
    {
        $result = [];
        $stringInProgress = false;
        $currentPart = '';

        foreach (preg_split('//u', $input, -1, PREG_SPLIT_NO_EMPTY) as $character) {
            if ($character === $quote) {
                $stringInProgress = !$stringInProgress;
            }

            if ($character === $delimiter) {
                if ($stringInProgress) {
                    $currentPart .= $character;
                    continue;
                }

                $result[] = $currentPart;
                $currentPart = '';
                continue;
            }

            $currentPart .= $character;
        }

        $result[] = $currentPart;
        return $result;
    }

    /**
     * @param string $input
     *
     * @return string|bool
     */
    public static function stringOrBool(string $input)
    {
        if ($input === 'true') {
            return true;
        }

        if ($input === 'false') {
            return false;
        }

        return $input;
    }

    public static function stringOrNull(string $input): ?string
    {
        return $input === 'null' ? null : $input;
    }
}