<?php

namespace RiftLab\Radiance\Classes\Formatters;

use RiftLab\Radiance\Classes\Abstract\BaseFormatter;
use RiftLab\Radiance\Contracts\RadianceInterface;

class AngleFormatter extends BaseFormatter
{
    protected static string $format = '{D}{dd.-1}°{mm.-1}\'{ss.0}"';

    protected static string $negativeDirection = '-';

    protected static string $positiveDirection = '+';

    protected static function getStringFormatPlaceholders(RadianceInterface $instance): array
    {
        return [
            '/\{D\}/' => fn () => $instance->isNegative() ? $instance->getDirection() : '',
            '/\{DD\}/' => fn () => $instance->getDirection(),
        ];
    }
}
