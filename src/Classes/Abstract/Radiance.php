<?php

namespace RiftLab\Radiance\Classes\Abstract;

use RiftLab\Radiance\Contracts\RadianceInterface;
use RiftLab\Radiance\Services\Convert;
use RiftLab\Radiance\Services\Precision;
use RiftLab\Radiance\Services\Value;

abstract class Radiance implements RadianceInterface
{
    private bool $negative;

    private string $degrees;

    private string $minutes;

    private string $seconds;

    private array $array;

    protected function __construct(private string $angle)
    {
        $this->negative = Value::isNegative($angle);

        $array = Convert::toArray($angle);

        [$this->degrees, $this->minutes, $this->seconds] = $array;

        $this->array = [
            'direction' => $this->negative ? '-' : '+',
            'degrees' => intval($this->degrees),
            'minutes' => intval($this->minutes),
            'seconds' => $this->getSeconds(),
        ];
    }

    final public function isNegative(): bool
    {
        return $this->negative;
    }

    final public function getDegrees(?int $decimalPlaces = null): float
    {
        return Value::toFloat($this->degrees, $decimalPlaces);
    }

    final public function getMinutes(?int $decimalPlaces = null): float
    {
        return Value::toFloat($this->minutes, $decimalPlaces);
    }

    final public function getSeconds(?int $decimalPlaces = null): float
    {
        return Value::toFloat($this->seconds, $decimalPlaces);
    }

    final public function toDecimal(?int $decimalPlaces = null): float
    {
        return Value::toFloat($this->angle, $decimalPlaces);
    }

    final public function toRawDecimal(): string
    {
        return $this->angle;
    }

    final public function toArray(): array
    {
        return $this->array;
    }

    abstract public function toString(): string;

    final public function __toString(): string
    {
        return $this->toString();
    }
}
