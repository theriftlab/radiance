<?php

namespace RiftLab\Radiance;

use RiftLab\Radiance\Concerns\IsCoordinate;
use RiftLab\Radiance\Classes\Abstract\BaseAngle;
use RiftLab\Radiance\Classes\Exceptions\LongitudeBoundaryException;
use RiftLab\Radiance\Contracts\AngleInterface;
use RiftLab\Radiance\Enum\Limit;

class Longitude extends BaseAngle implements AngleInterface
{
    use IsCoordinate;

    protected static string $boundaryExceptionClass = LongitudeBoundaryException::class;

    protected static function getLimit(): Limit
    {
        return Limit::SEMICIRCLE;
    }

    protected static function getNegativeDirection(): string
    {
        return 'w';
    }

    protected static function getPositiveDirection(): string
    {
        return 'e';
    }
}
