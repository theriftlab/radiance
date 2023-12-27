<?php

namespace RiftLab\Radiance\Contracts;

interface RadianceInterface
{
    public function getDirection(): string;

    public function getDegrees(): float;

    public function getMinutes(): float;

    public function getSeconds(): float;

    public function toDecimal(): float;

    public function toString(): string;

    public function toArray(): array;
}
