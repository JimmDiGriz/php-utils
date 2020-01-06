<?php
/**
 * Author: JimmDiGriz
 */

namespace jimmdigriz\utils;

use jimmdigriz\utils\log\EchoLog;
use jimmdigriz\utils\bench\Launch;
use Psr\Log\LoggerInterface;

class BenchUtils
{
    /** @var Launch[] $launches */
    protected static $launches = [];
    /** @var LoggerInterface $logger */
    protected static $logger;

    public static function run(string $name): Launch
    {
        if (!\array_key_exists($name, static::$launches)) {
            static::$launches[$name] = Launch::createAndRun($name);
        }

        return static::$launches[$name];
    }

    public static function stop(string $name, bool $showInfo = true): ?Launch
    {
        if (!\array_key_exists($name, static::$launches)) {
            return null;
        }

        static::$launches[$name]->stop();

        if ($showInfo) {
            static::getLogger()->info(static::$launches[$name]);
        }

        return static::$launches[$name];
    }

    public static function setLogger(LoggerInterface $logger): void
    {
        static::$logger = $logger;
    }

    protected static function getLogger(): LoggerInterface
    {
        if (null === static::$logger) {
            static::setLogger(new EchoLog());
        }

        return static::$logger;
    }
}