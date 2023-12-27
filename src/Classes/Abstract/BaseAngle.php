<?php

namespace RiftLab\Radiance\Classes\Abstract;

use RiftLab\Radiance\Classes\Exceptions\AngleBoundaryException;
use RiftLab\Radiance\Classes\Internal\Diff;
use RiftLab\Radiance\Contracts\AngleInterface;
use RiftLab\Radiance\Contracts\DiffInterface;
use RiftLab\Radiance\Enum\Limit;
use RiftLab\Radiance\Services\Calculate;

abstract class BaseAngle extends Radiance implements AngleInterface
{
    protected static string $boundaryExceptionClass = AngleBoundaryException::class;

    abstract protected static function getLimit(): Limit;

    abstract protected static function getNormalize(): bool;

    public static function make(float | string $angle): AngleInterface
    {
        $decimalAngle = Calculate::decimalFrom($angle);
        $angle = static::safeNormalize($decimalAngle);

        return new static($angle);
    }

    public function add(AngleInterface | float $angle): AngleInterface
    {
        return new static(Calculate::add($this->toDecimal(), $this->getDecimalFrom($angle), static::getNormalize()));
    }

    public function sub(AngleInterface | float $angle): AngleInterface
    {
        return new static(Calculate::sub($this->toDecimal(), $this->getDecimalFrom($angle), static::getNormalize()));
    }

    public function distanceTo(AngleInterface | float $angle): DiffInterface
    {
        return new Diff($this, $this->getAngleFrom($angle));
    }

    public function distanceFrom(AngleInterface | float $angle): DiffInterface
    {
        return new Diff($this->getAngleFrom($angle), $this);
    }

    public function midpointWith(AngleInterface | float $angle): AngleInterface
    {
        return new static(Calculate::midpoint($this->toDecimal(), $this->getDecimalFrom($angle)));
    }

    protected function getDecimalFrom(AngleInterface | float $angle): float
    {
        return static::safeNormalize($angle instanceof AngleInterface ? $angle->toDecimal() : $angle);
    }

    protected function getAngleFrom(AngleInterface | float $angle): AngleInterface
    {
        return $angle instanceof AngleInterface ? $angle : static::make($angle);
    }

    protected static function safeNormalize(float $angle): float
    {
        if (abs($angle) > static::getLimit()->value) {
            if (! static::getNormalize()) {
                throw new static::$boundaryExceptionClass($angle, static::getLimit());
            }

            return Calculate::normalize($angle, static::getLimit()->value);
        }

        return $angle;
    }
}
