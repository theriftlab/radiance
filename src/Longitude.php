<?php

namespace RiftLab\Radiance;

use RiftLab\Radiance\Classes\Abstract\BaseAngle;
use RiftLab\Radiance\Classes\Exceptions\LongitudeBoundaryException;
use RiftLab\Radiance\Concerns\Formatted;
use RiftLab\Radiance\Contracts\AngleInterface;
use RiftLab\Radiance\Enum\Limit;

class Longitude extends BaseAngle implements AngleInterface
{
    use Formatted;

    protected static Limit $limit = Limit::SEMICIRCLE;

    protected static bool $normalize = false;

    protected static string $defaultFormat = '{d.-1}{D}{m.2}';

    public function getFormatPlaceholders(): array
    {
        return [
            '/\{D\}/' => fn () => $this->isNegative() ? 'w' : 'e',
            '/\{DD\}/' => fn () => $this->isNegative() ? 'W' : 'E',
        ];
    }

    protected static function boundaryError(float $angle): void
    {
        throw new LongitudeBoundaryException($angle);
    }
}
