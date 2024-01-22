<?php

namespace RiftLab\Radiance;

use RiftLab\Radiance\Classes\Abstract\BaseAngle;
use RiftLab\Radiance\Classes\Exceptions\LongitudeBoundaryError;
use RiftLab\Radiance\Concerns\Formatted;
use RiftLab\Radiance\Contracts\AngleInterface;
use RiftLab\Radiance\Contracts\RadianceInterface;
use RiftLab\Radiance\Enum\Limit;

class Longitude extends BaseAngle implements AngleInterface
{
    use Formatted;

    protected static Limit $limit = Limit::SEMICIRCLE;

    protected static bool $normalize = false;

    protected static string $defaultFormat = '{d.-1}{D}{m.2f}';

    protected static function formatPlaceholders(RadianceInterface $instance): array
    {
        return [
            '/\{D\}/' => fn() => $instance->isNegative() ? 'w' : 'e',
            '/\{DD\}/' => fn() => $instance->isNegative() ? 'W' : 'E',
        ];
    }

    protected static function throwBoundaryError(float $angle): void
    {
        throw new LongitudeBoundaryError($angle);
    }
}
