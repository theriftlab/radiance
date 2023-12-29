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

    protected function __construct(protected float $angle)
    {
        $this->negative = $this->angle < 0;

        $array = Calculate::arrayFrom($this->angle);

        [$this->degrees, $this->minutes, $this->seconds] = $array;

        $this->array = [
            'direction' => $this->isNegative() ? '-' : '+',
            ...array_combine(['degrees', 'minutes', 'seconds'], $array),
        ];
    }

    public function isNegative(): bool
    {
        return $this->negative;
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
