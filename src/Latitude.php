<?php

namespace RiftLab\Radiance;

use RiftLab\Radiance\Concerns\IsCoordinate;
use RiftLab\Radiance\Classes\Abstract\BaseAngle;
use RiftLab\Radiance\Classes\Exceptions\LatitudeBoundaryException;
use RiftLab\Radiance\Contracts\AngleInterface;
use RiftLab\Radiance\Enum\Limit;

class Latitude extends BaseAngle implements AngleInterface
{
    use IsCoordinate;

    protected static string $boundaryExceptionClass = LatitudeBoundaryException::class;

    protected static function getLimit(): Limit
    {
        return Limit::QUADRANT;
    }

    protected static function getNegativeDirection(): string
    {
        return 's';
    }

    protected static function getPositiveDirection(): string
    {
        return 'n';
    }
}
