<?php

namespace RiftLab\Radiance\Contracts;

interface FormattedInterface
{
    public function getDefaultFormat(): string;

    public function getFormatPlaceholders(RadianceInterface $instance): array;

    public function toString(): string;
}
