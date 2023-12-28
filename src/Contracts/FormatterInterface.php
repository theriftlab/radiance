<?php

namespace RiftLab\Radiance\Contracts;

interface FormatterInterface
{
    public static function getFormat(): string;

    public static function format(RadianceInterface $instance): string;
}
