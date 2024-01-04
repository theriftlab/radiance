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

    public static function make(float | string $angle): AngleInterface
    {
        $decimalAngle = Convert::toRawDecimal($angle);
        $normalized = static::safeNormalize($decimalAngle);

        return new static($normalized);
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
        return static::make(Calculate::add($this->toRawDecimal(), static::getRawDecimalFrom($angle), static::$normalize));
    }

    public function sub(AngleInterface | float $angle): AngleInterface
    {
        return static::make(Calculate::sub($this->toRawDecimal(), static::getRawDecimalFrom($angle), static::$normalize));
    }

    public function distanceTo(AngleInterface | float $angle): DiffInterface
    {
        return new Diff($this, static::getAngleFrom($angle));
    }

    public function distanceFrom(AngleInterface | float $angle): DiffInterface
    {
        return new Diff(static::getAngleFrom($angle), $this);
    }

    public function midpointWith(AngleInterface | float $angle): AngleInterface
    {
        return static::make(Calculate::midpointBetween($this->toRawDecimal(), static::getRawDecimalFrom($angle)));
    }

    protected static function getRawDecimalFrom(AngleInterface | float $angle): string
    {
        return static::safeNormalize($angle instanceof AngleInterface ? $angle->toRawDecimal() : $angle);
    }

    protected static function getAngleFrom(AngleInterface | float $angle): AngleInterface
    {
        return $angle instanceof AngleInterface ? $angle : static::make($angle);
    }

    protected static function safeNormalize(float | string $angle): string
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
