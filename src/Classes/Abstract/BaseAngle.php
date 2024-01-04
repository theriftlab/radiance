<?php

namespace RiftLab\Radiance\Classes\Abstract;

use RiftLab\Radiance\Classes\Exceptions\BoundaryError;
use RiftLab\Radiance\Classes\Internal\Diff;
use RiftLab\Radiance\Contracts\AngleInterface;
use RiftLab\Radiance\Contracts\DiffInterface;
use RiftLab\Radiance\Contracts\RadianceInterface;
use RiftLab\Radiance\Enum\Limit;
use RiftLab\Radiance\Services\Calculate;
use RiftLab\Radiance\Services\Convert;

abstract class BaseAngle extends Radiance implements AngleInterface
{
    protected static Limit $limit;

    protected static bool $normalize;

    protected static string $defaultFormat;

    protected static function formatPlaceholders(RadianceInterface $instance): array
    {
        return [];
    }

    final public static function make(float | string $angle): AngleInterface
    {
        $decimalAngle = Convert::toRawDecimal($angle);
        $normalized = static::safeNormalize($decimalAngle);

        return new static($normalized);
    }

    final public function getDefaultFormat(): string
    {
        return static::$defaultFormat;
    }

    final public function getFormatPlaceholders(): array
    {
        return static::formatPlaceholders($this);
    }

    final public function getFormatPlaceholdersFor(RadianceInterface $instance): array
    {
        return static::formatPlaceholders($instance);
    }

    final public function add(AngleInterface | float $angle): AngleInterface
    {
        return static::make(Calculate::add($this->toRawDecimal(), static::getRawDecimalFrom($angle), static::$normalize));
    }

    final public function sub(AngleInterface | float $angle): AngleInterface
    {
        return static::make(Calculate::sub($this->toRawDecimal(), static::getRawDecimalFrom($angle), static::$normalize));
    }

    final public function distanceTo(AngleInterface | float $angle): DiffInterface
    {
        return new Diff($this, static::getAngleFrom($angle));
    }

    final public function distanceFrom(AngleInterface | float $angle): DiffInterface
    {
        return new Diff(static::getAngleFrom($angle), $this);
    }

    final public function midpointWith(AngleInterface | float $angle): AngleInterface
    {
        return static::make(Calculate::midpointBetween($this->toRawDecimal(), static::getRawDecimalFrom($angle)));
    }

    private static function getRawDecimalFrom(AngleInterface | float $angle): string
    {
        return static::safeNormalize($angle instanceof AngleInterface ? $angle->toRawDecimal() : $angle);
    }

    private static function getAngleFrom(AngleInterface | float $angle): AngleInterface
    {
        return $angle instanceof AngleInterface ? $angle : static::make($angle);
    }

    private static function safeNormalize(float | string $angle): string
    {
        $stringAngle = (string)$angle;

        if (Calculate::exceedsLimit($stringAngle, static::$limit->value)) {
            if (! static::$normalize) {
                static::boundaryError(floatval($angle));
            }

            return Calculate::normalizeTo($stringAngle, static::$limit->value);
        }

        return $stringAngle;
    }

    protected static function boundaryError(float $angle): void
    {
        throw new BoundaryError($angle);
    }
}
