<?php

namespace RiftLab\Radiance\Services;

class Calculate
{
    protected static int $precision = 30;

    protected static int $floatPrecision = 8;

    public static function isNegative(string $angle): bool
    {
        return bccomp($angle, '0', static::$precision) === -1;
    }

    public static function abs(string $angle): string
    {
        return static::isNegative($angle) ? bcmul($angle, '-1', static::$precision) : $angle;
    }

    public static function exceeds(string $angle, int $limit): bool
    {
        return bccomp(static::abs($angle), (string)$limit, static::$precision) === 1;
    }

    public static function toFloat(string $value, ?int $decimalPlaces): float
    {
        $value = round($value, static::$floatPrecision);

        if (is_null($decimalPlaces)) {
            return $value;
        }

        return $decimalPlaces < 0 ? floor($value) : round($value, $decimalPlaces);
    }

    public static function add(string $angle1, string $angle2, bool $normalize): string
    {
        $sum = bcadd($angle1, $angle2, static::$precision);

        return $normalize ? static::normalize($sum) : $sum;
    }

    public static function sub(string $angle1, string $angle2, bool $normalize): string
    {
        $difference = bcsub($angle1, $angle2, static::$precision);

        return $normalize ? static::normalize($difference) : $difference;
    }

    public static function distance(string $angle1, string $angle2): string
    {
        $clockwise = static::normalize(bcadd(bcsub($angle2, $angle1, static::$precision), '360', static::$precision));
        $counterClockwise = static::normalize(bcadd(bcsub($angle1, $angle2, static::$precision), '360', static::$precision));

        return bccomp($clockwise, $counterClockwise, static::$precision) > 0 ? bcmul($counterClockwise, '-1', static::$precision) : $clockwise;
    }

    public static function midpoint(string $angle1, string $angle2): string
    {
        $distance = static::distance($angle1, $angle2);
        $addTo = static::isNegative($distance) && bccomp($distance, '180', static::$precision) !== 0 ? $angle2 : $angle1;

        return static::normalize(bcadd($addTo, bcdiv(static::abs($distance), '2', static::$precision), static::$precision));
    }

    public static function normalize(string $angle, int $size = 360): string
    {
        return bcmod($angle, $size, static::$precision);
    }

    public static function decimalFrom(float | string $angle): string
    {
        if (is_numeric($angle)) {
            return (string)$angle;
        }

        $values = array_values(array_pad(array_filter(mb_split('([^0-9\.-])', $angle), 'strlen'), 3, 0.0));

        $arrayAngle = array_map(
            fn ($value, $index) => bcdiv(abs($value), bcpow('60', $index), static::$precision),
            $values,
            array_keys($values),
        );

        $decimalAngle = array_reduce($arrayAngle, fn ($carry, $item) => bcadd($carry, $item, static::$precision), 0);

        if ($values[0] < 0 || preg_match('/s|w/i', $angle) > 0) {
            $decimalAngle = bcmul($decimalAngle, '-1', static::$precision);
        }

        return $decimalAngle;
    }

    public static function arrayFrom(string $angle): array
    {
        $arrayAngle = [static::abs($angle), 0.0, 0.0];

        foreach ([1, 2] as $i) {
            $arrayAngle[$i] = bcmul(bcsub($arrayAngle[$i-1], intval($arrayAngle[$i-1]), static::$precision), '60', static::$precision);
        }

        return $arrayAngle;
    }
}
