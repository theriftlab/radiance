<?php

namespace RiftLab\Radiance\Services;

class Calculate
{
    public static function exceedsLimit(string $angle, int $limit): bool
    {
        return bccomp(Value::abs($angle), (string)$limit, Precision::forString()) === 1;
    }

    public static function add(string $angle1, string $angle2, bool $normalize): string
    {
        $sum = bcadd($angle1, $angle2, Precision::forString());

        return $normalize ? static::normalizeTo($sum) : $sum;
    }

    public static function sub(string $angle1, string $angle2, bool $normalize): string
    {
        $difference = bcsub($angle1, $angle2, Precision::forString());

        return $normalize ? static::normalizeTo($difference) : $difference;
    }

    public static function distanceBetween(string $angle1, string $angle2): string
    {
        $clockwise = static::normalizeTo(bcadd(bcsub($angle2, $angle1, Precision::forString()), '360', Precision::forString()));
        $counterClockwise = static::normalizeTo(bcadd(bcsub($angle1, $angle2, Precision::forString()), '360', Precision::forString()));

        return bccomp($clockwise, $counterClockwise, Precision::forString()) > 0 ? bcmul($counterClockwise, '-1', Precision::forString()) : $clockwise;
    }

    public static function midpointBetween(string $angle1, string $angle2): string
    {
        $distance = static::distanceBetween($angle1, $angle2);
        $addTo = Value::isNegative($distance) && bccomp($distance, '180', Precision::forString()) !== 0 ? $angle2 : $angle1;

        return static::normalizeTo(bcadd($addTo, bcdiv(Value::abs($distance), '2', Precision::forString()), Precision::forString()));
    }

    public static function normalizeTo(string $angle, int $size = 360): string
    {
        return bcmod($angle, $size, Precision::forString());
    }
}
