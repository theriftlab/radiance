<?php

namespace RiftLab\Radiance\Services;

class Calculate
{
    protected static int $precision = 20;

    public static function setPrecision(int $precision): void
    {
        static::$precision = $precision;
    }

    public static function add(float $angle1, float $angle2, bool $normalize): float
    {
        $sum = bcadd($angle1, $angle2, static::$precision+1);

        return $normalize ? static::normalize($sum) : round($sum, static::$precision);
    }

    public static function sub(float $angle1, float $angle2, bool $normalize): float
    {
        $difference = bcsub($angle1, $angle2, static::$precision+1);

        return $normalize ? static::normalize($difference) : round($difference, static::$precision);
    }

    public static function distance(float $angle1, float $angle2): float
    {
        $clockwise = static::normalize(bcadd(bcsub($angle2, $angle1, static::$precision+1), 360, static::$precision+1));
        $counterClockwise = static::normalize(bcadd(bcsub($angle1, $angle2, static::$precision+1), 360, static::$precision+1));
        $distance = round(min($clockwise, $counterClockwise), static::$precision);

        return $clockwise > $counterClockwise ? -$distance : $distance;
    }

    public static function midpoint(float $angle1, float $angle2): float
    {
        $distance = static::distance($angle1, $angle2);

        return static::normalize(bcadd(($distance < 0 && $distance !== 180.0 ? $angle2 : $angle1), bcdiv(abs($distance), 2, static::$precision+1), static::$precision+1));
    }

    public static function normalize(float $angle, int $size = 360): float
    {
        return round(bcmod($angle, $size, static::$precision+1), static::$precision);
    }

    public static function decimalFrom(float | string $angle): float
    {
        if (is_numeric($angle)) {
            $decimalAngle = floatval($angle);
        } else {
            $values = array_values(array_pad(array_filter(mb_split('([^0-9\.-])', $angle), 'strlen'), 3, 0.0));

            $decimalAngle = array_sum(array_map(
                    fn ($value, $index) => round(bcdiv(abs($value), bcpow(60, $index), static::$precision+1), static::$precision),
                    $values,
                    array_keys($values)
                ));

            if ($values[0] < 0 || preg_match('/s|w/i', $angle) > 0) {
                $decimalAngle *= -1;
            }
        }

        return $decimalAngle;
    }

    public static function arrayFrom(float $angle): array
    {
        $arrayAngle = [abs($angle), 0.0, 0.0];

        foreach ([1, 2] as $i) {
            $arrayAngle[$i] = round(bcmul(bcsub($arrayAngle[$i-1], intval($arrayAngle[$i-1]), static::$precision), 60, static::$precision+1), static::$precision);
        }

        return $arrayAngle;
    }
}
