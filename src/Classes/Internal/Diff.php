<?php

namespace RiftLab\Radiance\Classes\Internal;

use RiftLab\Radiance\Classes\Abstract\Radiance;
use RiftLab\Radiance\Contracts\AngleInterface;
use RiftLab\Radiance\Contracts\DiffInterface;
use RiftLab\Radiance\Services\Calculate;

class Diff extends Radiance implements DiffInterface
{
    public function __construct(
        protected AngleInterface $from,
        protected AngleInterface $to,
    )
    {
        static::$formatter = $from->getFormatter();
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
