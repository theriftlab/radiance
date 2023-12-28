<?php

namespace RiftLab\Radiance\Classes\Abstract;

use RiftLab\Radiance\Contracts\FormatterInterface;
use RiftLab\Radiance\Contracts\RadianceInterface;

abstract class BaseFormatter implements FormatterInterface
{
    protected static string $format;

    public static function getFormat(): string
    {
        return static::$format;
    }

    public static function format(RadianceInterface $instance, string $format = null): string
    {
        $format = $format ?? static::getFormat();

        return preg_replace_callback_array(static::getMergedStringFormatPlaceholders($instance), $format);
    }

    protected static function getStringFormatPlaceholders(RadianceInterface $instance): array
    {
        return [];
    }

    protected static function getMergedStringFormatPlaceholders(RadianceInterface $instance): array
    {
        return [
            '/\{d\.(-?\d+)\}/' => fn ($match) => static::formatValue($instance->getDegrees($match[1]), $match[1], false),
            '/\{m\.(-?\d+)\}/' => fn ($match) => static::formatValue($instance->getMinutes($match[1]), $match[1], false),
            '/\{s\.(-?\d+)\}/' => fn ($match) => static::formatValue($instance->getSeconds($match[1]), $match[1], false),

            '/\{dd\.(-?\d+)\}/' => fn ($match) => static::formatValue($instance->getDegrees($match[1]), $match[1], true),
            '/\{mm\.(-?\d+)\}/' => fn ($match) => static::formatValue($instance->getMinutes($match[1]), $match[1], true),
            '/\{ss\.(-?\d+)\}/' => fn ($match) => static::formatValue($instance->getSeconds($match[1]), $match[1], true),

            ...static::getStringFormatPlaceholders($instance),
        ];
    }

    protected static function formatValue(float $value, int $decimalPoints, bool $leadingZero): string
    {
        $value = number_format($value, $decimalPoints);

        return $leadingZero && $value < 10 ? "0$value" : $value;
    }
}
