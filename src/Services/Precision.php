<?php

namespace RiftLab\Radiance\Services;

final class Precision
{
    private static int $string = 30;

    private static int $float = 8;

    public static function setForString(int $precision): void
    {
        static::$string = $precision;
    }

    public static function setForFloat(int $precision): void
    {
        static::$float = $precision;
    }

    public static function forString(): int
    {
        return static::$string;
    }

    public static function forFloat(): int
    {
        return static::$float;
    }
}
