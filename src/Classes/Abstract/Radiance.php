<?php

namespace RiftLab\Radiance\Classes\Abstract;

use RiftLab\Radiance\Contracts\RadianceInterface;
use RiftLab\Radiance\Services\Calculate;

abstract class Radiance implements RadianceInterface
{
    protected bool $negative;

    protected float $degrees;

    protected float $minutes;

    protected float $seconds;

    protected array $array;

    protected array $formattedStrings = [];

    abstract protected static function getStringFormat(): string;

    abstract protected static function getNegativeDirection(): string;

    abstract protected static function getPositiveDirection(): string;

    protected function stringFormatPlaceholders(): array
    {
        return [];
    }

    protected function getStringFormatPlaceholders(): array
    {
        return [
            '/\{d\.(-?\d+)\}/' => fn ($match) => $this->formatValue($this->getDegrees($match[1]), $match[1], false),
            '/\{m\.(-?\d+)\}/' => fn ($match) => $this->formatValue($this->getMinutes($match[1]), $match[1], false),
            '/\{s\.(-?\d+)\}/' => fn ($match) => $this->formatValue($this->getSeconds($match[1]), $match[1], false),

            '/\{dd\.(-?\d+)\}/' => fn ($match) => $this->formatValue($this->getDegrees($match[1]), $match[1], true),
            '/\{mm\.(-?\d+)\}/' => fn ($match) => $this->formatValue($this->getMinutes($match[1]), $match[1], true),
            '/\{ss\.(-?\d+)\}/' => fn ($match) => $this->formatValue($this->getSeconds($match[1]), $match[1], true),

            ...$this->stringFormatPlaceholders(),
        ];
    }

    public function __construct(protected float $angle)
    {
        $this->negative = $this->angle < 0;
        $array = Calculate::arrayFrom($this->angle);
        [$this->degrees, $this->minutes, $this->seconds] = $array;
        $this->array = [
            'direction' => $this->getDirection(),
            ...array_combine(['degrees', 'minutes', 'seconds'], $array),
        ];
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function isNegative(): bool
    {
        return $this->negative;
    }

    public function getDirection(): string
    {
        return $this->isNegative() ? static::getNegativeDirection() : static::getPositiveDirection();
    }

    public function getDegrees(int $decimalPoints = -1): float
    {
        return $decimalPoints < 0 ? floor($this->degrees) : round($this->degrees, $decimalPoints);
    }

    public function getMinutes(int $decimalPoints = -1): float
    {
        return $decimalPoints < 0 ? floor($this->minutes) : round($this->minutes, $decimalPoints);
    }

    public function getSeconds(int $decimalPoints = 0): float
    {
        return $decimalPoints < 0 ? floor($this->seconds) : round($this->seconds, $decimalPoints);
    }

    public function toDecimal(): float
    {
        return $this->angle;
    }

    public function toString(string $stringFormat = null): string
    {
        $stringFormat = $stringFormat ?? static::getStringFormat();

        if (isset($this->formattedStrings[$stringFormat])) {
            return $this->formattedStrings[$stringFormat];
        }

        return $this->formattedStrings[$stringFormat] = preg_replace_callback_array(static::getStringFormatPlaceholders(), $stringFormat);
    }

    public function toArray(): array
    {
        return $this->array;
    }

    protected function formatValue(float $value, int $decimalPoints, bool $leadingZero): string
    {
        $value = number_format($value, $decimalPoints);

        return $leadingZero && $value < 10 ? "0$value" : $value;
    }
}
