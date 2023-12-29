<?php

namespace RiftLab\Radiance\Classes\Internal;

use RiftLab\Radiance\Classes\Abstract\Radiance;
use RiftLab\Radiance\Concerns\Formatted;
use RiftLab\Radiance\Contracts\AngleInterface;
use RiftLab\Radiance\Contracts\DiffInterface;
use RiftLab\Radiance\Contracts\RadianceInterface;
use RiftLab\Radiance\Services\Calculate;

class Diff extends Radiance implements DiffInterface
{
    use Formatted;

    public function __construct(
        protected AngleInterface $from,
        protected AngleInterface $to,
    )
    {
        parent::__construct(Calculate::distance($from->toDecimal(), $to->toDecimal()));
    }

    public function getDefaultFormat(): string
    {
        return $this->from->getDefaultFormat();
    }

    public function getFormatPlaceholders(RadianceInterface $instance): array
    {
        return $this->from->getFormatPlaceholders($instance);
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
