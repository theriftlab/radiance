<?php

namespace RiftLab\Radiance\Classes\Abstract;

use RiftLab\Radiance\Contracts\RadianceInterface;
use RiftLab\Radiance\Services\Convert;
use RiftLab\Radiance\Services\Precision;
use RiftLab\Radiance\Services\Value;

abstract class Radiance implements RadianceInterface
{
    protected bool $negative;

    protected string $degrees;

    protected string $minutes;

    protected string $seconds;

    protected array $array;

    protected function __construct(protected string $angle)
    {
        $this->negative = Value::isNegative($angle);

        $array = Convert::toArray($angle);

        [$this->degrees, $this->minutes, $this->seconds] = $array;

        $this->array = [
            'direction' => $this->negative ? '-' : '+',
            'degrees' => intval($this->degrees),
            'minutes' => intval($this->minutes),
            'seconds' => round($this->seconds, Precision::forFloat()),
        ];
    }

    public function isNegative(): bool
    {
        return $this->negative;
    }

    public function getDegrees(?int $decimalPlaces = null): float
    {
        return Value::toFloat($this->degrees, $decimalPlaces);
    }

    public function getMinutes(?int $decimalPlaces = null): float
    {
        return Value::toFloat($this->minutes, $decimalPlaces);
    }

    public function getSeconds(?int $decimalPlaces = null): float
    {
        return Value::toFloat($this->seconds, $decimalPlaces);
    }

    public function toDecimal(?int $decimalPlaces = null): float
    {
        return Value::toFloat($this->angle, $decimalPlaces);
    }

    public function toRawDecimal(): string
    {
        return $this->angle;
    }

    public function toArray(): array
    {
        return $this->array;
    }

    abstract public function toString(): string;

    public function __toString(): string
    {
        return $this->toString();
    }
}
