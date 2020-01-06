<?php
/**
 * Author: JimmDiGriz
 */

namespace jimmdigriz\utils\bench;

class Launch
{
    public const LAUNCH_NOT_FINISHED = 'Benchmark launch is not finished yet.';
    public const MEMORY_UNITS = [
        'b', 'Kb', 'Mb', 'Gb', 'Tb',
    ];

    /** @var string $name */
    protected $name;

    /** @var float $startTime */
    protected $startTime;
    /** @var float $endTime */
    protected $endTime;
    /** @var float $elapsedTime */
    protected $elapsedTime;
    /** @var string $formattedTime */
    protected $formattedTime;

    /** @var int $startMemory */
    protected $startMemory;
    /** @var int $endMemory */
    protected $endMemory;
    /** @var int $elapsedMemory */
    protected $elapsedMemory;
    /** @var string $formattedMemory */
    protected $formattedMemory;

    /** @var bool $isFinished */
    protected $isFinished = false;
    /** @var string $stringRepresentation */
    private $stringRepresentation;

    protected function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function create(string $name): self
    {
        return new static($name);
    }

    public static function createAndRun(string $name): self
    {
        return static::create($name)->run();
    }

    public function run(): self
    {
        if ($this->isFinished) {
            return $this;
        }

        $this->startTime = microtime(true);
        $this->startMemory = memory_get_usage();

        return $this;
    }

    public function stop(): self
    {
        if ($this->isFinished) {
            return $this;
        }

        $this->endTime = microtime(true);
        $this->endMemory = memory_get_usage();

        $this->elapsedTime = $this->endTime - $this->startTime;
        $this->elapsedMemory = $this->endMemory - $this->startMemory;

        $this->isFinished = true;
        return $this;
    }

    public function getTime(): float
    {
        if (!$this->isFinished) {
            return 0;
        }

        return $this->elapsedTime;
    }

    public function getFormattedTime(): string
    {
        if (null === $this->formattedTime) {
            $time = $this->elapsedTime >= 1 ? $this->elapsedTime : $this->elapsedTime * 1000;
            $unit = $this->elapsedTime >= 1 ? 's' : 'ms';

            $timeDiff = number_format($time, 2, '.', '');

            $this->formattedTime = "{$timeDiff} {$unit}.";
        }

        return $this->formattedTime;
    }

    public function getMemory(): int
    {
        if (!$this->isFinished) {
            return memory_get_usage() - $this->startMemory;
        }

        return $this->elapsedMemory;
    }

    public function getFormattedMemory(): string
    {
        if (null === $this->formattedMemory) {
            $memory = $this->elapsedMemory;

            $index = 0;

            while ($memory > 1024) {
                $memory /= 1024;
                ++$index;
            }

            $this->formattedMemory = sprintf('%.2f%s', round($memory, 2), static::MEMORY_UNITS[$index]);
        }

        return $this->formattedMemory;
    }

    public function __toString(): string
    {
        if (!$this->isFinished) {
            return static::LAUNCH_NOT_FINISHED;
        }

        if (null === $this->stringRepresentation) {
            $this->stringRepresentation =
                "BenchLaunchName: {$this->name}, Time: {$this->getFormattedTime()}, Memory: {$this->getFormattedMemory()}";
        }

        return $this->stringRepresentation;
    }
}