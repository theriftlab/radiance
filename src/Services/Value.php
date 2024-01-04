<?php

namespace RiftLab\Radiance\Services;

class Value
{
    public static function isNegative(string $value): bool
    {
        return $value[0] === '-';
    }

    public static function abs(string $value): string
    {
        return ltrim($value, '-');
    }

    public static function toFloat(string $value, ?int $decimalPlaces): float
    {
        $value = round(floatval($value), Precision::forFloat());

        if (is_null($decimalPlaces)) {
            return $value;
        }

        return $decimalPlaces < 0 ? floor($value) : round($value, $decimalPlaces);
    }
}
