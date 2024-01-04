<?php

namespace RiftLab\Radiance\Classes\Internal;

use RiftLab\Radiance\Classes\Abstract\Radiance;
use RiftLab\Radiance\Concerns\Formatted;
use RiftLab\Radiance\Contracts\AngleInterface;
use RiftLab\Radiance\Contracts\FormattedInterface;
use RiftLab\Radiance\Contracts\RadianceInterface;
use RiftLab\Radiance\Services\Calculate;

final class Diff extends Radiance implements RadianceInterface, FormattedInterface
{
    use Formatted;

    public function __construct(
        private AngleInterface $from,
        AngleInterface $to,
    )
    {
        parent::__construct(Calculate::distanceBetween($from->toRawDecimal(), $to->toRawDecimal()));
    }

    public function getDefaultFormat(): string
    {
        return $this->from->getDefaultFormat();
    }

    public function getFormatPlaceholders(): array
    {
        return $this->from->getFormatPlaceholdersFor($this);
    }
}
