<?php

namespace RiftLab\Radiance;

use RiftLab\Radiance\Classes\Abstract\BaseAngle;
use RiftLab\Radiance\Concerns\AngleFormat;
use RiftLab\Radiance\Contracts\AngleInterface;
use RiftLab\Radiance\Enum\Limit;
use RiftLab\Radiance\Services\Calculate;

class Angle extends BaseAngle implements AngleInterface
{
    use AngleFormat;

    protected static function getLimit(): Limit
    {
        return Limit::CIRCLE;
    }

    protected static function getNormalize(): bool
    {
        return true;
    }

    public function normalizeTo(int $size): Angle
    {
        return new static(Calculate::normalize($this->toDecimal(), $size));
    }
}
