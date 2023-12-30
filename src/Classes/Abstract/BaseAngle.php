<?php

namespace RiftLab\Radiance\Classes\Abstract;

use RiftLab\Radiance\Classes\Exceptions\BoundaryException;
use RiftLab\Radiance\Classes\Internal\Diff;
use RiftLab\Radiance\Contracts\AngleInterface;
use RiftLab\Radiance\Contracts\DiffInterface;
use RiftLab\Radiance\Contracts\RadianceInterface;
use RiftLab\Radiance\Enum\Limit;
use RiftLab\Radiance\Services\Calculate;

abstract class BaseAngle extends Radiance implements AngleInterface
{
    protected static Limit $limit;

    protected static bool $normalize;

    protected static string $defaultFormat;

    protected static function formatPlaceholders(RadianceInterface $instance): array
    {
        return [];
    }

    public static function make(float | string $angle): AngleInterface
    {
        $decimalAngle = Calculate::decimalFrom($angle);
        $angle = static::safeNormalize($decimalAngle);

        return new static($angle);
    }

    public function getDefaultFormat(): string
    {
        return static::$defaultFormat;
    }

    public function getFormatPlaceholders(): array
    {
        return static::formatPlaceholders($this);
    }

    public function getFormatPlaceholdersFor(RadianceInterface $instance): array
    {
        return static::formatPlaceholders($instance);
    }

    public function add(AngleInterface | float $angle): AngleInterface
    {
        return static::make(Calculate::add($this->toDecimal(), $this->getDecimalFrom($angle), static::$normalize));
    }

    public function sub(AngleInterface | float $angle): AngleInterface
    {
        return static::make(Calculate::sub($this->toDecimal(), $this->getDecimalFrom($angle), static::$normalize));
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
        return static::make(Calculate::midpoint($this->toDecimal(), $this->getDecimalFrom($angle)));
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
        if (abs($angle) > static::$limit->value) {
            if (! static::$normalize) {
                static::boundaryError($angle);
            }

            return Calculate::normalize($angle, static::$limit->value);
        }

        return $angle;
    }

    protected static function boundaryError(float $angle): void
    {
        throw new BoundaryException($angle);
    }
}
