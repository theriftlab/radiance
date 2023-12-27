<?php

namespace RiftLab\Radiance\Contracts;

interface DiffInterface extends RadianceInterface
{
    public function getFrom(): AngleInterface;

    public function getTo(): AngleInterface;
}
