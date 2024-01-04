<?php

namespace RiftLab\Radiance\Contracts;

interface AngleInterface extends RadianceInterface, FormattedInterface
{
    public function getFormatPlaceholdersFor(RadianceInterface $instance): array;

    public static function make(float | string $angle): AngleInterface;

    public function add(AngleInterface | float $angle): AngleInterface;

    public function sub(AngleInterface | float $angle): AngleInterface;

    public function distanceTo(AngleInterface | float $angle): RadianceInterface;

    public function distanceFrom(AngleInterface | float $angle): RadianceInterface;

    public function midpointWith(AngleInterface | float $angle): AngleInterface;
}
