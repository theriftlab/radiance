<?php

namespace RiftLab\Radiance;

use RiftLab\Radiance\Classes\Abstract\BaseAngle;
use RiftLab\Radiance\Concerns\CoordinateFormat;
use RiftLab\Radiance\Contracts\AngleInterface;
use RiftLab\Radiance\Enum\Limit;

class Longitude extends BaseAngle implements AngleInterface
{
    use CoordinateFormat;

    protected static function getLimit(): Limit
    {
        return Limit::SEMICIRCLE;
    }

    protected static function getNormalize(): bool
    {
        return false;
    }

    protected static function getDirections(): array
    {
        return [
            'negative' => 'w',
            'positive' => 'e',
        ];
    }
}
