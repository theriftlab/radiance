<?php

namespace RiftLab\Radiance;

use RiftLab\Radiance\Classes\Abstract\BaseAngle;
use RiftLab\Radiance\Classes\Exceptions\LongitudeBoundaryException;
use RiftLab\Radiance\Classes\Formatters\LongitudeFormatter;
use RiftLab\Radiance\Contracts\AngleInterface;
use RiftLab\Radiance\Enum\Limit;

class Longitude extends BaseAngle implements AngleInterface
{
    protected static Limit $limit = Limit::SEMICIRCLE;

    protected static bool $normalize = false;

    protected static string $boundaryExceptionClass = LongitudeBoundaryException::class;

    protected static string $formatter = LongitudeFormatter::class;
}
