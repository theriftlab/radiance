<?php

namespace RiftLab\Radiance;

use RiftLab\Radiance\Classes\Abstract\BaseAngle;
use RiftLab\Radiance\Classes\Exceptions\LatitudeBoundaryException;
use RiftLab\Radiance\Concerns\Formatted;
use RiftLab\Radiance\Contracts\AngleInterface;
use RiftLab\Radiance\Contracts\RadianceInterface;
use RiftLab\Radiance\Enum\Limit;

class Latitude extends BaseAngle implements AngleInterface
{
    use Formatted;

    protected static Limit $limit = Limit::QUADRANT;

    protected static bool $normalize = false;

    protected static string $defaultFormat = '{d.-1}{D}{m.2}';

    protected static function formatPlaceholders(RadianceInterface $instance): array
    {
        return [
            '/\{D\}/' => fn () => $instance->isNegative() ? 's' : 'n',
            '/\{DD\}/' => fn () => $instance->isNegative() ? 'S' : 'N',
        ];
    }

    protected static function boundaryError(float $angle): void
    {
        throw new LatitudeBoundaryException($angle);
    }
}
