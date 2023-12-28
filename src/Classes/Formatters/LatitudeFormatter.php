<?php

namespace RiftLab\Radiance\Classes\Formatters;

use RiftLab\Radiance\Classes\Abstract\BaseFormatter;
use RiftLab\Radiance\Contracts\RadianceInterface;

abstract class LatitudeFormatter extends BaseFormatter
{
    protected static string $format = '{d.-1}{D}{m.2}';

    protected static string $negativeDirection = 's';

    protected static string $positiveDirection = 'n';

    protected static function getStringFormatPlaceholders(RadianceInterface $instance): array
    {
        return [
            '/\{D\}/' => fn () => $instance->getDirection(),
            '/\{DD\}/' => fn () => strtoupper($instance->getDirection()),
        ];
    }
}
