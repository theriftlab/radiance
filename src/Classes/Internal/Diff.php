<?php

namespace RiftLab\Radiance\Classes\Internal;

use RiftLab\Radiance\Concerns\IsAngle;
use RiftLab\Radiance\Classes\Abstract\Radiance;
use RiftLab\Radiance\Contracts\AngleInterface;
use RiftLab\Radiance\Contracts\DiffInterface;
use RiftLab\Radiance\Services\Calculate;

class Diff extends Radiance implements DiffInterface
{
    use IsAngle;

    public function __construct(
        protected AngleInterface $from,
        protected AngleInterface $to,
    )
    {
        parent::__construct(Calculate::distance($from->toDecimal(), $to->toDecimal()));
    }

    public function getFrom(): AngleInterface
    {
        return $this->from;
    }

    public function getTo(): AngleInterface
    {
        return $this->to;
    }
}
