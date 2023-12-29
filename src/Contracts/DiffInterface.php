<?php

namespace RiftLab\Radiance\Contracts;

interface DiffInterface extends RadianceInterface, FormattedInterface
{
    public function getFrom(): AngleInterface;

    public function getTo(): AngleInterface;
}
