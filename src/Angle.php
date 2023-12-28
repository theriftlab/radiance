<?php

namespace RiftLab\Radiance;

use RiftLab\Radiance\Classes\Abstract\BaseAngle;
use RiftLab\Radiance\Classes\Formatters\AngleFormatter;
use RiftLab\Radiance\Contracts\AngleInterface;
use RiftLab\Radiance\Enum\Limit;
use RiftLab\Radiance\Services\Calculate;

class Angle extends BaseAngle implements AngleInterface
{
    protected static Limit $limit = Limit::CIRCLE;

    protected static bool $normalize = true;

    protected static string $formatter = AngleFormatter::class;

    public function normalizeTo(int $size): Angle
    {
        return new static(Calculate::normalize($this->toDecimal(), $size));
    }
}
