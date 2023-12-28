<?php

namespace RiftLab\Radiance;

use RiftLab\Radiance\Classes\Abstract\BaseAngle;
use RiftLab\Radiance\Classes\Exceptions\LatitudeBoundaryException;
use RiftLab\Radiance\Classes\Formatters\LatitudeFormatter;
use RiftLab\Radiance\Contracts\AngleInterface;
use RiftLab\Radiance\Enum\Limit;

class Latitude extends BaseAngle implements AngleInterface
{
    protected static Limit $limit = Limit::QUADRANT;

    protected static bool $normalize = false;

    protected static string $boundaryExceptionClass = LatitudeBoundaryException::class;

    protected static string $formatter = LatitudeFormatter::class;
}
