<?php
/**
 * Author: JimmDiGriz
 */

namespace jimmdigriz\utils\log;

use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;

class EchoLog extends AbstractLogger
{
    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function log($level, $message, array $context = []): void
    {
        echo $message, PHP_EOL;
    }
}