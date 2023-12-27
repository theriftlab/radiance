<?php

namespace RiftLab\Radiance;

use RiftLab\Radiance\Concerns\IsAngle;
use RiftLab\Radiance\Classes\Abstract\BaseAngle;
use RiftLab\Radiance\Contracts\AngleInterface;
use RiftLab\Radiance\Services\Calculate;

class Angle extends BaseAngle implements AngleInterface
{
    use IsAngle;

    public function normalizeTo(int $size): Angle
    {
        return new self(Calculate::normalize($this->toDecimal(), $size));
    }
}
