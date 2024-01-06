<?php

namespace RiftLab\Radiance\Services;

final class Value
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
        $floatValue = floatval($value);
        $float = $decimalPlaces < 0 ? floor($floatValue) : round($floatValue, $decimalPlaces ?? Precision::forFloat());

        if ($float === 0.0 && static::isNegative($value)) {
            $float = 0.0;
        }

        return $float;
    }
}
